@extends('setting::layouts.master')

@section('title', 'Installation Create')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Installation Create</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Installation Create</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Installation Create</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <form action="{{ route('store.installation.customer',$customer['id']) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Customer Detail's</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <strong> Name:</strong> <input class="form-control" type="text" readonly
                                                value="{{ ucfirst($customer->lead['name']) }}">
                                        </div>
                                        <div class="col-md-4">
                                            <strong> Contact :</strong> <input class="form-control" type="text" readonly
                                                value="{{ ucfirst($customer->lead['mobile']) }}">
                                        </div>
                                        <div class="col-md-4">
                                            <strong> Address :</strong> <input class="form-control" type="text" readonly
                                                value="{{ ucfirst($customer->lead['address']) }}">
                                        </div>

                                    </div>
                                    <input type="hidden" value="{{ $customer->lead['id'] }}" name="lead_id">
                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <strong> Lead By:</strong>
                                            <input class="form-control" type="text" value="{{ $leadby['name'] }}" readonly
                                                name="install_date">
                                        </div>
                                        <div class="col-md-4">
                                            <strong> Converted By :</strong>
                                             <select name="converted_by" id="" class="form-control">
                                                <option value="">Select Staff</option>
                                                @foreach ($staffs as $staff)
                                                <option value="{{ $staff['id'] }}">{{ $staff['name'] }}</option>
                                                @endforeach
                                             </select>
                                        </div>
                                        <div class="col-md-4">
                                            <strong> Install Date :</strong> <input class="form-control" type="date"
                                                name="install_date">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Product Detail's</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row gy-3">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="product_name">Product </label>
                                                @foreach ($customerMachines as $key => $machine)
                                                    <div class="row g-3 align-items-center mb-3 product-row"
                                                        id="product-{{ $key }}">
                                                        <div class="col-md-4">
                                                            <select class="form-control product-select" name="products_id[]"
                                                                id="product-select-{{ $key }}">
                                                                <option value="{{ $machine->product['id'] }}" selected
                                                                    >{{ $machine->product['name'] }} </option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <input type="number" name="products_qty[]"
                                                                value="{{ $machine->product_qty }}" min="1"
                                                                class="form-control product-qty" placeholder="Quantity">
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
                                                        <div class="col-md-2">
                                                            <button type="button"
                                                                class="badge badge-danger removeProduct">X</button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                <div id="productContainer">
                                                    <!-- Product rows will be appended here -->
                                                </div>
                                                <button type="button" id="addProduct" class="badge badge-primary">Add
                                                    Product</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!--accessories start here-->
                                    <hr>
                                    <label for="">Accessories </label>
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
                                                    class="form-control accessory-qty" min="1" placeholder="Quantity">
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
                                            <div class="col-md-2">
                                                <button type="button"
                                                    class="badge badge-danger removeAccessory">X</button>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div id="accessoryContainer">
                                        <!-- Accessory rows will be appended here -->
                                    </div>
                                    <button type="button" id="addAccessory" class="badge badge-primary">Add
                                        Accessory</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Payment Detail's</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Total Amount</label>
                                                <input type="text" name="grand_total" id="overallTotal"
                                                    class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Paid Amount</label>
                                                <input type="text" name="paid_amount" class="form-control"
                                                    placeholder="Paid Amount">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Date</label>
                                                <input type="date" name="paid_date" class="form-control"
                                                    placeholder="Date">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Payment Methods</label> <br>
                                                <input type="radio" name="method" value="cash" checked
                                                    class="payment-method"> Cash &nbsp;
                                                <input type="radio" name="method" value="online"
                                                    class="payment-method"> Online &nbsp;
                                                <input type="radio" name="method" value="cheque"
                                                    class="payment-method"> Cheque &nbsp;
                                            </div>
                                        </div>
                                        <!-- Placeholder for dynamically adding cheque field -->
                                        <div class="col-md-12" id="chequeContainer"></div>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">

                                <div class="card-body">
                                    <textarea name="remarks" class="form-control" id="" cols="30" rows="3"
                                        placeholder="Enter Remarks"></textarea>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <button class="btn btn-success w-50 p-2" type="submit">Save Change</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </section>
    </div>
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
                    <input type="number" name="products_qty[]" value="1" class="form-control product-qty" placeholder="Quantity">
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
                <div class="col-md-2">
                    <button type="button" class="badge badge-danger removeProduct">X</button>
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
                    <input type="number" name="accessories_qty[]" value="1" class="form-control accessory-qty" placeholder="Quantity">
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
                <div class="col-md-2">
                    <button type="button" class="badge badge-danger removeAccessory">X</button>
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
    </script>
    <!-- jQuery Script -->
    <script>
        $(document).ready(function() {
            $('.payment-method').on('change', function() {
                if ($(this).val() === 'cheque') {
                    // Append cheque number field dynamically
                    $('#chequeContainer').html(`
                        <div class="form-group">
                            <label for="">Cheque No.</label> <br>
                            <input type="text" name="cheque_no" placeholder="Enter Cheque Number" class="form-control">
                        </div>
                    `);
                } else {
                    // Remove cheque field if another method is selected
                    $('#chequeContainer').html('');
                }
            });
        });
    </script>

@endsection
