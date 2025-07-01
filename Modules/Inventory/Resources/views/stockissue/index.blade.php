@extends('setting::layouts.master')

@section('title', 'Stock Issue Requests')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Stock Issue</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Page Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Stock Issue</h1>
                    </div>
                    <div class="col-sm-6 text-right">

                    </div>
                </div>
            </div>
        </section>

        <!-- Table -->
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        {{-- @can('create_product') --}}
                        <h3 class="card-title float-right"><a class="btn btn-primary text-white" data-toggle="modal"
                                data-target="#requestModal"><i class="fa fa-plus"></i>
                                Request</a> </h3>
                        @include('inventory::stockissue.request')
                        {{-- @endcan --}}
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">S.N</th>
                                    <th class="text-center">Requested By</th>
                                    <th class="text-center">View Details</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stockIssues as $key => $tool)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $tool->user->name ?? 'N/A' }} <br>
                                            {{-- <small>ID: #{{ $tool->id }}</small> --}}
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-info btn-sm" data-toggle="modal"
                                                data-target="#viewModal{{ $tool->id }}">
                                                <i class="fa fa-eye"></i> View Details
                                            </button>
                                            @include('inventory::stockissue.viewdetails')
                                        </td>
                                        <td class="text-center">{{ $tool->created_at }}</td>
                                        <td class="text-center">
                                            @if ($tool->status == 'pending')
                                                <span class="badge badge-warning badge-sm">Pending</span>
                                            @elseif ($tool->status == 'accepted')
                                                <span class="badge badge-success badge-sm">Accepted</span>
                                            @elseif ($tool->status == 'rejected')
                                                <span class="badge badge-danger badge-sm">Rejected</span>
                                            @else
                                                <span class="badge badge-secondary badge-sm">Unknown</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if (Auth::user()->role->name === 'Super Admin')
                                                {{-- Allow Super Admin to take action again --}}
                                                <form action="{{ route('stock-issue.accept', $tool->id) }}" method="POST"
                                                    style="display:inline-block; margin-left: 5px;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success"
                                                        onclick="return confirm('Are you sure you want to accept ')">
                                                        Accept
                                                    </button>
                                                </form>

                                                <form action="{{ route('stock-issue.reject', $tool->id) }}" method="POST"
                                                    style="display:inline-block; margin-left: 5px;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure you want to reject ')">
                                                        Reject
                                                    </button>
                                                </form>
                                            @else
                                                {{-- Other users see only label --}}
                                                @if ($tool->status == 'pending')
                                                    <span class="badge badge-warning">Pending</span>
                                                @elseif ($tool->status == 'accepted')
                                                    <span class="badge badge-success">Accepted</span>
                                                @elseif ($tool->status == 'rejected')
                                                    <span class="badge badge-danger">Rejected</span>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-center">S.N</th>
                                    <th class="text-center">Requested By</th>
                                    <th class="text-center">View Details</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection
