<?php

namespace Modules\PetrolMGNT\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\PetrolMGNT\Entities\Bike;

class BikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bike = Bike::all();
        return view('petrolmgnt::bike.index', compact('bike'));
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
        Bike::create([
            'name' => $request->name,
            'model' => $request->model,
            'bikenumber' => $request->bikenumber,
            'created_by' => auth()->user()->id,
            'status' => $request->status
        ]);

        return back()->with('success', 'Bike Added Successfully');
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
        $bike = Bike::findOrFail($id);
        // dd($bike);
        $bike->update([
            'name' => $request->name,
            'model' => $request->model,
            'bikenumber' => $request->bikenumber,
            'status' => $request->status
        ]);

        return back()->with('success', 'Bike Details Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // dd($id);
        $bike = Bike::findOrfail($id);
        $bike->delete();
        return redirect()->back()->with('success', 'Bike Deleted!');
    }

    public function Status($id)
    {
        // dd($id);
        $bike = Bike::findOrfail($id);
        if ($bike->status == 'on') {
            $status = 'off';
        } else {
            $status = 'on';
        }
        $bike->update([
            'status' => $status
        ]);
        return redirect()->back()->with('success', 'Bike Status Updated!');
    }
}
