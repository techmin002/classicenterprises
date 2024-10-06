
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <strong>Name :</strong> {{ $payslip->employee->name }}<br>
                <strong>Salary Date :</strong> {{ \Carbon\Carbon::parse($payslip->month)->format('M d, Y') }}<br>

                <table class="table table-md">
                    <tr>
                        <th>Earning</th>
                        <th>Amount</th>
                    </tr>
                    <tr>
                        <td>Basic Salary</td>
                        <td>{{ number_format($payslip->salary, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Allowance</td>
                        <td>{{ number_format($payslip->allowance, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Sale Insentive</td>
                        <td>{{ number_format($payslip->sales_insentive, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Service Insentive</td>
                        <td>{{ number_format($payslip->service_insentive, 2) }}</td>
                    </tr>
                </table>
                <table class="table table-md">
                    <tr>
                        <th>Deduction</th>
                        <th>Amount</th>
                    </tr>
                    <tr>
                        <td>Advanced Pay</td>
                        <td>{{ number_format($payslip->advance_pay, 2) }}</td>
                        
                    </tr>
                    <tr>
                        <td>Classic Fund</td>
                            <td>{{ number_format($payslip->fund, 2) }}</td>
                    </tr>
                    <!-- Add more deduction rows -->
                </table>
            </div>
            @php
                $totalEarning = $payslip->salary + $payslip->allowance + $payslip->service_insentive + $payslip->sales_insentive;
                $totalDeduction = $payslip->advance_pay + $payslip->fund
            @endphp

            <div class="card-body">
                <strong>Total Earning: </strong> Rs. {{ number_format($totalEarning, 2) }}<br>
                    <strong>Total Deduction: </strong> Rs. {{ number_format($totalDeduction, 2) }}<br>
                    <strong>Net Salary: </strong> Rs. {{ number_format($totalEarning-$totalDeduction, 2) }}<br>
            </div>
        </div>
    </div>
</div>
