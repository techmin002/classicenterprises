<?php

namespace Modules\Pettycash\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\Pettycash\Entities\PettyCashRequest;
use Illuminate\Support\Str;


class PettyCashRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd(Auth::user()->role->name);
        if (Auth::user()->role->name === 'Super Admin') {
            $requests = PettyCashRequest::with('branch')->get();
        } else {
            // dd('hello');
            $requests = PettyCashRequest::where('branch_id', Auth::user()->branch_id)
                ->with('branch')
                ->get();
        }

        return view('pettycash::cash_request.index', compact('requests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pettycash::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'month' => 'required|string',
            'description' => 'nullable|string',
        ]);

        // dd(Auth::user()->branch_id);
        PettyCashRequest::create([
            'branch_id' => Auth::user()->branch_id,
            'title' => $validated['title'],
            'amount' => $validated['amount'],
            'date' => $validated['date'],
            'month' => $validated['month'],
            'description' => $validated['description'] ?? null
        ]);

        return redirect()->route('pettycash-request.index')->with('success', 'Request submitted!');
    }


    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('pettycash::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('pettycash::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $cashRequest = PettyCashRequest::findOrFail($id);

        $cashRequest->update([
            'title' => $request->input('title'),
            'amount' => $request->input('amount'),
            'date' => $request->input('date'),
            'month' => $request->input('month'),
            'description' => $request->input('description') ?? null,
        ]);

        return back()->with('success', 'Petty cash Request updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $request = PettyCashRequest::findOrfail($id);
        $request->delete();
        return redirect()->back()->with('success', 'Petty Cash Request Deleted!');
    }


    public function reject($id)
    {
        $request = PettyCashRequest::findOrFail($id);
        $request->status = 'rejected';
        $request->save();

        return redirect()->back()->with('success', 'Request rejected.');
    }
}
