@extends('setting::layouts.master')

@section('title', 'EMI Payment Details')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('emiPayment.index') }}">EMI Payments</a></li>
        <li class="breadcrumb-item active">Payment Details</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>EMI Payment Details</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary">
                                <h3 class="card-title">Customer Summary</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <p><strong>Customer Name:</strong> {{ $emiCustomer->customer->lead->name }}</p>
                                        <p><strong>Email:</strong> {{ $emiCustomer->customer->lead->email }}</p>
                                        <p><strong>Phone:</strong> {{ $emiCustomer->customer->lead->mobile }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p><strong>Total Amount:</strong> Rs.
                                            {{ number_format($emiCustomer->customer->total_amount, 2) }}</p>
                                        <p><strong>Total Paid:</strong> Rs. {{ number_format($totalPaid, 2) }}</p>
                                        <p><strong>Due Amount:</strong> Rs. {{ number_format($dueAmount, 2) }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p><strong>EMI Plan:</strong> Rs.
                                            {{ $emiCustomer->emiPlan->title }}</p>
                                        <p><strong>EMI Rate:</strong>  {{$emiCustomer->emiPlan->interest_rate}}</p>
                                        <p><strong>Per Month Interest:</strong> Rs.{{number_format(($emiCustomer->customer->total_amount * $emiCustomer->emiPlan->interest_rate / 100)/12, 2) }} </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header bg-info">
                                <h3 class="card-title">Payment History</h3>
                                @if ($dueAmount > 0)
                                    <button class="btn btn-success btn-sm float-right" data-toggle="modal"
                                        data-target="#pay{{ $emiCustomer->id }}">
                                        <i class="fas fa-plus"></i> Add Payment
                                    </button>
                                @endif
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Amount (Rs.)</th>
                                            <th class="text-center">Payment Mode</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($emiCustomer->payments as $payment)
                                        
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-right">{{ number_format($payment->payment, 2) }}</td>
                                                <td class="text-center">{{ ucfirst($payment->payment_method) }}</td>
                                                <td class="text-center">
                                                    {{ \Carbon\Carbon::parse($payment->date)->format('d M Y') }}
                                                </td>
                                                <td class="text-center">
                                                    <span
                                                        class="badge badge-{{ $payment->status ? 'success' : 'warning' }}">
                                                        {{ $payment->status ? 'Completed' : 'Pending' }}
                                                    </span>
                                                </td>
                                               
                                                <td>{{ $payment->message ?? '--' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">No payment records found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Initialize tooltips
                $('[data-toggle="tooltip"]').tooltip();

                // Initialize DataTable
                $('.table').DataTable({
                    responsive: true,
                    autoWidth: false,
                    order: [
                        [3, 'desc']
                    ] // Sort by date descending
                });
            });
        </script>
    @endpush
@endsection
