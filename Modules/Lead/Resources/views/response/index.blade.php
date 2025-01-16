@extends('setting::layouts.master')

@section('title', 'Leads Response')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Leads Response</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Leads Response</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Leads Response</li>
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
                                <h3 class="float-left">Name: {{ $lead['name'] }}</h3>
                                <h3 class="card-title float-right"><a class="btn btn-info text-white" data-toggle="modal"
                                        data-target="#exampleModalCenter"><i class="fa fa-plus"></i> Create</a> </h3>
                                @include('lead::response.create')
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Date & Time</th>
                                            <th class="text-center">Follow By</th>
                                            <th class="text-center">Response</th>
                                            <th class="text-center">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($lead->responses as $key => $exp)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $lead->name }}</td>
                                                <td class="text-center">{{ $exp->followups }}</td>
                                                <td class="text-center">
                                                    @php
                                                        $id = $exp->created_by;
                                                        $emp = App\Models\User::where('id', $id)
                                                            ->select('name')
                                                            ->first();
                                                    @endphp
                                                    {{ $emp->name ?? 'Not Found' }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $exp->message }}
                                                </td>

                                                <td>

                                                    <a data-toggle="modal" data-target="#editCategory{{ $exp->id }}"
                                                        class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                                    @include('lead::response.edit')
                                                    <button id="delete" class="btn btn-danger btn-sm"
                                                        onclick="event.preventDefault();if (confirm('Are you sure? It will delete the data permanently!')) {document.getElementById('destroy{{ $exp->id }}').submit()}">
                                                        <i class="fa fa-trash"></i>
                                                        <form id="destroy{{ $exp->id }}" class="d-none"
                                                            action="{{ route('response.destroy', $exp->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('delete')
                                                        </form>
                                                    </button>

                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Date & Time</th>
                                            <th class="text-center">Follow By</th>
                                            <th class="text-center">Response</th>
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
