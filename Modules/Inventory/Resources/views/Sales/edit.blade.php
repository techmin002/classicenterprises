@extends('setting::layouts.master')

@section('title', 'Edit Sale')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('sales.index') }}">Sales</a></li>
        <li class="breadcrumb-item active">Edit Sale</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Sale #{{ $sale->invoice_number }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('sales.index') }}">Sales</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow">
                            <div class="card-header bg-info text-white">
                                <h3 class="card-title">Edit Sale Details</h3>
                            </div>
                            <form action="{{ route('sales.update', $sale->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="card-body">
                                    <h3 class="mb-3 text-primary border-bottom pb-2 section-title">
                                        <i class="bi bi-person me-2"></i>
                                        Customer Details
                                    </h3>
                                    <div class="container-fluid">
                                        <div class="row gy-4">
                                            <div class="col-lg-4">
                                                <label class="form-label12 fw-semibold">Customer Name</label>
                                                <input type="text" class="form-control border-primary shadow-sm" 
                                                    name="customer_name" value="{{ $sale->customer_name }}" required>
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="form-label12 fw-semibold">Contact Number</label>
                                                <input type="text" class="form-control border-primary shadow-sm" 
                                                    name="contact" value="{{ $sale->contact }}" required>
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="form-label12 fw-semibold">Email</label>
                                                <input type="email" class="form-control border-primary shadow-sm" 
                                                    name="email" value="{{ $sale->email }}">
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="form-label12 fw-semibold">Customer Type</label>
                                                <select class="form-control border-primary shadow-sm" name="customer_type" required>
                                                    <option value="wholesaler" {{ $sale->customer_type == 'wholesaler' ? 'selected' : '' }}>Wholesaler</option>
                                                    <option value="retailer" {{ $sale->customer_type == 'retailer' ? 'selected' : '' }}>Retailer</option>
                                                    <option value="customer" {{ $sale->customer_type == 'customer' ? 'selected' : '' }}>Customer</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-8">
                                                <label class="form-label12 fw-semibold">Address</label>
                                                <textarea name="address" class="form-control border-primary shadow-sm" rows="2">{{ $sale->address }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <h3 class="mt-5 mb-3 text-warning border-bottom pb-2 section-title">
                                        <i class="bi bi-gear-wide-connected me-2"></i>
                                        Machinery Sale
                                    </h3>
                                    <div class="container-fluid">
                                        @foreach($sale->saleMachineries as $index => $machinery)
                                        <div class="row gy-4 item-row machinery-row" id="machinery-row-{{ $machinery->id }}">
                                            <div class="col-lg-3">
                                                <label class="form-label12 fw-semibold">Machinery Name</label>
                                                <select class="form-control border-warning shadow-sm machinery-name" 
                                                    name="machineries[{{ $machinery->id }}][id]" required>
                                                    <option value="">Select Machinery</option>
                                                    @foreach($machineries as $mach)
                                                        <option value="{{ $mach->id }}" 
                                                            data-price="{{ $mach->price }}"
                                                            {{ $mach->id == $machinery->machinery_id ? 'selected' : '' }}>
                                                            {{ $mach->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-2">
                                                <label class="form-label12 fw-semibold">Quantity</label>
                                                <input class="form-control border-warning shadow-sm machinery-quantity" 
                                                    name="machineries[{{ $machinery->id }}][quantity]" 
                                                    value="{{ $machinery->quantity }}" type="number" min="1" required>
                                            </div>
                                            <div class="col-lg-2">
                                                <label class="form-label12 fw-semibold">Unit Price</label>
                                                <input class="form-control border-warning shadow-sm machinery-price" 
                                                    name="machineries[{{ $machinery->id }}][price]" 
                                                    value="{{ $machinery->price }}" type="number" step="0.01" required>
                                            </div>
                                            <div class="col-lg-2">
                                                <label class="form-label12 fw-semibold">Total</label>
                                                <input class="form-control border-warning shadow-sm machinery-total" 
                                                    name="machineries[{{ $machinery->id }}][total]" 
                                                    value="{{ $machinery->total }}" type="number" step="0.01" readonly>
                                            </div>
                                            <div class="col-lg-2">
                                                <label class="form-label12 fw-semibold">Warranty</label>
                                                <select class="form-control border-warning shadow-sm" 
                                                    name="machineries[{{ $machinery->id }}][warranty]">
                                                    <option value="none" {{ $machinery->warranty == 'none' ? 'selected' : '' }}>No Warranty</option>
                                                    <option value="3m" {{ $machinery->warranty == '3m' ? 'selected' : '' }}>3 Months</option>
                                                    <option value="6m" {{ $machinery->warranty == '6m' ? 'selected' : '' }}>6 Months</option>
                                                    <option value="1y" {{ $machinery->warranty == '1y' ? 'selected' : '' }}>1 Year</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-1 d-flex align-items-end">
                                                <button type="button" class="btn btn-sm btn-danger remove-item" 
                                                    data-row="machinery-row-{{ $machinery->id }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        @endforeach
                                        <div id="newMachineryContainer"></div>
                                        <button type="button" id="addMachinery" class="btn btn-outline-warning mt-3">
                                            <i class="bi bi-plus-circle"></i> Add Machinery
                                        </button>

                                        <div class="row mt-3">
                                            <div class="col-md-3 offset-md-9">
                                                <label class="form-label12 fw-semibold">Machinery Subtotal</label>
                                                <input class="form-control border-warning shadow-sm" type="number" step="0.01"
                                                    name="machinery_subtotal" id="machinery_subtotal" 
                                                    value="{{ $sale->saleMachineries->sum('total') }}" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <h3 class="mt-5 mb-3 text-success border-bottom pb-2 section-title">
                                        <i class="bi bi-plug me-2"></i>
                                        Accessories Sale
                                    </h3>
                                    <div class="container-fluid">
                                        @foreach($sale->saleAccessories as $index => $accessory)
                                        <div class="row gy-4 item-row accessory-row" id="accessory-row-{{ $accessory->id }}">
                                            <div class="col-lg-3">
                                                <label class="form-label12 fw-semibold">Accessory Name</label>
                                                <select class="form-control border-success shadow-sm accessory-name" 
                                                    name="accessories[{{ $accessory->id }}][id]" required>
                                                    <option value="">Select Accessory</option>
                                                    @foreach($accessories as $acc)
                                                        <option value="{{ $acc->id }}" 
                                                            data-price="{{ $acc->price }}"
                                                            {{ $acc->id == $accessory->accessory_id ? 'selected' : '' }}>
                                                            {{ $acc->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-2">
                                                <label class="form-label12 fw-semibold">Quantity</label>
                                                <input class="form-control border-success shadow-sm accessory-quantity" 
                                                    name="accessories[{{ $accessory->id }}][quantity]" 
                                                    value="{{ $accessory->quantity }}" type="number" min="1" required>
                                            </div>
                                            <div class="col-lg-2">
                                                <label class="form-label12 fw-semibold">Unit Price</label>
                                                <input class="form-control border-success shadow-sm accessory-price" 
                                                    name="accessories[{{ $accessory->id }}][price]" 
                                                    value="{{ $accessory->price }}" type="number" step="0.01" required>
                                            </div>
                                            <div class="col-lg-2">
                                                <label class="form-label12 fw-semibold">Total</label>
                                                <input class="form-control border-success shadow-sm accessory-total" 
                                                    name="accessories[{{ $accessory->id }}][total]" 
                                                    value="{{ $accessory->total }}" type="number" step="0.01" readonly>
                                            </div>
                                            <div class="col-lg-2">
                                                <label class="form-label12 fw-semibold">Warranty</label>
                                                <select class="form-control border-success shadow-sm" 
                                                    name="accessories[{{ $accessory->id }}][warranty]">
                                                    <option value="none" {{ $accessory->warranty == 'none' ? 'selected' : '' }}>No Warranty</option>
                                                    <option value="1m" {{ $accessory->warranty == '1m' ? 'selected' : '' }}>1 Month</option>
                                                    <option value="3m" {{ $accessory->warranty == '3m' ? 'selected' : '' }}>3 Months</option>
                                                    <option value="6m" {{ $accessory->warranty == '6m' ? 'selected' : '' }}>6 Months</option>
                                                    <option value="1y" {{ $accessory->warranty == '1y' ? 'selected' : '' }}>1 Year</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-1 d-flex align-items-end">
                                                <button type="button" class="btn btn-sm btn-danger remove-item" 
                                                    data-row="accessory-row-{{ $accessory->id }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        @endforeach
                                        <div id="newAccessoryContainer"></div>
                                        <button type="button" id="addAccessory" class="btn btn-outline-success mt-3">
                                            <i class="bi bi-plus-circle"></i> Add Accessory
                                        </button>

                                        <div class="row mt-3">
                                            <div class="col-md-3 offset-md-9">
                                                <label class="form-label12 fw-semibold">Accessories Subtotal</label>
                                                <input class="form-control border-success shadow-sm" type="number" step="0.01"
                                                    name="accessories_subtotal" id="accessories_subtotal" 
                                                    value="{{ $sale->saleAccessories->sum('total') }}" readonly>
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
                                                    name="total_amount" id="total_amount" 
                                                    value="{{ $sale->total_amount }}" readonly>
                                            </div>
                                            <div class="col-lg-3">
                                                <label class="form-label12 fw-semibold">Amount Paid</label>
                                                <input class="form-control border-info shadow-sm" type="number" step="0.01"
                                                    name="paid_amount" id="paid_amount" 
                                                    value="{{ $sale->paid_amount }}" required>
                                            </div>
                                            <div class="col-lg-3">
                                                <label class="form-label12 fw-semibold">Balance Due</label>
                                                <input class="form-control border-info shadow-sm" type="number" step="0.01"
                                                    name="balance_due" id="balance_due" 
                                                    value="{{ $sale->balance_due }}" readonly>
                                            </div>
                                            <div class="col-lg-3">
                                                <label class="form-label12 fw-semibold">Payment Method</label>
                                                <select class="form-control border-info shadow-sm" name="payment_method" required>
                                                    <option value="cash" {{ $sale->payment_method == 'cash' ? 'selected' : '' }}>Cash</option>
                                                    <option value="cheque" {{ $sale->payment_method == 'cheque' ? 'selected' : '' }}>Cheque</option>
                                                    <option value="card" {{ $sale->payment_method == 'card' ? 'selected' : '' }}>Card</option>
                                                    <option value="bank_transfer" {{ $sale->payment_method == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                                    <option value="online" {{ $sale->payment_method == 'online' ? 'selected' : '' }}>Online</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="form-label12 fw-semibold">Payment Reference</label>
                                                <input class="form-control border-info shadow-sm" type="text"
                                                    name="payment_reference" value="{{ $sale->payment_reference }}"
                                                    placeholder="Cheque/Transaction number">
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="form-label12 fw-semibold">Status</label>
                                                <select class="form-control border-info shadow-sm" name="status" required>
                                                    <option value="pending" {{ $sale->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="completed" {{ $sale->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                    <option value="cancelled" {{ $sale->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-12">
                                                <label class="form-label12 fw-semibold">Remarks</label>
                                                <textarea name="remarks" class="form-control border-info shadow-sm" rows="2"
                                                    placeholder="Any special instructions">{{ $sale->remarks }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update Sale
                                    </button>
                                    <a href="{{ route('sales.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <style>
        /* Your existing styles from the create view */
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
        
        .section-title {
            letter-spacing: 1px;
            font-size: 1.25rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .item-row {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 0.7rem;
            padding: 1rem;
            margin-bottom: 1rem;
            border: 1px solid #e0f7fa;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }
    </style>

    <script>
        $(document).ready(function() {
            let accessoryIndex = {{ $sale->saleAccessories->count() }};
            let machineryIndex = {{ $sale->saleMachineries->count() }};

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
                <div class="row gy-4 item-row accessory-row" id="accessory-row-new-${accessoryIndex}">
                    <div class="col-lg-3">
                        <label class="form-label12 fw-semibold">Accessory Name</label>
                        <select class="form-control border-success shadow-sm accessory-name" name="new_accessories[${accessoryIndex}][id]">
                            <option value="">Select Accessory</option>
                            @foreach ($accessories as $accessory)
                                <option value="{{ $accessory->id }}" data-price="{{ $accessory->price }}">{{ $accessory->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <label class="form-label12 fw-semibold">Quantity</label>
                        <input class="form-control border-success shadow-sm accessory-quantity" name="new_accessories[${accessoryIndex}][quantity]" type="number" value="1" min="1">
                    </div>
                    <div class="col-lg-2">
                        <label class="form-label12 fw-semibold">Unit Price</label>
                        <input class="form-control border-success shadow-sm accessory-price" name="new_accessories[${accessoryIndex}][price]" type="number" step="0.01" placeholder="Price">
                    </div>
                    <div class="col-lg-2">
                        <label class="form-label12 fw-semibold">Total</label>
                        <input class="form-control border-success shadow-sm accessory-total" name="new_accessories[${accessoryIndex}][total]" type="number" step="0.01" readonly>
                    </div>
                    <div class="col-lg-2">
                        <label class="form-label12 fw-semibold">Warranty</label>
                        <select class="form-control border-success shadow-sm" name="new_accessories[${accessoryIndex}][warranty]">
                            <option value="none">No Warranty</option>
                            <option value="1m">1 Month</option>
                            <option value="3m">3 Months</option>
                            <option value="6m">6 Months</option>
                            <option value="1y">1 Year</option>
                        </select>
                    </div>
                    <div class="col-lg-1 d-flex align-items-end">
                        <button type="button" class="btn btn-sm btn-danger remove-item" data-row="accessory-row-new-${accessoryIndex}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>`;
                $('#newAccessoryContainer').append(row);
                
                // Set price when accessory is selected
                $(`#accessory-row-new-${accessoryIndex} .accessory-name`).change(function() {
                    const price = $(this).find(':selected').data('price');
                    $(this).closest('.accessory-row').find('.accessory-price').val(price).trigger('input');
                });
            });

            // Add machinery row
            $('#addMachinery').click(function() {
                machineryIndex++;
                const row = `
                <div class="row gy-4 item-row machinery-row" id="machinery-row-new-${machineryIndex}">
                    <div class="col-lg-3">
                        <label class="form-label12 fw-semibold">Machinery Name</label>
                        <select class="form-control border-warning shadow-sm machinery-name" name="new_machineries[${machineryIndex}][id]">
                            <option value="">Select Machinery</option>
                            @foreach ($machineries as $machinery)
                                <option value="{{ $machinery->id }}" data-price="{{ $machinery->price }}">{{ $machinery->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <label class="form-label12 fw-semibold">Quantity</label>
                        <input class="form-control border-warning shadow-sm machinery-quantity" name="new_machineries[${machineryIndex}][quantity]" type="number" value="1" min="1">
                    </div>
                    <div class="col-lg-2">
                        <label class="form-label12 fw-semibold">Unit Price</label>
                        <input class="form-control border-warning shadow-sm machinery-price" name="new_machineries[${machineryIndex}][price]" type="number" step="0.01" placeholder="Price">
                    </div>
                    <div class="col-lg-2">
                        <label class="form-label12 fw-semibold">Total</label>
                        <input class="form-control border-warning shadow-sm machinery-total" name="new_machineries[${machineryIndex}][total]" type="number" step="0.01" readonly>
                    </div>
                    <div class="col-lg-2">
                        <label class="form-label12 fw-semibold">Warranty</label>
                        <select class="form-control border-warning shadow-sm" name="new_machineries[${machineryIndex}][warranty]">
                            <option value="none">No Warranty</option>
                            <option value="3m">3 Months</option>
                            <option value="6m">6 Months</option>
                            <option value="1y">1 Year</option>
                            <option value="2y">2 Years</option>
                        </select>
                    </div>
                    <div class="col-lg-1 d-flex align-items-end">
                        <button type="button" class="btn btn-sm btn-danger remove-item" data-row="machinery-row-new-${machineryIndex}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>`;
                $('#newMachineryContainer').append(row);
                
                // Set price when machinery is selected
                $(`#machinery-row-new-${machineryIndex} .machinery-name`).change(function() {
                    const price = $(this).find(':selected').data('price');
                    $(this).closest('.machinery-row').find('.machinery-price').val(price).trigger('input');
                });
            });

            // Remove row
            $(document).on('click', '.remove-item', function() {
                const rowId = $(this).data('row');
                $(`#${rowId}`).remove();
                calculateTotals();
            });

            // Calculate totals when quantity or price changes
            $(document).on('input', '.accessory-quantity, .accessory-price, .machinery-quantity, .machinery-price, #paid_amount', function() {
                calculateTotals();
            });

            // Initialize calculations for existing items
            calculateTotals();
        });
    </script>
@endsection