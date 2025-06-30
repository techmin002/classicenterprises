@extends('setting::layouts.master')

@section('title', 'EMI Payment')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">EMI Payment</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>EMI Payment</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">EMI Payment</li>
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
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

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
                                        @foreach ($emiCustomers as $key => $customers)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $customers->customer->lead->name }}</td>
                                                <td class="text-center">{{ $customers->customer->lead->email }}</td>
                                                <td class="text-center">{{ $customers->customer->lead->mobile }}</td>
                                                <td class="text-center">{{ $customers->customer->lead->address }}</td>
                                                <td class="text-center">Rs.{{ $customers->down_payment ?? '0' }}</td>
                                                <td class="text-center">Rs.{{ $customers->customer->total_amount }}</td>
                                                <td class="text-center">Rs.
                                                {{ $customers->customer->total_amount -  $customers->down_payment}} 
                                                </td>

                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <a type="button"
                                                                href="{{ route('emi.payment.details', $customers->id) }}"
                                                                class="btn btn-primary btn-sm w-75" disabled
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="Convert lead into Client">
                                                                Payment Detail's
                                                            </a>
                                                        </div>
                                                        <div class="col-md-12 mt-2 d-flex">
                                                            @if ($customers->down_payment > 0)
                                                                <a type="button" data-toggle="modal"
                                                                    data-target="#pay{{ $customers->id }}"
                                                                    class="btn btn-success btn-sm" style="margin-left: 4%">
                                                                    EMI Pay
                                                                </a>
                                                                @include('finance::emiPayments.emiPay')
                                                            @endif
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
