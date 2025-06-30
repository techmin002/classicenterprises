@extends('setting::layouts.master')

@section('title', 'Petty Cash')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Petty Cash Request</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Petty Cash Request</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Petty Cash Request</li>
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
                        <!-- Card -->
                        <div class="card">
                            @if (Auth::user()->role->name !== 'Super Admin')
                                <div class="card-header">
                                    <h3 class="card-title float-right">
                                        <a class="btn btn-primary text-white" data-toggle="modal"
                                            data-target="#exampleModalCenter">
                                            <i class="fa fa-plus"></i> Request Extra Cash
                                        </a>
                                    </h3>
                                    @include('pettycash::cash_request.create')
                                </div>
                            @endif
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Branch</th>
                                            <th class="text-center">Title</th>
                                            <th class="text-center">Amount</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Month</th>
                                            <th class="text-center">Description</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($requests as $req)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $req->branch->name ?? 'N/A' }}</td>
                                                <td class="text-center">{{ $req->title }}</td>
                                                <td class="text-center">{{ $req->amount }}</td>
                                                <td class="text-center">{{ $req->date }}</td>
                                                <td class="text-center">{{ $req->month_name }}</td>
                                                <td class="text-center">{{ $req->description }}</td>
                                                <td class="text-center">
                                                    @if ($req->status === 'approved')
                                                        <span class="btn btn-success btn-sm">Approved</span>
                                                    @elseif ($req->status === 'rejected')
                                                        <span class="btn btn-danger btn-sm">Rejected</span>
                                                    @else
                                                        <span class="btn btn-warning btn-sm">Pending</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{-- @if (Auth::user()->role->name === 'Super Admin') --}}
                                                    @if (auth()->user()->can('edit_pettycash'))
                                                        @if ($req->status === 'pending')
                                                            <button type="button" class="btn btn-primary btn-sm text-white"
                                                                data-toggle="modal"
                                                                data-target="#exampleModalCentercashtransfer{{ $req->id }}">
                                                                Transfer
                                                            </button>
                                                            @include('pettycash::cash_transfer.transfer')

                                                            <form method="POST"
                                                                action="{{ route('pettycash-request.reject', $req->id) }}"
                                                                style="display:inline;">
                                                                @csrf
                                                                <button type="submit" class="btn btn-danger btn-sm">
                                                                    Reject
                                                                </button>
                                                            </form>
                                                        @endif
                                                        @if ($req->status === 'approved')
                                                            <button type="button" class="btn btn-danger btn-sm text-white">
                                                                Locked
                                                            </button>
                                                        @endif
                                                        @if ($req->status === 'rejected')
                                                            <button type="button" class="btn btn-primary btn-sm text-white"
                                                                data-toggle="modal"
                                                                data-target="#exampleModalCentercashtransfer{{ $req->id }}">
                                                                Transfer
                                                            </button>
                                                            @include('pettycash::cash_transfer.transfer')
                                                        @endif
                                                    @else
                                                        @if ($req->status === 'pending')
                                                            <a data-toggle="modal"
                                                                data-target="#editCategory{{ $req->id }}"
                                                                class="btn btn-primary btn-sm"><i
                                                                    class="fa fa-edit"></i></a>
                                                            @include('pettycash::cash_request.edit')

                                                            <button class="btn btn-danger btn-sm"
                                                                onclick="
                                                                event.preventDefault();
                                                                if (confirm('Are you sure? It will delete the data permanently!')) {
                                                                    document.getElementById('destroy{{ $req->id }}').submit();
                                                                }">
                                                                <i class="fa fa-trash"></i>
                                                                <form id="destroy{{ $req->id }}" class="d-none"
                                                                    action="{{ route('pettycash-request.destroy', $req->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                </form>
                                                            </button>
                                                        @else
                                                            <span class="btn btn-secondary btn-sm">Locked</span>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center text-danger">No requests found.</td>
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
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection
