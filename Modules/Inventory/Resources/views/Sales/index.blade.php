@extends('setting::layouts.master')

@section('title', "Sales")
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Sales</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Sales</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Sales</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <div class="card shadow">
                            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                                <h3 class="card-title mb-0">Sales List</h3>
                                <div class="ml-auto">
                                    <a class="btn btn-light text-info font-weight-bold" data-toggle="modal"
                                        data-target="#salesModal"><i class="fa fa-plus"></i> Create</a>
                                </div>
                                @include('inventory::Sales.create')
                            </div>
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Customer</th>
                                            <th class="text-center">Contact</th>
                                            <th class="text-center">Type</th>
                                            <th class="text-center">Paid</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Action</th>
                                            <th class="text-center">View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sales as $sale)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $sale->customer_name }}</td>
                                                <td class="text-center">{{ $sale->contact }}</td>
                                                <td class="text-center">
                                                    <span class="badge badge-pill badge-secondary">{{ $sale->customer_type }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="text-success font-weight-bold">{{ number_format($sale->paid_amount, 2) }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="text-primary font-weight-bold">{{ number_format($sale->total_amount, 2) }}</span>
                                                </td>
                                                <td class="text-center">
                                                    @if($sale->status == 'Completed')
                                                        <span class="badge badge-success">Completed</span>
                                                    @elseif($sale->status == 'Pending')
                                                        <span class="badge badge-warning">Pending</span>
                                                    @else
                                                        <span class="badge badge-secondary">{{ $sale->status }}</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    {{ $sale->created_at->format('d M, Y') }}
                                                </td>
                                                <td class="text-center">

                                                    <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                                    <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></button>
                                                    </form>
                                                </td>
                                                <td class="text-center">
                                                    <a href="" class="btn btn-sm btn-info" data-toggle="tooltip" title="View Details"><i class="fa fa-eye"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Customer</th>
                                            <th class="text-center">Contact</th>
                                            <th class="text-center">Type</th>
                                            <th class="text-center">Paid</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Action</th>
                                            <th class="text-center">View</th>
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
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }
    </style>
    <script>
       $(function () {
          $('[data-toggle="tooltip"]').tooltip()
       })
    </script>
@endsection
