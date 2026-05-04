@extends('setting::layouts.master')

@section('title', 'Stock Purchases')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Stock Purchases</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Stock Purchases</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Stock Purchases</li>
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
                                @can('create_purchases')
                                    <h3 class="card-title float-right">
                                        <a class="btn btn-info text-white" data-toggle="modal"
                                            data-target="#exampleModalCenter"><i class="fa fa-plus"></i> Create</a>
                                    </h3>
                                @endcan
                                @include('inventory::DevicePurchase.create')
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Supplier</th>
                                            <th class="text-center">Branch</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Bill No.</th>
                                            <th class="text-center">Total Amount</th>
                                            <th class="text-center">Created By</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Receipt</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($devicepurchases as $devicePurchase)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $devicePurchase->supplier->name }}</td>
                                                <td class="text-center">{{ $devicePurchase->branch->name }}</td>
                                                <td class="text-center">{{ $devicePurchase->created_at }}</td>
                                                <td class="text-center">{{ $devicePurchase->bill_no }}</td>
                                                <td class="text-center">{{ $devicePurchase->total_amount }}</td>
                                                <td class="text-center">{{ $devicePurchase->user->name }}</td>
                                                <td class="text-center">
                                                    @if ($devicePurchase->status == 0)
                                                        <span class="badge badge-warning">Pending</span>
                                                    @elseif($devicePurchase->status == 1)
                                                        <span class="badge badge-success">Completed</span>
                                                    @else
                                                        <span class="badge badge-danger">Cancelled</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if ($devicePurchase->receipt)
                                                        <a href="{{ asset($devicePurchase->receipt) }}" target="_blank"
                                                            class="btn btn-secondary btn-sm" data-toggle="tooltip"
                                                            data-placement="top" title="View Receipt">
                                                            <i class="fa fa-file-invoice" aria-hidden="true"></i>
                                                        </a>
                                                    @else
                                                        No receipt
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @can('edit_purchases')
                                                        <a href="{{ route('device_purchase_edit', $devicePurchase->id) }}"
                                                            class="btn btn-primary btn-sm" data-toggle="tooltip"
                                                            data-placement="top"> <i class="fa fa-edit"></i></a>
                                                    @endcan
                                                    @can('delete_purchases')
                                                        <form
                                                            action="{{ route('device_purchase_destroy', $devicePurchase->id) }}"
                                                            method="POST" style="display:inline-block;"
                                                            onsubmit="return confirm('Are you sure you want to delete this device purchase?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                data-toggle="tooltip" data-placement="top">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endcan
                                                    @can('show_purchases')
                                                        <a href="{{ route('device_purchase_machineries_accessories', $devicePurchase->id) }}"
                                                            class="btn btn-success btn-sm" data-toggle="tooltip"
                                                            data-placement="top" title="View Machineries and Accessories"><i
                                                                class="fa fa-wrench"></i></a>
                                                    @endcan
                                                    </a>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Supplier</th>
                                            <th class="text-center">Branch</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Bill No.</th>
                                            <th class="text-center">Total Amount</th>
                                            <th class="text-center">Created By</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Receipt</th>
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
