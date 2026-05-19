@extends('setting::layouts.master')

@section('title', 'Daily Collection')

@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Daily Collection</li>
</ol>
@endsection

@section('content')

<div class="content-wrapper">

<div class="content-header">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap:10px">
            <div>
                <h4 class="mb-0 font-weight-bold">Daily Collection</h4>
                <small class="text-muted">
                    {{ \Carbon\Carbon::parse($date)->format('l, d F Y') }}
                    @if(!$isToday)
                        <span class="badge badge-info ml-1">Past Date</span>
                    @endif
                </small>
            </div>
            <div class="d-flex align-items-center flex-wrap" style="gap:8px">
                <form method="GET" action="{{ request()->url() }}" class="mb-0">
                    <input type="date" name="date" value="{{ $date }}"
                           class="form-control form-control-sm"
                           onchange="this.form.submit()" style="width:160px">
                </form>
                <a href="{{ route('deposite.history') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-history mr-1"></i> Deposit History
                </a>
                <a href="{{ route('all-collection') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-chart-bar mr-1"></i> All Collections
                </a>
            </div>
        </div>
    </div>
</div>

<div class="content">
<div class="container-fluid">

{{-- ── ALERTS ──────────────────────────────────────────────────── --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
@endif

{{-- ── OPENING BALANCE ALERT ───────────────────────────────────── --}}
{{-- Only show if there is ACTUAL undeposited cash from a previous day --}}
@if($openingBalance > 0)
<div class="alert mb-3" style="background:#fff7ed;border:1px solid #fbbf24;border-left:5px solid #d97706;border-radius:6px;padding:14px 18px">
    <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap:8px">
        <div class="d-flex align-items-start" style="gap:12px">
            <i class="fas fa-exclamation-triangle mt-1" style="color:#d97706;font-size:18px"></i>
            <div>
                <strong style="color:#92400e;font-size:14px">Undeposited Cash from Previous Day(s)</strong><br>
                <small style="color:#b45309">
                    ₹{{ number_format($openingBalance, 2) }} was collected before
                    {{ \Carbon\Carbon::parse($date)->format('d M Y') }} but not yet deposited to the bank.
                    This carries forward until deposited.
                </small>
            </div>
        </div>
        <span class="badge badge-warning" style="font-size:15px;padding:8px 14px">
            ₹{{ number_format($openingBalance, 2) }}
        </span>
    </div>
</div>
@endif

{{-- ── KPI CARDS ────────────────────────────────────────────────── --}}
{{--
    Card breakdown:
    1. Today's Total      — today's verified payments only
    2. Cash Collected     — today's cash + yesterday's pending (total cash in hand)
    3. Online / Card      — today's online only (already in bank)
    4. Cash in Hand       — total undeposited cash (opening + today if not closed)
--}}
<div class="row mb-3">

    {{-- Today's Total --}}
    <div class="col-6 col-md-3">
        <div class="info-box shadow-sm mb-2">
            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-coins"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Today's Total</span>
                <span class="info-box-number">₹{{ number_format($grandTotal, 2) }}</span>
                <span class="progress-description text-muted" style="font-size:11px">
                    {{ $collections->count() }} transaction(s) today
                </span>
            </div>
        </div>
    </div>

    {{-- Cash Collected: today cash + opening balance --}}
    <div class="col-6 col-md-3">
        @php $totalCashResponsibility = $cashTotal + $openingBalance; @endphp
        <div class="info-box shadow-sm mb-2 @if($openingBalance > 0) border border-warning @endif">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-money-bill-wave"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Cash in Hand</span>
                <span class="info-box-number @if($totalCashResponsibility > 0) text-danger @endif">
                    ₹{{ number_format($totalCashResponsibility, 2) }}
                </span>
                <span class="progress-description" style="font-size:11px">
                    @if($openingBalance > 0 && $cashTotal > 0)
                        <span class="text-muted">Today ₹{{ number_format($cashTotal, 2) }}</span>
                        <span class="text-warning ml-1">+ Carry ₹{{ number_format($openingBalance, 2) }}</span>
                    @elseif($openingBalance > 0)
                        <span class="text-warning">₹{{ number_format($openingBalance, 2) }} carry-forward</span>
                    @elseif($cashTotal > 0)
                        <span class="text-muted">Today's cash collection</span>
                    @else
                        <span class="text-muted">No cash today</span>
                    @endif
                </span>
            </div>
        </div>
    </div>

    {{-- Online / Card --}}
    <div class="col-6 col-md-3">
        <div class="info-box shadow-sm mb-2">
            <span class="info-box-icon elevation-1" style="background:#6f42c1"><i class="fas fa-credit-card"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Online / Card</span>
                <span class="info-box-number">₹{{ number_format($onlineTotal, 2) }}</span>
                <span class="progress-description text-muted" style="font-size:11px">Auto-credited to bank</span>
            </div>
        </div>
    </div>

    {{-- Total pending deposit --}}
    <div class="col-6 col-md-3">
        <div class="info-box shadow-sm mb-2 @if($cashStillInHand > 0) bg-warning-subtle @endif">
            <span class="info-box-icon @if($cashStillInHand > 0) bg-orange @else bg-teal @endif elevation-1">
                <i class="fas fa-university"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Pending Deposit</span>
                <span class="info-box-number @if($cashStillInHand > 0) text-danger @endif">
                    ₹{{ number_format($cashStillInHand, 2) }}
                </span>
                <span class="progress-description text-muted" style="font-size:11px">
                    @if($cashStillInHand > 0)
                        Must be deposited to bank
                    @else
                        All deposited ✓
                    @endif
                </span>
            </div>
        </div>
    </div>

</div>

{{-- ── DEPOSIT FORM ─────────────────────────────────────────────── --}}
@if($alreadyClosed && $cashStillInHand > 0)
<div class="card card-warning card-outline mb-3">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-university mr-2 text-warning"></i>
            Deposit Cash to Bank
        </h3>
        <div class="card-tools">
            <span class="badge badge-warning" style="font-size:13px;padding:6px 12px">
                <i class="fas fa-wallet mr-1"></i>
                ₹{{ number_format($cashStillInHand, 2) }} to deposit
            </span>
        </div>
    </div>

    {{-- Per-day pending breakdown --}}
    @if($pendingClosings->count() > 0)
    <div style="background:#fffbeb;border-bottom:1px solid #fcd34d;padding:12px 20px">
        <small class="font-weight-bold text-uppercase" style="color:#92400e;letter-spacing:.5px;font-size:11px">
            Undeposited cash by closing day:
        </small>
        <div class="d-flex flex-wrap mt-2" style="gap:8px">
            @foreach($pendingClosings as $pc)
                @php $isPast = \Carbon\Carbon::parse($pc->date)->toDateString() < \Carbon\Carbon::today()->toDateString(); @endphp
                <div class="d-flex align-items-center @if($isPast) bg-danger @else bg-warning @endif text-white rounded px-3 py-1" style="font-size:12px;gap:6px">
                    <i class="fas fa-calendar-day"></i>
                    <span>{{ \Carbon\Carbon::parse($pc->date)->format('d M Y') }}</span>
                    <strong>₹{{ number_format($pc->remaining, 2) }}</strong>
                    @if($isPast) <em style="font-size:10px">(overdue)</em> @endif
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="card-body">
    <form action="{{ route('deposite.history.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">

            {{-- Amount --}}
            <div class="col-12 col-md-6 col-lg-2">
                <div class="form-group">
                    <label class="font-weight-bold text-sm mb-1">
                        <i class="fas fa-money-bill-wave text-success mr-1"></i>
                        Deposit Amount <span class="text-danger">*</span>
                    </label>

                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text font-weight-bold">Rs.</span>
                        </div>

                        <input type="number"
                               name="amount"
                               class="form-control"
                               step="0.01"
                               min="0.01"
                               max="{{ $cashStillInHand }}"
                               placeholder="0.00"
                               required>
                    </div>

                    <small class="text-muted d-block mt-1">
                        Maximum deposit: Rs. {{ number_format($cashStillInHand, 2) }}
                    </small>
                </div>
            </div>

            {{-- Bank --}}
            <div class="col-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <label class="font-weight-bold text-sm mb-1">
                        <i class="fas fa-university text-primary mr-1"></i>
                        Deposit Bank <span class="text-danger">*</span>
                    </label>

                    <select name="bank" class="form-control form-control-sm" required>
                        <option value="" disabled selected>-- Select Bank / Wallet --</option>

                        <optgroup label="Commercial Banks">
                            <option>Global IME Bank</option>
                            <option>Nabil Bank</option>
                            <option>NIC Asia Bank</option>
                            <option>Prabhu Bank</option>
                            <option>Kumari Bank</option>
                            <option>Everest Bank</option>
                            <option>Sanima Bank</option>
                            <option>Siddhartha Bank</option>
                            <option>Machhapuchchhre Bank</option>
                            <option>Laxmi Sunrise Bank</option>
                            <option>Himalayan Bank</option>
                            <option>NMB Bank</option>
                            <option>Citizens Bank International</option>
                            <option>Prime Commercial Bank</option>
                            <option>Nepal SBI Bank</option>
                            <option>Standard Chartered Bank Nepal</option>
                        </optgroup>

                        <optgroup label="Government Banks">
                            <option>Nepal Bank Limited</option>
                            <option>Rastriya Banijya Bank</option>
                            <option>Agricultural Development Bank</option>
                        </optgroup>

                        <optgroup label="Digital Wallets">
                            <option>eSewa</option>
                            <option>Khalti</option>
                            <option>IME Pay</option>
                        </optgroup>
                    </select>
                </div>
            </div>

            {{-- Deposit Slip --}}
            <div class="col-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <label class="font-weight-bold text-sm mb-1">
                        <i class="fas fa-file-upload text-warning mr-1"></i>
                        Deposit Slip / Receipt <span class="text-danger">*</span>
                    </label>

                    <div class="custom-file custom-file-sm">
                        <input type="file"
                               name="image"
                               class="custom-file-input"
                               id="depositSlip"
                               accept="image/*"
                               required>

                        <label class="custom-file-label text-truncate"
                               for="depositSlip">
                            Choose file...
                        </label>
                    </div>

                    <small class="text-muted d-block mt-1">
                        Upload clear bank receipt image
                    </small>
                </div>
            </div>

            {{-- Remarks --}}
            <div class="col-12 col-md-6 col-lg-2">
                <div class="form-group">
                    <label class="font-weight-bold text-sm mb-1">
                        <i class="fas fa-sticky-note text-secondary mr-1"></i>
                        Remarks
                    </label>

                    <input type="text"
                           name="notes"
                           class="form-control form-control-sm"
                           placeholder="Slip no / reference">
                </div>
            </div>

            {{-- Submit --}}
            <div class="col-12 col-lg-2 d-flex align-items-end">
                <div class="form-group w-100">
                    <button type="submit"
                            class="btn btn-warning btn-sm btn-block font-weight-bold shadow-sm"
                            onclick="return confirm('Confirm deposit to bank?\n\nAmount: Rs. ' + document.querySelector('[name=amount]').value)">

                        <i class="fas fa-paper-plane mr-1"></i>
                        Submit Deposit
                    </button>
                </div>
            </div>

        </div>
    </form>
</div>


</div>

@elseif($alreadyClosed && $cashStillInHand == 0)
<div class="alert alert-success d-flex align-items-center mb-3" style="gap:10px">
    <i class="fas fa-check-circle fa-lg"></i>
    <div>
        <strong>All cash deposited.</strong>
        Online payments are auto-credited to bank. Nothing pending.
    </div>
</div>
@endif

{{-- ── COLLECTIONS TABLE ────────────────────────────────────────── --}}
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-table mr-2"></i>
            @if($isToday) Today's @else {{ \Carbon\Carbon::parse($date)->format('d M Y') }} @endif
            Verified Payments
        </h3>
        <div class="card-tools">
            @if(!$alreadyClosed && $isToday && $collections->count() > 0)
                <span class="badge badge-warning"><i class="fas fa-lock-open mr-1"></i>Day Open</span>
            @elseif($alreadyClosed)
                <span class="badge badge-success"><i class="fas fa-lock mr-1"></i>Day Closed</span>
            @endif
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="installationTable" class="table table-hover table-sm mb-0">
                <thead class="thead-light">
                    <tr>
                        <th width="40">#</th>
                        <th>Type</th>
                        <th>Customer / Reference</th>
                        <th>Branch</th>
                        <th>Method</th>
                        <th>Verified At</th>
                        <th>Notes</th>
                        <th class="text-right">Amount</th>
                    </tr>
                </thead>
                <tbody>

                    {{-- ── Opening balance row (highlighted) ────────── --}}
                    @if($openingBalance > 0)
                    <tr style="background:#fff7ed;border-left:4px solid #d97706">
                        <td class="text-center text-muted">—</td>
                        <td colspan="5">
                            <span class="badge" style="background:#fef3c7;color:#92400e;border:1px solid #fcd34d;font-size:12px;padding:5px 10px">
                                <i class="fas fa-arrow-right mr-1"></i>
                                Opening Balance — undeposited cash from previous day(s)
                            </span>
                        </td>
                        <td></td>
                        <td class="text-right font-weight-bold" style="color:#d97706;font-size:14px">
                            ₹{{ number_format($openingBalance, 2) }}
                        </td>
                    </tr>
                    @endif

                    {{-- ── Today's payment rows ──────────────────────── --}}
                    @forelse($collections as $item)
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
                            <small class="text-muted">{{ $item->reference_no }}</small>
                        </td>
                        <td><small>{{ $item->branch }}</small></td>
                        <td>
                            @if(strtolower($item->payment_method) === 'cash')
                                <span class="badge badge-success">
                                    <i class="fas fa-money-bill-wave mr-1"></i>Cash
                                </span>
                            @else
                                <span class="badge badge-info">
                                    <i class="fas fa-credit-card mr-1"></i>{{ $item->payment_method }}
                                </span>
                            @endif
                        </td>
                        <td>
                            <div>{{ \Carbon\Carbon::parse($item->payment_date)->format('d M Y') }}</div>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($item->payment_date)->format('h:i A') }}</small>
                        </td>
                        <td><small class="text-muted">{{ \Illuminate\Support\Str::limit($item->message ?? '—', 50) }}</small></td>
                        <td class="text-right font-weight-bold text-success" style="font-size:14px">
                            ₹{{ number_format($item->amount, 2) }}
                        </td>
                    </tr>
                    @empty
                    @if($openingBalance == 0)
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="fas fa-inbox fa-3x mb-3 d-block" style="opacity:.3"></i>
                            No verified payments for this date.
                        </td>
                    </tr>
                    @endif
                    @endforelse

                </tbody>

                {{-- Totals footer --}}
                @if($collections->count() > 0 || $openingBalance > 0)
                <tfoot>
                    @if($openingBalance > 0)
                    <tr style="background:#fff7ed">
                        <th colspan="6"></th>
                        <th class="text-right" style="color:#92400e;font-size:12px">Opening balance:</th>
                        <th class="text-right" style="color:#d97706;font-size:14px">₹{{ number_format($openingBalance, 2) }}</th>
                    </tr>
                    <tr style="background:#f8f9fa">
                        <th colspan="6"></th>
                        <th class="text-right text-muted" style="font-size:12px">Today's collections:</th>
                        <th class="text-right text-success" style="font-size:14px">₹{{ number_format($grandTotal, 2) }}</th>
                    </tr>
                    @endif
                    <tr class="bg-light">
                        <th colspan="6"></th>
                        <th class="text-right text-muted font-weight-bold">Grand Total:</th>
                        <th class="text-right text-primary font-weight-bold" style="font-size:16px">
                            ₹{{ number_format($grandTotal + $openingBalance, 2) }}
                        </th>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>

    {{-- ── Close Day / Status Footer ─────────────────────────────── --}}
    @if(!$alreadyClosed && $isToday)
    <div class="card-footer d-flex align-items-center justify-content-between flex-wrap" style="gap:12px">
        <div class="text-muted" style="font-size:13px;flex:1">
            <i class="fas fa-info-circle text-info mr-1"></i>
            Closing will lock today's records.
            @if($cashTotal > 0)
                <strong>₹{{ number_format($cashTotal, 2) }} cash</strong> will need bank deposit.
            @endif
            @if($onlineTotal > 0)
                ₹{{ number_format($onlineTotal, 2) }} online is already credited.
            @endif
            @if($openingBalance > 0)
                <br><i class="fas fa-exclamation-triangle text-warning mr-1"></i>
                <strong class="text-warning">₹{{ number_format($openingBalance, 2) }} from previous days still pending deposit.</strong>
            @endif
        </div>
        <form action="{{ route('closing.amount.store') }}" method="POST" class="mb-0">
            @csrf
            <input type="hidden" name="amount" value="{{ $grandTotal }}">
            <button type="submit" class="btn btn-danger btn-sm font-weight-bold"
                    onclick="return confirm('Close today\'s collection?\n\nToday Total: ₹{{ number_format($grandTotal,2) }}\nCash: ₹{{ number_format($cashTotal,2) }}\nOnline: ₹{{ number_format($onlineTotal,2) }}')">
                <i class="fas fa-lock mr-1"></i>
                Close Day — ₹{{ number_format($grandTotal, 2) }}
            </button>
        </form>
    </div>

    @elseif($alreadyClosed)
    <div class="card-footer">
        <div class="d-flex align-items-center" style="gap:10px">
            <i class="fas fa-check-circle text-success"></i>
            <span style="font-size:13px;font-weight:600;color:#28a745">Day closed.</span>
            @if($cashStillInHand > 0)
                <span class="text-danger" style="font-size:13px">
                    ₹{{ number_format($cashStillInHand, 2) }} cash pending deposit.
                    Use the deposit form above — if skipped, it will appear as tomorrow's opening balance.
                </span>
            @else
                <span class="text-muted" style="font-size:13px">All cash deposited to bank.</span>
            @endif
        </div>
    </div>
    @endif

</div>{{-- /card --}}

</div>{{-- /container-fluid --}}
</div>{{-- /content --}}

<style>
.bg-orange { background-color: #fd7e14 !important; }
.bg-teal   { background-color: #20c997 !important; }
/* Custom file input label update */
.custom-file-input:lang(en) ~ .custom-file-label::after { content: "Browse"; }
</style>

<script>
// Update custom file input label with filename
document.getElementById('depositSlip')?.addEventListener('change', function(){
    var name = this.files[0]?.name || 'Choose file...';
    this.nextElementSibling.textContent = name;
});
</script>
</div>{{-- /content-wrapper --}}
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