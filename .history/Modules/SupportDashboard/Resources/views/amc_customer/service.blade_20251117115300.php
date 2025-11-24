@extends('setting::layouts.master')

@section('title', ' Service')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Service</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Service</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Service</li>
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
                                <h3><strong>AMC Customer</strong></h3>
                            </div>
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Mobile</th>
                                            <th class="text-center">AMC</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">Paid</th>
                                            <th class="text-center">Due</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($amccustomer as $customer)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $customer->customer->name ?? $customer->customer_name }}</td>
                                                <td>{{ $customer->customer->contact ?? $customer->contact }}</td>
                                                <td>{{ $customer->amc->title }}</td>
                                                <td>{{ \Carbon\Carbon::parse($customer->last_date)->format('d-m-Y') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($customer->last_date)->addMonths(4)->format('d-m-Y') }}
                                                </td>
                                                <td>
                                                    <span class="badge bg-danger">Service Due</span>
                                                </td>
                                                <td class="text-center">
                                                    <a href="" class="btn btn-primary btn-sm" data-toggle="modal"
                                                        data-target="#exampleModalamc{{ $customer['customer_id'] }}">
                                                        Create Ticket
                                                    </a>
                                                    <div class="modal fade"
                                                        id="exampleModalamc{{ $customer['customer_id'] }}" tabindex="-1">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content border-0 shadow">

                                                                <div class="modal-header bg-primary text-white">
                                                                    <h5 class="modal-title">
                                                                        <i class="fa fa-headset mr-2"></i>
                                                                        Create Support Ticket
                                                                    </h5>
                                                                    <button type="button" class="close text-white"
                                                                        data-dismiss="modal">
                                                                        &times;
                                                                    </button>
                                                                </div>

                                                                <form action="{{ route('amccustomer-ticket.store') }}"
                                                                    method="POST">
                                                                    @csrf

                                                                    <div class="modal-body">

                                                                        <input type="hidden" name="type" value="amc">
                                                                        <input type="hidden" name="customer_id"
                                                                            value="{{ $customer['customer_id'] }}">

                                                                        <div class="form-group">
                                                                            <label>Support Type</label>
                                                                            <select name="support_type"
                                                                                class="form-control">
                                                                                <option value="">Select Support Type
                                                                                </option>
                                                                                <option value="normal_service">Normal
                                                                                    Service</option>
                                                                                <option value="maintenance">Maintenance
                                                                                </option>
                                                                                <option value="location_shifting">Location
                                                                                    Shifting</option>
                                                                            </select>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label>Priority</label>
                                                                            <select name="priority" class="form-control">
                                                                                <option value="">Select Priority
                                                                                </option>
                                                                                <option value="high">High</option>
                                                                                <option value="medium">Medium</option>
                                                                                <option value="low">Low</option>
                                                                            </select>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label>AMC</label>
                                                                            <input type="text" class="form-control"
                                                                                value="AMC In" readonly>
                                                                            <input type="hidden" name="amc"
                                                                                value="in">
                                                                        </div>

                                                                        @php
                                                                            $warrantyExpiry = Carbon\Carbon::parse(
                                                                                $customer['assign_date'],
                                                                            )->addYear();
                                                                            $isWarrantyIn = now()->lt($warrantyExpiry);
                                                                        @endphp

                                                                        <div class="form-group">
                                                                            <label>Warranty</label>
                                                                            <input type="text" class="form-control"
                                                                                value="{{ $isWarrantyIn ? 'Warranty In' : 'Warranty Out' }}"
                                                                                readonly>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label>Message</label>
                                                                            <textarea name="message" class="form-control" rows="3"></textarea>
                                                                        </div>

                                                                    </div>

                                                                    <div class="modal-footer bg-light">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">
                                                                            Close
                                                                        </button>
                                                                        <button type="submit" class="btn btn-success">
                                                                            Create Support
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Mobile</th>
                                            <th class="text-center">AMC</th>
                                            <th class="text-center">Paid</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">Due</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
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
@endsection
