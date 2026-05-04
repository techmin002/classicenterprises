<div class="modal fade" id="payInstallModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content rounded">
            <div class="modal-header justify-content-center bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-tools mr-2"></i>
                    Pay Installation — Payment #{{ $payments->count() + 1 }}
                </h5>
            </div>
            <form action="{{ route('finance.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="payment_for" value="installation">
                <input type="hidden" name="customer_id" value="{{ $customer->id }}">

                <div class="modal-body">

                    <div class="alert alert-primary py-2 mb-3">
                        <i class="fas fa-list-ol mr-1"></i>
                        This will be recorded as
                        <strong>Payment #{{ $payments->count() + 1 }}</strong>
                        for this customer's installation.
                        Full due amount is pre-filled — reduce if making a partial payment.
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="info-box bg-primary text-white mb-0" style="min-height:60px;">
                                <span class="info-box-icon" style="font-size:14px;line-height:60px;width:50px;"><i class="fas fa-rupee-sign"></i></span>
                                <div class="info-box-content" style="padding:5px 10px;">
                                    <span class="info-box-text" style="font-size:12px;">Total</span>
                                    <span class="info-box-number" style="font-size:16px;">Rs. {{ number_format($installTotal) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box bg-success text-white mb-0" style="min-height:60px;">
                                <span class="info-box-icon" style="font-size:14px;line-height:60px;width:50px;"><i class="fas fa-check"></i></span>
                                <div class="info-box-content" style="padding:5px 10px;">
                                    <span class="info-box-text" style="font-size:12px;">Paid So Far</span>
                                    <span class="info-box-number" style="font-size:16px;">Rs. {{ number_format($installPaid) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box bg-danger text-white mb-0" style="min-height:60px;">
                                <span class="info-box-icon" style="font-size:14px;line-height:60px;width:50px;"><i class="fas fa-exclamation"></i></span>
                                <div class="info-box-content" style="padding:5px 10px;">
                                    <span class="info-box-text" style="font-size:12px;">Remaining Due</span>
                                    <span class="info-box-number" style="font-size:16px;">Rs. {{ number_format($installDue) }}</span>
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
                                <input type="number" name="amount" id="installAmount"
                                    class="form-control font-weight-bold"
                                    value="{{ $installDue }}"
                                    max="{{ $installDue }}" min="1" required
                                    oninput="calcInstallRemaining(this.value)">
                            </div>
                            <small class="text-muted">Max: Rs. {{ number_format($installDue) }}</small>
                            <div class="mt-1">
                                <small>Remaining after this payment:
                                    <strong class="text-danger" id="installRemaining">Rs. 0</strong>
                                </small>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Payment Mode <span class="text-danger">*</span></label>
                            <select name="payment_mode" class="form-control" onchange="toggleInstallCheque(this.value)" required>
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

                        <div class="col-md-6 mb-3 d-none" id="installChequeDiv">
                            <label class="font-weight-bold">Cheque Number <span class="text-danger">*</span></label>
                            <input type="text" name="cheque_no" id="installChequeNo" class="form-control" placeholder="Enter Cheque Number">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="font-weight-bold">Remarks</label>
                            <textarea name="remarks" class="form-control" rows="2" placeholder="Optional..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-check mr-1"></i> Confirm Payment #{{ $payments->count() + 1 }}
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>