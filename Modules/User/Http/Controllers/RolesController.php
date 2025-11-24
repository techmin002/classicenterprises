<?php

namespace Modules\User\Http\Controllers;

use App\Models\Log;
use Modules\User\DataTables\RolesDataTable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function index()
    {
        // abort_if(Gate::denies('access_user_management'), 403);

        $roles = Role::all();
        return view('user::roles.index', compact("roles"));
    }


    public function create()
    {
        // abort_if(Gate::denies('access_user_management'), 403);

        return view('user::roles.create');
    }


    public function store(Request $request)
    {
        // abort_if(Gate::denies('access_user_management'), 403);
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'required|array'
        ]);

        $role = Role::create([
            'name' => $request->name
        ]);

        $role->givePermissionTo($request->permissions);

        Log::create([
            'perform' => auth()->user()->name . ' Role Created '. $role->name . ' at ' . now(),
            'user_id' => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url' => url()->current(),
        ]);

        return redirect()->route('roles.index')->with('success', 'Created Successfully');
    }


    public function edit(Role $role)
    {
        abort_if(Gate::denies('access_user_management'), 403);

        return view('user::roles.edit', compact('role'));
    }


    public function update(Request $request, Role $role)
    {
        abort_if(Gate::denies('access_user_management'), 403);

        $RoleName = $role->name;

        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'required|array'
        ]);

        $role->update([
            'name' => $request->name
        ]);

        $role->syncPermissions($request->permissions);

        Log::create([
            'perform' => auth()->user()->name . ' Role Updated ' . $RoleName . ' at ' . now(),
            'user_id' => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url' => url()->current(),
        ]);

        return redirect()->route('roles.index')->with('success', 'Updated Successfully');
    }


    public function destroy(Role $role)
    {
        abort_if(Gate::denies('access_user_management'), 403);

        $RoleName = $role->name;
        $role->delete();

        Log::create([
            'perform' => auth()->user()->name . ' deleted role: ' . $RoleName . ' at ' . now(),
            'user_id' => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url' => url()->current(),
        ]);

        return redirect()->route('roles.index')->with('success', 'Deleted Successfully');
    }
}
