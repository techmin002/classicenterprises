@extends('setting::layouts.master')

@section('title', 'Customer Finance Details')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Customer Finance Details</li>
    </ol>
@endsection

@section('content')
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1>Customer Finance Details</h1></div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            {{-- Customer Info Card --}}
            <div class="card shadow-sm mb-4 border-0 rounded">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-user mr-2"></i>Customer Information</h5>
                    <a href="{{ url()->previous() }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Back
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-2"><strong>Customer ID:</strong><br>{{ $customer->id ?? '-' }}</div>
                        <div class="col-md-3 mb-2"><strong>Username:</strong><br>{{ $customer->user_name ?? 'Not Generated' }}</div>
                        <div class="col-md-3 mb-2"><strong>Name:</strong><br>{{ optional($customer->lead)->name ?? '-' }}</div>
                        <div class="col-md-3 mb-2"><strong>Mobile:</strong><br>{{ optional($customer->lead)->mobile ?? '-' }}</div>
                        <div class="col-md-3 mb-2"><strong>Email:</strong><br>{{ optional($customer->lead)->email ?? '-' }}</div>
                        <div class="col-md-3 mb-2"><strong>Address:</strong><br>{{ optional($customer->lead)->address ?? '-' }}</div>
                        <div class="col-md-3 mb-2"><strong>Branch:</strong><br>{{ optional($customer->branch)->name ?? '-' }}</div>
                        <div class="col-md-3 mb-2"><strong>Sales Convert:</strong><br>{{ optional($customer->convertedBy)->name ?? '-' }}</div>
                        <div class="col-md-3 mb-2">
                            <strong>Install Date:</strong><br>
                            {{ $customer->install_date ? \Carbon\Carbon::parse($customer->install_date)->format('d-m-Y') : '-' }}
                        </div>
                        <div class="col-md-3 mb-2">
                            <strong>Customer Type:</strong><br>
                            <span class="badge badge-info">{{ ucfirst($customer->customer_type ?? '-') }}</span>
                        </div>
                        <div class="col-md-3 mb-2">
                            <strong>Ticket Status:</strong><br>
                            <span class="badge badge-warning">{{ ucfirst($customer->ticket_status ?? '-') }}</span>
                        </div>
                        <div class="col-md-3 mb-2">
                            <strong>Status:</strong><br>
                            <span class="badge badge-success">{{ ucfirst(str_replace('_', ' ', $customer->status ?? '-')) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Overall Summary --}}
            @include('finance::Payment.summary')

            {{-- Installation Payment History --}}
            <div class="card shadow-sm mb-4 border-0 rounded">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-history mr-2"></i>Installation Payment History
                    </h5>
                    <span class="badge badge-light text-primary p-2">
                        Total Paid: Rs. {{ number_format($payments->sum('paid_amount')) }}
                    </span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="paymentTable" class="table table-bordered table-striped mb-0" style="font-size:13px;">
                            <thead>
                                <tr>
                                    <th class="text-center bg-light" colspan="8" style="border-bottom:2px solid #4e73df; color:#4e73df;">
                                        <i class="fas fa-money-bill-wave mr-1"></i> Payment Details
                                    </th>
                                    <th class="text-center" colspan="3" style="background:#fff3cd; border-bottom:2px solid #f6c23e; color:#856404;">
                                        <i class="fas fa-shield-alt mr-1"></i> Verification
                                    </th>
                                </tr>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Pay No.</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Method</th>
                                    <th class="text-center">Cash</th>
                                    <th class="text-center">Online</th>
                                    <th class="text-center">Cheque</th>
                                    <th class="text-center">Paid Amt</th>
                                    <th class="text-center" style="background:#fffdf0;">Verify Date</th>
                                    <th class="text-center" style="background:#fffdf0;">Remaining After</th>
                                    <th class="text-center" style="background:#fffdf0;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($payments as $payment)
                                    @php
                                        // Use the relationship - this should work if customer_payment_id is set correctly
                                        $verification = $payment->verification;
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">
                                            <span class="badge badge-primary">Payment #{{ $loop->iteration }}</span>
                                        </td>
                                        <td class="text-center">
                                            {{ $payment->created_at ? $payment->created_at->format('d-m-Y') : '-' }}<br>
                                            <small class="text-muted">{{ $payment->created_at ? $payment->created_at->format('h:i A') : '' }}</small>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-info">{{ ucfirst($payment->payment_method ?? '-') }}</span>
                                        </td>
                                        <td class="text-center">
                                            Rs. {{ number_format($payment->cash_amount ?? 0) }}
                                            @if($payment->cash_receipt)
                                                <br><a href="{{ asset('receipts/' . $payment->cash_receipt) }}" target="_blank" class="badge badge-secondary mt-1">
                                                    <i class="fas fa-file mr-1"></i>Receipt
                                                </a>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            Rs. {{ number_format($payment->online_amount ?? 0) }}
                                            @if($payment->online_receipt)
                                                <br><a href="{{ asset('receipts/' . $payment->online_receipt) }}" target="_blank" class="badge badge-secondary mt-1">
                                                    <i class="fas fa-file mr-1"></i>Receipt
                                                </a>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            Rs. {{ number_format($payment->cheque_amount ?? 0) }}
                                            @if($payment->cheque_number)
                                                <br><small class="text-muted">No: {{ $payment->cheque_number }}</small>
                                            @endif
                                            @if($payment->cheque_receipt)
                                                <br><a href="{{ asset('receipts/' . $payment->cheque_receipt) }}" target="_blank" class="badge badge-secondary mt-1">
                                                    <i class="fas fa-file mr-1"></i>Receipt
                                                </a>
                                            @endif
                                        </td>
                                        <td class="text-center text-success font-weight-bold">
                                            Rs. {{ number_format($payment->paid_amount ?? 0) }}
                                        </td>
                                        <td class="text-center" style="background:#fffdf0;">
                                            @if($verification && $verification->payment_date)
                                                {{ \Carbon\Carbon::parse($verification->payment_date)->format('d-m-Y') }}
                                            @elseif($verification && $verification->created_at)
                                                {{ $verification->created_at->format('d-m-Y') }}
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td class="text-center" style="background:#fffdf0;">
                                            @if($verification)
                                                <span class="{{ ($verification->remaining_amount ?? 0) > 0 ? 'text-danger' : 'text-success' }} font-weight-bold">
                                                    Rs. {{ number_format($verification->remaining_amount ?? 0) }}
                                                </span>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td class="text-center" style="background:#fffdf0;">
                                            @if(!$verification)
                                                <span class="badge badge-secondary p-2">
                                                    <i class="fas fa-minus mr-1"></i> No Record
                                                </span>
                                            @elseif($verification->status === 'verified')
                                                <span class="badge badge-success p-2">
                                                    <i class="fas fa-check-circle mr-1"></i> Verified
                                                </span>
                                            @elseif($verification->status === 'on' || $verification->status === 'pending')
                                                <span class="badge badge-warning p-2 text-dark">
                                                    <i class="fas fa-clock mr-1"></i> Pending
                                                </span>
                                            @elseif($verification->status === 'rejected')
                                                <span class="badge badge-danger p-2">
                                                    <i class="fas fa-times-circle mr-1"></i> Rejected
                                                </span>
                                            @else
                                                <span class="badge badge-secondary p-2">{{ ucfirst($verification->status ?? '-') }}</span>
                                            @endif
                                            @if($verification && $verification->message)
                                                <br><small class="text-muted mt-1 d-block" title="{{ $verification->message }}">
                                                    <i class="fas fa-comment-alt mr-1"></i>
                                                    {{ Str::limit($verification->message, 30) }}
                                                </small>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center text-muted py-3">
                                            <i class="fas fa-info-circle mr-1"></i> No installation payments found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            @if($payments->count() > 0)
                            <tfoot>
                                <tr class="bg-light font-weight-bold">
                                    <td colspan="7" class="text-right">Total Paid:</td>
                                    <td class="text-center text-success">
                                        Rs. {{ number_format($payments->sum('paid_amount')) }}
                                    </td>
                                    <td colspan="3"></td>
                                </tr>
                            </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </div>

            {{-- Ticket Payment History --}}
            <div class="card shadow-sm mb-4 border-0 rounded">
                <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-ticket-alt mr-2"></i>Ticket Payment History
                    </h5>
                    <span class="badge badge-dark p-2">
                        Total Paid: Rs. {{ number_format($ticketPayments->sum('paid_amount')) }}
                    </span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="ticketPaymentTable" class="table table-bordered table-striped mb-0" style="font-size:13px;">
                            <thead>
                                <tr>
                                    <th class="text-center bg-light" colspan="9" style="border-bottom:2px solid #f6c23e; color:#856404;">
                                        <i class="fas fa-money-bill-wave mr-1"></i> Payment Details
                                    </th>
                                    <th class="text-center" colspan="3" style="background:#f0f4ff; border-bottom:2px solid #4e73df; color:#4e73df;">
                                        <i class="fas fa-shield-alt mr-1"></i> Verification
                                    </th>
                                </tr>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Ticket #</th>
                                    <th class="text-center">Support Type</th>
                                    <th class="text-center">Method</th>
                                    <th class="text-center">Cash</th>
                                    <th class="text-center">Online</th>
                                    <th class="text-center">Cheque</th>
                                    <th class="text-center">Paid Amt</th>
                                    <th class="text-center" style="background:#f0f4ff;">Verify Date</th>
                                    <th class="text-center" style="background:#f0f4ff;">Remaining After</th>
                                    <th class="text-center" style="background:#f0f4ff;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($ticketPayments as $tp)
                                    @php
                                        $verification = $tp->verification;
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">
                                            {{ $tp->created_at ? $tp->created_at->format('d-m-Y') : '-' }}<br>
                                            <small class="text-muted">{{ $tp->created_at ? $tp->created_at->format('h:i A') : '' }}</small>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-secondary">#{{ optional($tp->ticket)->id ?? '-' }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-info">
                                                {{ ucfirst(str_replace('_', ' ', optional($tp->ticket)->support_type ?? '-')) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-secondary">{{ ucfirst($tp->payment_method ?? '-') }}</span>
                                        </td>
                                        <td class="text-center">
                                            Rs. {{ number_format($tp->cash_amount ?? 0) }}
                                            @if($tp->cash_receipt)
                                                <br><a href="{{ asset('receipts/' . $tp->cash_receipt) }}" target="_blank" class="badge badge-secondary mt-1">
                                                    <i class="fas fa-file mr-1"></i>Receipt
                                                </a>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            Rs. {{ number_format($tp->online_amount ?? 0) }}
                                            @if($tp->online_receipt)
                                                <br><a href="{{ asset('receipts/' . $tp->online_receipt) }}" target="_blank" class="badge badge-secondary mt-1">
                                                    <i class="fas fa-file mr-1"></i>Receipt
                                                </a>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            Rs. {{ number_format($tp->cheque_amount ?? 0) }}
                                            @if($tp->cheque_number)
                                                <br><small class="text-muted">No: {{ $tp->cheque_number }}</small>
                                            @endif
                                            @if($tp->cheque_receipt)
                                                <br><a href="{{ asset('receipts/' . $tp->cheque_receipt) }}" target="_blank" class="badge badge-secondary mt-1">
                                                    <i class="fas fa-file mr-1"></i>Receipt
                                                </a>
                                            @endif
                                        </td>
                                        <td class="text-center text-success font-weight-bold">
                                            Rs. {{ number_format($tp->paid_amount ?? 0) }}
                                        </td>
                                        <td class="text-center" style="background:#f0f4ff;">
                                            @if($verification && $verification->payment_date)
                                                {{ \Carbon\Carbon::parse($verification->payment_date)->format('d-m-Y') }}
                                            @elseif($verification && $verification->created_at)
                                                {{ $verification->created_at->format('d-m-Y') }}
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td class="text-center" style="background:#f0f4ff;">
                                            @if($verification)
                                                <span class="{{ ($verification->remaining_amount ?? 0) > 0 ? 'text-danger' : 'text-success' }} font-weight-bold">
                                                    Rs. {{ number_format($verification->remaining_amount ?? 0) }}
                                                </span>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td class="text-center" style="background:#f0f4ff;">
                                            @if(!$verification)
                                                <span class="badge badge-secondary p-2">
                                                    <i class="fas fa-minus mr-1"></i> No Record
                                                </span>
                                            @elseif($verification->status === 'verified')
                                                <span class="badge badge-success p-2">
                                                    <i class="fas fa-check-circle mr-1"></i> Verified
                                                </span>
                                            @elseif($verification->status === 'on' || $verification->status === 'pending')
                                                <span class="badge badge-warning p-2 text-dark">
                                                    <i class="fas fa-clock mr-1"></i> Pending
                                                </span>
                                            @elseif($verification->status === 'rejected')
                                                <span class="badge badge-danger p-2">
                                                    <i class="fas fa-times-circle mr-1"></i> Rejected
                                                </span>
                                            @else
                                                <span class="badge badge-secondary p-2">{{ ucfirst($verification->status ?? '-') }}</span>
                                            @endif
                                            @if($verification && $verification->message)
                                                <br><small class="text-muted mt-1 d-block" title="{{ $verification->message }}">
                                                    <i class="fas fa-comment-alt mr-1"></i>
                                                    {{ Str::limit($verification->message, 30) }}
                                                </small>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12" class="text-center text-muted py-3">
                                            <i class="fas fa-info-circle mr-1"></i> No ticket payments found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            @if($ticketPayments->count() > 0)
                            <tfoot>
                                <tr class="bg-light font-weight-bold">
                                    <td colspan="8" class="text-right">Total Ticket Paid:</td>
                                    <td class="text-center text-success">
                                        Rs. {{ number_format($ticketPayments->sum('paid_amount')) }}
                                    </td>
                                    <td colspan="3"></td>
                                </tr>
                            </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

{{-- Modals --}}
@include('finance::Payment.installationpaymodal')
@include('finance::Payment.ticketpaymodal')

<script>
    $(function () {
        $('#paymentTable').DataTable({ 
            responsive: true, 
            autoWidth: false, 
            order: [[0, 'asc']],
            pageLength: 10
        });
        $('#ticketPaymentTable').DataTable({ 
            responsive: true, 
            autoWidth: false, 
            order: [[0, 'asc']],
            pageLength: 10
        });
    });

    function calcInstallRemaining(value) {
        const due = {{ $installDue }};
        const entered = parseFloat(value) || 0;
        const remaining = Math.max(0, due - entered);
        document.getElementById('installRemaining').innerText = 'Rs. ' + remaining.toLocaleString('en-IN');
        if (entered > due) {
            document.getElementById('installAmount').value = due;
            document.getElementById('installRemaining').innerText = 'Rs. 0';
        }
    }

    function toggleInstallCheque(value) {
        const div = document.getElementById('installChequeDiv');
        const no = document.getElementById('installChequeNo');
        if (value === 'cheque') {
            div.classList.remove('d-none');
            no.setAttribute('required', true);
        } else {
            div.classList.add('d-none');
            no.removeAttribute('required');
        }
    }

    function calcTicketRemaining(value) {
        const due = parseFloat(document.getElementById('ticketAmount').getAttribute('max')) || {{ $ticketDue }};
        const entered = parseFloat(value) || 0;
        const remaining = Math.max(0, due - entered);
        document.getElementById('ticketRemaining').innerText = 'Rs. ' + remaining.toLocaleString('en-IN');
        if (entered > due) {
            document.getElementById('ticketAmount').value = due;
            document.getElementById('ticketRemaining').innerText = 'Rs. 0';
        }
    }

    function toggleTicketCheque(value) {
        const div = document.getElementById('ticketChequeDiv');
        const no = document.getElementById('ticketChequeNo');
        if (value === 'cheque') {
            div.classList.remove('d-none');
            no.setAttribute('required', true);
        } else {
            div.classList.add('d-none');
            no.removeAttribute('required');
        }
    }

    function updateTicketDue(select) {
        const option = select.options[select.selectedIndex];
        const due = parseFloat(option.dataset.due) || 0;
        const total = parseFloat(option.dataset.total) || 0;
        const paid = parseFloat(option.dataset.paid) || 0;

        document.getElementById('ticketModalTotal').innerText = 'Rs. ' + total.toLocaleString('en-IN');
        document.getElementById('ticketModalPaid').innerText = 'Rs. ' + paid.toLocaleString('en-IN');
        document.getElementById('ticketModalDue').innerText = 'Rs. ' + due.toLocaleString('en-IN');
        document.getElementById('ticketMaxLabel').innerText = 'Rs. ' + due.toLocaleString('en-IN');
        document.getElementById('ticketRemaining').innerText = 'Rs. ' + due.toLocaleString('en-IN');
        document.getElementById('ticketAmount').setAttribute('max', due);
        document.getElementById('ticketAmount').value = '';
    }
</script>
@endsection