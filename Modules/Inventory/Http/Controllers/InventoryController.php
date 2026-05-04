<?php

namespace Modules\Inventory\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Inventory\Entities\DevicePurchaseAccessory;
use Modules\Inventory\Entities\DevicePurchaseMachinery;
use Modules\Inventory\Entities\DevicePurchaseTechnicalTool;
use Modules\Inventory\Entities\DevicePurchase;
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
use Modules\Inventory\Entities\Branch;
use Modules\Inventory\Entities\SaleReturn;
use Modules\Inventory\Entities\SaleReturnItem;
use Modules\Lead\Entities\CustomerProduct;
use Modules\Lead\Entities\CustomerAccessory;
use Modules\Inventory\Entities\TechnicalTool; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;


class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */


// public function index()
// {
//     if (auth()->user()->role['name'] === 'Super Admin') {
//         $branchId = session('branch_id');
//     } else {
//         $branchId = auth()->user()->branch_id;
//     }

//     // ACCESSORIES (from accessory_stocks table)
//     $filteredAccessories = AccessoryStock::with(['accessory', 'branch'])
//         ->where('branch_id', $branchId)
//         ->get();

//     // MACHINERIES (if you store stock in machineries table)
//     $filteredMachineries = Machinery::where('status', 1)->get();

//     // TECHNICAL TOOLS (from inventory table)
//     $filteredTechnicalTools = Inventory::with(['technicaltools', 'branch', 'user'])
//         ->whereNotNull('technical_tool_id')
//         ->where('branch_id', $branchId)
//         ->get();

//     return view('inventory::index', compact(
//         'filteredAccessories',
//         'filteredMachineries',
//         'filteredTechnicalTools'
//     ));
// }


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
    // public function accessories_details($id)
    // {
    //     $branchId = auth()->user()->role['name'] === 'Super Admin'
    //         ? session('branch_id')
    //         : auth()->user()->branch_id;

    //     if (!$branchId) {
    //         return back()->with('error', 'Please select a branch.');
    //     }

    //     $unitMap = [
    //         'qty' => 'Quantity',
    //         'ltr' => 'Liter',
    //         'kg' => 'Kilogram',
    //         'meter' => 'Meter',
    //         'inch' => 'Inch',
    //         'other' => 'Other'
    //     ];

    //     $accessory = Accessories::find($id);
    //     $accessoryName = $accessory ? $accessory->name : 'N/A';

    //     // ---------------------- PURCHASE ----------------------
    //     $purchases = DevicePurchaseAccessory::with('branch', 'accessory')
    //         ->where('accessory_id', $id)
    //         ->where('branch_id', $branchId)
    //         ->get()
    //         ->map(fn($item) => (object)[
    //             'movement_type' => 'Purchase',
    //             'quantity' => $item->quantity,
    //             'from_branch' => null,
    //             'to_branch' => $item->branch->name ?? null,
    //             'unit' => $unitMap[$item->accessory->units ?? 'qty'] ?? 'N/A',
    //             'created_at' => $item->created_at,
    //         ]);

    //     // ---------------------- TRANSFER IN ----------------------
    //     $transfersIn = StockTransferAccessories::with(['stockTransfer.fromBranch', 'stockTransfer.toBranch', 'accessory'])
    //         ->where('accessory_id', $id)
    //         ->whereHas('stockTransfer', fn($q) => $q->where('to_branch_id', $branchId))
    //         ->get()
    //         ->map(fn($item) => (object)[
    //             'movement_type' => 'Transfer Received',
    //             'quantity' => $item->quantity,
    //             'from_branch' => $item->stockTransfer->fromBranch->name ?? null,
    //             'to_branch' => $item->stockTransfer->toBranch->name ?? null,
    //             'unit' => $unitMap[$item->accessory->units ?? 'qty'] ?? 'N/A',
    //             'created_at' => $item->created_at,
    //         ]);

    //     // ---------------------- TRANSFER OUT ----------------------
    //     $transfersOut = StockTransferAccessories::with(['stockTransfer.fromBranch', 'stockTransfer.toBranch', 'accessory'])
    //         ->where('accessory_id', $id)
    //         ->whereHas('stockTransfer', fn($q) => $q->where('from_branch_id', $branchId))
    //         ->get()
    //         ->map(fn($item) => (object)[
    //             'movement_type' => 'Transfer Sent',
    //             'quantity' => $item->quantity,
    //             'from_branch' => $item->stockTransfer->fromBranch->name ?? null,
    //             'to_branch' => $item->stockTransfer->toBranch->name ?? null,
    //             'unit' => $unitMap[$item->accessory->units ?? 'qty'] ?? 'N/A',
    //             'created_at' => $item->created_at,
    //         ]);

    //     // ---------------------- SALES ----------------------
    //     $sales = SaleAccessory::with(['sale.branch', 'accessory'])
    //         ->where('accessory_id', $id)
    //         ->get()
    //         ->filter(fn($item) => $item->sale && $item->sale->branch_id == $branchId)
    //         ->map(fn($item) => (object)[
    //             'movement_type' => 'Sale',
    //             'quantity' => $item->quantity,
    //             'from_branch' => null,
    //             'to_branch' => $item->sale->branch->name ?? null,
    //             'unit' => $unitMap[$item->accessory->units ?? 'qty'] ?? 'N/A',
    //             'created_at' => $item->created_at,
    //         ]);

    //     // ---------------------- SALE RETURNS ----------------------
    //     $saleReturns = SaleReturnItem::with(['saleReturn', 'accessory'])
    //         ->where('accessory_id', $id)
    //         ->whereHas('saleReturn.sale', fn($q) => $q->where('branch_id', $branchId))
    //         ->get()
    //         ->map(fn($item) => (object)[
    //             'movement_type' => 'Sale Return',
    //             'quantity' => $item->quantity,
    //             'from_branch' => null,
    //             'to_branch' => Branch::find($branchId)->name ?? null,
    //             'unit' => $unitMap[$item->accessory->units ?? 'qty'] ?? 'N/A',
    //             'created_at' => $item->saleReturn->created_at,
    //         ]);

    //     // ---------------------- USED + BROKEN ----------------------
    //     $assignments = StaffItemAssignment::with('returns')
    //         ->where('item_type', 'accessory')
    //         ->where('item_id', $id)
    //         ->where('branch_id', $branchId)
    //         ->get();

    //     $usage = collect();
    //     foreach ($assignments as $assignment) {
    //         foreach ($assignment->returns as $return) {
    //             if ($return->used_qty > 0) {
    //                 $used = clone $return;
    //                 $used->movement_type = 'Used';
    //                 $used->quantity = $return->used_qty;
    //                 $used->from_branch = null;
    //                 $used->to_branch = null;
    //                 $used->unit = $unitMap[$assignment->item->units ?? 'qty'] ?? 'N/A';
    //                 $used->created_at = $return->verified_at ?? $return->created_at;
    //                 $usage->push($used);
    //             }
    //             if ($return->broken_qty > 0) {
    //                 $broken = clone $return;
    //                 $broken->movement_type = 'Broken';
    //                 $broken->quantity = $return->broken_qty;
    //                 $broken->from_branch = null;
    //                 $broken->to_branch = null;
    //                 $broken->unit = $unitMap[$assignment->item->units ?? 'qty'] ?? 'N/A';
    //                 $broken->created_at = $return->verified_at ?? $return->created_at;
    //                 $usage->push($broken);
    //             }
    //         }
    //     }

    //     // ---------------------- MERGE ALL ----------------------
    //     $accessoryMovements = collect()
    //         ->merge($purchases)
    //         ->merge($transfersIn)
    //         ->merge($transfersOut)
    //         ->merge($sales)
    //         ->merge($saleReturns)
    //         ->merge($usage)
    //         ->sortByDesc('created_at')
    //         ->values();

    //     // ---------------------- TOTALS ----------------------
    //     $totalIn = $accessoryMovements
    //         ->filter(fn($item) => in_array($item->movement_type, ['Purchase', 'Transfer Received', 'Sale Return']))
    //         ->sum('quantity');

    //     $totalOut = $accessoryMovements
    //         ->filter(fn($item) => in_array($item->movement_type, ['Transfer Sent', 'Sale', 'Used', 'Broken']))
    //         ->sum('quantity');

    //     $remaining = $totalIn - $totalOut;

    //     return view('inventory::inventories.accessories_details', compact(
    //         'accessoryMovements',
    //         'totalIn',
    //         'totalOut',
    //         'remaining',
    //         'accessoryName'
    //     ));
    // }

  public function accessories_details($id)
{
    abort_if(Gate::denies('show_inventory'), 403);
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

    // -------------------- PURCHASE --------------------
    $purchases = DevicePurchaseAccessory::with(['branch', 'accessory'])
        ->where('accessory_id', $id)
        ->where('branch_id', $branchId)
        ->get()
        ->map(function ($item) use ($unitMap) {
            $unit = $unitMap[$item->accessory->units ?? 'qty'] ?? 'N/A';
            return (object)[
                'movement_type' => 'Purchase',
                'quantity' => $item->quantity,
                'from_branch' => null,
                'to_branch' => optional($item->branch)->name,
                'unit' => $unit,
                'created_at' => $item->created_at,
                'route' => $item->device_purchase_id
                    ? route('device_purchase_machineries_accessories', $item->device_purchase_id)
                    : null,
            ];
        });

    // -------------------- TRANSFER IN --------------------
    $transfersIn = StockTransferAccessories::with(['stockTransfer.fromBranch', 'stockTransfer.toBranch', 'accessory'])
        ->where('accessory_id', $id)
        ->whereHas('stockTransfer', fn($q) => $q->where('to_branch_id', $branchId))
        ->get()
        ->map(fn($item) => (object)[
            'movement_type' => 'Transfer Received',
            'quantity' => $item->quantity,
            'from_branch' => $item->stockTransfer->fromBranch->name ?? null,
            'to_branch' => $item->stockTransfer->toBranch->name ?? null,
            'unit' => $unitMap[$item->accessory->units ?? 'qty'] ?? 'N/A',
            'created_at' => $item->created_at,
            'route' => route('stock-transfers.show', $item->stockTransfer->id)
        ]);

    // -------------------- TRANSFER OUT --------------------
    $transfersOut = StockTransferAccessories::with(['stockTransfer.fromBranch', 'stockTransfer.toBranch', 'accessory'])
        ->where('accessory_id', $id)
        ->whereHas('stockTransfer', fn($q) => $q->where('from_branch_id', $branchId))
        ->get()
        ->map(fn($item) => (object)[
            'movement_type' => 'Transfer Sent',
            'quantity' => $item->quantity,
            'from_branch' => $item->stockTransfer->fromBranch->name ?? null,
            'to_branch' => $item->stockTransfer->toBranch->name ?? null,
            'unit' => $unitMap[$item->accessory->units ?? 'qty'] ?? 'N/A',
            'created_at' => $item->created_at,
            'route' => route('stock-transfers.show', $item->stockTransfer->id)
        ]);

    // -------------------- SALES --------------------
    $sales = SaleAccessory::with(['sale.branch', 'accessory'])
        ->where('accessory_id', $id)
        ->get()
        ->filter(fn($item) => $item->sale && $item->sale->branch_id == $branchId)
        ->map(fn($item) => (object)[
            'movement_type' => 'Sale',
            'quantity' => $item->quantity,
            'from_branch' => null,
            'to_branch' => $item->sale->branch->name ?? null,
            'unit' => $unitMap[$item->accessory->units ?? 'qty'] ?? 'N/A',
            'created_at' => $item->created_at,
            'route' => route('sales.show', $item->sale->id)
        ]);

    // -------------------- SALE RETURN --------------------
    $saleReturns = SaleReturnItem::with(['saleReturn', 'accessory'])
        ->where('accessory_id', $id)
        ->whereHas('saleReturn.sale', fn($q) => $q->where('branch_id', $branchId))
        ->get()
        ->map(fn($item) => (object)[
            'movement_type' => 'Sale Return',
            'quantity' => $item->quantity,
            'from_branch' => 'Customer',
            'to_branch' => $item->saleReturn->sale->branch->name ?? null,
            'unit' => $unitMap[$item->accessory->units ?? 'qty'] ?? 'N/A',
            'created_at' => $item->saleReturn->created_at,
            'route' => route('sale-returns.show', $item->saleReturn->id)
        ]);

    // -------------------- USED (Customer Installed) --------------------
    $customerUsed = CustomerAccessory::with(['customer'])
        ->where('branch_id', $branchId)
        ->where('accessory_id', $id)
        ->get()
        ->map(fn($item) => (object)[
            'movement_type' => 'Used',
            'quantity' => $item->accessory_qty,
            'from_branch' => optional($item->customer)->name ?? 'Customer',
            'to_branch' => 'Installed',
            'unit' => $unitMap['qty'],
            'created_at' => $item->created_at,
            'route' => route('customer.details', $item->customer_id),
        ]);

    // -------------------- BROKEN (Staff) --------------------
    $assignments = StaffItemAssignment::with(['returns', 'item', 'staff'])
        ->where('item_type', 'accessory')
        ->where('item_id', $id)
        ->where('branch_id', $branchId)
        ->get();

    $brokenMovements = collect();

    foreach ($assignments as $assignment) {
        $unit = $unitMap[$assignment->item->units ?? 'qty'] ?? 'N/A';
        foreach ($assignment->returns as $return) {
            if ($return->broken_qty > 0) {
                $brokenMovements->push((object)[
                    'movement_type' => 'Broken',
                    'quantity' => $return->broken_qty,
                    'from_branch' => optional($assignment->staff)->name ?? 'Staff',
                    'to_branch' => 'Broken',
                    'unit' => $unit,
                    'created_at' => $return->verified_at ?? $return->created_at,
                ]);
            }
        }
    }

    // -------------------- MERGE ALL USED + BROKEN --------------------
    $usedMovements = collect()
        ->merge($customerUsed)
        ->merge($brokenMovements);

    // -------------------- MERGE ALL ACCESSORY MOVEMENTS --------------------
    $accessoryMovements = collect()
        ->merge($purchases)
        ->merge($transfersIn)
        ->merge($transfersOut)
        ->merge($sales)
        ->merge($saleReturns)
        ->merge($usedMovements)
        ->sortByDesc('created_at')
        ->values();

    $totalIn = $accessoryMovements
        ->whereIn('movement_type', ['Purchase', 'Transfer Received', 'Sale Return'])
        ->sum('quantity');

    $totalOut = $accessoryMovements
        ->whereIn('movement_type', ['Transfer Sent', 'Sale', 'Used', 'Broken'])
        ->sum('quantity');

    $remaining = $totalIn - $totalOut;

    return view('inventory::inventories.accessories_details', compact(
        'accessoryMovements',
        'totalIn',
        'totalOut',
        'remaining',
        'accessoryName'
    ));
}




    public function machineries_details($id)
    {
    abort_if(Gate::denies('show_inventory'), 403);

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

        $machinery = Machinery::find($id);
        $machineryName = $machinery ? $machinery->name : 'N/A';

        // PURCHASE
        $purchases = DevicePurchaseMachinery::with('branch', 'machinery', 'purchase')
            ->where('machinery_id', $id)
            ->where('branch_id', $branchId)
            ->get()
            ->map(fn($item) => (object)[
                'movement_type' => 'Purchase',
                'quantity' => $item->quantity,
                'from_branch' => null,
                'to_branch' => optional($item->branch)->name,
                'unit' => $unitMap[optional($item->machinery)->units ?? 'qty'] ?? 'N/A',
                'created_at' => $item->created_at,
                'route' => optional($item->purchase)
                    ? route('device_purchase_machineries_accessories', $item->purchase->id)
                    : '#'
            ]);

        // TRANSFER IN
        $transfersIn = StockTransferMachineries::with(['stockTransfer.fromBranch', 'stockTransfer.toBranch', 'machinery'])
            ->where('machinery_id', $id)
            ->whereHas('stockTransfer', fn($q) => $q->where('to_branch_id', $branchId))
            ->get()
            ->map(fn($item) => (object)[
                'movement_type' => 'Transfer Received',
                'quantity' => $item->quantity,
                'from_branch' => $item->stockTransfer->fromBranch->name ?? null,
                'to_branch' => $item->stockTransfer->toBranch->name ?? null,
                'unit' => $unitMap[$item->machinery->units ?? 'qty'] ?? 'N/A',
                'created_at' => $item->created_at,
                'route' => route('stock-transfers.show', $item->stockTransfer->id),
            ]);

        // TRANSFER OUT
        $transfersOut = StockTransferMachineries::with(['stockTransfer.fromBranch', 'stockTransfer.toBranch', 'machinery'])
            ->where('machinery_id', $id)
            ->whereHas('stockTransfer', fn($q) => $q->where('from_branch_id', $branchId))
            ->get()
            ->map(fn($item) => (object)[
                'movement_type' => 'Transfer Sent',
                'quantity' => $item->quantity,
                'from_branch' => $item->stockTransfer->fromBranch->name ?? null,
                'to_branch' => $item->stockTransfer->toBranch->name ?? null,
                'unit' => $unitMap[$item->machinery->units ?? 'qty'] ?? 'N/A',
                'created_at' => $item->created_at,
                'route' => route('stock-transfers.show', $item->stockTransfer->id),
            ]);

        // SALES
        $sales = SaleMachinery::with(['sale.branch', 'machinery'])
            ->where('machinery_id', $id)
            ->get()
            ->filter(fn($item) => $item->sale && $item->sale->branch_id == $branchId)
            ->map(fn($item) => (object)[
                'movement_type' => 'Sale',
                'quantity' => $item->quantity,
                'from_branch' => null,
                'to_branch' => 'Customer',
                'unit' => $unitMap[$item->machinery->units ?? 'qty'] ?? 'N/A',
                'created_at' => $item->created_at,
                // 'route' => route('sales.details', $item->sale->id)
                'route' => route('sales.show', $item->sale->id),
            ]);

        // USED
        $used = CustomerProduct::with(['customer'])
            ->where('branch_id', $branchId)
            ->where('product_id', $id)
            ->get()
            ->map(fn($item) => (object)[
                'movement_type' => 'Used',
                'quantity' => $item->product_qty,
                'from_branch' => optional($item->customer)->name ?? 'Customer',
                'to_branch' => 'Installed',
                'unit' => $unitMap['qty'],
                'created_at' => $item->created_at,
                'route' => route('customer.details', $item->customer_id),
                // 'route' => route('customer-products.show', $item->id),
            ]);

        // SALE RETURN
        $saleReturns = SaleReturnItem::with(['saleReturn', 'machinery'])
            ->where('machinery_id', $id)
            ->get()
            ->filter(fn($item) => $item->saleReturn && $item->saleReturn->sale && $item->saleReturn->sale->branch_id == $branchId)
            ->map(fn($item) => (object)[
                'movement_type' => 'Sale Return',
                'quantity' => $item->quantity,
                'from_branch' => 'Customer',
                'to_branch' => $item->saleReturn->sale->branch->name ?? null,
                'unit' => $unitMap[$item->machinery->units ?? 'qty'],
                'created_at' => $item->saleReturn->created_at,
                'route' => route('sale-returns.show', $item->saleReturn->id),
            ]);

        $machineryMovements = collect()
            ->merge($purchases)
            ->merge($transfersIn)
            ->merge($transfersOut)
            ->merge($sales)
            ->merge($saleReturns)
            ->merge($used)
            ->sortByDesc('created_at')
            ->values();

        $totalIn = $machineryMovements
            ->whereIn('movement_type', ['Purchase', 'Transfer Received', 'Sale Return'])
            ->sum('quantity');

        $totalOut = $machineryMovements
            ->whereIn('movement_type', ['Transfer Sent', 'Sale', 'Used'])
            ->sum('quantity');

        $remaining = $totalIn - $totalOut;

        return view('inventory::inventories.machineries_details', compact(
            'machineryMovements',
            'totalIn',
            'totalOut',
            'remaining',
            'machineryName'
        ));
    }





    public function technicaltools_details($id)
{
    abort_if(Gate::denies('show_inventory'), 403);

    $branchId = auth()->user()->role['name'] === 'Super Admin'
        ? session('branch_id')
        : auth()->user()->branch_id;

    if (!$branchId) {
        return back()->with('error', 'Please select a branch to view movements.');
    }

    $unitMap = [
        'qty' => 'Quantity',
        'ltr' => 'Liter',
        'kg' => 'Kilogram',
        'meter' => 'Meter',
        'inch' => 'Inch',
        'other' => 'Other'
    ];

    $technicalTool = TechnicalTool::find($id);
    $toolName = $technicalTool ? $technicalTool->tool_name : 'N/A';

    // ---------------------- PURCHASE ----------------------
   $purchases = DevicePurchaseTechnicalTool::with(['branch', 'technicaltools'])
    ->where('technical_tool_id', $id)
    ->where('branch_id', $branchId)
    ->get()
    ->map(function ($item) use ($unitMap) {
        return (object)[
            'movement_type' => 'Purchase',
            'quantity' => $item->quantity,
            'from_branch' => null,
            'to_branch' => optional($item->branch)->name,
            'unit' => $unitMap[optional($item->technicaltools)->units ?? 'qty'] ?? 'N/A',
            'created_at' => $item->created_at,
            'route' => $item->device_purchase_id
                ? route('device_purchase_machineries_accessories', $item->device_purchase_id)
                : '#',
        ];
    });

        

    // ---------------------- TRANSFER IN ----------------------
    $transfersIn = StockTransferTechnicalTool::with(['technicaltools', 'stockTransfer.fromBranch', 'stockTransfer.toBranch'])
        ->where('technical_tool_id', $id)
        ->whereHas('stockTransfer', fn($q) => $q->where('to_branch_id', $branchId))
        ->get()
        ->map(fn($item) => (object)[
            'movement_type' => 'Transfer Received',
            'quantity' => $item->quantity,
            'from_branch' => optional($item->stockTransfer->fromBranch)->name,
            'to_branch' => optional($item->stockTransfer->toBranch)->name,
            'unit' => $unitMap[$item->technicaltools->units ?? 'qty'] ?? 'N/A',
            'created_at' => $item->created_at,
            'route' => route('stock-transfers.show', $item->stockTransfer->id),
        ]);

    // ---------------------- TRANSFER OUT ----------------------
    $transfersOut = StockTransferTechnicalTool::with(['technicaltools', 'stockTransfer.fromBranch', 'stockTransfer.toBranch'])
        ->where('technical_tool_id', $id)
        ->whereHas('stockTransfer', fn($q) => $q->where('from_branch_id', $branchId))
        ->get()
        ->map(fn($item) => (object)[
            'movement_type' => 'Transfer Sent',
            'quantity' => $item->quantity,
            'from_branch' => optional($item->stockTransfer->fromBranch)->name,
            'to_branch' => optional($item->stockTransfer->toBranch)->name,
            'unit' => $unitMap[$item->technicaltools->units ?? 'qty'] ?? 'N/A',
            'created_at' => $item->created_at,
            'route' => route('stock-transfers.show', $item->stockTransfer->id),
        ]);

    // ---------------------- USED / BROKEN ----------------------
    $assignments = StaffItemAssignment::with('returns', 'staff')
        ->where('item_type', 'technical_tool')
        ->where('item_id', $id)
        ->where('branch_id', $branchId)
        ->get();

    $usage = collect();

    foreach ($assignments as $assignment) {
        // Used
       

        // Broken
        foreach ($assignment->returns as $return) {
            if ($return->broken_qty > 0) {
                $broken = clone $return;
                $broken->movement_type = 'Broken';
                $broken->quantity = $return->broken_qty;
                $broken->from_branch = optional($assignment->staff)->name ?? 'Staff';
                $broken->to_branch = 'Returned Broken';
                $broken->unit = $unitMap['qty'];
                $broken->created_at = $return->created_at;
                // $broken->route = route('staff.assignments.show', $assignment->id);
                $usage->push($broken);
            }
        }
    }

    // ---------------------- MERGE MOVEMENTS ----------------------
    $technicalToolMovements = collect()
        ->merge($purchases)
        ->merge($transfersIn)
        ->merge($transfersOut)
        ->merge($usage)
        ->sortByDesc('created_at')
        ->values();

    // ---------------------- TOTALS ----------------------
    $totalIn = $technicalToolMovements
        ->whereIn('movement_type', ['Purchase', 'Transfer Received'])
        ->sum('quantity');

    $totalOut = $technicalToolMovements
        ->whereIn('movement_type', ['Transfer Sent', 'Used', 'Broken'])
        ->sum('quantity');

    $totalUsed = $technicalToolMovements
        ->whereIn('movement_type', ['Used', 'Broken'])
        ->sum('quantity');

    $remaining = $totalIn - $totalOut;

    return view('inventory::inventories.technical_tools_details', compact(
        'technicalToolMovements',
        'totalIn',
        'totalOut',
        'totalUsed',
        'remaining',
        'toolName'
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
