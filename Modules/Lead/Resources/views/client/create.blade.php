@extends('setting::layouts.master')

@section('title', 'Create Customer')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active"> Create Customer</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1> Create Customer</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active"> Create Customer</li>
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
                            <div class="card-header">

                                <h3 class="card-title"> Customers Detail's </h3>
                            </div>
                            <!-- /.card-header -->
                            <form action="{{ route('leads.convert.store') }}" id="expenseForm" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="container">
                                        <div class="row gy-3">


                                            <div class="mt-3 col-lg-6">
                                                <label class="form-label12">Name <strong
                                                        class="text-danger">*</strong></label>
                                                <input class="form-control" placeholder="Enter name" type="text"
                                                    value="{{ $lead->name }}" name="name" id="name">
                                            </div>
                                            <div class="mt-3 col-lg-6">
                                                <label class="form-label12">Email <strong
                                                        class="text-danger">*</strong></label>
                                                <input class="form-control" placeholder="" type="email"
                                                    value="{{ $lead->email }}" name="email">
                                            </div>
                                            <input type="hidden" value="{{ $lead->id }}" name="lead_id">
                                            <div class="mt-3 col-lg-6">
                                                <label class="form-label12">Contact Number <strong
                                                        class="text-danger">*</strong></label>
                                                <input class="form-control" placeholder="Enter mobile number" type="tel"
                                                    value="{{ $lead->mobile }}"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);"
                                                    pattern="\d{10}"maxlength="10" name="mobile" id="mobile" required
                                                    title="Please enter exactly 10 digits">
                                            </div>

                                            <div class="mt-3 col-lg-6">
                                                <label class="form-label12">Alternate Contact Number <small
                                                        class="text-success">(Optional)</small></label>
                                                <input class="form-control" placeholder="Enter alternate mobile number"
                                                    type="tel" value="{{ $lead->landline }}"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);"
                                                    pattern="\d{10}"maxlength="10" name="landline" id="landline"
                                                    title="Please enter exactly 10 digits">
                                            </div>

                                            <div class="mt-3 col-lg-12">
                                                <label class="form-label12">Address <strong
                                                        class="text-danger">*</strong></label>
                                                <input class="form-control" placeholder="" type="text"
                                                    value="{{ $lead->address }}" name="address" id="address">
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <hr>
                                <div class="card-header">
                                    <h3 class="card-title">Product Detail's</h3>
                                </div>
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row gy-3">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="product_name">Product <strong
                                                            class="text-danger">*</strong></label>
                                                            <div id="productContainer">
                                                                <!-- Product rows will be appended here -->
                                                            </div>
                                                            <button type="button" id="addProduct" class="badge badge-primary mt-3">Add
                                                                Product</button>
                                                </div>


                                            </div>

                                        </div>
                                        <!--accessories start here-->
                                        <hr>
                                        <label for="">Accessories </label>

                                        <div id="accessoryContainer">
                                            <!-- Accessory rows will be appended here -->
                                        </div>
                                        <button type="button" id="addAccessory" class="badge badge-primary mt-3">Add
                                            Accessory</button>




                                        <div class="mt-3">
                                            <label for="overallTotal">Overall Total: </label>
                                            <input type="text" name="grand_total" id="overallTotal" class="form-control"
                                                readonly />
                                        </div>

                                        <!--accessories end here-->
                                        <div class="form-group">
                                            <label for="remark">Remark <small>(optional)</small></label>
                                            <textarea name="remark" class="form-control" required></textarea>

                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-start">

                                    <button type="submit" name="submit" id="btnSubmit" class="btn btn-success">Save
                                        Lead</button>

                                    <button type="cancel" data-dismiss="modal" class="btn btn-danger">Cancel</button>
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
                                    price: item.sales_price
                                }))
                            };
                        },
                        cache: true
                    }
                }).on('select2:select', function(e) {
                    const selectedData = e.params.data;
                    const rowId = $(this).closest(`.${type}-row`).attr('id');
                    $(`#${rowId} .${type}-price`).val(selectedData.price);
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
                        <div class="col-md-2">
                            <input type="number" name="products_qty[]" value="1" class="form-control product-qty" placeholder="Quantity">
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
                        <div class="col-md-2">
                            <input type="number" name="accessories_qty[]" value="1" class="form-control accessory-qty" placeholder="Quantity">
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
        });
    </script>

    {{-- <script>
        $(document).ready(function() {
            let accessoryIndex = 1; // Start with the first row
            let overallTotal = 0; // Variable to store the overall total

            // Function to initialize Select2 with AJAX for dynamic accessory dropdowns
            function initializeSelect(selector) {
                $(selector).select2({
                    theme: 'bootstrap4',
                    placeholder: 'Search for an accessory',
                    ajax: {
                        url: '/accessories', // Replace with your actual endpoint
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                search: params.term // Pass the search term to the server
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: data.map(item => ({
                                    id: item.id,
                                    text: item.name,
                                    price: item.sales_price
                                }))
                            };
                        },
                        cache: true
                    }
                }).on('select2:select', function(e) {
                    const selectedData = e.params.data;
                    const rowId = $(this).closest('.accessory-row').attr('id');
                    $(`#${rowId} .price`).val(selectedData.price);
                    calculate(rowId); // Recalculate total when accessory is selected
                });
            }

            // Initialize Select2 for the default row
            initializeSelect(`#accessory-${accessoryIndex}`);

            // Function to append a new accessory row
            function appendAccessoryRow() {
                accessoryIndex++;
                const row = `
                    <div class="row g-3 align-items-center mb-3 accessory-row" id="row-${accessoryIndex}">
                        <div class="col-md-3">
                            <select class="form-control accessory-select" name="accessories_id[]" id="accessory-${accessoryIndex}">
                                <option value="">Search and select an accessory</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="number" name="accessories_qty[]"  class="form-control qty" placeholder="Quantity" id="qty-${accessoryIndex}" />
                        </div>
                        <div class="col-md-3">
                            <input type="number" name="accessories_price[]" class="form-control price" placeholder="Price" id="price-${accessoryIndex}" />
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="accessories_total[]" class="form-control row-total" id="row-total-${accessoryIndex}" readonly />
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-danger removeAccessory" data-row="${accessoryIndex}">X</button>
                        </div>
                    </div>`;
                $('#accessoryContainer').append(row);
                initializeSelect(`#accessory-${accessoryIndex}`);
            }

            // Add Accessory Button Click
            $('#addAccessory').on('click', function() {
                appendAccessoryRow(); // Append a new row
            });

            // Remove Accessory Button Click
            $(document).on('click', '.removeAccessory', function() {
                const rowId = $(this).data('row');
                $(`#row-${rowId}`).remove();
                calculateOverallTotal(); // Recalculate overall total after removal
            });

            // Calculate total for the row
            function calculate(rowId) {
                const qty = $(`#row-${rowId} .qty`).val();
                const price = $(`#row-${rowId} .price`).val();
                const rowTotal = qty * price;

                $(`#row-${rowId} .row-total`).val(rowTotal.toFixed(2)); // Update row total

                calculateOverallTotal(); // Recalculate overall total
            }

            // Calculate the overall total
            function calculateOverallTotal() {
                overallTotal = 0;
                $('.row-total').each(function() {
                    const rowTotal = parseFloat($(this).val()) || 0;
                    overallTotal += rowTotal;
                });

                // Add the backend price to the overall total
                const backendPrice = parseFloat($('#backend_price').val()) || 0;
                overallTotal += backendPrice;

                $('#overallTotal').val(overallTotal.toFixed(2)); // Update overall total
            }

            // Watch for changes in quantity or price to trigger calculation
            $(document).on('input', '.qty, .price', function() {
                const rowId = $(this).closest('.accessory-row').attr('id').replace('row-', '');
                calculate(rowId); // Call calculate for each changed row
            });

            // Watch for changes in backend price to trigger overall total calculation
            $('#backend_price').on('input', function() {
                calculateOverallTotal(); // Recalculate overall total when backend price changes
            });

            // Get Accessory Data Button Click (if needed)
            $('#getAccessoryData').on('click', function() {
                const accessoryData = [];
                $('.accessory-row').each(function() {
                    const rowId = $(this).attr('id');
                    const accessoryId = $(this).find('.accessory-select').val();
                    const qty = $(this).find('.qty').val();
                    const price = $(this).find('.price').val();
                    if (accessoryId && qty && price) {
                        accessoryData.push({
                            accessory_id: accessoryId,
                            qty: qty,
                            price: price
                        });
                    }
                });
                console.log(accessoryData); // Log the collected data
                // Optional: Send the accessoryData via AJAX to the server
            });
        });
    </script> --}}


    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    {{-- <script>
        $(document).ready(function() {
            let accessoryIndex = 1; // Start with the first row

            // Function to initialize Select2 with AJAX for dynamic accessory dropdowns
            function initializeSelect(selector) {
                $(selector).select2({
                    theme: 'bootstrap4',
                    placeholder: 'Search for an accessory',
                    ajax: {
                        url: '/accessories', // Replace with your actual endpoint
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                search: params.term // Pass the search term to the server
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: data.map(item => ({
                                    id: item.id,
                                    text: item.name,
                                    price: item.sales_price
                                }))
                            };
                        },
                        cache: true
                    }
                }).on('select2:select', function(e) {
                    const selectedData = e.params.data;
                    const rowId = $(this).closest('.accessory-row').attr('id');
                    $(`#${rowId} .price`).val(selectedData.price);
                });
            }

            // Initialize Select2 for the default row
            initializeSelect(`#accessory-${accessoryIndex}`);

            // Function to append a new accessory row
            function appendAccessoryRow() {
                accessoryIndex++;
                const row = `
            <div class="row g-3 align-items-center mb-3 accessory-row" id="row-${accessoryIndex}">
                <div class="col-md-5">
                    <select class="form-control accessory-select" id="accessory-${accessoryIndex}">
                        <option value="">Search and select an accessory</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" class="form-control qty" placeholder="Quantity" id="qty-${accessoryIndex}" />
                </div>
                <div class="col-md-3">
                    <input type="number" class="form-control price" placeholder="Price" id="price-${accessoryIndex}"  />
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger removeAccessory" data-row="${accessoryIndex}">X</button>
                </div>
            </div>`;
                $('#accessoryContainer').append(row);
                initializeSelect(`#accessory-${accessoryIndex}`);
            }

            // Add Accessory Button Click
            $('#addAccessory').on('click', function() {
                appendAccessoryRow(); // Append a new row
            });

            // Remove Accessory Button Click
            $(document).on('click', '.removeAccessory', function() {
                const rowId = $(this).data('row');
                $(`#row-${rowId}`).remove();
            });

            // Get Accessory Data Button Click
            $('#getAccessoryData').on('click', function() {
                const accessoryData = [];
                $('.accessory-row').each(function() {
                    const rowId = $(this).attr('id');
                    const accessoryId = $(this).find('.accessory-select').val();
                    const qty = $(this).find('.qty').val();
                    const price = $(this).find('.price').val();
                    if (accessoryId && qty && price) {
                        accessoryData.push({
                            accessory_id: accessoryId,
                            qty: qty,
                            price: sales_price
                        });
                    }
                });
                console.log(accessoryData); // Log the collected data
                // Optional: Send the accessoryData via AJAX to the server
            });
        });
    </script> --}}
@endsection
