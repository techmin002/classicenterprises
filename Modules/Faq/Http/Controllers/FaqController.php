<?php

namespace Modules\Faq\Http\Controllers;

use App\Models\Log;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Modules\Faq\DataTables\TeamDataTable;
use Modules\Faq\Entities\Faq;
use Modules\Faq\Http\Requests\StoreFaqRequest;
use Modules\Faq\Http\Requests\UpdateFaqRequest;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        abort_if(Gate::denies('show_faqs'), 403);
        $faqs = Faq::latest()->get();

        return view('faq::faqs.index', compact("faqs"));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        abort_if(Gate::denies('create_faqs'), 403);
        return view('faq::faqs.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(StoreFaqRequest $request)
    {
        abort_if(Gate::denies('create_faqs'), 403);
        Faq::create([
            'question' => $request['question'],
            'answer' => $request['answer'],
            'status' => $request['status']
        ]);

        Log::create([
            'perform'   => auth()->user()->name
                . 'FAQ Created "' . $request['question']
                . ' at ' . now(),
            'user_id'   => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url'       => url()->current(),
        ]);

        return redirect()->route('faqs.index')->with('success', 'Created Successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        // return view('faq::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        abort_if(Gate::denies('edit_faqs'), 403);
        $faq = Faq::findOrfail($id);
        return view('faq::faqs.edit', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateFaqRequest $request, $id)
    {
        abort_if(Gate::denies('edit_faqs'), 403);
        $faq = Faq::findOrfail($id);

        $faq->update($request->all());
        if (!$request->status) {
            $faq->update([
                'status' => '',
            ]);
        }
        Log::create([
            'perform'   => auth()->user()->name
                . 'FAQ Created "' .  $faq['question']
                . ' at ' . now(),
            'user_id'   => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url'       => url()->current(),
        ]);

        return redirect()->route('faqs.index')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('delete_faqs'), 403);
        $faq = Faq::findOrfail($id);
        $faq->delete();
        Log::create([
            'perform'   => auth()->user()->name
                . 'FAQ Created "' . $faq['question']
                . ' at ' . now(),
            'user_id'   => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url'       => url()->current(),
        ]);
        return redirect()->route('faqs.index')->with('success', 'Removed Successfully');
    }

    public function status($id)
    {
        abort_if(Gate::denies('access_faqs'), 403);
        $faq = Faq::findOrfail($id);
        $oldstatus = $faq->status;
        if ($faq->status == 'on') {
            $status = 'off';
        } else {
            $status = 'on';
        }
        $faq->update([
            'status' => $status
        ]);
        Log::create([
            'perform'   => auth()->user()->name
                . ' Changed Status' . $faq['question']
                . $oldstatus . ' -> ' . $status
                . ' at ' . now(),
            'user_id'   => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url'       => url()->current(),
        ]);
        return redirect()->route('faqs.index')->with('success', 'Status Updated Successfully');
    }
}
