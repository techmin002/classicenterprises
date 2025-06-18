<div class="modal fade" id="pay{{ $customer->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #0837a4; color: #fff;">
                <h5 class="modal-title" id="staticBackdropLabel">Pay</h5>
            </div>
            <form action="{{ route('finance.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <!-- Bike Name -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Amount</label>
                            <input type="number" name="amount" class="form-control" required
                                placeholder="Enter Amount">
                        </div>
                        <!-- Branch -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Payment Mode</label>
                            <select class="form-control" name="payment_mode">
                                <option value="" selected disabled>Select Payment Mode</option>
                                <option value="online">Online</option>
                                <option value="cash">Cash</option>
                                <option value="cheque">Cheque</option>
                            </select>
                        </div>
                        <input type="hidden" value="{{ $customer->id }}" name="customer_id">
                        <!-- Date -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" name="date" class="form-control" required>
                        </div>
                        <!-- Cheque Number (hidden by default) -->
                        <div class="col-md-6 mb-3 d-none" id="chequeNoDiv">
                            <label class="form-label">Cheque Number</label>
                            <input type="text" name="cheque_no" class="form-control"
                                placeholder="Enter Cheque Number">
                        </div>

                    </div>
                </div>

                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-success">Pay</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Target all modals (in case of multiple customers)
        $('[id^=pay]').each(function() {
            const modal = $(this);
            const paymentModeSelect = modal.find('select[name="payment_mode"]');
            const chequeNoDiv = modal.find('#chequeNoDiv');

            paymentModeSelect.on('change', function() {
                if ($(this).val() === 'cheque') {
                    chequeNoDiv.removeClass('d-none');
                } else {
                    chequeNoDiv.addClass('d-none');
                }
            });
        });
    });
</script>
