@extends('setting::layouts.master')

@section('title', 'Installation Create')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0 px-0 py-2">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Installation Create</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper" style="background-color: #f5f7fa;">
        <!-- Custom CSS -->
        <style>
            :root {
                --primary-color: #4361ee;
                --secondary-color: #3f37c9;
                --success-color: #4cc9f0;
                --danger-color: #f72585;
                --warning-color: #f8961e;
                --light-color: #f8f9fa;
                --dark-color: #212529;
                --border-radius: 0.375rem;
                --box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
                --transition: all 0.3s ease;
            }

            body {
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
                background-color: #f5f7fa;
                color: #4a5568;
            }

            .content-header {
                padding: 15px 0;
            }

            .content-header h1 {
                font-weight: 600;
                color: #2d3748;
                font-size: 1.75rem;
            }

            .card {
                border: none;
                border-radius: var(--border-radius);
                box-shadow: var(--box-shadow);
                margin-bottom: 1.5rem;
                transition: var(--transition);
                background-color: white;
            }

            .card:hover {
                box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1);
            }

            .card-header {
                background-color: white;
                border-bottom: 1px solid rgba(0, 0, 0, 0.05);
                padding: 1.25rem 1.5rem;
                border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
            }

            .card-header h4 {
                font-weight: 600;
                color: var(--primary-color);
                margin: 0;
                font-size: 1.1rem;
            }

            .card-body {
                padding: 1.5rem;
            }

            .card-footer {
                background-color: white;
                border-top: 1px solid rgba(0, 0, 0, 0.05);
                padding: 1rem 1.5rem;
                border-radius: 0 0 var(--border-radius) var(--border-radius);
            }

            .form-control {
                border-radius: var(--border-radius);
                border: 1px solid #e2e8f0;
                padding: 0.5rem 0.75rem;
                height: calc(2.25rem + 2px);
                font-size: 0.875rem;
                transition: var(--transition);
            }

            .form-control:focus {
                border-color: var(--primary-color);
                box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
            }

            .form-control[readonly] {
                background-color: #f8fafc;
            }

            label,
            strong {
                font-weight: 500;
                color: #4a5568;
                margin-bottom: 0.5rem;
                display: block;
                font-size: 0.875rem;
            }

            .btn {
                border-radius: var(--border-radius);
                padding: 0.5rem 1.25rem;
                font-weight: 500;
                transition: var(--transition);
                font-size: 0.875rem;
            }

            .btn-success {
                background-color: #38a169;
                border-color: #38a169;
            }

            .btn-success:hover {
                background-color: #2f855a;
                border-color: #2f855a;
            }

            .btn-warning {
                background-color: var(--warning-color);
                border-color: var(--warning-color);
                color: white;
            }

            .btn-warning:hover {
                background-color: #e07b0e;
                border-color: #e07b0e;
            }

            .badge {
                padding: 0.35rem 0.65rem;
                border-radius: var(--border-radius);
                font-weight: 500;
                cursor: pointer;
                font-size: 0.75rem;
                transition: var(--transition);
            }

            .badge-primary {
                background-color: var(--primary-color);
            }

            .badge-danger {
                background-color: var(--danger-color);
            }

            .badge-primary:hover {
                background-color: var(--secondary-color);
            }

            .badge-danger:hover {
                background-color: #d1146a;
            }

            .product-row,
            .accessory-row {
                background-color: #f8fafc;
                padding: 1rem;
                border-radius: var(--border-radius);
                margin-bottom: 1rem;
                align-items: center;
                border: 1px solid #edf2f7;
            }

            .payment-method {
                margin-right: 0.5rem;
            }

            textarea.form-control {
                min-height: 100px;
            }

            hr {
                border-top: 1px solid #e2e8f0;
                margin: 1.5rem 0;
            }

            .breadcrumb {
                background-color: transparent;
                padding: 0.5rem 0;
                font-size: 0.875rem;
            }

            .breadcrumb-item a {
                color: var(--primary-color);
                text-decoration: none;
            }

            .breadcrumb-item.active {
                color: #718096;
            }

            /* Improved radio buttons */
            .payment-method {
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
                width: 16px;
                height: 16px;
                border: 2px solid #cbd5e0;
                border-radius: 50%;
                outline: none;
                transition: var(--transition);
                position: relative;
                vertical-align: middle;
                margin-right: 0.5rem;
            }

            .payment-method:checked {
                border-color: var(--primary-color);
                background-color: var(--primary-color);
            }

            .payment-method:checked::after {
                content: '';
                position: absolute;
                width: 6px;
                height: 6px;
                background-color: white;
                border-radius: 50%;
                top: 3px;
                left: 3px;
            }

            /* Responsive adjustments */
            @media (max-width: 768px) {
                .content-header .row {
                    flex-direction: column;
                }

                .content-header .col-sm-6 {
                    width: 100%;
                    margin-bottom: 1rem;
                }

                .breadcrumb.float-sm-right {
                    float: none !important;
                    justify-content: flex-start !important;
                }

                .product-row,
                .accessory-row {
                    flex-direction: column;
                    gap: 0.75rem;
                }

                .product-row>div,
                .accessory-row>div {
                    width: 100% !important;
                }
            }

            /* Animation for form sections */
            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .card {
                animation: fadeIn 0.3s ease-out forwards;
            }

            /* Custom scrollbar */
            ::-webkit-scrollbar {
                width: 8px;
                height: 8px;
            }

            ::-webkit-scrollbar-track {
                background: #f1f1f1;
            }

            ::-webkit-scrollbar-thumb {
                background: #c1c1c1;
                border-radius: 4px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: #a8a8a8;
            }

            /* Select2 customization */
            .select2-container--bootstrap4 .select2-selection {
                border-radius: var(--border-radius) !important;
                border: 1px solid #e2e8f0 !important;
                height: calc(2.25rem + 2px) !important;
                padding: 0.375rem 0.75rem;
            }

            .select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow {
                height: calc(2.25rem + 2px) !important;
            }

            /* Improved toggle button */
            #toggleEmi {
                font-size: 0.75rem;
                padding: 0.35rem 0.75rem;
                border-radius: 20px;
                font-weight: 600;
            }
        </style>

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Create New Installation</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">New Installation</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <form action="{{ route('store.installation.customer', $customer['id']) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- Customer Details Card -->
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4><i class="fas fa-user mr-2"></i>Customer Details</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input class="form-control" type="text" readonly
                                                    value="{{ ucfirst($customer->lead['name']) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Contact</label>
                                                <input class="form-control" type="text" readonly
                                                    value="{{ ucfirst($customer->lead['mobile']) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input class="form-control" type="text" readonly
                                                    value="{{ ucfirst($customer->lead['address']) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" value="{{ $customer->lead['id'] }}" name="lead_id">
                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Lead By</label>
                                                <input class="form-control" type="text" value="{{ $leadby['name'] }}"
                                                    readonly name="install_date">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Converted By</label>
                                                <select name="converted_by" class="form-control">
                                                    <option value="">Select Staff</option>
                                                    @foreach ($staffs as $staff)
                                                        <option value="{{ $staff['id'] }}">{{ $staff['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Install Date</label>
                                                <input class="form-control" type="date" name="install_date">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Product Details Card -->
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4><i class="fas fa-boxes mr-2"></i>Product Details</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row gy-3">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Products</label>
                                                @foreach ($customerMachines as $key => $machine)
                                                    <div class="row g-3 align-items-center mb-3 product-row"
                                                        id="product-{{ $key }}">
                                                        <div class="col-md-4">
                                                            <select class="form-control product-select" name="products_id[]"
                                                                id="product-select-{{ $key }}">
                                                                <option value="{{ $machine->product['id'] }}" selected>
                                                                    {{ $machine->product['name'] }}</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <input type="number" name="products_qty[]"
                                                                value="{{ $machine->product_qty }}" min="1"
                                                                class="form-control product-qty" placeholder="Qty">
                                                        </div>
                                                        <div class="col-md-1">
                                                            <input type="text" name="products_units[]"
                                                                value="{{ $machine->product['units'] }}"
                                                                class="form-control product-units" readonly>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="number" name="products_price[]"
                                                                value="{{ $machine->product_price }}"
                                                                class="form-control product-price" placeholder="Price">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="text" name="products_total[]"
                                                                value="{{ $machine->product_total }}"
                                                                class="form-control product-row-total" readonly>
                                                        </div>
                                                        <div class="col-md-2 text-right">
                                                            <button type="button"
                                                                class="btn btn-sm btn-danger removeProduct">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                <div id="productContainer"></div>
                                                <button type="button" id="addProduct"
                                                    class="btn btn-sm btn-primary mt-2">
                                                    <i class="fas fa-plus mr-1"></i> Add Product
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="form-group">
                                        <label>Accessories</label>
                                        @foreach ($customerAccessories as $key => $accessory)
                                            <div class="row g-3 align-items-center mb-3 accessory-row"
                                                id="accessory-{{ $key }}">
                                                <div class="col-md-4">
                                                    <select class="form-control accessory-select" name="accessories_id[]"
                                                        id="accessory-select-{{ $key }}">
                                                        <option value="{{ $accessory->accessory['id'] }}">
                                                            {{ $accessory->accessory['name'] }}</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="number" name="accessories_qty[]"
                                                        value="{{ $accessory->accessory_qty }}"
                                                        class="form-control accessory-qty" min="1"
                                                        placeholder="Qty">
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="text" name="accessories_units[]"
                                                        value="{{ $accessory->accessory['units'] }}"
                                                        class="form-control accessory-units" readonly>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="number" name="accessories_price[]"
                                                        value="{{ $accessory->accessory_price }}"
                                                        class="form-control accessory-price" placeholder="Price">
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" name="accessories_total[]"
                                                        value="{{ $accessory->accessory_total }}"
                                                        class="form-control accessory-row-total" readonly>
                                                </div>
                                                <div class="col-md-2 text-right">
                                                    <button type="button" class="btn btn-sm btn-danger removeAccessory">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div id="accessoryContainer"></div>
                                        <button type="button" id="addAccessory" class="btn btn-sm btn-primary mt-2">
                                            <i class="fas fa-plus mr-1"></i> Add Accessory
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Details Card -->
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div class="col-6">
                                        <h4><i class="fas fa-credit-card mr-2"></i>Payment Details</h4>
                                    </div>
                                    <div class="col-6 text-right">
                                        <button type="button" id="toggleEmi" class="btn btn-warning btn-lg p-3">
                                            <i class="fas fa-exchange-alt mr-1"></i> Use EMI
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <!-- Regular Payment Form -->
                                    <div id="paymentSection">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Total Amount</label>
                                                    <input type="text" name="grand_total" id="overallTotal"
                                                        class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Paid Amount</label>
                                                    <input type="text" name="paid_amount" class="form-control"
                                                        placeholder="Paid Amount">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Date</label>
                                                    <input type="date" name="paid_date" class="form-control"
                                                        placeholder="Date">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Payment Methods</label>
                                            <div class="d-flex align-items-center" style="gap: 1rem;">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="cashMethod" name="method" value="cash"
                                                        checked class="payment-method custom-control-input">
                                                    <label class="custom-control-label" for="cashMethod">Cash</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="onlineMethod" name="method"
                                                        value="online" class="payment-method custom-control-input">
                                                    <label class="custom-control-label" for="onlineMethod">Online</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="chequeMethod" name="method"
                                                        value="cheque" class="payment-method custom-control-input">
                                                    <label class="custom-control-label" for="chequeMethod">Cheque</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="chequeContainer"></div>
                                    </div>

                                    <!-- EMI Payment Form -->
                                    <div id="emiSection" style="display: none;">
                                        <!-- Hidden input to set payment method to emi -->
                                        <input type="hidden" name="method" value="emi">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Select EMI Plan</label>
                                                    <select name="emi_id" class="form-control">
                                                        <option value="">Select EMI Plan</option>
                                                        @foreach ($emiPlans as $plan)
                                                            <option value="{{ $plan->id }}">{{ $plan->title }} -
                                                                {{ $plan->interest_rate }}% for {{ $plan->duration }}
                                                                months</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Down Payment</label>
                                                    <input type="number" name="down_payment" class="form-control"
                                                        placeholder="Enter Down Payment">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Start Date</label>
                                                    <input type="date" name="start_date" id="startDate"
                                                        class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>End Date</label>
                                                    <input type="date" name="end_date" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Monthly Pay</label>
                                                    <input type="number" name="monthly_pay" class="form-control"
                                                        placeholder="Calculated Monthly Pay">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Document Upload</label>
                                                    <input type="file" name="document" class="form-control-file">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Status</label>
                                            <select name="status" class="form-control">
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Remarks Card -->
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4><i class="fas fa-comment-alt mr-2"></i>Additional Remarks</h4>
                            </div>
                            <div class="card-body">
                                <textarea name="remarks" class="form-control" id="" cols="30" rows="3"
                                    placeholder="Enter any additional remarks here..."></textarea>
                            </div>
                            <div class="card-footer text-center">
                                <button class="btn btn-success px-5 py-2" type="submit">
                                    <i class="fas fa-save mr-2"></i> Save Installation
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>

    </div>

    <!-- JavaScript (unchanged from original) -->
    <script>
        $(document).ready(function() {
            let accessoryIndex = 0;
            let productIndex = 0;

            // Function to calculate the overall total (Products + Accessories)
            function calculateOverallTotal() {
                let overallTotal = 0;

                // Calculate total for all products
                $('.product-row').each(function() {
                    const rowTotal = parseFloat($(this).find('.product-row-total').val()) || 0;
                    overallTotal += rowTotal;
                });

                // Calculate total for all accessories
                $('.accessory-row').each(function() {
                    const rowTotal = parseFloat($(this).find('.accessory-row-total').val()) || 0;
                    overallTotal += rowTotal;
                });

                $('#overallTotal').val(overallTotal.toFixed(2)); // Update overall total
            }

            // Function to calculate totals for a row (either product or accessory)
            function calculateRowTotal(rowId, type) {
                const qty = $(`#${type}-${rowId} .${type}-qty`).val();
                const price = $(`#${type}-${rowId} .${type}-price`).val();
                const rowTotal = qty * price;

                $(`#${type}-${rowId} .${type}-row-total`).val(rowTotal.toFixed(2));
                calculateOverallTotal(); // Recalculate overall total
            }

            // Initialize Select2 for a dynamic dropdown
            function initializeSelect(selector, type) {
                // Check and set the correct endpoint based on type
                const endpoint = type === 'product' ? '/getproducts' : '/accessories';

                $(selector).select2({
                    theme: 'bootstrap4',
                    placeholder: `Search for a ${type}`,
                    ajax: {
                        url: endpoint, // Use the dynamic endpoint
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                search: params.term
                            }; // Send the search term to the server
                        },
                        processResults: function(data) {
                            return {
                                results: data.map(item => ({
                                    id: item.id,
                                    text: item.name,
                                    price: item.sales_price,
                                    units: item.units
                                }))
                            };
                        },
                        cache: true
                    }
                }).on('select2:select', function(e) {
                    const selectedData = e.params.data;
                    const rowId = $(this).closest(`.${type}-row`).attr('id');
                    $(`#${rowId} .${type}-price`).val(selectedData.price);
                    $(`#${rowId} .${type}-units`).val(selectedData.units);
                    calculateRowTotal(rowId.replace(`${type}-`, ''), type); // Recalculate for the row
                });
            }

            // Append new product row
            $('#addProduct').on('click', function() {
                productIndex++;
                const row = `
                <div class="row g-3 align-items-center mb-3 product-row" id="product-${productIndex}">
                    <div class="col-md-4">
                        <select class="form-control product-select" name="products_id[]" id="product-select-${productIndex}">
                            <option value="">Search and select a product</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <input type="number" name="products_qty[]" value="1" class="form-control product-qty" placeholder="Qty">
                    </div>
                    <div class="col-md-1">
                        <input type="text" name="products_units[]" class="form-control product-units" readonly>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="products_price[]" class="form-control product-price" placeholder="Price">
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="products_total[]" class="form-control product-row-total" readonly>
                    </div>
                    <div class="col-md-2 text-right">
                        <button type="button" class="btn btn-sm btn-danger removeProduct">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>`;
                $('#productContainer').append(row);
                initializeSelect(`#product-select-${productIndex}`, 'product');
            });

            // Append new accessory row
            $('#addAccessory').on('click', function() {
                accessoryIndex++;
                const row = `
                <div class="row g-3 align-items-center mb-3 accessory-row" id="accessory-${accessoryIndex}">
                    <div class="col-md-4">
                        <select class="form-control accessory-select" name="accessories_id[]" id="accessory-select-${accessoryIndex}">
                            <option value="">Search and select an accessory</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <input type="number" name="accessories_qty[]" value="1" class="form-control accessory-qty" placeholder="Qty">
                    </div>
                    <div class="col-md-1">
                        <input type="text" name="accessories_units[]" class="form-control accessory-units" readonly>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="accessories_price[]" class="form-control accessory-price" placeholder="Price">
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="accessories_total[]" class="form-control accessory-row-total" readonly>
                    </div>
                    <div class="col-md-2 text-right">
                        <button type="button" class="btn btn-sm btn-danger removeAccessory">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>`;
                $('#accessoryContainer').append(row);
                initializeSelect(`#accessory-select-${accessoryIndex}`, 'accessory');
            });

            // Remove product row
            $(document).on('click', '.removeProduct', function() {
                $(this).closest('.product-row').remove();
                calculateOverallTotal(); // Recalculate overall total after removal
            });

            // Remove accessory row
            $(document).on('click', '.removeAccessory', function() {
                $(this).closest('.accessory-row').remove();
                calculateOverallTotal(); // Recalculate overall total after removal
            });

            // Watch for changes in quantity or price for products
            $(document).on('input', '.product-qty, .product-price', function() {
                const rowId = $(this).closest('.product-row').attr('id').replace('product-', '');
                calculateRowTotal(rowId, 'product');
            });

            // Watch for changes in quantity or price for accessories
            $(document).on('input', '.accessory-qty, .accessory-price', function() {
                const rowId = $(this).closest('.accessory-row').attr('id').replace('accessory-', '');
                calculateRowTotal(rowId, 'accessory');
            });

            // Call calculateOverallTotal on page load
            calculateOverallTotal();
        });

        // EMI script

        $(document).ready(function() {
            const toggleBtn = $('#toggleEmi');
            const paymentSection = $('#paymentSection');
            const emiSection = $('#emiSection');
            const startDateInput = $('#startDate')[0];

            // EMI toggle
            toggleBtn.on('click', function() {
                if (emiSection.is(':hidden')) {
                    emiSection.show();
                    paymentSection.hide();
                    toggleBtn.html('<i class="fas fa-exchange-alt mr-1"></i> Use Full Payment');

                    // Set start date one month from today
                    const today = new Date();
                    today.setMonth(today.getMonth() + 1);
                    startDateInput.valueAsDate = today;

                    // Disable and uncheck payment methods
                    $('.payment-method').prop('checked', false).prop('disabled', true);
                    $('#chequeContainer').html('');
                } else {
                    emiSection.hide();
                    paymentSection.show();
                    toggleBtn.html('<i class="fas fa-exchange-alt mr-1"></i> Use EMI');

                    // Enable and reset payment methods
                    $('.payment-method').prop('disabled', false);
                    $('#cashMethod').prop('checked', true);
                }
            });

            // Handle payment method change
            $('.payment-method').on('change', function() {
                if ($(this).val() === 'cheque' && $('#emiSection').is(':hidden')) {
                    $('#chequeContainer').html(`
                    <div class="form-group mt-3">
                        <label>Cheque No.</label>
                        <input type="text" name="cheque_no" placeholder="Enter Cheque Number" class="form-control">
                    </div>
                `);
                } else {
                    $('#chequeContainer').html('');
                }
            });
        });
    </script>
@endsection
