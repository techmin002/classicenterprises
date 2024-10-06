<?php

namespace Modules\Service\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Modules\Service\Entities\ServiceCategory;
use Modules\Service\Http\Requests\ServiceCategoryStoreRequest;
use Illuminate\Support\Str;
use Modules\Service\Http\Requests\ServiceCategoryUpdateRequest;

class ServiceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        abort_if(Gate::denies('access_service_category'),403);
        $categories = ServiceCategory::get();
        return view('service::category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('service::category.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(ServiceCategoryStoreRequest $request)
    {
        if($request['icon'])
        {
            $imageName = time().'.'.$request->icon->extension();

            $request->icon->move(public_path('upload/images/category'), $imageName);
        }
        if($request->image)
        {
            $image = time().'.'.$request->image->extension();
            $request->image->move(public_path('upload/images/category'), $image);
        }
        $slug = Str::slug($request->title);
        ServiceCategory::create([
            'title' => $request->title,
            'slug' => $slug,
            'icon' => $imageName,
            'image' => $image,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'status' => $request->status
        ]);
        return redirect()->route('services_category.index')->with('success','Category Added Successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('service::category.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        abort_if(Gate::denies('edit_service_category'), 403);
        $serviceCategory = ServiceCategory::findOrfail($id);
        return view('service::category.edit',compact('serviceCategory'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(ServiceCategoryUpdateRequest $request, $id)
    {
        $category = ServiceCategory::findOrFail($id);
        if($request['icon'])
        {
            $imageName = time().'.'.$request->icon->extension();

            $request->icon->move(public_path('upload/images/category'), $imageName);
        }else{
            $imageName = $category->icon;
        }
        if($request->image)
        {
            $image = time().'.'.$request->image->extension();
            $request->image->move(public_path('upload/images/category'), $image);
        }else
        {
            $image = $category->iamge;
        }
        if($request->title)
        {
            $slug = Str::slug($request->title);
        }else{
            $slug = Str::slug($category->title);
        }
        $category->update([
            'title' => $request->title,
            'slug' => $slug,
            'icon' => $imageName,
            'image' => $image,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'status' => $request->status
        ]);
        return redirect()->route('services_category.index')->with('success','Category Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('delete_service_category'),403);
        $category = ServiceCategory::findOrfail($id);
        $category->delete();
        return back()->with('success','Service Catgory Deleted successfully');
    }
}
