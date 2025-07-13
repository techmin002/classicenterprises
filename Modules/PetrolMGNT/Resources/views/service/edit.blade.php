<div class="modal fade" id="editCategory{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="editServiceLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #0837a4; color: #fff;">
                <h1 class="modal-title fs-5">Edit Bike Service</h1>
            </div>
            <form action="{{ route('service.update', $value->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="container">
                        <div class="row gy-3">
                            {{-- Branch --}}
                            <div class="col-lg-6">
                                <label class="form-label12">Branch</label>
                                <select class="form-control branchSelect" name="branch_id" required>
                                    <option value="" disabled>Select Branch</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}"
                                            {{ $value->bike->branch_id == $branch->id ? 'selected' : '' }}>
                                            {{ $branch->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Bike --}}
                            <div class="col-lg-6">
                                <label class="form-label12">Select Bike</label>
                                <select class="form-control bikeSelect" name="bike_id" required>
                                    <option value="{{ $value->bike->id }}">{{ $value->bike->bikenumber }}</option>
                                </select>
                            </div>

                            <div class="col-lg-6">
                                <label class="form-label12">Amount</label>
                                <input class="form-control" type="text" name="amount" value="{{ $value->amount }}"
                                    required>
                            </div>

                            <div class="col-lg-6">
                                <label class="form-label12">Date</label>
                                <input class="form-control" type="date" name="date" value="{{ $value->date }}"
                                    required>
                            </div>

                            <div class="col-lg-6">
                                <label class="form-label12">KM</label>
                                <input class="form-control" type="text" name="km" value="{{ $value->km }}"
                                    required>
                            </div>

                            {{-- Payment Type --}}
                            <div class="col-lg-12 mt-3">
                                <label class="form-label12 d-block mb-2">Payment Type</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input payment-type" type="radio" name="payment_type"
                                        value="payment" {{ $value->payment_type === 'payment' ? 'checked' : '' }}>
                                    <label class="form-check-label">Payment</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input payment-type" type="radio" name="payment_type"
                                        value="token" {{ $value->payment_type === 'token' ? 'checked' : '' }}>
                                    <label class="form-check-label">Token</label>
                                </div>
                            </div>

                            {{-- Mode of Payment --}}
                            <div class="col-lg-6 mt-3 d-none" id="paymentModeDiv{{ $value->id }}">
                                <label class="form-label12">Mode of Payment</label>
                                <select class="form-control mode-select" name="mode">
                                    <option value="" disabled>Select Payment Mode</option>
                                    <option value="petty cash" {{ $value->mode === 'petty cash' ? 'selected' : '' }}>
                                        Petty Cash</option>
                                    <option value="online" {{ $value->mode === 'online' ? 'selected' : '' }}>Online
                                    </option>
                                    <option value="cheque" {{ $value->mode === 'cheque' ? 'selected' : '' }}>Cheque
                                    </option>
                                </select>
                            </div>

                            {{-- Cheque Number --}}
                            <div class="col-lg-6 mt-3 d-none" id="chequeNumberDiv{{ $value->id }}">
                                <label class="form-label12">Cheque Number</label>
                                <input type="text" class="form-control" name="cheque_number"
                                    value="{{ $value->cheque_number }}">
                            </div>

                            {{-- Service Center (if token) --}}
                            <div class="col-lg-6 mt-3 d-none" id="serviceCenterDiv{{ $value->id }}">
                                <label class="form-label12">Service Center</label>
                                <select class="form-control" name="service_center">
                                    <option value="" disabled selected>Select Service Center</option>
                                    @foreach ($servicecenter as $center)
                                        <option value="{{ $center->name }}"
                                            {{ $value->service_center == $center->name ? 'selected' : '' }}>
                                            {{ $center->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Receipt --}}
                            <div class="col-lg-6 mt-3 d-none" id="receiptDiv{{ $value->id }}">
                                <label class="form-label12">Receipt</label>
                                <input type="file" class="form-control" name="image">
                                @if ($value->image)
                                    <small class="text-muted">Current: <a
                                            href="{{ asset('upload/images/service-receipt/' . $value->image) }}"
                                            target="_blank">View</a></small>
                                @endif
                            </div>

                            <div class="col-lg-12">
                                <label class="form-label12">Message</label>
                                <textarea name="message" class="form-control" required>{{ $value->message }}</textarea>
                            </div>

                            <div class="col-lg-12">
                                <label class="form-label12">Status</label><br>
                                <input type="checkbox" name="status" {{ $value->status == 'on' ? 'checked' : '' }}
                                    data-bootstrap-switch data-off-color="danger" data-on-color="success">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-start">
                    <button type="submit" class="btn btn-success">Update</button>
                    <button type="button" data-dismiss="modal" class="btn btn-danger">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- JS --}}
<script>
    $(document).ready(function() {
        const modalId = "{{ $value->id }}";

        function toggleFields() {
            const paymentType = $("input[name='payment_type']:checked", `#editCategory${modalId}`).val();
            const mode = $(`#paymentModeDiv${modalId} select`).val();

            if (paymentType === 'payment') {
                $(`#paymentModeDiv${modalId}`).removeClass('d-none');
                $(`#receiptDiv${modalId}`).removeClass('d-none');
                $(`#serviceCenterDiv${modalId}`).addClass('d-none');
                if (mode === 'cheque') {
                    $(`#chequeNumberDiv${modalId}`).removeClass('d-none');
                } else {
                    $(`#chequeNumberDiv${modalId}`).addClass('d-none');
                }
            } else if (paymentType === 'token') {
                $(`#serviceCenterDiv${modalId}`).removeClass('d-none');
                $(`#paymentModeDiv${modalId}`).addClass('d-none');
                $(`#chequeNumberDiv${modalId}`).addClass('d-none');
                $(`#receiptDiv${modalId}`).removeClass('d-none');
            }
        }

        $(`#editCategory${modalId} .payment-type`).change(toggleFields);
        $(`#paymentModeDiv${modalId} select`).change(toggleFields);
        toggleFields(); // call on load

        // Branch change bike reload
        $(`#editCategory${modalId} .branchSelect`).change(function() {
            const branchId = $(this).val();
            const bikeSelect = $(`#editCategory${modalId} .bikeSelect`);
            if (branchId) {
                $.ajax({
                    url: '{{ route('get.bikes.by.branch') }}',
                    type: 'GET',
                    data: {
                        branch_id: branchId
                    },
                    success: function(data) {
                        bikeSelect.empty().append(
                            '<option disabled selected>Select Bike</option>');
                        $.each(data, function(key, value) {
                            bikeSelect.append('<option value="' + value.id + '">' +
                                value.bikenumber + '</option>');
                        });
                    }
                });
            }
        });
    });
</script>
