<?php

namespace Modules\Employee\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Employee\Entities\Holiday;
use Illuminate\Support\Facades\Log;

class HolidayController extends Controller
{
    // ✅ INDEX
    public function index()
    {
        $holidays = Holiday::orderBy('date', 'DESC')->get();

        return view('employee::holidays.index', compact('holidays'));
    }

    // ✅ STORE
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'date'  => 'required|date|unique:holidays,date'
        ]);

        $holiday = Holiday::create([
            'title' => $request->title,
            'date'  => $request->date,
        ]);

        // Optional log
        Log::info('Holiday Created', [
            'title' => $holiday->title,
            'date'  => $holiday->date,
            'user'  => auth()->user()->id ?? null
        ]);

        return back()->with('success', 'Holiday Added Successfully');
    }

    // ✅ UPDATE
    public function update(Request $request, $id)
    {
        $holiday = Holiday::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'date'  => 'required|date|unique:holidays,date,' . $holiday->id
        ]);

        $oldData = $holiday->toArray();

        $holiday->update([
            'title' => $request->title,
            'date'  => $request->date,
        ]);

        Log::info('Holiday Updated', [
            'old' => $oldData,
            'new' => $holiday->toArray(),
            'user' => auth()->user()->id ?? null
        ]);

        return back()->with('success', 'Holiday Updated Successfully');
    }

    // ✅ DELETE
    public function destroy($id)
    {
        $holiday = Holiday::findOrFail($id);

        $holiday->delete();

        Log::warning('Holiday Deleted', [
            'title' => $holiday->title,
            'date'  => $holiday->date,
            'user'  => auth()->user()->id ?? null
        ]);

        return back()->with('success', 'Holiday Deleted Successfully');
    }
}