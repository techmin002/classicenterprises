@extends('setting::layouts.master')

@section('title', 'Leaves')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Leaves</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Leaves</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Leaves</li>
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
                              @if (auth()->user()->role['name'] === 'Super Admin')
                              @else
                                <h3 class="card-title float-right"><a class="btn btn-info text-white" data-toggle="modal"
                                        data-target="#exampleModalCenter"><i class="fa fa-plus"></i> Create</a> </h3>
                                @include('employee::leaves.create')
                                @endif
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Title</th>
                                            <th class="text-center">Employee</th>
                                            <th class="text-center">Leave Type</th>
                                            <th class="text-center">Branch</th>
                                            <th class="text-center">Start Date</th>
                                            <th class="text-center">End Date</th>
                                            <th class="text-center">Message</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($leaves as $key => $exp)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $exp->title }}</td>
                                                <td class="text-center">{{ $exp->employee_id }}</td>
                                                <td class="text-center">{{ $exp->leave_type_id }}</td>
                                                <td class="text-center">{{ $exp->barnch_id }}</td>
                                                <td class="text-center">{{ $exp->start_date }}</td>
                                                <td class="text-center">{{ $exp->end_date }}</td>
                                                <td class="text-center">{{ $exp->message }}</td>
                                                <td class="text-center">
                                                    @if ($exp->status == 'pending')
                                                        <a class="badge badge-warning">{{ ucfirst($exp->status) }}</a>
                                                    @elseif($exp->status == 'accept')
                                                        <a class="badge badge-success">{{ ucfirst($exp->status) }}</a>
                                                    @else
                                                        <a class="badge badge-danger">{{ ucfirst($exp->status) }}</a>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if (auth()->user()->role['name'] === 'Super Admin')
                                                        <div class="dropdown show">
                                                            <a class="badge badge-info dropdown-toggle" href="#"
                                                                role="button" id="dropdownMenuLink" data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false">
                                                                {{ ucfirst($exp->status) }}
                                                            </a>

                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                <a class="dropdown-item"
                                                                    href="{{ route('employee.leaves.status', ['id' => $exp->id, 'status' => 'accept']) }}">Accept</a>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('employee.leaves.status', ['id' => $exp->id, 'status' => 'reject']) }}">Reject</a>

                                                            </div>
                                                        </div>
                                                    @else
                                                        <a data-toggle="modal"
                                                            data-target="#editCategory{{ $exp->id }}"
                                                            class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                                        @include('employee::leaves.edit')
                                                        <button id="delete" class="btn btn-danger btn-sm"
                                                            onclick="event.preventDefault();if (confirm('Are you sure? It will delete the data permanently!')) {document.getElementById('destroy{{ $exp->id }}').submit()}">
                                                            <i class="fa fa-trash"></i>
                                                            <form id="destroy{{ $exp->id }}" class="d-none"
                                                                action="{{ route('expenses.destroy', $exp->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('delete')
                                                            </form>
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Title</th>
                                            <th class="text-center">Employee</th>
                                            <th class="text-center">Leave Type</th>
                                            <th class="text-center">Branch</th>
                                            <th class="text-center">Start Date</th>
                                            <th class="text-center">End Date</th>
                                            <th class="text-center">Message</th>
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
