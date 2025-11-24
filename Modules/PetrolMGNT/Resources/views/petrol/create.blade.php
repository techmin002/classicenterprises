@php use Illuminate\Support\Facades\Auth; @endphp

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #0837a4; color: #fff;">
                <h1 class="modal-title fs-5">Add Petrol For Bike</h1>
            </div>
            <form action="{{ route('petrol.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="row gy-3">

                            {{-- Branch --}}
                            @if (Auth::user()->role->name === 'Super Admin')
                                <div class="col-lg-6">
                                    <label class="form-label12">Branch</label>
                                    <select class="form-control" id="branchSelect">
                                        <option value="" disabled selected>Select Branch</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <input type="hidden" id="branchSelect" value="{{ Auth::user()->branch_id }}">
                            @endif

                            {{-- Bike --}}
                            <div class="col-lg-6">
                                <label class="form-label12">Select Bike</label>
                                <select class="form-control" name="bike_id" id="bikeSelect" required>
                                    <option value="" selected disabled>Select Bike Number</option>
                                    @foreach ($bike as $b)
                                        <option value="{{ $b->id }}" data-branch="{{ $b->branch_id }}">
                                            {{ $b->bikenumber }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Amount --}}
                            <div class="col-lg-6">
                                <label class="form-label12">Amount</label>
                                <input class="form-control" type="text" name="amount" placeholder="Enter Amount" required>
                            </div>

                            {{-- Date --}}
                            <div class="col-lg-6">
                                <label class="form-label12">Date</label>
                                <input class="form-control" type="date" name="date" required>
                            </div>

                            {{-- KM --}}
                            <div class="col-lg-6">
                                <label class="form-label12">KM</label>
                                <input class="form-control" type="text" name="km" placeholder="Enter KM" required>
                            </div>

                            {{-- Payment Type --}}
                            <div class="col-lg-12 mt-3">
                                <label class="form-label12 d-block mb-2">Payment Type</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="payment_type" id="paymentRadio" value="payment">
                                    <label class="form-check-label" for="paymentRadio">Payment</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="payment_type" id="tokenRadio" value="token">
                                    <label class="form-check-label" for="tokenRadio">Token</label>
                                </div>
                            </div>

                            {{-- Mode of Payment --}}
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
                                <input type="text" class="form-control" name="cheque_number" placeholder="Enter Cheque Number">
                            </div>

                            {{-- Petrol Pump --}}
                            <div class="col-lg-6 d-none" id="petrolPumpDiv">
                                <label class="form-label12">Petrol Pump</label>
                                <select class="form-control" name="petrol_pump">
                                    <option value="" selected disabled>Select Pump</option>
                                    @foreach ($petrolPumps as $pump)
                                        <option value="{{ $pump->name }}">{{ $pump->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Receipt --}}
                            <div class="col-lg-6 d-none" id="receiptDiv">
                                <label class="form-label12">Receipt</label>
                                <input type="file" class="form-control" name="image">
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

{{-- Script --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const paymentRadio = document.getElementById("paymentRadio");
        const tokenRadio = document.getElementById("tokenRadio");
        const paymentModeDiv = document.getElementById("paymentModeDiv");
        const chequeNumberDiv = document.getElementById("chequeNumberDiv");
        const petrolPumpDiv = document.getElementById("petrolPumpDiv");
        const receiptDiv = document.getElementById("receiptDiv");
        const modeSelect = document.getElementById("modeSelect");

        // Filter bikes by branch
        const branchSelect = document.getElementById("branchSelect");
        const bikeSelect = document.getElementById("bikeSelect");

        function filterBikesByBranch(branchId) {
            Array.from(bikeSelect.options).forEach(option => {
                if (!option.value) return; // skip placeholder
                option.style.display = option.dataset.branch == branchId ? 'block' : 'none';
            });
        }

        @if(Auth::user()->role->name !== 'Super Admin')
            filterBikesByBranch("{{ Auth::user()->branch_id }}");
        @endif

        branchSelect?.addEventListener("change", function () {
            filterBikesByBranch(this.value);
            bikeSelect.value = ""; // reset selection
        });

        function updateFields() {
            if (paymentRadio.checked) {
                paymentModeDiv.classList.remove("d-none");
                petrolPumpDiv.classList.add("d-none");
                receiptDiv.classList.remove("d-none");
                updateChequeField();
            } else if (tokenRadio.checked) {
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

        function updateChequeField() {
            chequeNumberDiv.classList.toggle("d-none", modeSelect.value !== "cheque");
        }

        paymentRadio.addEventListener("change", updateFields);
        tokenRadio.addEventListener("change", updateFields);
        modeSelect.addEventListener("change", updateChequeField);
    });
</script>
