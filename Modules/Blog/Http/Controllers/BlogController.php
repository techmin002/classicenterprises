<?php

namespace Modules\Blog\Http\Controllers;

use App\Models\Log;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Modules\Blog\DataTables\BlogDataTable;
use Modules\Blog\Entities\Blog;
use Modules\Blog\Http\Requests\StoreBlogRequest;
use Modules\Blog\Http\Requests\UpdateBlogRequest;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        abort_if(Gate::denies('show_blogs'), 403);
        $blogs = Blog::orderBy('created_at', 'DESC')->get();
        return view('blog::blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        abort_if(Gate::denies('create_blogs'), 403);
        return view('blog::blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(StoreBlogRequest $request)
    {
        abort_if(Gate::denies('create_blogs'), 403);
        $imageName = '';
        $slug = Str::slug($request->title);
        if ($request->image) {
            $imageName = time() . '.' . $request->image->extension();

            $request->image->move(public_path('upload/images/blogs'), $imageName);
        }
        Blog::create([
            'title' => $request['title'],
            'description' => $request['description'],
            'slug' => $slug,
            'status' => $request['status'],
            'image' => $imageName
        ]);
        Log::create([
            'perform'   => auth()->user()->name
                . ' Blog Created: ' . $request->title
                . ' at ' . now(),
            'user_id'   => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url'       => url()->current(),
        ]);
        // toastr('Blog Added','success');
        // return redirect()->route('blogs.index');
        return redirect()->route('blogs.index')->with('success', 'Added Successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        abort_if(Gate::denies('edit_blogs'), 403);
        $blog = Blog::findOrfail($id);
        return view('blog::blogs.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateBlogRequest $request, $id)
    {
        abort_if(Gate::denies('edit_blogs'), 403);
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
        ]);
        $blog = Blog::findOrfail($id);
        $imageName = '';
        $slug = Str::slug($request->title);
        if ($request->image) {
            $imageName = time() . '.' . $request->image->extension();

            $request->image->move(public_path('upload/images/blogs'), $imageName);
        } else {
            $imageName = $blog->image;
        }
        if ($request['status'] == 'on') {
            $status = 'on';
        } else {
            $status = 'off';
        }
        $blog->update([
            'title' => $request['title'],
            'description' => $request['description'],
            'slug' => $slug,
            'status' => $status,
            'image' => $imageName
        ]);
        Log::create([
            'perform'   => auth()->user()->name
                . ' Blog Updated: ' . $blog->title
                . ' at ' . now(),
            'user_id'   => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url'       => url()->current(),
        ]);
        return redirect()->route('blogs.index')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('delete_blogs'), 403);
        $blog = Blog::findOrfail($id);
        $blog->delete();
        Log::create([
            'perform'   => auth()->user()->name
                . ' Blog Deleted: ' . $blog->title
                . ' at ' . now(),
            'user_id'   => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url'       => url()->current(),
        ]);
        return redirect()->route('blogs.index')->with('success', 'Deleted Successfully');
    }
    public function status($id)
    {
        abort_if(Gate::denies('access_blogs'), 403);
        $blog = Blog::findOrfail($id);
        $oldstatus = $blog->status;
        if ($blog->status == 'on') {
            $status = 'off';
        } else {
            $status = 'on';
        }
        $blog->update([
            'status' => $status
        ]);
        Log::create([
            'perform'   => auth()->user()->name
                . ' Changed "' . $blog->title . '" status from '
                . $oldstatus . ' -> ' . $status
                . ' at ' . now(),
            'user_id'   => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url'       => url()->current(),
        ]);
        return redirect()->route('blogs.index')->with('success', 'Status Updated Successfully');
    }
}
