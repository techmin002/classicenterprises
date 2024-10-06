<?php

namespace Modules\Employee\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Employee\Entities\Employee;
use Modules\Employee\Entities\EmployeeAdvancePay;
use Modules\Employee\Entities\EmployeeAllowance;
use Modules\Employee\Entities\EmployeeFund;
use Modules\Employee\Entities\EmployeePayslip;
use Modules\Employee\Entities\EmployeeSalary;
use Modules\Employee\Entities\EmployeeSaleInsentive;
use Modules\Employee\Entities\EmployeeService;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $employees = Employee::where('status', 'on')->with('user', 'branch', 'salary')->orderBy('created_at', 'DESC')->get();
        // dd($employees);
        return view('employee::payroll.setsalary', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('employee::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $employee = Employee::where('id', $id)
            ->with('user', 'branch', 'salary', 'allowance', 'insentive', 'advancePay', 'fund', 'service')
            ->first();
        $salary = EmployeeSalary::where('employee_id', $employee->id)->first();
        return view('employee::payroll.show', compact('employee', 'salary'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('employee::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
    public function StoreEmployeeSalary(Request $request)
    {
        $request->validate([
            'salary' => ['required']
        ]);
        $empSalary = EmployeeSalary::create([
            'salary' => $request['salary'],
            'employee_id' => $request['emp_id']
        ]);

        return back()->with('success', 'Salary Added Successfully');
    }
    public function updateEmployeeSalary(Request $request)
    {
        $request->validate([
            'salary' => ['required']
        ]);
        $id = $request['salary_id'];
        $empSalary = EmployeeSalary::findOrfail($id);
        $empSalary->update([
            'salary' => $request['salary'],
        ]);

        return back()->with('success', 'Salary Added Successfully');
    }
    public function StoreEmployeeAllowance(Request $request)
    {
        $request->validate([
            'amount' => ['required'],
            'type' => ['required'],
            'title' => ['required'],
        ]);
        $empamount = EmployeeAllowance::create([
            'amount' => $request['amount'],
            'title' => $request['title'],
            'type' => $request['type'],
            'employee_id' => $request['emp_id']
        ]);

        return back()->with('success', 'Allowance Added Successfully');
    }
    public function DeleteEmployeeAllowance($id)
    {
        $empAllowance = EmployeeAllowance::findOrfail($id);
        $empAllowance->delete();
        return back()->with('success', 'Allowance Deleted Successfully');
    }
    public function updateEmployeeAllowance(Request $request, $id)
    {
        $request->validate([
            'amount' => ['required'],
            'type' => ['required'],
            'title' => ['required'],
        ]);
        $empamount = EmployeeAllowance::findOrfail($id)
            ->update([
                'amount' => $request['amount'],
                'title' => $request['title'],
                'type' => $request['type'],
            ]);

        return back()->with('success', 'Allowance Updated Successfully');
    }

    public function storeEmployeeInsentive(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'insentive' => ['required'],
            'sale_amount' => ['required'],
            'date' => ['required'],
            'title' => ['required'],
        ]);
        $empamount = EmployeeSaleInsentive::create([
            'sale_amount' => $request['sale_amount'],
            'insentive_amount' => $request['insentive'],
            'title' => $request['title'],
            'date' => $request['date'],
            'description' => $request['description'],
            'employee_id' => $request['emp_id']
        ]);

        return back()->with('success', 'Insentive Added Successfully');
    }
    public function updateEmployeeinsentive(Request $request, $id)
    {
        $request->validate([
            'insentive' => ['required'],
            'sale_amount' => ['required'],
            'date' => ['required'],
            'title' => ['required'],
        ]);
        $insentive = EmployeeSaleInsentive::findOrfail($id)
            ->update([
                'sale_amount' => $request['sale_amount'],
                'insentive_amount' => $request['insentive'],
                'title' => $request['title'],
                'date' => $request['date'],
                'description' => $request['description'],
            ]);

        return back()->with('success', 'Insentive Updated Successfully');
    }
    public function deleteEmployeeinsentive($id)
    {
        $empAllowance = EmployeeSaleInsentive::findOrfail($id);
        $empAllowance->delete();
        return back()->with('success', 'Insentive Deleted Successfully');
    }
    public function storeEmployeeadvancedpay(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title' => ['required'],
            'amount' => ['required'],
            'date' => ['required'],
            'reason' => ['required'],
        ]);
        $empamount = EmployeeAdvancePay::create([
            'amount' => $request['amount'],
            'title' => $request['title'],
            'date' => $request['date'],
            'reason' => $request['reason'],
            'employee_id' => $request['emp_id']
        ]);

        return back()->with('success', 'Employee Advanced Pay Added Successfully');
    }
    public function updateEmployeeadvancedpay(Request $request, $id)
    {
        $request->validate([
            'title' => ['required'],
            'amount' => ['required'],
            'date' => ['required'],
            'reason' => ['required'],
        ]);
        $insentive = EmployeeAdvancePay::findOrfail($id)
            ->update([
                'amount' => $request['amount'],
                'title' => $request['title'],
                'date' => $request['date'],
                'reason' => $request['reason'],
            ]);

        return back()->with('success', 'Advance Pay Updated Successfully');
    }
    public function deleteEmployeeadvancedpay($id)
    {
        $empAllowance = EmployeeAdvancePay::findOrfail($id);
        $empAllowance->delete();
        return back()->with('success', 'Employee Advanced Pay Deleted Successfully');
    }
    public function storeEmployeefund(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'amount' => ['required'],
            'date' => ['required'],
        ]);
        $empamount = EmployeeFund::create([
            'amount' => $request['amount'],
            'month' => $request['date'],
            'employee_id' => $request['emp_id']
        ]);

        return back()->with('success', 'Classic Fund Added Successfully');
    }
    public function updateEmployeefund(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'amount' => ['required'],
            'date' => ['required'],
        ]);
        $empamount = EmployeeFund::findOrfail($id)->update([
            'amount' => $request['amount'],
            'month' => $request['date'],
        ]);

        return back()->with('success', 'Classic Fund updated Successfully');
    }
    public function deleteEmployeefund($id)
    {
        $fund = EmployeeFund::findOrfail($id);
        $fund->delete();
        return back()->with('success', 'Fund Deleted Successfully');
    }
    // employee service insentive 
    public function storeEmployeeservice(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'amount' => ['required'],
            'date' => ['required'],
            'description' => ['required'],
            'title' => ['required'],
        ]);
        $empamount = EmployeeService::create([
            'amount' => $request['amount'],
            'date' => $request['date'],
            'employee_id' => $request['emp_id'],
            'title' => $request['title'],
            'description' => $request['description'],
            'created_by' => auth()->user()->id,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Service Insentive Added Successfully');
    }
    public function updateEmployeeservice(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'amount' => ['required'],
            'date' => ['required'],
            'description' => ['required'],
            'title' => ['required'],
        ]);
        $empamount = EmployeeService::findOrfail($id)->update([
            'amount' => $request['amount'],
            'date' => $request['date'],
            'title' => $request['title'],
            'description' => $request['description'],
            'created_by' => auth()->user()->id,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Employee Service updated Successfully');
    }
    public function deleteEmployeeservice($id)
    {
        $fund = EmployeeService::findOrfail($id);
        $fund->delete();
        return back()->with('success', 'Employee Service Deleted Successfully');
    }
    public function payslip()
    {
        $payslips = EmployeePayslip::with('employee')->get();
        return view('employee::payslip.index', compact('payslips'));
    }
    public function payslipStore(Request $request)
    {
        $request->validate([
            'month' => ['required'],
        ]);
        $emp = EmployeeSalary::pluck('employee_id');
        foreach ($emp as $employeeId) {
            $employee = Employee::where('id', $employeeId)
                ->with('salary', 'allowance', 'insentive', 'advancePay', 'fund', 'service')
                ->first();

            $salary =  EmployeeSalary::select('salary')->where('employee_id', $employeeId)->first();
            $salary = $salary->salary;
            $fund = EmployeeFund::select('amount')->where('employee_id', $employeeId)->first();
            $fund = $fund->amount ?? 1000;
            $allowance = EmployeeAllowance::where('employee_id', $employeeId)->sum('amount');
            $sale_insentive = EmployeeSaleInsentive::where('employee_id', $employeeId)->sum('insentive_amount');
            $service_insentive = EmployeeService::where('employee_id', $employeeId)->sum('amount');
            $advancedPay = EmployeeAdvancePay::where('employee_id', $employeeId)->sum('amount');
            EmployeeAllowance::where('employee_id', $employeeId)->update(['status' => 'paid']);
            EmployeeSaleInsentive::where('employee_id', $employeeId)->update(['status' => 'paid']);
            $fund = EmployeeFund::where('employee_id', $employeeId)->update(['status' => 'paid']);
            EmployeeService::where('employee_id', $employeeId)->update(['status' => 'paid']);
            EmployeeAdvancePay::where('employee_id', $employeeId)->update(['status' => 'paid']);
            $net_salary = $salary + $allowance + $sale_insentive + $service_insentive - $fund - $advancedPay;

            $empamount = EmployeePayslip::create([
                'salary' => $salary,
                'net_salary' => $net_salary,
                'fund' => $fund,
                'sales_insentive' => $sale_insentive,
                'service_insentive' => $service_insentive,
                'advance_pay' => $advancedPay,
                'allowance' => $allowance,
                'month' => $request['month'],
                'employee_id' => $employeeId,
                'status' => 'unpaid',
                'created_by' => auth()->user()->id,
            ]);
        }
        $message = $request['month'] . ' Payslip Generated Successfully';
        return back()->with('success', $message);
    }
    public function fetchPayslip(Request $request)
    {
        $month = $request->input('month');
        $payslips = EmployeePayslip::where('month', $month)
            // ->where('status','unpaid')
            ->with('employee')->get();
        $html = '';
        if ($payslips->isEmpty()) {
            $html = '
                <tr>
                    <td colspan="7" class="text-center">Payslip not found for the selected month.</td>
                </tr>';
        } else {
            foreach ($payslips as $payslip) {
                $html .= '
                <tr>
                    <td><a class="btn btn-outline-primary">#EMP0000' . $payslip->employee_id . '</a></td>
                    <td>' . $payslip->employee->name . '</td>
                    <td>' . 'Monthly' . '</td>
                    <td>Rs.' . number_format($payslip->salary, 2) . '</td>
                    <td>Rs.' . number_format($payslip->net_salary, 2) . '</td>
                    <td>
                        <div class="badge bg-' . ($payslip->status == 'paid' ? 'success' : 'danger') . ' p-2 px-3 rounded">
                            <a href="#" class="text-white">' . $payslip->status . '</a>
                        </div>
                    </td>
                    <td>
                <a href="javascript:void(0);" class="btn-sm btn btn-warning c" data-id="' . $payslip->id . '">Payslip</a>
                <a href="javascript:void(0);" class="btn-sm btn btn-primary click-to-paid" data-id="' . $payslip->id . '">Click To Paid</a>
                <a href="javascript:void(0);" class="btn-sm btn btn-danger delete-payslip" data-id="' . $payslip->id . '">Delete</a>
                    </td>
                </tr>';
            }
        }

        // Return response as JSON with the HTML
        return response()->json(['html' => $html]);
    }
    public function markAsPaid(Request $request)
    {
        $payslipId = $request->input('id');
        $payslip = EmployeePayslip::find($payslipId);

        if ($payslip) {
            $payslip->status = 'paid';
            $payslip->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
    public function deletePayslip(Request $request)
    {
        $payslipId = $request->input('id');
        // Find the payslip by ID and delete it
        $payslip = EmployeePayslip::find($payslipId);

        if ($payslip) {
            $payslip->delete();
            return response()->json(['success' => true, 'message' => 'Payslip deleted successfully']);
        }

        return response()->json(['success' => false, 'message' => 'Payslip not found']);
    }
    public function viewPayslip(Request $request)
{
    $payslipId = $request->input('id');

    // Fetch payslip data
    $payslip = EmployeePayslip::find($payslipId);

    if ($payslip) {
        // You can customize this view (create a separate blade for it)
        $html = view('employee::payslip.view', compact('payslip'))->render();

        return response()->json(['success' => true, 'html' => $html]);
    }

    return response()->json(['success' => false, 'message' => 'Payslip not found']);
}

}
