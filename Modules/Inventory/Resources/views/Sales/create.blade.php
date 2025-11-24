<div class="modal fade" id="salesModal" tabindex="-1" role="dialog" aria-labelledby="salesModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="max-width: 1100px;">
        <div class="modal-content shadow-lg modal-advanced" style="border-radius: 24px; border: none;">
            <div class="modal-header justify-content-center modal-header-advanced">
                <h1 class="modal-title fs-3 fw-bold" id="staticBackdropLabel">
                    <i class="bi bi-cart-plus me-2"></i>
                    Create New Sale
                </h1>
            </div>
            <form action="{{ route('sales_store') }}" id="saleForm" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body modal-body-advanced">
                    <h3 class="mb-3 text-primary border-bottom pb-2 section-title">
                        <i class="bi bi-person me-2"></i>
                        Customer Details
                    </h3>
                    <div class="container-fluid">
                        <div class="row gy-4">
                            <div class="col-lg-4">
                                <label class="form-label12 fw-semibold">Customer Name</label>
                                <input type="text" class="form-control border-primary shadow-sm" id="customer_name"
                                    name="customer_name" placeholder="Enter customer name">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label12 fw-semibold">Contact Number</label>
                                <input type="text" class="form-control border-primary shadow-sm" name="contact"
                                    id="contact" placeholder="Enter mobile number">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label12 fw-semibold">Landline</label>
                                <input type="text" class="form-control border-primary shadow-sm" name="landline"
                                    id="landline" placeholder="Enter landline">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label12 fw-semibold">Email</label>
                                <input type="email" class="form-control border-primary shadow-sm" name="email"
                                    id="email" placeholder="Enter email">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label12 fw-semibold">Customer Type</label>
                                <select class="form-control border-primary shadow-sm" name="customer_type"
                                    id="customer_type">
                                    <option value="">Select type</option>
                                    <option value="wholesaler">Wholesaler</option>
                                    <option value="retailer">Retailer</option>
                                    <option value="customer">Customer</option>
                                </select>
                            </div>
                            <div class="col-lg-8">
                                <label class="form-label12 fw-semibold">Address</label>
                                <textarea name="address" class="form-control border-primary shadow-sm" rows="2" placeholder="Enter full address"></textarea>
                            </div>  
                        </div>
                    </div>

                    <h3 class="mt-5 mb-3 text-warning border-bottom pb-2 section-title">
                        <i class="bi bi-gear-wide-connected me-2"></i>
                        Machinery Sale
                    </h3>
                    <div class="container-fluid">
                        <div id="machineryContainer">
                            <!-- Machinery rows will be added here -->
                        </div>
                        <button type="button" id="addMachinery" class="btn btn-outline-warning mt-3">
                            <i class="bi bi-plus-circle"></i> Add Machinery
                        </button>

                        <div class="row mt-3">
                            <div class="col-md-3 offset-md-9">
                                <label class="form-label12 fw-semibold">Machinery Subtotal</label>
                                <input class="form-control border-warning shadow-sm" type="number" step="0.01"
                                    name="machinery_subtotal" id="machinery_subtotal" readonly>
                            </div>
                        </div>
                    </div>

                    <h3 class="mt-5 mb-3 text-success border-bottom pb-2 section-title">
                        <i class="bi bi-plug me-2"></i>
                        Accessories Sale
                    </h3>
                    <div class="container-fluid">
                        <div id="accessoriesContainer">
                            <!-- Accessories rows will be added here -->
                        </div>
                        <button type="button" id="addAccessory" class="btn btn-outline-success mt-3">
                            <i class="bi bi-plus-circle"></i> Add Accessory
                        </button>

                        <div class="row mt-3">
                            <div class="col-md-3 offset-md-9">
                                <label class="form-label12 fw-semibold">Accessories Subtotal</label>
                                <input class="form-control border-success shadow-sm" type="number" step="0.01"
                                    name="accessories_subtotal" id="accessories_subtotal" readonly>
                            </div>
                        </div>
                    </div>

                    <h3 class="mt-5 mb-3 text-info border-bottom pb-2 section-title">
                        <i class="bi bi-credit-card me-2"></i>
                        Payment Details
                    </h3>
                    <div class="container-fluid">
                        <div class="row gy-4">
                            <div class="col-lg-3">
                                <label class="form-label12 fw-semibold">Total Amount</label>
                                <input class="form-control border-info shadow-sm" type="number" step="0.01"
                                    name="total_amount" id="total_amount" readonly>
                            </div>
                            <div class="col-lg-3">
                                <label class="form-label12 fw-semibold">Amount Paid</label>
                                <input class="form-control border-info shadow-sm" type="number" step="0.01"
                                    name="paid_amount" id="paid_amount">
                            </div>
                            <div class="col-lg-3">
                                <label class="form-label12 fw-semibold">Balance Due</label>
                                <input class="form-control border-info shadow-sm" type="number" step="0.01"
                                    name="balance_due" id="balance_due" readonly>
                            </div>
                            <div class="col-lg-3">
                                <label class="form-label12 fw-semibold">Payment Method</label>
                                <select class="form-control border-info shadow-sm" name="payment_method"
                                    id="payment_method">
                                    <option value="">Select method</option>
                                    <option value="cash">Cash</option>
                                    <option value="cheque">Cheque</option>
                                    <option value="card">Credit/Debit Card</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                    <option value="online">Online Payment</option>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label12 fw-semibold">Payment Reference</label>
                                <input class="form-control border-info shadow-sm" type="text"
                                    name="payment_reference" placeholder="Cheque/Transaction number">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label12 fw-semibold">Status</label>
                                <select class="form-control border-info shadow-sm" name="status" id="status">
                                    <option value="pending">Pending</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                            <div class="col-lg-12">
                                <label class="form-label12 fw-semibold">Remarks</label>
                                <textarea name="remarks" class="form-control border-info shadow-sm" rows="2"
                                    placeholder="Any special instructions"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-start modal-footer-advanced">
                    <button type="submit" name="submit" id="btnSubmit"
                        class="btn btn-success px-5 py-2 fw-bold shadow-sm">
                        <i class="bi bi-save me-2"></i>Save Sale
                    </button>
                    <button type="button" data-dismiss="modal" class="btn btn-danger px-5 py-2 fw-bold shadow-sm">
                        <i class="bi bi-x-circle me-2"></i>Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<style>
    .modal-advanced {
        background: linear-gradient(135deg, #f8fafc 70%, #f0f8ff 100%);
        border-radius: 24px;
        border: none;
        box-shadow: 0 8px 40px 0 rgba(8, 164, 164, 0.15);
        overflow: hidden;
    }

    .modal-header-advanced {
        background: linear-gradient(90deg, #08A4A4 60%, #0E8388 100%);
        color: #fff;
        border-top-left-radius: 24px;
        border-top-right-radius: 24px;
        border-bottom: 2px solid #e0f7fa;
        box-shadow: 0 2px 8px 0 rgba(8, 164, 164, 0.08);
        padding-top: 1.5rem;
        padding-bottom: 1.5rem;
    }

    .modal-body-advanced {
        background: linear-gradient(120deg, #f8f9fa 80%, #f0f8ff 100%);
        padding: 2rem 2.5rem;
    }

    .modal-footer-advanced {
        background: #f1f1f1;
        border-bottom-left-radius: 24px;
        border-bottom-right-radius: 24px;
        border-top: 2px solid #e0f7fa;
        padding-top: 1.2rem;
        padding-bottom: 1.2rem;
    }

    .form-label12 {
        font-size: 1.05rem;
        color: #222;
        margin-bottom: 0.3rem;
        letter-spacing: 0.5px;
    }

    .form-control {
        border-radius: 0.7rem;
        font-size: 1rem;
        transition: box-shadow 0.2s, border-color 0.2s;
    }

    .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(8, 164, 164, 0.18);
        border-color: #08A4A4;
        background: #f0fdfa;
    }

    .modal-content {
        transition: box-shadow 0.3s;
    }

    .modal-content:hover {
        box-shadow: 0 12px 48px 0 rgba(8, 164, 164, 0.18);
    }

    .section-title {
        letter-spacing: 1px;
        font-size: 1.25rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-success,
    .btn-danger {
        border-radius: 0.7rem;
        font-size: 1.1rem;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 8px 0 rgba(8, 164, 164, 0.08);
        transition: background 0.2s, box-shadow 0.2s;
    }

    .btn-success:hover {
        background: linear-gradient(90deg, #08A4A4 60%, #0E8388 100%);
        color: #fff;
    }

    .btn-danger:hover {
        background: linear-gradient(90deg, #e53935 60%, #b71c1c 100%);
        color: #fff;
    }

    .item-row {
        background-color: rgba(255, 255, 255, 0.8);
        border-radius: 0.7rem;
        padding: 1rem;
        margin-bottom: 1rem;
        border: 1px solid #e0f7fa;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .remove-item {
        cursor: pointer;
        color: #ecede0;
        transition: color 0.2s;
    }

    .remove-item:hover {
        color: #eedede;
    }

    @media (max-width: 991.98px) {
        .modal-body-advanced {
            padding: 1rem 0.5rem;
        }

        .modal-dialog {
            max-width: 98vw !important;
        }
    }
</style>

<script>
    $(document).ready(function() {
        let accessoryIndex = 0;
        let machineryIndex = 0;

        // Function to calculate totals
        function calculateTotals() {
            let accessoriesTotal = 0;
            let machineryTotal = 0;

            // Calculate accessories subtotal
            $('.accessory-row').each(function() {
                const qty = parseFloat($(this).find('.accessory-quantity').val()) || 0;
                const price = parseFloat($(this).find('.accessory-price').val()) || 0;
                const total = qty * price;
                $(this).find('.accessory-total').val(total.toFixed(2));
                accessoriesTotal += total;
            });

            // Calculate machinery subtotal
            $('.machinery-row').each(function() {
                const qty = parseFloat($(this).find('.machinery-quantity').val()) || 0;
                const price = parseFloat($(this).find('.machinery-price').val()) || 0;
                const total = qty * price;
                $(this).find('.machinery-total').val(total.toFixed(2));
                machineryTotal += total;
            });

            // Update subtotals
            $('#accessories_subtotal').val(accessoriesTotal.toFixed(2));
            $('#machinery_subtotal').val(machineryTotal.toFixed(2));

            // Update grand total
            const grandTotal = accessoriesTotal + machineryTotal;
            $('#total_amount').val(grandTotal.toFixed(2));

            // Calculate balance due
            const paidAmount = parseFloat($('#paid_amount').val()) || 0;
            $('#balance_due').val((grandTotal - paidAmount).toFixed(2));
        }

        // Add accessory row
        $('#addAccessory').click(function() {
            accessoryIndex++;
            const row = `
        <div class="row gy-4 item-row accessory-row" id="accessory-row-${accessoryIndex}">
            <div class="col-lg-3">
                <label class="form-label12 fw-semibold">Accessory Name</label>
                <select class="form-control border-success shadow-sm accessory-name" name="accessories[${accessoryIndex}][id]">
                    <option value="">Select Accessory</option>
                    @foreach ($accessories as $accessory)
                        <option value="{{ $accessory->id }}" data-price="{{ $accessory->price }}">{{ $accessory->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2">
                <label class="form-label12 fw-semibold">Quantity</label>
                <input class="form-control border-success shadow-sm accessory-quantity" name="accessories[${accessoryIndex}][quantity]" type="number" value="1" min="1">
            </div>
            <div class="col-lg-2">
                <label class="form-label12 fw-semibold">Unit Price</label>
                <input class="form-control border-success shadow-sm accessory-price" name="accessories[${accessoryIndex}][price]" type="number" step="0.01" placeholder="Price">
            </div>
            <div class="col-lg-2">
                <label class="form-label12 fw-semibold">Total</label>
                <input class="form-control border-success shadow-sm accessory-total" name="accessories[${accessoryIndex}][total]" type="number" step="0.01" readonly>
            </div>
            <div class="col-lg-2">
                <label class="form-label12 fw-semibold">Warranty</label>
                <select class="form-control border-success shadow-sm" name="accessories[${accessoryIndex}][warranty]">
                    <option value="none">No Warranty</option>
                    <option value="1m">1 Month</option>
                    <option value="3m">3 Months</option>
                    <option value="6m">6 Months</option>
                    <option value="1y">1 Year</option>
                </select>
            </div>
            <div class="col-lg-1 d-flex align-items-end">
                <button type="button" class="btn btn-sm btn-danger remove-item" data-row="accessory-row-${accessoryIndex}">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>`;
            $('#accessoriesContainer').append(row);

            // Set price when accessory is selected
            $(`#accessory-row-${accessoryIndex} .accessory-name`).change(function() {
                const price = $(this).find(':selected').data('price');
                $(this).closest('.accessory-row').find('.accessory-price').val(price).trigger(
                    'input');
            });
        });

        // Add machinery row
        $('#addMachinery').click(function() {
            machineryIndex++;
            const row = `
        <div class="row gy-4 item-row machinery-row" id="machinery-row-${machineryIndex}">
            <div class="col-lg-3">
                <label class="form-label12 fw-semibold">Machinery Name</label>
                <select class="form-control border-warning shadow-sm machinery-name" name="machineries[${machineryIndex}][id]">
                    <option value="">Select Machinery</option>
                    @foreach ($machineries as $machinery)
                        <option value="{{ $machinery->id }}" data-price="{{ $machinery->price }}">{{ $machinery->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2">
                <label class="form-label12 fw-semibold">Quantity</label>
                <input class="form-control border-warning shadow-sm machinery-quantity" name="machineries[${machineryIndex}][quantity]" type="number" value="1" min="1">
            </div>
            <div class="col-lg-2">
                <label class="form-label12 fw-semibold">Unit Price</label>
                <input class="form-control border-warning shadow-sm machinery-price" name="machineries[${machineryIndex}][price]" type="number" step="0.01" placeholder="Price">
            </div>
            <div class="col-lg-2">
                <label class="form-label12 fw-semibold">Total</label>
                <input class="form-control border-warning shadow-sm machinery-total" name="machineries[${machineryIndex}][total]" type="number" step="0.01" readonly>
            </div>
            <div class="col-lg-2">
                <label class="form-label12 fw-semibold">Warranty</label>
                <select class="form-control border-warning shadow-sm" name="machineries[${machineryIndex}][warranty]">
                    <option value="none">No Warranty</option>
                    <option value="3m">3 Months</option>
                    <option value="6m">6 Months</option>
                    <option value="1y">1 Year</option>
                    <option value="2y">2 Years</option>
                </select>
            </div>
            <div class="col-lg-1 d-flex align-items-end">
                <button type="button" class="btn btn-sm btn-danger remove-item" data-row="machinery-row-${machineryIndex}">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>`;
            $('#machineryContainer').append(row);

            // Set price when machinery is selected
            $(`#machinery-row-${machineryIndex} .machinery-name`).change(function() {
                const price = $(this).find(':selected').data('price');
                $(this).closest('.machinery-row').find('.machinery-price').val(price).trigger(
                    'input');
            });
        });

        // Remove row
        $(document).on('click', '.remove-item', function() {
            const rowId = $(this).data('row');
            $(`#${rowId}`).remove();
            calculateTotals();
        });

        // Calculate totals when quantity or price changes
        $(document).on('input',
            '.accessory-quantity, .accessory-price, .machinery-quantity, .machinery-price, #paid_amount',
            function() {
                calculateTotals();
            });

        // Add first row for each section
        $('#addAccessory').trigger('click');
        $('#addMachinery').trigger('click');
    });
</script>
