<?php

namespace Modules\Lead\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Employee\Entities\Employee;
use Modules\Lead\Entities\Lead;
use Modules\Branch\Entities\Branch;
use Modules\Lead\Entities\LeadResponse;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('lead::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('lead::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $emp = Employee::where('user_id',auth()->user()->id)->select('id','branch_id')->first();

        if($request->branch_id)
        {
            $branch_id = $request->branch_id;
        }else{
            $branch_id = $emp->branch_id;
        }
        // dd($request->all());
        $lead = new Lead();
        $lead->name = $request->input('name');
        $lead->email = $request->input('email');
        $lead->address = $request->input('address');
        $lead->mobile = $request->input('mobile');
        $lead->lead_type = $request->input('type');
        $lead->branch_id = $branch_id;
        $lead->created_by = auth()->user()->id;
        $lead->message = $request->input('message');
        $lead->save();
        $res = LeadResponse::create([
            'lead_id' => $lead->id,
            'branch_id' => $lead->branch_id,
            'created_by' => $lead->created_by,
            'message' => $request->input('message'),
            'date_time' => $request['date_time']
        ]);
        return back()->with('success','Lead added successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $lead = Lead::with('responses','employee')->where('id', $id)->first();
        // dd($lead);
        return view('lead::response.index', compact('lead'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('lead::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $lead = Lead::findOrfail($id);
        $lead->name = $request->input('name');
        $lead->email = $request->input('email');
        $lead->address = $request->input('address');
        $lead->mobile = $request->input('mobile');
        $lead->message = $request->input('message');
        $lead->save();

        return back()->with('success','Lead Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $lead = Lead::findOrfail($id);
        if($lead)
        {
            $lead->update([
                'deleted_at' => Carbon::now(),
            ]);
            return back()->with('success','Lead Updated successfully');
        }else{
            return back()->with('error','Lead Not Found');
        }
    }
    public function hotLeads()
    {

        $branches = Branch::all();

        $leads = Lead::with('responses')->where('lead_type', 'hot')->get();
        $type = 'hot';
        return view('lead::leads.index', compact('leads','type','branches'));
    }
    public function warmLeads()
    {

        $branches = Branch::all();

        $type = 'warm';
        $leads = Lead::with('responses')->where('lead_type', 'warm')->get();
        return view('lead::leads.index', compact('leads','type','branches'));
    }
    public function coldLeads()
    {

        $branches = Branch::all();

        $type = 'cold';
        $leads = Lead::with('responses')->where('lead_type', 'cold')->get();
        return view('lead::leads.index', compact('leads','type','branches'));
    }
    public function responseStore(Request $request)
    {
        $emp = Employee::where('user_id',auth()->user()->id)->select('id','branch_id')->first();
        $lead = Lead::where('id', $request['lead_id'])->first();
        $res = LeadResponse::create([
            'lead_id' => $lead->id,
            'branch_id' => $emp->branch_id,
            'created_by' => $emp->id,
            'message' => $request->input('message'),
            'date_time' => $request['date_time']
        ]);
        return back()->with('success','Response added successfully');
    }
    public function responseUpdate(Request $request, $id)
    {
        $res = LeadResponse::findOrfail($id)->update([
            'message' => $request->input('message'),
            'date_time' => $request['date_time']
        ]);
        return back()->with('success','Response added successfully');
    }
    public function responseDelete($id)
    {
        $res = LeadResponse::findOrfail($id)->update([
            'deleted_at' => Carbon::now(),
        ]);
        return back()->with('success','Response added successfully');
    }
}
