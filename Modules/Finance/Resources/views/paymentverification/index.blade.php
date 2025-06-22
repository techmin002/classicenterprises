@extends('setting::layouts.master')

@section('title', 'Payment Verification')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active"> Payment Verification </li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1> Payment Verification </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active"> Payment Verification</li>
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
                                            <th class="text-center">Customer Name</th>
                                            <th class="text-center">Branch Name</th>
                                            <th class="text-center">Lead Name</th>
                                            <th class="text-center">Method</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Message</th>
                                            <th class="text-center">Total Amount</th>
                                            <th class="text-center">Paid Amount</th>
                                            <th class="text-center">Remaning Amount</th>
                                            <th class="text-center">Status</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($data as $value)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $value->customer->lead->name ?? '-' }}</td>
                                                <td class="text-center">{{ $value->branch->name ?? '-' }}</td>
                                                <td class="text-center">{{ $value->lead->name ?? '-' }}</td>
                                                <td class="text-center">{{ $value->payment_method }}</td>
                                                <td class="text-center">{{ $value->created_at }}</td>
                                                <td class="text-center">{{ $value->message }}</td>
                                                <td class="text-center">₹{{ $value->total_amount }}</td>
                                                <td class="text-center">₹{{ $value->paid_amount }}</td>
                                                <td class="text-center">₹{{ $value->remaining_amount }}</td>
                                                <td>
                                                    @if ($value->status === 'on')
                                                        <button type="button" class="btn btn-primary btn-sm text-white"
                                                            data-toggle="modal"
                                                            data-target="#exampleModal{{ $value->id }}">
                                                            Verify Amount
                                                        </button>
                                                        @include('finance::paymentverification.verifyamount')
                                                    @else
                                                        <button type="button" class="btn btn-success btn-sm text-white">
                                                            Verified
                                                        </button>
                                                    @endif
                                                </td>

                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No collections today.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot>

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
