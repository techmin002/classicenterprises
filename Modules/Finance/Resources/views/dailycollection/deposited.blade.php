@extends('setting::layouts.master')

@section('title', 'Deposit History')

@section('content')
<div class="content-wrapper dc-wrapper">

    <section class="content-header dc-page-header">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                    <h1 class="dc-title">Deposit History</h1>
                    <p class="dc-subtitle mb-0">Bank deposits from cash collections</p>
                </div>
                <a href="{{ route('daily.index') }}" class="dc-btn dc-btn-outline">
                    <i class="fas fa-arrow-left mr-1"></i> Back to Daily Collection
                </a>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            @if(session('success'))
                <div class="dc-alert dc-alert-success mb-4">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                </div>
            @endif

            {{-- Summary --}}
            <div class="dc-cards-row mb-4">
                <div class="dc-stat-card dc-stat-total">
                    <div class="dc-stat-icon"><i class="fas fa-university"></i></div>
                    <div>
                        <div class="dc-stat-label">Total Deposited</div>
                        <div class="dc-stat-value">₹{{ number_format($history->sum('amount'), 2) }}</div>
                    </div>
                </div>
                <div class="dc-stat-card dc-stat-entries">
                    <div class="dc-stat-icon"><i class="fas fa-receipt"></i></div>
                    <div>
                        <div class="dc-stat-label">Total Deposits</div>
                        <div class="dc-stat-value">{{ $history->count() }}</div>
                    </div>
                </div>
            </div>

            <div class="dc-card">
                <div class="dc-card-header">
                    <i class="fas fa-history mr-2"></i> All Deposit Records
                </div>
                <div class="dc-card-body p-0">
                    <div class="table-responsive">
                        <table class="dc-table" id="depositTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Bank</th>
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
                                            <div class="dc-date">{{ \Carbon\Carbon::parse($item->date)->format('d M Y') }}</div>
                                            <div class="dc-time">{{ \Carbon\Carbon::parse($item->created_at)->format('h:i A') }}</div>
                                        </td>
                                        <td>
                                            <span class="dc-badge dc-badge-primary">
                                                <i class="fas fa-university mr-1"></i>{{ $item->bank_name }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if($item->image)
                                                <a href="{{ asset('upload/images/deposite-amount/' . $item->image) }}"
                                                   target="_blank" class="dc-thumb-link">
                                                    <img src="{{ asset('upload/images/deposite-amount/' . $item->image) }}"
                                                         class="dc-thumb" alt="Receipt">
                                                    <span class="dc-thumb-label">View</span>
                                                </a>
                                            @else
                                                <span class="text-muted" style="font-size:12px;">—</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="dc-badge dc-badge-success">
                                                <i class="fas fa-check-circle mr-1"></i>Deposited
                                            </span>
                                        </td>
                                        <td class="text-right dc-amount">₹{{ number_format($item->amount, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="dc-empty">
                                            <i class="fas fa-inbox"></i>
                                            <p>No deposit records found.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            @if($history->count() > 0)
                            <tfoot>
                                <tr>
                                    <th colspan="4"></th>
                                    <th class="text-right">Total:</th>
                                    <th class="text-right dc-total-cell">₹{{ number_format($history->sum('amount'), 2) }}</th>
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
:root{--dc-bg:#f0f4f8;--dc-surface:#ffffff;--dc-border:#e2e8f0;--dc-text:#1a202c;--dc-muted:#718096;--dc-primary:#2b6cb0;--dc-primary-light:#ebf4ff;--dc-green:#276749;--dc-green-bg:#f0fff4;--dc-radius:10px;--dc-shadow:0 1px 3px rgba(0,0,0,.08),0 4px 16px rgba(0,0,0,.05);--dc-font:'DM Sans','Segoe UI',sans-serif;}
.dc-wrapper{background:var(--dc-bg);min-height:100vh;font-family:var(--dc-font);}
.dc-page-header{background:var(--dc-surface);border-bottom:1px solid var(--dc-border);padding:18px 0!important;margin-bottom:24px;}
.dc-title{font-size:22px;font-weight:700;color:var(--dc-text);margin:0 0 2px;}
.dc-subtitle{color:var(--dc-muted);font-size:13px;}
.dc-cards-row{display:grid;grid-template-columns:repeat(auto-fit,minmax(190px,1fr));gap:16px;}
.dc-stat-card{background:var(--dc-surface);border:1px solid var(--dc-border);border-radius:var(--dc-radius);padding:20px;display:flex;align-items:center;gap:16px;box-shadow:var(--dc-shadow);}
.dc-stat-icon{width:46px;height:46px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;}
.dc-stat-total .dc-stat-icon{background:var(--dc-primary-light);color:var(--dc-primary);}
.dc-stat-entries .dc-stat-icon{background:#fffbeb;color:#92400e;}
.dc-stat-label{font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.5px;color:var(--dc-muted);}
.dc-stat-value{font-size:22px;font-weight:700;color:var(--dc-text);line-height:1.2;}
.dc-card{background:var(--dc-surface);border:1px solid var(--dc-border);border-radius:var(--dc-radius);box-shadow:var(--dc-shadow);overflow:hidden;}
.dc-card-header{padding:14px 20px;border-bottom:1px solid var(--dc-border);font-weight:600;font-size:14px;color:var(--dc-text);background:#fafbfc;display:flex;align-items:center;}
.dc-btn{display:inline-flex;align-items:center;padding:8px 18px;border-radius:7px;font-size:13px;font-weight:600;border:none;cursor:pointer;text-decoration:none!important;transition:all .15s ease;white-space:nowrap;}
.dc-btn-outline{background:#fff;color:var(--dc-text);border:1px solid var(--dc-border);}
.dc-btn-outline:hover{background:var(--dc-bg);color:var(--dc-text);}
.dc-badge{display:inline-flex;align-items:center;padding:3px 9px;border-radius:20px;font-size:11px;font-weight:600;}
.dc-badge-primary{background:#ebf4ff;color:#2b6cb0;}
.dc-badge-success{background:var(--dc-green-bg);color:var(--dc-green);}
.dc-alert{padding:12px 16px;border-radius:var(--dc-radius);font-size:14px;font-weight:500;}
.dc-alert-success{background:var(--dc-green-bg);color:var(--dc-green);border:1px solid #9ae6b4;}
.dc-table{width:100%;border-collapse:collapse;font-size:13.5px;}
.dc-table thead th{background:#fafbfc;border-bottom:2px solid var(--dc-border);padding:11px 14px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--dc-muted);}
.dc-table tbody tr{border-bottom:1px solid var(--dc-border);transition:background .1s;}
.dc-table tbody tr:hover{background:#f7fafc;}
.dc-table tbody td{padding:12px 14px;vertical-align:middle;}
.dc-table tfoot th{padding:12px 14px;border-top:2px solid var(--dc-border);background:#f7fafc;}
.dc-date{font-weight:500;color:var(--dc-text);}
.dc-time{font-size:11px;color:var(--dc-muted);}
.dc-amount{font-weight:700;color:#276749;font-size:14px;}
.dc-total-cell{font-size:16px;font-weight:800;color:var(--dc-primary);}
.dc-empty{text-align:center;padding:60px 20px!important;color:var(--dc-muted);}
.dc-empty i{display:block;font-size:36px;margin-bottom:10px;opacity:.3;}
.dc-empty p{margin:0;font-size:14px;}
.dc-thumb-link{display:inline-flex;flex-direction:column;align-items:center;gap:4px;text-decoration:none;}
.dc-thumb{width:52px;height:52px;object-fit:cover;border-radius:6px;border:2px solid var(--dc-border);transition:transform .15s;}
.dc-thumb:hover{transform:scale(1.08);border-color:var(--dc-primary);}
.dc-thumb-label{font-size:10px;color:var(--dc-primary);font-weight:600;}
.gap-2{gap:8px;}
</style>
@endsection