<?php

namespace Modules\Expenses\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Branch\Entities\Branch;
use Modules\Expenses\Entities\ExpenseCategory;
use Modules\Expenses\Entities\Expenses;
use Modules\Pettycash\Entities\PettyCashAdd;
use Modules\Pettycash\Entities\PettyCashTransaction;
use Yajra\DataTables\DataTables;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
   public function index()
{
    $user = auth()->user();

    if ($user->role->name === 'Super Admin') {
        $expenses = Expenses::with('category')
            ->orderBy('created_at', 'DESC')
            ->get();
    } else {
        $expenses = Expenses::with('category')
            ->where('branch_id', $user->branch_id)
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    $categories = ExpenseCategory::where('status', 'on')->get();
    $branches = Branch::where('status', 'on')->get();

    return view('expenses::expenses.index', compact('expenses', 'categories', 'branches'));
}


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('expenses::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $image = '';
        if ($request->receipt) {
            $image = time() . '.' . $request->receipt->extension();
            $request->receipt->move(public_path('upload/images/expenses-receipt'), $image);
        }

        $branchId = $request->branchId;

        if ($request->mode === 'petty cash') {
            $pettyCash = PettyCashAdd::where('branch_id', $branchId)->first();

            if (!$pettyCash) {
                return back()->with('error', 'Petty cash record not found for this branch!');
            }

            if ((float)$request->amount > (float)$pettyCash->remaining_cash) {
                return back()->with('error', 'Insufficient petty cash funds for this expense!');
            }
        }

        // Save expense
        $expense = new Expenses;
        $expense->expense_category_id = $request->categoryId;
        $expense->title = $request->title;
        $expense->amount = $request->amount;
        $expense->branch_id = $branchId;
        $expense->created_by = auth()->user()->id;
        $expense->date = $request->date;
        $expense->mode = $request->mode;
        $expense->description = $request->description;
        $expense->status = 'on';
        $expense->receipt = $image;
        $expense->save();

        // Deduct & log transaction
        if ($expense->mode === 'petty cash') {
            $before = $pettyCash->remaining_cash;
            $after = $before - (float)$expense->amount;

            $pettyCash->remaining_cash = $after;
            $pettyCash->save();

            PettyCashTransaction::create([
                'branch_id' => $branchId,
                'type' => 'expense',
                'amount' => $expense->amount,
                'total_cash_before' => $before,
                'remaining_cash_after' => $after,
                'message' => 'Expense entry: ' . $expense->title,
                'reference_id' => $expense->id,
                'created_by' => auth()->id(),
            ]);
        }

        return back()->with('success', 'Expense Added Successfully');
    }


    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('expenses::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('expenses::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $expense = Expenses::findOrFail($id);

        $oldAmount = $expense->amount;
        $oldMode = $expense->mode;
        $oldBranchId = $expense->branch_id;

        $image = $expense->receipt;
        if ($request->receipt) {
            $image = time() . '.' . $request->receipt->extension();
            $request->receipt->move(public_path('upload/images/expenses-receipt'), $image);
        }

        // Revert old petty cash if needed
        if ($oldMode === 'petty cash') {
            $oldPettyCash = PettyCashAdd::where('branch_id', $oldBranchId)->first();
            if ($oldPettyCash) {
                $oldPettyCash->remaining_cash += (float)$oldAmount;
                $oldPettyCash->save();
            }
        }

        // Check if new mode is petty cash
        if ($request->mode === 'petty cash') {
            $newPettyCash = PettyCashAdd::where('branch_id', $request->branchId)->first();
            if (!$newPettyCash) {
                return back()->with('error', 'Petty cash record not found for this branch!');
            }

            if ((float)$request->amount > (float)$newPettyCash->remaining_cash) {
                return back()->with('error', 'Insufficient petty cash funds for this expense!');
            }
        }

        // Update expense
        $expense->update([
            'expense_category_id' => $request->categoryId,
            'title' => $request->title,
            'amount' => $request->amount,
            'branch_id' => $request->branchId,
            'created_by' => auth()->user()->id,
            'date' => $request->date,
            'mode' => $request->mode,
            'description' => $request->description,
            'status' => 'on',
            'receipt' => $image,
        ]);

        // Deduct and log if mode is petty cash
        if ($expense->mode === 'petty cash') {
            $pettyCash = PettyCashAdd::where('branch_id', $request->branchId)->first();

            $before = $pettyCash->remaining_cash;
            $after = $before - (float)$expense->amount;

            $pettyCash->remaining_cash = $after;
            $pettyCash->save();

            $transaction = PettyCashTransaction::where('reference_id', $expense->id)
                ->where('type', 'expense')
                ->first();

            if ($transaction) {
                $transaction->update([
                    'amount' => $expense->amount,
                    'total_cash_before' => $before,
                    'remaining_cash_after' => $after,
                    'message' => 'Expense entry: ' . $expense->title,
                    'created_by' => auth()->id(),
                ]);
            } else {
                PettyCashTransaction::create([
                    'branch_id' => $request->branchId,
                    'type' => 'expense',
                    'amount' => $expense->amount,
                    'total_cash_before' => $before,
                    'remaining_cash_after' => $after,
                    'message' => 'Expense entry: ' . $expense->title,
                    'reference_id' => $expense->id,
                    'created_by' => auth()->id(),
                ]);
            }
        } else {
            // Mode changed from petty cash to something else — delete old transaction
            PettyCashTransaction::where('reference_id', $expense->id)
                ->where('type', 'expense')
                ->delete();
        }

        return back()->with('success', 'Expenses Updated Successfully');
    }






    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $expense = Expenses::findOrFail($id);

        // Reverse petty cash if mode was 'petty cash'
        if ($expense->mode === 'petty cash') {
            $pettyCash = PettyCashAdd::where('branch_id', $expense->branch_id)->first();
            if ($pettyCash) {
                $pettyCash->remaining_cash += (float)$expense->amount;
                $pettyCash->save();
            }

            // Delete associated petty cash transaction
            PettyCashTransaction::where('reference_id', $expense->id)
                ->where('type', 'expense')
                ->delete();
        }

        $expense->delete();

        return redirect()->back()->with('success', 'Expense Deleted!');
    }


    public function Status($id)
    {
        $categorys = Expenses::findOrfail($id);
        if ($categorys->status == 'on') {
            $status = 'off';
        } else {
            $status = 'on';
        }
        $categorys->update([
            'status' => $status
        ]);
        return redirect()->back()->with('success', 'Expense Status Updated!');
    }
    public function getExpense(Request $request)
    {
        $expenses = Expenses::all(); // Replace this with your logic to fetch data (you can apply filters, sorting, etc. here)

        return response()->json($expenses);
    }
}
