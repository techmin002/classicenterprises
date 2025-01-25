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
        });
    </script>



    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@endsection
