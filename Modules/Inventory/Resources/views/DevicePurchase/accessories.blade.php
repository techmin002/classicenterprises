@extends('setting::layouts.master')

@section('title', 'Accessories')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Accessories</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper bg-light">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 align-items-center">
                    <div class="col-sm-6">
                        <h1 class="display-4 font-weight-bold text-primary mb-3">
                            <i class="fas fa-plug"></i> Accessories
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right bg-white rounded shadow-sm px-3 py-2">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Accessories</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="card shadow-lg border-0">
                            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                <h3 class="card-title mb-0">Accessories</h3>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap table-bordered table-striped mb-0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Purchase ID</th>
                                            <th>Accessories ID</th>
                                            <th>Branch ID</th>
                                            <th>Created By</th>
                                            <th>Quantity</th>
                                            <th>Amount</th>
                                            <th>Status</th>                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($accessories) && count($accessories) > 0)
                                            @foreach ($accessories as $accessory)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $accessory->purchase_id }}</td>
                                                    <td>{{ $accessory->accessories_id }}</td>
                                                    <td>{{ $accessory->branch_id }}</td>
                                                    <td>{{ $accessory->created_by }}</td>
                                                    <td>{{ $accessory->quantity }}</td>
                                                    <td>{{ $accessory->amount }}</td>
                                                    <td>{{ $accessory->status }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="8" class="text-center">No accessories found.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Purchase ID</th>
                                            <th>Accessories ID</th>
                                            <th>Branch ID</th>
                                            <th>Created By</th>
                                            <th>Quantity</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <style>
        .content-wrapper {
            min-height: 100vh;
            padding-top: 30px;
        }
        .card {
            border-radius: 1rem;
        }
        .table th, .table td {
            vertical-align: middle !important;
        }
        .thead-dark th {
            background-color: #343a40;
            color: #fff;
        }
    </style>
@endsection
