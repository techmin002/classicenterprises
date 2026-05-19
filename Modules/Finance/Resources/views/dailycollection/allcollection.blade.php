@extends('setting::layouts.master')

@section('title', 'All Collections Report')

@section('content')

<div class="content-wrapper">

<div class="content-header">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h4 class="mb-0 font-weight-bold">All Collections</h4>
                <small class="text-muted">Complete verified payment history</small>
            </div>
            <a href="{{ route('daily.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left mr-1"></i> Back to Daily
            </a>
        </div>
    </div>
</div>

<div class="content">
<div class="container-fluid">

{{-- ── FILTER BAR ──────────────────────────────────────────────── --}}
<div class="card card-outline card-secondary mb-3">
    <div class="card-body py-3">
        <form method="GET" action="{{ request()->url() }}" id="filterForm">
            <div class="d-flex align-items-end flex-wrap" style="gap:12px">
                <div>
                    <label class="d-block" style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;color:#6c757d;margin-bottom:6px">Period</label>
                    <div class="btn-group btn-group-sm">
                        @foreach(['all' => 'All Time', 'month' => 'By Month', 'year' => 'By Year', 'custom' => 'Custom Range'] as $val => $lbl)
                            <button type="submit" name="filter" value="{{ $val }}"
                                    class="btn {{ $filter === $val ? 'btn-primary' : 'btn-outline-secondary' }}">
                                {{ $lbl }}
                            </button>
                        @endforeach
                    </div>
                </div>

                @if($filter === 'month')
                <div>
                    <label class="d-block" style="font-size:11px;font-weight:700;text-transform:uppercase;color:#6c757d;margin-bottom:6px">Month</label>
                    <select name="month" class="form-control form-control-sm" onchange="document.getElementById('filterForm').submit()" style="width:140px">
                        @foreach(range(1,12) as $m)
                            <option value="{{ $m }}" {{ (int)$month === $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif

                @if(in_array($filter, ['month','year']))
                <div>
                    <label class="d-block" style="font-size:11px;font-weight:700;text-transform:uppercase;color:#6c757d;margin-bottom:6px">Year</label>
                    <select name="year" class="form-control form-control-sm" onchange="document.getElementById('filterForm').submit()" style="width:100px">
                        @foreach($years as $y)
                            <option value="{{ $y }}" {{ (int)$year === $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
                @endif

                @if($filter === 'custom')
                <div>
                    <label class="d-block" style="font-size:11px;font-weight:700;text-transform:uppercase;color:#6c757d;margin-bottom:6px">From</label>
                    <input type="date" name="date_from" value="{{ $dateFrom }}" class="form-control form-control-sm">
                </div>
                <div>
                    <label class="d-block" style="font-size:11px;font-weight:700;text-transform:uppercase;color:#6c757d;margin-bottom:6px">To</label>
                    <input type="date" name="date_to" value="{{ $dateTo }}" class="form-control form-control-sm">
                </div>
                <div>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-search mr-1"></i> Apply
                    </button>
                </div>
                @endif

                <input type="hidden" name="filter" value="{{ $filter }}">
            </div>
        </form>
    </div>
</div>

{{-- Opening balance banner --}}
@if($openingBalance > 0)
<div class="alert mb-3" style="background:#fff7ed;border:1px solid #fed7aa;border-left:4px solid #d97706">
    <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap:8px">
        <div>
            <strong style="color:#92400e">Opening Balance for Selected Period</strong><br>
            <small style="color:#b45309">Undeposited cash carried forward before {{ \Carbon\Carbon::parse($dateFrom)->format('d M Y') }}</small>
        </div>
        <span style="font-size:20px;font-weight:800;color:#92400e">₹{{ number_format($openingBalance, 2) }}</span>
    </div>
</div>
@endif

{{-- ── KPI CARDS ────────────────────────────────────────────────── --}}
<div class="row mb-3">
    <div class="col-6 col-md-3">
        <div class="info-box shadow-sm mb-2">
            <span class="info-box-icon bg-primary"><i class="fas fa-coins"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Grand Total</span>
                <span class="info-box-number">₹{{ number_format($total, 2) }}</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="info-box shadow-sm mb-2">
            <span class="info-box-icon bg-success"><i class="fas fa-money-bill-wave"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Cash Collected</span>
                <span class="info-box-number">₹{{ number_format($cashTotal, 2) }}</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="info-box shadow-sm mb-2">
            <span class="info-box-icon bg-purple"><i class="fas fa-credit-card"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Online / Card</span>
                <span class="info-box-number">₹{{ number_format($onlineTotal, 2) }}</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="info-box shadow-sm mb-2">
            <span class="info-box-icon bg-info"><i class="fas fa-receipt"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Transactions</span>
                <span class="info-box-number">{{ $allcollections->count() }}</span>
            </div>
        </div>
    </div>
</div>

{{-- ── TABLE ────────────────────────────────────────────────────── --}}
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-table mr-2"></i>Collection Records</h3>
        <div class="card-tools">
            <span class="badge badge-secondary">{{ $allcollections->count() }} records</span>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="installationTable" class="table table-hover table-sm mb-0">
                <thead class="thead-light">
                    <tr>
                        <th style="width:40px">#</th>
                        <th>Type</th>
                        <th>Customer / Reference</th>
                        <th>Branch</th>
                        <th>Method</th>
                        <th>Verified Date</th>
                        <th>Notes</th>
                        <th class="text-right">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @if($openingBalance > 0)
                    <tr style="background:#fff7ed">
                        <td class="text-center text-muted">—</td>
                        <td colspan="5">
                            <span class="badge" style="background:#fed7aa;color:#92400e;font-size:12px;padding:4px 10px">
                                <i class="fas fa-exchange-alt mr-1"></i>
                                Opening Balance — Carry-forward before {{ \Carbon\Carbon::parse($dateFrom)->format('d M Y') }}
                            </span>
                        </td>
                        <td></td>
                        <td class="text-right font-weight-bold" style="color:#92400e">₹{{ number_format($openingBalance, 2) }}</td>
                    </tr>
                    @endif

                    @forelse($allcollections as $item)
                    <tr>
                        <td class="text-center text-muted">{{ $loop->iteration }}</td>
                        <td>
                            @if($item->type === 'Installation')
                                <span class="badge badge-primary">Installation</span>
                            @elseif($item->type === 'Ticket')
                                <span class="badge badge-warning">Ticket</span>
                            @else
                                <span class="badge badge-secondary">Regular</span>
                            @endif
                        </td>
                        <td>
                            <div class="font-weight-bold">{{ $item->name }}</div>
                            <small class="text-muted">{{ $item->reference_no ?? '—' }}</small>
                        </td>
                        <td>{{ $item->branch }}</td>
                        <td>
                            @if(strtolower($item->payment_method) === 'cash')
                                <span class="badge badge-success"><i class="fas fa-money-bill-wave mr-1"></i>Cash</span>
                            @else
                                <span class="badge badge-info"><i class="fas fa-credit-card mr-1"></i>{{ $item->payment_method }}</span>
                            @endif
                        </td>
                        <td>
                            <div>{{ \Carbon\Carbon::parse($item->payment_date)->format('d M Y') }}</div>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($item->payment_date)->format('h:i A') }}</small>
                        </td>
                        <td><small class="text-muted">{{ \Illuminate\Support\Str::limit($item->message ?? '—', 50) }}</small></td>
                        <td class="text-right font-weight-bold text-success">₹{{ number_format($item->amount, 2) }}</td>
                    </tr>
                    @empty
                    @if($openingBalance == 0)
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                            No collections found for the selected period.
                        </td>
                    </tr>
                    @endif
                    @endforelse
                </tbody>
                @if($allcollections->count() > 0 || $openingBalance > 0)
                <tfoot>
                    <tr class="bg-light">
                        <th colspan="6"></th>
                        <th class="text-right text-muted">
                            @if($openingBalance > 0) Total (incl. opening): @else Grand Total: @endif
                        </th>
                        <th class="text-right text-primary" style="font-size:16px">
                            ₹{{ number_format($total + $openingBalance, 2) }}
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
<style>.bg-purple{background-color:#6f42c1!important}</style>
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