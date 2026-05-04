@extends('setting::layouts.master')

@section('title', 'Daily Collection')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Daily Collection</li>
    </ol>
@endsection

@section('content')
<div class="content-wrapper dc-wrapper">

    {{-- Page Header --}}
    <section class="content-header dc-page-header">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                    <h1 class="dc-title">Daily Collection</h1>
                    <p class="dc-subtitle mb-0">
                        <i class="far fa-calendar-alt mr-1"></i>
                        {{ \Carbon\Carbon::parse($date)->format('l, d F Y') }}
                    </p>
                </div>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <form method="GET" action="{{ request()->url() }}" class="d-flex align-items-center">
                        <input type="date" name="date" value="{{ $date }}"
                               class="dc-date-input form-control form-control-sm mr-2"
                               onchange="this.form.submit()">
                    </form>
                    <a href="{{ route('deposite.history') }}" class="dc-btn dc-btn-outline">
                        <i class="fas fa-history mr-1"></i> Deposit History
                    </a>
                    <a href="{{ route('all-collection') }}" class="dc-btn dc-btn-outline">
                        <i class="fas fa-chart-bar mr-1"></i> All Collections
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            {{-- Alerts --}}
            @if(session('success'))
                <div class="dc-alert dc-alert-success">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="dc-alert dc-alert-danger">
                    <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
                </div>
            @endif

            {{-- Summary Cards --}}
            <div class="dc-cards-row">
                <div class="dc-stat-card dc-stat-total">
                    <div class="dc-stat-icon"><i class="fas fa-coins"></i></div>
                    <div>
                        <div class="dc-stat-label">Grand Total</div>
                        <div class="dc-stat-value">₹{{ number_format($grandTotal, 2) }}</div>
                    </div>
                </div>
                <div class="dc-stat-card dc-stat-cash">
                    <div class="dc-stat-icon"><i class="fas fa-money-bill-wave"></i></div>
                    <div>
                        <div class="dc-stat-label">Cash</div>
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
                    <div class="dc-stat-icon"><i class="fas fa-list"></i></div>
                    <div>
                        <div class="dc-stat-label">Entries</div>
                        <div class="dc-stat-value">{{ $collections->count() }}</div>
                    </div>
                </div>
            </div>

            {{-- Deposit Form (Cash only) --}}
            @if($alreadyClosed && ($balance === null || ($balance && $balance->status === 'pending')))
            <div class="dc-card mb-4">
                <div class="dc-card-header">
                    <i class="fas fa-university mr-2"></i> Deposit Cash to Bank
                    <span class="dc-badge dc-badge-info ml-2">Cash only — online payments already in bank</span>
                </div>
                <div class="dc-card-body">
                    <form action="{{ route('deposite.history.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row align-items-end">
                            <div class="col-md-3 mb-3">
                                <label class="dc-label">Cash Available to Deposit</label>
                                <div class="dc-info-box">₹{{ number_format($cashTotal ?? 0, 2) }}</div>
                                <input type="hidden" name="available_cash" value="{{ $cashTotal ?? 0 }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="dc-label">Deposit Amount <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" max="{{ $cashTotal ?? 0 }}"
                                       name="amount" class="form-control dc-input" placeholder="₹ Enter amount" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="dc-label">Select Bank <span class="text-danger">*</span></label>
                                <select name="bank" class="form-control dc-input" required>
                                    <option value="" disabled selected>-- Choose Bank --</option>
                                    <option value="Bank of Baroda">Bank of Baroda</option>
                                    <option value="SBI">SBI</option>
                                    <option value="HDFC">HDFC</option>
                                    <option value="ICICI">ICICI</option>
                                    <option value="Axis Bank">Axis Bank</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="dc-label">Deposit Slip / Receipt <span class="text-danger">*</span></label>
                                <input type="file" name="image" class="form-control dc-input" accept="image/*" required>
                            </div>
                            <div class="col-md-2 mb-3">
                                <button type="submit" class="dc-btn dc-btn-primary w-100"
                                        onclick="return confirm('Confirm deposit to bank?')">
                                    <i class="fas fa-paper-plane mr-1"></i> Submit Deposit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endif

            {{-- Collections Table --}}
            <div class="dc-card">
                <div class="dc-card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-table mr-2"></i> Today's Verified Payments</span>
                    @if(!$alreadyClosed && $collections->count() > 0)
                        <span class="dc-badge dc-badge-warning">Day Open</span>
                    @elseif($alreadyClosed)
                        <span class="dc-badge dc-badge-success"><i class="fas fa-lock mr-1"></i> Day Closed</span>
                    @endif
                </div>
                <div class="dc-card-body p-0">
                    <div class="table-responsive">
                        <table class="dc-table" id="dailyTable">
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
                                @forelse($collections as $item)
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
                                            <div class="dc-ref">{{ $item->reference_no ?? '' }}</div>
                                        </td>
                                        <td class="text-center">
                                            <span class="dc-branch">{{ $item->branch }}</span>
                                        </td>
                                        <td class="text-center">
                                            @php $method = strtolower($item->payment_method); @endphp
                                            @if(in_array($method, ['cash']))
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
                                        <td class="dc-notes">{{ \Illuminate\Support\Str::limit($item->message ?? '—', 60) }}</td>
                                        <td class="text-right dc-amount">₹{{ number_format($item->amount, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="dc-empty">
                                            <i class="fas fa-inbox"></i>
                                            <p>No verified collections for this date.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            @if($collections->count() > 0)
                            <tfoot>
                                <tr>
                                    <th colspan="6"></th>
                                    <th class="text-right">Total:</th>
                                    <th class="text-right dc-total-cell">
                                        ₹{{ number_format($grandTotal, 2) }}
                                    </th>
                                </tr>
                            </tfoot>
                            @endif
                        </table>
                    </div>
                </div>

                {{-- Close Day Footer --}}
                @if(!$alreadyClosed)
                <div class="dc-card-footer">
                    <form action="{{ route('closing.amount.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="amount" value="{{ $grandTotal }}">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                            <div class="dc-close-info">
                                <i class="fas fa-info-circle text-info mr-1"></i>
                                Closing the day will lock today's collection. Only cash (₹{{ number_format($cashTotal,2) }}) can be deposited.
                            </div>
                            <button type="submit" class="dc-btn dc-btn-danger"
                                    onclick="return confirm('Close today\'s collection?\n\nTotal: ₹{{ number_format($grandTotal,2) }}\nCash: ₹{{ number_format($cashTotal,2) }}\nOnline: ₹{{ number_format($onlineTotal,2) }}')">
                                <i class="fas fa-lock mr-2"></i> Close Day — ₹{{ number_format($grandTotal, 2) }}
                            </button>
                        </div>
                    </form>
                </div>
                @else
                <div class="dc-card-footer">
                    <div class="dc-closed-badge">
                        <i class="fas fa-check-circle mr-2"></i>
                        Today's collection has been closed.
                        @if($balance && $balance->status === 'pending')
                            Cash of <strong>₹{{ number_format($cashTotal,2) }}</strong> is pending deposit.
                        @endif
                    </div>
                </div>
                @endif
            </div>

        </div>
    </section>
</div>

<style>
/* ── Design tokens ─────────────────────────────────── */
:root {
    --dc-bg:       #f0f4f8;
    --dc-surface:  #ffffff;
    --dc-border:   #e2e8f0;
    --dc-text:     #1a202c;
    --dc-muted:    #718096;
    --dc-primary:  #2b6cb0;
    --dc-primary-light: #ebf4ff;
    --dc-green:    #276749;
    --dc-green-bg: #f0fff4;
    --dc-amber:    #92400e;
    --dc-amber-bg: #fffbeb;
    --dc-red:      #c53030;
    --dc-red-bg:   #fff5f5;
    --dc-radius:   10px;
    --dc-shadow:   0 1px 3px rgba(0,0,0,.08), 0 4px 16px rgba(0,0,0,.05);
    --dc-font:     'DM Sans', 'Segoe UI', sans-serif;
}

.dc-wrapper { background: var(--dc-bg); min-height: 100vh; font-family: var(--dc-font); }

/* Page header */
.dc-page-header { background: var(--dc-surface); border-bottom: 1px solid var(--dc-border);
    padding: 18px 0 !important; margin-bottom: 24px; }
.dc-title  { font-size: 22px; font-weight: 700; color: var(--dc-text); margin: 0 0 2px; }
.dc-subtitle { color: var(--dc-muted); font-size: 13px; }

/* Stat cards */
.dc-cards-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(190px,1fr)); gap: 16px; margin-bottom: 24px; }
.dc-stat-card  { background: var(--dc-surface); border: 1px solid var(--dc-border); border-radius: var(--dc-radius);
    padding: 20px; display: flex; align-items: center; gap: 16px; box-shadow: var(--dc-shadow); }
.dc-stat-icon  { width: 46px; height: 46px; border-radius: 10px; display: flex; align-items: center;
    justify-content: center; font-size: 18px; flex-shrink: 0; }
.dc-stat-total .dc-stat-icon  { background: var(--dc-primary-light); color: var(--dc-primary); }
.dc-stat-cash  .dc-stat-icon  { background: #f0fff4; color: #276749; }
.dc-stat-online .dc-stat-icon { background: #faf5ff; color: #6b46c1; }
.dc-stat-entries .dc-stat-icon{ background: #fffbeb; color: #92400e; }
.dc-stat-label { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing:.5px; color: var(--dc-muted); }
.dc-stat-value { font-size: 22px; font-weight: 700; color: var(--dc-text); line-height: 1.2; }

/* Card */
.dc-card { background: var(--dc-surface); border: 1px solid var(--dc-border); border-radius: var(--dc-radius);
    box-shadow: var(--dc-shadow); overflow: hidden; }
.dc-card-header { padding: 14px 20px; border-bottom: 1px solid var(--dc-border); font-weight: 600;
    font-size: 14px; color: var(--dc-text); background: #fafbfc; display: flex; align-items: center; }
.dc-card-body   { padding: 20px; }
.dc-card-footer { padding: 14px 20px; border-top: 1px solid var(--dc-border); background: #fafbfc; }

/* Info box */
.dc-info-box { background: var(--dc-primary-light); color: var(--dc-primary); font-weight: 700;
    font-size: 16px; border-radius: 6px; padding: 8px 12px; }

/* Form elements */
.dc-label { font-size: 12px; font-weight: 600; color: var(--dc-muted); margin-bottom: 4px; display: block;
    text-transform: uppercase; letter-spacing: .4px; }
.dc-input  { border: 1px solid var(--dc-border); border-radius: 6px; font-size: 14px; color: var(--dc-text); }
.dc-input:focus { border-color: var(--dc-primary); box-shadow: 0 0 0 3px rgba(43,108,176,.12); }
.dc-date-input { border: 1px solid var(--dc-border); border-radius: 6px; font-size: 13px; padding: 5px 10px; }

/* Buttons */
.dc-btn { display: inline-flex; align-items: center; padding: 8px 18px; border-radius: 7px;
    font-size: 13px; font-weight: 600; border: none; cursor: pointer; text-decoration: none !important;
    transition: all .15s ease; white-space: nowrap; }
.dc-btn-primary { background: var(--dc-primary); color: #fff; }
.dc-btn-primary:hover { background: #2c5282; color: #fff; }
.dc-btn-danger  { background: var(--dc-red); color: #fff; }
.dc-btn-danger:hover { background: #9b2c2c; color: #fff; }
.dc-btn-outline { background: #fff; color: var(--dc-text); border: 1px solid var(--dc-border); }
.dc-btn-outline:hover { background: var(--dc-bg); color: var(--dc-text); }

/* Badges */
.dc-badge { display: inline-flex; align-items: center; padding: 3px 9px; border-radius: 20px;
    font-size: 11px; font-weight: 600; }
.dc-badge-primary  { background: #ebf4ff; color: #2b6cb0; }
.dc-badge-warning  { background: #fffbeb; color: #92400e; }
.dc-badge-secondary{ background: #f7fafc; color: #4a5568; border: 1px solid #e2e8f0; }
.dc-badge-success  { background: var(--dc-green-bg); color: var(--dc-green); }
.dc-badge-info     { background: #ebf8ff; color: #2c7a7b; }
.dc-badge-cash     { background: #f0fff4; color: #276749; }
.dc-badge-online   { background: #faf5ff; color: #6b46c1; }

/* Alerts */
.dc-alert { padding: 12px 16px; border-radius: var(--dc-radius); margin-bottom: 20px; font-size: 14px; font-weight: 500; }
.dc-alert-success { background: var(--dc-green-bg); color: var(--dc-green); border: 1px solid #9ae6b4; }
.dc-alert-danger  { background: var(--dc-red-bg); color: var(--dc-red); border: 1px solid #feb2b2; }

/* Table */
.dc-table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
.dc-table thead th { background: #fafbfc; border-bottom: 2px solid var(--dc-border); padding: 11px 14px;
    font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: var(--dc-muted); }
.dc-table tbody tr { border-bottom: 1px solid var(--dc-border); transition: background .1s; }
.dc-table tbody tr:hover { background: #f7fafc; }
.dc-table tbody td  { padding: 12px 14px; vertical-align: middle; }
.dc-table tfoot th  { padding: 12px 14px; border-top: 2px solid var(--dc-border); background: #f7fafc; }

.dc-name   { font-weight: 600; color: var(--dc-text); }
.dc-ref    { font-size: 11px; color: var(--dc-muted); margin-top: 2px; }
.dc-date   { font-weight: 500; color: var(--dc-text); }
.dc-time   { font-size: 11px; color: var(--dc-muted); }
.dc-notes  { color: var(--dc-muted); font-size: 12.5px; max-width: 220px; }
.dc-amount { font-weight: 700; color: #276749; font-size: 14px; }
.dc-total-cell { font-size: 16px; font-weight: 800; color: var(--dc-primary); }

.dc-empty  { text-align: center; padding: 60px 20px !important; color: var(--dc-muted); }
.dc-empty i{ display: block; font-size: 36px; margin-bottom: 10px; opacity: .3; }
.dc-empty p{ margin: 0; font-size: 14px; }

.dc-close-info  { font-size: 13px; color: var(--dc-muted); }
.dc-closed-badge{ display: flex; align-items: center; color: var(--dc-green); font-weight: 600; font-size: 14px; }

.gap-2 { gap: 8px; }
.gap-3 { gap: 12px; }
</style>
@endsection