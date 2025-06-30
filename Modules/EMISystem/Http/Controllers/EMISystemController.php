<?php

namespace Modules\EMISystem\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\EMISystem\Entities\EmiPlan;

class EMISystemController extends Controller
{
    public function index()
    {
        $emiPlan = EmiPlan::all();
        return view('emisystem::EMISystem.index', compact('emiPlan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'interest_rate' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|boolean'
        ]);

        $emiPlan = EmiPlan::create($validated);

        return back()->with('success', 'EMI Plan created successfully.');
    }

    public function edit($id)
    {
        $emiPlan = EmiPlan::findOrFail($id);
        return view('emisystem::EMISystem.edit', compact('emiPlan'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'interest_rate' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        $emiPlan = EmiPlan::findOrFail($id);
        $emiPlan->update($validated);

        return redirect()->route('emi.system.index')->with('success', 'EMI Plan updated successfully.');
    }

    public function destroy($id)
    {
        $plan = EmiPlan::findOrFail($id);
        $plan->delete();

        return redirect()->back()->with('success', 'EMI Plan deleted successfully.');
    }
}
