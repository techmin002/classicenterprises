@extends('setting::layouts.master')

@section('title', 'Stock Issue Requests')

@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">
        <a href="{{ route('home') }}">Home</a>
    </li>
    <li class="breadcrumb-item active">Stock Issue Requests</li>
</ol>
@endsection

@section('content')
<div class="content-wrapper">

    <!-- Page Header -->
    <section class="content-header">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <h1 class="m-0">Stock Issue Requests</h1>
@can('create_requestransfers')
            <button class="btn btn-primary"
                    data-toggle="modal"
                    data-target="#requestModal">
                <i class="fa fa-plus"></i> New Request
            </button>
            @endcan

            @include('inventory::stockissue.request')
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h3 class="card-title">All Requests</h3>
                </div>

                <div class="card-body table-responsive">

                    <table class="table table-hover table-bordered text-center">
                        <thead class="thead-light">
                            <tr>
                                <th width="50">#</th>
                                <th>Requested By</th>
                                <th>Branch</th>
                                <th>Details</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th width="220">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($stockIssues as $issue)
                                <tr>

                                    <td>{{ $loop->iteration }}</td>

                                    <!-- Requested By -->
                                    <td>
                                        <strong>{{ $issue->user->name ?? 'N/A' }}</strong>
                                    </td>

                                    <!-- Branch -->
                                    <td>
                                        {{ $issue->branch->name ?? 'N/A' }}
                                    </td>

                                    <!-- Details -->
                                    @can('show_stockissue')
                                    <td>
                                        <button class="btn btn-sm btn-info"
                                                data-toggle="modal"
                                                data-target="#viewModal{{ $issue->id }}">
                                            <i class="fa fa-eye"></i> View
                                        </button>

                                        @include('inventory::stockissue.stock_issue_details')
                                    </td>
                                    @endcan

                                    <!-- Date -->
                                    <td>
                                        {{ $issue->created_at->format('d M Y') }}
                                        <br>
                                        <small class="text-muted">
                                            {{ $issue->created_at->format('h:i A') }}
                                        </small>
                                    </td>

                                    <!-- Status -->
                                    <td>
    @switch($issue->status)
        @case('pending')
            <span class="badge badge-warning">Pending</span>
            @break

        @case('accepted')
            <span class="badge badge-success">Accepted</span>
            @break

        @case('rejected')
            <span class="badge badge-danger">Rejected</span>
            @break

        @case('in_transit')
            <span class="badge badge-info">In Transit</span>
            @break
        @case('completed')
            <span class="badge badge-success">Completed</span>
            @break

        @default
            <span class="badge badge-secondary">Unknown</span>
    @endswitch
</td>


                                    <!-- Actions -->
                                    <td>
    @if(Auth::user()->role->name === 'Super Admin')

        @if($issue->status === 'pending')
            <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#acceptModal{{ $issue->id }}">
                <i class="fa fa-check"></i>
            </button>
            @include('inventory::stockissue.accept')

            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#rejectModal{{ $issue->id }}">
                <i class="fa fa-times"></i>
            </button>
            @include('inventory::stockissue.reject_modal')

        @elseif($issue->status === 'in_transit')
            <span class="badge badge-info">In Transit</span>

            <!-- Only show Receive button to requested branch -->
            @if(Auth::user()->branch_id == $issue->to_branch_id)
                <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#StockReceiveModal{{ $issue->id }}">
                    <i class="fa fa-truck-loading"></i> Receive
                </button>
                @include('inventory::stockissue.stock_receive_details', ['issue' => $issue])
            @endif

        @elseif($issue->status === 'completed')
            <span class="badge badge-success">Completed</span>

        @elseif($issue->status === 'rejected')
            <span class="badge badge-danger">Rejected</span>
        @endif

    @else
        <span class="badge badge-light text-dark">
            {{ ucfirst(str_replace('_', ' ', $issue->status)) }}
        </span>
    @endif
</td>

                                </tr>

                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        No Stock Issue Requests Found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>

                </div>
            </div>

        </div>
    </section>
</div>
@endsection
