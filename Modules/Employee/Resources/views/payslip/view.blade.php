<div class="card shadow border-0">
    <div class="card-body">

        <h4 class="text-center text-primary mb-3">
            Payslip - {{ \Carbon\Carbon::parse($payslip->month)->format('F Y') }}
        </h4>

        <strong>Name :</strong> {{ $payslip->employee->name }} <br>
        <strong>Employee ID :</strong> #EMP{{ $payslip->employee_id }} <br>

        <hr>

        {{-- DAYS --}}
        <div class="row text-center mb-3">
            <div class="col-md-3">
                <span class="badge badge-success p-2">Present: {{ $presentDays }}</span>
            </div>
            <div class="col-md-3">
                <span class="badge badge-info p-2">Holiday: {{ $holidays }}</span>
            </div>
            <div class="col-md-3">
                <span class="badge badge-warning p-2">Leave: {{ $leaves }}</span>
            </div>
            <div class="col-md-3">
                <span class="badge badge-primary p-2">Total Paid: {{ $totalPaidDays }}</span>
            </div>
        </div>

        {{-- EARNING --}}
        <table class="table table-bordered">
            <thead class="bg-success text-white">
                <tr>
                    <th>Earnings</th>
                    <th class="text-right">Amount</th>
                </tr>
            </thead>
            <tr>
                <td>Salary</td>
                <td class="text-right">Rs. {{ number_format($payslip->salary, 2) }}</td>
            </tr>
            <tr>
                <td>Allowance</td>
                <td class="text-right">Rs. {{ number_format($payslip->allowance, 2) }}</td>
            </tr>
            <tr>
                <td>Sales Incentive</td>
                <td class="text-right">Rs. {{ number_format($payslip->sales_insentive, 2) }}</td>
            </tr>
            <tr>
                <td>Service Incentive</td>
                <td class="text-right">Rs. {{ number_format($payslip->service_insentive, 2) }}</td>
            </tr>
        </table>

        {{-- DEDUCTION --}}
        <table class="table table-bordered">
            <thead class="bg-danger text-white">
                <tr>
                    <th>Deductions</th>
                    <th class="text-right">Amount</th>
                </tr>
            </thead>
            <tr>
                <td>Advance</td>
                <td class="text-right">Rs. {{ number_format($payslip->advance_pay, 2) }}</td>
            </tr>
            <tr>
                <td>Fund</td>
                <td class="text-right">Rs. {{ number_format($payslip->fund, 2) }}</td>
            </tr>
        </table>

        @php
            $totalEarning = $payslip->salary + $payslip->allowance + $payslip->sales_insentive + $payslip->service_insentive;
            $totalDeduction = $payslip->advance_pay + $payslip->fund;
        @endphp

        <div class="text-right mt-3">
            <h5>Total Earning: <strong>Rs. {{ number_format($totalEarning, 2) }}</strong></h5>
            <h5>Total Deduction: <strong>Rs. {{ number_format($totalDeduction, 2) }}</strong></h5>
            <h4 class="text-success">Net Salary: Rs. {{ number_format($totalEarning - $totalDeduction, 2) }}</h4>
        </div>

    </div>
</div>