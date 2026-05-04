 <h6 class="text-muted font-weight-bold text-uppercase mb-2">
                <i class="fas fa-chart-pie mr-1"></i> Overall Summary
            </h6>
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="info-box bg-primary text-white shadow-sm mb-0">
                        <span class="info-box-icon"><i class="fas fa-rupee-sign"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Grand Total</span>
                            <span class="info-box-number">Rs. {{ number_format($grandTotal) }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box bg-success text-white shadow-sm mb-0">
                        <span class="info-box-icon"><i class="fas fa-check-circle"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Paid</span>
                            <span class="info-box-number">Rs. {{ number_format($grandPaid) }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box bg-danger text-white shadow-sm mb-0">
                        <span class="info-box-icon"><i class="fas fa-exclamation-circle"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Due</span>
                            <span class="info-box-number">Rs. {{ number_format($grandDue) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ✅ Installation & Ticket Breakdown Cards --}}
            <h6 class="text-muted font-weight-bold text-uppercase mb-2">
                <i class="fas fa-tools mr-1"></i> Installation &nbsp;|&nbsp;
                <i class="fas fa-ticket-alt mr-1"></i> Ticket Breakdown
            </h6>
            <div class="row mb-4">

                {{-- Installation Card --}}
                <div class="col-md-6 mb-3">
                    <div class="card border-left-primary shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="font-weight-bold text-primary">
                                    <i class="fas fa-tools mr-1"></i> Installation
                                </span>
                                @if($installDue > 0)
                                    <button type="button" class="btn btn-primary btn-sm"
                                        data-toggle="modal" data-target="#payInstallModal">
                                        <i class="fas fa-plus mr-1"></i> Pay Installation
                                    </button>
                                @else
                                    <span class="badge badge-success p-2">
                                        <i class="fas fa-check mr-1"></i> Fully Paid
                                    </span>
                                @endif
                            </div>
                            <div class="row text-center mb-2">
                                <div class="col-4">
                                    <small class="text-muted d-block">Total</small>
                                    <strong class="text-primary">Rs. {{ number_format($installTotal) }}</strong>
                                </div>
                                <div class="col-4">
                                    <small class="text-muted d-block">Paid</small>
                                    <strong class="text-success">Rs. {{ number_format($installPaid) }}</strong>
                                </div>
                                <div class="col-4">
                                    <small class="text-muted d-block">Due</small>
                                    <strong class="text-danger">Rs. {{ number_format($installDue) }}</strong>
                                </div>
                            </div>
                            @php $installPercent = $installTotal > 0 ? round(($installPaid / $installTotal) * 100) : 0; @endphp
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-primary" style="width: {{ $installPercent }}%"></div>
                            </div>
                            <small class="text-muted">{{ $installPercent }}% paid</small>

                            {{-- Payment sequence indicator --}}
                            @if($payments->count() > 0)
                                <hr class="my-2">
                                <small class="text-muted">
                                    <i class="fas fa-list-ol mr-1"></i>
                                    {{ $payments->count() }} payment(s) recorded —
                                    Next will be <strong>Payment #{{ $payments->count() + 1 }}</strong>
                                </small>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Ticket Card --}}
                <div class="col-md-6 mb-3">
                    <div class="card border-left-warning shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="font-weight-bold text-warning">
                                    <i class="fas fa-ticket-alt mr-1"></i> Tickets
                                </span>
                                @if($ticketDue > 0)
                                    <button type="button" class="btn btn-warning btn-sm text-white"
                                        data-toggle="modal" data-target="#payTicketModal">
                                        <i class="fas fa-plus mr-1"></i> Pay Ticket
                                    </button>
                                @else
                                    <span class="badge badge-success p-2">
                                        <i class="fas fa-check mr-1"></i> Fully Paid
                                    </span>
                                @endif
                            </div>
                            <div class="row text-center mb-2">
                                <div class="col-4">
                                    <small class="text-muted d-block">Total</small>
                                    <strong class="text-primary">Rs. {{ number_format($ticketTotal) }}</strong>
                                </div>
                                <div class="col-4">
                                    <small class="text-muted d-block">Paid</small>
                                    <strong class="text-success">Rs. {{ number_format($ticketPaid) }}</strong>
                                </div>
                                <div class="col-4">
                                    <small class="text-muted d-block">Due</small>
                                    <strong class="text-danger">Rs. {{ number_format($ticketDue) }}</strong>
                                </div>
                            </div>
                            @php $ticketPercent = $ticketTotal > 0 ? round(($ticketPaid / $ticketTotal) * 100) : 0; @endphp
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-warning" style="width: {{ $ticketPercent }}%"></div>
                            </div>
                            <small class="text-muted">{{ $ticketPercent }}% paid</small>

                            {{-- ✅ Ticket payment sequence indicator --}}
                            @if($ticketPayments->count() > 0)
                                <hr class="my-2">
                                <small class="text-muted">
                                    <i class="fas fa-list-ol mr-1"></i>
                                    {{ $ticketPayments->count() }} payment(s) recorded —
                                    Next will be <strong>Payment #{{ $ticketPayments->count() + 1 }}</strong>
                                </small>
                            @endif
                        </div>
                    </div>
                </div>

            </div>