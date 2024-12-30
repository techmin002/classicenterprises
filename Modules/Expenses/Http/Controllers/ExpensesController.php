<?php

namespace Modules\Expenses\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Branch\Entities\Branch;
use Modules\Expenses\Entities\ExpenseCategory;
use Modules\Expenses\Entities\Expenses;
use Yajra\DataTables\DataTables;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $expenses = Expenses::with('category')->orderBy('created_at','DESC')->get();
        $categories = ExpenseCategory::where('status','on')->get();
        $branches = Branch::where('status','on')->get();
        return view('expenses::expenses.index', compact('expenses','categories','branches'));
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
        if($request->receipt)
        {
            $image = time().'.'.$request->receipt->extension();
            $request->receipt->move(public_path('upload/images/expenses-receipt'), $image);
        }
        
        $expense = new Expenses;
        $expense->expense_category_id = $request->categoryId;
        $expense->title = $request->title;
        $expense->amount = $request->amount;
        $expense->branch_id = $request->branchId;
        $expense->created_by = auth()->user()->id;
        $expense->date = $request->date;
        $expense->mode = $request->mode;
        $expense->description = $request->description;
        $expense->status = 'on';
        $expense->receipt = $image;
        $expense->save();
        return back()->with('success','Expenses Added Successfully');
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
        $expense = Expenses::findOrfail($id);
        $image = $expense->receipt;
        if($request->receipt)
        {
            $image = time().'.'.$request->receipt->extension();
            $request->receipt->move(public_path('upload/images/expenses-receipt'), $image);
        }
        $expense->expense_category_id = $request->categoryId;
        $expense->title = $request->title;
        $expense->amount = $request->amount;
        $expense->branch_id = $request->branchId;
        $expense->created_by = auth()->user()->id;
        $expense->date = $request->date;
        $expense->mode = $request->mode;
        $expense->description = $request->description;
        $expense->status = 'on';
        $expense->receipt = $image;
        $expense->save();
        return back()->with('success','Expenses Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $categorys= Expenses::findOrfail($id);
        $categorys->delete();
        return redirect()->back()->with('success','Expense Deleted!');
    }
    public function Status($id)
    {
        $categorys= Expenses::findOrfail($id);
        if($categorys->status == 'on')
        {
            $status ='off';
        }else{
            $status ='on';
        }
        $categorys->update([
            'status' => $status
        ]);
        return redirect()->back()->with('success','Expense Status Updated!');
    }
    public function getExpense(Request $request)
    {
        $expenses = Expenses::all(); // Replace this with your logic to fetch data (you can apply filters, sorting, etc. here)

        return response()->json($expenses);
    }
}
