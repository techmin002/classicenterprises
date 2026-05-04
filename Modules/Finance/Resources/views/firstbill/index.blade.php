@extends('setting::layouts.master')

@section('title', 'First Bill')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">First Bill</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>First Bill</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">First Bill</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        {{-- ✅ INSTALLATION CUSTOMERS TABLE --}}
                        <div class="card">
                            <div class="card-header">
                                <h4><i class="fas fa-tools mr-2"></i>Installation Due Payments</h4>
                            </div>
                            <div class="card-body">
                                <table id="installationTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">Paid</th>
                                            <th class="text-center">Due</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($customers as $customer)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ optional($customer->lead)->name ?? '-' }}</td>
                                                <td class="text-center">Rs. {{ number_format($customer->total_amount) }}</td>
                                                <td class="text-center">Rs. {{ number_format($customer->paid_amount ?? 0) }}</td>
                                                <td class="text-center">Rs. {{ number_format($customer->due_amount) }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('customer.payment.details', $customer->id) }}"
                                                        class="btn btn-primary btn-sm"
                                                        data-toggle="tooltip" title="Payment Details">
                                                        Payment Details
                                                    </a>
                                                    <a href="{{ route('customer.details', $customer->id) }}"
                                                        class="btn btn-info btn-sm"
                                                        data-toggle="tooltip" title="View Details">
                                                        View Details
                                                    </a>
                                                    {{-- @if ($customer->due_amount > 0)
                                                        <a type="button"
                                                            data-toggle="modal"
                                                            data-target="#pay{{ $customer->id }}"
                                                            class="btn btn-success btn-sm">
                                                            Pay
                                                        </a>
                                                        @include('finance::Payment.pay')
                                                    @endif --}}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted">No pending installation payments.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">Paid</th>
                                            <th class="text-center">Due</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        {{-- ✅ TICKET DUE PAYMENTS TABLE --}}
                        <div class="card mt-4">
                            <div class="card-header">
                                <h4><i class="fas fa-ticket-alt mr-2"></i>Ticket Due Payments</h4>
                            </div>
                            <div class="card-body">
                                <table id="ticketTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Customer Name</th>
                                            <th class="text-center">Support Type</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">Paid</th>
                                            <th class="text-center">Due</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($tickets as $ticket)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">
                                                    {{ optional(optional($ticket->customer)->lead)->name ?? $ticket->customer_name ?? '-' }}
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge badge-info">
                                                        {{ ucfirst(str_replace('_', ' ', $ticket->support_type ?? '-')) }}
                                                    </span>
                                                </td>
                                                <td class="text-center">Rs. {{ number_format($ticket->total_amount ?? 0) }}</td>
                                                <td class="text-center">Rs. {{ number_format($ticket->paid_amount ?? 0) }}</td>
                                                <td class="text-center">Rs. {{ number_format($ticket->due_amount ?? 0) }}</td>
                                                <td class="text-center">
                                                    {{-- Add ticket pay modal/button here if needed --}}
                                                    <span class="badge badge-warning p-2">Pending</span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted">No pending ticket payments.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Customer Name</th>
                                            <th class="text-center">Support Type</th>
                                            <th class="text-center">Total</th>
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
        </section>
    </div>

    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();

            $('#installationTable').DataTable({
                "responsive": true,
                "autoWidth": false,
            });

            $('#ticketTable').DataTable({
                "responsive": true,
                "autoWidth": false,
            });
        });
    </script>
@endsection