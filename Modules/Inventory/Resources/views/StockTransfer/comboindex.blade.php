@extends('setting::layouts.master')

@section('title', 'Stock Management')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">
            <div class="container-fluid">

                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Stock Management</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Stock Management</li>
                        </ol>
                    </div>

                </div>
            </div>
        </section>



        <section class="content">

            <div class="container-fluid">

                <div class="card">

                    <div class="card-header">

                        <ul class="nav nav-tabs">

                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#request">

                                    Requested Stock Transfer
                                    <span class="badge badge-primary ml-1">
                                        {{ $stockIssues->count() }}
                                    </span>

                                </a>
                            </li>


                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#direct">

                                    Direct Stock Transfer
                                    <span class="badge badge-success ml-1">
                                        {{ $stockTransfers->count() }}
                                    </span>

                                </a>
                            </li>

                        </ul>

                    </div>


                    <div class="card-body">

                        <div class="tab-content">


                            {{-- ================= REQUEST TAB ================= --}}
                            <div class="tab-pane fade show active" id="request">

                                <div class="d-flex justify-content-between mb-3">

                                    <h4>Stock Issue Requests</h4>
                                    @can('create_requestransfers')
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#requestModal">

                                            <i class="fa fa-plus"></i> New Request

                                        </button>
                                    @endcan

                                </div>

                                @include('inventory::stockissue.request')



                                <table class="table table-hover table-bordered text-center">

                                    <thead class="thead-light">

                                        <tr>
                                            <th>#</th>
                                            <th>Requested By</th>
                                            <th>Branch</th>
                                            <th>Details</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>

                                    </thead>

                                    <tbody>

                                        @forelse($stockIssues as $issue)

                                            <tr>

                                                <td>{{ $loop->iteration }}</td>

                                                <td>{{ $issue->user->name ?? 'N/A' }}</td>

                                                <td>{{ $issue->branch->name ?? 'N/A' }}</td>

                                                <td>
                                                    @can('show_requestransfers')
                                                        <button class="btn btn-info btn-sm" data-toggle="modal"
                                                            data-target="#viewModal{{ $issue->id }}">

                                                            <i class="fa fa-eye"></i>

                                                        </button>
                                                    @endcan

                                                    @include('inventory::stockissue.stock_issue_details')

                                                </td>


                                                <td>

                                                    {{ $issue->created_at->format('d M Y') }}

                                                    <br>

                                                    <small class="text-muted">

                                                        {{ $issue->created_at->format('h:i A') }}

                                                    </small>

                                                </td>


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
                                                <td>
                                                    @php
                                                        $user = Auth::user();
                                                        $activeBranch = session('branch_id') ?? $user->branch_id;

                                                        // 🔥 Get latest transfer (IMPORTANT)
                                                        $transfer = $issue->stockTransfers->last();

                                                        // ✅ Branch logic
                                                        $senderBranch = $transfer->from_branch_id ?? null;
                                                        $receiverBranch = $transfer->to_branch_id ?? $issue->branch_id;

                                                        $isSender = $activeBranch == $senderBranch;
                                                        $isReceiver = $activeBranch == $receiverBranch;
                                                    @endphp

                                                    @if ($issue->status === 'pending')
                                                        @if (Auth::user()->role->name === 'Super Admin')
                                                            {{-- ✅ ONLY SUPER ADMIN CAN ACCEPT --}}
                                                            <button class="btn btn-success btn-sm" data-toggle="modal"
                                                                data-target="#acceptModal{{ $issue->id }}">
                                                                <i class="fa fa-check"></i>
                                                            </button>

                                                            @include('inventory::stockissue.accept')

                                                            {{-- ✅ ONLY SUPER ADMIN CAN REJECT --}}
                                                            <button class="btn btn-danger btn-sm" data-toggle="modal"
                                                                data-target="#rejectModal{{ $issue->id }}">
                                                                <i class="fa fa-times"></i>
                                                            </button>

                                                            @include('inventory::stockissue.reject_modal')
                                                        @else
                                                            {{-- ❌ STAFF → ONLY SEE STATUS --}}
                                                            <span class="badge badge-warning">Pending</span>
                                                        @endif


                                                        {{-- ===== IN TRANSIT ===== --}}
                                                    @elseif ($issue->status === 'in_transit')
                                                        <span class="badge badge-info">In Transit</span>

                                                        {{-- ✅ ONLY RECEIVER CAN SEE --}}
                                                        @if ($isReceiver)
                                                            <button class="btn btn-success btn-sm" data-toggle="modal"
                                                                data-target="#StockReceiveModal{{ $issue->id }}">
                                                                <i class="fa fa-truck-loading"></i> Receive
                                                            </button>

                                                            @include(
                                                                'inventory::stockissue.stock_receive_details',
                                                                ['issue' => $issue]
                                                            )
                                                        @endif


                                                        {{-- ===== COMPLETED ===== --}}
                                                    @elseif ($issue->status === 'completed')
                                                        <span class="badge badge-success">Completed</span>

                                                        {{-- ===== REJECTED ===== --}}
                                                    @elseif ($issue->status === 'rejected')
                                                        <span class="badge badge-danger">Rejected</span>
                                                    @endif
                                                </td>

                                            </tr>

                                            @empty

                                                <tr>

                                                    <td colspan="7">No Requests Found</td>

                                                </tr>

                                            @endforelse

                                        </tbody>

                                    </table>

                                </div>



                                {{-- ================= DIRECT TRANSFER TAB ================= --}}
                                <div class="tab-pane fade" id="direct">

                                    <div class="d-flex justify-content-between mb-3">

                                        <h4>Direct Stock Transfer</h4>
                                        @can('create_stocktransfers')
                                            <a class="btn btn-primary" data-toggle="modal" data-target="#createStockTransfer">

                                                <i class="fa fa-plus"></i> Create Transfer

                                            </a>
                                        @endcan

                                    </div>

                                    @include('inventory::StockTransfer.create')


                                    <table class="table table-bordered table-striped text-center">

                                        <thead class="thead-dark">

                                            <tr>
                                                <th>S.N</th>
                                                <th>From Location</th>
                                                <th>To Location</th>
                                                <th>Total Quantity</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>

                                        </thead>


                                        <tbody>

                                            @foreach ($stockTransfers as $key => $transfer)
                                                <tr>

                                                    <td>{{ $key + 1 }}</td>

                                                    <td>{{ optional($transfer->fromBranch)->name }}</td>

                                                    <td>{{ optional($transfer->toBranch)->name }}</td>

                                                    <td>

                                                        {{ ($transfer->accessories->sum('pivot.quantity') ?? 0) +
                                                            ($transfer->machineries->sum('pivot.quantity') ?? 0) +
                                                            ($transfer->technicaltools->sum('pivot.quantity') ?? 0) }}

                                                    </td>


                                                    <td>

                                                        {{ \Carbon\Carbon::parse($transfer->transfer_date)->format('d M Y') }}

                                                    </td>


                                                    <td>

                                                        <span
                                                            class="badge

@if ($transfer->status == 'pending') badge-warning
@elseif($transfer->status == 'in_transit') badge-info
@elseif($transfer->status == 'completed') badge-success
@elseif($transfer->status == 'cancelled') badge-danger @endif">

                                                            {{ ucfirst($transfer->status) }}

                                                        </span>

                                                    </td>


                                                    <td>
                                                        @can('view_stocktransfers')
                                                            <a href="{{ route('stock-transfers.show', $transfer->id) }}"
                                                                class="btn btn-info btn-sm" title="View Details">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        @endcan
                                                    </td>

                                                </tr>
                                            @endforeach

                                        </tbody>

                                    </table>

                                </div>



                            </div>

                        </div>

                    </div>

                </div>

            </section>

        </div>

    @endsection
