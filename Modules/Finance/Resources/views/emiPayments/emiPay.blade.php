<div class="modal fade" id="pay{{ $customers->id }}" tabindex="-1" role="dialog" aria-labelledby="emiPaymentModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border: none; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <!-- Modal Header -->
            <div class="modal-header" style="background: linear-gradient(135deg, #0837a4 0%, #0a4dbe 100%); border-radius: 12px 12px 0 0; border: none; padding: 1.5rem;">
                <h5 class="modal-title text-white" id="emiPaymentModal">
                    <i class="fas fa-wallet mr-2"></i> Make EMI Payment
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body p-4">
                <!-- EMI Plan Summary -->
                <div class="alert alert-primary border-0" style="background-color: #f0f5ff; border-left: 4px solid #0837a4;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1 text-primary"><strong>EMI Plan:</strong> {{ $customers->emiPlan->title }}</h6>
                            <h6 class="mb-1 text-primary"><strong>Interest Rate:</strong> {{ $customers->emiPlan->interest_rate }}%</h6>
                        </div>
                        <div class="text-right">
                            <h4 class="mb-0 text-success">
                                <strong>Monthly Interest:</strong> Rs {{ number_format(($customers->customer->total_amount * $customers->emiPlan->interest_rate / 100)/12, 2) }}
                            </h4>
                        </div>
                    </div>
                </div>

                <form action="{{ route('emi.payments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="customer_id" value="{{ $customers->customer->id }}">
                    <input type="hidden" name="emi_customers_id" value="{{ $customers->id }}">

                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <!-- Payment Amount -->
                            <div class="form-group">
                                <label class="font-weight-bold">Payment Amount (₹)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light"><i class="fas fa-rupee-sign"></i></span>
                                    </div>
                                    <input type="number" name="payment" class="form-control form-control-lg" 
                                           value="{{ old('payment') }}" 
                                           min="1" step="0.01" required 
                                           placeholder="0.00">
                                </div>
                            </div>

                            <!-- Payment Date -->
                            <div class="form-group">
                                <label class="font-weight-bold">Payment Date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light"><i class="far fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="date" name="date" class="form-control form-control-lg" 
                                           value="{{ old('date', date('Y-m-d')) }}" required>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <!-- Payment Mode -->
                            <div class="form-group">
                                <label class="font-weight-bold">Payment Method</label>
                                <select class="form-control form-control-xlg select2 " name="payment_mode" required>
                                    <option value="" disabled selected>Select Method</option>
                                    <option value="online">Online Transfer</option>
                                    <option value="cash">Cash</option>
                                    <option value="cheque">Cheque</option>
                                </select>
                            </div>

                            <!-- Payment Status -->
                            <div class="form-group">
                                <label class="font-weight-bold">Payment Status</label>
                                <select class="form-control form-control-lg" name="status" required>
                                    <option value="" disabled selected>Select Status</option>
                                    <option value="1">Completed</option>
                                    <option value="0">Pending</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Cheque Details (Conditional) -->
                    <div class="row d-none" id="chequeDetails{{ $customers->id }}">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Cheque Number *</label>
                                <input type="text" name="cheque_no" class="form-control form-control-lg" 
                                       placeholder="Enter cheque number">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Bank Name</label>
                                <input type="text" name="bank_name" class="form-control form-control-lg" 
                                       placeholder="Enter bank name">
                            </div>
                        </div>
                    </div>

                    <!-- Payment Notes -->
                    <div class="form-group">
                        <label class="font-weight-bold">Payment Notes (Optional)</label>
                        <textarea name="message" class="form-control" rows="2" 
                                  placeholder="Enter any additional notes...">{{ old('message') }}</textarea>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer border-0 pt-4 pb-0 px-0">
                        <button type="button" class="btn btn-outline-secondary btn-lg px-4" data-dismiss="modal">
                            <i class="fas fa-times mr-2"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary btn-lg px-4" style="background: linear-gradient(135deg, #0837a4 0%, #0a4dbe 100%); border: none;">
                            <i class="fas fa-check-circle mr-2"></i> Submit Payment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Show/hide cheque details based on payment method
    $('select[name="payment_mode"]').change(function() {
        if ($(this).val() === 'cheque') {
            $('#chequeDetails{{ $customers->id }}').removeClass('d-none');
            $('#chequeDetails{{ $customers->id }} input').prop('required', true);
        } else {
            $('#chequeDetails{{ $customers->id }}').addClass('d-none');
            $('#chequeDetails{{ $customers->id }} input').prop('required', false);
        }
    });

    // Initialize select2 if needed
    if ($.fn.select2) {
        $('.select2').select2({
            minimumResultsForSearch: Infinity,
            width: '100%'
        });
    }
});
</script>

<style>
.modal-content {
    overflow: hidden;
}
.form-control-lg {
    height: calc(2.5em + 1rem + 2px);
    padding: 0.5rem 1rem;
    font-size: 1.1rem;
}
.input-group-text {
    padding: 0 1rem;
}
.btn-lg {
    padding: 0.6rem 1.5rem;
    font-size: 1.1rem;
    border-radius: 8px;
}
</style>