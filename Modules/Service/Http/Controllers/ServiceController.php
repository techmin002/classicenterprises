<?php

namespace Modules\Service\Http\Controllers;

use App\Models\Log;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Modules\Service\Entities\Service;
use Modules\Service\Http\Requests\StoreServiceRequest;
use Modules\Service\Http\Requests\UpdateServiceRequest;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        abort_if(Gate::denies('show_services'), 403);
        $services = Service::all();
        return view('service::service.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        abort_if(Gate::denies('create_services'), 403);
        return view('service::service.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(StoreServiceRequest $request)
    {
        // dd($request->all());

        if ($request['icon']) {
            $imageName = time() . '.' . $request->icon->extension();

            $request->icon->move(public_path('upload/images/services'), $imageName);
        }
        if ($request->image) {
            $image = time() . '.' . $request->image->extension();
            $request->image->move(public_path('upload/images/services'), $image);
        }
        $slug = Str::slug($request->title);
        Service::create([
            'title' => $request->title,
            'slug' => $slug,
            'icon' => $imageName,
            'image' => $image,
            'shortDescription' => $request->shortDescription,
            'description' => $request->description,
            'status' => $request->status
        ]);

        Log::create([
            'perform'   => auth()->user()->name
                . ' Service Created: ' . $request->title
                . ' at ' . now(),
            'user_id'   => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url'       => url()->current(),
        ]);
        return redirect()->route('services.index')->with('success', 'Services Added Successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('service::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        abort_if(Gate::denies('edit_services'), 403);
        $service = Service::findOrfail($id);
        return view('service::service.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateServiceRequest $request, $id)
    {
        $service = Service::findOrfail($id);
        if ($request['icon']) {
            $imageName = time() . '.' . $request->icon->extension();

            $request->icon->move(public_path('upload/images/services'), $imageName);
        } else {
            $imageName = $service->icon;
        }
        if ($request->image) {
            $image = time() . '.' . $request->image->extension();
            $request->image->move(public_path('upload/images/services'), $image);
        } else {
            $image = $service->image;
        }
        if ($request['status'] == 'on') {
            $status = 'on';
        } else {
            $status = 'off';
        }
        if ($request->title) {
            $slug = Str::slug($request->title);
        } else {
            $slug = Str::slug($service->title);
        }
        $service->update([
            'title' => $request->title,
            'slug' => $slug,
            'icon' => $imageName,
            'image' => $image,
            'shortDescription' => $request->shortDescription,
            'description' => $request->description,
            'status' => $status
        ]);
        Log::create([
            'perform'   => auth()->user()->name
                . ' Service Updated: ' . $service->title
                . ' at ' . now(),
            'user_id'   => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url'       => url()->current(),
        ]);
        return redirect()->route('services.index')->with('success', 'Services Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $service = Service::findOrfail($id);
        $service->delete();
        Log::create([
            'perform'   => auth()->user()->name
                . ' Service Deleted: ' . $service->title
                . ' at ' . now(),
            'user_id'   => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url'       => url()->current(),
        ]);

        return redirect()->back()->with('success', 'Service Deleted!');
    }
    public function Status($id)
    {
        $service = Service::findOrfail($id);
        $oldstatus = $service->status;
        if ($service->status == 'on') {
            $status = 'off';
        } else {
            $status = 'on';
        }
        $service->update([
            'status' => $status
        ]);
        Log::create([
            'perform'   => auth()->user()->name
                . ' Changed "' . $service->title . '" status from '
                . $oldstatus . ' -> ' . $status
                . ' at ' . now(),
            'user_id'   => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url'       => url()->current(),
        ]);

        return redirect()->back()->with('success', 'Service Updated!');
    }
}
