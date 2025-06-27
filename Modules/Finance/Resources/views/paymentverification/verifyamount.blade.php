<div class="modal fade" id="verifyModal{{ $value->id }}" tabindex="-1" role="dialog"
    aria-labelledby="verifyModalLabel{{ $value->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center bg-primary text-white">
                <h5 class="modal-title">Payment Verification</h5>
            </div>
            <form action="{{ route('payment-verification.store', $value->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row gy-3">
                        <div class="col-md-6">
                            <label>Total Amount</label>
                            <input type="number" name="total_amount" class="form-control"
                                value="{{ $value->total_amount }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label>Paid Amount</label>
                            <input type="number" name="paid_amount" class="form-control"
                                value="{{ $value->paid_amount }}" readonly>
                        </div>
                    </div>
                    <div class="row gy-3 mt-2">
                        <div class="col-md-6">
                            <label>Remaining Amount</label>
                            <input type="number" name="remaining_amount" class="form-control"
                                value="{{ $value->remaining_amount }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label>Date</label>
                            <input type="date" name="date" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label>Message</label>
                        <textarea name="message" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-success">Verified</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
