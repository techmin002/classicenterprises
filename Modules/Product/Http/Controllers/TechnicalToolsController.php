<?php

namespace Modules\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Product\Entities\TechnicalTools;

class TechnicalToolsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $technicalTools = TechnicalTools::latest()->get();
        return view('product::technicaltools.index', compact('technicalTools'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('product::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        // Handle single image
        if ($request->hasFile('image')) {
            $image = time() . '.' . $request->image->extension();
            $request->image->move(public_path('upload/images/technicaltools'), $image);
        } else {
            $image = null;
        }


        // dd('hello');
        // Save the data
        TechnicalTools::create([
            'tool_name'   => $request->tool_name,
            'model_name'  => $request->model_name,
            'price'       => $request->price,
            // 'stock'       => $request->stock,
            'image'       => $image,
            'description' => $request->description,
            'status'      => $request->status ?? 'on',
        ]);

        Log::create([
            'perform'   => auth()->user()->name
                . ' TechnicalTools Create: ' . $request->tool_name
                . ' at ' . now(),
            'user_id'   => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url'       => url()->current(),
        ]);
        return redirect()->route('technicaltools.index')->with('success', 'Technical Tool Created Successfully');
    }
    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('product::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $tool = TechnicalTools::findOrFail($id);
        return view('product::technicaltools.edit', compact('tool'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $tool = TechnicalTools::findOrFail($id);
        $tool->update($request->only('tool_name', 'description'));
        Log::create([
            'perform'   => auth()->user()->name
                . ' TechnicalTools Update: ' . $tool->tool_name
                . ' at ' . now(),
            'user_id'   => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url'       => url()->current(),
        ]);

        return redirect()->route('technicaltools.index')->with('success', 'Technical Tool updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tool = TechnicalTools::findOrFail($id);
        $tool->delete();
        Log::create([
            'perform'   => auth()->user()->name
                . ' TechnicalTools Deleted: ' . $tool->tool_name
                . ' at ' . now(),
            'user_id'   => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url'       => url()->current(),
        ]);
        return redirect()->back()->with('success', 'Technical Tool deleted successfully!');
    }
    public function Status($id)
    {
        $tool = TechnicalTools::findOrFail($id); // get tool
        $oldstatus = $tool->status;
        $tool->status = $tool->status === 'on' ? 'off' : 'on'; // toggle status

        $tool->save(); // save change to DB

        Log::create([
            'perform'   => auth()->user()->name
                . ' Changed TechnicalTools status: ' . $tool->title
                . ' | Status: ' . $oldstatus . ' → ' . $tool->status
                . ' at ' . now(),
            'user_id'   => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url'       => url()->current(),
        ]);
        return redirect()->back()->with('success', 'Status updated successfully!');
    }
}
