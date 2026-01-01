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

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('inventory::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inventory::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function accessories_details($id)
    {

        if (auth()->user()->role['name'] === 'Super Admin') {
            $branchId = session('branch_id');
        } else {
            $branchId = auth()->user()->branch_id;
        }
        $accessories = DevicePurchaseAccessory::with(['accessories', 'branch'])
            ->where('accessory_id', $id)
            ->where('branch_id', $branchId)
            ->get();
        $transferAccessories = StockTransferAccessories::with([
            'accessory',
            'stockTransfer.fromBranch',
            'stockTransfer.toBranch',
            'stockTransfer.user',
        ])
            ->where('accessory_id', $id)
            ->whereHas('stockTransfer', function ($q) use ($branchId) {
                $q->where('to_branch_id', $branchId);
            })
            ->get();

        return view('inventory::inventories.accessories_details', compact('accessories', 'transferAccessories'));
    }

    public function machineries_details($id)
    {

        if (auth()->user()->role['name'] === 'Super Admin') {
            $branchId = session('branch_id');
        } else {
            $branchId = auth()->user()->branch_id;
        }

        $machineries = DevicePurchaseMachinery::with(['machineries', 'branch'])
            ->where('machinery_id', $id)
            ->where('branch_id', $branchId)
            ->get();
        $transferMachineries = StockTransferMachineries::with([
            'machinery',
            'stockTransfer.fromBranch',
            'stockTransfer.toBranch',
            'stockTransfer.user',
        ])
            ->where('machinery_id', $id)
            ->whereHas('stockTransfer', function ($q) use ($branchId) {
                $q->where('to_branch_id', $branchId);
            })
            ->get();

        return view('inventory::inventories.machineries_details', compact('machineries', 'transferMachineries'));
    }

    public function technicaltools_details($id)
    {

        // dd($id);
        if (auth()->user()->role['name'] === 'Super Admin') {
            $branchId = session('branch_id');
        } else {
            $branchId = auth()->user()->branch_id;
        }

        $technicaltools = DevicePurchaseTechnicalTool::with(['technicaltools', 'branch'])
            ->where('technical_tool_id', $id)
            ->where('branch_id', $branchId)
            ->get();

        $transferTechnicaltools = StockTransferTechnicalTool::with([
            'technicaltools',
            'stockTransfer.fromBranch',
            'stockTransfer.toBranch',
            'stockTransfer.user',
        ])
            ->where('technical_tool_id', $id)
            ->whereHas('stockTransfer', function ($q) use ($branchId) {
                $q->where('to_branch_id', $branchId);
            })
            ->get();

        return view('inventory::inventories.technical_tools_details', compact('technicaltools', 'transferTechnicaltools'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('inventory::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
