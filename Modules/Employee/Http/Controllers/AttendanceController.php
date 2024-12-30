<?php

namespace Modules\Employee\Http\Controllers;

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
        $employee = Employee::where('user_id', $id)->with('user')->first();

        $datetime = Carbon::now();
        $date = $datetime->format('Y-m-d');
        $employeeAttendance = EmployeeAttendance::create([
            'employee_id' => $employee->id,
            'branch_id' => $employee->branch_id,
            'check_in' => $datetime,
            'check_out' => null,
            'date' => $date,
            'status' => 'checkin'
        ]);
        return back()->with('success', 'You Check In Successfully');
    }
    public function checkinStatus($id)
    {
        $employee = Employee::where('user_id', auth()->user()->id)->first();
        $Attendance = EmployeeAttendance::where('employee_id', $employee->id)->first();

        $todayCheckin = $Attendance->whereDate('check_in', Carbon::today())
            ->where('status', 'checkin')->first();
        return response()->json([
            'checked_in' => !is_null($todayCheckin), // true if checked in today
            'checkin_time' => $todayCheckin ? $todayCheckin->created_at->toDateTimeString() : null
        ]);
    }
    public function checkout($id)
    {
        $employee = Employee::where('user_id', auth()->user()->id)->first();
        $Attendance = EmployeeAttendance::where('employee_id', $employee->id)->orderby('created_at', 'DESC')->first();
        $Attendance->update([
            'check_out' => Carbon::now(),
            'status' => 'checkout'
        ]);
        return back()->with('success', 'You Check Out Successfully');
    }
    public function checkinRequest()
    {
        if (auth()->user()->role['name'] != 'Super Admin') {
            $userId = auth()->user()->id;
            $checkin = EmployeeAttendanceRequest::where('employee_id', auth()->user()->id)->where('request_type', 'checkin')->with('employee')->orderby('created_at', 'DESC')->get();
        } else {
            $checkin = EmployeeAttendanceRequest::where('request_type', 'checkin')->with('employee')->orderby('created_at', 'DESC')->get();
        }
        return view('employee::attendance.checkinrequest', compact('checkin'));
    }
    public function checkinRequestStore(Request $request)
    {
        $checkinRequest = EmployeeAttendanceRequest::create([
            'employee_id' => auth()->user()->id,
            'date' => $request['checkin'],
            'branch_id' => auth()->user()->branch_id,
            'message' => $request['message'],
            'request_type' => 'checkin',
        ]);
        return back()->with('success', 'Checkin Request Added is successfully');
    }
    public function checkinRequestStatus(Request $request)
    {
        $id = $request->query('id');
        $status = $request->query('status');

        // Find the check-in request or fail
        $checkinRequest = EmployeeAttendanceRequest::findOrFail($id);

        // Parse the request date for comparison
        $date = Carbon::parse($checkinRequest->date)->format('Y-m-d');

        if ($status === 'accept') {
            // Find existing attendance for the employee on the given date
            $empAttendance = EmployeeAttendance::where('employee_id', $checkinRequest->employee_id)
                ->whereDate('date', $date)
                ->first();

            if (!$empAttendance) {
                // No attendance record for the date, create a new one
                EmployeeAttendance::create([
                    'check_in' => $checkinRequest->date,
                    'employee_id' => $checkinRequest->employee_id,
                    'branch_id' => $checkinRequest->branch_id,
                    'check_out' => null,
                    'date' => $date,
                    'status' => 'checkin',
                ]);
            } else {
                // Attendance record exists, update the check-in time
                $empAttendance->update([
                    'check_in' => $checkinRequest->date,
                ]);
            }

            // Update the check-in request status to accepted
            $checkinRequest->update(['status' => 'accept']);

            return back()->with('success', 'Check-In Request Accepted Successfully');
        } else {
            // Reject the request
            $checkinRequest->update(['status' => 'reject']);

            return back()->with('success', 'Check-In Request Rejected');
        }
    }

    public function checkoutRequestStatus(Request $request)
    {
        $id = $request->query('id');
        $status = $request->query('status');

        // Find the checkout request or fail
        $checkoutRequest = EmployeeAttendanceRequest::findOrFail($id);

        // Parse the request date for comparison
        $date = Carbon::parse($checkoutRequest->date)->format('Y-m-d');

        if ($status === 'accept') {
            // Find existing attendance for the employee on the given date
            $empAttendance = EmployeeAttendance::where('employee_id', $checkoutRequest->employee_id)
                ->whereDate('date', $date)
                ->first();

            if ($empAttendance) {
                // Update the check-out time if attendance exists
                $empAttendance->update([
                    'check_out' => $checkoutRequest->date,
                ]);
            } else {
                // No attendance record for the date, create a new one with check-out
                EmployeeAttendance::create([
                    'check_in' => null,
                    'check_out' => $checkoutRequest->date,
                    'employee_id' => $checkoutRequest->employee_id,
                    'branch_id' => $checkoutRequest->branch_id,
                    'date' => $date,
                    'status' => 'checkout',
                ]);
            }

            // Update the checkout request status to accepted
            $checkoutRequest->update(['status' => 'accept']);

            return back()->with('success', 'Check-Out Request Accepted Successfully');
        } else {
            // Reject the request
            $checkoutRequest->update(['status' => 'reject']);

            return back()->with('success', 'Attendance Request Rejected');
        }
    }

    public function checkoutRequest()
    {
        if (auth()->user()->role['name'] != 'Super Admin') {
            $userId = auth()->user()->id;
            $checkout = EmployeeAttendanceRequest::where('employee_id', auth()->user()->id)->where('request_type', 'checkout')->orderby('created_at', 'DESC')->get();
        } else {
            $checkout = EmployeeAttendanceRequest::where('request_type', 'checkout')->orderby('created_at', 'DESC')->get();
        }
        return view('employee::attendance.checkoutrequest', compact('checkout'));
    }
    public function checkoutRequestStore(Request $request)
    {
        $checkoutRequest = EmployeeAttendanceRequest::create([
            'employee_id' => auth()->user()->id,
            'date' => $request['checkout'],
            'branch_id' => auth()->user()->branch_id,
            'message' => $request['message'],
            'request_type' => 'checkout',
        ]);
        return back()->with('success', 'Checkout Request Added is successfully');
    }
    public function attendanceAll()
    {
        $attendance = EmployeeAttendance::orderby('created_at', 'DESC')->get();
        return view('employee::attendance.all', compact('attendance'));
    }
}
