@extends('setting::layouts.master')

@section('title', 'Deposit History')

@section('content')

<div class="content-wrapper">

<div class="content-header">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h4 class="mb-0 font-weight-bold">Deposit History</h4>
                <small class="text-muted">Bank deposits from daily cash collections</small>
            </div>
            <a href="{{ route('daily.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left mr-1"></i> Back to Daily
            </a>
        </div>
    </div>
</div>

<div class="content">
<div class="container-fluid">

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
@endif

{{-- ── KPI CARDS ────────────────────────────────────────────────── --}}
<div class="row mb-3">
    <div class="col-6 col-md-3">
        <div class="info-box shadow-sm mb-2">
            <span class="info-box-icon bg-primary"><i class="fas fa-university"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Deposited</span>
                <span class="info-box-number">₹{{ number_format($history->sum('amount'), 2) }}</span>
                <span class="info-box-text text-muted" style="font-size:11px">All banks combined</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="info-box shadow-sm mb-2">
            <span class="info-box-icon bg-info"><i class="fas fa-receipt"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Deposits</span>
                <span class="info-box-number">{{ $history->count() }}</span>
                <span class="info-box-text text-muted" style="font-size:11px">Deposit transactions</span>
            </div>
        </div>
    </div>
    @php $banks = $history->groupBy('bank_name'); @endphp
    @foreach($banks->take(2) as $bank => $deps)
    <div class="col-6 col-md-3">
        <div class="info-box shadow-sm mb-2">
            <span class="info-box-icon bg-success"><i class="fas fa-landmark"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">{{ $bank }}</span>
                <span class="info-box-number">₹{{ number_format($deps->sum('amount'), 2) }}</span>
                <span class="info-box-text text-muted" style="font-size:11px">{{ $deps->count() }} deposit(s)</span>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- ── TABLE ────────────────────────────────────────────────────── --}}
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-history mr-2"></i>All Deposit Records</h3>
        <div class="card-tools">
            <span class="badge badge-secondary">{{ $history->count() }} entries</span>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="installationTable" class="table table-hover table-sm mb-0">
                <thead class="thead-light">
                    <tr>
                        <th style="width:40px">#</th>
                        <th>Deposit Date</th>
                        <th>Bank</th>
                        <th>For Closing Day</th>
                        <th>Remarks</th>
                        <th class="text-center">Receipt</th>
                        <th>Status</th>
                        <th class="text-right">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($history as $item)
                    <tr>
                        <td class="text-center text-muted">{{ $loop->iteration }}</td>
                        <td>
                            <div>{{ \Carbon\Carbon::parse($item->date)->format('d M Y') }}</div>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($item->created_at)->format('h:i A') }}</small>
                        </td>
                        <td>
                            <span class="badge badge-primary" style="font-size:12px">
                                <i class="fas fa-university mr-1"></i>{{ $item->bank_name }}
                            </span>
                        </td>
                        <td>
                            @if($item->closingBalance)
                                <div class="font-weight-bold">{{ \Carbon\Carbon::parse($item->closingBalance->date)->format('d M Y') }}</div>
                                <small class="text-muted">Closing day cash</small>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td><small class="text-muted">{{ $item->notes ?? '—' }}</small></td>
                        <td class="text-center">
                            @if($item->image)
                                <a href="{{ asset('upload/images/deposite-amount/' . $item->image) }}"
                                   target="_blank" title="View receipt">
                                    <img src="{{ asset('upload/images/deposite-amount/' . $item->image) }}"
                                         style="width:46px;height:46px;object-fit:cover;border-radius:4px;border:1px solid #dee2e6"
                                         alt="Receipt">
                                </a>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-success">
                                <i class="fas fa-check-circle mr-1"></i>Deposited
                            </span>
                        </td>
                        <td class="text-right font-weight-bold text-success">
                            ₹{{ number_format($item->amount, 2) }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                            No deposit records found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($history->count() > 0)
                <tfoot>
                    <tr class="bg-light">
                        <th colspan="6"></th>
                        <th class="text-right text-muted">Total:</th>
                        <th class="text-right text-primary" style="font-size:16px">
                            ₹{{ number_format($history->sum('amount'), 2) }}
                        </th>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>

</div>
</div>
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