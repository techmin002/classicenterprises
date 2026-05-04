<?php

namespace Modules\AMC\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\AMC\Entities\Amc;
use Modules\AMC\Entities\AmcAccessory;
use Modules\Product\Entities\Accessory;
use Illuminate\Support\Facades\Gate;

class AMCController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    abort_if(Gate::denies('access_customers'), 403);
        
        $amcs = Amc::all();
        return view('amc::AmcList.index', compact('amcs'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('amc::AmcList.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        // dd($request->all());
        // Validate request
        $request->validate([
            'title' => 'required|string|max:255',
            'year' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // dd('hello');
        DB::beginTransaction();

        try {
            // Image upload
            $image = '';
            if ($request->image) {
                $image = time() . '.' . $request->image->extension();
                $request->image->move(public_path('upload/images/Amc'), $image);
            }

            // Create AMC record
            $amc = Amc::create([
                'title' => $request->title,
                'year' => $request->year,
                'price' => $request->price,
                'description' => $request->description,
                'image' => $image,
                'status' => $request->has('status') ? 'on' : 'off',
            ]);

            // if ($request->has('accessories_id') && is_array($request->accessories_id)) {
            //     foreach ($request->accessories_id as $index => $accessoryId) {
            //         $quantity = $request->accessories_qty[$index] ?? 1;

            //         AmcAccessory::create([
            //             'amc_id' => $amc->id,
            //             'accessory_id' => $accessoryId,
            //             'quantity' => $quantity,
            //         ]);
            //     }
            // }

            // Log::create([
            //     'perform'   => auth()->user()->name . ' created Amc: '
            //         . $request->title . ' at ' . now(),
            //     'user_id'   => auth()->user()->id,
            //     'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            //     'url'       => url()->current(),
            // ]);

            DB::commit();
            return redirect()->route('amc.index')->with('success', 'AMC created successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
    /**
     * Show the specified resource.
     */
    // public function show($id)
    // {
    //     $amc = Amc::with(['accessories.accessory'])->findOrFail($id);
    //     return view('amc::AmcList.details', compact('amc'));
    // }


    /**
     * Show the form for editing the specified resource.
     */
    // public function edit($id)
    // {
    //     $amc = Amc::findOrFail($id);
    //     $accessories = Accessory::where('status', 'on')->get();

    //     $attachedAccessories = DB::table('amc_accessories')
    //         ->where('amc_id', $amc->id)
    //         ->get()
    //         ->map(function ($item) {
    //             $accessory = Accessory::find($item->accessory_id);
    //             $item->accessory_name = $accessory ? $accessory->name : 'Unknown';
    //             return $item;
    //         });

    //     Log::create([
    //         'perform'   => auth()->user()->name . ' created Amc: '
    //             . $amc->title . ' at ' . now(),
    //         'user_id'   => auth()->user()->id,
    //         'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
    //         'url'       => url()->current(),
    //     ]);
    //     return view('amc::AmcList.edit', compact('amc', 'accessories', 'attachedAccessories'));
    // }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate request
        $request->validate([
            'title' => 'required|string|max:255',
            'year' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $amc = Amc::findOrFail($id);

            // Handle image upload
            $image = $amc->image;
            if ($request->hasFile('image')) {
                // Optionally delete old image if exists
                if ($amc->image && file_exists(public_path('upload/images/Amc/' . $amc->image))) {
                    unlink(public_path('upload/images/Amc/' . $amc->image));
                }

                $image = time() . '.' . $request->image->extension();
                $request->image->move(public_path('upload/images/Amc'), $image);
            }

            // Update AMC record
            $amc->update([
                'title' => $request->title,
                'year' => $request->year,
                'price' => $request->price,
                'description' => $request->description,
                'image' => $image,
                'status' => $request->has('status') ? 'on' : 'off',
            ]);

            // // Delete old accessories
            // AmcAccessory::where('amc_id', $amc->id)->delete();

            // // Insert updated accessories
            // if ($request->has('accessories_id') && is_array($request->accessories_id)) {
            //     foreach ($request->accessories_id as $index => $accessoryId) {
            //         $quantity = $request->accessories_qty[$index] ?? 1;

            //         AmcAccessory::create([
            //             'amc_id' => $amc->id,
            //             'accessory_id' => $accessoryId,
            //             'quantity' => $quantity,
            //         ]);
            //     }
            // }

            Log::create([
                'perform'   => auth()->user()->name . ' created Amc: '
                    . $request->title . ' at ' . now(),
                'user_id'   => auth()->user()->id,
                'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
                'url'       => url()->current(),
            ]);

            DB::commit();
            return redirect()->route('amc.index')->with('success', 'AMC updated successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }


    public function Status($id)
    {
        // dd($id);
        $amc = AMC::findOrfail($id);
        $oldstatus = $amc->status;
        if ($amc->status == 'on') {
            $status = 'off';
        } else {
            $status = 'on';
        }
        $amc->update([
            'status' => $status
        ]);
        Log::create([
            'perform'   => auth()->user()->name . ' changed AMC status: '
                . $amc->title . ' from ' . $oldstatus
                . ' to ' . $status . ' at ' . now(),
            'user_id'   => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url'       => url()->current(),
        ]);
        return redirect()->back()->with('success', 'AMC Status Updated!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // dd($id);
        $delete = Amc::findOrfail($id);
        $delete->delete();
        Log::create([
            'perform'   => auth()->user()->name . ' delete AMC '
                . $delete->title . ' at ' . now(),
            'user_id'   => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url'       => url()->current(),
        ]);
        return redirect()->back()->with('success', 'AMC  Deleted!');
    }


    public function getAmcAmount($id)
    {
        $amc = AMC::find($id);
        if ($amc) {
            return response()->json(['amount' => $amc->price]);
        }
        return response()->json(['amount' => 0]);
    }
}
