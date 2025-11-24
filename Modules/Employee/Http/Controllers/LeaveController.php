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

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $leaves = Leave::orderBy('created_at', 'DESC')->get();
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

        $employee = Employee::where('user_id', auth()->user->id)->first();
        $expense = new Leave();
        $expense->title = $request->title;
        $expense->employee_id = $employee->id ?? 1;
        $expense->leave_type_id = $request->leave_type_id;
        $expense->branch_id = $employee->branch_id ?? 1;
        $expense->start_date = $request->start_date;
        $expense->end_date = $request->end_date;
        $expense->message = $request->message;
        $expense->status = 'pending';
        $expense->save();
        Log::create([
            'perform'   => auth()->user()->name
                . ' Leave Created for: ' . $employee->name
                . ' at ' . now(),
            'user_id'   => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url'       => url()->current(),
        ]);

        return back()->with('success', 'leaves Added Successfully');
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
        $categorys = Leave::findOrfail($id);
        $oldstatus = $categorys->status;
        $categorys->update([
            'status' => $status
        ]);
        Log::create([
            'perform'   => auth()->user()->name
                . ' Changed Status' . $categorys->title
                . $oldstatus . ' -> ' . $status
                . ' at ' . now(),
            'user_id'   => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url'       => url()->current(),
        ]);
        return redirect()->back()->with('success', 'Expense Status Updated!');
    }
}
