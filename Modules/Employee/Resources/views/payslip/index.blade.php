@extends('setting::layouts.master')

@section('title', 'Users')

@section('third_party_stylesheets')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="dash-content">

                    <div class="page-header">
                        <div class="page-block">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="page-header-title">
                                        <h4 class="m-b-10">
                                            Payslip
                                        </h4>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                        <li class="breadcrumb-item"> Payslip</li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-sm-12 col-lg-12 col-xl-12 col-md-12 mt-4">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('payslip.store') }}">
                                            @csrf
                                            <div class="d-flex align-items-center justify-content-end">
                                                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12 mx-2">
                                                    <div class="btn-box">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon1">Month
                                                                </span>
                                                            </div>
                                                            <input type="month" class="form-control" name="month"
                                                                required>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-auto float-end ms-2">
                                                    <button type="submit" href="#" class="btn  btn-primary">Generate
                                                        Payslip
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-md-4" style="margin-bottom: 10px;">
                                                <div class="d-flex align-items-center justify-content-start">
                                                    <h5>Find Employee Payslip</h5>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="d-flex align-items-center justify-content-end">
                                                    <div class="col-lg-3 col-md-6 col-sm-12 col-12 mx-2">
                                                        <div class="btn-box">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"
                                                                        id="basic-addon1">Month</span>
                                                                </div>
                                                                <input type="month" class="form-control"
                                                                    name="payslip_month" id="payslip_month" required>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <form method="POST" id="payslip_form"><input name="_token"
                                                            type="hidden" value="hPTy7j4GdQtDjGnAeeF2juveIYH93yirqGXB6D4b">
                                                        <input type="hidden" name="filter_month" class="filter_month"
                                                            value="07">
                                                        <input type="hidden" name="filter_year" class="filter_year"
                                                            value="2024">
                                                    </form>

                                                    <div class="ml-2 float-end">
                                                        <input type="button" value="Bulk Payment" class="btn btn-primary"
                                                            style="margin-left: 5px" id="bulk_payment">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <div
                                                class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">

                                                <div class="datatable">
                                                    <table id="example1" class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Employee Id</th>
                                                                <th>Name</th>
                                                                <th>Payroll Type</th>
                                                                <th>Salary</th>
                                                                <th>Net Salary</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="payslip-data">
                                                            @foreach ($payslips as $payslip)
                                                                <tr>
                                                                    <td>
                                                                        <a
                                                                            class="btn btn-outline-primary">#EMP0000{{ $payslip->employee_id }}</a>
                                                                    </td>
                                                                    <td>{{ $payslip->employee->name }}</td>
                                                                    <td>Monthly Payslip</td>
                                                                    <td>Rs. {{ $payslip->salary }}</td>
                                                                    <td>Rs. {{ $payslip->net_salary }}</td>
                                                                    <td>
                                                                        <div
                                                                            class="badge bg-{{ $payslip->status == 'paid' ? 'success' : 'danger' }} p-2 px-3 rounded">
                                                                            <a href="#"
                                                                                class="text-white">{{ ucfirst($payslip->status) }}</a>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <a href="javascript:void(0);" class=" btn-sm btn btn-warning view-payslip"
                                                                            data-title="Employee Payslip" data-id="{{ $payslip->id }}">Payslip</a>
                                                                        @if ($payslip->status == 'paid')
                                                                        @else
                                                                            <a class="btn-sm btn btn-primary">Click To
                                                                                Paid</a>
                                                                        @endif
                                                                        <a href="javascript:void(0);" class="btn-sm btn btn-danger delete-payslip" data-id="{{ $payslip->id }}">Delete</a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th>Employee Id</th>
                                                                <th>Name</th>
                                                                <th>Payroll Type</th>
                                                                <th>Salary</th>
                                                                <th>Net Salary</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- Modal -->
<div class="modal fade" id="commonModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Employee Payslip</h5>
                <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
            </div>
            <div class="modal-body">
                <div id="payslip-content">
                    <!-- Payslip details will be dynamically inserted here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="window.print()"><i class="fa fa-printer"></i>Print Payslip</button>

            </div>
        </div>
    </div>
</div>


    <script>
        document.getElementById('payslip_month').addEventListener('change', function() {
            let month = this.value;
            if (month) {
                fetchPayslipData(month);
            }
        });

        function fetchPayslipData(month) {
            $.ajax({
                url: '{{ route('payslip.fetch') }}', // Update this route accordingly
                method: 'GET',
                data: {
                    month: month
                },
                success: function(response) {
                    $('#payslip-data').html(response.html);
                },
                error: function(xhr) {
                    console.log("Error fetching payslip data", xhr);
                }
            });
        }
        $(document).on('click', '.click-to-paid', function(e) {
            e.preventDefault();

            let payslipId = $(this).data('id'); // Get the payslip ID

            $.ajax({
                url: '{{ route('payslip.markAsPaid') }}', // Update this route accordingly
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', // CSRF token for security
                    id: payslipId
                },
                success: function(response) {
                    if (response.success) {
                        alert('Payslip marked as paid successfully!');
                        location.reload(); // Reload the page or update the table dynamically
                    } else {
                        alert('Error: Could not update payslip status.');
                    }
                },
                error: function(xhr) {
                    console.log("Error updating payslip status", xhr);
                }
            });
        });
        // Delete Payslip
        $(document).on('click', '.delete-payslip', function(e) {
    e.preventDefault();

    let payslipId = $(this).data('id'); // Get the payslip ID

    if (confirm("Are you sure you want to delete this payslip?")) {
        $.ajax({
            url: '{{ route("payslip.delete") }}', // Ensure the route is correct
            method: 'POST', // Use POST method
            data: {
                _token: '{{ csrf_token() }}', // CSRF token for security
                id: payslipId
            },
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    // Remove the payslip row from the table
                    $('a[data-id="' + payslipId + '"]').closest('tr').remove();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr) {
                console.log("Error deleting payslip", xhr);
            }
        });
    }
});
$(document).on('click', '.view-payslip', function() {
    let payslipId = $(this).data('id'); // Get the payslip ID
    // Make AJAX call to fetch the payslip data
    $.ajax({
        url: '{{ route('payslip.view') }}', // Make sure this route is defined in your backend
        method: 'GET',
        data: {
            id: payslipId
        },
        success: function(response) {
            if (response.success) {
                // Inject the payslip HTML content into the modal body
                $('#payslip-content').html(response.html);
                // Show the modal
                $('#commonModal').modal('show');
            } else {
                alert('Error: Could not retrieve payslip.');
            }
        },
        error: function(xhr) {
            console.log("Error fetching payslip", xhr);
        }
    });
});

        </script>
@endsection
