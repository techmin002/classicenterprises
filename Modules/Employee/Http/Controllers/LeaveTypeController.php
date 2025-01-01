<?php

namespace Modules\Employee\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Branch\Entities\Branch;
use Modules\Employee\Entities\LeaveType;

class LeaveTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $expenses = LeaveType::orderBy('created_at','DESC')->with('branch')->get();
        $branches = Branch::where('status','on')->get();
        return view('employee::leave-types.index', compact('expenses','branches'));
    }
  
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('expenses::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        
        LeaveType::create([
            'title' => $request->title,
            'branch_id' => $request->branch_id,
            'duration_type' => $request->duration_type,
            'leaves' => $request->leaves,
            'created_by' => auth()->user()->id,
            'description' => $request->description,
            'status' => $request->status
        ]);
        return back()->with('success','Leave Type Added Successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('expenses::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('expenses::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $cat = LeaveType::findOrfail($id);
        
        $cat->update([
            'title' => $request->title,
            'branch_id' => $request->branch_id,
            'duration_type' => $request->duration_type,
            'leaves' => $request->leaves,
            'description' => $request->description,
            'status' => $request->status
        ]);
        return back()->with('success','Leave Types Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $leaveType= LeaveType::findOrfail($id);
        $leaveType->delete();
        return redirect()->back()->with('success','Leave Type Deleted!');
    }
    public function Status($id)
    {
        $leaveType= LeaveType::findOrfail($id);
        if($leaveType->status == 'on')
        {
            $status ='off';
        }else{
            $status ='on';
        }
        $leaveType->update([
            'status' => $status
        ]);
        return redirect()->back()->with('success','Leave Type Updated!');
    }
   
}
