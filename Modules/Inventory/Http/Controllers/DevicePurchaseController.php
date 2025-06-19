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
                    if (!$inventory->exists) {
                        $inventory->opening_quantity = 0;
                        $inventory->quantity = 0;
                        $inventory->status = true;
                    }
                    $inventory->quantity += $acc['quantity'];
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
                    if (!$inventory->exists) {
                        $inventory->opening_quantity = 0;
                        $inventory->quantity = 0;
                        $inventory->status = true;
                    }
                    $inventory->quantity += $mach['quantity'];
                    $inventory->updated_by = auth()->id();
                    $inventory->save();
                }
            }
        });

        return back()->with('success', 'Device purchase stored successfully.');
    }


    public function edit(DevicePurchase $devicePurchase)
    {
        // dd($devicePurchase);
        // No need for closure if already eager-loaded withPivot in the model
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
                // Delete old receipt if exists
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

            // Handle accessories update
            if ($request->filled('accessories')) {
                // First delete existing accessories
                DevicePurchaseAccessory::where('device_purchase_id', $devicePurchase->id)->delete();

                foreach ($request->accessories as $acc) {
                    $total = $acc['quantity'] * $acc['price'];
                    DevicePurchaseAccessory::create([
                        'device_purchase_id' => $devicePurchase->id,
                        'accessory_id' => $acc['id'],
                        'branch_id' => $acc['branch_id'],
                        'quantity' => $acc['quantity'],
                        'unit_price' => $acc['price'],
                        'total' => $total,
                    ]);

                    // Update inventory
                    $inventory = Inventory::firstOrNew([
                        'accessory_id' => $acc['id'],
                        'branch_id' => $acc['branch_id'],
                        'machinery_id' => null,
                    ]);
                    $inventory->quantity = $acc['quantity']; // Set to new quantity
                    $inventory->updated_by = auth()->id();
                    $inventory->save();
                }
            }

            // Handle machineries update
            if ($request->filled('machineries')) {
                // First delete existing machineries
                DevicePurchaseMachinery::where('device_purchase_id', $devicePurchase->id)->delete();

                foreach ($request->machineries as $mach) {
                    $total = $mach['quantity'] * $mach['price'];
                    DevicePurchaseMachinery::create([
                        'device_purchase_id' => $devicePurchase->id,
                        'machinery_id' => $mach['id'],
                        'branch_id' => $mach['branch_id'],
                        'quantity' => $mach['quantity'],
                        'unit_price' => $mach['price'],
                        'total' => $total,
                    ]);

                    // Update inventory
                    $inventory = Inventory::firstOrNew([
                        'machinery_id' => $mach['id'],
                        'branch_id' => $mach['branch_id'],
                        'accessory_id' => null,
                    ]);
                    $inventory->quantity = $mach['quantity']; // Set to new quantity
                    $inventory->updated_by = auth()->id();
                    $inventory->save();
                }
            }
        });

        return redirect()->route('device-purchases.index')->with('success', 'Device purchase updated successfully.');
    }

    public function destroy(DevicePurchase $devicePurchase): RedirectResponse
    {
        DB::transaction(function () use ($devicePurchase) {
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

        $filteredAccessories = $inventories->filter(function($inventory) {
            return !empty($inventory->accessories);
        });

        $filteredMachineries = $inventories->filter(function($inventory) {
            return !empty($inventory->machineries);
        });

        return view('inventory::inventories.index', compact(
            'filteredAccessories',
            'filteredMachineries'
        ));
    }
}
