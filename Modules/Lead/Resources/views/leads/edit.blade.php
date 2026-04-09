<!-- ===========================
     EDIT LEAD MODAL
============================ -->
<div class="modal fade" id="editCategory{{ $exp->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #08A4A4; color: #fff;">
                <h1 class="modal-title fs-5">Edit Lead</h1>
            </div>

            <form action="{{ route('leads.update', $exp->id) }}" id="editLeadForm{{ $exp->id }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <div class="container">
                        <div class="row gy-3">
                            {{-- Hidden Branch ID --}}
                            <input type="hidden" name="branch_id" value="{{ auth()->user()->branch_id }}">

                            {{-- Name --}}
                            <div class="col-lg-6">
                                <label class="form-label12">Name</label>
                                <input class="form-control" placeholder="Enter name" type="text" name="name"
                                    value="{{ $exp->name }}" required>
                            </div>

                            {{-- Email --}}
                            <div class="col-lg-6">
                                <label class="form-label12">Email</label>
                                <input class="form-control" type="email" name="email" value="{{ $exp->email }}"
                                    >
                            </div>

                            {{-- Contact --}}
                            <div class="col-lg-6">
                                <label class="form-label12 mt-2">Contact Number</label>
                                <input class="form-control" placeholder="Enter mobile number" type="tel"
                                    name="mobile" value="{{ $exp->mobile }}"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);"
                                    pattern="\d{10}" maxlength="10" required>
                            </div>

                            {{-- Alternate --}}
                            <div class="col-lg-6">
                                <label class="form-label12 mt-2">Alternate Contact Number</label>
                                <input class="form-control" placeholder="Enter alternate mobile number" type="tel"
                                    name="landline" value="{{ $exp->landline }}"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);"
                                    maxlength="10">
                            </div>


                            {{-- Lead Source --}}
                            <div class="col-lg-6">
                                <label class="form-label12 mt-2">Lead Source</label>
                                <select name="lead_source" class="form-control select2-modal lead-source-select"
                                    required>
                                    <option value="" disabled>Select Lead Source</option>
                                    <option value="facebook" {{ $exp->lead_source == 'facebook' ? 'selected' : '' }}>
                                        Facebook</option>
                                    <option value="instagram" {{ $exp->lead_source == 'instagram' ? 'selected' : '' }}>
                                        Instagram</option>
                                    <option value="whatsapp" {{ $exp->lead_source == 'whatsapp' ? 'selected' : '' }}>
                                        WhatsApp</option>
                                    <option value="staff" {{ $exp->lead_source == 'staff' ? 'selected' : '' }}>Staff
                                    </option>
                                    <option value="counter" {{ $exp->lead_source == 'counter' ? 'selected' : '' }}>
                                        Counter</option>
                                    <option value="customer" {{ $exp->lead_source == 'customer' ? 'selected' : '' }}>
                                        Customer Refer</option>
                                </select>
                            </div>

                            {{-- Next Followup --}}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mt-2">Next Followup Date:</label>
                                    <div class="input-group date" id="reservationdatetime{{ $exp->id }}"
                                        data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input" name="date_time"
                                            data-target="#reservationdatetime{{ $exp->id }}"
                                            value="{{ $exp->followups }}" required />
                                        <div class="input-group-append"
                                            data-target="#reservationdatetime{{ $exp->id }}"
                                            data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Dynamic containers --}}
                            <div class="col-lg-12" id="staff-select-container-edit{{ $exp->id }}"></div>
                            <div class="col-lg-12" id="customer-type-container-edit{{ $exp->id }}"></div>
                            <div class="col-lg-12" id="customer-select-container-edit{{ $exp->id }}"></div>
                            <div class="col-lg-12" id="manual-input-container-edit{{ $exp->id }}"></div>

                            {{-- Address --}}
                            <div class="col-lg-6">
                                <label class="form-label12">Address</label>
                                <input class="form-control" type="text" name="address" value="{{ $exp->address }}"
                                    required>
                            </div>

                            {{-- Installation Category --}}
                            <div class="col-lg-6">
                                <label class="form-label12 mt-2">Installation Category</label>
                                <select name="installation_category" class="form-control select2-modal">
                                    <option value="" disabled>Select Installation Category</option>
                                    <option value="retailler"
                                        {{ $exp->installation_category == 'retailler' ? 'selected' : '' }}>Retail
                                    </option>
                                    <option value="commercial"
                                        {{ $exp->installation_category == 'commercial' ? 'selected' : '' }}>Commercial
                                    </option>
                                    <option value="industrial"
                                        {{ $exp->installation_category == 'industrial' ? 'selected' : '' }}>Industrial
                                    </option>
                                </select>
                            </div>


                            {{-- Sales Category --}}
                            {{-- <div class="col-lg-6">
                                <label class="form-label12 mt-2">Sales Category</label>
                                <select name="sales_type" class="form-control select2-modal">
                                    <option value="" disabled {{ is_null($exp->sales_type) ? 'selected' : '' }}>
                                        Select Sales Category</option>
                                    <option value="counter_sales"
                                        {{ $exp->sales_type === 'counter_sales' ? 'selected' : '' }}>Counter Sales
                                    </option>
                                    <option value="retailler"
                                        {{ $exp->sales_type === 'retailler' ? 'selected' : '' }}>Retailer</option>
                                    <option value="wholeseller"
                                        {{ $exp->sales_type === 'wholeseller' ? 'selected' : '' }}>Wholeseller</option>
                                </select>

                            </div> --}}


                            {{-- Message --}}
                            <div class="col-lg-12">
                                <label class="form-label12 mt-2">Message</label>
                                <textarea name="message" class="form-control" required>{{ $exp->message }}</textarea>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-start">
                    <button type="submit" class="btn btn-success">Update</button>
                    <button type="button" data-dismiss="modal" class="btn btn-danger">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ===========================
     JS SCRIPT
============================ -->
<script>
    $(document).ready(function() {
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};

        // Initialize modal fields on load
        $('form[id^="editLeadForm"]').each(function() {
            const form = $(this);
            const id = form.attr('id').replace('editLeadForm', '');
            const leadSource = form.find('select[name="lead_source"]').val();

            if (leadSource === 'staff') {
                $.getJSON("{{ route('get.staff') }}", function(data) {
                    let html = `<div class="mt-2">
                        <label class="form-label12">Select Staff</label>
                        <select name="staff_id" class="form-control select2-modal" required>
                            <option value="" disabled>Select Staff</option>`;
                    $.each(data, (i, staff) => {
                        const selected = staff.id == "{{ $exp->staff_id ?? '' }}" ?
                            'selected' : '';
                        html +=
                            `<option value="${staff.id}" ${selected}>${staff.name}</option>`;
                    });
                    html += `</select></div>`;
                    $(`#staff-select-container-edit${id}`).html(html);
                    initSelect2InsideModal();
                });
            }

            if (leadSource === 'customer') {
                let typeHtml = `<div class="mt-2">
                    <label class="form-label12">Customer Type</label>
                    <select name="customer_type" class="form-control customer-type-select" data-id="${id}" required>
                        <option value="" disabled>Select Type</option>
                        <option value="register" ${"{{ $exp->customer_type }}"=="register"?'selected':''}>Register</option>
                        <option value="not_register" ${"{{ $exp->customer_type }}"=="not_register"?'selected':''}>Not Register</option>
                    </select>
                </div>`;
                $(`#customer-type-container-edit${id}`).html(typeHtml);

                // Load register/not_register fields
                if ("{{ $exp->customer_type }}" === 'register') {
                    $.getJSON("{{ route('get.customer') }}", function(data) {
                        let html = `<div class="mt-2">
                            <label class="form-label12">Select Registered Customer</label>
                            <select name="customer_id" class="form-control select2-modal" required>
                                <option value="" disabled>Select Customer</option>`;
                        $.each(data, (i, customer) => {
                            const selected = customer.id ==
                                "{{ $exp->customer_id ?? '' }}" ? 'selected' : '';
                            html +=
                                `<option value="${customer.id}" ${selected}>${customer.name} - ${customer.mobile}</option>`;
                        });
                        html += `</select></div>`;
                        $(`#customer-select-container-edit${id}`).html(html);
                        initSelect2InsideModal();
                    });
                }

                if ("{{ $exp->customer_type }}" === 'not_register') {
                    let manualHtml = `<div class="row mt-2">
                        <div class="col-lg-6">
                            <label class="form-label12">Customer Name</label>
                            <input type="text" name="manual_customer_name" class="form-control" placeholder="Enter Name" value="{{ $exp->manual_customer_name }}" required>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label12">Customer Mobile</label>
                            <input type="tel" name="manual_customer_mobile" class="form-control" placeholder="Enter Mobile" maxlength="10" value="{{ $exp->manual_customer_mobile }}" required>
                        </div>
                    </div>`;
                    $(`#manual-input-container-edit${id}`).html(manualHtml);
                }
            }
        });

        $('.lead-source-select').on('change', function() {
            const id = $(this).closest('form').attr('id').replace('editLeadForm', '');
            const leadSource = $(this).val();

            $(`#staff-select-container-edit${id}, #customer-type-container-edit${id}, #customer-select-container-edit${id}, #manual-input-container-edit${id}`)
                .empty();

            if (leadSource === 'staff') {
                $.getJSON("{{ route('get.staff') }}", function(data) {
                    let html = `<div class="mt-2">
                        <label class="form-label12">Select Staff</label>
                        <select name="staff_id" class="form-control select2-modal" required>
                            <option value="" disabled selected>Select Staff</option>`;
                    $.each(data, (i, staff) => html +=
                        `<option value="${staff.id}">${staff.name}</option>`);
                    html += `</select></div>`;
                    $(`#staff-select-container-edit${id}`).html(html);
                    initSelect2InsideModal();
                });
            }

            if (leadSource === 'customer') {
                let typeHtml = `<div class="mt-2">
                    <label class="form-label12">Customer Type</label>
                    <select name="customer_type" class="form-control customer-type-select" data-id="${id}" required>
                        <option value="" disabled selected>Select Type</option>
                        <option value="register">Register</option>
                        <option value="not_register">Not Register</option>
                    </select>
                </div>`;
                $(`#customer-type-container-edit${id}`).html(typeHtml);
            }
        });

        $(document).on('change', '.customer-type-select', function() {
            const id = $(this).data('id');
            const type = $(this).val();
            $(`#customer-select-container-edit${id}, #manual-input-container-edit${id}`).empty();

            if (type === 'register') {
                $.getJSON("{{ route('get.customer') }}", function(data) {
                    let html = `<div class="mt-2">
                        <label class="form-label12">Select Registered Customer</label>
                        <select name="customer_id" class="form-control select2-modal" required>
                            <option value="" disabled selected>Select Customer</option>`;
                    $.each(data, (i, customer) => html +=
                        `<option value="${customer.id}">${customer.name} - ${customer.mobile}</option>`
                    );
                    html += `</select></div>`;
                    $(`#customer-select-container-edit${id}`).html(html);
                    initSelect2InsideModal();
                });
            }

            if (type === 'not_register') {
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
                $(`#manual-input-container-edit${id}`).html(manualHtml);
            }
        });

        // ✅ Validation: Require either Sales or Installation Category
        $('form[id^="editLeadForm"]').on('submit', function(e) {
            let salesType = $(this).find('select[name="sales_type"]').val();
            let installationCategory = $(this).find('select[name="installation_category"]').val();

            if (!salesType && !installationCategory) {
                e.preventDefault();
                $(this).find('select[name="sales_type"], select[name="installation_category"]')
                    .addClass('is-invalid');
            } else {
                $(this).find('select[name="sales_type"], select[name="installation_category"]')
                    .removeClass('is-invalid');
            }
        });
    });

    function initSelect2InsideModal() {
        $('.select2-modal').select2({
            width: '100%',
            dropdownParent: $('.modal.show')
        });
    }
</script>

<!-- ===========================
     CSS STYLE
============================ -->
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
