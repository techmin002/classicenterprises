<?php

namespace Modules\AMC\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\AMC\Entities\Amc;
use Modules\AMC\Entities\AmcAccessory;
use Modules\AMC\Entities\AmcAssign;
use Modules\AMC\Entities\AmcAssignAccessory;
use Modules\AMC\Entities\AmcCustomer;
use Modules\Lead\Entities\Customer;
use Modules\Lead\Entities\Lead;

class AmcAssignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->role['name'] === 'Super Admin') {
            $branch_id = session('branch_id');
        } else {
            $branch_id = auth()->user()->branch_id;
        }
        $customers = Customer::where('branch_id', $branch_id)->get();
        $amcs = Amc::where('status', 'on')->get();

        $register = AmcCustomer::with(['customer', 'amc'])->where('branch_id', $branch_id)->where('type', 'register')->latest()->get();
        $outsider = AmcCustomer::with('amc')->where('branch_id', $branch_id)->where('type', 'outsider')->latest()->get();
        return view('amc::AmcAssign.index', compact('amcs', 'customers', 'register', 'outsider'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::with('lead')->get(); // get active customers with lead
        $amcs = AMC::where('status', 'on')->get(); // get active AMCs

        return view('amc::AmcAssign.create', compact('customers', 'amcs', 'leads'));
    }

    public function Registerassign()
    {
        if (auth()->user()->role['name'] === 'Super Admin') {
            $branch_id = session('branch_id');
        } else {
            $branch_id = auth()->user()->branch_id;
        }
        $users = User::where('branch_id', $branch_id)->get();
        $customers = Customer::where('branch_id', $branch_id)->get();
        $amcs = Amc::where('status', 'on')->get();
        return view('amc::AmcAssign.register_create', compact('amcs', 'customers', 'users'));
    }

    public function Outsiderassign()
    {
        if (auth()->user()->role['name'] === 'Super Admin') {
            $branch_id = session('branch_id');
        } else {
            $branch_id = auth()->user()->branch_id;
        }

        $users = User::where('branch_id', $branch_id)->get();
        $customers = Customer::where('branch_id', $branch_id)->get();
        $amcs = Amc::where('status', 'on')->get();
        return view('amc::AmcAssign.outsider_create', compact('amcs', 'customers', 'users'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        if (auth()->user()->role['name'] === 'Super Admin') {
            $branch_id = session('branch_id');
            $branchcode=session('branch_code');
        } else {
            $branch_id = auth()->user()->branch_id;
            $branchcode=auth()->user()->branch_code;
        }
        dd
        if ($request->customer_id) {
            $customer = Customer::with('lead')->findOrFail($request->customer_id);
            $userName = strtoupper(auth()->user()->branch . $request->customer_name);
        }
        // dd($request->customer_id);
        // 🧾 Handle Receipts
        if ($request->hasFile('cash_receipt')) {
            $cashFile = $request->file('cash_receipt');
            $cashFileName = $cashFile->getClientOriginalName();
            $cashFile->move(public_path('receipts/AmcAssign'), $cashFileName);
        } else {
            $cashFileName = NULL;
        }

        if ($request->hasFile('online_receipt')) {
            $onlineFile = $request->file('online_receipt');
            $onlineFileName = $onlineFile->getClientOriginalName();
            $onlineFile->move(public_path('receipts/AmcAssign'), $onlineFileName);
        } else {
            $onlineFileName = NULL;
        }

        if ($request->hasFile('cheque_receipt')) {
            $chequeFile = $request->file('cheque_receipt');
            $chequeFileName = $chequeFile->getClientOriginalName();
            $chequeFile->move(public_path('receipts/AmcAssign'), $chequeFileName);
        } else {
            $chequeFileName = NULL;
        }
        AmcCustomer::create([
            'customer_id' => $request->customer_id,
            'customer_name'   => $request->customer_name,
            'email'   => $request->email,
            'contact'   => $request->contact,
            'landline'   => $request->landline,
            'sales'   => $request->sales,
            'product_name'   => $request->product_name,
            'address'   => $request->address,
            'type' => $request->customer_type,
            'amc_id'        => $request->amc_id,
            'branch_id'        => $branch_id,
            'date'        => $request->date,
            'last_date'        => $request->date,
            'amount'        => $request->amount,

            // 🧾 Payment Section
            'payment_status'    => $request->payment_status,
            'payment_method'    => $request->payment_method,

            // 💰 Cash Payment
            'cash_amount'       => $request->cash_amount ?? 0,
            'cash_receipt'      => $cashFileName,

            // 💳 Online Payment
            'online_amount'     => $request->online_amount ?? 0,
            'online_receipt'    => $onlineFileName,

            // 🧾 Cheque Payment
            'cheque_amount'     => $request->cheque_amount ?? 0,
            'cheque_number'     => $request->cheque_number,
            'cheque_receipt'    => $chequeFileName,

            'message'        => $request->message,

        ]);

        if ($request->customer_id) {
            $customer = Customer::findOrFail($request->customer_id);
            $customer->amc = 'yes';
            $customer->amc_date = Carbon::now();
            $customer->save();
        }

        return redirect()->route('amcassign.index')->with('success', 'AMC Assign successfully.');
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
        $leads = Lead::all();

        return view('amc::AmcAssign.edit', compact('customers', 'amcs', 'leads', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, $id)
    // {
    //     $assign = AmcAssign::findOrFail($id);

    //     // Default image value
    //     $image = $assign->image;

    //     // Handle image if payment method is online and image is uploaded
    //     if ($request->payment_method === 'online' && $request->hasFile('image')) {
    //         // Delete old image if exists
    //         if ($assign->image && file_exists(public_path('upload/images/AmcAssign/' . $assign->image))) {
    //             unlink(public_path('upload/images/AmcAssign/' . $assign->image));
    //         }

    //         // Upload new image
    //         $image = time() . '.' . $request->image->extension();
    //         $request->image->move(public_path('upload/images/AmcAssign'), $image);
    //     }

    //     // If payment method is not online, remove the image
    //     if ($request->payment_method !== 'online') {
    //         if ($assign->image && file_exists(public_path('upload/images/AmcAssign/' . $assign->image))) {
    //             unlink(public_path('upload/images/AmcAssign/' . $assign->image));
    //         }
    //         $image = null;
    //     }

    //     // Update fields
    //     $assign->customer_id = $request->customer_id;
    //     $assign->amc_id = $request->amc_id;
    //     $assign->payment_method = $request->payment_method;
    //     $assign->date = $request->date;
    //     $assign->status = $request->has('status') ? 'on' : 'off';
    //     $assign->image = $image;

    //     // Handle Cheque Number
    //     if ($request->payment_method === 'Cheque') {
    //         $assign->cheque_no = $request->cheque_no;
    //     } else {
    //         $assign->cheque_no = '';
    //     }

    //     $assign->save();
    //     // 🔹 Log entry
    //     Log::create([
    //         'perform'   => auth()->user()->name
    //             . ' updated AMC: ' . $assign->amc->title
    //             . ' at ' . now(),
    //         'user_id'   => auth()->user()->id,
    //         'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
    //         'url'       => url()->current(),
    //     ]);

    //     return redirect()->route('amcassign.index')->with('success', 'AMC assignment updated successfully.');
    // }


    public function Status($id)
    {
        // dd($id);
        $amc = AmcAssign::findOrfail($id);
        $oldStatus = $amc->status;
        if ($amc->status == 'on') {
            $status = 'off';
        } else {
            $status = 'on';
        }
        $amc->update([
            'status' => $status
        ]);


        // 🔹 Log entry
        Log::create([
            'perform'   => auth()->user()->name
                . ' changed AMC :' . $amc->amc->title
                . ' | Status: ' . $oldStatus . ' → ' . $status
                . ' at ' . now(),
            'user_id'   => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url'       => url()->current(),
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
        Log::create([
            'perform'   => auth()->user()->name
                . ' delete AMC :' . $delete->amc->title
                . ' at ' . now(),
            'user_id'   => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url'       => url()->current(),
        ]);
        return redirect()->back()->with('success', 'AMC Assign  Deleted!');
    }

    public function getAmcList($type)
    {

        if ($type === 'register') {
            $amcs = AmcAssign::all();
        } else {
            $amcs = AmcAssign::all();
        }

        $html = view('amc::amcassign.table', compact('amcs', 'type'))->render();

        return response()->json(['html' => $html]);
    }
}
