@extends('setting::layouts.master')

@section('title', 'Payment Reports')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active"> Payment Reports</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1> Payment Reports</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active"> Payment Reports</li>
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


                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Mobile</th>
                                            <th class="text-center">Address</th>
                                            <th class="text-center">Paid</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">Due</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customers as $key => $customer)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $customer->lead->name }}</td>
                                                <td class="text-center">{{ $customer->lead->email }}</td>
                                                <td class="text-center">{{ $customer->lead->mobile }}</td>
                                                <td class="text-center">{{ $customer->lead->address }}</td>
                                                <td class="text-center">Rs.{{ $customer->paid_amount ?? '0' }}</td>
                                                <td class="text-center">Rs.{{ $customer->total_amount }}</td>
                                                <td class="text-center">Rs.{{ $customer->due_amount }}</td>

                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <a type="button"
                                                                href="{{ route('customer.payment.details', $customer->id) }}"
                                                                class="btn btn-primary btn-sm w-100" disabled
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="Convert lead into Client">
                                                                Payment Detail's
                                                            </a>
                                                        </div>
                                                        <div class="col-md-12 mt-2 d-flex">
                                                            <a type="button"
                                                                href="{{ route('customer.details', $customer->id) }}"
                                                                class="btn btn-info btn-sm w-50 " disabled
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="Convert lead into Client">
                                                                View Detail's
                                                            </a>
                                                            <a type="button" data-toggle="modal"
                                                                data-target="#pay{{ $customer->id }}"
                                                                class="btn btn-success btn-sm w-25" style="margin-left: 4%">
                                                                Pay
                                                            </a>
                                                            @include('finance::payment.pay')
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
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Mobile</th>
                                            <th class="text-center">Address</th>
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
