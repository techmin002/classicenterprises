@extends('setting::layouts.master')

@section('title', " $saleType Installation Queue")
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">{{ $saleType }} Installation Queue</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ $saleType }} Installation Queue</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">{{ $saleType }} Installation Queue</li>
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
                                        @foreach ($customers as $key => $exp)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $exp->lead->name }}</td>
                                                <td class="text-center">{{ $exp->lead->email }}</td>
                                                <td class="text-center">{{ $exp->lead->mobile }}</td>
                                                <td class="text-center">{{ $exp->lead->address }}</td>
                                                <td class="text-center">Rs.{{ $exp->paid_amount ?? '0' }}</td>
                                                <td class="text-center">Rs.{{ $exp->total_amount }}</td>
                                                <td class="text-center">Rs.{{ $exp->due_amount }}</td>

                                                <td>


                                                        <button id="delete" class="btn btn-danger btn-sm" disabled
                                                            onclick="event.preventDefault();if (confirm('Are you sure? It will delete the data permanently!')) {document.getElementById('destroy{{ $exp->id }}').submit()}">
                                                            <i class="fa fa-trash"></i>
                                                            <form id="destroy{{ $exp->id }}" class="d-none"
                                                                action="{{ route('leads.destroy', $exp->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('delete')
                                                            </form>
                                                        </button>
                                                        <a type="button" href="{{ route('installation-create.create',$exp->id) }}" class="btn btn-secondary btn-sm" disabled data-toggle="tooltip" data-placement="top" title="Convert lead into Client">
                                                            <i class="fa fa-user-plus"></i>
                                                        </a>
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
       $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
    </script>
@endsection

