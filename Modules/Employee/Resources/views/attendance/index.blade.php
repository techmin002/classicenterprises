@extends('setting::layouts.master')

@section('title', 'Users')

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
                                            Attendance
                                        </h4>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                        <li class="breadcrumb-item"> Attendance</li>
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
                                                    <h5>My Attendance</h5>
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
                                                                <th>Date</th>
                                                                <th>Day</th>
                                                                <th>Check-In</th>
                                                                <th>Check-Out</th>
                                                                <th>Status</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($attendance as $key => $attend)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ \Carbon\Carbon::parse($attend->date)->format('Y-M-d') }}
                                                                    </td>
                                                                    <td>{{ \Carbon\Carbon::parse($attend->date)->format('l') }}</td>
                                                                </td>
                                                                    <td>{{ \Carbon\Carbon::parse($attend->check_in)->format('H:i A') }}
                                                                    </td>
                                                                    <td>{{ \Carbon\Carbon::parse($attend->check_out)->format('H:i A') }}
                                                                    </td>

                                                                    <td>
                                                                        <div
                                                                            class="badge bg-{{ $attend->status == 'checkin' ? 'success' : 'danger' }} p-2 px-3 rounded">
                                                                            <a href="#"
                                                                                class="text-white">{{ ucfirst($attend->status) }}</a>
                                                                        </div>
                                                                    </td>

                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th>S.N.</th>
                                                                <th>Date</th>
                                                                <th>Day</th>
                                                                <th>Check-In</th>
                                                                <th>Check-Out</th>
                                                                <th>Status</th>
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
