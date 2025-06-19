<?php

namespace Modules\Finance\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Lead\Entities\CustomerPayment;

class DailyCOllectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $today = \Carbon\Carbon::today();

        $collections = \Modules\Lead\Entities\CustomerPayment::with(['customer.lead'])
            ->whereDate('created_at', $today)
            ->get();

        $grandTotal = $collections->sum('paid_amount');

        return view('finance::dailycollection.index', compact('collections', 'grandTotal'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('finance::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('finance::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('finance::edit');
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
}
