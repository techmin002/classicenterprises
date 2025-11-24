<?php

namespace Modules\PetrolMGNT\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Branch\Entities\Branch;
use Modules\PetrolMGNT\Entities\Bike;
use Modules\PetrolMGNT\Entities\BikeService;
use Modules\PetrolMGNT\Entities\PetrolPump;
use Modules\PetrolMGNT\Entities\ServiceCenter;
use Modules\Pettycash\Entities\PettyCashAdd;
use Modules\Pettycash\Entities\PettyCashTransaction;

class BikeServiceController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $branches = Branch::where('status', 'on')->get();
        $servicecenter = ServiceCenter::all();

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

        // 🛠 Pass petrolPumps to view
        return view('petrolmgnt::service.index', compact('service', 'bike', 'branches', 'servicecenter'));
    }

    public function store(Request $request)
    {
        $image = '';
        if ($request->hasFile('image')) {
            $image = time() . '.' . $request->image->extension();
            $request->image->move(public_path('upload/images/service-receipt'), $image);
        }

        $user = auth()->user();
        $bike = Bike::findOrFail($request->bike_id);
        $branchId = $user->branch_id ?? $bike->branch_id;

        if (!$branchId) {
            return back()->with('error', 'Branch ID not found!');
        }

        // Extract month/year from selected date
        $serviceDate = \Carbon\Carbon::parse($request->date);
        $selectedMonth = $serviceDate->format('m');
        $selectedYear = $serviceDate->format('Y');

        $pettyCash = null;
        $before = null;
        $after = null;

        if ($request->payment_type === 'payment' && $request->mode === 'petty cash') {
            // Fetch petty cash using date's month/year (no month column now)
            $pettyCash = PettyCashAdd::where('branch_id', $branchId)
                ->whereMonth('date', $selectedMonth)
                ->whereYear('date', $selectedYear)
                ->first();

            if (!$pettyCash) {
                return back()->with('error', 'No petty cash available for this branch and selected date\'s month.');
            }

            if ((float)$request->amount > (float)$pettyCash->remaining_cash) {
                return back()->with('error', 'Insufficient petty cash balance.');
            }

            $before = $pettyCash->remaining_cash;
            $after = $before - (float)$request->amount;
        }

        $bikeService = new BikeService();
        $bikeService->bike_id = $request->bike_id;
        $bikeService->branch_id = $branchId;
        $bikeService->amount = $request->amount;
        $bikeService->date = $request->date;
        $bikeService->km = $request->km;
        $bikeService->message = $request->message;
        $bikeService->image = $image;
        $bikeService->status = $request->status;
        $bikeService->created_by = $user->id;
        $bikeService->payment_type = $request->payment_type;

        if ($request->payment_type === 'payment') {
            $bikeService->mode = $request->mode;
            $bikeService->cheque_number = $request->mode === 'cheque' ? $request->cheque_number : null;
            $bikeService->service_center = null;
        } elseif ($request->payment_type === 'token') {
            $bikeService->mode = 'token';
            $bikeService->cheque_number = null;
            $bikeService->service_center = $request->service_center;
        }

        $bikeService->save();

        // Deduct from petty cash if applicable
        if ($request->payment_type === 'payment' && $request->mode === 'petty cash') {
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
        $oldPaymentType = $service->payment_type;

        $image = $service->image;
        if ($request->hasFile('image')) {
            $image = time() . '.' . $request->image->extension();
            $request->image->move(public_path('upload/images/service-receipt'), $image);
        }

        // Extract month/year from new selected date
        $newDate = \Carbon\Carbon::parse($request->date);
        $selectedMonth = $newDate->format('m');
        $selectedYear = $newDate->format('Y');

        $pettyCash = PettyCashAdd::where('branch_id', $branchId)
            ->whereMonth('date', $selectedMonth)
            ->whereYear('date', $selectedYear)
            ->first();

        // Revert previous petty cash if old was petty cash
        if ($oldPaymentType === 'payment' && $oldMode === 'petty cash' && $pettyCash) {
            $pettyCash->remaining_cash += (float)$oldAmount;
            $pettyCash->save();
        }

        $before = null;
        $after = null;

        // Check and deduct new petty cash if required
        if ($request->payment_type === 'payment' && $request->mode === 'petty cash') {
            if (!$pettyCash) {
                return back()->with('error', 'No petty cash found for this branch and selected date\'s month.');
            }

            if ((float)$request->amount > (float)$pettyCash->remaining_cash) {
                return back()->with('error', 'Insufficient petty cash balance.');
            }

            $before = $pettyCash->remaining_cash;
            $after = $before - (float)$request->amount;
            $pettyCash->remaining_cash = $after;
            $pettyCash->save();
        }

        // Update Bike Service record
        $service->update([
            'bike_id' => $request->bike_id,
            'branch_id' => $branchId,
            'amount' => $request->amount,
            'date' => $request->date,
            'mode' => $request->mode === 'cheque' ? 'cheque' : ($request->mode ?? 'token'),
            'cheque_number' => $request->mode === 'cheque' ? $request->cheque_number : null,
            'service_center' => $request->payment_type === 'token' ? $request->service_center : null,
            'payment_type' => $request->payment_type,
            'image' => $image,
            'km' => $request->km,
            'message' => $request->message,
            'status' => $request->status,
            'created_by' => $user->id,
        ]);

        // Handle petty cash transaction log
        if ($request->payment_type === 'payment' && $request->mode === 'petty cash') {
            PettyCashTransaction::updateOrCreate(
                ['reference_id' => $service->id, 'type' => 'bike_service'],
                [
                    'branch_id' => $branchId,
                    'amount' => $request->amount,
                    'total_cash_before' => $before,
                    'remaining_cash_after' => $after,
                    'message' => 'Bike service for: ' . $bike->bikenumber,
                    'created_by' => $user->id,
                ]
            );
        } else {
            // Delete previous transaction if no longer petty cash
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

        // if ($service->mode === 'petty cash') {
        //     $pettyCash = PettyCashAdd::where('branch_id', $branchId)->first();
        //     if ($pettyCash) {
        //         $pettyCash->remaining_cash += $service->amount;
        //         $pettyCash->save();
        //     }

        //     PettyCashTransaction::where('reference_id', $service->id)
        //         ->where('type', 'bike_service')
        //         ->delete();
        // }

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
    public function getBikesByBranch(Request $request)
    {
        $bikes = Bike::where('branch_id', $request->branch_id)
            ->where('status', 'on')
            ->get(['id', 'bikenumber']);

        return response()->json($bikes);
    }
}
