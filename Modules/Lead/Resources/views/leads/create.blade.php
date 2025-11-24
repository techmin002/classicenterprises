<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #08A4A4; color: #fff;">
                <h1 class="modal-title fs-5">Create Lead</h1>
            </div>
            <form action="{{ route('leads.store') }}" id="expenseForm" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="row gy-3">
                            {{-- {{ session('branch_id') }} --}}
                            {{-- Name --}}
                            <div class="col-lg-6">
                                <label class="form-label12">Name</label>
                                <input class="form-control" placeholder="Enter name" type="text" name="name"
                                    id="name" required>
                            </div>

                            {{-- Email --}}
                            <div class="col-lg-6">
                                <label class="form-label12">Email</label>
                                <input class="form-control" type="email" name="email">
                            </div>

                            {{-- Contact --}}
                            <div class="col-lg-6">
                                <label class="form-label12 mt-2">Contact Number</label>
                                <input class="form-control" placeholder="Enter mobile number" type="tel"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);"
                                    pattern="\d{10}" maxlength="10" name="mobile" required>
                            </div>

                            {{-- Alternate --}}
                            <div class="col-lg-6">
                                <label class="form-label12 mt-2">Alternate Contact Number</label>
                                <input class="form-control" placeholder="Enter alternate mobile number" type="tel"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);"
                                    maxlength="10" name="landline">
                            </div>

                            <input type="hidden" name="type" value="{{ $type }}">

                            {{-- Lead Source --}}
                            <div class="col-lg-6">
                                <label class="form-label12 mt-2">Lead Source</label>
                                <select name="lead_source" class="form-control" required>
                                    <option value="" selected disabled>Select Lead Source</option>
                                    <option value="facebook">Facebook</option>
                                    <option value="instagram">Instagram</option>
                                    <option value="whatsapp">WhatsApp</option>
                                    <option value="staff">Staff</option>
                                    <option value="counter">Counter</option>
                                    <option value="customer">Customer Refer</option>
                                </select>
                            </div>

                            {{-- Next Followup --}}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mt-2">Next Followup Date:</label>
                                    <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input" name="date_time"
                                            data-target="#reservationdatetime" required />
                                        <div class="input-group-append" data-target="#reservationdatetime"
                                            data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Dynamic containers --}}
                            <div class="col-lg-12" id="staff-select-container" style="display:none;"></div>
                            <div class="col-lg-12" id="customer-type-container" style="display:none;"></div>
                            <div class="col-lg-12" id="customer-select-container" style="display:none;"></div>
                            <div class="col-lg-12" id="manual-input-container" style="display:none;"></div>


                            {{-- Address --}}
                            <div class="col-lg-12">
                                <label class="form-label12">Address</label>
                                <input class="form-control" type="text" name="address" required>
                            </div>

                            {{-- Installation Category --}}
                            <div class="col-lg-6">
                                <label class="form-label12 mt-2">Installation Category</label>
                                <select name="installation_category" class="form-control select2-modal">
                                    <option value="" disabled selected>Select Installation Category</option>
                                    <option value="retailler">Retail</option>
                                    <option value="commercial">Commercial</option>
                                    <option value="industrial">Industrial</option>
                                </select>
                                <div class="invalid-feedback">Select Installation Category or Sales Category.</div>
                            </div>


                            {{-- Sales Category --}}
                            <div class="col-lg-6">
                                <label class="form-label12 mt-2">Sales Category</label>
                                <select name="sales_type" class="form-control select2-modal">
                                    <option value="" disabled selected>Select Sales Category</option>
                                    <option value="counter_sales">Counter Sales</option>
                                    <option value="retailler">Retailer</option>
                                    <option value="wholeseller">Wholeseller</option>
                                </select>
                                <div class="invalid-feedback">Select Sales Category or Installation Category.</div>
                            </div>

                            {{-- Message --}}
                            <div class="col-lg-12">
                                <label class="form-label12 mt-2">Message</label>
                                <textarea name="message" class="form-control" required></textarea>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-start">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <button type="button" data-dismiss="modal" class="btn btn-danger">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- JS --}}
<script>
    $(document).ready(function() {
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};

        let selectedCustomerId = null;
        let selectedStaffId = null;

        // Lead Source change
        $('select[name="lead_source"]').on('change', function() {
            let leadSource = $(this).val();
            $('#staff-select-container, #customer-type-container, #customer-select-container, #manual-input-container')
                .empty().hide();

            if (leadSource === 'staff') {
                $.getJSON("{{ route('get.staff') }}", function(data) {
                    let html = `<div class="mt-2">
                        <label class="form-label12">Select Staff</label>
                        <select name="staff_id" class="form-control select2-modal staff-select" required>
                            <option value="" selected disabled>Select Staff</option>`;
                    $.each(data, function(i, staff) {
                        html += `<option value="${staff.id}">${staff.name}</option>`;
                    });
                    html += `</select></div>`;
                    $('#staff-select-container').html(html).show();
                    initSelect2InsideModal();
                });
            }

            if (leadSource === 'customer') {
                let typeHtml = `<div class="mt-2">
                    <label class="form-label12">Customer Type</label>
                    <select name="customer_type" class="form-control" id="customer-type-select" required>
                        <option value="" selected disabled>Select Type</option>
                        <option value="register">Register</option>
                        <option value="not_register">Not Register</option>
                    </select>
                </div>`;
                $('#customer-type-container').html(typeHtml).show();
            }
        });

        // Customer Type change
        $(document).on('change', '#customer-type-select', function() {
            let customerType = $(this).val();
            $('#customer-select-container, #manual-input-container').empty().hide();

            if (customerType === 'register') {
                $.getJSON("{{ route('get.customer') }}", function(data) {
                    let html = `<div class="mt-2">
                        <label class="form-label12">Select Registered Customer</label>
                        <select name="customer_id" class="form-control select2-modal customer-select" required>
                            <option value="" selected disabled>Select Customer</option>`;
                    $.each(data, function(i, customer) {
                        html +=
                            `<option value="${customer.id}">${customer.name} - ${customer.mobile}</option>`;
                    });
                    html += `</select></div>`;
                    $('#customer-select-container').html(html).show();
                    initSelect2InsideModal();
                });
            }

            if (customerType === 'not_register') {
                let manualHtml = `<div class="row mt-2">
                    <div class="col-lg-6">
                        <label class="form-label12">Customer Name</label>
                        <input type="text" name="manual_customer_name" class="form-control" placeholder="Enter Name" required>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label12">Customer Mobile</label>
                        <input type="tel" name="manual_customer_mobile" class="form-control" placeholder="Enter Mobile" maxlength="10" required>
                    </div>
                </div>`;
                $('#manual-input-container').html(manualHtml).show();
            }
        });

        // ✅ Validation: at least one of Sales/Installation must be selected
        $('#expenseForm').on('submit', function(e) {
            let salesType = $('select[name="sales_type"]').val();
            let installationCategory = $('select[name="installation_category"]').val();

            if (!salesType && !installationCategory) {
                e.preventDefault();
                $('select[name="sales_type"], select[name="installation_category"]').addClass(
                    'is-invalid');
            } else {
                $('select[name="sales_type"], select[name="installation_category"]').removeClass(
                    'is-invalid');
            }
        });
    });

    function initSelect2InsideModal() {
        $('.select2-modal').select2({
            width: '100%',
            dropdownParent: $('#exampleModalCenter')
        });
    }

    $(document).on('select2:open', () => {
        document.querySelectorAll('.select2-container--open').forEach((el) => {
            el.closest('.modal').removeAttribute('tabindex');
        });
    });
</script>

{{-- CSS --}}
<style>
    .select2-container .select2-selection--single {
        height: 38px !important;
        border: 1px solid #ced4da !important;
        border-radius: 5px !important;
        padding: 5px 8px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 28px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px !important;
        right: 8px !important;
    }

    .select2-search--dropdown .select2-search__field {
        height: 35px !important;
        padding: 6px 10px !important;
        font-size: 14px !important;
        border-radius: 5px !important;
    }

    .row.gy-3>[class*="col-"] {
        margin-top: 0 !important;
    }

    #staff-select-container,
    #customer-type-container,
    #customer-select-container,
    #manual-input-container {
        margin-top: 10px !important;
        margin-bottom: 5px !important;
    }
</style>
