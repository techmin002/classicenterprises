<?php

namespace Modules\Employee\Http\Controllers;

use App\Models\Log;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Branch\Entities\Branch;
use Modules\Employee\Entities\Employee;
use Modules\Employee\Entities\Leave;
use Modules\Employee\Entities\LeaveType;
  use Carbon\Carbon;
use Modules\Employee\Entities\EmployeeAttendance;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
   public function index()
{
    $leaves = Leave::with(['employee', 'leaveType', 'branch'])
        ->orderBy('created_at', 'DESC')
        ->get();

    $categories = LeaveType::where('status', 'on')->get();
    $branches = Branch::where('status', 'on')->get();

    return view('employee::leaves.index', compact('leaves', 'categories', 'branches'));
}

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('Leave::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
 public function store(Request $request)
{
    $user = auth()->user();

    $employee = Employee::where('user_id', $user->id)->first();

    if (!$employee) {
        return back()->with('error', 'Employee not found!');
    }

    Leave::create([
        'title'         => $request->title,
        'employee_id'   => $employee->id,
        'leave_type_id' => $request->leave_type_id,
        'branch_id'     => $employee->branch_id,
        'start_date'    => $request->start_date,
        'end_date'      => $request->end_date,
        'message'       => $request->message, // ✅ FIXED
        'status'        => 'pending',
    ]);

    Log::create([
        'perform'   => $user->name . ' Leave Created for: ' . $employee->name . ' at ' . now(),
        'user_id'   => $user->id,
        'branch_id' => session('branch_id') ?? $user->branch_id,
        'url'       => url()->current(),
    ]);

    return back()->with('success', 'Leave Added Successfully');
}

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('Leave::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('Leave::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $expense = Leave::findOrfail($id);

        $expense->title = $request->title;
        $expense->leave_type_id = $request->leave_type_id;
        $expense->start_date = $request->start_date;
        $expense->end_date = $request->end_date;
        $expense->message = $request->message;
        $expense->status = 'pending';
        $expense->save();
        Log::create([
            'perform'   => auth()->user()->name
                . ' Leave Update: ' . $expense->title
                . ' at ' . now(),
            'user_id'   => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url'       => url()->current(),
        ]);

        return back()->with('success', 'leaves Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $categorys = Leave::findOrfail($id);
        $categorys->delete();
        Log::create([
            'perform'   => auth()->user()->name
                . ' Leave Update: ' . $categorys->title
                . ' at ' . now(),
            'user_id'   => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url'       => url()->current(),
        ]);
        return redirect()->back()->with('success', 'Expense Deleted!');
    }
 



public function Status(Request $request, $id)
{
    $status = $request['status'];

    $leave = Leave::with(['employee', 'leaveType'])->findOrFail($id);
    $oldstatus = $leave->status;

    if ($status == 'accept') {
        $start = Carbon::parse($leave->start_date);
        $end   = Carbon::parse($leave->end_date);

        // Total requested leave days
        $requestedDays = $start->diffInDays($end) + 1;

        // Allowed days from leave type
        $allowedDays = $leave->leaveType->leaves ?? 0;

        // Approve only up to allowed days
        $approvedDays = min($requestedDays, $allowedDays);

        // Calculate the actual end date for approved leave
        $approvedEnd = $start->copy()->addDays($approvedDays - 1);

        // Loop and save each approved day as leave
        for ($date = $start; $date->lte($approvedEnd); $date->addDay()) {
            $exists = EmployeeAttendance::where('employee_id', $leave->employee_id)
                ->whereDate('date', $date->format('Y-m-d'))
                ->first();

            if ($exists) continue;

            EmployeeAttendance::create([
                'employee_id' => $leave->employee_id,
                'branch_id'   => $leave->branch_id,
                'check_in'    => null,
                'check_out'   => null,
                'date'        => $date->format('Y-m-d'),
                'status'      => 'leave',
            ]);
        }
    }

    // Update leave status
    $leave->update([
        'status' => $status
    ]);

    // Log the action
    Log::create([
        'perform'   => auth()->user()->name
            . ' Changed Leave Status: ' . $leave->title
            . ' ' . $oldstatus . ' -> ' . $status
            . ' at ' . now(),
        'user_id'   => auth()->user()->id,
        'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
        'url'       => url()->current(),
    ]);

    // Show message about approved days
    if ($requestedDays > $allowedDays) {
        return back()->with('success', "Leave accepted for {$approvedDays} day(s). Extra requested days were not counted.");
    }

    return back()->with('success', 'Leave accepted successfully.');
}
}
