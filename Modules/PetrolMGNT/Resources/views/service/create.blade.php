@php
    use Illuminate\Support\Facades\Auth;
@endphp

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #0837a4; color: #fff;">
                <h1 class="modal-title fs-5">Add Bike For Services</h1>
            </div>

            <form action="{{ route('service.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="row gy-3">
                            {{-- Branch --}}
                            @if (Auth::user()->role->name === 'Super Admin')
                                <div class="col-lg-6">
                                    <label class="form-label12">Branch</label>
                                    <select class="form-control" name="branch_id" id="branchSelect" required>
                                        <option value="" selected disabled>Select Branch</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <input type="hidden" name="branch_id" id="branchSelect"
                                    value="{{ Auth::user()->branch_id }}">
                            @endif
                            {{-- Bike --}}
                            <div class="col-lg-6">
                                <label class="form-label12">Select Bike</label>
                                <select class="form-control" name="bike_id" id="bikeSelect" required>
                                    <option value="" selected disabled>Select Bike Number</option>
                                </select>
                            </div>

                            {{-- Amount --}}
                            <div class="col-lg-6">
                                <label class="form-label12">Amount</label>
                                <input class="form-control" type="text" name="amount" placeholder="Enter Amount"
                                    required>
                            </div>

                            {{-- Date --}}
                            <div class="col-lg-6 mt-3">
                                <label class="form-label12">Date</label>
                                <input class="form-control" type="date" name="date" required>
                            </div>

                            {{-- KM --}}
                            <div class="col-lg-6 mt-3">
                                <label class="form-label12">KM</label>
                                <input class="form-control" type="text" name="km" placeholder="Enter Kilometer"
                                    required>
                            </div>

                            {{-- Payment Type --}}
                            <div class="col-lg-12 mt-3">
                                <label class="form-label12 d-block mb-2">Payment Type</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="payment_type" id="paymentRadio"
                                        value="payment">
                                    <label class="form-check-label" for="paymentRadio">Payment</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="payment_type" id="tokenRadio"
                                        value="token">
                                    <label class="form-check-label" for="tokenRadio">Token</label>
                                </div>
                            </div>

                            {{-- Payment Mode --}}
                            <div class="col-lg-6 d-none" id="paymentModeDiv">
                                <label class="form-label12">Mode of Payment</label>
                                <select class="form-control" name="mode" id="modeSelect">
                                    <option value="" selected disabled>Select Payment Mode</option>
                                    <option value="petty cash">Petty Cash</option>
                                    <option value="online">Online</option>
                                    <option value="cheque">Cheque</option>
                                </select>
                            </div>

                            {{-- Cheque Number --}}
                            <div class="col-lg-6 d-none" id="chequeNumberDiv">
                                <label class="form-label12">Cheque Number</label>
                                <input class="form-control" type="text" name="cheque_number"
                                    placeholder="Enter Cheque Number">
                            </div>

                            {{-- Service Center (for token) --}}
                            <div class="col-lg-6 d-none" id="servicecenterDiv">
                                <label class="form-label12">Service Center</label>
                                <select class="form-control" name="service_center">
                                    <option value="" selected disabled>Select Service Center</option>
                                    @foreach ($servicecenter as $center)
                                        <option value="{{ $center->name }}">{{ $center->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Receipt --}}
                            <div class="col-lg-6 d-none" id="receiptDiv">
                                <label class="form-label12">Receipt</label>
                                <input class="form-control" type="file" name="image">
                            </div>

                            {{-- Message --}}
                            <div class="col-lg-12">
                                <label class="form-label12">Message</label>
                                <textarea class="form-control" name="message" required></textarea>
                            </div>

                            {{-- Status --}}
                            <div class="col-md-12">
                                <label class="form-label12">Publish</label><br>
                                <input type="checkbox" name="status" checked data-bootstrap-switch
                                    data-off-color="danger" data-on-color="success">
                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-start">
                    <button type="submit" class="btn btn-success">Save Item</button>
                    <button type="button" data-dismiss="modal" class="btn btn-danger">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script>
    $(document).ready(function() {
        const isSuperAdmin = "{{ Auth::user()->role->name }}" === "Super Admin";

        // Auto-load bikes if not Super Admin
        if (!isSuperAdmin) {
            const branchId = "{{ Auth::user()->branch_id }}";
            fetchBikes(branchId);
        }

        // Fetch bikes when branch changes
        $('#branchSelect').on('change', function() {
            const branchId = $(this).val();
            fetchBikes(branchId);
        });

        function fetchBikes(branchId) {
            if (branchId) {
                $.ajax({
                    url: '{{ route('get.bikes.by.branch') }}',
                    type: 'GET',
                    data: {
                        branch_id: branchId
                    },
                    success: function(data) {
                        $('#bikeSelect').empty().append(
                            '<option value="" selected disabled>Select Bike Number</option>');
                        $.each(data, function(key, bike) {
                            $('#bikeSelect').append('<option value="' + bike.id + '">' +
                                bike.bikenumber + '</option>');
                        });
                    },
                    error: function() {
                        alert('Unable to fetch bikes. Try again.');
                    }
                });
            }
        }

        // Payment/Token toggle fields
        function updateFields() {
            const isPayment = $('#paymentRadio').is(':checked');
            const isToken = $('#tokenRadio').is(':checked');
            $('#paymentModeDiv, #chequeNumberDiv, #servicecenterDiv, #receiptDiv').addClass('d-none');

            if (isPayment) {
                $('#paymentModeDiv, #receiptDiv').removeClass('d-none');
                updateChequeField();
            } else if (isToken) {
                $('#servicecenterDiv, #receiptDiv').removeClass('d-none');
            }
        }

        function updateChequeField() {
            if ($('#modeSelect').val() === 'cheque') {
                $('#chequeNumberDiv').removeClass('d-none');
            } else {
                $('#chequeNumberDiv').addClass('d-none');
            }
        }

        $('input[name="payment_type"]').on('change', updateFields);
        $('#modeSelect').on('change', updateChequeField);
    });
</script>
