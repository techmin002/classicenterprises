<?php

namespace Modules\Team\Http\Controllers;

use App\Models\Log;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Modules\Team\DataTables\TeamDataTable;
use Modules\Team\Entities\Team;
use Modules\Team\Http\Requests\StoreTeamRequest;
use Modules\Team\Http\Requests\UpdateTeamRequest;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        abort_if(Gate::denies('show_teams'), 403);
        $teams = Team::latest()->get();

        return view('team::teams.index', compact("teams"));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        abort_if(Gate::denies('create_teams'), 403);
        return view('team::teams.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(StoreTeamRequest $request)
    {
        abort_if(Gate::denies('create_teams'), 403);
        //        dd($request->all());
        $imageName = '';
        if ($request->image) {
            $imageName = time() . '.' . $request->image->extension();

            $request->image->move(public_path('upload/images/teams'), $imageName);
        }
        Team::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'designation' => $request['designation'],
            'introduction' => $request['introduction'],
            'status' => $request['status'],
            'image' => $imageName
        ]);

        Log::create([
            'perform'   => auth()->user()->name
                . ' Team created: ' . $request->name
                . ' at ' . now(),
            'user_id'   => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url'       => url()->current(),
        ]);

        return redirect()->route('teams.index')->with('success', 'Created Successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        // return view('team::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        abort_if(Gate::denies('edit_teams'), 403);
        $team = Team::findOrfail($id);

        return view('team::teams.edit', compact('team'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateTeamRequest $request, $id)
    {
        $team = Team::findOrfail($id);
        if ($request->image) {
            $imageName = time() . '.' . $request->image->extension();

            $request->image->move(public_path('upload/images/teams'), $imageName);
        } else {
            $imageName = $team->image;
        }
        $team->update([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'designation' => $request['designation'],
            'introduction' => $request['introduction'],
            'status' => $request['status'],
            'image' => $imageName
        ]);
        Log::create([
            'perform'   => auth()->user()->name
                . ' Team Updated: ' . $request->name
                . ' at ' . now(),
            'user_id'   => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url'       => url()->current(),
        ]);

        return redirect()->route('teams.index')->with('success', 'Created Successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('delete_teams'), 403);
        $team = Team::findOrfail($id);
        $team->delete();
        Log::create([
            'perform'   => auth()->user()->name
                . ' Team Delete: ' . $team->name
                . ' at ' . now(),
            'user_id'   => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url'       => url()->current(),
        ]);
        return redirect()->route('teams.index')->with('success', 'Removed Successfully');
    }

    public function status($id)
    {
        abort_if(Gate::denies('access_teams'), 403);
        $team = Team::findOrfail($id);

        $oldstatus = $team->status;
        if ($team->status == 'on') {
            $status = 'off';
        } else {
            $status = 'on';
        }
        $team->update([
            'status' => $status
        ]);

        Log::create([
            'perform'   => auth()->user()->name
                . ' changed team Status ' . $team->name
                . $oldstatus . ' -> ' . $status
                . ' at ' . now(),
            'user_id'   => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url'       => url()->current(),
        ]);
        return redirect()->route('teams.index')->with('success', 'Status Updated Successfully');
    }
}
