<?php

namespace Modules\Pettycash\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Log;
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
    public function index(Request $request)
    {
        $user = Auth::user();
        $branchId = $user->role->name === 'Super Admin'
            ? session('branch_id')
            : $user->branch_id;

        // Base query
        $query = PettyCashRequest::with('branch')
            ->where('branch_id', $branchId);

        // Apply filter if present
        if ($request->has('filter')) {
            $days = (int) $request->filter;
            $query->where('created_at', '>=', now()->subDays($days));
        }

        $requests = $query->get();

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
            'description' => 'nullable|string',
        ]);

        PettyCashRequest::create([
            'branch_id' => Auth::user()->branch_id,
            'title' => $validated['title'],
            'amount' => $validated['amount'],
            'requested_by' => auth()->user()->id,
            'date' => $validated['date'],
            'description' => $validated['description'] ?? null,
        ]);
        Log::create([
            'perform' => auth()->user()->name . ' Petty cash Requested ' . now(),
            'user_id' => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url' => url()->current(),
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
