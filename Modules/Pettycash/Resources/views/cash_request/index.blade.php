@extends('setting::layouts.master')

@section('title', 'Petty Cash Request')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Petty Cash Request</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Petty Cash Request</h1>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- Card -->
                        <div class="card">
                            <div class="card-header">
                                <!-- Left: Filter Buttons -->
                                <div class="btn-group petty-filter" role="group">
                                    <a href="{{ route('pettycash-request.index', ['filter' => '7days']) }}"
                                        class="btn {{ request('filter') == '7days' ? 'active-btn' : '' }}">7 Days</a>

                                    <a href="{{ route('pettycash-request.index', ['filter' => '15days']) }}"
                                        class="btn {{ request('filter') == '15days' ? 'active-btn' : '' }}">15 Days</a>

                                    <a href="{{ route('pettycash-request.index', ['filter' => '1month']) }}"
                                        class="btn {{ request('filter') == '1month' ? 'active-btn' : '' }}">1 Month</a>

                                    <button id="customBtn"
                                        class="btn {{ request('start_date') && request('end_date') ? 'active-btn' : '' }}"
                                        type="button">Custom</button>
                                </div>

                                <!-- Right: Create Button -->
                                @if (auth()->user()->role->name !== 'Super Admin')
                                    <h3 class="card-title float-right">
                                        <a class="btn btn-info text-white" data-toggle="modal"
                                            data-target="#exampleModalCenter">
                                            <i class="fa fa-plus"></i> Request Extra Cash
                                        </a>
                                    </h3>
                                    @include('pettycash::cash_request.create')
                                @endif
                            </div>

                            <!-- Custom Date Filter -->
                            <div id="customDateFilter"
                                style="{{ request('start_date') && request('end_date') ? '' : 'display:none;' }}; margin:10px;">
                                <form method="GET" action="{{ route('pettycash-request.index') }}" class="row g-2">
                                    <div class="col-auto">
                                        <label for="start_date" class="form-label fw-bold text-dark">Start Date:</label>
                                        <input type="date" id="start_date" name="start_date"
                                            class="form-control shadow-sm rounded" value="{{ request('start_date') }}">
                                    </div>
                                    <div class="col-auto">
                                        <label for="end_date" class="form-label fw-bold text-dark">End Date:</label>
                                        <input type="date" id="end_date" name="end_date"
                                            class="form-control shadow-sm rounded" value="{{ request('end_date') }}">
                                    </div>
                                    <div class="col-auto d-flex align-items-end">
                                        <button type="submit" class="btn btn-success btn-sm shadow-sm px-4">Filter</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Table -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Branch</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Amount</th>
                                            <th class="text-center">Title</th>
                                            <th class="text-center">Description</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($requests as $req)
                                            <tr
                                                class="
    @if ($req->status === 'pending') bg-warning-light
    @elseif($req->status === 'rejected') bg-danger-light text-dark @endif">
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $req->branch->name ?? 'N/A' }}</td>
                                                <td class="text-center">
                                                    {{ \Carbon\Carbon::parse($req->date)->format('Y.m.d') }}
                                                </td>
                                                <td class="text-center">{{ $req->amount }}</td>
                                                <td class="text-center">{{ $req->title }}</td>
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
                                                    @if (auth()->user()->can('edit_pettycash'))
                                                        @if (Auth::user()->role->name === 'Super Admin')
                                                            @if ($req->status === 'pending')
                                                                <button type="button"
                                                                    class="btn btn-primary btn-sm text-white"
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
                                                            @if ($req->status === 'approved' || $req->status === 'rejected')
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm text-white">
                                                                    Locked
                                                                </button>
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
                                                    @endif
                                                    <a href="" data-toggle="modal"
                                                        data-target="#logModalCenter{{ $req['id'] }}"
                                                        class="btn btn-info btn-sm"> <i class="fa fa-eye"></i> Log</a>
                                                    <div class="modal fade" id="logModalCenter{{ $req['id'] }}"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="logModalCenterTitle" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content" style="border-radius: 8px;">
                                                                <div class="modal-header justify-content-center"
                                                                    style="background-color: #0837a4; color: #fff;">
                                                                    <h4 class="modal-title" id="staticBackdropLabel">
                                                                        Petty Cash Request Log</h4>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true"
                                                                            class="text-light">&times;</span>
                                                                    </button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <div class="container">
                                                                        <div class="row gy-3">
                                                                            <div class="col-lg-12">
                                                                                <table class="table">
                                                                                    @php
                                                                                        $requested = App\Models\User::where(
                                                                                            'id',
                                                                                            $req['requested_by'],
                                                                                        )
                                                                                            ->select('name')
                                                                                            ->first();
                                                                                        $approved = App\Models\User::where(
                                                                                            'id',
                                                                                            $req['transfer_by'],
                                                                                        )
                                                                                            ->select('name')
                                                                                            ->first();
                                                                                    @endphp
                                                                                    <tr>
                                                                                        <th>Requested By</th>
                                                                                        <th>Request Date</th>
                                                                                        @if ($approved != null)
                                                                                            <th>Approved By</th>
                                                                                            <th>Approved Date</th>
                                                                                        @endif
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>{{ $requested['name'] }}</td>
                                                                                        <td>{{ $req['created_at']->format('Y.m.d') }}</td>
                                                                                        @if ($approved != null)
                                                                                            <td>{{ $approved['name'] ?? 'N/A' }}
                                                                                            </td>
                                                                                            <td>{{ $req['updated_at'] }}
                                                                                            </td>
                                                                                        @endif
                                                                                    </tr>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <span id="output"></span>
                                                        </div>
                                                    </div>
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
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Amount</th>
                                            <th class="text-center">Title</th>
                                            <th class="text-center">Description</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- Custom Filter Button Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const customBtn = document.getElementById('customBtn');
            const customFilter = document.getElementById('customDateFilter');
            const filterButtons = document.querySelectorAll('.petty-filter .btn');

            customBtn.addEventListener('click', function() {
                filterButtons.forEach(btn => btn.classList.remove('active-btn'));
                customBtn.classList.add('active-btn');

                if (customFilter.style.display === 'none') {
                    customFilter.style.display = 'block';
                } else {
                    customFilter.style.display = 'none';
                    customBtn.classList.remove('active-btn');
                }
            });
        });
    </script>

    {{-- Filter Buttons Custom CSS --}}
    <style>
        .petty-filter .btn {
            margin-right: 12px;
            padding: 8px 20px;
            font-weight: 600;
            font-size: 14px;
            border-radius: 12px !important;
            transition: all 0.3s ease-in-out;
            position: relative;
        }

        .petty-filter .btn:not(.active-btn) {
            background: #f1f3f5;
            color: #555;
            border: 1px solid #d1d5db;
        }

        .petty-filter .btn:not(.active-btn):hover {
            background: #e9ecef;
            color: #0d6efd;
            border-color: #0d6efd;
            transform: translateY(-2px);
        }

        .petty-filter .active-btn {
            background: linear-gradient(135deg, #0d6efd, #0b5ed7) !important;
            color: #fff !important;
            border: none !important;
        }

        .bg-warning-light {
            background-color: #fff3cd !important;
            /* halka yellow */
            color: #856404 !important;
        }

        .bg-danger-light {
            background-color: #f8d7da !important;
            /* halka red */
            color: #721c24 !important;
        }
    </style>
@endsection
