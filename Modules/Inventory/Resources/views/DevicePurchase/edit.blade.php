@extends('setting::layouts.master')

@section('title', 'Device Purchases')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Device Purchases Edit</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Device Purchases Edit</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Device Purchases</li>
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
                            <form action="{{ route('device_purchases_update', $devicePurchase->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="container-fluid">
                                    <div class="row gy-4">
                                        <div class="col-lg-4">
                                            <label class="form-label12 fw-semibold">Supplier</label>
                                            <select class="form-control border-primary shadow-sm" name="supplier_id">
                                                <option value="">Select Supplier</option>
                                                @foreach ($suppliers as $supplier)
                                                    <option value="{{ $supplier->id }}"
                                                        {{ $supplier->id == $devicePurchase->supplier_id ? 'selected' : '' }}>
                                                        {{ $supplier->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-label12 fw-semibold">Branch ID</label>
                                            <select class="form-control border-primary shadow-sm" name="branch_id">
                                                <option value="">Select Branch</option>
                                                @foreach ($branches as $branch)
                                                    <option value="{{ $branch->id }}"
                                                        {{ $branch->id == $devicePurchase->branch_id ? 'selected' : '' }}>
                                                        {{ $branch->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <input type="hidden" name="created_by" value="{{ auth()->user()->id }}">
                                        <div class="col-lg-4">
                                            <label class="form-label12 fw-semibold">Bill No.</label>
                                            <input class="form-control border-primary shadow-sm"
                                                placeholder="Enter bill number" type="text" name="bill_no" id="bill_no"
                                                value="{{ $devicePurchase->bill_no }}">
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-label12 fw-semibold">Total Amount</label>
                                            <input class="form-control border-primary shadow-sm" type="number"
                                                step="0.01" name="total_amount" id="total_amount"
                                                value="{{ $devicePurchase->total_amount }}"
                                                placeholder="Enter total amount">
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-label12 fw-semibold">Receipt</label>
                                            <input class="form-control border-primary shadow-sm" type="file"
                                                name="receipt" id="receipt" accept=".jpg, .jpeg, .png, .pdf">

                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-label12 fw-semibold">Status</label>
                                            <select class="form-control border-primary shadow-sm" name="status">
                                                <option value="0"
                                                    {{ $devicePurchase->status == 0 ? 'selected' : '' }}>
                                                    Pending</option>
                                                <option value="1"
                                                    {{ $devicePurchase->status == 1 ? 'selected' : '' }}>
                                                    Completed</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-12">
                                            <label class="form-label12 fw-semibold">Description</label>
                                            <textarea class="form-control border-primary shadow-sm" name="description" id="description" rows="3">{{ $devicePurchase->description }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <h3 class="mt-5 mb-3 text-success border-bottom pb-2 section-title">
                                    <i class="bi bi-plug me-2"></i>
                                    Accessories Purchase
                                </h3>
                                <div class="container-fluid">
                                    @foreach ($purchaseAccessories as $acc)
                                        <div class="row gy-4 item-row accessory-row"
                                            id="accessory-row-{{ $acc->id }}">
                                            <div class="col-lg-3">
                                                <label class="form-label12 fw-semibold">Accessory Name</label>
                                                <select class="form-control border-success shadow-sm accessory-name"
                                                    name="accessories[{{ $acc->id }}][id]">
                                                    <option value="">Select Accessory</option>
                                                    @foreach ($accessories as $accessory)
                                                        <option value="{{ $accessory->id }}"
                                                            data-price="{{ $accessory->price }}"
                                                            @if ($accessory->id == $acc->accessory_id) selected @endif>
                                                            {{ $accessory->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-2">
                                                <label class="form-label12 fw-semibold">Quantity</label>
                                                <input class="form-control border-success shadow-sm accessory-quantity"
                                                    name="accessories[{{ $acc->id }}][quantity]" type="number"
                                                    value="{{ $acc['quantity'] }}" min="1">
                                            </div>
                                            <div class="col-lg-2">
                                                <label class="form-label12 fw-semibold">Unit Price</label>
                                                <input class="form-control border-success shadow-sm accessory-price"
                                                    name="accessories[{{ $acc->id }}][price]"
                                                    value="{{ $acc['unit_price'] }}" type="number" step="0.01"
                                                    placeholder="Price">
                                            </div>
                                            <div class="col-lg-2">
                                                <label class="form-label12 fw-semibold">Total</label>
                                                <input class="form-control border-success shadow-sm accessory-total"
                                                    name="accessories[{{ $acc->id }}][total]" type="number"
                                                    value="{{ $acc['total'] }}" step="0.01" readonly>
                                            </div>
                                            <div class="col-lg-1">
                                                <label class="form-label12 fw-semibold">Branch</label>
                                                <select class="form-control border-success shadow-sm"
                                                    name="accessories[{{ $acc->id }}][branch_id]">
                                                    <option value="">Select Branch</option>
                                                    @foreach ($branches as $branch)
                                                        <option value="{{ $branch->id }}"
                                                            {{ $branch->id == $acc->branch_id ? 'selected' : '' }}>
                                                            {{ $branch->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-1 d-flex align-items-end">
                                                <button type="button" class="btn btn-sm btn-danger remove-item"
                                                    data-row="accessory-row-{{ $acc->id }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div id="accessoriesContainer">

                                    </div>
                                    <button type="button" id="addAccessory" class="btn btn-outline-success mt-3">
                                        <i class="bi bi-plus-circle"></i> Add Accessory
                                    </button>

                                    <div class="row mt-3">
                                        <div class="col-md-3 offset-md-9">
                                            <label class="form-label12 fw-semibold">Accessories Subtotal</label>
                                            <input class="form-control border-success shadow-sm" type="number"
                                                step="0.01" name="accessories_subtotal" id="accessories_subtotal"
                                                readonly>
                                        </div>
                                    </div>
                                </div>

                                <h3 class="mt-5 mb-3 text-warning border-bottom pb-2 section-title">
                                    <i class="bi bi-gear-wide-connected me-2"></i>
                                    Machinery Purchase
                                </h3>
                                <div class="container-fluid">
                                    <div id="machineryContainer">
                                        @foreach ($purchaseMachineries as $mach)
                                            <div class="row gy-4 item-row machinery-row"
                                                id="machinery-row-{{ $mach->id }}">
                                                <div class="col-lg-3">
                                                    <label class="form-label12 fw-semibold">Machinery Name</label>
                                                    <select class="form-control border-warning shadow-sm machinery-name"
                                                        name="machineries[{{ $mach->id }}][id]">
                                                        <option value="">Select Machinery</option>
                                                        @foreach ($machineries as $machinery)
                                                            <option value="{{ $machinery->id }}"
                                                                data-price="{{ $machinery->price }}"
                                                                {{ $machinery->id == $mach->machinery_id ? 'selected' : '' }}>
                                                                {{ $machinery->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="form-label12 fw-semibold">Quantity</label>
                                                    <input class="form-control border-warning shadow-sm machinery-quantity"
                                                        name="machineries[{{ $mach->id }}][quantity]" type="number"
                                                        value="{{ $mach['quantity'] }}" min="1">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="form-label12 fw-semibold">Unit Price</label>
                                                    <input class="form-control border-warning shadow-sm machinery-price"
                                                        name="machineries[{{ $mach->id }}][price]" type="number"
                                                        value="{{ $mach['unit_price'] }}" step="0.01"
                                                        placeholder="Price">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="form-label12 fw-semibold">Total</label>
                                                    <input class="form-control border-warning shadow-sm machinery-total"
                                                        name="machineries[{{ $mach->id }}][total]" type="number"
                                                        value="{{ $mach['total'] }}" step="0.01" readonly>
                                                </div>
                                                <div class="col-lg-1">
                                                    <label class="form-label12 fw-semibold">Branch</label>
                                                    <select class="form-control border-warning shadow-sm"
                                                        name="machineries[{{ $mach->id }}][branch_id]">
                                                        <option value="">Select Branch</option>
                                                        @foreach ($branches as $branch)
                                                            <option value="{{ $branch->id }}"
                                                                {{ $branch->id == $mach->branch_id ? 'selected' : '' }}>
                                                                {{ $branch->name }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                                <div class="col-lg-1 d-flex align-items-end">
                                                    <button type="button" class="btn btn-sm btn-danger remove-item"
                                                        data-row="machinery-row-{{ $mach->id }}">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </div>`;
                                        @endforeach
                                    </div>
                                    <button type="button" id="addMachinery" class="btn btn-outline-warning mt-3">
                                        <i class="bi bi-plus-circle"></i> Add Machinery
                                    </button>

                                    <div class="row mt-3">
                                        <div class="col-md-3 offset-md-9">
                                            <label class="form-label12 fw-semibold">Machinery Subtotal</label>
                                            <input class="form-control border-warning shadow-sm" type="number"
                                                step="0.01" name="machinery_subtotal" id="machinery_subtotal"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer justify-content-start modal-footer-advanced">
                            <button type="submit" name="submit" id="btnSubmit"
                                class="btn btn-success px-5 py-2 fw-bold shadow-sm">
                                <i class="bi bi-save me-2"></i>Save Device Purchase
                            </button>
                            <button type="button" data-dismiss="modal"
                                class="btn btn-danger px-5 py-2 fw-bold shadow-sm">
                                <i class="bi bi-x-circle me-2"></i>Cancel
                            </button>
                        </div>
                        </form>
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
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@endsection

<!-- Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<style>
    .modal-advanced {
        background: linear-gradient(135deg, #f8fafc 70%, #e0f7fa 100%);
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
        background: linear-gradient(120deg, #f8f9fa 80%, #e0f7fa 100%);
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
            <div class="col-lg-1">
                <label class="form-label12 fw-semibold">Branch</label>
                <select class="form-control border-success shadow-sm" name="accessories[${accessoryIndex}][branch_id]">
                    <option value="">Select Branch</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                    @endforeach
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
            <div class="col-lg-1">
                <label class="form-label12 fw-semibold">Branch</label>
                <select class="form-control border-warning shadow-sm" name="machineries[${machineryIndex}][branch_id]">
                    <option value="">Select Branch</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                    @endforeach
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
        $(document).on('input', '.accessory-quantity, .accessory-price, .machinery-quantity, .machinery-price',
            function() {
                calculateTotals();
            });

        // Add first row for each section
        $('#addAccessory').trigger('click');
        $('#addMachinery').trigger('click');
    });
</script>
