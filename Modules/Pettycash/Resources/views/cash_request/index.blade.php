@extends('setting::layouts.master')

@section('title', 'Petty Cash')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Petty Cash</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Petty Cash</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Petty Cash</li>
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
                            @if (Auth::user()->role->name !== 'Super Admin')
                                <div class="card-header">
                                    <h3 class="card-title float-right"><a class="btn btn-primary text-white"
                                            data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-plus"></i>
                                            Request Extra Cash</a> </h3>
                                    @include('pettycash::cash_request.create')
                                </div>
                            @endif
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            @if (Auth::user()->role === 'Admin' || Auth::user()->role === 'Super Admin')
                                                <th>Branch</th>
                                            @endif
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Branch</th>
                                            <th class="text-center">Title</th>
                                            <th class="text-center">Amount</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Month</th>
                                            <th class="text-center">Description</th>
                                            <th class="text-center">Status</th>
                                            @if (Auth::user()->role->name == 'Super Admin')
                                                <th class="text-center">Action</th>
                                            @endif
                                            @if (Auth::user()->role->name !== 'Super Admin')
                                                <th class="text-center">Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($requests as $req)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                {{-- @if (Auth::user()->role === 'Admin')
                                                    <td class="text-center">{{ $req->branch->name }}</td>
                                                @endif --}}
                                                <td class="text-center">{{ $req->branch->name }}</td>
                                                <td class="text-center">{{ $req->title }}</td>
                                                <td class="text-center">{{ $req->amount }}</td>
                                                <td class="text-center">{{ $req->date }}</td>
                                                <td class="text-center">{{ $req->month_name }}</td>
                                                <td class="text-center">{{ $req->description }}</td>
                                                <td class="text-center"> <button class="btn btn-warning btn-sm">
                                                        {{ ucfirst($req->status) }}
                                                    </button></td>
                                                @if (Auth::user()->role->name === 'Super Admin')
                                                    <td class="text-center">
                                                        @if ($req->status)
                                                            <form method="POST"
                                                                action="{{ route('pettycash-request.approve', $req->id) }}"
                                                                style="display:inline;">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="btn btn-success">Approve</button>
                                                            </form>
                                                            <form method="POST"
                                                                action="{{ route('pettycash-request.reject', $req->id) }}"
                                                                style="display:inline;">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="btn btn-danger">Reject</button>
                                                            </form>
                                                        @else
                                                            ---
                                                        @endif
                                                    </td>
                                                @endif
                                                @if (Auth::user()->role->name !== 'Super Admin')
                                                    <td>
                                                        @if ($req->status === 'pending')
                                                        <a data-toggle="modal"
                                                            data-target="#editCategory{{ $req->id }}"
                                                            class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                                        @include('pettycash::cash_request.edit')

                                                        <button id="delete" class="btn btn-danger btn-sm"
                                                            onclick="
                                                                event.preventDefault();
                                                                if (confirm('Are you sure? It will delete the data permanently!')) {
                                                                    document.getElementById('destroy{{ $req->id }}').submit()}">
                                                            <i class="fa fa-trash"></i>
                                                            <form id="destroy{{ $req->id }}" class="d-none"
                                                                action="{{ route('pettycash-request.destroy', $req->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        </button>
                                                        @else
                                                        <button class="btn btn-danger btn-sm">Can't Take Action</button>
                                                        @endif
                                                    </td>
                                                @endif
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center text-danger">No requests
                                                    found.</td>
                                            </tr>
                                        @endforelse

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Branch</th>
                                            <th class="text-center">Title</th>
                                            <th class="text-center">Amount</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Month</th>
                                            <th class="text-center">Description</th>
                                            <th class="text-center">Status</th>
                                            @if (Auth::user()->role->name === 'Super Admin')
                                                <th class="text-center">Action</th>
                                            @endif
                                            @if (Auth::user()->role->name !== 'Super Admin')
                                                <th class="text-center">Action</th>
                                            @endif
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
