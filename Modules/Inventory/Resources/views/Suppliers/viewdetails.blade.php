@extends('setting::layouts.master')

@section('title', "Suppliers")
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Suppliers</li>
</ol>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Suppliers Name: <strong>{{ $supplier->name }}</strong></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Suppliers</li>
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
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">S.N</th>
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
                                    @foreach ($details as $data)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $data->branch->name }}</td>
                                        <td class="text-center">{{ $data->created_at }}</td>
                                        <td class="text-center">{{ $data->bill_no }}</td>
                                        <td class="text-center">{{ $data->total_amount }}</td>
                                        <td class="text-center">{{ $data->user->name }}</td>
                                        <td class="text-center">
                                            @if ($data->status == 0)
                                            <span class="badge badge-warning">Pending</span>
                                            @elseif($data->status == 1)
                                            <span class="badge badge-success">Completed</span>
                                            @else
                                            <span class="badge badge-danger">Cancelled</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($data->receipt)
                                            <a href="{{ asset($data->receipt) }}" target="_blank" class="btn btn-secondary btn-sm" data-toggle="tooltip" data-placement="top" title="View Receipt">
                                                <i class="fa fa-file-invoice" aria-hidden="true"></i>
                                            </a>
                                            @else
                                            No receipt
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('device_purchase_machineries_accessories', $data->id) }}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="View Machineries and Accessories"><i class="fa fa-wrench"></i></a>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-center">S.N</th>
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
