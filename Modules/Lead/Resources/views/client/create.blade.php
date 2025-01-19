@extends('setting::layouts.master')

@section('title', 'Create Customer')
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
                                                <label class="form-label12">Name <strong class="text-danger">*</strong></label>
                                                <input class="form-control" placeholder="Enter name" type="text"
                                                    value="{{ $lead->name }}" name="name" id="name">
                                            </div>
                                            <div class="mt-3 col-lg-6">
                                                <label class="form-label12">Email <strong class="text-danger">*</strong></label>
                                                <input class="form-control" placeholder="" type="email"
                                                    value="{{ $lead->email }}" name="email">
                                            </div>
                                            <input type="hidden" value="{{ $lead->id }}" name="lead_id">
                                            <div class="mt-3 col-lg-6">
                                                <label class="form-label12">Contact Number  <strong class="text-danger">*</strong></label>
                                                <input class="form-control" placeholder="Enter mobile number" type="tel"
                                                    value="{{ $lead->mobile }}"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);"
                                                    pattern="\d{10}"maxlength="10" name="mobile" id="mobile" required
                                                    title="Please enter exactly 10 digits">
                                            </div>

                                            <div class="mt-3 col-lg-6">
                                                <label class="form-label12">Alternate Contact Number  <small class="text-success">(Optional)</small></label>
                                                <input class="form-control" placeholder="Enter alternate mobile number"
                                                    type="tel" value="{{ $lead->landline }}"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);"
                                                    pattern="\d{10}"maxlength="10" name="landline" id="landline"
                                                    title="Please enter exactly 10 digits">
                                            </div>

                                            <div class="mt-3 col-lg-12">
                                                <label class="form-label12">Address <strong class="text-danger">*</strong></label>
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
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="product_name">Product <strong class="text-danger">*</strong></label>
                                                    <select name="product_id" id="product_id" required
                                                        class="form-control select2bs4">
                                                        <option value="" selected disabled>Select Product</option>
                                                        @foreach ($machineries as $product)
                                                            <option value="{{ $product->id }}">{{ $product->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>


                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="backend_price">Price <strong class="text-danger">*</strong></label>
                                                    <input type="number" name="backend_price" id="backend_price"
                                                        class="form-control" required placeholder="Enter Product Price">
                                                </div>
                                            </div>
                                        </div>
                                            <!--accessories start here-->
                                            <div class="customer_records">
                                                <div class="row gy-3">
                                                    <div class="col-md-4">
                                                        <label>Accessories</label>
                                                        <select name="accessories_id[]" class="form-control select2bs4">
                                                            <option value="">Select Accessories</option>
                                                            @foreach ($accessories as $product)
                                                                <option value="{{ $product->id }}">{{ $product->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('product_id')
                                                            <p style="color: red">{{ $message }}</p>
                                                        @enderror

                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Price</label>
                                                        <input type="number" class="form-control" id="amount"
                                                            value="{{ old('amount') }}" name="a_amount[]"
                                                            placeholder="Enter Price">
                                                        @error('pricce')
                                                            <p style="color: red">{{ $message }}</p>
                                                        @enderror

                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Quantity</label>
                                                        <input name="a_qty[]" class="form-control" type="number"
                                                            placeholder="Quantity">
                                                    </div>

                                                </div>
                                                <a class="extra-fields-customer badge badge-success" style="cursor: pointer"><i
                                                        class="fa fa-plus" ></i> Accessories</a>
                                            </div>
                                            <div class="customer_records_dynamic"></div>
                                            <!--accessories end here-->
                                            <div class="form-group">
                                                <label for="remark">Remark <small>(optional)</small></label>
                                                <textarea name="remark" class="summernote" required></textarea>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-start">

                                        <button type="submit" name="submit" id="btnSubmit"
                                            class="btn btn-success">Save Lead</button>

                                        <button type="cancel" data-dismiss="modal"
                                            class="btn btn-danger">Cancel</button>
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
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })

    </script>
    <script>
        $('.extra-fields-customer').click(function() {
            $('.customer_records').clone().appendTo('.customer_records_dynamic');
            $('.customer_records_dynamic .customer_records').addClass('single remove');
            $('.single .extra-fields-customer').remove();

            $('.single').append('<a href="#" class="remove-field badge badge-danger"><i class="fa fa-minus"></i> Accessories</a>');
            $('.customer_records_dynamic > .single').attr("class", "remove");

            $('.customer_records_dynamic input').each(function() {
                var count = 0;
                var fieldname = $(this).attr("name");
                $(this).attr('name', fieldname + count);
                count++;
            });

        });

        $(document).on('click', '.remove-field', function(e) {
            $(this).parent('.remove').remove();
            e.preventDefault();
        });
    </script>
@endsection
