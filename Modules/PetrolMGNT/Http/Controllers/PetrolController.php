<?php

namespace Modules\PetrolMGNT\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\PetrolMGNT\Entities\Bike;
use Modules\PetrolMGNT\Entities\Petrol;

class PetrolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $petrol = Petrol::with('bike')->get();
        $bike = Bike::where('status', 'on')->get();
        return view('petrolmgnt::petrol.index', compact('petrol', 'bike'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('petrolmgnt::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        Petrol::create([
            'bike_id' => $request->bike_id,
            'amount' => $request->amount,
            'date' => $request->date,
            'km' => $request->km,
            'message' => $request->message,
            'created_by' => auth()->user()->id,
            'status' => $request->status
        ]);

        return back()->with('success', 'Petrol For Bike Added Successfully');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('petrolmgnt::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('petrolmgnt::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $petrol = Petrol::findOrfail($id);
        // dd($id);
        $petrol->update([
            'bike_id' => $request->bike_id,
            'amount' => $request->amount,
            'date' => $request->date,
            'km' => $request->km,
            'message' => $request->message,
            'status' => $request->status
        ]);

        return back()->with('success', 'Petrol For Bike Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // dd($id);
        $petrol = Petrol::findOrfail($id);
        $petrol->delete();
        return redirect()->back()->with('success', 'Petrol Deleted!');
    }

    public function Status($id)
    {
        // dd($id);
        $petrol = Petrol::findOrfail($id);
        if ($petrol->status == 'on') {
            $status = 'off';
        } else {
            $status = 'on';
        }
        $petrol->update([
            'status' => $status
        ]);
        return redirect()->back()->with('success', 'Petrol Status Updated!');
    }
}
