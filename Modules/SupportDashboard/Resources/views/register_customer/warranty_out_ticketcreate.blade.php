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
                <div class="tab-pane fade show active" id="pills-registeruser" role="tabpanel"
                    aria-labelledby="pills-registeruser-tab" tabindex="0">
                    <div class="row">
                        <div class="col-12">
                            <!-- /.card -->
                            <div class="card">
                                <div class="card-header">
                                    {{-- <button class="btn btn-secondary">Register Customer</button> --}}
                                    <h3><strong>Warranty Out Customer</strong></h3>
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
                                                <th class="text-center">Amount</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($customers as $key => $customer)
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
                                                    <td class="text-center">
                                                        @foreach ($customer->products as $customerProduct)
                                                            {{ $customerProduct->product_price }}
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        <a href="" class="btn btn-primary btn-sm" data-toggle="modal"
                                                            data-target="#exampleModal{{ $customer->id }}"> Create
                                                            Ticket</a>

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
                                                                                    Type</label>
                                                                                <select name="support_type"
                                                                                    id="support_type" class="form-control">
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
                                                                            @php

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
                                                                                    class="font-weight-bold">Warranty</label>
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
                                                <th class="text-center">Address</th>
                                                <th class="text-center">Product</th>
                                                <th class="text-center">Amount</th>
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
            </div>
        </section>
    </div>
@endsection
