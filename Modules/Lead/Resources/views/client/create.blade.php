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
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create Customer</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Customers Detail's</h3>
                            </div>

                            <form action="{{ route('leads.convert.store') }}" id="expenseForm" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="container">
                                        <div class="row gy-3">
                                            <div class="mt-3 col-lg-6">
                                                <label>Name <strong class="text-danger">*</strong></label>
                                                <input class="form-control" placeholder="Enter name" type="text"
                                                    value="{{ $lead->name }}" name="name" id="name">
                                            </div>
                                            <div class="mt-3 col-lg-6">
                                                <label>Email <strong class="text-danger">*</strong></label>
                                                <input class="form-control" type="email" value="{{ $lead->email }}"
                                                    name="email">
                                            </div>
                                            <input type="hidden" value="{{ $lead->id }}" name="lead_id">
                                            <div class="mt-3 col-lg-6">
                                                <label>Contact Number <strong class="text-danger">*</strong></label>
                                                <input class="form-control" placeholder="Enter mobile number" type="tel"
                                                    value="{{ $lead->mobile }}"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);"
                                                    pattern="\d{10}" maxlength="10" name="mobile" required>
                                            </div>
                                            <div class="mt-3 col-lg-6">
                                                <label>Alternate Contact Number <small
                                                        class="text-success">(Optional)</small></label>
                                                <input class="form-control" placeholder="Alternate number" type="tel"
                                                    value="{{ $lead->landline }}"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);"
                                                    pattern="\d{10}" maxlength="10" name="landline">
                                            </div>
                                            <div class="mt-3 col-lg-12">
                                                <label>Address <strong class="text-danger">*</strong></label>
                                                <input class="form-control" type="text" value="{{ $lead->address }}"
                                                    name="address">
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
                                                <label>Product <strong class="text-danger">*</strong></label>
                                                <div id="productContainer"></div>
                                                <button type="button" id="addProduct" class="badge badge-primary mt-3">Add
                                                    Product</button>
                                            </div>
                                        </div>

                                        <hr>
                                        <label>Accessories</label>
                                        <div id="accessoryContainer"></div>
                                        <button type="button" id="addAccessory" class="badge badge-primary mt-3">Add
                                            Accessory</button>

                                        <hr>
                                        <div class="form-group">
                                            <label>Remark <small>(optional)</small></label>
                                            <textarea name="remark" class="form-control" required></textarea>
                                        </div>

                                        <hr>
                                        <div class="form-group">
                                            <label>Exchange <strong class="text-danger">*</strong></label><br>
                                            <label><input type="radio" name="is_exchange" value="yes" id="exchangeYes">
                                                Yes</label>&nbsp;&nbsp;
                                            <label><input type="radio" name="is_exchange" value="no" id="exchangeNo"
                                                    checked> No</label>
                                        </div>

                                        <div id="exchangeSection" style="display: none;">
                                            <label>Exchange Items</label>
                                            <div id="exchangeContainer"></div>
                                            <button type="button" id="addExchange" class="badge badge-primary mt-3">New</button>

                                            <div class="mt-3">
                                                <label>Total Exchange Amount:</label>
                                                <input type="text" name="total_exchange" id="totalExchangeAmount"
                                                    class="form-control" readonly />
                                            </div>
                                        </div>

                                        <div class="mt-3">
                                            <label>Overall Total:</label>
                                            <input type="text" name="grand_total" id="overallTotal"
                                                class="form-control" readonly />
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer justify-content-start">
                                    <button type="submit" name="submit" class="btn btn-success">Save Lead</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        $(document).ready(function() {
            let productIndex = 0,
                accessoryIndex = 0,
                exchangeIndex = 0;

            function calculateRowTotal(rowId, type) {
                const qty = $(`#${type}-${rowId} .${type}-qty`).val();
                const price = $(`#${type}-${rowId} .${type}-price`).val();
                const rowTotal = qty * price;
                $(`#${type}-${rowId} .${type}-row-total`).val(rowTotal.toFixed(2));
                calculateOverallTotal();
            }

            function calculateOverallTotal() {
                let total = 0;
                $('.product-row-total, .accessory-row-total').each(function() {
                    total += parseFloat($(this).val()) || 0;
                });

                const exchange = parseFloat($('#totalExchangeAmount').val()) || 0;
                total -= exchange;

                $('#overallTotal').val(total.toFixed(2));
            }

            function calculateTotalExchange() {
                let exchangeTotal = 0;
                $('.exchange-price').each(function() {
                    exchangeTotal += parseFloat($(this).val()) || 0;
                });
                $('#totalExchangeAmount').val(exchangeTotal.toFixed(2));
                calculateOverallTotal();
            }

            function initializeSelect(selector, type) {
                const endpoint = type === 'product' ? '/getproducts' : '/accessories';
                $(selector).select2({
                    theme: 'bootstrap4',
                    placeholder: `Search ${type}`,
                    ajax: {
                        url: endpoint,
                        dataType: 'json',
                        delay: 250,
                        data: params => ({
                            search: params.term
                        }),
                        processResults: data => ({
                            results: data.map(item => ({
                                id: item.id,
                                text: item.name,
                                price: item.sales_price,
                                units: item.units
                            }))
                        }),
                        cache: true
                    }
                }).on('select2:select', function(e) {
                    const data = e.params.data;
                    const rowId = $(this).closest(`.${type}-row`).attr('id');
                    $(`#${rowId} .${type}-price`).val(data.price);
                    $(`#${rowId} .${type}-units`).val(data.units);
                    calculateRowTotal(rowId.replace(`${type}-`, ''), type);
                });
            }

            $('#addProduct').on('click', function() {
                productIndex++;
                const row = `
                    <div class="row mb-2 product-row" id="product-${productIndex}">
                        <div class="col-md-4"><select class="form-control product-select" name="products_id[]" id="product-select-${productIndex}"></select></div>
                        <div class="col-md-1"><input type="number" name="products_qty[]" value="1" class="form-control product-qty"></div>
                        <div class="col-md-1"><input type="text" name="products_units[]" class="form-control product-units" readonly></div>
                        <div class="col-md-2"><input type="number" name="products_price[]" class="form-control product-price"></div>
                        <div class="col-md-2"><input type="text" name="products_total[]" class="form-control product-row-total" readonly></div>
                        <div class="col-md-2"><button type="button" class="badge badge-danger removeProduct">X</button></div>
                    </div>`;
                $('#productContainer').append(row);
                initializeSelect(`#product-select-${productIndex}`, 'product');
            });

            $('#addAccessory').on('click', function() {
                accessoryIndex++;
                const row = `
                    <div class="row mb-2 accessory-row" id="accessory-${accessoryIndex}">
                        <div class="col-md-4"><select class="form-control accessory-select" name="accessories_id[]" id="accessory-select-${accessoryIndex}"></select></div>
                        <div class="col-md-1"><input type="number" name="accessories_qty[]" value="1" class="form-control accessory-qty"></div>
                        <div class="col-md-1"><input type="text" name="accessories_units[]" class="form-control accessory-units" readonly></div>
                        <div class="col-md-2"><input type="number" name="accessories_price[]" class="form-control accessory-price"></div>
                        <div class="col-md-2"><input type="text" name="accessories_total[]" class="form-control accessory-row-total" readonly></div>
                        <div class="col-md-2"><button type="button" class="badge badge-danger removeAccessory">X</button></div>
                    </div>`;
                $('#accessoryContainer').append(row);
                initializeSelect(`#accessory-select-${accessoryIndex}`, 'accessory');
            });

            $('#addExchange').on('click', function() {
                exchangeIndex++;
                const row = `
                    <div class="row mb-2 exchange-row" id="exchange-${exchangeIndex}">
                        <div class="col-md-5"><input type="text" name="exchange_names[]" class="form-control" placeholder="Enter Exchange Item Name"></div>
                        <div class="col-md-4"><input type="number" name="exchange_prices[]" class="form-control exchange-price" placeholder="Enter Price"></div>
                        <div class="col-md-2"><button type="button" class="badge badge-danger removeExchange">X</button></div>
                    </div>`;
                $('#exchangeContainer').append(row);
            });

            $(document).on('input', '.product-qty, .product-price', function() {
                const rowId = $(this).closest('.product-row').attr('id').replace('product-', '');
                calculateRowTotal(rowId, 'product');
            });

            $(document).on('input', '.accessory-qty, .accessory-price', function() {
                const rowId = $(this).closest('.accessory-row').attr('id').replace('accessory-', '');
                calculateRowTotal(rowId, 'accessory');
            });

            $(document).on('input', '.exchange-price', function() {
                calculateTotalExchange();
            });

            $(document).on('click', '.removeProduct', function() {
                $(this).closest('.product-row').remove();
                calculateOverallTotal();
            });

            $(document).on('click', '.removeAccessory', function() {
                $(this).closest('.accessory-row').remove();
                calculateOverallTotal();
            });

            $(document).on('click', '.removeExchange', function() {
                $(this).closest('.exchange-row').remove();
                calculateTotalExchange();
            });

            $('input[name="is_exchange"]').change(function() {
                if ($(this).val() === 'yes') {
                    $('#exchangeSection').show();
                } else {
                    $('#exchangeSection').hide();
                    $('#exchangeContainer').empty();
                    $('#totalExchangeAmount').val(0);
                    calculateOverallTotal();
                }
            });
        });
    </script>

    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        });
    </script>
@endsection
