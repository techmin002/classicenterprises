<?php

namespace Modules\Inventory\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Modules\Inventory\Entities\DevicePurchase;
use Modules\Inventory\Entities\DevicePurchaseAccessory;
use Modules\Inventory\Entities\DevicePurchaseMachinery;
use Modules\Inventory\Entities\Inventory;
use Modules\Inventory\Entities\Accessories;
use Modules\Inventory\Entities\Machineries;
use Modules\Inventory\Entities\Supplier;
use Modules\Inventory\Entities\Branch;
use Modules\Inventory\Entities\User;

class DevicePurchaseController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        $branches = Branch::all();
        $users = User::all();
        $accessories = Accessories::all();
        $machineries = Machineries::all();
        $devicepurchases = DevicePurchase::with('supplier')->get();
        return view('inventory::DevicePurchase.index', compact('devicepurchases', 'suppliers', 'branches', 'users', 'accessories', 'machineries'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'branch_id' => 'required|exists:branches,id',
            'bill_no' => 'required|string|max:255',
            'total_amount' => 'required|numeric|min:0',
            'receipt' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'status' => 'required|boolean',
            'description' => 'nullable|string',

            'accessories' => 'nullable|array',
            'accessories.*.id' => 'required|exists:accessories,id',
            'accessories.*.quantity' => 'required|integer|min:1',
            'accessories.*.price' => 'required|numeric|min:0',
            'accessories.*.branch_id' => 'required|exists:branches,id',

            'machineries' => 'nullable|array',
            'machineries.*.id' => 'required|exists:machineries,id',
            'machineries.*.quantity' => 'required|integer|min:1',
            'machineries.*.price' => 'required|numeric|min:0',
            'machineries.*.branch_id' => 'required|exists:branches,id',
        ]);

        DB::transaction(function () use ($request) {
            $receiptPath = null;
            if ($request->hasFile('receipt')) {
                $imageName = time() . '.' . $request->receipt->extension();
                $request->receipt->move(public_path('upload/images/receipts'), $imageName);
                $receiptPath = 'upload/images/receipts/' . $imageName;
            }

            $devicePurchase = DevicePurchase::create([
                'supplier_id' => $request->supplier_id,
                'branch_id' => $request->branch_id,
                'bill_no' => $request->bill_no,
                'total_amount' => $request->total_amount,
                'receipt' => $receiptPath,
                'status' => $request->status,
                'description' => $request->description,
                'created_by' => auth()->id(),
            ]);

            // Handle accessories
            if ($request->filled('accessories')) {
                foreach ($request->accessories as $acc) {
                    $total = $acc['quantity'] * $acc['price'];
                    $accessory_purchase = DevicePurchaseAccessory::create([
                        'device_purchase_id' => $devicePurchase->id,
                        'accessory_id' => $acc['id'],
                        'branch_id' => $acc['branch_id'],
                        'quantity' => $acc['quantity'],
                        'unit_price' => $acc['price'],
                        'total' => $total,
                    ]);

                    // Update inventory for accessory
                    $inventory = Inventory::firstOrNew([
                        'accessory_id' => $acc['id'],
                        'branch_id' => $acc['branch_id'],
                        'machinery_id' => null,
                    ]);

                    // Always increase opening_quantity with new purchases
                    $inventory->opening_quantity += $acc['quantity'];
                    
                    // For quantity, add only if inventory exists, otherwise set to purchased quantity
                    if ($inventory->exists) {
                        $inventory->quantity += $acc['quantity'];
                    } else {
                        $inventory->quantity = $acc['quantity'];
                        $inventory->status = true;
                    }

                    $inventory->updated_by = auth()->id();
                    $inventory->save();
                }
            }

            // Handle machineries
            if ($request->filled('machineries')) {
                foreach ($request->machineries as $mach) {
                    $total = $mach['quantity'] * $mach['price'];
                    $machineryPurchase = DevicePurchaseMachinery::create([
                        'device_purchase_id' => $devicePurchase->id,
                        'machinery_id' => $mach['id'],
                        'branch_id' => $mach['branch_id'],
                        'quantity' => $mach['quantity'],
                        'unit_price' => $mach['price'],
                        'total' => $total,
                    ]);

                    // Update inventory for machinery
                    $inventory = Inventory::firstOrNew([
                        'machinery_id' => $mach['id'],
                        'branch_id' => $mach['branch_id'],
                        'accessory_id' => null,
                    ]);

                    // Always increase opening_quantity with new purchases
                    $inventory->opening_quantity += $mach['quantity'];
                    
                    // For quantity, add only if inventory exists, otherwise set to purchased quantity
                    if ($inventory->exists) {
                        $inventory->quantity += $mach['quantity'];
                    } else {
                        $inventory->quantity = $mach['quantity'];
                        $inventory->status = true;
                    }

                    $inventory->updated_by = auth()->id();
                    $inventory->save();
                }
            }
        });

        return back()->with('success', 'Device purchase stored successfully.');
    }

    public function edit(DevicePurchase $devicePurchase)
    {
        $devicePurchase->load('accessories', 'machineries');

        $suppliers = Supplier::all();
        $branches = Branch::all();
        $users = User::all();
        $accessories = Accessories::all();
        $machineries = Machineries::all();
        $purchaseAccessories = DevicePurchaseAccessory::where('device_purchase_id', $devicePurchase->id)->with('accessory')->get();
        $purchaseMachineries = DevicePurchaseMachinery::where('device_purchase_id', $devicePurchase->id)->with('machinery')->get();

        return view('inventory::DevicePurchase.edit', compact(
            'devicePurchase',
            'suppliers',
            'branches',
            'users',
            'accessories',
            'machineries',
            'purchaseAccessories',
            'purchaseMachineries'
        ));
    }

    public function update(Request $request, DevicePurchase $devicePurchase): RedirectResponse
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'branch_id' => 'required|exists:branches,id',
            'bill_no' => 'required|string|max:255',
            'total_amount' => 'required|numeric|min:0',
            'receipt' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'status' => 'required|boolean',
            'description' => 'nullable|string',

            'accessories' => 'nullable|array',
            'accessories.*.id' => 'required|exists:accessories,id',
            'accessories.*.quantity' => 'required|integer|min:1',
            'accessories.*.price' => 'required|numeric|min:0',
            'accessories.*.branch_id' => 'nullable|exists:branches,id',

            'machineries' => 'nullable|array',
            'machineries.*.id' => 'required|exists:machineries,id',
            'machineries.*.quantity' => 'required|integer|min:1',
            'machineries.*.price' => 'required|numeric|min:0',
            'machineries.*.branch_id' => 'nullable|exists:branches,id',
        ]);

        DB::transaction(function () use ($request, $devicePurchase) {
            $receiptPath = $devicePurchase->receipt;
            if ($request->hasFile('receipt')) {
                if ($receiptPath && file_exists(public_path($receiptPath))) {
                    unlink(public_path($receiptPath));
                }

                $imageName = time() . '.' . $request->receipt->extension();
                $request->receipt->move(public_path('upload/images/receipts'), $imageName);
                $receiptPath = 'upload/images/receipts/' . $imageName;
            }

            $devicePurchase->update([
                'supplier_id' => $request->supplier_id,
                'branch_id' => $request->branch_id,
                'bill_no' => $request->bill_no,
                'total_amount' => $request->total_amount,
                'receipt' => $receiptPath,
                'status' => $request->status,
                'description' => $request->description,
            ]);

            // Get current quantities before update for inventory adjustment
            $currentAccessories = DevicePurchaseAccessory::where('device_purchase_id', $devicePurchase->id)
                ->get()
                ->keyBy('accessory_id');

            $currentMachineries = DevicePurchaseMachinery::where('device_purchase_id', $devicePurchase->id)
                ->get()
                ->keyBy('machinery_id');

            // Handle accessories update
            if ($request->filled('accessories')) {
                foreach ($request->accessories as $acc) {
                    $total = $acc['quantity'] * $acc['price'];
                    
                    // Find or create accessory purchase record
                    $accessoryPurchase = DevicePurchaseAccessory::updateOrCreate(
                        [
                            'device_purchase_id' => $devicePurchase->id,
                            'accessory_id' => $acc['id'],
                            'branch_id' => $acc['branch_id'] ?? $devicePurchase->branch_id,
                        ],
                        [
                            'quantity' => $acc['quantity'],
                            'unit_price' => $acc['price'],
                            'total' => $total,
                        ]
                    );

                    // Update inventory
                    $inventory = Inventory::firstOrNew([
                        'accessory_id' => $acc['id'],
                        'branch_id' => $acc['branch_id'] ?? $devicePurchase->branch_id,
                        'machinery_id' => null,
                    ]);

                    // Calculate difference from original purchase
                    $originalQuantity = $currentAccessories[$acc['id']]->quantity ?? 0;
                    $quantityDifference = $acc['quantity'] - $originalQuantity;

                    // Adjust both quantities
                    $inventory->opening_quantity += $quantityDifference;
                    $inventory->quantity += $quantityDifference;

                    if (!$inventory->exists) {
                        $inventory->status = true;
                    }

                    $inventory->updated_by = auth()->id();
                    $inventory->save();
                }
            }

            // Handle machineries update
            if ($request->filled('machineries')) {
                foreach ($request->machineries as $mach) {
                    $total = $mach['quantity'] * $mach['price'];
                    
                    // Find or create machinery purchase record
                    $machineryPurchase = DevicePurchaseMachinery::updateOrCreate(
                        [
                            'device_purchase_id' => $devicePurchase->id,
                            'machinery_id' => $mach['id'],
                            'branch_id' => $mach['branch_id'] ?? $devicePurchase->branch_id,
                        ],
                        [
                            'quantity' => $mach['quantity'],
                            'unit_price' => $mach['price'],
                            'total' => $total,
                        ]
                    );

                    // Update inventory
                    $inventory = Inventory::firstOrNew([
                        'machinery_id' => $mach['id'],
                        'branch_id' => $mach['branch_id'] ?? $devicePurchase->branch_id,
                        'accessory_id' => null,
                    ]);

                    // Calculate difference from original purchase
                    $originalQuantity = $currentMachineries[$mach['id']]->quantity ?? 0;
                    $quantityDifference = $mach['quantity'] - $originalQuantity;

                    // Adjust both quantities
                    $inventory->opening_quantity += $quantityDifference;
                    $inventory->quantity += $quantityDifference;

                    if (!$inventory->exists) {
                        $inventory->status = true;
                    }

                    $inventory->updated_by = auth()->id();
                    $inventory->save();
                }
            }

            // Remove any accessories/machineries that were deleted
            $currentAccessoryIds = collect($request->accessories ?? [])->pluck('id')->toArray();
            $currentMachineryIds = collect($request->machineries ?? [])->pluck('id')->toArray();

            DevicePurchaseAccessory::where('device_purchase_id', $devicePurchase->id)
                ->whereNotIn('accessory_id', $currentAccessoryIds)
                ->delete();

            DevicePurchaseMachinery::where('device_purchase_id', $devicePurchase->id)
                ->whereNotIn('machinery_id', $currentMachineryIds)
                ->delete();
        });

        return redirect()->route('device-purchases.index')->with('success', 'Device purchase updated successfully.');
    }

    public function destroy(DevicePurchase $devicePurchase): RedirectResponse
    {
        DB::transaction(function () use ($devicePurchase) {
            // First get all related items to adjust inventory
            $accessories = DevicePurchaseAccessory::where('device_purchase_id', $devicePurchase->id)->get();
            $machineries = DevicePurchaseMachinery::where('device_purchase_id', $devicePurchase->id)->get();

            // Adjust inventory quantities before deletion
            foreach ($accessories as $accessory) {
                $inventory = Inventory::where('accessory_id', $accessory->accessory_id)
                    ->where('branch_id', $accessory->branch_id)
                    ->first();

                if ($inventory) {
                    // Only decrease the quantity (keep opening_quantity as historical record)
                    $inventory->quantity -= $accessory->quantity;

                    // If quantity would go negative, set to 0 (safety measure)
                    if ($inventory->quantity < 0) {
                        $inventory->quantity = 0;
                    }

                    $inventory->save();
                }
            }

            foreach ($machineries as $machinery) {
                $inventory = Inventory::where('machinery_id', $machinery->machinery_id)
                    ->where('branch_id', $machinery->branch_id)
                    ->first();

                if ($inventory) {
                    // Only decrease the quantity (keep opening_quantity as historical record)
                    $inventory->quantity -= $machinery->quantity;

                    // If quantity would go negative, set to 0 (safety measure)
                    if ($inventory->quantity < 0) {
                        $inventory->quantity = 0;
                    }

                    $inventory->save();
                }
            }

            // Delete receipt file if exists
            if ($devicePurchase->receipt && file_exists(public_path($devicePurchase->receipt))) {
                unlink(public_path($devicePurchase->receipt));
            }

            // Delete related accessories and machineries
            DevicePurchaseAccessory::where('device_purchase_id', $devicePurchase->id)->delete();
            DevicePurchaseMachinery::where('device_purchase_id', $devicePurchase->id)->delete();

            // Delete the device purchase record
            $devicePurchase->delete();
        });

        return redirect()->route('device-purchases.index')->with('success', 'Device purchase deleted successfully.');
    }

    public function showMachineriesAccessories($id)
    {
        $purchase = DevicePurchase::with('supplier')->findOrFail($id);

        $machineries = DevicePurchaseMachinery::with(['machineries', 'branch'])
            ->where('device_purchase_id', $id)
            ->get();
        $accessories = DevicePurchaseAccessory::with(['accessories', 'branch'])
            ->where('device_purchase_id', $id)
            ->get();

        return view('inventory::DevicePurchase.machineries_accessories', [
            'supplier' => $purchase->supplier,
            'bill_no' => $purchase->bill_no,
            'machineries' => $machineries,
            'accessories' => $accessories,
        ]);
    }

    public function getInventories()
    {
        $user = auth()->user();

        $query = Inventory::with([
            'accessories:id,name',
            'machineries:id,name',
            'branch:id,name',
            'user:id,name'
        ])->latest();

        if ($user->branch_id) {
            $query->where('branch_id', $user->branch_id);
        }

        $inventories = $query->get();

        $filteredAccessories = $inventories->filter(function ($inventory) {
            return !empty($inventory->accessories);
        });

        $filteredMachineries = $inventories->filter(function ($inventory) {
            return !empty($inventory->machineries);
        });

        return view('inventory::inventories.index', compact(
            'filteredAccessories',
            'filteredMachineries'
        ));
    }
}