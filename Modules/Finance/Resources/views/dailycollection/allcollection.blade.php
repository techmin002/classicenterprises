@extends('setting::layouts.master')

@section('title', 'All Collections Report')

@section('content')
<div class="content-wrapper dc-wrapper">

    <section class="content-header dc-page-header">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                    <h1 class="dc-title">All Collections Report</h1>
                    <p class="dc-subtitle mb-0">Complete payment history across all sources</p>
                </div>
                <a href="{{ route('daily.index') }}" class="dc-btn dc-btn-outline">
                    <i class="fas fa-arrow-left mr-1"></i> Back to Daily
                </a>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            {{-- Filter Bar --}}
            <div class="dc-card mb-4">
                <div class="dc-card-body py-3">
                    <form method="GET" action="{{ request()->url() }}" id="filterForm">
                        <div class="d-flex align-items-end flex-wrap gap-3">

                            {{-- Quick filter pills --}}
                            <div class="dc-filter-group">
                                <label class="dc-label">Quick Filter</label>
                                <div class="dc-pills">
                                    @foreach(['all' => 'All Time', 'month' => 'By Month', 'year' => 'By Year', 'custom' => 'Custom Range'] as $val => $label)
                                        <button type="submit" name="filter" value="{{ $val }}"
                                                class="dc-pill {{ $filter === $val ? 'active' : '' }}">
                                            {{ $label }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                            @if($filter === 'month')
                            <div style="min-width:130px">
                                <label class="dc-label">Month</label>
                                <select name="month" class="form-control dc-input form-control-sm" onchange="document.getElementById('filterForm').submit()">
                                    @foreach(range(1,12) as $m)
                                        <option value="{{ $m }}" {{ (int)$month === $m ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @endif

                            @if(in_array($filter, ['month','year']))
                            <div style="min-width:110px">
                                <label class="dc-label">Year</label>
                                <select name="year" class="form-control dc-input form-control-sm" onchange="document.getElementById('filterForm').submit()">
                                    @foreach($years as $y)
                                        <option value="{{ $y }}" {{ (int)$year === $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif

                            @if($filter === 'custom')
                            <div>
                                <label class="dc-label">From</label>
                                <input type="date" name="date_from" value="{{ $dateFrom }}" class="form-control dc-input form-control-sm">
                            </div>
                            <div>
                                <label class="dc-label">To</label>
                                <input type="date" name="date_to" value="{{ $dateTo }}" class="form-control dc-input form-control-sm">
                            </div>
                            <div class="align-self-end">
                                <button type="submit" class="dc-btn dc-btn-primary">
                                    <i class="fas fa-search mr-1"></i> Apply
                                </button>
                            </div>
                            @endif

                            <input type="hidden" name="filter" value="{{ $filter }}">
                        </div>
                    </form>
                </div>
            </div>

            {{-- Summary Cards --}}
            <div class="dc-cards-row mb-4">
                <div class="dc-stat-card dc-stat-total">
                    <div class="dc-stat-icon"><i class="fas fa-coins"></i></div>
                    <div>
                        <div class="dc-stat-label">Grand Total</div>
                        <div class="dc-stat-value">₹{{ number_format($total, 2) }}</div>
                    </div>
                </div>
                <div class="dc-stat-card dc-stat-cash">
                    <div class="dc-stat-icon"><i class="fas fa-money-bill-wave"></i></div>
                    <div>
                        <div class="dc-stat-label">Cash Collected</div>
                        <div class="dc-stat-value">₹{{ number_format($cashTotal, 2) }}</div>
                    </div>
                </div>
                <div class="dc-stat-card dc-stat-online">
                    <div class="dc-stat-icon"><i class="fas fa-credit-card"></i></div>
                    <div>
                        <div class="dc-stat-label">Online / Card</div>
                        <div class="dc-stat-value">₹{{ number_format($onlineTotal, 2) }}</div>
                    </div>
                </div>
                <div class="dc-stat-card dc-stat-entries">
                    <div class="dc-stat-icon"><i class="fas fa-receipt"></i></div>
                    <div>
                        <div class="dc-stat-label">Transactions</div>
                        <div class="dc-stat-value">{{ $allcollections->count() }}</div>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="dc-card">
                <div class="dc-card-header justify-content-between">
                    <span><i class="fas fa-table mr-2"></i> Collection Records</span>
                    <span class="text-muted" style="font-size:12px;font-weight:400;">
                        {{ $allcollections->count() }} records
                    </span>
                </div>
                <div class="dc-card-body p-0">
                    <div class="table-responsive">
                        <table class="dc-table" id="allTable">
                            <thead>
                                <tr>
                                    <th>#</th>
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
                                @forelse($allcollections as $item)
                                    <tr>
                                        <td class="text-center text-muted">{{ $loop->iteration }}</td>
                                        <td class="text-center">
                                            @if($item->type === 'Installation')
                                                <span class="dc-badge dc-badge-primary">Installation</span>
                                            @elseif($item->type === 'Ticket')
                                                <span class="dc-badge dc-badge-warning">Ticket</span>
                                            @else
                                                <span class="dc-badge dc-badge-secondary">Regular</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dc-name">{{ $item->name }}</div>
                                            <div class="dc-ref">{{ $item->reference_no ?? 'N/A' }}</div>
                                        </td>
                                        <td class="text-center">
                                            <span class="dc-branch">{{ $item->branch }}</span>
                                        </td>
                                        <td class="text-center">
                                            @if(strtolower($item->payment_method) === 'cash')
                                                <span class="dc-badge dc-badge-cash">
                                                    <i class="fas fa-money-bill-wave mr-1"></i>Cash
                                                </span>
                                            @else
                                                <span class="dc-badge dc-badge-online">
                                                    <i class="fas fa-credit-card mr-1"></i>{{ $item->payment_method }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="dc-date">{{ \Carbon\Carbon::parse($item->payment_date)->format('d M Y') }}</div>
                                            <div class="dc-time">{{ \Carbon\Carbon::parse($item->payment_date)->format('h:i A') }}</div>
                                        </td>
                                        <td class="dc-notes">{{ \Illuminate\Support\Str::limit($item->message ?? '—', 55) }}</td>
                                        <td class="text-right dc-amount">₹{{ number_format($item->amount, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="dc-empty">
                                            <i class="fas fa-inbox"></i>
                                            <p>No collections found for the selected period.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            @if($allcollections->count() > 0)
                            <tfoot>
                                <tr>
                                    <th colspan="6"></th>
                                    <th class="text-right">Grand Total:</th>
                                    <th class="text-right dc-total-cell">₹{{ number_format($total, 2) }}</th>
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

<style>
:root {
    --dc-bg:#f0f4f8;--dc-surface:#ffffff;--dc-border:#e2e8f0;--dc-text:#1a202c;--dc-muted:#718096;
    --dc-primary:#2b6cb0;--dc-primary-light:#ebf4ff;--dc-green:#276749;--dc-green-bg:#f0fff4;
    --dc-amber:#92400e;--dc-amber-bg:#fffbeb;--dc-red:#c53030;--dc-red-bg:#fff5f5;
    --dc-radius:10px;--dc-shadow:0 1px 3px rgba(0,0,0,.08),0 4px 16px rgba(0,0,0,.05);
    --dc-font:'DM Sans','Segoe UI',sans-serif;
}
.dc-wrapper{background:var(--dc-bg);min-height:100vh;font-family:var(--dc-font);}
.dc-page-header{background:var(--dc-surface);border-bottom:1px solid var(--dc-border);padding:18px 0!important;margin-bottom:24px;}
.dc-title{font-size:22px;font-weight:700;color:var(--dc-text);margin:0 0 2px;}
.dc-subtitle{color:var(--dc-muted);font-size:13px;}
.dc-cards-row{display:grid;grid-template-columns:repeat(auto-fit,minmax(190px,1fr));gap:16px;}
.dc-stat-card{background:var(--dc-surface);border:1px solid var(--dc-border);border-radius:var(--dc-radius);padding:20px;display:flex;align-items:center;gap:16px;box-shadow:var(--dc-shadow);}
.dc-stat-icon{width:46px;height:46px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;}
.dc-stat-total .dc-stat-icon{background:var(--dc-primary-light);color:var(--dc-primary);}
.dc-stat-cash .dc-stat-icon{background:#f0fff4;color:#276749;}
.dc-stat-online .dc-stat-icon{background:#faf5ff;color:#6b46c1;}
.dc-stat-entries .dc-stat-icon{background:#fffbeb;color:#92400e;}
.dc-stat-label{font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.5px;color:var(--dc-muted);}
.dc-stat-value{font-size:22px;font-weight:700;color:var(--dc-text);line-height:1.2;}
.dc-card{background:var(--dc-surface);border:1px solid var(--dc-border);border-radius:var(--dc-radius);box-shadow:var(--dc-shadow);overflow:hidden;}
.dc-card-header{padding:14px 20px;border-bottom:1px solid var(--dc-border);font-weight:600;font-size:14px;color:var(--dc-text);background:#fafbfc;display:flex;align-items:center;}
.dc-card-body{padding:20px;}
.dc-label{font-size:12px;font-weight:600;color:var(--dc-muted);margin-bottom:4px;display:block;text-transform:uppercase;letter-spacing:.4px;}
.dc-input{border:1px solid var(--dc-border);border-radius:6px;font-size:14px;color:var(--dc-text);}
.dc-input:focus{border-color:var(--dc-primary);box-shadow:0 0 0 3px rgba(43,108,176,.12);}
.dc-btn{display:inline-flex;align-items:center;padding:8px 18px;border-radius:7px;font-size:13px;font-weight:600;border:none;cursor:pointer;text-decoration:none!important;transition:all .15s ease;white-space:nowrap;}
.dc-btn-primary{background:var(--dc-primary);color:#fff;}
.dc-btn-primary:hover{background:#2c5282;color:#fff;}
.dc-btn-outline{background:#fff;color:var(--dc-text);border:1px solid var(--dc-border);}
.dc-btn-outline:hover{background:var(--dc-bg);color:var(--dc-text);}
.dc-badge{display:inline-flex;align-items:center;padding:3px 9px;border-radius:20px;font-size:11px;font-weight:600;}
.dc-badge-primary{background:#ebf4ff;color:#2b6cb0;}
.dc-badge-warning{background:#fffbeb;color:#92400e;}
.dc-badge-secondary{background:#f7fafc;color:#4a5568;border:1px solid #e2e8f0;}
.dc-badge-cash{background:#f0fff4;color:#276749;}
.dc-badge-online{background:#faf5ff;color:#6b46c1;}
.dc-filter-group{flex-shrink:0;}
.dc-pills{display:flex;gap:6px;flex-wrap:wrap;}
.dc-pill{padding:6px 14px;border-radius:20px;font-size:12px;font-weight:600;border:1px solid var(--dc-border);background:#fff;color:var(--dc-muted);cursor:pointer;transition:all .15s;}
.dc-pill:hover{border-color:var(--dc-primary);color:var(--dc-primary);}
.dc-pill.active{background:var(--dc-primary);color:#fff;border-color:var(--dc-primary);}
.dc-table{width:100%;border-collapse:collapse;font-size:13.5px;}
.dc-table thead th{background:#fafbfc;border-bottom:2px solid var(--dc-border);padding:11px 14px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--dc-muted);}
.dc-table tbody tr{border-bottom:1px solid var(--dc-border);transition:background .1s;}
.dc-table tbody tr:hover{background:#f7fafc;}
.dc-table tbody td{padding:12px 14px;vertical-align:middle;}
.dc-table tfoot th{padding:12px 14px;border-top:2px solid var(--dc-border);background:#f7fafc;}
.dc-name{font-weight:600;color:var(--dc-text);}
.dc-ref{font-size:11px;color:var(--dc-muted);margin-top:2px;}
.dc-date{font-weight:500;color:var(--dc-text);}
.dc-time{font-size:11px;color:var(--dc-muted);}
.dc-notes{color:var(--dc-muted);font-size:12.5px;max-width:220px;}
.dc-amount{font-weight:700;color:#276749;font-size:14px;}
.dc-total-cell{font-size:16px;font-weight:800;color:var(--dc-primary);}
.dc-empty{text-align:center;padding:60px 20px!important;color:var(--dc-muted);}
.dc-empty i{display:block;font-size:36px;margin-bottom:10px;opacity:.3;}
.dc-empty p{margin:0;font-size:14px;}
.gap-2{gap:8px;}.gap-3{gap:12px;}
</style>
@endsection