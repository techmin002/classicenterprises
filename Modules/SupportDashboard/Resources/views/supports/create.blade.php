@extends('setting::layouts.master')

@section('title', 'Support Ticket')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Support Ticket</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Support Ticket</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Support Ticket</li>
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
                                <h3 class="card-title float-right">
                                    <a class="btn btn-info text-white" href="{{ route('products-accessories.create') }}"><i
                                            class="fa fa-plus"></i> Create</a>
                                </h3>
                                @include('product::category.create')
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>ID</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">User Name</th>
                                            <th class="text-center">Product</th>
                                            <th class="text-center">Install Date</th>
                                            <th class="text-center">Contact</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customers as $key => $value)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $value->id }}</td>
                                                <td>{{ $value->lead->name }}</td>
                                                <td>{{ $value->lead->user_name }}</td>
                                                <td>
                                                    @foreach ($value->products as $product)
                                                        {{ $product->product['name'] }}
                                                    @endforeach

                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($value->install_date)->format('d-M-Y') }}
                                                </td>
                                                <td>{{ $value->lead->mobile }}</td>
                                                <td>
                                                    {{ $value->lead->email }}
                                                </td>

                                                <td>
                                                    <a href="{{ route('products-accessories.edit', $value->id) }}"
                                                        class="btn btn-primary btn-sm" data-toggle="modal"
                                                        data-target="#exampleModal{{ $value->id }}"> Create Ticket</a>

                                                        <div class="modal fade" id="exampleModal{{ $value->id }}" tabindex="-1"
                                                            role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content border-0 shadow">

                                                                    <!-- Modal Header -->
                                                                    <div class="modal-header bg-primary text-white">
                                                                        <div>
                                                                            <h5 class="modal-title mb-0" id="exampleModalLabel">
                                                                                <i class="fa fa-headset mr-2"></i> Create Support Ticket
                                                                            </h5>
                                                                            <small>Customer: <strong>{{ ucfirst($value->lead->name) }}</strong></small>
                                                                        </div>
                                                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>

                                                                    <!-- Modal Body -->
                                                                    <form action="">
                                                                        <div class="modal-body">
                                                                            <div class="form-group">
                                                                                <label for="support_type" class="font-weight-bold">Support Type</label>
                                                                                <select name="support_type" id="support_type" class="form-control">
                                                                                    <option value="" selected disabled>Select Support Type</option>
                                                                                    <option value="">Normal Service</option>
                                                                                    <option value="">Maintenance</option>
                                                                                    <option value="">Location Shifting</option>
                                                                                </select>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label for="priority" class="font-weight-bold">Priority</label>
                                                                                <select name="priority" id="priority" class="form-control">
                                                                                    <option value="" selected disabled>Select Priority</option>
                                                                                    <option value="high">High</option>
                                                                                    <option value="medium">Medium</option>
                                                                                    <option value="low">Low</option>
                                                                                </select>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label for="message" class="font-weight-bold">Message</label>
                                                                                <textarea name="message" id="message" class="form-control" rows="4" placeholder="Enter message..."></textarea>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Modal Footer -->
                                                                        <div class="modal-footer bg-light">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                                                <i class="fa fa-times mr-1"></i> Close
                                                                            </button>
                                                                            <button type="submit" class="btn btn-success">
                                                                                <i class="fa fa-paper-plane mr-1"></i> Create Support
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>S.N</th>
                                            <th>ID</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">User Name</th>
                                            <th class="text-center">Product</th>
                                            <th class="text-center">Install Date</th>
                                            <th class="text-center">Contact</th>
                                            <th class="text-center">Email</th>
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
