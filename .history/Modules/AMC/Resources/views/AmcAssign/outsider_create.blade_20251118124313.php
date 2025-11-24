@extends('setting::layouts.master')

@section('title', 'Outsider Customer Assign AMC')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Outsider Customer Assign AMC</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Outsider Customer Assign AMC</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Outsider Customer Assign AMC</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <form id="amcAssignForm" action="{{ route('amcassign.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <input type="hidden" name="customer_type" value="outsider">

                                <div class="col-md-4">
                                    <label>Customer Name <span class="text-danger">*</span></label>
                                    <input type="text" name="customer_name" class="form-control"
                                        placeholder="Enter Customer Name" required>
                                </div>
                                <div class="col-md-4">
                                    <label>Address <span class="text-danger">*</span></label>
                                    <input type="text" name="address" class="form-control" placeholder="Enter Address"
                                        required>
                                </div>
                                <div class="col-md-4">
                                    <label>Email <small class="text-muted">(optional)</small></label>
                                    <input type="text" name="email" class="form-control" placeholder="Enter Email">
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label>Contact Number<span class="text-danger">*</span></label>
                                    <input type="tel" name="contact" class="form-control"
                                        placeholder="Enter Mobile Number" pattern="\d{10}" maxlength="10" required
                                        oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,10);">
                                </div>
                                <div class="col-md-4 mt-2">
                                    <label>Alternate Number <small class="text-muted">(optional)</small></label>
                                    <input type="tel" name="landline" class="form-control"
                                        placeholder="Enter Alternate Mobile Number" pattern="\d{10}" maxlength="10" required
                                        oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,10);">
                                </div>


                                <div class="col-md-4 mt-2">
                                    <div class="form-group">
                                        <label>Amc Sales<span class="text-danger">*</span></label>
                                        <select name="amc_id" id="amc_id" class="form-control" required>
                                            <option value="" selected disabled>--Select AMC--</option>
                                            @foreach ($amcs as $amc)
                                                <option value="{{ $amc->id }}">{{ $amc->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- AMC -->
                                <div class="col-md-4 mt-2">
                                    <div class="form-group">
                                        <label>AMC <span class="text-danger">*</span></label>
                                        <select name="amc_id" id="amc_id" class="form-control" required>
                                            <option value="" selected disabled>--Select AMC--</option>
                                            @foreach ($amcs as $amc)
                                                <option value="{{ $amc->id }}">{{ $amc->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 mt-2">
                                    <label>Previous Product Name <span class="text-danger">*</span></label>
                                    <input type="tel" name="landline" class="form-control"
                                        placeholder="Enter Alternate Mobile Number" pattern="\d{10}" maxlength="10" required
                                        oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,10);">
                                </div>
                            </div>


                            <!-- Date & Total Amount -->
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Date <span class="text-danger">*</span></label>
                                    <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label>Total Amount <span class="text-danger">*</span></label>
                                    <input type="number" name="amount" id="total_amount" class="form-control" readonly
                                        required>
                                </div>
                            </div>

                            <!-- Payment Section -->
                            <div class="card mt-3">
                                <div class="card-header bg-info text-white">
                                    <h4 class="card-title mb-0">Payment Section</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row align-items-end">
                                        <div class="col-md-6">
                                            <label>Payment Status <span class="text-danger">*</span></label>
                                            <select name="payment_status" id="payment_status" class="form-control"
                                                required>
                                                <option value="">Select Status</option>
                                                <option value="paid">Paid</option>
                                                <option value="unpaid">Unpaid</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6" id="method_col" style="display:none;">
                                            <label>Payment Method <span class="text-danger">*</span></label>
                                            <select name="payment_method" id="payment_method_register"
                                                class="form-control">
                                                <option value="">Select Method</option>
                                                <option value="Cash">Cash</option>
                                                <option value="Online">Online</option>
                                                <option value="Cheque">Cheque</option>
                                                <option value="Multiple">Multiple</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- SINGLE PAYMENT DIVS -->
                                    <!-- CASH -->
                                    <div id="cash_div_register" class="row method-fields" style="display:none;">
                                        <div class="col-md-6 mt-2">
                                            <label>Cash Amount <span class="text-danger">*</span></label>
                                            <input type="number" name="cash_amount" class="form-control">
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <label>Cash Receipt <span class="text-danger">*</span></label>
                                            <input type="file" name="cash_receipt" class="form-control"
                                                accept="image/*">
                                        </div>
                                    </div>

                                    <!-- ONLINE -->
                                    <div id="online_div_register" class="row method-fields" style="display:none;">
                                        <div class="col-md-6 mt-2">
                                            <label>Online Amount <span class="text-danger">*</span></label>
                                            <input type="number" name="online_amount" class="form-control">
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <label>Online Receipt <span class="text-danger">*</span></label>
                                            <input type="file" name="online_receipt" class="form-control"
                                                accept="image/*">
                                        </div>
                                    </div>

                                    <!-- CHEQUE -->
                                    <div id="cheque_div_register" class="row method-fields" style="display:none;">
                                        <div class="col-md-4 mt-2">
                                            <label>Cheque Amount <span class="text-danger">*</span></label>
                                            <input type="number" name="cheque_amount" class="form-control">
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>Cheque Number <span class="text-danger">*</span></label>
                                            <input type="text" name="cheque_number" class="form-control">
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>Cheque Receipt <span class="text-danger">*</span></label>
                                            <input type="file" name="cheque_receipt" class="form-control"
                                                accept="image/*">
                                        </div>
                                    </div>

                                    <!-- MULTIPLE PAYMENT DIV -->
                                    <div id="multiple_div_register" class="row" style="display:none;">
                                        <div class="col-12 mb-2 mt-2">
                                            <div class="alert alert-secondary p-2 mb-3">
                                                <b>Note:</b> Fill at least <b>two</b> payment methods. Total must equal AMC
                                                amount.
                                            </div>
                                        </div>

                                        <!-- MULTIPLE CASH -->
                                        <div class="col-md-6 mt-2">
                                            <label>Cash Amount</label>
                                            <input type="number" name="multi_cash_amount" class="form-control">
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <label>Cash Receipt</label>
                                            <input type="file" name="multi_cash_receipt" class="form-control"
                                                accept="image/*">
                                        </div>

                                        <!-- MULTIPLE ONLINE -->
                                        <div class="col-md-6 mt-2">
                                            <label>Online Amount</label>
                                            <input type="number" name="multi_online_amount" class="form-control">
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <label>Online Receipt</label>
                                            <input type="file" name="multi_online_receipt" class="form-control"
                                                accept="image/*">
                                        </div>

                                        <!-- MULTIPLE CHEQUE -->
                                        <div class="col-md-4 mt-2">
                                            <label>Cheque Amount</label>
                                            <input type="number" name="multi_cheque_amount" class="form-control">
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>Cheque Number</label>
                                            <input type="text" name="multi_cheque_number" class="form-control">
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>Cheque Receipt</label>
                                            <input type="file" name="multi_cheque_receipt" class="form-control"
                                                accept="image/*">
                                        </div>

                                        <!-- Validation message -->
                                        <div class="col-12 mt-2">
                                            <span id="multiple_error" class="text-danger fw-bold"
                                                style="display:none;"></span>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Message Section -->
                            <div class="card mt-3">
                                <div class="card-header bg-primary text-white">
                                    <h4 class="card-title mb-0">Message</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row align-items-end">
                                        <div class="col-md-12">
                                            <label>Remark <span class="text-danger">*</span></label>
                                            <textarea name="message" id="" class="form-control summernote" required></textarea>
                                        </div>
                                        <div class="col-md-6" id="method_col" style="display:none;">
                                            <label>Payment Method <span class="text-danger">*</span></label>
                                            <select name="payment_method" id="payment_method_register"
                                                class="form-control">
                                                <option value="">Select Method</option>
                                                <option value="Cash">Cash</option>
                                                <option value="Online">Online</option>
                                                <option value="Cheque">Cheque</option>
                                                <option value="Multiple">Multiple</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-info text-white">
                                <i class="fa fa-save"></i> Save
                            </button>
                            <a href="{{ route('amcassign.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
    <script>
        $(document).ready(function() {
            // Fetch AMC amount
            $('#amc_id').on('change', function() {
                let amcId = $(this).val();
                if (!amcId) return;
                $.get('/get-amc-amount/' + amcId, function(res) {
                    $('#total_amount').val(res.amount);
                });
            });

            // Payment status toggle
            $('#payment_status').on('change', function() {
                if ($(this).val() === 'paid') {
                    $('#method_col').slideDown();
                } else {
                    $('#method_col').slideUp();
                    $('#payment_method_register').val('');
                    $('.method-fields').hide().find('input').prop('required', false);
                    $('#multiple_div_register').hide().find('input').prop('required', false);
                    $('#multiple_error').hide();
                }
            });

            // Payment method selection
            $('#payment_method_register').on('change', function() {
                let method = $(this).val();
                $('.method-fields').hide().find('input').prop('required', false);
                $('#multiple_div_register').hide().find('input').prop('required', false);
                $('#multiple_error').hide().text('');

                if (method === 'Cash') $('#cash_div_register').show().find('input').prop('required', true);
                else if (method === 'Online') $('#online_div_register').show().find('input').prop(
                    'required', true);
                else if (method === 'Cheque') $('#cheque_div_register').show().find('input').prop(
                    'required', true);
                else if (method === 'Multiple') $('#multiple_div_register').show();
            });

            // Restrict single amount <= total
            $(document).on('input', 'input[name$="_amount"]', function() {
                let total = parseFloat($('#total_amount').val()) || 0;
                let val = parseFloat($(this).val()) || 0;
                if (val > total) $(this).val(total);
            });

            // Live remaining restriction for multiple payment
            $('#multiple_div_register input[name$="_amount"]').on('input', function() {
                let total = parseFloat($('#total_amount').val()) || 0;
                let cash = parseFloat($('#multiple_div_register input[name="multi_cash_amount"]').val()) ||
                    0;
                let online = parseFloat($('#multiple_div_register input[name="multi_online_amount"]')
                    .val()) || 0;
                let cheque = parseFloat($('#multiple_div_register input[name="multi_cheque_amount"]')
                    .val()) || 0;

                let currentName = $(this).attr('name');
                let sumOthers = 0;
                if (currentName !== 'multi_cash_amount') sumOthers += cash;
                if (currentName !== 'multi_online_amount') sumOthers += online;
                if (currentName !== 'multi_cheque_amount') sumOthers += cheque;

                let remaining = total - sumOthers;
                let currentVal = parseFloat($(this).val()) || 0;
                if (currentVal > remaining) $(this).val(remaining);
            });

            // Multiple payment validation on submit
            $('#amcAssignForm').on('submit', function(e) {
                let total = parseFloat($('#total_amount').val()) || 0;
                let status = $('#payment_status').val();
                let method = $('#payment_method_register').val();

                if (status === 'unpaid') return true;

                if (method === 'Multiple') {
                    let cash = parseFloat($('#multiple_div_register input[name="multi_cash_amount"]')
                        .val()) || 0;
                    let online = parseFloat($('#multiple_div_register input[name="multi_online_amount"]')
                        .val()) || 0;
                    let cheque = parseFloat($('#multiple_div_register input[name="multi_cheque_amount"]')
                        .val()) || 0;

                    let filled = [cash, online, cheque].filter(v => v > 0).length;
                    let totalSum = cash + online + cheque;

                    $('#multiple_error').hide().text('');
                    if (filled < 2) {
                        e.preventDefault();
                        $('#multiple_error').text('Please fill at least TWO payment methods.').show();
                        return false;
                    }
                    if (totalSum !== total) {
                        e.preventDefault();
                        $('#multiple_error').text('Sum of all payment amounts must equal AMC amount (' +
                            total + '). Current: ' + totalSum).show();
                        return false;
                    }
                }
            });
        });
    </script>
@endsection
