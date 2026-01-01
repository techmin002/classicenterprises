<?php

namespace Modules\Inventory\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Inventory\Entities\Branch;
use Modules\Inventory\Entities\DevicePurchase;
use Modules\Inventory\Entities\Supplier;
use Modules\Inventory\Entities\User;

class SupplierController extends Controller
{
    public function index()
    {
        if (auth()->user()->role['name'] === 'Super Admin') {
            $branchId = session('branch_id');
        } else {
            $branchId = auth()->user()->branch_id;
        }
        $branch = Branch::find($branchId);
        $branchName = $branch?->name;

        $type = 'local';
        $suppliers = Supplier::all();
        $branches = Branch::all();
        $users = User::all();

        return view('inventory::Suppliers.index', compact('suppliers', 'type', 'branches', 'users', 'branchId', 'branchName'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'contact' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'vat' => 'nullable|string|max:50',
            'pan' => 'nullable|string|max:50',
            'discription' => 'nullable|string',
            'type' => 'nullable|string',
            'branch_id' => 'nullable|exists:branches,id',
            'status' => 'nullable|boolean',
            'created_by' => 'nullable|exists:users,id',
        ]);

        Supplier::create($validated);

        return redirect()->route('suppliers.index')->with('success', 'Supplier created successfully.');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        if (auth()->user()->role['name'] === 'Super Admin') {
            $branchId = session('branch_id');
        } else {
            $branchId = auth()->user()->branch_id;
        }
        $supplier = Supplier::findOrFail($id);
        $details = DevicePurchase::with('supplier')
            ->where('branch_id', $branchId)
            ->where('supplier_id', $id)->get();

        return view('inventory::Suppliers.viewdetails', compact('details','supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        $branches = Branch::all();
        $users = User::all();

        return view('inventory::Suppliers.edit', compact('supplier', 'branches', 'users'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'contact' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'vat' => 'nullable|string|max:50',
            'pan' => 'nullable|string|max:50',
            'discription' => 'nullable|string',
            'type' => 'nullable|string',
            'branch_id' => 'nullable|exists:branches,id',
            'status' => 'nullable|boolean',
            'created_by' => 'nullable|exists:users,id',
        ]);

        $supplier = Supplier::findOrFail($id);
        $supplier->update($validated);

        return redirect()->route('suppliers.index')->with('success', 'Supplier updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return redirect()->route('suppliers.index')->with('success', 'Supplier deleted successfully.');
    }
}
