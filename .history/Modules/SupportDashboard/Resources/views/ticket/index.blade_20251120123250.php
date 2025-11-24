@extends('setting::layouts.master')

@section('title', 'Ticket Create')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Ticket Create</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Ticket Create</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Ticket Create</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section class="content">
            <div class="container-fluid">
                <ul class="nav nav-pills mb-3 d-flex gap-4" id="pills-tab" role="tablist">
                    <li class="nav-item me-2" role="presentation">
                        <button class="nav-link active" id="pills-registeruser-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-registeruser" type="button" role="tab"
                            aria-controls="pills-registeruser" aria-selected="true">Register Customer</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-amcuser-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-amcuser" type="button" role="tab" aria-controls="pills-amcuser"
                            aria-selected="false">AMC Customer</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-outsideruser-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-outsideruser" type="button" role="tab"
                            aria-controls="pills-outsideruser" aria-selected="false">Outsider Customer</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    {{-- Register Customer --}}
                    <div class="tab-pane fade show active" id="pills-registeruser" role="tabpanel"
                        aria-labelledby="pills-registeruser-tab" tabindex="0">
                        <div class="row">
                            <div class="col-12">
                                <!-- /.card -->
                                <div class="card">
                                    <div class="card-header">
                                        {{-- <button class="btn btn-secondary">Register Customer</button> --}}
                                        <h3><strong>Register Customer</strong></h3>
                                    </div>
                                    <div class="card-body">
                                        <table id="example1" class="table table-bordered table-striped datatable-custom">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">S.N</th>
                                                    <th class="text-center">Name</th>
                                                    <th class="text-center">Mobile</th>
                                                    <th class="text-center">Address</th>
                                                    <th class="text-center">Product</th>
                                                    {{-- <th class="text-center">Amount</th> --}}
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($register as $key => $customer)
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        <td class="text-center">{{ $customer->lead->name }}</td>
                                                        <td class="text-center">{{ $customer->lead->mobile }}</td>
                                                        <td class="text-center">{{ $customer->lead->address }}</td>
                                                        <td class="text-center">
                                                            @foreach ($customer->products as $customerProduct)
                                                                {{ $customerProduct->product->name }}
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            <a href="" class="btn btn-primary btn-sm"
                                                                data-toggle="modal"
                                                                data-target="#exampleModal{{ $customer->id }}">Ticket
                                                                Create</a>

                                                            <div class="modal fade" id="exampleModal{{ $customer->id }}"
                                                                tabindex="-1" role="dialog"
                                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg" role="document">
                                                                    <div class="modal-content border-0 shadow">

                                                                        <!-- Modal Header -->
                                                                        <div class="modal-header bg-primary text-white">
                                                                            <div>
                                                                                <h5 class="modal-title mb-0"
                                                                                    id="exampleModalLabel">
                                                                                    <i class="fa fa-headset mr-2"></i>
                                                                                    Create
                                                                                    Support Ticket
                                                                                </h5>
                                                                                <small>Customer:
                                                                                    <strong>{{ ucfirst($customer->lead->name) }}</strong></small>
                                                                            </div>
                                                                            <button type="button" class="close text-white"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>

                                                                        <!-- Modal Body -->
                                                                        <form
                                                                            action="{{ route('registercustomer-ticket.store') }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <div class="modal-body">
                                                                                <input type="hidden" name='type'
                                                                                    value="register">
                                                                                <input type="hidden" name="customer_id"
                                                                                    value="{{ $customer->id }}">
                                                                                <div class="form-group">
                                                                                    <label for="support_type"
                                                                                        class="font-weight-bold">Support
                                                                                        Category</label>
                                                                                    <select name="support_type"
                                                                                        id="support_type"
                                                                                        class="form-control">
                                                                                        <option value="" selected
                                                                                            disabled>Select Support Type
                                                                                        </option>
                                                                                        <option value="maintenance">
                                                                                            Maintenance</option>
                                                                                        <option value="filter_leakage">
                                                                                            Filter Leakage</option>
                                                                                        <option value="location_shifting">
                                                                                            Location Shifting</option>
                                                                                        <option value="regular_servicing">
                                                                                            Regular Servicing</option>

                                                                                    </select>
                                                                                </div>

                                                                                <div class="form-group">
                                                                                    <label for="priority"
                                                                                        class="font-weight-bold">Priority</label>
                                                                                    <select name="priority" id="priority"
                                                                                        class="form-control">
                                                                                        <option value="" selected
                                                                                            disabled> Select Priority
                                                                                        </option>
                                                                                        <option value="high">High
                                                                                        </option>
                                                                                        <option value="medium">Medium
                                                                                        </option>
                                                                                        <option value="low">Low</option>
                                                                                    </select>
                                                                                </div>
                                                                                @php

                                                                                    // Calculate warranty status (1 year validity from created_at)
                                                                                    $warrantyIn = false;
                                                                                    if (isset($customer->created_at)) {
                                                                                        $warrantyIn = Carbon\Carbon::parse(
                                                                                            $customer->created_at,
                                                                                        )
                                                                                            ->addYear()
                                                                                            ->isFuture();
                                                                                    }
                                                                                @endphp

                                                                                <div class="form-group">
                                                                                    <label for="warranty"
                                                                                        class="font-weight-bold">Warranty
                                                                                        Status</label>
                                                                                    <select name="warranty" id="warranty"
                                                                                        class="form-control" disabled>
                                                                                        <option value="" disabled>
                                                                                            Select Warranty</option>
                                                                                        <option value="in"
                                                                                            {{ $warrantyIn ? 'selected' : '' }}>
                                                                                            Warranty In</option>
                                                                                        <option value="out"
                                                                                            {{ !$warrantyIn ? 'selected' : '' }}>
                                                                                            Warranty Out</option>
                                                                                    </select>

                                                                                    <!-- Hidden input to submit the warranty value since select is disabled -->
                                                                                    <input type="hidden" name="warranty"
                                                                                        value="{{ $warrantyIn ? 'in' : 'out' }}">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="amc"
                                                                                        class="font-weight-bold">AMC</label>
                                                                                    <select name="amc" id="amc"
                                                                                        class="form-control" disabled>
                                                                                        <option value="" disabled>
                                                                                            Select AMC</option>
                                                                                        <option value="in"
                                                                                            {{ $customer->amc == 'yes' ? 'selected' : '' }}>
                                                                                            AMC In</option>
                                                                                        <option value="out"
                                                                                            {{ $customer->amc != 'yes' ? 'selected' : '' }}>
                                                                                            AMC Out</option>
                                                                                    </select>

                                                                                    <!-- Hidden input to still send AMC value since disabled inputs aren't submitted -->
                                                                                    <input type="hidden" name="amc"
                                                                                        value="{{ $customer->amc == 'yes' ? 'in' : 'out' }}">
                                                                                </div>

                                                                                <div class="form-group">
                                                                                    <label for="message"
                                                                                        class="font-weight-bold">Message</label>
                                                                                    <textarea name="message" id="message" class="form-control" rows="4" placeholder="Enter message..."></textarea>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Modal Footer -->
                                                                            <div
                                                                                class="modal-footer bg-light justify-content-start">
                                                                                <button type="submit"
                                                                                    class="btn btn-success">Submit
                                                                                </button>
                                                                                <button type="button"
                                                                                    class="btn btn-danger"
                                                                                    data-dismiss="modal">Cancel
                                                                                </button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <a href="" class="btn btn-info btn-sm">Details</a>
                                                            <a type="button"
                                                                href="{{ route('customer.details', $customer->id) }}"
                                                                class="btn btn-info btn-sm" disabled data-toggle="tooltip"
                                                                data-placement="top" title="Details">Detail's
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th class="text-center">S.N</th>
                                                    <th class="text-center">Name</th>
                                                    <th class="text-center">Mobile</th>
                                                    <th class="text-center">Address</th>
                                                    <th class="text-center">Product</th>
                                                    {{-- <th class="text-center">Amount</th> --}}
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>
                        </div>
                    </div>

                    {{-- Outsider Customer --}}
                    <div class="tab-pane fade" id="pills-outsideruser" role="tabpanel"
                        aria-labelledby="pills-outsideruser-tab" tabindex="0">
                        <div class="row">
                            <div class="col-12">
                                <!-- /.card -->
                                <div class="card">
                                    <div class="card-header">
                                        <div class="btn-container d-flex justify-content-between">
                                            {{-- <button class="btn btn-secondary">Outsider Customer</button> --}}
                                            <h3><strong>Outsider Customer</strong></h3>
                                            <a href="" class="btn btn-info text-white" data-toggle="modal"
                                                data-target="#exampleModaloutsidercustomercreate"><i
                                                    class="fa fa-plus"></i> Add
                                                Customer</a>

                                            <div class="modal fade" id="exampleModaloutsidercustomercreate"
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content border-0 shadow">

                                                        <!-- Modal Header -->
                                                        <div class="modal-header bg-primary text-white">
                                                            <div>
                                                                <h5 class="modal-title mb-0" id="exampleModalLabel">
                                                                    <i class="fa fa-headset mr-2"></i>
                                                                    Create
                                                                    Support Ticket
                                                                </h5>
                                                            </div>
                                                            <button type="button" class="close text-white"
                                                                data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>

                                                        <!-- Modal Body -->
                                                        <form
                                                            action="{{ route('outsidercustomer-ticket.customer-create') }}"
                                                            method="POST">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <input type="hidden" name='type' value="outsider">

                                                                <div class="row">
                                                                    <!-- Left Column: Customer Details -->
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="customer_name"
                                                                                class="font-weight-bold">Customer
                                                                                Name</label>
                                                                            <input type="text" name="customer_name"
                                                                                id="customer_name" class="form-control"
                                                                                placeholder="Enter customer name">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="address"
                                                                                class="font-weight-bold">Email</label>
                                                                            <input class="form-control" type="email"
                                                                                name="email" id="email"
                                                                                class="form-control"
                                                                                placeholder="Enter address">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="contact"
                                                                                class="font-weight-bold">Contact</label>
                                                                            <input type="text" name="contact"
                                                                                id="contact" class="form-control"
                                                                                placeholder="Enter contact number"
                                                                                maxlength="10"
                                                                                oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="address"
                                                                                class="font-weight-bold">Address</label>
                                                                            <input type="text" name="address"
                                                                                id="address" class="form-control"
                                                                                placeholder="Enter address">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="message"
                                                                            class="font-weight-bold">Message</label>
                                                                        <textarea name="message" id="message" class="form-control summernote" rows="4"
                                                                            placeholder="Enter message..."></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <!-- Modal Footer -->
                                                            <div class="modal-footer bg-light">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">
                                                                    <i class="fa fa-times mr-1"></i> Close
                                                                </button>
                                                                <button type="submit" class="btn btn-success">
                                                                    <i class="fa fa-paper-plane mr-1"></i>
                                                                    Create
                                                                    Customer
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <table id="example2" class="table table-bordered table-striped datatable-custom">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">S.N</th>
                                                    <th class="text-center">Name</th>
                                                    <th class="text-center">Mobile</th>
                                                    <th class="text-center">Paid</th>
                                                    {{-- <th class="text-center">Due</th> --}}
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($outsider as $key => $customer)
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        <td class="text-center">{{ $customer->customer_name }}</td>
                                                        <td class="text-center">{{ $customer->contact }}</td>
                                                        <td class="text-center">Rs.{{ $customer->amount ?? '0' }}</td>
                                                        {{-- <td class="text-center">
                                                            Rs.{{ $customer->amc->price - $customer->amount ?? '0' }}
                                                        </td> --}}
                                                        <td>
                                                            <a href="" class="btn btn-primary btn-sm"
                                                                data-toggle="modal"
                                                                data-target="#exampleModaloutsidercustomer{{ $customer->id }}">
                                                                Create
                                                                Ticket</a>

                                                            <div class="modal fade"
                                                                id="exampleModaloutsidercustomer{{ $customer->id }}"
                                                                tabindex="-1" role="dialog"
                                                                aria-labelledby="exampleModaloutsidercustomerLabel"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog modal-lg" role="document">
                                                                    <div class="modal-content border-0 shadow">

                                                                        <!-- Modal Header -->
                                                                        <div class="modal-header bg-primary text-white">
                                                                            <div>
                                                                                <h5 class="modal-title mb-0"
                                                                                    id="exampleModaloutsidercustomerLabel">
                                                                                    <i class="fa fa-headset mr-2"></i>
                                                                                    Create
                                                                                    Support Ticket
                                                                                </h5>
                                                                                <small>Customer:
                                                                                    <strong>{{ ucfirst($customer->customer_name) }}</strong></small>
                                                                            </div>
                                                                            <button type="button"
                                                                                class="close text-white"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>

                                                                        <!-- Modal Body -->
                                                                        <form
                                                                            action="{{ route('outsidercustomer-ticket.store', $customer->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <div class="modal-body">
                                                                                <input type="hidden" name='type'
                                                                                    value="amc">
                                                                                <div class="form-group">
                                                                                    <label for="support_type"
                                                                                        class="font-weight-bold">Support
                                                                                        Type</label>
                                                                                    <select name="support_type"
                                                                                        id="support_type"
                                                                                        class="form-control">
                                                                                        <option value="" selected
                                                                                            disabled>
                                                                                            Select Support Type</option>
                                                                                        <option value="normal_service">
                                                                                            Normal
                                                                                            Service
                                                                                        </option>
                                                                                        <option value="maintenance">
                                                                                            Maintenance
                                                                                        </option>
                                                                                        <option value="location_shifting">
                                                                                            Location
                                                                                            Shifting
                                                                                        </option>
                                                                                    </select>
                                                                                </div>

                                                                                <div class="form-group">
                                                                                    <label for="priority"
                                                                                        class="font-weight-bold">Priority</label>
                                                                                    <select name="priority" id="priority"
                                                                                        class="form-control">
                                                                                        <option value="" selected
                                                                                            disabled>
                                                                                            Select Priority</option>
                                                                                        <option value="high">High
                                                                                        </option>
                                                                                        <option value="medium">Medium
                                                                                        </option>
                                                                                        <option value="low">Low</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="amc"
                                                                                        class="font-weight-bold">AMC</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        id="amc_display" value="AMC Out"
                                                                                        readonly>
                                                                                    <input type="hidden" name="amc"
                                                                                        value="out">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="amc"
                                                                                        class="font-weight-bold">Warranty</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        value="Warranty Out" readonly>
                                                                                    <input type="hidden" name="warranty"
                                                                                        value="out">
                                                                                </div>

                                                                                <div class="form-group">
                                                                                    <label for="message"
                                                                                        class="font-weight-bold">Message</label>
                                                                                    <textarea name="message" id="message" class="form-control" rows="4" placeholder="Enter message..."></textarea>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Modal Footer -->
                                                                            <div class="modal-footer bg-light">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-dismiss="modal">
                                                                                    <i class="fa fa-times mr-1"></i> Close
                                                                                </button>
                                                                                <button type="submit"
                                                                                    class="btn btn-success">
                                                                                    <i class="fa fa-paper-plane mr-1"></i>
                                                                                    Create
                                                                                    Support
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
                                                    <th class="text-center">Total</th>
                                                    {{-- <th class="text-center">Due</th> --}}
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
                    </div>

                    {{-- AMC Customer --}}
                    <div class="tab-pane fade" id="pills-amcuser" role="tabpanel" aria-labelledby="pills-amcuser-tab"
                        tabindex="0">
                        <div class="row">
                            <div class="col-12">
                                <!-- /.card -->
                                <div class="card">
                                    <div class="card-header">
                                        <h3><strong>AMC Customer</strong></h3>
                                    </div>
                                    <div class="card-body">
                                        <table id="example3" class="table table-bordered table-striped datatable-custom">
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
                                                @foreach ($amccustomer as $key => $customer)
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        @if ($customer->type == 'register')
                                                            <td class="text-center">{{ $customer->customer->lead->name }}
                                                            </td>
                                                        @else
                                                            <td class="text-center">{{ $customer->customer_name }}</td>
                                                        @endif
                                                        @if ($customer->type == 'register')
                                                            <td class="text-center">
                                                                {{ $customer->customer->lead->mobile }}</td>
                                                        @else
                                                            <td class="text-center">{{ $customer->contact }}</td>
                                                        @endif
                                                        <td class="text-center">{{ $customer->amc->title }}</td>
                                                        <td class="text-center">{{ $customer->amc->price }}</td>
                                                        <td class="text-center">Rs.{{ $customer->amount ?? '0' }}</td>
                                                        <td class="text-center">
                                                            Rs.{{ $customer->amc->price - $customer->amount ?? '0' }}
                                                        </td>
                                                        <td>
                                                            <a href="" class="btn btn-primary btn-sm"
                                                                data-toggle="modal"
                                                                data-target="#exampleModalamc{{ $customer->id }}"> Create
                                                                Ticket</a>

                                                            <div class="modal fade"
                                                                id="exampleModalamc{{ $customer->id }}" tabindex="-1"
                                                                role="dialog" aria-labelledby="exampleModalLabel"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog modal-lg" role="document">
                                                                    <div class="modal-content border-0 shadow">

                                                                        <!-- Modal Header -->
                                                                        <div class="modal-header bg-primary text-white">
                                                                            <div>
                                                                                <h5 class="modal-title mb-0"
                                                                                    id="exampleModalLabel">
                                                                                    <i class="fa fa-headset mr-2"></i>
                                                                                    Create
                                                                                    Support Ticket
                                                                                </h5>
                                                                                <small>Customer:
                                                                                    <strong>{{ ucfirst($customer->customer_name) }}</strong></small>
                                                                            </div>
                                                                            <button type="button"
                                                                                class="close text-white"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>

                                                                        <!-- Modal Body -->
                                                                        <form
                                                                            action="{{ route('amccustomer-ticket.store') }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <div class="modal-body">
                                                                                <input type="hidden" name='type'
                                                                                    value="amc">
                                                                                <input type="hidden" name="id"
                                                                                    value="{{ $customer['id'] }}">
                                                                                <input type="hidden" name="customer_id"
                                                                                    value="{{ $customer->customer_id }}">
                                                                                <div class="form-group">
                                                                                    <label for="support_type"
                                                                                        class="font-weight-bold">Support
                                                                                        Type</label>
                                                                                    <select name="support_type"
                                                                                        id="support_type"
                                                                                        class="form-control">
                                                                                        <option value="" selected
                                                                                            disabled>
                                                                                            Select Support Type</option>
                                                                                        <option value="normal_service">
                                                                                            Normal
                                                                                            Service
                                                                                        </option>
                                                                                        <option value="maintenance">
                                                                                            Maintenance
                                                                                        </option>
                                                                                        <option value="location_shifting">
                                                                                            Location
                                                                                            Shifting
                                                                                        </option>
                                                                                    </select>
                                                                                </div>

                                                                                <div class="form-group">
                                                                                    <label for="priority"
                                                                                        class="font-weight-bold">Priority</label>
                                                                                    <select name="priority" id="priority"
                                                                                        class="form-control">
                                                                                        <option value="" selected
                                                                                            disabled>
                                                                                            Select Priority</option>
                                                                                        <option value="high">High
                                                                                        </option>
                                                                                        <option value="medium">Medium
                                                                                        </option>
                                                                                        <option value="low">Low</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="amc"
                                                                                        class="font-weight-bold">AMC</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        id="amc_display" value="AMC In"
                                                                                        readonly>
                                                                                    <input type="hidden" name="amc"
                                                                                        value="in">
                                                                                </div>
                                                                                @php
                                                                                    $isWarrantyIn = false;
                                                                                    if ($customer->customer) {
                                                                                        $warrantyExpiryDate = \Carbon\Carbon::parse(
                                                                                            $customer->customer
                                                                                                ->created_at,
                                                                                        )->addYear();
                                                                                        $isWarrantyIn = \Carbon\Carbon::now()->lt(
                                                                                            $warrantyExpiryDate,
                                                                                        );
                                                                                    }
                                                                                @endphp
                                                                                <div class="form-group">
                                                                                    <label for="warranty"
                                                                                        class="font-weight-bold">Warranty</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        id="warranty" name="warranty"
                                                                                        value="{{ $isWarrantyIn ? 'in' : 'out' }}"
                                                                                        readonly>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="message"
                                                                                        class="font-weight-bold">Message</label>
                                                                                    <textarea name="message" id="message" class="form-control" rows="4" placeholder="Enter message..."></textarea>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Modal Footer -->
                                                                            <div class="modal-footer bg-light">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-dismiss="modal">
                                                                                    <i class="fa fa-times mr-1"></i> Close
                                                                                </button>
                                                                                <button type="submit"
                                                                                    class="btn btn-success">
                                                                                    <i class="fa fa-paper-plane mr-1"></i>
                                                                                    Create
                                                                                    Support
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
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection
