@extends('setting::layouts.master')

@section('title', ' Report')

@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Report</li>
</ol>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Outsider Customer Ticket Report</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Report</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>


    <section class="content">
        <div class="container-fluid">
            <!-- Top-level Tabs -->
            <ul class="nav nav-pills mb-4 d-flex gap-3" id="mainTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="tab-maintenance" data-bs-toggle="pill" data-bs-target="#content-maintenance" type="button" role="tab" aria-controls="content-maintenance" aria-selected="true">Maintenance</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-filterleakage" data-bs-toggle="pill" data-bs-target="#content-filterleakage" type="button" role="tab" aria-controls="content-filterleakage" aria-selected="false">Filter Leakage</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-locationshifting" data-bs-toggle="pill" data-bs-target="#content-locationshifting" type="button" role="tab" aria-controls="content-locationshifting" aria-selected="false">Location Shifting</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-regularservice" data-bs-toggle="pill" data-bs-target="#content-regularservice" type="button" role="tab" aria-controls="content-regularservice" aria-selected="false">Regular Service</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-installation" data-bs-toggle="pill" data-bs-target="#content-installation" type="button" role="tab" aria-controls="content-installation" aria-selected="false">Installation</button>
                </li>
            </ul>

            <!-- Top-level Tab Content -->
            <div class="tab-content" id="mainTabsContent">

                <!-- Maintenance -->
                <div class="tab-pane fade show active" id="content-maintenance" role="tabpanel" aria-labelledby="tab-maintenance">
                    <div class="card border-primary mb-4">
                        <div class="card-header bg-primary text-white">
                            <h3>Maintenance</h3>
                        </div>
                        <div class="card-body p-2">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Mobile</th>
                                            <th class="text-center">Address</th>
                                            <th class="text-center">Product</th>
                                            <th class="text-center">Amount</th>
                                            <th class="text-center">Paid</th>
                                            <th class="text-center">Due</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($maintanance as $key => $customer)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $customer->customer_name }}</td>
                                            <td class="text-center">{{ $customer->contact }}</td>
                                            <td class="text-center">{{ $customer->address }}</td>
                                            <td class="text-center">{{ $customer->product_name }}</td>
                                            <td class="text-center">{{ $customer->total_amount }}</td>
                                            <td class="text-center">{{ $customer->paid_amount ?? '0' }}</td>
                                            <td class="text-center text-danger">{{ $customer->due_amount }}</td>
                                            <td class="text-center">
                                                <a type="button" href="{{ route('ticket_customer.details', $customer->id) }}" class="btn btn-info btn-sm" disabled data-toggle="tooltip" data-placement="top" title="Details">Detail's
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Mobile</th>
                                            <th class="text-center">Address</th>
                                            <th class="text-center">Product</th>
                                            <th class="text-center">Amount</th>
                                            <th class="text-center">Paid</th>
                                            <th class="text-center">Due</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Leakage -->
                <div class="tab-pane fade" id="content-filterleakage" role="tabpanel" aria-labelledby="tab-filterleakage">
                    <div class="card border-warning mb-4">
                        <div class="card-header bg-warning text-white">
                            <h3>Filter Leakage</h3>
                        </div>
                        <div class="card-body p-2">
                            <div class="table-responsive">
                                <table id="example3" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Mobile</th>
                                            <th class="text-center">Address</th>
                                            <th class="text-center">Product</th>
                                            <th class="text-center">Amount</th>
                                            <th class="text-center">Paid</th>
                                            <th class="text-center">Due</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($filter as $key => $customer)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $customer->customer_name }}</td>
                                            <td class="text-center">{{ $customer->contact }}</td>
                                            <td class="text-center">{{ $customer->address }}</td>
                                            <td class="text-center">{{ $customer->product_name }}</td>
                                            <td class="text-center">{{ $customer->total_amount }}</td>
                                            <td class="text-center">{{ $customer->paid_amount ?? '0' }}</td>
                                            <td class="text-center text-danger">{{ $customer->due_amount }}</td>
                                            <td class="text-center">
                                                <a type="button" href="{{ route('ticket_customer.details', $customer->id) }}" class="btn btn-info btn-sm" disabled data-toggle="tooltip" data-placement="top" title="Details">Detail's
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Mobile</th>
                                            <th class="text-center">Address</th>
                                            <th class="text-center">Product</th>
                                            <th class="text-center">Amount</th>
                                            <th class="text-center">Paid</th>
                                            <th class="text-center">Due</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Location Shifting -->
                <div class="tab-pane fade" id="content-locationshifting" role="tabpanel" aria-labelledby="tab-locationshifting">
                    <div class="card border-secondary mb-4">
                        <div class="card-header bg-secondary text-white">
                            <h3>Location Shifting</h3>
                        </div>
                        <div class="card-body p-2">
                            <div class="table-responsive">
                                <table id="example5" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Mobile</th>
                                            <th class="text-center">Address</th>
                                            <th class="text-center">Product</th>
                                            <th class="text-center">Amount</th>
                                            <th class="text-center">Paid</th>
                                            <th class="text-center">Due</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($location as $key => $customer)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $customer->customer_name }}</td>
                                            <td class="text-center">{{ $customer->contact }}</td>
                                            <td class="text-center">{{ $customer->address }}</td>
                                            <td class="text-center">{{ $customer->product_name }}</td>
                                            <td class="text-center">{{ $customer->total_amount }}</td>
                                            <td class="text-center">{{ $customer->paid_amount ?? '0' }}</td>
                                            <td class="text-center text-danger">{{ $customer->due_amount }}</td>
                                            <td class="text-center">
                                                <a type="button" href="{{ route('ticket_customer.details', $customer->id) }}" class="btn btn-info btn-sm" disabled data-toggle="tooltip" data-placement="top" title="Details">Detail's
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Mobile</th>
                                            <th class="text-center">Address</th>
                                            <th class="text-center">Product</th>
                                            <th class="text-center">Amount</th>
                                            <th class="text-center">Paid</th>
                                            <th class="text-center">Due</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Regular Service -->
                <div class="tab-pane fade" id="content-regularservice" role="tabpanel" aria-labelledby="tab-regularservice">
                    <div class="card border-dark mb-4">
                        <div class="card-header bg-dark text-white">
                            <h3>Regular Service</h3>
                        </div>
                        <div class="card-body p-2">
                            <div class="table-responsive">
                                <table id="example7" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Mobile</th>
                                            <th class="text-center">Address</th>
                                            <th class="text-center">Product</th>
                                            <th class="text-center">Amount</th>
                                            <th class="text-center">Paid</th>
                                            <th class="text-center">Due</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($regular as $key => $customer)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $customer->customer_name }}</td>
                                            <td class="text-center">{{ $customer->contact }}</td>
                                            <td class="text-center">{{ $customer->address }}</td>
                                            <td class="text-center">{{ $customer->product_name }}</td>
                                            <td class="text-center">{{ $customer->total_amount }}</td>
                                            <td class="text-center">{{ $customer->paid_amount ?? '0' }}</td>
                                            <td class="text-center text-danger">{{ $customer->due_amount }}</td>
                                            <td class="text-center">
                                                <a type="button" href="{{ route('ticket_customer.details', $customer->id) }}" class="btn btn-info btn-sm" disabled data-toggle="tooltip" data-placement="top" title="Details">Detail's
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Mobile</th>
                                            <th class="text-center">Address</th>
                                            <th class="text-center">Product</th>
                                            <th class="text-center">Amount</th>
                                            <th class="text-center">Paid</th>
                                            <th class="text-center">Due</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Installation -->
                <div class="tab-pane fade" id="content-installation" role="tabpanel" aria-labelledby="tab-installation">
                    <div class="card border-info mb-4">
                        <div class="card-header bg-info text-white">
                            <h3>Installation</h3>
                        </div>
                        <div class="card-body p-2">
                            <div class="table-responsive">
                                <table id="example2" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Mobile</th>
                                            <th class="text-center">Address</th>
                                            <th class="text-center">Product</th>
                                            <th class="text-center">Amount</th>
                                            <th class="text-center">Paid</th>
                                            <th class="text-center">Due</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($installation as $key => $customer)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $customer->customer_name }}</td>
                                            <td class="text-center">{{ $customer->contact }}</td>
                                            <td class="text-center">{{ $customer->address }}</td>
                                            <td class="text-center">{{ $customer->product_name }}</td>
                                            <td class="text-center">{{ $customer->total_amount }}</td>
                                            <td class="text-center">{{ $customer->paid_amount ?? '0' }}</td>
                                            <td class="text-center text-danger">{{ $customer->due_amount }}</td>
                                            <td class="text-center">
                                                <a type="button" href="{{ route('ticket_customer.details', $customer->id) }}" class="btn btn-info btn-sm" disabled data-toggle="tooltip" data-placement="top" title="Details">Detail's
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Mobile</th>
                                            <th class="text-center">Address</th>
                                            <th class="text-center">Product</th>
                                            <th class="text-center">Amount</th>
                                            <th class="text-center">Paid</th>
                                            <th class="text-center">Due</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>




</div>
<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })

</script>
<script>
    document.querySelectorAll('.view-btn').forEach(btn => {
        const box = btn.closest('td').querySelector('.details-box');

        btn.addEventListener('mouseenter', () => {
            box.style.display = 'block';
        });

        btn.addEventListener('mouseleave', () => {
            // Hide only after a small delay to allow smooth hover transition
            setTimeout(() => {
                if (!box.matches(':hover')) {
                    box.style.display = 'none';
                }
            }, 150);
        });

        box.addEventListener('mouseenter', () => {
            box.style.display = 'block';
        });

        box.addEventListener('mouseleave', () => {
            box.style.display = 'none';
        });
    });

</script>

@endsection
