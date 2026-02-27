<?php

namespace Modules\Inventory\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Inventory\Entities\DevicePurchaseAccessory;
use Modules\Inventory\Entities\DevicePurchaseMachinery;
use Modules\Inventory\Entities\DevicePurchaseTechnicalTool;
use Modules\Inventory\Entities\StockTransferAccessories;
use Modules\Inventory\Entities\StockTransferMachineries;
use Modules\Inventory\Entities\StockTransferTechnicalTool;
use Modules\Inventory\Entities\Inventory;
use Modules\Product\Entities\AccessoryStock;
use Modules\Product\Entities\Machinery;
use Modules\Product\Entities\TechnicalTools;
use Modules\Inventory\Entities\SaleAccessory;
use Modules\Inventory\Entities\SaleMachinery;
use Modules\Inventory\Entities\SaleTechnicalTool;
use Modules\Inventory\Entities\InventoryTransaction;
use Modules\Inventory\Entities\StaffItemAssignment;
use Modules\Inventory\Entities\StaffItemReturn;
use Modules\Inventory\Entities\Accessories;



class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */


public function index()
{
    if (auth()->user()->role['name'] === 'Super Admin') {
        $branchId = session('branch_id');
    } else {
        $branchId = auth()->user()->branch_id;
    }

    // ACCESSORIES (from accessory_stocks table)
    $filteredAccessories = AccessoryStock::with(['accessory', 'branch'])
        ->where('branch_id', $branchId)
        ->get();

    // MACHINERIES (if you store stock in machineries table)
    $filteredMachineries = Machinery::where('status', 1)->get();

    // TECHNICAL TOOLS (from inventory table)
    $filteredTechnicalTools = Inventory::with(['technicaltools', 'branch', 'user'])
        ->whereNotNull('technical_tool_id')
        ->where('branch_id', $branchId)
        ->get();

    return view('inventory::index', compact(
        'filteredAccessories',
        'filteredMachineries',
        'filteredTechnicalTools'
    ));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inventory::create');
    }

    /**
     * Show the specified resource.
     */
public function accessories_details($id)
{
    $branchId = auth()->user()->role['name'] === 'Super Admin'
        ? session('branch_id')
        : auth()->user()->branch_id;

    if (!$branchId) {
        return back()->with('error', 'Please select a branch.');
    }

    $unitMap = [
        'qty' => 'Quantity',
        'ltr' => 'Liter',
        'kg' => 'Kilogram',
        'meter' => 'Meter',
        'inch' => 'Inch',
        'other' => 'Other'
    ];

    $accessory = Accessories::find($id);
    $accessoryName = $accessory ? $accessory->name : 'N/A';

    // ---------------------- PURCHASE ----------------------
    $purchases = DevicePurchaseAccessory::with('branch')
        ->where('accessory_id', $id)
        ->where('branch_id', $branchId)
        ->get()
        ->map(fn($item) => (object)[
            'movement_type' => 'Purchase',
            'quantity' => $item->quantity,
            'from_branch' => null,
            'to_branch' => $item->branch->name ?? null,
            'unit' => $unitMap[$item->accessory->units ?? ''] ?? 'N/A',
            'created_at' => $item->created_at,
        ]);

    // ---------------------- TRANSFER IN ----------------------
    $transfersIn = StockTransferAccessories::with(['stockTransfer.fromBranch','stockTransfer.toBranch','accessory'])
        ->where('accessory_id', $id)
        ->whereHas('stockTransfer', fn($q) => $q->where('to_branch_id', $branchId))
        ->get()
        ->map(fn($item) => (object)[
            'movement_type' => 'Transfer Received',
            'quantity' => $item->quantity,
            'from_branch' => $item->stockTransfer->fromBranch->name ?? null,
            'to_branch' => $item->stockTransfer->toBranch->name ?? null,
            'unit' => $unitMap[$item->accessory->units ?? ''] ?? 'N/A',
            'created_at' => $item->created_at,
        ]);

    // ---------------------- TRANSFER OUT ----------------------
    $transfersOut = StockTransferAccessories::with(['stockTransfer.fromBranch','stockTransfer.toBranch','accessory'])
        ->where('accessory_id', $id)
        ->whereHas('stockTransfer', fn($q) => $q->where('from_branch_id', $branchId))
        ->get()
        ->map(fn($item) => (object)[
            'movement_type' => 'Transfer Sent',
            'quantity' => $item->quantity,
            'from_branch' => $item->stockTransfer->fromBranch->name ?? null,
            'to_branch' => $item->stockTransfer->toBranch->name ?? null,
            'unit' => $unitMap[$item->accessory->units ?? ''] ?? 'N/A',
            'created_at' => $item->created_at,
        ]);

    // ---------------------- SALES ----------------------
    $sales = SaleAccessory::with(['sale.branch','accessory'])
        ->where('accessory_id', $id)
        ->get()
        ->filter(fn($item) => $item->sale && $item->sale->branch_id == $branchId)
        ->map(fn($item) => (object)[
            'movement_type' => 'Sale',
            'quantity' => $item->quantity,
            'from_branch' => null,
            'to_branch' => $item->sale->branch->name ?? null,
            'unit' => $unitMap[$item->accessory->units ?? ''] ?? 'N/A',
            'created_at' => $item->created_at,
        ]);

    // ---------------------- USED + BROKEN (Staff Assignments) ----------------------
    $assignments = StaffItemAssignment::with('returns')
        ->where('item_type', 'accessory')
        ->where('item_id', $id)
        ->where('branch_id', $branchId)
        ->get();

    $usage = collect();
    foreach ($assignments as $assignment) {
        foreach ($assignment->returns as $return) {
            if ($return->used_qty > 0) {
                $used = clone $return;
                $used->movement_type = 'Used';
                $used->quantity = $return->used_qty;
                $used->from_branch = null;
                $used->to_branch = null;
                $used->unit = $unitMap[$assignment->item->units ?? 'qty'] ?? 'N/A';
                $used->created_at = $return->verified_at ?? $return->created_at;
                $usage->push($used);
            }
            if ($return->broken_qty > 0) {
                $broken = clone $return;
                $broken->movement_type = 'Broken';
                $broken->quantity = $return->broken_qty;
                $broken->from_branch = null;
                $broken->to_branch = null;
                $broken->unit = $unitMap[$assignment->item->units ?? 'qty'] ?? 'N/A';
                $broken->created_at = $return->verified_at ?? $return->created_at;
                $usage->push($broken);
            }
        }
    }

    // ---------------------- MERGE ALL ----------------------
    $accessoryMovements = collect()
        ->merge($purchases)
        ->merge($transfersIn)
        ->merge($transfersOut)
        ->merge($sales)
        ->merge($usage)
        ->sortByDesc('created_at')
        ->values();

    // ---------------------- TOTALS ----------------------
    $totalIn = $accessoryMovements
        ->filter(fn($item) => in_array($item->movement_type, ['Purchase','Transfer Received']))
        ->sum('quantity');

    $totalOut = $accessoryMovements
        ->filter(fn($item) => in_array($item->movement_type, ['Transfer Sent','Sale','Used','Broken']))
        ->sum('quantity');

    $remaining = $totalIn - $totalOut;

    return view('inventory::inventories.accessories_details', compact(
        'accessoryMovements','totalIn','totalOut','remaining','accessoryName'
    ));
}






public function machineries_details($id)
{
    // Determine current branch
    $branchId = auth()->user()->role['name'] === 'Super Admin'
        ? session('branch_id')
        : auth()->user()->branch_id;

    // -----------------------------
    // Purchases (IN)
    // -----------------------------
    $purchases = DevicePurchaseMachinery::with(['machinery', 'branch'])
        ->where('machinery_id', $id)
        ->where('branch_id', $branchId)
        ->get()
        ->map(function ($item) {
            $item->movement_type = 'Purchase';
            $item->from_branch = null;
            $item->to_branch   = $item->branch->name ?? null;
            return $item;
        });

    // -----------------------------
    // Transfers IN (counted in IN)
    // -----------------------------
    $transfersIn = StockTransferMachineries::with([
            'machinery',
            'stockTransfer.fromBranch',
            'stockTransfer.toBranch'
        ])
        ->where('machinery_id', $id)
        ->whereHas('stockTransfer', fn($q) => $q->where('to_branch_id', $branchId))
        ->get()
        ->map(function ($item) {
            $item->movement_type = 'Transfer Received';
            $item->from_branch = $item->stockTransfer->fromBranch->name ?? null;
            $item->to_branch   = $item->stockTransfer->toBranch->name ?? null;
            return $item;
        });

    // -----------------------------
    // Transfers OUT (counted in OUT)
    // -----------------------------
    $transfersOut = StockTransferMachineries::with([
            'machinery',
            'stockTransfer.fromBranch',
            'stockTransfer.toBranch'
        ])
        ->where('machinery_id', $id)
        ->whereHas('stockTransfer', fn($q) => $q->where('from_branch_id', $branchId))
        ->get()
        ->map(function ($item) {
            $item->movement_type = 'Transfer Sent';
            $item->from_branch = $item->stockTransfer->fromBranch->name ?? null;
            $item->to_branch   = $item->stockTransfer->toBranch->name ?? null;
            return $item;
        });

    // -----------------------------
    // Sales OUT (only for current branch)
    // -----------------------------
    $salesOut = SaleMachinery::with(['machinery', 'sale.branch'])
        ->where('machinery_id', $id)
        ->get()
        ->filter(fn($item) => $item->sale && $item->sale->branch_id == $branchId)
        ->map(function ($item) {
            $item->movement_type = 'Sell';
            $item->from_branch = $item->sale->branch->name ?? null;
            $item->to_branch   = 'Customer';
            return $item;
        });

    // -----------------------------
    // Merge all movements
    // -----------------------------
    $machineryMovements = collect()
        ->merge($purchases)
        ->merge($transfersIn)
        ->merge($transfersOut)
        ->merge($salesOut)
        ->sortBy('created_at')
        ->values();

    // -----------------------------
    // Calculate totals
    // -----------------------------
    $totalIn = $machineryMovements
        ->filter(fn($item) => in_array($item->movement_type, ['Purchase', 'Transfer Received']))
        ->sum('quantity');

    $totalOut = $machineryMovements
        ->filter(fn($item) => in_array($item->movement_type, ['Transfer Sent', 'Sell']))
        ->sum('quantity');

    $remaining = $totalIn - $totalOut;

    // -----------------------------
    // Return view
    // -----------------------------
    return view('inventory::inventories.machineries_details', compact(
        'machineryMovements',
        'totalIn',
        'totalOut',
        'remaining'
    ));
}





public function technicaltools_details($id)
{
    $branchId = auth()->user()->role['name'] === 'Super Admin'
        ? session('branch_id')
        : auth()->user()->branch_id;

    if (!$branchId) {
        return back()->with('error', 'Please select a branch to view movements.');
    }

    // ---------------------- PURCHASE (IN) ----------------------
    $purchases = DevicePurchaseTechnicalTool::with(['technicaltools', 'branch'])
        ->where('technical_tool_id', $id)
        ->where('branch_id', $branchId)
        ->get()
        ->map(function ($item) {
            $item->movement_type = 'Purchase';
            $item->from_branch = null;
            $item->to_branch = $item->branch->name ?? null;
            return $item;
        });

    // ---------------------- TRANSFER IN ----------------------
    $transfersIn = StockTransferTechnicalTool::with([
        'technicaltools',
        'stockTransfer.fromBranch',
        'stockTransfer.toBranch'
    ])
        ->where('technical_tool_id', $id)
        ->whereHas('stockTransfer', fn($q) => $q->where('to_branch_id', $branchId))
        ->get()
        ->map(function ($item) {
            $item->movement_type = 'Transfer Received';
            $item->from_branch = $item->stockTransfer->fromBranch->name ?? null;
            $item->to_branch = $item->stockTransfer->toBranch->name ?? null;
            return $item;
        });

    // ---------------------- TRANSFER OUT ----------------------
    $transfersOut = StockTransferTechnicalTool::with([
        'technicaltools',
        'stockTransfer.fromBranch',
        'stockTransfer.toBranch'
    ])
        ->where('technical_tool_id', $id)
        ->whereHas('stockTransfer', fn($q) => $q->where('from_branch_id', $branchId))
        ->get()
        ->map(function ($item) {
            $item->movement_type = 'Transfer Sent';
            $item->from_branch = $item->stockTransfer->fromBranch->name ?? null;
            $item->to_branch = $item->stockTransfer->toBranch->name ?? null;
            return $item;
        });

    // ---------------------- USED + BROKEN (from STAFF ASSIGNMENTS) ----------------------
    $assignments = StaffItemAssignment::with('returns')
        ->where('item_type', 'technical_tool')
        ->where('item_id', $id)
        ->where('branch_id', $branchId)
        ->get();

    $usage = collect();

    foreach ($assignments as $assignment) {
        foreach ($assignment->returns as $return) {
            if ($return->used_qty > 0) {
                $used = clone $return;
                $used->movement_type = 'Used';
                $used->quantity = $return->used_qty;
                $used->from_branch = null;
                $used->to_branch = null;
                $usage->push($used);
            }

            if ($return->broken_qty > 0) {
                $broken = clone $return;
                $broken->movement_type = 'Broken';
                $broken->quantity = $return->broken_qty;
                $broken->from_branch = null;
                $broken->to_branch = null;
                $usage->push($broken);
            }
        }
    }

    // ---------------------- MERGE ALL MOVEMENTS ----------------------
    $technicalToolMovements = collect()
        ->merge($purchases)
        ->merge($transfersIn)
        ->merge($transfersOut)
        ->merge($usage)
        ->sortBy('created_at')
        ->values();

    // ---------------------- TOTALS ----------------------
    $totalIn = $technicalToolMovements
        ->filter(fn($item) => in_array($item->movement_type, ['Purchase', 'Transfer Received']))
        ->sum('quantity');

    $totalOut = $technicalToolMovements
        ->filter(fn($item) => in_array($item->movement_type, ['Transfer Sent', 'Used', 'Broken']))
        ->sum('quantity');

    $remaining = $totalIn - $totalOut;

    return view('inventory::inventories.technical_tools_details', compact(
        'technicalToolMovements',
        'totalIn',
        'totalOut',
        'remaining'
    ));
}







    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('inventory::edit');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
