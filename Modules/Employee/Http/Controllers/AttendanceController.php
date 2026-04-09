<?php

namespace Modules\Employee\Http\Controllers;

use App\Models\Log;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Employee\Entities\Employee;
use Modules\Employee\Entities\EmployeeAttendance;
use Modules\Employee\Entities\EmployeeAttendanceRequest;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $employee = Employee::where('user_id', auth()->user()->id)->first();
        $attendance = EmployeeAttendance::where('employee_id', $employee->id)->orderby('created_at', 'DESC')->get();
        return view('employee::attendance.index', compact('attendance'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('employee::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('employee::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('employee::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
   public function checkin($id)
{
    $employee = Employee::where('user_id', $id)->first();

    if (!$employee) {
        return back()->with('error', 'Employee not found!');
    }

    $today = Carbon::today();

    // Check if already checked in today
    $attendance = EmployeeAttendance::where('employee_id', $employee->id)
        ->whereDate('date', $today)
        ->first();

    if ($attendance) {
        return back()->with('error', 'You have already checked in today!');
    }

    $now = Carbon::now();

    EmployeeAttendance::create([
        'employee_id' => $employee->id,
        'branch_id'   => $employee->branch_id,
        'check_in'    => $now,
        'check_out'   => null,
        'date'        => $today,
        'status'      => 'checkin'
    ]);

    return back()->with('success', 'You Check In Successfully');
}

 public function checkinStatus($id)
{
    $employee = Employee::where('user_id', auth()->user()->id)->first();

    if (!$employee) {
        return response()->json([
            'checked_in' => false,
            'checkin_time' => null
        ]);
    }

    $todayAttendance = EmployeeAttendance::where('employee_id', $employee->id)
        ->whereDate('date', Carbon::today())
        ->first();

    return response()->json([
        'checked_in' => !is_null($todayAttendance),
        'checkin_time' => $todayAttendance ? $todayAttendance->check_in : null
    ]);
}
public function checkout($id)
{
    $employee = Employee::where('user_id', auth()->user()->id)->first();

    if (!$employee) {
        return back()->with('error', 'Employee not found!');
    }

    $today = Carbon::today();

    // Get today's attendance
    $attendance = EmployeeAttendance::where('employee_id', $employee->id)
        ->whereDate('date', $today)
        ->first();

    // Must check-in first
    if (!$attendance) {
        return back()->with('error', 'You must check in first!');
    }

    // Already checked out
    if (!is_null($attendance->check_out)) {
        return back()->with('error', 'You have already checked out today!');
    }

    $attendance->update([
        'check_out' => Carbon::now(),
        'status'    => 'checkout'
    ]);

    return back()->with('success', 'You Check Out Successfully');
}
 public function checkinRequest()
{
    if (auth()->user()->role['name'] != 'Super Admin') {

        $employee = Employee::where('user_id', auth()->user()->id)->first();

        if (!$employee) {
            return back()->with('error', 'Employee not found!');
        }

        $checkin = EmployeeAttendanceRequest::with('employee')
            ->where('employee_id', $employee->id)
            ->where('request_type', 'checkin')
            ->latest()
            ->get();

    } else {

        $checkin = EmployeeAttendanceRequest::with('employee')
            ->where('request_type', 'checkin')
            ->latest()
            ->get();
    }

    return view('employee::attendance.checkinrequest', compact('checkin'));
}
public function checkinRequestStore(Request $request)
{
    $employee = Employee::where('user_id', auth()->user()->id)->first();

    if (!$employee) {
        return back()->with('error', 'Employee not found!');
    }

    $employeeId = $employee->id;
    $date = Carbon::parse($request['checkin'])->format('Y-m-d');

    // ❌ BLOCK: Already attendance exists (VERY IMPORTANT FIX)
    $attendanceExists = EmployeeAttendance::where('employee_id', $employeeId)
        ->whereDate('date', $date)
        ->exists();

    if ($attendanceExists) {
        return back()->with('error', 'You already marked attendance for this date!');
    }

    // ❌ BLOCK: Already requested
    $requestExists = EmployeeAttendanceRequest::where('employee_id', $employeeId)
        ->where('request_type', 'checkin')
        ->whereDate('date', $date)
        ->exists();

    if ($requestExists) {
        return back()->with('error', 'You already requested check-in for this date!');
    }

    EmployeeAttendanceRequest::create([
        'employee_id' => $employeeId, // ✅ FIXED
        'date'        => $request['checkin'],
        'branch_id'   => $employee->branch_id,
        'message'     => $request['message'],
        'request_type'=> 'checkin',
    ]);

    return back()->with('success', 'Check-in request submitted successfully');
}
    

    public function checkinRequestStatus(Request $request)
{
    $id = $request->query('id');
    $status = $request->query('status');

    $checkinRequest = EmployeeAttendanceRequest::findOrFail($id);
    $date = Carbon::parse($checkinRequest->date)->format('Y-m-d');

    if ($status === 'accept') {

        $attendance = EmployeeAttendance::where('employee_id', $checkinRequest->employee_id)
            ->whereDate('date', $date)
            ->first();

       if ($attendance && $attendance->check_in) {
    return back()->with('error', 'Attendance already exists for this date!');
}

        if ($attendance) {
            $attendance->update([
                'check_in' => $checkinRequest->date,
                'status'   => 'checkin'
            ]);
        } else {
            EmployeeAttendance::create([
                'employee_id' => $checkinRequest->employee_id,
                'branch_id'   => $checkinRequest->branch_id,
                'check_in'    => $checkinRequest->date,
                'check_out'   => null,
                'date'        => $date,
                'status'      => 'checkin',
            ]);
        }

        $checkinRequest->update(['status' => 'accept']);

        return back()->with('success', 'Check-in request accepted');
    }

    $checkinRequest->update(['status' => 'reject']);

    return back()->with('success', 'Check-in request rejected');
}

    public function checkoutRequest()
{
    if (auth()->user()->role['name'] != 'Super Admin') {

        // ✅ Get correct employee
        $employee = Employee::where('user_id', auth()->user()->id)->first();

        if (!$employee) {
            return back()->with('error', 'Employee not found!');
        }

        $checkout = EmployeeAttendanceRequest::where('employee_id', $employee->id) // ✅ FIXED
            ->where('request_type', 'checkout')
            ->with('employee') // ✅ load relation
            ->latest()
            ->get();

    } else {

        $checkout = EmployeeAttendanceRequest::where('request_type', 'checkout')
            ->with('employee') // ✅ for admin view
            ->latest()
            ->get();
    }

    // ✅ Log (clean)
    Log::create([
        'perform'   => auth()->user()->name . ' viewed Check-Out requests at ' . now(),
        'user_id'   => auth()->user()->id,
        'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
        'url'       => url()->current(),
    ]);

    return view('employee::attendance.checkoutrequest', compact('checkout'));
}
public function checkoutRequestStore(Request $request)
{
    $employee = Employee::where('user_id', auth()->user()->id)->first();

    if (!$employee) {
        return back()->with('error', 'Employee not found!');
    }

    $employeeId = $employee->id;
    $date = Carbon::parse($request['checkout'])->format('Y-m-d');

    $attendance = EmployeeAttendance::where('employee_id', $employeeId)
        ->whereDate('date', $date)
        ->first();

    // ❌ BLOCK: No check-in exists (MAIN FIX)
    if (!$attendance || !$attendance->check_in) {
        return back()->with('error', 'You must check-in first before requesting check-out!');
    }

    // ❌ BLOCK: Already completed attendance
    if ($attendance->check_in && $attendance->check_out) {
        return back()->with('error', 'You already completed attendance for this date!');
    }

    // ❌ BLOCK: Already requested checkout
    $requestExists = EmployeeAttendanceRequest::where('employee_id', $employeeId)
        ->where('request_type', 'checkout')
        ->whereDate('date', $date)
        ->exists();

    if ($requestExists) {
        return back()->with('error', 'You already requested check-out for this date!');
    }

    // ✅ CREATE REQUEST
    EmployeeAttendanceRequest::create([
        'employee_id' => $employeeId,
        'date'        => $request['checkout'],
        'branch_id'   => $employee->branch_id,
        'message'     => $request['message'],
        'request_type'=> 'checkout',
    ]);

    return back()->with('success', 'Check-out request submitted successfully');
}
public function checkoutRequestStatus(Request $request)
{
    $id = $request->query('id');
    $status = $request->query('status');

    $checkoutRequest = EmployeeAttendanceRequest::findOrFail($id);
    $date = Carbon::parse($checkoutRequest->date)->format('Y-m-d');

    if ($status === 'accept') {

        $attendance = EmployeeAttendance::where('employee_id', $checkoutRequest->employee_id)
            ->whereDate('date', $date)
            ->first();

        // ❌ No check-in
        if (!$attendance || !$attendance->check_in) {
            return back()->with('error', 'Cannot checkout without check-in!');
        }

        if ($attendance && $attendance->check_out) {
    return back()->with('error', 'Already checked out for this date!');
}

        $attendance->update([
            'check_out' => $checkoutRequest->date,
            'status'    => 'checkout'
        ]);

        $checkoutRequest->update(['status' => 'accept']);

        return back()->with('success', 'Check-out request accepted');
    }

    $checkoutRequest->update(['status' => 'reject']);

    return back()->with('success', 'Check-out request rejected');
}
    public function attendanceAll()
    {
        $attendance = EmployeeAttendance::orderby('created_at', 'DESC')->get();
        return view('employee::attendance.all', compact('attendance'));
    }
}
