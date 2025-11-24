<?php

namespace Modules\Finance\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Finance\Entities\ClosingBalance;
use Modules\Finance\Entities\DepositeAmount;
use Modules\Finance\Entities\Payment;
use Modules\Lead\Entities\CustomerPayment;

class DailyCOllectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $date = $request->input('date') ?? Carbon::today()->toDateString();
        // dd($date, Payment::first());

        $alreadyClosed = ClosingBalance::whereDate('date', Carbon::today())->exists();
        // Filter by created_at instead of payment_date
        $collections = Payment::whereDate('created_at', $date)
            ->where('payment_method', 'cash')
            ->get();

        $grandTotal = $collections->sum('amount');
        $balance = ClosingBalance::where('status', 'pending')
            ->whereDate('date', now()->toDateString())
            ->first();
        return view('finance::dailycollection.index', compact('collections', 'grandTotal', 'date', 'alreadyClosed', 'balance'));
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
    public function storeClosingAmount(Request $request)
    {
        $date = Carbon::today()->toDateString();

        // Prevent duplicate for same day
        if (ClosingBalance::where('date', $date)->exists()) {
            return redirect()->back()->with('error', 'Closing amount already stored for today.');
        }

        ClosingBalance::create([
            'amount' => $request->input('amount'),
            'date' => $date,
        ]);

        return redirect()->back()->with('success', 'Closing amount saved.');
    }

    public function depositedHistorystore(Request $request)
    {
        $image = '';
        if ($request->hasFile('image')) {
            // dd($request->all());
            $image = time() . '.' . $request->image->extension();
            $request->image->move(public_path('upload/images/deposite-amount'), $image);
        }
        // dd('hello');
        // 1. Store deposit in DepositeAmount table
        DepositeAmount::create([
            'amount' => $request->amount,
            'bank_name' => $request->bank,
            'image' => $image,
            'date' => now(),
        ]);

        // 2. Update today's closing balance status to 'off'
        ClosingBalance::whereDate('date', today())->update(['status' => 'deposited']);

        return redirect()->back()->with('success', 'Deposit recorded and closing balance updated.');
    }
    public function depositedHistory()
    {
        $history = DepositeAmount::orderBy('date', 'desc')->get();
        return view('finance::dailycollection.deposited', compact('history'));
    }
    public function AllCollection()
    {
        $allcollections = Payment::where('payment_method', 'cash')
            ->orderBy('created_at', 'asc') // Ascending order by date
            ->get();
        $total = $allcollections->sum('amount');
        return view('finance::dailycollection.allcollection', compact('allcollections','total'));
    }
}
