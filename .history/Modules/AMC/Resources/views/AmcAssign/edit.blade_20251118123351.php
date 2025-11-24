@extends('setting::layouts.master')

@section('title', 'Edit AMC Assignment')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Edit AMC Assignment</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h1>Edit Assigned AMC</h1>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <form action="{{ route('amcassign.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Edit AMC Assign Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="row gy-3">

                                {{-- Customer --}}
                                <div class="col-md-6">
                                    <label>Customer <span class="text-danger">*</span></label>
                                    <select name="customer_id" class="form-control" required>
                                        <option value="">Select Customer</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}"
                                                {{ $data->customer_id == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->lead->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- AMC --}}
                                <div class="col-md-6">
                                    <label>AMC <span class="text-danger">*</span></label>
                                    <select name="amc_id" class="form-control" required>
                                        <option value="">Select AMC</option>
                                        @foreach ($amcs as $amc)
                                            <option value="{{ $amc->id }}"
                                                {{ $data->amc_id == $amc->id ? 'selected' : '' }}>
                                                {{ $amc->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Payment Method --}}
                                <div class="col-md-6 mt-3">
                                    <label>Payment Method <span class="text-danger">*</span></label>
                                    <select name="payment_method" id="payment_method" class="form-control" required>
                                        <option value="">Select Method</option>
                                        <option value="Cash" {{ $data->payment_method == 'Cash' ? 'selected' : '' }}>Cash
                                        </option>
                                        <option value="online" {{ $data->payment_method == 'online' ? 'selected' : '' }}>
                                            Online</option>
                                        <option value="Cheque" {{ $data->payment_method == 'Cheque' ? 'selected' : '' }}>
                                            Cheque</option>
                                    </select>
                                </div>

                                {{-- Cheque Number --}}
                                <div class="col-md-6 mt-3 {{ $data->payment_method == 'Cheque' ? '' : 'd-none' }}"
                                    id="cheque_number_div">
                                    <label>Cheque Number <span class="text-danger">*</span></label>
                                    <input type="text" name="cheque_no" id="cheque_number" class="form-control"
                                        value="{{ old('cheque_no', $data->cheque_no) }}" placeholder="Enter Cheque Number">
                                </div>

                                {{-- Online Payment Screenshot --}}
                                <div class="col-md-6 mt-3 {{ $data->payment_method == 'online' ? '' : 'd-none' }}"
                                    id="image_div">
                                    <label>Online Payment Screenshot {{ !$data->image ? '*' : '' }}</label>
                                    <input type="file" name="image" id="image" class="form-control"
                                        accept="image/*">
                                    @if ($data->image)
                                        <img src="{{ asset('upload/images/AmcAssign/' . $data->image) }}" width="100"
                                            class="mt-2">
                                    @endif
                                </div>

                                {{-- Date --}}
                                <div class="col-md-6 mt-3">
                                    <label>Date <span class="text-danger">*</span></label>
                                    <input type="date" name="date" class="form-control" value="{{ $data->date }}"
                                        required>
                                </div>

                                {{-- Status --}}
                                <div class="mt-3 col-md-12">
                                    <label class="form-label">Publish</label><br>
                                    <input type="checkbox" name="status" {{ $data->status == 'on' ? 'checked' : '' }}
                                        data-bootstrap-switch data-off-color="danger" data-on-color="success">
                                </div>

                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">Update AMC</button>
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
            function toggleFields() {
                const method = $('#payment_method').val();

                $('#cheque_number_div').addClass('d-none');
                $('#cheque_number').prop('required', false);

                $('#image_div').addClass('d-none');
                $('#image').prop('required', false);

                if (method === 'Cheque') {
                    $('#cheque_number_div').removeClass('d-none');
                    $('#cheque_number').prop('required', true);
                } else if (method === 'online') {
                    $('#image_div').removeClass('d-none');
                    @if (!$data->image)
                        $('#image').prop('required', true);
                    @endif
                }
            }

            $('#payment_method').on('change', toggleFields);

            toggleFields(); // Run on page load
        });
    </script>
@endsection
