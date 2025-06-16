<?php

namespace Modules\PetrolMGNT\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Branch\Entities\Branch;
use Modules\PetrolMGNT\Entities\Bike;
use Modules\PetrolMGNT\Entities\Petrol;
use Modules\Pettycash\Entities\PettyCashAdd;
use Modules\Pettycash\Entities\PettyCashTransaction;

class PetrolController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $branches = Branch::where('status', 'on')->get();

        if ($user->role->name === 'Super Admin') {
            $petrol = Petrol::with('bike.branch')->latest()->get();
            $bike = Bike::with('branch')->where('status', 'on')->get();
        } else {
            $petrol = Petrol::whereHas('bike', function ($query) use ($user) {
                $query->where('branch_id', $user->branch_id);
            })->with('bike.branch')->latest()->get();

            $bike = Bike::with('branch')
                ->where('status', 'on')
                ->where('branch_id', $user->branch_id)
                ->get();
        }

        return view('petrolmgnt::petrol.index', compact('petrol', 'bike', 'branches'));
    }

    public function create()
    {
        return view('petrolmgnt::create');
    }

    public function store(Request $request)
    {
        $image = '';
        if ($request->image) {
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

        if ($request->mode === 'petty cash') {
            $pettyCash = PettyCashAdd::where('branch_id', $branchId)->first();

            if (!$pettyCash) {
                return back()->with('error', 'Petty cash record not found for this branch!');
            }

            if ((float)$request->amount > (float)$pettyCash->remaining_cash) {
                return back()->with('error', 'Insufficient petty cash funds!');
            }
        }

        $petrol = new Petrol();
        $petrol->bike_id = $request->bike_id;
        $petrol->amount = $request->amount;
        $petrol->date = $request->date;
        $petrol->mode = $request->mode;
        $petrol->image = $image;
        $petrol->km = $request->km;
        $petrol->message = $request->message;
        $petrol->created_by = $user->id;
        $petrol->status = $request->status;
        $petrol->save();

        if ($request->mode === 'petty cash') {
            $before = $pettyCash->remaining_cash;
            $after = $before - (float)$petrol->amount;

            $pettyCash->remaining_cash = $after;
            $pettyCash->save();

            PettyCashTransaction::create([
                'branch_id' => $branchId,
                'type' => 'petrol',
                'amount' => $petrol->amount,
                'total_cash_before' => $before,
                'remaining_cash_after' => $after,
                'message' => 'Petrol entry for bike: ' . $bike->bikenumber,
                'reference_id' => $petrol->id,
                'created_by' => $user->id,
            ]);
        }

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

        $user = auth()->user();
        $bike = Bike::with('branch')->find($request->bike_id);

        $branchId = $user->branch_id ?? $bike->branch_id;

        if (!$branchId) {
            return back()->with('error', 'Branch ID not found!');
        }

        $image = $petrol->image;
        if ($request->image) {
            $image = time() . '.' . $request->image->extension();
            $request->image->move(public_path('upload/images/petrol-receipt'), $image);
        }

        $pettyCash = PettyCashAdd::where('branch_id', $branchId)->first();
        if (!$pettyCash) {
            return back()->with('error', 'Petty cash record not found for this branch!');
        }

        if ($oldMode === 'petty cash') {
            $pettyCash->remaining_cash += (float)$oldAmount;
            $pettyCash->save();
        }

        if ($request->mode === 'petty cash' && (float)$request->amount > (float)$pettyCash->remaining_cash) {
            return back()->with('error', 'Insufficient petty cash funds!');
        }

        $petrol->update([
            'bike_id' => $request->bike_id,
            'amount' => $request->amount,
            'date' => $request->date,
            'mode' => $request->mode,
            'image' => $image,
            'km' => $request->km,
            'message' => $request->message,
            'status' => $request->status,
            'created_by' => $user->id,
        ]);

        if ($request->mode === 'petty cash') {
            $before = $pettyCash->remaining_cash;
            $after = $before - (float)$request->amount;

            $pettyCash->remaining_cash = $after;
            $pettyCash->save();

            $transaction = PettyCashTransaction::where('reference_id', $petrol->id)
                ->where('type', 'petrol')
                ->first();

            if ($transaction) {
                $transaction->update([
                    'amount' => $request->amount,
                    'total_cash_before' => $before,
                    'remaining_cash_after' => $after,
                    'message' => 'Petrol entry for bike: ' . optional($bike)->bikenumber,
                    'created_by' => $user->id,
                ]);
            } else {
                PettyCashTransaction::create([
                    'branch_id' => $branchId,
                    'type' => 'petrol',
                    'amount' => $request->amount,
                    'total_cash_before' => $before,
                    'remaining_cash_after' => $after,
                    'message' => 'Petrol entry for bike: ' . optional($bike)->bikenumber,
                    'reference_id' => $petrol->id,
                    'created_by' => $user->id,
                ]);
            }
        } else {
            PettyCashTransaction::where('reference_id', $petrol->id)
                ->where('type', 'petrol')
                ->delete();
        }

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
