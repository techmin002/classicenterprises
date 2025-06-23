@extends('setting::layouts.master')

@section('title', "{$type} Suppliers")
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">{{ ucfirst($type) }} Suppliers</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ ucfirst($type) }} Suppliers</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">{{ ucfirst($type) }} Suppliers</li>
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

                                <h3 class="card-title float-right"><a class="btn btn-info text-white" data-toggle="modal"
                                        data-target="#exampleModalCenter"><i class="fa fa-plus"></i> Create</a> </h3>
                                @include('inventory::Suppliers.create')
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Contact</th>
                                            <th class="text-center">Address</th>
                                            <th class="text-center">PAN/VAT</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($suppliers as $supplier)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $supplier->name }}</td>
                                                <td class="text-center">{{ $supplier->email }}</td>
                                                <td class="text-center">{{ $supplier->contact }}</td>
                                                <td class="text-center">{{ $supplier->address }}</td>
                                                <td class="text-center">
                                                    {{ $supplier->PAN  }} / {{ $supplier->VAT }}
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('suppliers_edit', $supplier->id) }}"
                                                        class="btn btn-warning btn-sm" data-toggle="tooltip"
                                                        title="Edit"><i class="fa fa-edit"></i></a>
                                                    <form action="{{ route('suppliers_destroy', $supplier->id) }}"
                                                        method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            data-toggle="tooltip" title="Delete"
                                                            onclick="return confirm('Are you sure you want to delete this supplier?')"><i
                                                                class="fa fa-trash"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Contact</th>
                                            <th class="text-center">Address</th>
                                            <th class="text-center">PAN/VAT</th>
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
       $(function () {
          $('[data-toggle="tooltip"]').tooltip()
       })
    </script>
@endsection
