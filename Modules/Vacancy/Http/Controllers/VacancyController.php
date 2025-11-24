<?php

namespace Modules\Vacancy\Http\Controllers;

use App\Models\Log;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Modules\Vacancy\DataTables\VacancyDataTable;
use Modules\Vacancy\Entities\Vacancy;
use Modules\Vacancy\Http\Requests\StoreVacancyRequest;
use Modules\Vacancy\Http\Requests\UpdateVacancyRequest;

class VacancyController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        abort_if(Gate::denies('show_testimonials'), 403);
        $vacancies = Vacancy::latest()->get();
        return view('vacancy::vacancies.index', compact("vacancies"));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        abort_if(Gate::denies('create_testimonials'), 403);
        return view('vacancy::vacancies.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(StoreVacancyRequest $request)
    {
        $imageName = '';
        if ($request->image) {
            $imageName = time() . '.' . $request->image->extension();

            $request->image->move(public_path('upload/images/vacancies'), $imageName);
        }
        Vacancy::create([
            'title' => $request['title'],
            'type' => $request['type'],
            'no_of_opening' => $request['no_of_opening'],
            'short_description' => $request['short_description'],
            'description' => $request['description'],
            'expire_at' => $request['expire_at'],
            'status' => $request['status'],
            'image' => $imageName
        ]);
        Log::create([
            'perform'   => auth()->user()->name
                . ' Vacancy Created: ' . $request['title']
                . ' at ' . now(),
            'user_id'   => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url'       => url()->current(),
        ]);


        return redirect()->route('vacancies.index')->with('success', 'Created Successfully');;
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        // return view('vacancy::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        abort_if(Gate::denies('edit_testimonials'), 403);
        $vacancy = Vacancy::findOrfail($id);
        return view('vacancy::vacancies.edit', compact('vacancy'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateVacancyRequest $request, $id)
    {
        $vacancy = Vacancy::findOrfail($id);
        $imageName = $vacancy->image;
        if ($request->image) {
            $imageName = time() . '.' . $request->image->extension();

            $request->image->move(public_path('upload/images/vacancies'), $imageName);
        }
        if ($request['status'] == 'on') {
            $status = 'on';
        } else {
            $status = 'off';
        }
        $vacancy->update([
            'title' => $request['title'],
            'type' => $request['type'],
            'no_of_opening' => $request['no_of_opening'],
            'short_description' => $request['short_description'],
            'description' => $request['description'],
            'expire_at' => $request['expire_at'],
            'status' => $status,
            'image' => $imageName
        ]);
        Log::create([
            'perform'   => auth()->user()->name
                . ' Vacancy updated: ' . $vacancy['title']
                . ' at ' . now(),
            'user_id'   => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url'       => url()->current(),
        ]);
        return redirect()->route('vacancies.index')->with('success', 'Updated Successfully');;
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('delete_testimonials'), 403);
        $vacancy = Vacancy::findOrfail($id);
        $vacancy->delete();
        Log::create([
            'perform'   => auth()->user()->name
                . ' Vacancy Deleted: ' . $vacancy['title']
                . ' at ' . now(),
            'user_id'   => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url'       => url()->current(),
        ]);
        return redirect()->route('vacancies.index')->with('success', 'Deleted Successfully');;
    }

    public function status($id)
    {
        abort_if(Gate::denies('access_testimonials'), 403);
        $vacancy = Vacancy::findOrfail($id);
        $oldstatus = $vacancy->status;
        if ($vacancy->status == 'on') {
            $status = 'off';
        } else {
            $status = 'on';
        }
        $vacancy->update([
            'status' => $status
        ]);
        Log::create([
            'perform'   => auth()->user()->name
                . ' Changed Status' . $vacancy['title']
                . $oldstatus . ' -> ' . $status
                . ' at ' . now(),
            'user_id'   => auth()->user()->id,
            'branch_id' => session('branch_id') ?? auth()->user()->branch_id,
            'url'       => url()->current(),
        ]);

        return redirect()->route('vacancies.index')->with('success', 'Status Updated Successfully');
    }
}
