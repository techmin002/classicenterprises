@extends('setting::layouts.master')

@section('title', 'Support Ticket')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Support Queue</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Support Queue</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Support Queue</li>
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
                                            <th>S.N</th>
                                            <th>ID</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Contact</th>
                                            <th class="text-center">Amount</th>
                                            <th class="text-center">Assign To</th>
                                            <th class="text-center">Product</th>
                                            <th class="text-center">Address</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $value)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $value->id }}</td>

                                                <td class="text-center">{{ $value->customer->lead->name }}</td>
                                                <td class="text-center">{{ $value->customer->lead->mobile }}</td>
                                                <td class="text-center">{{ isset($value->amount) ? $value->amount : 'N/A' }}
                                                </td>
                                                <td class="text-center">{{ ucfirst($value->assign_to) }}</td>
                                                <td class="text-center">
                                                    @foreach ($value->customer->products as $product)
                                                        {{ $product->product['name'] }}
                                                    @endforeach
                                                </td>
                                                <td class="text-center">{{ $value->customer->lead->address }}
                                                </td>
                                                <td class="text-center">{{ $value->created_at }}</td>
                                                <td class="text-center">{{ $value->status }}</td>

                                                <td>
                                                    <a href="{{ route('task.complete.details', $value->id) }}" class="btn btn-success btn-xs">View Details</a>


                                                    <a href="" class="btn btn-primary btn-xs w-100 mt-2" data-toggle="modal"
                                                        data-target="#exampleModal1{{ $value->id }}">Note</a>

                                                    {{-- modal start --}}
                                                    <div class="modal fade" id="exampleModal1{{ $value->id }}"
                                                        tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content border-0 shadow">
                                                                <!-- Modal Header -->
                                                                <div class="modal-header bg-primary text-white">
                                                                    <div>
                                                                        <small>Customer:
                                                                            <strong>{{ ucfirst($value->customer->lead->name) }}</strong></small>
                                                                    </div>
                                                                    <button type="button" class="close text-white"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>

                                                                <!-- Modal Body -->
                                                                <div class="modal-body">
                                                                    {{ $value->message }}
                                                                </div>

                                                                <!-- Modal Footer -->
                                                                <div class="modal-footer bg-light">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- modal end --}}

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>S.N</th>
                                            <th>ID</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Contact</th>
                                            <th class="text-center">Amount</th>
                                            <th class="text-center">Assign To</th>
                                            <th class="text-center">Product</th>
                                            <th class="text-center">Address</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Status</th>
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

@endsection
