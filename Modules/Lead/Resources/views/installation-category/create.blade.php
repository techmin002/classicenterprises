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
                <form action="{{ route('store.installation-category.customer', $customer['id']) }}" method="post"
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
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Username</label>
                                                <input class="form-control" type="text" name="username" id="username"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input class="form-control" type="text" name="name" id="customer_name"
                                                    value="{{ ucfirst($customer->lead['name']) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Contact Number</label>
                                                <input class="form-control" type="tel"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);"
                                                    pattern="\d{10}" maxlength="10" name="mobile"
                                                    value="{{ $customer->lead['mobile'] }}">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Alternate Contact Number</label>
                                                <input class="form-control" type="tel"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);"
                                                    pattern="\d{10}" maxlength="10" name="landline"
                                                    value="{{ $customer->lead['landline'] }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input class="form-control" type="text" name="address"
                                                    value="{{ ucfirst($customer->lead['address']) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" value="{{ $customer->lead['id'] }}" name="lead_id">

                                    <div class="row mt-3">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input class="form-control" type="email" name="email" id="email"
                                                    value="{{ ucfirst($customer->lead['email']) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Install Date</label>
                                                <input class="form-control" type="date" name="install_date" required>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Lead Source</label>
                                                <input class="form-control" type="text"
                                                    value="{{ ucfirst($customer->lead['lead_source']) }}" name="lead_source"
                                                    readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Lead Entry</label>
                                                <input class="form-control" type="text" value="{{ $leadby['name'] }}"
                                                    name="created_by" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Sales Convert</label>
                                                <input class="form-control" type="text"
                                                    value="{{ $customer->convertedBy->name ?? 'N/A' }}" name="converted_by"
                                                    readonly>
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Sales Convert</label>
                                                <select name="converted_by" class="form-control" required>
                                                    <option value="">Select Staff</option>
                                                    @foreach ($staffs as $staff)
                                                        <option value="{{ $staff['id'] }}">{{ $staff['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> --}}

                                        <!-- Hidden Branch Code -->
                                        <input type="hidden" id="branch_code"
                                            value="{{ $customer->branch->branch_code ?? '' }}">
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
                                                            <select class="form-control product-select"
                                                                name="products_id[]"
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
                                                                class="btn btn-sm btn-danger removeProduct"><i
                                                                    class="fas fa-times"></i></button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                <div id="productContainer"></div>
                                                <button type="button" id="addProduct"
                                                    class="btn btn-sm btn-primary mt-2"><i class="fas fa-plus mr-1"></i>
                                                    Add Product</button>
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
                                                    <button type="button"
                                                        class="btn btn-sm btn-danger removeAccessory"><i
                                                            class="fas fa-times"></i></button>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div id="accessoryContainer"></div>
                                        <button type="button" id="addAccessory" class="btn btn-sm btn-primary mt-2"><i
                                                class="fas fa-plus mr-1"></i> Add Accessory</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Gifted Card -->
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div class="col-6">
                                        <h4><i class="fas fa-gift mr-2"></i>Gifted</h4>
                                        <div class="d-flex align-items-center mt-3" style="gap: 1rem;">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="giftedYes" name="is_gifted" value="1"
                                                    class="custom-control-input">
                                                <label class="custom-control-label" for="giftedYes">Yes</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="giftedNo" name="is_gifted" value="0"
                                                    class="custom-control-input" checked>
                                                <label class="custom-control-label" for="giftedNo">No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Details Card -->
                        <div class="col-md-12" id="paymentCard">
                            <div class="card">
                                <div class="card-header">
                                    <h4><i class="fas fa-credit-card mr-2"></i>Payment Details</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <!-- Payment Status -->
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Payment Status</label>
                                                <select name="payment_status" id="paymentStatus" class="form-control">
                                                    <option value="" selected disabled>Select Payment status</option>
                                                    <option value="unpaid">Unpaid</option>
                                                    <option value="paid">Paid</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Total Amount -->
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Total Amount</label>
                                                <input type="number" name="grand_total" id="overallTotal"
                                                    class="form-control" value="{{ $customer->total_amount ?? 0 }}"
                                                    readonly>
                                            </div>
                                        </div>

                                        <!-- Exchange Amount -->
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Exchange Amount</label>
                                                <input type="number" name="exchange_amount" class="form-control"
                                                    value="{{ $customer->exchange_amount ?? 0 }}" readonly>
                                            </div>
                                        </div>

                                        <!-- Remaining Amount -->
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Remaining Amount</label>
                                                <input type="number" name="remaining_amount" id="remainingAmount"
                                                    class="form-control"
                                                    value="{{ ($customer->total_amount ?? 0) - ($customer->exchange_amount ?? 0) }}"
                                                    readonly>
                                            </div>
                                        </div>


                                        <!-- Paid Date -->
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Date</label>
                                                <input type="date" name="paid_date" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Paid Section -->
                                    <div id="paidSection" style="display:none;">
                                        <div class="form-group">
                                            <label>Payment Method</label>
                                            <select name="method" id="paymentMethod" class="form-control">
                                                <option value="" selected disabled>Select Method</option>
                                                <option value="cash">Cash</option>
                                                <option value="online">Online</option>
                                                <option value="cheque">Cheque</option>
                                                <option value="multiple">Multiple</option>
                                            </select>
                                        </div>
                                        <div id="methodFields" class="mt-3"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Document Card -->
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div class="col-12">
                                        <h4><i class="fas fa-file-alt mr-2"></i>Documents</h4>
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="productDocument">Upload Product Document</label>
                                                    <input type="file" name="product_document" class="form-control"
                                                        accept=".pdf,.jpg,.jpeg,.png" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="warrantyCard">Upload Warranty Card</label>
                                                    <input type="file" name="warranty_card" class="form-control"
                                                        accept=".pdf,.jpg,.jpeg,.png" required>
                                                </div>
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
                                    <h4><i class="fas fa-comment-alt mr-2"></i>Remarks</h4>
                                </div>
                                <div class="card-body">
                                    <textarea name="remarks" class="form-control" cols="30" rows="3" required
                                        placeholder="Enter any remarks here..."></textarea>
                                </div>
                                <div class="card-footer text-start">
                                    <button class="btn btn-success" type="submit">
                                        <i class="fas fa-save mr-2"></i>Submit
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </section>

    </div>

    </div>

    <!-- JavaScript  -->
    <!-- Complete JavaScript -->
    <script>
        $(document).ready(function() {
            let accessoryIndex = 0;
            let productIndex = 0;

            // Calculate the overall total (Products + Accessories)
            function calculateOverallTotal() {
                let overallTotal = 0;

                // Products total
                $('.product-row').each(function() {
                    const rowTotal = parseFloat($(this).find('.product-row-total').val()) || 0;
                    overallTotal += rowTotal;
                });

                // Accessories total
                $('.accessory-row').each(function() {
                    const rowTotal = parseFloat($(this).find('.accessory-row-total').val()) || 0;
                    overallTotal += rowTotal;
                });

                $('#overallTotal').val(overallTotal.toFixed(2));
            }

            // Calculate row total
            function calculateRowTotal(rowId, type) {
                const qty = parseFloat($(`#${type}-${rowId} .${type}-qty`).val()) || 0;
                const price = parseFloat($(`#${type}-${rowId} .${type}-price`).val()) || 0;
                const rowTotal = qty * price;

                $(`#${type}-${rowId} .${type}-row-total`).val(rowTotal.toFixed(2));
                calculateOverallTotal();
            }

            // Initialize Select2 for product/accessory
            function initializeSelect(selector, type) {
                const endpoint = type === 'product' ? '/getproducts' : '/accessories';

                $(selector).select2({
                    theme: 'bootstrap4',
                    placeholder: `Search for a ${type}`,
                    ajax: {
                        url: endpoint,
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                search: params.term
                            };
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
                    calculateRowTotal(rowId.replace(`${type}-`, ''), type);
                });
            }

            // Add Product row
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

            // Add Accessory row
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

            // Remove row handlers
            $(document).on('click', '.removeProduct', function() {
                $(this).closest('.product-row').remove();
                calculateOverallTotal();
            });

            $(document).on('click', '.removeAccessory', function() {
                $(this).closest('.accessory-row').remove();
                calculateOverallTotal();
            });

            // Recalculate totals on input change
            $(document).on('input', '.product-qty, .product-price', function() {
                const rowId = $(this).closest('.product-row').attr('id').replace('product-', '');
                calculateRowTotal(rowId, 'product');
            });
            $(document).on('input', '.accessory-qty, .accessory-price', function() {
                const rowId = $(this).closest('.accessory-row').attr('id').replace('accessory-', '');
                calculateRowTotal(rowId, 'accessory');
            });

            // Initial total calculation
            calculateOverallTotal();

            /* ========================================
                Payment Section Handling
            ======================================== */
            function updateRemainingAmount() {
                const total = parseFloat($('#overallTotal').val()) || 0;
                const exchange = parseFloat($('input[name="exchange_amount"]').val()) || 0;
                let paidTotal = 0;

                // Cash amount
                let cash = parseFloat($('input[name="cash_amount"]').val()) || 0;
                paidTotal += cash;

                // Online amount
                let online = parseFloat($('input[name="online_amount"]').val()) || 0;
                paidTotal += online;

                // Cheque amount
                let cheque = parseFloat($('input[name="cheque_amount"]').val()) || 0;
                paidTotal += cheque;

                // Subtract exchange first, then paid amounts
                let remaining = (total - exchange) - paidTotal;
                remaining = remaining >= 0 ? remaining : 0;
                $('#remainingAmount').val(remaining);

                // If total paid exceeds allowed (after exchange), adjust last input
                const allowedTotal = total - exchange;
                if (paidTotal > allowedTotal) {
                    const $trigger = $(
                            'input[name="cash_amount"], input[name="online_amount"], input[name="cheque_amount"]')
                        .filter(':focus');
                    if ($trigger.length) {
                        const triggerVal = parseFloat($trigger.val()) || 0;
                        const allowed = triggerVal - (paidTotal - allowedTotal);
                        $trigger.val(allowed >= 0 ? allowed : 0);
                        updateRemainingAmount(); // recalc
                    }
                }
            }

            /* ========================================
               Validation Handling for Payment Section
            ======================================== */
            function setFieldRequired(selector, isRequired) {
                const field = $(selector);
                if (isRequired) {
                    field.attr('required', true);
                    // Add * only if not already present
                    const label = field.closest('.form-group').find('label');
                    if (!label.find('.text-danger').length) {
                        label.append('<span class="text-danger"> *</span>');
                    }
                } else {
                    field.removeAttr('required');
                    field.closest('.form-group').find('label .text-danger').remove();
                }
            }

            // Handle requirement updates
            function updateFieldRequirements() {
                const status = $('#paymentStatus').val();
                const method = $('#paymentMethod').val();

                // 1️⃣ Date field required if paid or unpaid
                setFieldRequired('input[name="paid_date"]', status === 'paid' || status === 'unpaid');

                // 2️⃣ Reset all receipts to not required
                setFieldRequired('input[name="cash_receipt"]', false);
                setFieldRequired('input[name="online_receipt"]', false);
                setFieldRequired('input[name="cheque_number"]', false);
                setFieldRequired('#paymentMethod', false);

                // 3️⃣ When status = paid
                if (status === 'paid') {
                    // Payment method required
                    setFieldRequired('#paymentMethod', true);

                    // Method-based receipts
                    if (method === 'cash') {
                        setFieldRequired('input[name="cash_receipt"]', true);
                    } else if (method === 'online') {
                        setFieldRequired('input[name="online_receipt"]', true);
                    } else if (method === 'cheque') {
                        setFieldRequired('input[name="cheque_number"]', true);
                    } else if (method === 'multiple') {
                        setFieldRequired('input[name="cash_receipt"]', true);
                        setFieldRequired('input[name="online_receipt"]', true);
                        setFieldRequired('input[name="cheque_number"]', true);
                    }
                }
            }

            // Listen for changes
            $('#paymentStatus, #paymentMethod').on('change', updateFieldRequirements);

            // Initialize on page load
            $(document).ready(function() {
                updateFieldRequirements();
            });

            // Show payment fields
            function showPaymentFields(method) {
                let html = '';
                if (method === 'cash') {
                    html = `
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Cash Amount</label>
                <input type="number" name="cash_amount" class="form-control" placeholder="Enter Cash Amount" min="0" required oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Receipt</label>
                <input type="file" name="cash_receipt" class="form-control" required>
            </div>
        </div>
    </div>`;
                } else if (method === 'online') {
                    html = `
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Online Amount</label>
                <input type="number" name="online_amount" class="form-control" placeholder="Enter Online Amount" min="0" required oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Receipt</label>
                <input type="file" name="online_receipt" class="form-control" required>
            </div>
        </div>
    </div>`;
                } else if (method === 'cheque') {
                    html = `
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Cheque Amount</label>
                <input type="number" name="cheque_amount" class="form-control" placeholder="Enter Cheque Amount" min="0" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Cheque Number</label>
                <input type="text" name="cheque_number" class="form-control" placeholder="Enter Cheque Number" required oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Cheque Receipt</label>
                <input type="file" name="cheque_receipt" class="form-control" required>
            </div>
        </div>
    </div>`;
                } else if (method === 'multiple') {
                    html = `
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Cash Amount</label>
                <input type="number" name="cash_amount" class="form-control" placeholder="Enter Cash Amount" min="0" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Cash Receipt</label>
                <input type="file" name="cash_receipt" class="form-control" >
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-6">
            <div class="form-group">
                <label>Online Amount</label>
                <input type="number" name="online_amount" class="form-control" placeholder="Enter Online Amount" min="0" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Online Receipt</label>
                <input type="file" name="online_receipt" class="form-control" >
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-4">
            <div class="form-group">
                <label>Cheque Amount</label>
                <input type="number" name="cheque_amount" class="form-control" placeholder="Enter Cheque Amount" min="0" >
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Cheque Number</label>
                <input type="number" name="cheque_number" class="form-control" placeholder="Enter Cheque Number" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Cheque Receipt</label>
                <input type="file" name="cheque_receipt" class="form-control" >
            </div>
        </div>
    </div>`;
                }

                // Validation for "multiple" payment method
                $('form').off('submit.multipleCheck').on('submit.multipleCheck', function(e) {
                    if (method === 'multiple') {
                        let filledCount = 0;

                        const cash = parseFloat($('input[name="cash_amount"]').val()) || 0;
                        const online = parseFloat($('input[name="online_amount"]').val()) || 0;
                        const cheque = parseFloat($('input[name="cheque_amount"]').val()) || 0;

                        if (cash > 0) filledCount++;
                        if (online > 0) filledCount++;
                        if (cheque > 0) filledCount++;

                        $('#multiple-error').remove();

                        // Make receipt fields required only when corresponding amount > 0
                        if (cash > 0) {
                            $('input[name="cash_receipt"]').attr('required', true);
                        } else {
                            $('input[name="cash_receipt"]').removeAttr('required').css('border', '');
                        }

                        if (online > 0) {
                            $('input[name="online_receipt"]').attr('required', true);
                        } else {
                            $('input[name="online_receipt"]').removeAttr('required').css('border', '');
                        }

                        if (cheque > 0) {
                            $('input[name="cheque_receipt"]').attr('required', true);
                            $('input[name="cheque_number"]').attr('required', true);
                        } else {
                            $('input[name="cheque_receipt"]').removeAttr('required').css('border', '');
                            $('input[name="cheque_number"]').removeAttr('required').css('border', '');
                        }

                        // Check if at least 2 amounts are filled
                        if (filledCount < 2) {
                            e.preventDefault();

                            // Red highlight for empty or 0 amounts
                            $('input[name="cash_amount"], input[name="online_amount"], input[name="cheque_amount"]')
                                .each(function() {
                                    if (!$(this).val() || parseFloat($(this).val()) <= 0) {
                                        $(this).css('border', '1px solid red');
                                    } else {
                                        $(this).css('border', '');
                                    }
                                });

                            $('#methodFields').append(`
                <div id="multiple-error" style="color:red; margin-top:10px; font-size:14px;">
                    Please fill at least <b>two payment methods</b> (e.g., Cash & Online or Cash & Cheque).
                </div>
            `);
                            return false;
                        }

                        // Validate receipt/cheque fields for filled amounts
                        let invalid = false;
                        if (cash > 0 && !$('input[name="cash_receipt"]').val()) {
                            $('input[name="cash_receipt"]').css('border', '1px solid red');
                            invalid = true;
                        }
                        if (online > 0 && !$('input[name="online_receipt"]').val()) {
                            $('input[name="online_receipt"]').css('border', '1px solid red');
                            invalid = true;
                        }
                        if (cheque > 0) {
                            if (!$('input[name="cheque_number"]').val()) {
                                $('input[name="cheque_number"]').css('border', '1px solid red');
                                invalid = true;
                            }
                            if (!$('input[name="cheque_receipt"]').val()) {
                                $('input[name="cheque_receipt"]').css('border', '1px solid red');
                                invalid = true;
                            }
                        }

                        if (invalid) {
                            e.preventDefault();
                            $('#methodFields').append(`
                <div id="multiple-error" style="color:red; margin-top:10px; font-size:14px;">
                    Please upload required receipts (and cheque number if cheque amount is entered).
                </div>
            `);
                            return false;
                        }
                    }
                });

                // 🔴 Live update validation while typing or selecting files
                $(document).on('input change',
                    'input[name="cash_amount"], input[name="online_amount"], input[name="cheque_amount"], input[name="cash_receipt"], input[name="online_receipt"], input[name="cheque_number"], input[name="cheque_receipt"]',
                    function() {
                        if (method === 'multiple') {
                            let filledCount = 0;
                            const cash = parseFloat($('input[name="cash_amount"]').val()) || 0;
                            const online = parseFloat($('input[name="online_amount"]').val()) || 0;
                            const cheque = parseFloat($('input[name="cheque_amount"]').val()) || 0;

                            if (cash > 0) filledCount++;
                            if (online > 0) filledCount++;
                            if (cheque > 0) filledCount++;

                            // Dynamic receipt requirement
                            $('input[name="cash_receipt"]').prop('required', cash > 0);
                            $('input[name="online_receipt"]').prop('required', online > 0);
                            $('input[name="cheque_number"]').prop('required', cheque > 0);
                            $('input[name="cheque_receipt"]').prop('required', cheque > 0);

                            // Border highlighting
                            $('input[name="cash_amount"], input[name="online_amount"], input[name="cheque_amount"]')
                                .each(function() {
                                    if (!$(this).val() || parseFloat($(this).val()) <= 0) {
                                        $(this).css('border', '1px solid red');
                                    } else {
                                        $(this).css('border', '');
                                    }
                                });

                            if (filledCount >= 2) {
                                $('#multiple-error').remove();
                            }
                        }
                    });

                $('#methodFields').html(html);

                // Attach listener to dynamically created amount fields
                $('input[name="cash_amount"], input[name="online_amount"], input[name="cheque_amount"]').on('input',
                    updateRemainingAmount);

            }

            // Payment status change
            $('#paymentStatus').on('change', function() {
                if ($(this).val() === 'paid') {
                    $('#paidSection').show();
                } else {
                    $('#paidSection').hide();
                    $('#methodFields').html('');
                    $('#paymentMethod').val('');
                    const total = parseFloat($('#overallTotal').val()) || 0;
                    const exchange = parseFloat($('input[name="exchange_amount"]').val()) || 0;
                    $('#remainingAmount').val(total - exchange);
                }
            });

            // Payment method change
            $('#paymentMethod').on('change', function() {
                const method = $(this).val();
                showPaymentFields(method);
            });

            // On page load
            $(document).ready(function() {
                const total = parseFloat($('#overallTotal').val()) || 0;
                const exchange = parseFloat($('input[name="exchange_amount"]').val()) || 0;
                $('#remainingAmount').val(total - exchange);
            });
            /* ========================================
                    Gifted Toggle
               /* ========================================*/
            const giftedYes = document.getElementById('giftedYes');
            const giftedNo = document.getElementById('giftedNo');
            const paymentCard = document.getElementById('paymentCard');
            const paymentStatus = document.getElementById('paymentStatus');

            function setRequired(field, isRequired) {
                if (!field) return;
                if (isRequired) {
                    field.setAttribute('required', true);
                    // Add * to label if not already added
                    const label = field.closest('.form-group').querySelector('label');
                    if (label && !label.querySelector('.text-danger')) {
                        label.innerHTML += ' <span class="text-danger">*</span>';
                    }
                } else {
                    field.removeAttribute('required');
                    // Remove * from label if exists
                    const label = field.closest('.form-group').querySelector('label');
                    if (label) label.innerHTML = label.innerHTML.replace(/ <span class="text-danger">\*<\/span>/,
                        '');
                }
            }

            function togglePaymentCard() {
                if (giftedYes.checked) {
                    // Hide payment section when gifted
                    paymentCard.style.display = 'none';
                    setRequired(paymentStatus, false);
                } else {
                    // Show payment section when not gifted
                    paymentCard.style.display = 'block';
                    setRequired(paymentStatus, true);
                }
            }

            // Initial run
            togglePaymentCard();

            // Event listeners
            giftedYes.addEventListener('change', togglePaymentCard);
            giftedNo.addEventListener('change', togglePaymentCard);

            /* ========================================
                Warranty Lifetime Toggle
            ======================================== */
            const lifetimeRadio = document.getElementById("lifetimeRadio");
            const warrantyFrom = document.getElementById("warrantyFrom");
            const warrantyTo = document.getElementById("warrantyTo");
            let wasSelected = false;

            lifetimeRadio.addEventListener("click", function() {
                if (wasSelected) {
                    this.checked = false;
                    warrantyFrom.disabled = false;
                    warrantyTo.disabled = false;
                    wasSelected = false;
                } else {
                    this.checked = true;
                    warrantyFrom.disabled = true;
                    warrantyTo.disabled = true;
                    wasSelected = true;
                }
            });
        });

        $(document).ready(function() {
            // Hide by default if unpaid is selected initially
            if ($('#paymentStatus').val() === 'unpaid') {
                $('#paidAmountDiv').hide();
            }

            // Listen for changes
            $('#paymentStatus').on('change', function() {
                if ($(this).val() === 'paid') {
                    $('#paidAmountDiv').show();
                } else {
                    $('#paidAmountDiv').hide();
                    $('#paidamount').val(''); // clear input when hidden
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('customer_name');
            const usernameInput = document.getElementById('username');
            const branchCode = document.getElementById('branch_code').value;

            function generateUsername(name) {
                // Remove spaces and convert to uppercase
                return (branchCode + name.replace(/\s+/g, '')).toUpperCase();
            }

            // Initialize username on page load
            usernameInput.value = generateUsername(nameInput.value);

            // Update username on name change
            nameInput.addEventListener('input', function() {
                usernameInput.value = generateUsername(this.value);
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('form').forEach(function(form) {
                let isSubmitting = false;

                form.addEventListener('submit', function(e) {
                    // Prevent double submission
                    if (isSubmitting) {
                        e.preventDefault();
                        return false;
                    }

                    isSubmitting = true;

                    const btn = form.querySelector('button[type="submit"]');
                    if (btn) {
                        btn.disabled = true;
                        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Submitting...';
                    }

                    // ✅ Re-enable button after 5 seconds (in case of validation error or no redirect)
                    setTimeout(() => {
                        isSubmitting = false;
                        if (btn) {
                            btn.disabled = false;
                            btn.innerHTML = 'Submit'; // Change to your original text
                        }
                    }, 5000);
                });
            });
        });
    </script>

@endsection
