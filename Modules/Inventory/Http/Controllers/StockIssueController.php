<?php

namespace Modules\Inventory\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Inventory\Entities\StockIssue;
use Modules\Inventory\Entities\StockIssueAccessory;
use Modules\Inventory\Entities\StockIssueMachinery;
use Modules\Inventory\Entities\StockIssueTechnicalTool;
use Modules\Product\Entities\Accessory;
use Modules\Product\Entities\Machinery;
use Modules\Product\Entities\TechnicalTools;

class StockIssueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $machineries = Machinery::select('id', 'name')->get();
        $accessories = Accessory::select('id', 'name')->get();
        $technicalTools = TechnicalTools::select('id', 'tool_name as name')->get();

        $stockIssues = StockIssue::with('user')->latest()->get();
        return view('inventory::stockissue.index', compact(
            'machineries',
            'accessories',
            'technicalTools',
            'stockIssues'
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        // dd($request->all());
        // 1. Create Stock Issue
        $issue = StockIssue::create([
            'message' => $request->message,
            'requested_by' => auth()->id(),
            'status' => 'pending'
        ]);

        // 2. Store Machineries
        if ($request->has('machineries')) {
            foreach ($request->machineries as $machinery) {
                if (!empty($machinery['id']) && !empty($machinery['qty'])) {
                    StockIssueMachinery::create([
                        'stock_issue_id' => $issue->id,
                        'machinery_id' => $machinery['id'],
                        'quantity' => $machinery['qty'],
                    ]);
                }
            }
        }
        // 3. Store Accessories
        if ($request->accessories) {
            foreach ($request->accessories as $accessory) {
                if (!empty($accessory['id']) && !empty($accessory['qty'])) {
                    StockIssueAccessory::create([
                        'stock_issue_id' => $issue->id,
                        'accessory_id' => $accessory['id'],
                        'quantity' => $accessory['qty'],
                    ]);
                }
            }
        }


        // 4. Store Technical Tools
        if ($request->has('technical_tools')) {
            foreach ($request->technical_tools as $tool) {
                if (!empty($tool['id']) && !empty($tool['qty'])) {
                    StockIssueTechnicalTool::create([
                        'stock_issue_id' => $issue->id,
                        'technical_tool_id' => $tool['id'],
                        'quantity' => $tool['qty'],
                    ]);
                }
            }
        }
        return back()->with('success', 'Stock Issue Request Created Successfully');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('inventory::show');
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
    public function update(Request $request, $id)
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

    public function reject($id)
    {
        $request = StockIssue::findOrFail($id);
        $request->status = 'rejected';
        $request->save();

        return redirect()->back()->with('success', 'Request rejected.');
    }
    public function accept($id)
    {
        $request = StockIssue::findOrFail($id);
        $request->status = 'accepted';
        $request->save();

        return redirect()->back()->with('success', 'Request rejected.');
    }
}
