<?php

namespace Modules\AMC\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\AMC\Entities\AMC;
use Modules\AMC\Entities\AmcAccessory;
use Modules\AMC\Entities\AmcAssign;
use Modules\AMC\Entities\AmcAssignAccessory;
use Modules\Lead\Entities\Customer;
use Modules\Lead\Entities\Lead;

class AmcAssignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $amcs = AmcAssign::all();
        return view('amc::AmcAssign.index', compact('amcs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::with('lead')->get(); // get active customers with lead
        $amcs = AMC::where('status', 'on')->get(); // get active AMCs
        $leads = Lead::all(); // optional, if needed

        return view('amc::AmcAssign.create', compact('customers', 'amcs', 'leads'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $image = '';
            if ($request->image) {
                $image = time() . '.' . $request->image->extension();
                $request->image->move(public_path('upload/images/AmcAssign'), $image);
            }

            $assign = new AmcAssign();
            $assign->customer_id = $request->customer_id;
            $assign->amc_id = $request->amc_id;
            $assign->payment_method = $request->payment_method;
            $assign->date = $request->date;
            $assign->status = $request->has('status') ? 'on' : 'off';

            if ($request->payment_method === 'Cheque') {
                $assign->cheque_no = $request->cheque_number;
            }

            if ($request->payment_method === 'online' && $request->hasFile('image')) {
                $assign->image = $image;
            }

            $assign->save();

            // ✅ Store AMC Accessories into amc_assign_accessories
            $amcAccessories = AmcAccessory::where('amc_id', $request->amc_id)->get();

            foreach ($amcAccessories as $amcAcc) {
                AmcAssignAccessory::create([
                    'amc_assign_id' => $assign->id,
                    'customer_id'   => $request->customer_id,
                    'amc_id'        => $request->amc_id,
                    'accessory_id'  => $amcAcc->accessory_id,
                    'quantity'      => $amcAcc->quantity,
                ]);
            }

            DB::commit();

            return redirect()->route('amcassign.index')->with('success', 'AMC assigned successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error occurred: ' . $e->getMessage());
        }
    }


    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('amc::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = AmcAssign::findOrFail($id);
        $customers = Customer::with('lead')->get(); // get active customers with lead
        $amcs = AMC::where('status', 'on')->get(); // get active AMCs
        $leads = Lead::all(); // optional, if needed

        return view('amc::AmcAssign.edit', compact('customers', 'amcs', 'leads', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $assign = AmcAssign::findOrFail($id);

        // Default image value
        $image = $assign->image;

        // Handle image if payment method is online and image is uploaded
        if ($request->payment_method === 'online' && $request->hasFile('image')) {
            // Delete old image if exists
            if ($assign->image && file_exists(public_path('upload/images/AmcAssign/' . $assign->image))) {
                unlink(public_path('upload/images/AmcAssign/' . $assign->image));
            }

            // Upload new image
            $image = time() . '.' . $request->image->extension();
            $request->image->move(public_path('upload/images/AmcAssign'), $image);
        }

        // If payment method is not online, remove the image
        if ($request->payment_method !== 'online') {
            if ($assign->image && file_exists(public_path('upload/images/AmcAssign/' . $assign->image))) {
                unlink(public_path('upload/images/AmcAssign/' . $assign->image));
            }
            $image = null;
        }

        // Update fields
        $assign->customer_id = $request->customer_id;
        $assign->amc_id = $request->amc_id;
        $assign->payment_method = $request->payment_method;
        $assign->date = $request->date;
        $assign->status = $request->has('status') ? 'on' : 'off';
        $assign->image = $image;

        // Handle Cheque Number
        if ($request->payment_method === 'Cheque') {
            $assign->cheque_no = $request->cheque_no;
        } else {
            $assign->cheque_no = '';
        }

        $assign->save();

        return redirect()->route('amcassign.index')->with('success', 'AMC assignment updated successfully.');
    }


    public function Status($id)
    {
        // dd($id);
        $amc = AmcAssign::findOrfail($id);
        if ($amc->status == 'on') {
            $status = 'off';
        } else {
            $status = 'on';
        }
        $amc->update([
            'status' => $status
        ]);
        return redirect()->back()->with('success', 'AMC Assign Status Updated!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // dd($id);
        $delete = AmcAssign::findOrfail($id);
        $delete->delete();
        return redirect()->back()->with('success', 'AMC Assign  Deleted!');
    }
}
