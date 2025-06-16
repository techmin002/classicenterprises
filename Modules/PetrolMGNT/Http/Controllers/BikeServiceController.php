<?php

namespace Modules\PetrolMGNT\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Branch\Entities\Branch;
use Modules\PetrolMGNT\Entities\Bike;
use Modules\PetrolMGNT\Entities\BikeService;
use Modules\Pettycash\Entities\PettyCashAdd;
use Modules\Pettycash\Entities\PettyCashTransaction;

class BikeServiceController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $branches = Branch::where('status', 'on')->get();

        if ($user->role->name === 'Super Admin') {
            $service = BikeService::with('bike.branch')->latest()->get();
            $bike = Bike::with('branch')->where('status', 'on')->get();
        } else {
            $service = BikeService::whereHas('bike', function ($query) use ($user) {
                $query->where('branch_id', $user->branch_id);
            })->with('bike.branch')->latest()->get();

            $bike = Bike::with('branch')
                ->where('status', 'on')
                ->where('branch_id', $user->branch_id)
                ->get();
        }

        return view('petrolmgnt::service.index', compact('service', 'bike', 'branches'));
    }

    public function store(Request $request)
    {
        $image = '';
        if ($request->image) {
            $image = time() . '.' . $request->image->extension();
            $request->image->move(public_path('upload/images/service-receipt'), $image);
        }

        $user = auth()->user();
        $bike = Bike::findOrFail($request->bike_id);
        $branchId = $user->branch_id ?? $bike->branch_id;

        if ($request->mode === 'petty cash') {
            $pettyCash = PettyCashAdd::where('branch_id', $branchId)->first();

            if (!$pettyCash || $request->amount > $pettyCash->remaining_cash) {
                return back()->with('error', 'Insufficient petty cash balance.');
            }
        }

        $bikeService = new BikeService();
        $bikeService->bike_id = $request->bike_id;
        $bikeService->amount = $request->amount;
        $bikeService->date = $request->date;
        $bikeService->mode = $request->mode;
        $bikeService->image = $image;
        $bikeService->km = $request->km;
        $bikeService->message = $request->message;
        $bikeService->status = $request->status;
        $bikeService->created_by = $user->id;
        $bikeService->save();

        if ($request->mode === 'petty cash') {
            $before = $pettyCash->remaining_cash;
            $after = $before - $request->amount;

            $pettyCash->remaining_cash = $after;
            $pettyCash->save();

            PettyCashTransaction::create([
                'branch_id' => $branchId,
                'type' => 'bike_service',
                'amount' => $request->amount,
                'total_cash_before' => $before,
                'remaining_cash_after' => $after,
                'message' => 'Bike service for: ' . $bike->bikenumber,
                'reference_id' => $bikeService->id,
                'created_by' => $user->id,
            ]);
        }

        return back()->with('success', 'Bike Service Added Successfully.');
    }

    public function update(Request $request, $id)
    {
        $service = BikeService::findOrFail($id);
        $user = auth()->user();
        $bike = Bike::findOrFail($request->bike_id);
        $branchId = $user->branch_id ?? $bike->branch_id;

        $oldAmount = $service->amount;
        $oldMode = $service->mode;

        $image = $service->image;
        if ($request->image) {
            $image = time() . '.' . $request->image->extension();
            $request->image->move(public_path('upload/images/service-receipt'), $image);
        }

        $pettyCash = PettyCashAdd::where('branch_id', $branchId)->first();

        if (!$pettyCash) {
            return back()->with('error', 'Petty cash record not found.');
        }

        // Restore previous petty cash amount if old mode was petty cash
        if ($oldMode === 'petty cash') {
            $pettyCash->remaining_cash += $oldAmount;
            $pettyCash->save();
        }

        if ($request->mode === 'petty cash' && $request->amount > $pettyCash->remaining_cash) {
            return back()->with('error', 'Insufficient petty cash funds.');
        }

        $service->update([
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
            $after = $before - $request->amount;

            $pettyCash->remaining_cash = $after;
            $pettyCash->save();

            $transaction = PettyCashTransaction::where('reference_id', $service->id)
                ->where('type', 'bike_service')
                ->first();

            if ($transaction) {
                $transaction->update([
                    'amount' => $request->amount,
                    'total_cash_before' => $before,
                    'remaining_cash_after' => $after,
                    'message' => 'Bike service for: ' . $bike->bikenumber,
                ]);
            } else {
                PettyCashTransaction::create([
                    'branch_id' => $branchId,
                    'type' => 'bike_service',
                    'amount' => $request->amount,
                    'total_cash_before' => $before,
                    'remaining_cash_after' => $after,
                    'message' => 'Bike service for: ' . $bike->bikenumber,
                    'reference_id' => $service->id,
                    'created_by' => $user->id,
                ]);
            }
        } else {
            PettyCashTransaction::where('reference_id', $service->id)
                ->where('type', 'bike_service')
                ->delete();
        }

        return back()->with('success', 'Bike Service Updated Successfully.');
    }

    public function destroy($id)
    {
        $service = BikeService::findOrFail($id);
        $bike = Bike::find($service->bike_id);
        $branchId = auth()->user()->branch_id ?? optional($bike)->branch_id;

        if ($service->mode === 'petty cash') {
            $pettyCash = PettyCashAdd::where('branch_id', $branchId)->first();
            if ($pettyCash) {
                $pettyCash->remaining_cash += $service->amount;
                $pettyCash->save();
            }

            PettyCashTransaction::where('reference_id', $service->id)
                ->where('type', 'bike_service')
                ->delete();
        }

        $service->delete();
        return back()->with('success', 'Bike Service Deleted.');
    }

    public function show($id)
    {
        return view('petrolmgnt::show');
    }

    public function edit($id)
    {
        return view('petrolmgnt::edit');
    }
    public function status($id)
{
    $service = BikeService::findOrFail($id);
    $status = $service->status === 'on' ? 'off' : 'on';
    $service->update(['status' => $status]);

    return redirect()->back()->with('success', 'Bike Service Status Updated!');
}

}
