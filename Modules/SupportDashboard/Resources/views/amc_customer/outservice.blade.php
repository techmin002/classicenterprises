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
                            <h3><strong>AMC Service Out Customer</strong></h3>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">S.N</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Mobile</th>
                                        <th class="text-center">AMC Start Date</th>
                                        <th class="text-center">AMC End Date</th>
                                        <th class="text-center">Next Service Date</th>
                                        <th class="text-center">AMC Name</th>
                                        <th class="text-center">Amc Duration</th>
                                        <th class="text-center">Due</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($amccustomer as $customer)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">
                                            {{ $customer->customer->lead->name ?? $customer->customer_name }}</td>
                                        <td class="text-center">
                                            {{ $customer->customer->lead->mobile ?? $customer->contact }}</td>
                                        <td class="text-center">
                                            {{ \Carbon\Carbon::parse($customer->date)->format('d M, Y') }}</td>
                                        <td class="text-center">
                                            {{ \Carbon\Carbon::parse($customer->amc_end_date)->format('d M, Y') }}
                                        </td>
                                        <td class="text-center">
                                            {{ \Carbon\Carbon::parse($customer->next_service_date)->format('d M, Y') }}
                                        </td>
                                        <td class="text-center">{{ $customer->amc->title ?? '' }}</td>
                                        <td class="text-center">{{ $customer->duration_months }} Years</td>
                                        <td class="text-center">
                                            <span class="badge bg-danger">Service Out</span>
                                        </td>
                                        <td>
                                            <a href="" class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#exampleModalamc{{ $customer['id'] }}">
                                                Create Ticket
                                            </a>
                                            <div class="modal fade" id="exampleModalamc{{ $customer['id'] }}"
                                                tabindex="-1">
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
                                                                <input type="hidden" name='type' value="amc">
                                                                <input type="hidden" name="id"
                                                                    value="{{ $customer['id'] }}">
                                                                <input type="hidden" name="customer_id"
                                                                    value="{{ $customer->customer_id }}">
                                                                <div class="form-group">
                                                                    <label for="support_type"
                                                                        class="font-weight-bold">Support
                                                                        Type</label>
                                                                    <select name="support_type" id="support_type"
                                                                        class="form-control">
                                                                        <option value="" selected disabled>
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
                                                                        <option value="" selected disabled>
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
                                                                    <input type="text" class="form-control"
                                                                        id="amc_display" value="AMC In" readonly>
                                                                    <input type="hidden" name="amc" value="in">
                                                                </div>
                                                                @php
                                                                $isWarrantyIn = false;
                                                                if ($customer->customer) {
                                                                $warrantyExpiryDate = \Carbon\Carbon::parse(
                                                                $customer->customer->created_at,
                                                                )->addYear();
                                                                $isWarrantyIn = \Carbon\Carbon::now()->lt(
                                                                $warrantyExpiryDate,
                                                                );
                                                                }
                                                                @endphp
                                                                <div class="form-group">
                                                                    <label for="warranty"
                                                                        class="font-weight-bold">Warranty</label>
                                                                    <input type="text" class="form-control"
                                                                        id="warranty" name="warranty"
                                                                        value="{{ $isWarrantyIn ? 'in' : 'out' }}"
                                                                        readonly>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="message"
                                                                        class="font-weight-bold">Message</label>
                                                                    <textarea name="message" id="message"
                                                                        class="form-control" rows="4"
                                                                        placeholder="Enter message..."></textarea>
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
                                        <th class="text-center">AMC Start Date</th>
                                        <th class="text-center">AMC End Date</th>
                                        <th class="text-center">Next Service Date</th>
                                        <th class="text-center">AMC Name</th>
                                        <th class="text-center">Amc Duration</th>
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
