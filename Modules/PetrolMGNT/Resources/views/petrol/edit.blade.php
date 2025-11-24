<div class="modal fade" id="editCategory{{ $value->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editModalLabel{{ $value->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <form action="{{ route('petrol.update', $value->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-header justify-content-center" style="background-color: #0837a4; color: #fff;">
                    <h5 class="modal-title">Edit Petrol For Bike</h5>
                </div>

                <div class="modal-body">
                    <div class="container">
                        <div class="row gy-3">

                            <div class="col-lg-6">
                                <label>Select Bike</label>
                                <select class="form-control" name="bike_id" required>
                                    <option value="" disabled>Select Bike Number</option>
                                    @foreach ($bike as $bikeOption)
                                        <option value="{{ $bikeOption->id }}"
                                            {{ $bikeOption->id == $value->bike_id ? 'selected' : '' }}>
                                            {{ $bikeOption->bikenumber }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-6">
                                <label>Amount</label>
                                <input class="form-control" type="number" step="0.01" name="amount"
                                    value="{{ $value->amount }}" required>
                            </div>

                            <div class="col-lg-6">
                                <label>Date</label>
                                <input class="form-control" type="date" name="date" value="{{ $value->date }}"
                                    required>
                            </div>

                            <div class="col-lg-6">
                                <label>KM</label>
                                <input class="form-control" type="number" name="km" value="{{ $value->km }}"
                                    required>
                            </div>

                            {{-- Payment Type --}}
                            <div class="col-lg-12">
                                <label class="d-block">Payment Type</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input payment-type-edit" type="radio" name="payment_type"
                                        id="editPayment{{ $value->id }}" value="payment"
                                        {{ $value->payment_type === 'payment' ? 'checked' : '' }}>
                                    <label class="form-check-label"
                                        for="editPayment{{ $value->id }}">Payment</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input payment-type-edit" type="radio" name="payment_type"
                                        id="editToken{{ $value->id }}" value="token"
                                        {{ $value->payment_type === 'token' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="editToken{{ $value->id }}">Token</label>
                                </div>
                            </div>

                            {{-- Payment Mode --}}
                            <div
                                class="col-lg-6 mt-2 edit-payment-mode {{ $value->payment_type === 'payment' ? '' : 'd-none' }}">
                                <label>Mode of Payment</label>
                                <select class="form-control mode-select-edit" name="mode">
                                    <option value="" disabled>Select Mode</option>
                                    <option value="petty cash" {{ $value->mode === 'petty cash' ? 'selected' : '' }}>
                                        Petty Cash</option>
                                    <option value="online" {{ $value->mode === 'online' ? 'selected' : '' }}>Online
                                    </option>
                                    <option value="cheque" {{ $value->mode === 'cheque' ? 'selected' : '' }}>Cheque
                                    </option>
                                </select>
                            </div>

                            {{-- Cheque Number --}}
                            <div
                                class="col-lg-6 mt-2 edit-cheque-number {{ $value->mode === 'cheque' ? '' : 'd-none' }}">
                                <label>Cheque Number</label>
                                <input type="text" class="form-control" name="cheque_number"
                                    value="{{ $value->cheque_number }}">
                            </div>

                            {{-- Petrol Pump --}}
                            <div
                                class="col-lg-6 mt-2 edit-petrol-pump {{ $value->payment_type === 'token' ? '' : 'd-none' }}">
                                <label>Select Petrol Pump</label>
                                <select class="form-control" name="petrol_pump">
                                    <option value="" disabled>Select Pump</option>
                                    @foreach ($petrolPumps as $pump)
                                        <option value="{{ $pump->name }}"
                                            {{ $value->petrol_pump == $pump->name ? 'selected' : '' }}>
                                            {{ $pump->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Receipt --}}
                            <div class="col-lg-6 mt-2 edit-receipt {{ $value->payment_type ? '' : 'd-none' }}">
                                <label>Receipt</label>
                                <input type="file" name="image" class="form-control">
                                @if ($value->image)
                                    <small class="text-muted">Current: <a
                                            href="{{ asset('upload/images/petrol-receipt/' . $value->image) }}"
                                            target="_blank">View Receipt</a></small>
                                @endif
                            </div>

                            <div class="col-lg-12">
                                <label>Message</label>
                                <textarea name="message" class="form-control" rows="2" required>{{ $value->message }}</textarea>
                            </div>

                            <div class="col-md-12">
                                <label>Publish</label><br>
                                <input type="checkbox" name="status" {{ $value->status === 'on' ? 'checked' : '' }}
                                    data-bootstrap-switch data-off-color="danger" data-on-color="success">
                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-start">
                    <button type="submit" class="btn btn-success">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
        <span id="output"></span>
    </div>
</div>

{{-- Script --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const modal = document.getElementById("editCategory{{ $value->id }}");

        if (modal) {
            const paymentRadios = modal.querySelectorAll(".payment-type-edit");
            const paymentModeDiv = modal.querySelector(".edit-payment-mode");
            const chequeNumberDiv = modal.querySelector(".edit-cheque-number");
            const petrolPumpDiv = modal.querySelector(".edit-petrol-pump");
            const receiptDiv = modal.querySelector(".edit-receipt");
            const modeSelect = modal.querySelector(".mode-select-edit");

            function updateEditFields() {
                const selectedType = [...paymentRadios].find(r => r.checked)?.value;

                if (selectedType === "payment") {
                    paymentModeDiv.classList.remove("d-none");
                    petrolPumpDiv.classList.add("d-none");
                    receiptDiv.classList.remove("d-none");
                    updateEditChequeField();
                } else if (selectedType === "token") {
                    paymentModeDiv.classList.add("d-none");
                    chequeNumberDiv.classList.add("d-none");
                    petrolPumpDiv.classList.remove("d-none");
                    receiptDiv.classList.remove("d-none");
                } else {
                    paymentModeDiv.classList.add("d-none");
                    chequeNumberDiv.classList.add("d-none");
                    petrolPumpDiv.classList.add("d-none");
                    receiptDiv.classList.add("d-none");
                }
            }

            function updateEditChequeField() {
                if (modeSelect?.value === "cheque") {
                    chequeNumberDiv.classList.remove("d-none");
                } else {
                    chequeNumberDiv.classList.add("d-none");
                }
            }

            paymentRadios.forEach(radio => {
                radio.addEventListener("change", updateEditFields);
            });

            modeSelect?.addEventListener("change", updateEditChequeField);

            updateEditFields(); // On load
        }
    });
</script>
