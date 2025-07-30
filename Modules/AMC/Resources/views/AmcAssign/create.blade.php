@extends('setting::layouts.master')

@section('title', 'Assign AMC')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Assign AMC</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h1>Assign AMC</h1>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <form action="{{ route('amcassign.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">AMC Assign Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="row gy-3">

                                {{-- Customer --}}
                                <div class="col-md-6">
                                    <label>Customer <span class="text-danger">*</span></label>
                                    <select name="customer_id" class="form-control" required>
                                        <option value="">Select Customer</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->lead->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- AMC --}}
                                <div class="col-md-6">
                                    <label>AMC <span class="text-danger">*</span></label>
                                    <select name="amc_id" class="form-control" required>
                                        <option value="">Select AMC</option>
                                        @foreach ($amcs as $amc)
                                            <option value="{{ $amc->id }}">{{ $amc->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Payment Method --}}
                                <div class="col-md-6 mt-3">
                                    <label>Payment Method <span class="text-danger">*</span></label>
                                    <select name="payment_method" id="payment_method" class="form-control" required>
                                        <option value="">Select Method</option>
                                        <option value="Cash">Cash</option>
                                        <option value="online">Online</option>
                                        <option value="Cheque">Cheque</option>
                                    </select>
                                </div>

                                {{-- Cheque Number (Only if Cheque) --}}
                                <div class="col-md-6 mt-3 d-none" id="cheque_number_div">
                                    <label>Cheque Number <span class="text-danger">*</span></label>
                                    <input type="text" name="cheque_number" id="cheque_number" class="form-control"
                                        placeholder="Enter Cheque Number">
                                </div>

                                {{-- Image (Only if Online) --}}
                                <div class="col-md-6 mt-3 d-none" id="image_div">
                                    <label>Online Payment Screenshot <span class="text-danger">*</span></label>
                                    <input type="file" name="image" id="image" class="form-control"
                                        accept="image/*">
                                </div>

                                {{-- Date --}}
                                <div class="col-md-6 mt-3">
                                    <label>Date <span class="text-danger">*</span></label>
                                    <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}"
                                        required>
                                </div>

                                {{-- Status --}}
                                <div class="mt-3 col-md-12">
                                    <label class="form-label12">Publish</label>
                                    <br>
                                    <input type="checkbox" name="status" checked data-bootstrap-switch
                                        data-off-color="danger" data-on-color="success">
                                </div>

                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">Assign AMC</button>
                            <a href="{{ route('amcassign.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>

    {{-- Scripts --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#payment_method').on('change', function() {
                const method = $(this).val();

                // Reset fields
                $('#cheque_number_div').addClass('d-none');
                $('#cheque_number').val('').prop('required', false);

                $('#image_div').addClass('d-none');
                $('#image').val('').prop('required', false);

                if (method === 'Cheque') {
                    $('#cheque_number_div').removeClass('d-none');
                    $('#cheque_number').prop('required', true);
                }

                if (method === 'online') {
                    $('#image_div').removeClass('d-none');
                    $('#image').prop('required', true);
                }
            });
        });
    </script>
@endsection
