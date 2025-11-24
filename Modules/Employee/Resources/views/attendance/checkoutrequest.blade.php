@extends('setting::layouts.master')

@section('title', 'Check-Out Request')

@section('third_party_stylesheets')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="dash-content">

                    <div class="page-header">
                        <div class="page-block">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="page-header-title">
                                        <h4 class="m-b-10">
                                            Check-Out Request
                                        </h4>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                        <li class="breadcrumb-item">Check-Out</li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="row">

                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-md-4" style="margin-bottom: 10px;">
                                                <div class="d-flex align-items-center justify-content-start">
                                                    <h5>Check-Out Request</h5>
                                                </div>

                                            </div>
                                            <div class="col-md-8">
                                                <div class="d-flex align-items-center justify-content-end">
                                                    @can('create_attendance')
                                                        <a href="" title="Set Salary" class="btn btn-sm btn-primary"
                                                            data-toggle="modal" data-target="#requestcheckout">
                                                            <i class="fa fa-plus"></i> Chek-Out Request
                                                        </a>
                                                    @endcan
                                                </div>
                                                <!-- Add Salary Modal -->
                                                <div class="modal fade" id="requestcheckout" tabindex="-1" role="dialog"
                                                    aria-labelledby="requestcheckoutLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="requestcheckoutLabel">Chek-Out
                                                                    Request
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="{{ route('attendance.checkout.store') }}"
                                                                method="post">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="input-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"
                                                                                id="basic-addon1">Date & Time
                                                                            </span>
                                                                        </div>
                                                                        <input type="datetime-local" min="1"
                                                                            class="form-control" name="checkout"
                                                                            placeholder="Enter Salary here"
                                                                            aria-label="amount"
                                                                            aria-describedby="basic-addon1" required>
                                                                        <input type="hidden" name="emp_id" value="">
                                                                    </div>
                                                                    <div class="input-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"
                                                                                id="basic-addon1">Message
                                                                            </span>
                                                                        </div>
                                                                        <textarea name="message" id="" class="form-control" cols="30" rows="4"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Request
                                                                        Submit</button>
                                                                </div>
                                                            </form>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <div
                                                class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">

                                                <div class="datatable">
                                                    <table id="example1" class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>S.N.</th>
                                                                @if (auth()->user()->role['name'] === 'Super Admin')
                                                                    <th>Name</th>
                                                                @endif
                                                                <th>Date</th>
                                                                <th>Day</th>
                                                                <th>Check-Out</th>
                                                                <th>Message</th>
                                                                <th>Status</th>
                                                                @if (auth()->user()->role['name'] === 'Super Admin')
                                                                    <th>Action</th>
                                                                @endif
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($checkout as $key => $check)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    @if (auth()->user()->role['name'] === 'Super Admin')
                                                                        <td>{{ $check->employee->name }}</td>
                                                                    @endif
                                                                    <td>{{ \Carbon\Carbon::parse($check->date)->format('Y-M-d') }}
                                                                    </td>
                                                                    <td>{{ \Carbon\Carbon::parse($check->date)->format('l') }}
                                                                    </td>
                                                                    </td>
                                                                    <td>{{ \Carbon\Carbon::parse($check->check_in)->format('H:i A') }}
                                                                    </td>
                                                                    <td>{!! $check->message !!}
                                                                    </td>
                                                                    <td>
                                                                        @if ($check->status === 'pending')
                                                                            <a href="#"
                                                                                class="badge badge-info">{{ ucfirst($check->status) }}</a>
                                                                        @elseif($check->status === 'accept')
                                                                            <a href="#"
                                                                                class="badge badge-success">Accepted</a>
                                                                        @else
                                                                            <a href="#"
                                                                                class="badge badge-danger">Rejected</a>
                                                                        @endif
                                                                    </td>
                                                                    @if (auth()->user()->role['name'] === 'Super Admin')
                                                                        <td>
                                                                            <div class="dropdown show">
                                                                                <a class="badge badge-info dropdown-toggle"
                                                                                    href="#" role="button"
                                                                                    id="dropdownMenuLink"
                                                                                    data-toggle="dropdown"
                                                                                    aria-haspopup="true"
                                                                                    aria-expanded="false">
                                                                                    {{ ucfirst($check->status) }}
                                                                                </a>

                                                                                <div class="dropdown-menu"
                                                                                    aria-labelledby="dropdownMenuLink">
                                                                                    <a class="dropdown-item"
                                                                                        href="{{ route('attendance.checkout.status', ['id' => $check->id, 'status' => 'accept']) }}">Accept</a>
                                                                                    <a class="dropdown-item"
                                                                                        href="{{ route('attendance.checkout.status', ['id' => $check->id, 'status' => 'reject']) }}">Reject</a>

                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    @endif

                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th>S.N.</th>
                                                                @if (auth()->user()->role['name'] === 'Super Admin')
                                                                    <th>Name</th>
                                                                @endif
                                                                <th>Date</th>
                                                                <th>Day</th>
                                                                <th>Check-Out</th>
                                                                <th>Message</th>
                                                                <th>Status</th>
                                                                @if (auth()->user()->role['name'] === 'Super Admin')
                                                                    <th>Action</th>
                                                                @endif
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection
