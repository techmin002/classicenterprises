<?php

namespace Modules\PetrolMGNT\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Http\Request;
use Modules\Branch\Entities\Branch;
use Modules\PetrolMGNT\Entities\Bike;
use Modules\PetrolMGNT\Entities\Petrol;
use Modules\PetrolMGNT\Entities\PetrolPump;
use Modules\Pettycash\Entities\PettyCashAdd;
use Modules\Pettycash\Entities\PettyCashTransaction;

class PetrolController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $branches = Branch::where('status', 'on')->get();
        $petrolPumps = PetrolPump::all();

        if ($user->role->name === 'Super Admin') {
            $bike = Bike::with('branch')->where('status', 'on')->get();
        } else {
            $bike = Bike::with('branch')
                ->where('status', 'on')
                ->where('branch_id', $user->branch_id)
                ->get();
        }

        $petrol = Petrol::with('bike.branch')
            ->when($user->role->name !== 'Super Admin', function ($query) use ($user) {
                $query->whereHas('bike', function ($q) use ($user) {
                    $q->where('branch_id', $user->branch_id);
                });
            })
            ->latest()
            ->get();

        return view('petrolmgnt::petrol.index', compact('petrol', 'bike', 'branches', 'petrolPumps'));
    }


    public function create()
    {
        return view('petrolmgnt::create');
    }

    public function store(Request $request)
    {
        $image = '';
        if ($request->hasFile('image')) {
            $image = time() . '.' . $request->image->extension();
            $request->image->move(public_path('upload/images/petrol-receipt'), $image);
        }

        $user = auth()->user();
        $bike = Bike::with('branch')->find($request->bike_id);

        if (!$bike) {
            return back()->with('error', 'Bike not found!');
        }

        $branchId = $user->branch_id ?? $bike->branch_id;

        if (!$branchId) {
            return back()->with('error', 'Branch ID not found!');
        }

        // Get selected date's month and year
        $selectedDate = \Carbon\Carbon::parse($request->date);
        $selectedMonth = $selectedDate->format('m'); // e.g. "07"
        $selectedYear = $selectedDate->format('Y');

        $pettyCash = null;
        $before = null;
        $after = null;

        if ($request->payment_type === 'payment' && $request->mode === 'petty cash') {
            // Fetch petty cash entry for that branch and month (using DATE field now)
            $pettyCash = PettyCashAdd::where('branch_id', $branchId)
                ->whereMonth('date', $selectedMonth)
                ->whereYear('date', $selectedYear)
                ->first();

            if (!$pettyCash) {
                return back()->with('error', 'No petty cash found for this branch and selected month!');
            }

            if ((float)$request->amount > (float)$pettyCash->remaining_cash) {
                return back()->with('error', 'Insufficient petty cash balance!');
            }

            $before = $pettyCash->remaining_cash;
            $after = $before - (float)$request->amount;
        }


        // Create petrol entry
        $petrol = new Petrol();
        $petrol->bike_id = $request->bike_id;
        $petrol->amount = $request->amount;
        $petrol->date = $request->date;
        $petrol->km = $request->km;
        $petrol->message = $request->message;
        $petrol->image = $image;
        $petrol->status = $request->status;
        $petrol->created_by = $user->id;

        $petrol->payment_type = $request->payment_type;

        if ($request->payment_type === 'payment') {
            $petrol->mode = $request->mode;
            $petrol->cheque_number = $request->mode === 'cheque' ? $request->cheque_number : null;
            $petrol->petrol_pump = null;
        } elseif ($request->payment_type === 'token') {
            $petrol->mode = 'token';
            $petrol->cheque_number = null;
            $petrol->petrol_pump = $request->petrol_pump;
        }

        $petrol->save();

        // Deduct petty cash and log transaction
        if ($request->payment_type === 'payment' && $request->mode === 'petty cash') {
            $pettyCash->remaining_cash = $after;
            $pettyCash->save();

            PettyCashTransaction::create([
                'branch_id' => $branchId,
                'type' => 'petrol',
                'amount' => $request->amount,
                'total_cash_before' => $before,
                'remaining_cash_after' => $after,
                'message' => 'Petrol entry for bike: ' . $bike->bikenumber,
                'reference_id' => $petrol->id,
                'created_by' => $user->id,
            ]);
        }


        $bikeName = $petrol->bike->name ?? 'N/A';

        Log::create([
            'perform'   => auth()->user()->name
                . ' Petrol assign : ' . $bikeName
                . ' at ' . now(),
            'user_id'   => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url'       => url()->current(),
        ]);

        return back()->with('success', 'Petrol For Bike Added Successfully');
    }


    public function show($id)
    {
        return view('petrolmgnt::show');
    }

    public function edit($id)
    {
        return view('petrolmgnt::edit');
    }

    public function update(Request $request, $id)
    {
        $petrol = Petrol::findOrFail($id);

        $oldAmount = $petrol->amount;
        $oldMode = $petrol->mode;
        $oldPaymentType = $petrol->payment_type;

        $user = auth()->user();
        $bike = Bike::with('branch')->find($request->bike_id);

        if (!$bike) {
            return back()->with('error', 'Bike not found!');
        }

        $branchId = $user->branch_id ?? $bike->branch_id;

        if (!$branchId) {
            return back()->with('error', 'Branch ID not found!');
        }

        $image = $petrol->image;
        if ($request->hasFile('image')) {
            $image = time() . '.' . $request->image->extension();
            $request->image->move(public_path('upload/images/petrol-receipt'), $image);
        }

        // Get selected date month & year
        $serviceDate = \Carbon\Carbon::parse($request->date);
        $selectedMonth = $serviceDate->format('m');
        $selectedYear = $serviceDate->format('Y');

        // Restore old petty cash if applicable
        if ($oldPaymentType === 'payment' && $oldMode === 'petty cash') {
            $oldPettyCash = PettyCashAdd::where('branch_id', $branchId)
                ->whereMonth('date', $serviceDate->format('m'))
                ->whereYear('date', $serviceDate->format('Y'))
                ->first();

            if ($oldPettyCash) {
                $oldPettyCash->remaining_cash += (float)$oldAmount;
                $oldPettyCash->save();
            }
        }

        // Fetch new petty cash if mode is petty cash
        $pettyCash = null;
        $before = null;
        $after = null;

        if ($request->payment_type === 'payment' && $request->mode === 'petty cash') {
            $pettyCash = PettyCashAdd::where('branch_id', $branchId)
                ->whereMonth('date', $selectedMonth)
                ->whereYear('date', $selectedYear)
                ->first();

            if (!$pettyCash) {
                return back()->with('error', 'No petty cash found for this branch and selected month!');
            }

            if ((float)$request->amount > (float)$pettyCash->remaining_cash) {
                return back()->with('error', 'Insufficient petty cash balance!');
            }

            $before = $pettyCash->remaining_cash;
            $after = $before - (float)$request->amount;

            $pettyCash->remaining_cash = $after;
            $pettyCash->save();
        }

        // Update petrol
        $petrol->bike_id = $request->bike_id;
        $petrol->amount = $request->amount;
        $petrol->date = $request->date;
        $petrol->km = $request->km;
        $petrol->message = $request->message;
        $petrol->image = $image;
        $petrol->status = $request->status;
        $petrol->created_by = $user->id;
        $petrol->payment_type = $request->payment_type;

        if ($request->payment_type === 'payment') {
            $petrol->mode = $request->mode;
            $petrol->cheque_number = $request->mode === 'cheque' ? $request->cheque_number : null;
            $petrol->petrol_pump = null;
        } elseif ($request->payment_type === 'token') {
            $petrol->mode = 'token';
            $petrol->cheque_number = null;
            $petrol->petrol_pump = $request->petrol_pump;
        }

        $petrol->save();

        // Petty cash transaction update
        if ($request->payment_type === 'payment' && $request->mode === 'petty cash') {
            PettyCashTransaction::updateOrCreate(
                ['reference_id' => $petrol->id, 'type' => 'petrol'],
                [
                    'branch_id' => $branchId,
                    'amount' => $request->amount,
                    'total_cash_before' => $before,
                    'remaining_cash_after' => $after,
                    'message' => 'Updated petrol entry for bike: ' . optional($bike)->bikenumber,
                    'reference_id' => $petrol->id,
                    'created_by' => $user->id,
                ]
            );
        } else {
            PettyCashTransaction::where('reference_id', $petrol->id)
                ->where('type', 'petrol')
                ->delete();
        }

        $bikeName = $petrol->bike->name ?? 'N/A';

        Log::create([
            'perform'   => auth()->user()->name
                . ' Petrol assign Update : ' . $bikeName
                . ' at ' . now(),
            'user_id'   => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url'       => url()->current(),
        ]);
        return back()->with('success', 'Petrol For Bike Updated Successfully');
    }




    public function destroy($id)
    {
        $petrol = Petrol::findOrFail($id);
        $bike = Bike::find($petrol->bike_id);
        $branchId = auth()->user()->branch_id ?? optional($bike)->branch_id;

        if ($petrol->mode === 'petty cash' && $branchId) {
            $pettyCash = PettyCashAdd::where('branch_id', $branchId)->first();

            if ($pettyCash) {
                $pettyCash->remaining_cash += (float)$petrol->amount;
                $pettyCash->save();
            }

            PettyCashTransaction::where('reference_id', $petrol->id)
                ->where('type', 'petrol')
                ->delete();
        }


        Log::create([
            'perform'   => auth()->user()->name
                . ' Delete Petrol Assign for : ' . $bike
                . ' at ' . now(),
            'user_id'   => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url'       => url()->current(),
        ]);

        $petrol->delete();
        return redirect()->back()->with('success', 'Petrol Deleted!');
    }

    public function Status($id)
    {
        $petrol = Petrol::findOrFail($id);
        $status = $petrol->status == 'on' ? 'off' : 'on';
        $petrol->update(['status' => $status]);

        return redirect()->back()->with('success', 'Petrol Status Updated!');
    }
}
