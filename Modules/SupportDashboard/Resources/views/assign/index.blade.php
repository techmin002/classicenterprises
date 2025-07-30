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
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>ID</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">User Name</th>
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
                                            @php $modalId = $value->id; @endphp
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $value->id }}</td>
                                                <td class="text-center">{{ $value->customer->lead->name }}</td>
                                                <td class="text-center">{{ $value->customer->lead->user_name }}</td>
                                                <td class="text-center">{{ $value->customer->lead->mobile }}</td>
                                                <td class="text-center">
                                                    @foreach ($value->customer->products as $product)
                                                        {{ $product->product['name'] }}
                                                    @endforeach
                                                </td>
                                                <td class="text-center">{{ $value->customer->lead->address }}</td>
                                                <td class="text-center">{{ ucfirst($value->assign_to) }}</td>
                                                <td class="text-center">{{ $value->created_at }}</td>
                                                <td>
                                                    @can('edit_ticket')
                                                        <button type="button" class="btn btn-success btn-xs w-75"
                                                            data-toggle="modal"
                                                            data-target="#exampleModal{{ $modalId }}">Action</button>
                                                    @endcan

                                                    <div class="modal fade" id="exampleModal{{ $modalId }}"
                                                        tabindex="-1" role="dialog">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content border-0 shadow">
                                                                <div class="modal-header bg-primary text-white">
                                                                    <div>
                                                                        <h5 class="modal-title mb-0">Take Action</h5>
                                                                        <small>Customer:
                                                                            <strong>{{ ucfirst($value->customer->lead->name) }}</strong></small>
                                                                    </div>
                                                                    <button type="button" class="close text-white"
                                                                        data-dismiss="modal">&times;</button>
                                                                </div>
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <form
                                                                            action="{{ route('supportdashboard-task.completestore', $modalId) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="customer_id"
                                                                                value="{{ $value->customer_id }}">
                                                                            <input type="hidden" name="total_amount"
                                                                                id="hiddenTotalAmount{{ $modalId }}">
                                                                            <input type="hidden" name="service_method"
                                                                                id="hiddenServiceMethod{{ $modalId }}">
                                                                            <input type="hidden" name="payment_method"
                                                                                id="hiddenPaymentMethod{{ $modalId }}">
                                                                            <input type="hidden" name="service_type"
                                                                                id="hiddenServiceType{{ $modalId }}"
                                                                                value="free">

                                                                            <button type="button"
                                                                                id="freeServiceBtn{{ $modalId }}"
                                                                                class="btn btn-outline-primary btn-sm">Free
                                                                                Service</button>
                                                                            <button type="button"
                                                                                id="paidServiceBtn{{ $modalId }}"
                                                                                class="btn btn-outline-success btn-sm ml-2">Paid
                                                                                Service</button>

                                                                            <div id="paidServiceSection{{ $modalId }}"
                                                                                style="display:none;">
                                                                                <div class="form-group mt-3">
                                                                                    <label>Service Charge</label>
                                                                                    <input type="number"
                                                                                        id="serviceCharge{{ $modalId }}"
                                                                                        name="service_charge"
                                                                                        class="form-control" min="0">
                                                                                </div>
                                                                                {{-- <div class="border p-2 rounded">
    <strong>Free Accessories:</strong>
    <hr class="my-1">
    @if (isset($amcMap[$value->customer_id]) && count($amcMap[$value->customer_id]))
        @foreach ($amcMap[$value->customer_id] as $accessory)
            <span class="badge badge-info">
                {{ $accessory['name'] }} ({{ $accessory['quantity'] }})
            </span>
        @endforeach
    @else
        <span class="text-muted">No Accessories</span>
    @endif
</div> --}}


                                                                                <div class="form-group">
                                                                                    <label>Accessories</label>
                                                                                    <div
                                                                                        id="accessoryContainer{{ $modalId }}">
                                                                                    </div>
                                                                                    <button type="button"
                                                                                        id="addAccessory{{ $modalId }}"
                                                                                        class="badge badge-primary mt-2">Add
                                                                                        Accessory</button>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label>Overall Total</label>
                                                                                    <input type="text"
                                                                                        id="overallTotal{{ $modalId }}"
                                                                                        class="form-control" readonly>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label>Payment Taken?</label><br>
                                                                                    <input type="radio"
                                                                                        name="paymentTaken{{ $modalId }}"
                                                                                        id="paymentYes{{ $modalId }}"
                                                                                        value="yes"> Yes
                                                                                    <input type="radio"
                                                                                        name="paymentTaken{{ $modalId }}"
                                                                                        id="paymentNo{{ $modalId }}"
                                                                                        value="no" checked> No
                                                                                </div>
                                                                                <div class="form-group"
                                                                                    id="paidAmountField{{ $modalId }}"
                                                                                    style="display:none;">
                                                                                    <label>Paid Amount</label>
                                                                                    <input type="number"
                                                                                        name="paid_amount"
                                                                                        class="form-control"
                                                                                        min="0">
                                                                                </div>
                                                                                <div class="form-group"
                                                                                    id="paymentModes{{ $modalId }}"
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
                                                                                <label>Message / Remark</label>
                                                                                <textarea class="form-control" name="message" required></textarea>
                                                                            </div>
                                                                            <div class="modal-footer bg-light">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-dismiss="modal">Close</button>
                                                                                <button type="submit"
                                                                                    class="btn btn-success">Save</button>
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
                                                                        <small>Customer:
                                                                            <strong>{{ ucfirst($value->customer->lead->name) }}</strong></small>
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
                                                    <script>
                                                        document.addEventListener("DOMContentLoaded", function() {
                                                            let accessoryIndex = 0;
                                                            const modalId = {{ $modalId }};

                                                            const accessoryContainer = document.getElementById(`accessoryContainer${modalId}`);
                                                            const overallTotal = document.getElementById(`overallTotal${modalId}`);
                                                            const serviceChargeInput = document.getElementById(`serviceCharge${modalId}`);
                                                            const paidServiceSection = document.getElementById(`paidServiceSection${modalId}`);
                                                            const paymentModes = document.getElementById(`paymentModes${modalId}`);
                                                            const paidAmountField = document.getElementById(`paidAmountField${modalId}`);

                                                            const hiddenTotalAmount = document.getElementById(`hiddenTotalAmount${modalId}`);
                                                            const hiddenServiceMethod = document.getElementById(`hiddenServiceMethod${modalId}`);
                                                            const hiddenPaymentMethod = document.getElementById(`hiddenPaymentMethod${modalId}`);
                                                            const hiddenServiceType = document.getElementById(`hiddenServiceType${modalId}`);

                                                            const addAccessoryBtn = document.getElementById(`addAccessory${modalId}`);
                                                            const paymentYes = document.getElementById(`paymentYes${modalId}`);
                                                            const paymentNo = document.getElementById(`paymentNo${modalId}`);

                                                            const freeBtn = document.getElementById(`freeServiceBtn${modalId}`);
                                                            const paidBtn = document.getElementById(`paidServiceBtn${modalId}`);

                                                            const accessoryList = @json($accessories);
                                                            const freeAccessories = @json($amcMap[$value->customer_id] ?? []);

                                                            function updateTotal() {
                                                                let total = 0;
                                                                accessoryContainer.querySelectorAll(".accessory-row-total").forEach(input => {
                                                                    total += parseFloat(input.value) || 0;
                                                                });
                                                                total += parseFloat(serviceChargeInput.value) || 0;
                                                                overallTotal.value = total.toFixed(2);
                                                                hiddenTotalAmount.value = total.toFixed(2);
                                                            }

                                                            function createAccessoryRow(index) {
                                                                const options = accessoryList.map(item =>
                                                                    `<option value="${item.name}" data-id="${item.id}" data-price="${item.sales_price}">${item.name}</option>`

                                                                ).join('');
                                                                const row = document.createElement("div");
                                                                row.className = "row mb-2 accessory-row";
                                                                row.innerHTML = `
               <div class="col-md-4">
            <select name="accessories[${index}][name]" class="form-control accessory-name">
                <option value="">Select Accessory</option>
                ${options}
            </select>
            <input type="hidden" name="accessories[${index}][accessory_id]" class="accessory-hidden-id" />
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

                                                            document.getElementById(`exampleModal${modalId}`).addEventListener("change", function(e) {
                                                                if (e.target.matches(".accessory-name")) {
                                                                    const row = e.target.closest(".row");

                                                                    const selectedOption = e.target.selectedOptions[0];
                                                                    const selectedName = selectedOption.value;
                                                                    const selectedId = selectedOption.getAttribute("data-id");
                                                                    let price = parseFloat(selectedOption.getAttribute("data-price")) || 0;

                                                                    // Update hidden accessory_id
                                                                    const hiddenInput = e.target.parentElement.querySelector(".accessory-hidden-id");
                                                                    if (hiddenInput) hiddenInput.value = selectedId;


                                                                    const qtyInput = row.querySelector(".accessory-qty");
                                                                    const totalInput = row.querySelector(".accessory-row-total");
                                                                    const qty = parseInt(qtyInput.value) || 1;

                                                                    let total = 0;
                                                                    if (freeAccessories[selectedName]) {
                                                                        let freeQty = freeAccessories[selectedName];
                                                                        let paidQty = Math.max(0, qty - freeQty);
                                                                        total = paidQty * price;
                                                                    } else {
                                                                        total = qty * price;
                                                                    }

                                                                    row.querySelector(".accessory-price").value = price;
                                                                    totalInput.value = total.toFixed(2);
                                                                    updateTotal();
                                                                }

                                                            });

                                                            document.getElementById(`exampleModal${modalId}`).addEventListener("input", function(e) {
                                                                if (e.target.matches(".accessory-qty") || e.target === serviceChargeInput) {
                                                                    const row = e.target.closest(".row");
                                                                    const selectedName = row.querySelector(".accessory-name").value;
                                                                    const price = parseFloat(row.querySelector(".accessory-price").value) || 0;
                                                                    const qty = parseInt(row.querySelector(".accessory-qty").value) || 1;

                                                                    let total = 0;
                                                                    if (freeAccessories[selectedName]) {
                                                                        let freeQty = freeAccessories[selectedName];
                                                                        let paidQty = Math.max(0, qty - freeQty);
                                                                        total = paidQty * price;
                                                                    } else {
                                                                        total = qty * price;
                                                                    }

                                                                    row.querySelector(".accessory-row-total").value = total.toFixed(2);
                                                                    updateTotal();
                                                                }

                                                            });

                                                            document.getElementById(`exampleModal${modalId}`).addEventListener("click", function(e) {
                                                                if (e.target.closest(".remove-accessory")) {
                                                                    e.target.closest(".row").remove();
                                                                    updateTotal();
                                                                }
                                                            });

                                                            freeBtn.addEventListener("click", function() {
                                                                paidServiceSection.style.display = 'none';
                                                                hiddenServiceMethod.value = 'free';
                                                                hiddenServiceType.value = 'free';
                                                                overallTotal.value = '0';
                                                                hiddenTotalAmount.value = '0';
                                                            });

                                                            paidBtn.addEventListener("click", function() {
                                                                paidServiceSection.style.display = 'block';
                                                                hiddenServiceMethod.value = 'paid';
                                                                hiddenServiceType.value = 'paid';
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

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>S.N</th>
                                            <th>ID</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">User Name</th>
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
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
