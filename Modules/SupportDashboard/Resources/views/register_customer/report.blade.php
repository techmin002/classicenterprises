@extends('setting::layouts.master')

@section('title', 'Customer Ticket Report')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Customer Ticket Report</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Register Customer Ticket Report</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Report</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <!-- Top-level Tabs -->
                <ul class="nav nav-pills mb-4" id="mainTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="tab-maintenance" data-toggle="pill" href="#content-maintenance" role="tab" aria-controls="content-maintenance" aria-selected="true">Maintenance</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab-filterleakage" data-toggle="pill" href="#content-filterleakage" role="tab" aria-controls="content-filterleakage" aria-selected="false">Filter Leakage</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab-locationshifting" data-toggle="pill" href="#content-locationshifting" role="tab" aria-controls="content-locationshifting" aria-selected="false">Location Shifting</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab-regularservice" data-toggle="pill" href="#content-regularservice" role="tab" aria-controls="content-regularservice" aria-selected="false">Regular Service</a>
                    </li>
                </ul>

                <!-- Top-level Tab Content -->
                <div class="tab-content" id="mainTabsContent">
                    <!-- Maintenance Tab -->
                    <div class="tab-pane fade show active" id="content-maintenance" role="tabpanel" aria-labelledby="tab-maintenance">
                        <div class="card card-primary card-outline">
                            <div class="card-header bg-primary text-white">
                                <h3 class="card-title">Maintenance Reports</h3>
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-pills mb-3" id="maintenanceSubTabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="warranty-in-tab" data-toggle="pill" href="#warranty-in" role="tab" aria-controls="warranty-in" aria-selected="true">Warranty In</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="warranty-out-tab" data-toggle="pill" href="#warranty-out" role="tab" aria-controls="warranty-out" aria-selected="false">Warranty Out</a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="warranty-in" role="tabpanel" aria-labelledby="warranty-in-tab">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped data-table">
                                                <thead>
                                                    <tr>
                                                        <th>S.N</th>
                                                        <th>Name</th>
                                                        <th>Mobile</th>
                                                        <th>Address</th>
                                                        <th>Product</th>
                                                        <th>Amount</th>
                                                        <th>Paid</th>
                                                        <th>Due</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($maintanancein as $customer)
                                                        <tr>
                                                            <td class="text-center">{{ $loop->iteration }}</td>
                                                            <td>{{ $customer->customer->lead->name ?? 'N/A' }}</td>
                                                            <td>{{ $customer->customer->lead->mobile ?? 'N/A' }}</td>
                                                            <td>{{ $customer->customer->lead->address ?? 'N/A' }}</td>
                                                            <td>
                                                                @foreach($customer->customer->products as $customerProduct)
                                                                    {{ $customerProduct->product->name }}{{ !$loop->last ? ', ' : '' }}
                                                                @endforeach
                                                            </td>
                                                            <td class="text-right">{{ number_format($customer->total_amount, 2) }}</td>
                                                            <td class="text-right">{{ number_format($customer->paid_amount ?? 0, 2) }}</td>
                                                            <td class="text-right text-danger">{{ number_format($customer->due_amount, 2) }}</td>
                                                            <td class="text-center">
                                                                <a href="{{ route('ticket_customer.details', $customer->id) }}" class="btn btn-info btn-sm" title="View Details">
                                                                    <i class="fa fa-eye"></i> Details
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="9" class="text-center">No records found</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="warranty-out" role="tabpanel" aria-labelledby="warranty-out-tab">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped data-table">
                                                <thead>
                                                    <tr>
                                                        <th>S.N</th>
                                                        <th>Name</th>
                                                        <th>Mobile</th>
                                                        <th>Address</th>
                                                        <th>Product</th>
                                                        <th>Amount</th>
                                                        <th>Paid</th>
                                                        <th>Due</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($maintananceout as $customer)
                                                        <tr>
                                                            <td class="text-center">{{ $loop->iteration }}</td>
                                                            <td>{{ $customer->customer->lead->name ?? 'N/A' }}</td>
                                                            <td>{{ $customer->customer->lead->mobile ?? 'N/A' }}</td>
                                                            <td>{{ $customer->customer->lead->address ?? 'N/A' }}</td>
                                                            <td>
                                                                @foreach($customer->customer->products as $customerProduct)
                                                                    {{ $customerProduct->product->name }}{{ !$loop->last ? ', ' : '' }}
                                                                @endforeach
                                                            </td>
                                                            <td class="text-right">{{ number_format($customer->total_amount, 2) }}</td>
                                                            <td class="text-right">{{ number_format($customer->paid_amount ?? 0, 2) }}</td>
                                                            <td class="text-right text-danger">{{ number_format($customer->due_amount, 2) }}</td>
                                                            <td class="text-center">
                                                                <a href="{{ route('ticket_customer.details', $customer->id) }}" class="btn btn-info btn-sm" title="View Details">
                                                                    <i class="fa fa-eye"></i> Details
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="9" class="text-center">No records found</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Leakage Tab -->
                    <div class="tab-pane fade" id="content-filterleakage" role="tabpanel" aria-labelledby="tab-filterleakage">
                        <div class="card card-warning card-outline">
                            <div class="card-header bg-warning text-white">
                                <h3 class="card-title">Filter Leakage Reports</h3>
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-pills mb-3" id="filterLeakageSubTabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="filter-warranty-in-tab" data-toggle="pill" href="#filter-warranty-in" role="tab">Warranty In</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="filter-warranty-out-tab" data-toggle="pill" href="#filter-warranty-out" role="tab">Warranty Out</a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="filter-warranty-in">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped data-table">
                                                <thead>
                                                    <tr>
                                                        <th>S.N</th>
                                                        <th>Name</th>
                                                        <th>Mobile</th>
                                                        <th>Address</th>
                                                        <th>Product</th>
                                                        <th>Amount</th>
                                                        <th>Paid</th>
                                                        <th>Due</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($filterin as $customer)
                                                        <tr>
                                                            <td class="text-center">{{ $loop->iteration }}</td>
                                                            <td>{{ $customer->customer->lead->name ?? 'N/A' }}</td>
                                                            <td>{{ $customer->customer->lead->mobile ?? 'N/A' }}</td>
                                                            <td>{{ $customer->customer->lead->address ?? 'N/A' }}</td>
                                                            <td>
                                                                @foreach($customer->customer->products as $customerProduct)
                                                                    {{ $customerProduct->product->name }}{{ !$loop->last ? ', ' : '' }}
                                                                @endforeach
                                                            </td>
                                                            <td class="text-right">{{ number_format($customer->total_amount, 2) }}</td>
                                                            <td class="text-right">{{ number_format($customer->paid_amount ?? 0, 2) }}</td>
                                                            <td class="text-right text-danger">{{ number_format($customer->due_amount, 2) }}</td>
                                                            <td class="text-center">
                                                                <a href="{{ route('ticket_customer.details', $customer->id) }}" class="btn btn-info btn-sm">Details</a>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="9" class="text-center">No records found</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="filter-warranty-out">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped data-table">
                                                <thead>
                                                    <tr>
                                                        <th>S.N</th>
                                                        <th>Name</th>
                                                        <th>Mobile</th>
                                                        <th>Address</th>
                                                        <th>Product</th>
                                                        <th>Amount</th>
                                                        <th>Paid</th>
                                                        <th>Due</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($filterout as $customer)
                                                        <tr>
                                                            <td class="text-center">{{ $loop->iteration }}</td>
                                                            <td>{{ $customer->customer->lead->name ?? 'N/A' }}</td>
                                                            <td>{{ $customer->customer->lead->mobile ?? 'N/A' }}</td>
                                                            <td>{{ $customer->customer->lead->address ?? 'N/A' }}</td>
                                                            <td>
                                                                @foreach($customer->customer->products as $customerProduct)
                                                                    {{ $customerProduct->product->name }}{{ !$loop->last ? ', ' : '' }}
                                                                @endforeach
                                                            </td>
                                                            <td class="text-right">{{ number_format($customer->total_amount, 2) }}</td>
                                                            <td class="text-right">{{ number_format($customer->paid_amount ?? 0, 2) }}</td>
                                                            <td class="text-right text-danger">{{ number_format($customer->due_amount, 2) }}</td>
                                                            <td class="text-center">
                                                                <a href="{{ route('ticket_customer.details', $customer->id) }}" class="btn btn-info btn-sm">Details</a>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="9" class="text-center">No records found</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Location Shifting Tab -->
                    <div class="tab-pane fade" id="content-locationshifting" role="tabpanel" aria-labelledby="tab-locationshifting">
                        <div class="card card-secondary card-outline">
                            <div class="card-header bg-secondary text-white">
                                <h3 class="card-title">Location Shifting Reports</h3>
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-pills mb-3" id="locationSubTabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="location-warranty-in-tab" data-toggle="pill" href="#location-warranty-in" role="tab">Warranty In</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="location-warranty-out-tab" data-toggle="pill" href="#location-warranty-out" role="tab">Warranty Out</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="location-warranty-in">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped data-table">
                                                <thead>
                                                    <tr>
                                                        <th>S.N</th>
                                                        <th>Name</th>
                                                        <th>Mobile</th>
                                                        <th>Address</th>
                                                        <th>Product</th>
                                                        <th>Amount</th>
                                                        <th>Paid</th>
                                                        <th>Due</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($locationin as $customer)
                                                        <tr>
                                                            <td class="text-center">{{ $loop->iteration }}</td>
                                                            <td>{{ $customer->customer->lead->name ?? 'N/A' }}</td>
                                                            <td>{{ $customer->customer->lead->mobile ?? 'N/A' }}</td>
                                                            <td>{{ $customer->customer->lead->address ?? 'N/A' }}</td>
                                                            <td>
                                                                @foreach($customer->customer->products as $customerProduct)
                                                                    {{ $customerProduct->product->name }}{{ !$loop->last ? ', ' : '' }}
                                                                @endforeach
                                                            </td>
                                                            <td class="text-right">{{ number_format($customer->total_amount, 2) }}</td>
                                                            <td class="text-right">{{ number_format($customer->paid_amount ?? 0, 2) }}</td>
                                                            <td class="text-right text-danger">{{ number_format($customer->due_amount, 2) }}</td>
                                                            <td class="text-center">
                                                                <a href="{{ route('ticket_customer.details', $customer->id) }}" class="btn btn-info btn-sm">Details</a>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="9" class="text-center">No records found</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="location-warranty-out">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped data-table">
                                                <thead>
                                                    <tr>
                                                        <th>S.N</th>
                                                        <th>Name</th>
                                                        <th>Mobile</th>
                                                        <th>Address</th>
                                                        <th>Product</th>
                                                        <th>Amount</th>
                                                        <th>Paid</th>
                                                        <th>Due</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($locationout as $customer)
                                                        <tr>
                                                            <td class="text-center">{{ $loop->iteration }}</td>
                                                            <td>{{ $customer->customer->lead->name ?? 'N/A' }}</td>
                                                            <td>{{ $customer->customer->lead->mobile ?? 'N/A' }}</td>
                                                            <td>{{ $customer->customer->lead->address ?? 'N/A' }}</td>
                                                            <td>
                                                                @foreach($customer->customer->products as $customerProduct)
                                                                    {{ $customerProduct->product->name }}{{ !$loop->last ? ', ' : '' }}
                                                                @endforeach
                                                            </td>
                                                            <td class="text-right">{{ number_format($customer->total_amount, 2) }}</td>
                                                            <td class="text-right">{{ number_format($customer->paid_amount ?? 0, 2) }}</td>
                                                            <td class="text-right text-danger">{{ number_format($customer->due_amount, 2) }}</td>
                                                            <td class="text-center">
                                                                <a href="{{ route('ticket_customer.details', $customer->id) }}" class="btn btn-info btn-sm">Details</a>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="9" class="text-center">No records found</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Regular Service Tab -->
                    <div class="tab-pane fade" id="content-regularservice" role="tabpanel" aria-labelledby="tab-regularservice">
                        <div class="card card-dark card-outline">
                            <div class="card-header bg-dark text-white">
                                <h3 class="card-title">Regular Service Reports</h3>
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-pills mb-3" id="regularServiceSubTabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="regular-warranty-in-tab" data-toggle="pill" href="#regular-warranty-in" role="tab">Warranty In</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="regular-warranty-out-tab" data-toggle="pill" href="#regular-warranty-out" role="tab">Warranty Out</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="regular-warranty-in">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped data-table">
                                                <thead>
                                                    <tr>
                                                        <th>S.N</th>
                                                        <th>Name</th>
                                                        <th>Mobile</th>
                                                        <th>Address</th>
                                                        <th>Product</th>
                                                        <th>Amount</th>
                                                        <th>Paid</th>
                                                        <th>Due</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($regularin as $customer)
                                                        <tr>
                                                            <td class="text-center">{{ $loop->iteration }}</td>
                                                            <td>{{ $customer->customer->lead->name ?? 'N/A' }}</td>
                                                            <td>{{ $customer->customer->lead->mobile ?? 'N/A' }}</td>
                                                            <td>{{ $customer->customer->lead->address ?? 'N/A' }}</td>
                                                            <td>
                                                                @foreach($customer->customer->products as $customerProduct)
                                                                    {{ $customerProduct->product->name }}{{ !$loop->last ? ', ' : '' }}
                                                                @endforeach
                                                            </td>
                                                            <td class="text-right">{{ number_format($customer->total_amount, 2) }}</td>
                                                            <td class="text-right">{{ number_format($customer->paid_amount ?? 0, 2) }}</td>
                                                            <td class="text-right text-danger">{{ number_format($customer->due_amount, 2) }}</td>
                                                            <td class="text-center">
                                                                <a href="{{ route('ticket_customer.details', $customer->id) }}" class="btn btn-info btn-sm">Details</a>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="9" class="text-center">No records found</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="regular-warranty-out">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped data-table">
                                                <thead>
                                                    <tr>
                                                        <th>S.N</th>
                                                        <th>Name</th>
                                                        <th>Mobile</th>
                                                        <th>Address</th>
                                                        <th>Product</th>
                                                        <th>Amount</th>
                                                        <th>Paid</th>
                                                        <th>Due</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($regularout as $customer)
                                                        <tr>
                                                            <td class="text-center">{{ $loop->iteration }}</td>
                                                            <td>{{ $customer->customer->lead->name ?? 'N/A' }}</td>
                                                            <td>{{ $customer->customer->lead->mobile ?? 'N/A' }}</td>
                                                            <td>{{ $customer->customer->lead->address ?? 'N/A' }}</td>
                                                            <td>
                                                                @foreach($customer->customer->products as $customerProduct)
                                                                    {{ $customerProduct->product->name }}{{ !$loop->last ? ', ' : '' }}
                                                                @endforeach
                                                            </td>
                                                            <td class="text-right">{{ number_format($customer->total_amount, 2) }}</td>
                                                            <td class="text-right">{{ number_format($customer->paid_amount ?? 0, 2) }}</td>
                                                            <td class="text-right text-danger">{{ number_format($customer->due_amount, 2) }}</td>
                                                            <td class="text-center">
                                                                <a href="{{ route('ticket_customer.details', $customer->id) }}" class="btn btn-info btn-sm">Details</a>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="9" class="text-center">No records found</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
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
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTables for all tables with class 'data-table'
        $('.data-table').each(function() {
            $(this).DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    search: "Search:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "→",
                        previous: "←"
                    }
                },
                columnDefs: [
                    { orderable: false, targets: -1 } // Disable ordering on action column
                ]
            });
        });

        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endpush