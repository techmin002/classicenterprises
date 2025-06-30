@extends('setting::layouts.master')

@section('title', 'Support Ticket')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Support Assign</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Support Assign</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Support Assign</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- /.card -->
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Contact</th>
                                            <th class="text-center">Product</th>
                                            <th class="text-center">Address</th>
                                            <th class="text-center">Assign To</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $value)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>

                                                <td class="text-center">{{ $value->name }}</td>
                                                <td class="text-center">{{ $value->contact }}</td>
                                                <td class="text-center">{{ $value->product }}</td>
                                                <td class="text-center">{{ $value->address }}
                                                </td>
                                                <td class="text-center">{{ ucfirst($value->assign_to) }}</td>
                                                <td class="text-center">{{ $value->created_at }}</td>

                                                <td>
                                                    @can('edit_ticket')
                                                        <a href="" class="btn btn-success btn-xs w-75"
                                                            data-toggle="modal"
                                                            data-target="#exampleModal{{ $value->id }}">Action</a>
                                                    @endcan
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="exampleModal{{ $value->id }}"
                                                        tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content border-0 shadow">

                                                                <!-- Modal Header -->
                                                                <div class="modal-header bg-primary text-white">
                                                                    <div>
                                                                        <h5 class="modal-title mb-0" id="exampleModalLabel">
                                                                            <i class="fa fa-headset mr-2"></i> Take Action
                                                                        </h5>

                                                                    </div>
                                                                    <button type="button" class="close text-white"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>

                                                                <!-- Modal Body -->
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <form
                                                                            action="{{ route('outsidersupportdashboard-task.completestore', $value->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="total_amount"
                                                                                id="hiddenTotalAmount">
                                                                            <input type="hidden" name="service_method"
                                                                                id="hiddenServiceMethod">
                                                                            <input type="hidden" name="payment_method"
                                                                                id="hiddenPaymentMethod">
                                                                            <input type="hidden" name="service_type"
                                                                                id="hiddenServiceType" value="free">

                                                                            <button type="button" id="freeServiceBtn"
                                                                                class="btn btn-outline-primary btn-sm">Free
                                                                                Service</button>
                                                                            <button type="button" id="paidServiceBtn"
                                                                                class="btn btn-outline-success btn-sm ml-2">Paid
                                                                                Service</button>

                                                                            <div id="paidServiceSection"
                                                                                style="display:none;">
                                                                                <div class="form-group mt-3">
                                                                                    <label for="serviceCharge">Service
                                                                                        Charge</label>
                                                                                    <input type="number" id="serviceCharge"
                                                                                        name='service_charge'
                                                                                        class="form-control"
                                                                                        placeholder="Enter service charge"
                                                                                        min="0">
                                                                                </div>

                                                                                <!-- Accessories -->
                                                                                <div class="form-group">
                                                                                    <label>Accessories</label>
                                                                                    <div id="accessoryContainer"></div>
                                                                                    <button type="button" id="addAccessory"
                                                                                        class="badge badge-primary mt-2">Add
                                                                                        Accessory</button>
                                                                                </div>

                                                                                <div class="form-group">
                                                                                    <label>Overall Total</label>
                                                                                    <input type="text" id="overallTotal"
                                                                                        class="form-control" readonly>
                                                                                </div>

                                                                                <div class="form-group">
                                                                                    <label>Payment Taken?</label><br>
                                                                                    <div
                                                                                        class="form-check form-check-inline">
                                                                                        <input class="form-check-input"
                                                                                            type="radio"
                                                                                            name="paymentTaken"
                                                                                            id="paymentYes"
                                                                                            value="yes">
                                                                                        <label class="form-check-label"
                                                                                            for="paymentYes">Yes</label>
                                                                                    </div>
                                                                                    <div
                                                                                        class="form-check form-check-inline">
                                                                                        <input class="form-check-input"
                                                                                            type="radio"
                                                                                            name="paymentTaken"
                                                                                            id="paymentNo" value="no"
                                                                                            checked>
                                                                                        <label class="form-check-label"
                                                                                            for="paymentNo">No</label>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="form-group"
                                                                                    id="paidAmountField"
                                                                                    style="display: none;">
                                                                                    <label>Paid Amount</label>
                                                                                    <input type="number"
                                                                                        name="paid_amount"
                                                                                        class="form-control"
                                                                                        min="0">
                                                                                </div>

                                                                                <div class="form-group" id="paymentModes"
                                                                                    style="display:none;">
                                                                                    <label>Payment Mode</label>
                                                                                    <select class="form-control"
                                                                                        name="payment_method">
                                                                                        <option value="" selected
                                                                                            disabled>Select</option>
                                                                                        <option value="cash">Cash
                                                                                        </option>
                                                                                        <option value="cheque">Cheque
                                                                                        </option>
                                                                                        <option value="online">Online
                                                                                        </option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group mt-3">
                                                                                <label for="remark">Message /
                                                                                    Remark</label>
                                                                                <textarea class="form-control" name='message' required></textarea>
                                                                            </div>

                                                                            <!-- Footer -->
                                                                            <div class="modal-footer bg-light">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-dismiss="modal">
                                                                                    <i class="fa fa-times mr-1"></i> Close
                                                                                </button>
                                                                                <button type="submit"
                                                                                    class="btn btn-success">
                                                                                    <i class="fa fa-paper-plane mr-1"></i>
                                                                                    Save
                                                                                </button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>



                                                    <a href="" class="btn btn-primary btn-xs w-75 mt-2"
                                                        data-toggle="modal"
                                                        data-target="#exampleModal1{{ $value->id }}">Note</a>

                                                    {{-- modal start --}}
                                                    <div class="modal fade" id="exampleModal1{{ $value->id }}"
                                                        tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content border-0 shadow">
                                                                <!-- Modal Header -->
                                                                <div class="modal-header bg-primary text-white">
                                                                    <div>

                                                                    </div>
                                                                    <button type="button" class="close text-white"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>

                                                                <!-- Modal Body -->
                                                                <div class="modal-body">
                                                                    {{ $value->message }}
                                                                </div>

                                                                <!-- Modal Footer -->
                                                                <div class="modal-footer bg-light">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>S.N</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Contact</th>
                                            <th class="text-center">Product</th>
                                            <th class="text-center">Address</th>
                                            <th class="text-center">Assign To</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

@endsection
<script>
    const accessoryList = @json($accessories);
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let accessoryIndex = 0;

        const accessoryContainer = document.getElementById("accessoryContainer");
        const overallTotal = document.getElementById("overallTotal");
        const serviceChargeInput = document.getElementById("serviceCharge");

        const paidServiceSection = document.getElementById("paidServiceSection");
        const paymentModes = document.getElementById("paymentModes");
        const paidAmountField = document.getElementById("paidAmountField");

        const hiddenTotalAmount = document.getElementById("hiddenTotalAmount");
        const hiddenServiceMethod = document.getElementById("hiddenServiceMethod");
        const hiddenPaymentMethod = document.getElementById("hiddenPaymentMethod");

        const addAccessoryBtn = document.getElementById("addAccessory");
        const paymentYes = document.getElementById("paymentYes");
        const paymentNo = document.getElementById("paymentNo");

        const serviceBtns = {
            free: document.getElementById("freeServiceBtn"),
            paid: document.getElementById("paidServiceBtn")
        };

        function updateTotal() {
            let total = 0;

            document.querySelectorAll(".accessory-row-total").forEach(input => {
                total += parseFloat(input.value) || 0;
            });

            total += parseFloat(serviceChargeInput.value) || 0;

            overallTotal.value = total.toFixed(2);
            hiddenTotalAmount.value = total.toFixed(2);
        }

        function createAccessoryRow(index) {
            const options = accessoryList.map(item =>
                `<option value="${item.name}" data-price="${item.sales_price}">${item.name}</option>`
            ).join('');

            const row = document.createElement("div");
            row.className = "row mb-2 accessory-row";
            row.innerHTML = `
                <div class="col-md-4">
                    <select name="accessories[${index}][name]" class="form-control accessory-name">
                        <option value="">Select Accessory</option>
                        ${options}
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" name="accessories[${index}][qty]" class="form-control accessory-qty" value="1" min="1">
                </div>
                <div class="col-md-2">
                    <input type="text" name="accessories[${index}][price]" class="form-control accessory-price" readonly>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control accessory-row-total" readonly>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-danger btn-sm remove-accessory"><i class="fa fa-times"></i></button>
                </div>
            `;
            accessoryContainer.appendChild(row);
        }

        addAccessoryBtn.addEventListener("click", () => {
            createAccessoryRow(accessoryIndex++);
        });

        document.addEventListener("change", function(e) {
            if (e.target.matches(".accessory-name")) {
                const row = e.target.closest(".row");
                const price = parseFloat(e.target.selectedOptions[0].getAttribute("data-price")) || 0;
                const qtyInput = row.querySelector(".accessory-qty");
                const totalInput = row.querySelector(".accessory-row-total");
                row.querySelector(".accessory-price").value = price;
                const qty = parseInt(qtyInput.value) || 1;
                totalInput.value = (price * qty).toFixed(2);
                updateTotal();
            }

            if (e.target.matches("select[name='payment_method']")) {
                hiddenPaymentMethod.value = e.target.value;
            }
        });

        document.addEventListener("input", function(e) {
            if (e.target.matches(".accessory-qty") || e.target === serviceChargeInput) {
                const row = e.target.closest(".row");
                const price = parseFloat(row.querySelector(".accessory-price").value) || 0;
                const qty = parseInt(row.querySelector(".accessory-qty").value) || 1;
                row.querySelector(".accessory-row-total").value = (price * qty).toFixed(2);
                updateTotal();
            }
        });

        document.addEventListener("click", function(e) {
            if (e.target.closest(".remove-accessory")) {
                e.target.closest(".row").remove();
                updateTotal();
            }
        });

        serviceBtns.free.addEventListener("click", function() {
            paidServiceSection.style.display = 'none';
            hiddenServiceMethod.value = 'free';
            overallTotal.value = '0';
            hiddenTotalAmount.value = '0';
        });

        serviceBtns.paid.addEventListener("click", function() {
            paidServiceSection.style.display = 'block';
            hiddenServiceMethod.value = 'paid';
            updateTotal();
        });

        paymentYes.addEventListener("click", function() {
            paymentModes.style.display = 'block';
            paidAmountField.style.display = 'block';
        });

        paymentNo.addEventListener("click", function() {
            paymentModes.style.display = 'none';
            paidAmountField.style.display = 'none';
            hiddenPaymentMethod.value = '';
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const freeBtn = document.getElementById('freeServiceBtn');
        const paidBtn = document.getElementById('paidServiceBtn');
        const paidSection = document.getElementById('paidServiceSection');
        const serviceTypeInput = document.getElementById('hiddenServiceType');

        // When Free Service is clicked
        freeBtn.addEventListener('click', function() {
            serviceTypeInput.value = 'free';
            paidSection.style.display = 'none';
        });

        // When Paid Service is clicked
        paidBtn.addEventListener('click', function() {
            serviceTypeInput.value = 'paid';
            paidSection.style.display = 'block';
        });
    });
</script>
