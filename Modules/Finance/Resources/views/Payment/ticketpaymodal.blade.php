<div class="modal fade" id="payTicketModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content rounded">
            <div class="modal-header justify-content-center bg-warning text-dark">
                <h5 class="modal-title">
                    <i class="fas fa-ticket-alt mr-2"></i>
                    Pay Ticket — Payment #{{ $ticketPayments->count() + 1 }}
                </h5>
            </div>
            <form action="{{ route('finance.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="payment_for" value="ticket">
                <input type="hidden" name="customer_id" value="{{ $customer->id }}">

                <div class="modal-body">
                    @php $dueTickets = $ticketsDue ?? collect(); @endphp

                    @if($dueTickets->count() > 1)
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Select Ticket <span class="text-danger">*</span></label>
                            <select name="ticket_id" class="form-control" required onchange="updateTicketDue(this)">
                                <option value="" disabled selected>-- Select Ticket --</option>
                                @foreach($dueTickets as $dt)
                                    <option value="{{ $dt->id }}"
                                        data-total="{{ $dt->total_amount }}"
                                        data-paid="{{ $dt->paid_amount }}"
                                        data-due="{{ $dt->due_amount }}">
                                        #{{ $dt->id }} — {{ ucfirst(str_replace('_', ' ', $dt->support_type)) }}
                                        (Due: Rs. {{ number_format($dt->due_amount) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @elseif($dueTickets->count() === 1)
                        <input type="hidden" name="ticket_id" value="{{ $dueTickets->first()->id }}">
                    @endif

                    <div class="alert alert-warning py-2 mb-3 text-dark">
                        <i class="fas fa-list-ol mr-1"></i>
                        This will be recorded as
                        <strong>Payment #{{ $ticketPayments->count() + 1 }}</strong>
                        for this customer's tickets.
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="info-box bg-primary text-white mb-0" style="min-height:60px;">
                                <span class="info-box-icon" style="font-size:14px;line-height:60px;width:50px;"><i class="fas fa-rupee-sign"></i></span>
                                <div class="info-box-content" style="padding:5px 10px;">
                                    <span class="info-box-text" style="font-size:12px;">Total</span>
                                    <span class="info-box-number" style="font-size:16px;" id="ticketModalTotal">Rs. {{ number_format($ticketTotal) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box bg-success text-white mb-0" style="min-height:60px;">
                                <span class="info-box-icon" style="font-size:14px;line-height:60px;width:50px;"><i class="fas fa-check"></i></span>
                                <div class="info-box-content" style="padding:5px 10px;">
                                    <span class="info-box-text" style="font-size:12px;">Paid</span>
                                    <span class="info-box-number" style="font-size:16px;" id="ticketModalPaid">Rs. {{ number_format($ticketPaid) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box bg-danger text-white mb-0" style="min-height:60px;">
                                <span class="info-box-icon" style="font-size:14px;line-height:60px;width:50px;"><i class="fas fa-exclamation"></i></span>
                                <div class="info-box-content" style="padding:5px 10px;">
                                    <span class="info-box-text" style="font-size:12px;">Due</span>
                                    <span class="info-box-number" style="font-size:16px;" id="ticketModalDue">Rs. {{ number_format($ticketDue) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">
                                Amount to Pay <span class="text-danger">*</span>
                                <small class="text-muted font-weight-normal">(partial allowed)</small>
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Rs.</span></div>
                                <input type="number" name="amount" id="ticketAmount"
                                    class="form-control" placeholder="Enter amount"
                                    max="{{ $ticketDue }}" min="1" required
                                    oninput="calcTicketRemaining(this.value)">
                            </div>
                            <small class="text-muted">Max: <span id="ticketMaxLabel">Rs. {{ number_format($ticketDue) }}</span></small>
                            <div class="mt-1">
                                <small>Remaining after:
                                    <strong class="text-danger" id="ticketRemaining">Rs. {{ number_format($ticketDue) }}</strong>
                                </small>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Payment Mode <span class="text-danger">*</span></label>
                            <select name="payment_mode" class="form-control" onchange="toggleTicketCheque(this.value)" required>
                                <option value="" disabled selected>Select Mode</option>
                                <option value="cash">Cash</option>
                                <option value="online">Online</option>
                                <option value="cheque">Cheque</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Date <span class="text-danger">*</span></label>
                            <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Receipt</label>
                            <input type="file" name="receipt" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                        </div>

                        <div class="col-md-6 mb-3 d-none" id="ticketChequeDiv">
                            <label class="font-weight-bold">Cheque Number <span class="text-danger">*</span></label>
                            <input type="text" name="cheque_no" id="ticketChequeNo" class="form-control" placeholder="Enter Cheque Number">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="font-weight-bold">Remarks</label>
                            <textarea name="remarks" class="form-control" rows="2" placeholder="Optional..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-warning text-white px-4">
                        <i class="fas fa-check mr-1"></i> Confirm Payment #{{ $ticketPayments->count() + 1 }}
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>