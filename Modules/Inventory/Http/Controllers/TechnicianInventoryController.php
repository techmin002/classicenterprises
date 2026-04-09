<?php

namespace Modules\Inventory\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Inventory\Entities\StaffItemAssignment;
use Modules\Inventory\Entities\StaffItemReturn;
use Modules\Inventory\Entities\Inventory;
use Modules\Inventory\Entities\DevicePurchaseAccessory;
use Modules\Inventory\Entities\DevicePurchaseTechnicalTool;
use Modules\Inventory\Entities\StockTransferAccessories;
use Modules\Inventory\Entities\StockTransferTechnicalTool;
use Modules\Inventory\Entities\SaleAccessory;
use Modules\Inventory\Entities\Accessories;
use Modules\Inventory\Entities\TechnicalTool;
use Illuminate\Validation\ValidationException;


use App\Models\User;


class TechnicianInventoryController extends Controller
{
    /**
     * List technicians (branch-wise)
     */
public function index()
{
    $user = auth()->user();
    $branchId = $user->hasRole('Super Admin') ? session('branch_id') : $user->branch_id;

    $technicians = User::with('branch')
        ->where('branch_id', $branchId)
        ->whereHas('role', fn($q) => $q->where('name', 'staff'))
        ->get();

    // Load accessories with branch inventory
    $accessories = Accessories::with(['inventory' => function ($q) use ($branchId) {
        $q->where('branch_id', $branchId);
    }])->get();

  $technicalTools = TechnicalTool::with(['inventory', 'assignments', 'stockTransfers'])->get();

    return view('inventory::technicians.index', compact(
        'technicians',
        'accessories',
        'technicalTools'
    ));
}

/**
 * Handle storing assignment
 */


public function storeAssignment(Request $request)
{
    $request->validate([
        'staff_id' => 'required|exists:users,id',
        'remarks'  => 'nullable|string|max:500',
    ]);

    $staffId = $request->staff_id;

    /*
    |--------------------------------------------------------------------------
    | BRANCH DETECTION (IMPORTANT FIX)
    |--------------------------------------------------------------------------
    */
    $branchId = auth()->user()->role['name'] === 'Super Admin'
        ? session('branch_id')
        : auth()->user()->branch_id;

    if (!$branchId) {
        return back()->withErrors([
            'error' => 'Branch not selected.'
        ]);
    }

    try {

        DB::transaction(function () use ($request, $staffId, $branchId) {

            /*
            |--------------------------------------------------------------------------
            | ACCESSORIES
            |--------------------------------------------------------------------------
            */
            if (!empty($request->accessories)) {

                foreach ($request->accessories as $item) {

                    if (empty($item['item_id'])) continue;

                    $accessoryId = $item['item_id'];
                    $assignQty   = (int) $item['assigned_qty'];

                    if ($assignQty <= 0) continue;

                    // Purchased
                    $purchased = DevicePurchaseAccessory::where([
                        'accessory_id' => $accessoryId,
                        'branch_id'    => $branchId
                    ])->sum('quantity');

                    // Already Assigned
                    $assigned = StaffItemAssignment::where([
                        'branch_id' => $branchId,
                        'item_type' => 'accessory',
                        'item_id'   => $accessoryId,
                        'status'    => 'assigned'
                    ])->sum('assigned_qty');

                    // Transfer OUT
                    $transferredOut = StockTransferAccessories::where('accessory_id', $accessoryId)
                        ->whereHas('stockTransfer', function ($q) use ($branchId) {
                            $q->where('from_branch_id', $branchId);
                        })->sum('quantity');

                    // Transfer IN
                    $transferredIn = StockTransferAccessories::where('accessory_id', $accessoryId)
                        ->whereHas('stockTransfer', function ($q) use ($branchId) {
                            $q->where('to_branch_id', $branchId);
                        })->sum('quantity');

                    // SOLD
                    $sold = SaleAccessory::whereHas('sale', function ($q) use ($branchId) {
                        $q->where('branch_id', $branchId);
                    })->where('accessory_id', $accessoryId)
                      ->sum('quantity');

                    // Final Available
                    $available = ($purchased + $transferredIn)
                               - ($assigned + $transferredOut + $sold);

                    $available = max(0, $available);

                    if ($assignQty > $available) {
                        throw ValidationException::withMessages([
                            'stock' => "Not enough stock for selected accessory. Available: {$available}"
                        ]);
                    }

                    StaffItemAssignment::create([
                        'staff_id'     => $staffId,
                        'branch_id'    => $branchId,
                        'item_type'    => 'accessory',
                        'item_id'      => $accessoryId,
                        'assigned_qty' => $assignQty,
                        'assigned_by'  => auth()->id(),
                        'assigned_at'  => now(),
                        'status'       => 'assigned',
                        'remarks'      => $request->remarks,
                    ]);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | TECHNICAL TOOLS
            |--------------------------------------------------------------------------
            */
            if (!empty($request->technical_tools)) {

                foreach ($request->technical_tools as $item) {

                    if (empty($item['item_id'])) continue;

                    $toolId    = $item['item_id'];
                    $assignQty = (int) $item['assigned_qty'];

                    if ($assignQty <= 0) continue;

                    // Purchased
                    $purchased = DevicePurchaseTechnicalTool::where([
                        'technical_tool_id' => $toolId,
                        'branch_id'         => $branchId
                    ])->sum('quantity');

                    // Already Assigned
                    $assigned = StaffItemAssignment::where([
                        'branch_id' => $branchId,
                        'item_type' => 'technical_tool',
                        'item_id'   => $toolId,
                        'status'    => 'assigned'
                    ])->sum('assigned_qty');

                    // Transfer OUT
                    $transferredOut = StockTransferTechnicalTool::where('technical_tool_id', $toolId)
                        ->whereHas('stockTransfer', function ($q) use ($branchId) {
                            $q->where('from_branch_id', $branchId);
                        })->sum('quantity');

                    // Transfer IN
                    $transferredIn = StockTransferTechnicalTool::where('technical_tool_id', $toolId)
                        ->whereHas('stockTransfer', function ($q) use ($branchId) {
                            $q->where('to_branch_id', $branchId);
                        })->sum('quantity');

                    // Available
                    $available = ($purchased + $transferredIn)
                               - ($assigned + $transferredOut);

                    $available = max(0, $available);

                    if ($assignQty > $available) {
                        throw ValidationException::withMessages([
                            'stock' => "Not enough stock for selected tool. Available: {$available}"
                        ]);
                    }

                    StaffItemAssignment::create([
                        'staff_id'     => $staffId,
                        'branch_id'    => $branchId,
                        'item_type'    => 'technical_tool',
                        'item_id'      => $toolId,
                        'assigned_qty' => $assignQty,
                        'assigned_by'  => auth()->id(),
                        'assigned_at'  => now(),
                        'status'       => 'assigned',
                        'remarks'      => $request->remarks,
                    ]);
                }
            }

        });

        return redirect()
            ->route('inventory.technicians.show', $staffId)
            ->with('success', 'Items assigned successfully!');

    } catch (ValidationException $e) {
        throw $e;
    } catch (\Exception $e) {

        return back()->withErrors([
            'error' => 'Something went wrong: ' . $e->getMessage()
        ]);
    }
}




public function show($staffId)
{
    $user = auth()->user();

    $branchId = $user->hasRole('Super Admin')
        ? session('branch_id')
        : $user->branch_id;

    $staff = User::findOrFail($staffId);

    /*
    |--------------------------------------------------------------------------
    | STAFF ASSIGNMENTS
    |--------------------------------------------------------------------------
    */
    $assignments = StaffItemAssignment::with(['item', 'returns'])
        ->where('staff_id', $staffId)
        ->where('branch_id', $branchId)
        ->latest()
        ->get();

    /*
    |--------------------------------------------------------------------------
    | ACCESSORIES (WITH UNIT + REMAINING STOCK)
    |--------------------------------------------------------------------------
    */
    $accessories = Accessories::whereHas('devicePurchaseAccessories', function ($q) use ($branchId) {
        $q->where('branch_id', $branchId);
    })->get()->map(function ($accessory) use ($branchId) {

        $purchasedQty = DevicePurchaseAccessory::where('accessory_id', $accessory->id)
            ->where('branch_id', $branchId)
            ->sum('quantity');

        $transferredOutQty = StockTransferAccessories::where('accessory_id', $accessory->id)
            ->whereHas('stockTransfer', fn($q) => $q->where('from_branch_id', $branchId))
            ->sum('quantity');

        $transferredInQty = StockTransferAccessories::where('accessory_id', $accessory->id)
            ->whereHas('stockTransfer', fn($q) => $q->where('to_branch_id', $branchId))
            ->sum('quantity');

        $soldQty = SaleAccessory::where('accessory_id', $accessory->id)
            ->sum('quantity');

        // Net assigned qty = assigned - returned (for dropdown only)
        $assignedQty = StaffItemAssignment::with('returns')
            ->where('branch_id', $branchId)
            ->where('item_type', 'accessory')
            ->where('item_id', $accessory->id)
            ->get()
            ->sum(fn($a) => $a->assigned_qty - $a->returns->sum('returned_qty'));

        $remainingQty = max(
            0,
            ($purchasedQty + $transferredInQty)
            - ($soldQty + $transferredOutQty + $assignedQty)
        );

        return $remainingQty > 0 ? [
            'id' => $accessory->id,
            'name' => $accessory->name,
            'stock_quantity' => $remainingQty,
            'unit' => $accessory->units,
        ] : null;

    })->filter()->values();

    /*
    |--------------------------------------------------------------------------
    | TECHNICAL TOOLS (NO UNIT)
    |--------------------------------------------------------------------------
    */
    $technicalTools = TechnicalTool::get()->map(function ($tool) use ($branchId) {

        $purchasedQty = DevicePurchaseTechnicalTool::where('technical_tool_id', $tool->id)
            ->where('branch_id', $branchId)
            ->sum('quantity');

        $transferredOutQty = StockTransferTechnicalTool::where('technical_tool_id', $tool->id)
            ->whereHas('stockTransfer', fn($q) => $q->where('from_branch_id', $branchId))
            ->sum('quantity');

        $transferredInQty = StockTransferTechnicalTool::where('technical_tool_id', $tool->id)
            ->whereHas('stockTransfer', fn($q) => $q->where('to_branch_id', $branchId))
            ->sum('quantity');

        // Net assigned qty = assigned - returned (for dropdown only)
        $assignedQty = StaffItemAssignment::with('returns')
            ->where('branch_id', $branchId)
            ->where('item_type', 'technical_tool')
            ->where('item_id', $tool->id)
            ->get()
            ->sum(fn($a) => $a->assigned_qty - $a->returns->sum('returned_qty'));

        $remainingQty = max(
            0,
            ($purchasedQty + $transferredInQty)
            - ($assignedQty + $transferredOutQty)
        );

        return $remainingQty > 0 ? [
            'id' => $tool->id,
            'name' => $tool->tool_name,
            'stock_quantity' => $remainingQty,
        ] : null;

    })->filter()->values();

    /*
    |--------------------------------------------------------------------------
    | RETURN VIEW
    |--------------------------------------------------------------------------
    */
    return view('inventory::technicians.show', compact(
        'staff',
        'assignments',
        'accessories',
        'technicalTools'
    ));
}


public function itemHistory($staffId, $itemType, $itemId)
{
    $staff = User::findOrFail($staffId);

    $history = StaffItemAssignment::with('returns')
        ->where('staff_id', $staffId)
        ->where('item_type', $itemType)
        ->where('item_id', $itemId)
        ->latest()
        ->get();

    return view('inventory::technicians.history', compact('staff', 'history'));
}

    /**
     * Verify return
     */
public function verifyReturn(Request $request, $staffId, $itemType, $itemId)
{
    $request->validate([
        'returned_qty' => 'required|integer|min:0',
        'broken_qty'   => 'required|integer|min:0',
        'remarks'      => 'nullable|string|max:1000',
    ]);

    $assignments = StaffItemAssignment::with('returns')
        ->where('staff_id', $staffId)
        ->where('item_type', $itemType)
        ->where('item_id', $itemId)
        ->whereIn('status', ['assigned', 'returned'])
        ->orderBy('assigned_at', 'asc')
        ->get();

    if ($assignments->isEmpty()) {
        return back()->withErrors(['error' => 'No pending assignments found for this item.']);
    }

    $totalRemaining = $assignments->sum->remaining_qty;
    $totalProcessed = $request->returned_qty + $request->broken_qty;

    if ($totalProcessed > $totalRemaining) {
        return back()->withErrors(['error' => 'Cannot verify more than total remaining quantity.']);
    }

    DB::transaction(function () use ($request, $assignments, $itemType, $itemId) {

        $remainingToProcess = [
            'returned' => $request->returned_qty,
            'broken'   => $request->broken_qty,
        ];

        foreach ($assignments as $assignment) {

            $assignmentRemaining = $assignment->remaining_qty;
            if ($assignmentRemaining <= 0) continue;

            $applyReturned = min($assignmentRemaining, $remainingToProcess['returned']);
            $assignmentRemaining -= $applyReturned;
            $remainingToProcess['returned'] -= $applyReturned;

            $applyBroken = min($assignmentRemaining, $remainingToProcess['broken']);
            $assignmentRemaining -= $applyBroken;
            $remainingToProcess['broken'] -= $applyBroken;

            if ($applyReturned || $applyBroken) {
                StaffItemReturn::create([
                    'assignment_id' => $assignment->id,
                    'returned_qty'  => $applyReturned,
                    'broken_qty'    => $applyBroken,
                    'remarks'       => $request->remarks,
                    'verified_by'   => auth()->id(),
                    'verified_at'   => now(),
                ]);
            }

            // Reduce inventory for BROKEN only
            if ($itemType === 'accessory') {
                $inventory = Inventory::where('accessory_id', $itemId)
                            ->where('branch_id', $assignment->branch_id)
                            ->lockForUpdate()
                            ->first();
            } else {
                $inventory = Inventory::where('technical_tool_id', $itemId)
                            ->where('branch_id', $assignment->branch_id)
                            ->lockForUpdate()
                            ->first();
            }

            if (!$inventory) throw new \Exception("Inventory row not found!");

            if ($applyBroken > 0) $inventory->quantity -= $applyBroken;
            $inventory->save();

            // Update assignment status
            if ($assignment->remaining_qty - ($applyReturned + $applyBroken) <= 0) {
                $assignment->update(['status' => 'verified']);
            } else {
                $assignment->update(['status' => 'returned']);
            }

            if (array_sum($remainingToProcess) <= 0) break;
        }
    });

    return back()->with('success', 'Item verification updated successfully.');
}

}
