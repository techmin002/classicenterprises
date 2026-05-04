<style>
.form-label12 {
    font-size: 1rem;
    color: #212529 !important; /* FIX invisible text */
    margin-bottom: 4px;
    display: block;
    font-weight: 600;
}

.modal-body {
    background: #f8fafc;
}

.form-control {
    border-radius: 8px;
    border: 1px solid #ced4da;
}

.form-control::placeholder {
    color: #999 !important; /* FIX placeholder invisible */
}

.pre-row {
    background: #ffffff;
    border: 1px solid #e3e6ea;
    padding: 12px;
    border-radius: 10px;
}
</style>
<div class="modal fade" id="preSaleModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered" style="max-width: 1100px;">
        <div class="modal-content shadow-lg" style="border-radius: 20px; border: none;">

            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title fw-bold">
                    <i class="bi bi-calendar-check me-2"></i> Create Pre Booking
                </h4>
            </div>

            <form action="{{ route('pre-sales.store') }}" method="POST">
                @csrf

                <div class="modal-body">

                    <!-- ================= CUSTOMER ================= -->
                    <h5 class="text-primary border-bottom pb-2 mb-3">
                        <i class="bi bi-person"></i> Customer Details
                    </h5>

                    <div class="row gy-3">

    <div class="col-md-4">
        <label class="form-label12">Customer Name</label>
        <input type="text" name="customer_name" class="form-control" placeholder="Enter name" required>
    </div>

    <div class="col-md-4">
        <label class="form-label12">Contact</label>
        <input type="text" name="contact" class="form-control" placeholder="Mobile number">
    </div>

    {{-- <div class="col-md-4">
        <label class="form-label12">Landline</label>
        <input type="text" name="landline" class="form-control" placeholder="Landline">
    </div> --}}

    <div class="col-md-4">
        <label class="form-label12">Email</label>
        <input type="email" name="email" class="form-control" placeholder="Email">
    </div>

    {{-- <div class="col-md-4">
        <label class="form-label12">Customer Type</label>
        <select name="customer_type" class="form-control">
            <option value="">Select Type</option>
            <option value="wholesaler">Wholesaler</option>
            <option value="retailer">Retailer</option>
            <option value="customer">Customer</option>
        </select>
    </div> --}}

    <div class="col-md-12">
        <label class="form-label12">Address</label>
        <textarea name="address" class="form-control" rows="2" placeholder="Full address"></textarea>
    </div>

</div>

                    <!-- ================= MACHINERY ================= -->
                    <h5 class="text-warning mt-4 border-bottom pb-2">
                        <i class="bi bi-gear"></i> Machinery Booking
                    </h5>

                    <div id="preMachineryContainer"></div>

                    <button type="button" id="addPreMachinery" class="btn btn-outline-warning btn-sm mt-2">
                        <i class="bi bi-plus-circle"></i> Add Machinery
                    </button>

                    <!-- ================= ACCESSORY ================= -->
                    <h5 class="text-success mt-4 border-bottom pb-2">
                        <i class="bi bi-plug"></i> Accessories Booking
                    </h5>

                    <div id="preAccessoryContainer"></div>

                    <button type="button" id="addPreAccessory" class="btn btn-outline-success btn-sm mt-2">
                        <i class="bi bi-plus-circle"></i> Add Accessory
                    </button>

                    <!-- ================= PAYMENT ================= -->
                    <h5 class="text-info mt-4 border-bottom pb-2">
                        <i class="bi bi-credit-card"></i> Payment Details
                    </h5>

                    <div class="row">
                        <div class="col-md-4">
                            <label>Total Amount</label>
                            <input type="number" name="total_amount" id="pre_total" class="form-control shadow-sm"
                                readonly>
                        </div>

                        <div class="col-md-4">
                            <label>Advance Paid</label>
                            <input type="number" name="paid_amount" id="pre_paid" value="0"
                                class="form-control shadow-sm">
                        </div>

                        <div class="col-md-4">
                            <label>Balance Due</label>
                            <input type="number" name="balance_due" id="pre_balance" class="form-control shadow-sm"
                                readonly>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-success px-4">
                        <i class="bi bi-save"></i> Save Booking
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>

            </form>
        </div>
    </div>
</div>
<script>
    let accIndex = 0;
    let macIndex = 0;

    // Calculate total
    function calculatePreTotal() {
        let total = 0;

        $('.pre-row').each(function() {
            let qty = parseFloat($(this).find('.qty').val()) || 0;
            let price = parseFloat($(this).find('.price').val()) || 0;
            let t = qty * price;

            $(this).find('.total').val(t.toFixed(2));
            total += t;
        });

        $('#pre_total').val(total.toFixed(2));

        let paid = parseFloat($('#pre_paid').val()) || 0;
        $('#pre_balance').val((total - paid).toFixed(2));
    }

    // ================= ADD ACCESSORY =================
    $('#addPreAccessory').click(function() {
        accIndex++;

        $('#preAccessoryContainer').append(`
    <div class="row pre-row mb-2 align-items-end border p-2 rounded">
        <div class="col-md-4">
            <label>Accessory</label>
            <select name="accessories[${accIndex}][id]" class="form-control product">
                <option value="">Select</option>
                @foreach ($accessories as $a)
                <option value="{{ $a->id }}" data-price="{{ $a->price }}">{{ $a->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <label>Qty</label>
            <input type="number" name="accessories[${accIndex}][quantity]" class="form-control qty" value="1">
        </div>

        <div class="col-md-2">
            <label>Price</label>
            <input type="number" name="accessories[${accIndex}][price]" class="form-control price">
        </div>

        <div class="col-md-2">
            <label>Total</label>
            <input type="number" name="accessories[${accIndex}][total]" class="form-control total" readonly>
        </div>

        <div class="col-md-2">
            <button type="button" class="btn btn-danger btn-sm remove-row">X</button>
        </div>
    </div>
    `);
    });

    // ================= ADD MACHINERY =================
    $('#addPreMachinery').click(function() {
        macIndex++;

        $('#preMachineryContainer').append(`
    <div class="row pre-row mb-2 align-items-end border p-2 rounded">
        <div class="col-md-4">
            <label>Machinery</label>
            <select name="machineries[${macIndex}][id]" class="form-control product">
                <option value="">Select</option>
                @foreach ($machineries as $m)
                <option value="{{ $m->id }}" data-price="{{ $m->price }}">{{ $m->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <label>Qty</label>
            <input type="number" name="machineries[${macIndex}][quantity]" class="form-control qty" value="1">
        </div>

        <div class="col-md-2">
            <label>Price</label>
            <input type="number" name="machineries[${macIndex}][price]" class="form-control price">
        </div>

        <div class="col-md-2">
            <label>Total</label>
            <input type="number" name="machineries[${macIndex}][total]" class="form-control total" readonly>
        </div>

        <div class="col-md-2">
            <button type="button" class="btn btn-danger btn-sm remove-row">X</button>
        </div>
    </div>
    `);
    });

    // Auto price fill
    $(document).on('change', '.product', function() {
        let price = $(this).find(':selected').data('price');
        $(this).closest('.pre-row').find('.price').val(price).trigger('input');
    });

    // Remove row
    $(document).on('click', '.remove-row', function() {
        $(this).closest('.pre-row').remove();
        calculatePreTotal();
    });

    // Recalculate
    $(document).on('input', '.qty, .price, #pre_paid', function() {
        calculatePreTotal();
    });

    // Add default rows
    $('#addPreAccessory').click();
    $('#addPreMachinery').click();
</script>
