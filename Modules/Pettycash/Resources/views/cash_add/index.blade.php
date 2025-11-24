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
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Petty Cash</h1>
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
                                    <a href="{{ route('pettycash-addcash.index', ['filter' => '7days']) }}"
                                        class="btn {{ request('filter') == '7days' ? 'active-btn' : '' }}">7 Days</a>

                                    <a href="{{ route('pettycash-addcash.index', ['filter' => '15days']) }}"
                                        class="btn {{ request('filter') == '15days' ? 'active-btn' : '' }}">15 Days</a>

                                    <a href="{{ route('pettycash-addcash.index', ['filter' => '1month']) }}"
                                        class="btn {{ request('filter') == '1month' ? 'active-btn' : '' }}">1 Month</a>

                                    <button id="customBtn"
                                        class="btn {{ request('start_date') && request('end_date') ? 'active-btn' : '' }}"
                                        type="button">Custom</button>
                                </div>

                                <!-- Right: Create Button -->
                                @if (auth()->user()->role->name === 'Super Admin')
                                    @can('create_pettycash')
                                        <h3 class="card-title float-right">
                                            <a class="btn btn-info text-white" data-toggle="modal"
                                                data-target="#exampleModalCenter">
                                                <i class="fa fa-plus"></i> Create
                                            </a>
                                        </h3>
                                    @endcan
                                    @include('pettycash::cash_add.create')
                                @endif
                            </div>

                            <!-- Custom Date Filter -->
                            <div id="customDateFilter"
                                style="{{ request('start_date') && request('end_date') ? '' : 'display:none;' }}; margin:10px;">
                                <form method="GET" action="{{ route('pettycash-addcash.index') }}" class="row g-2">
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

                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Branch</th>
                                            <th class="text-center">Date (Month)</th>
                                            <th class="text-center">Add AMT</th>
                                            <th class="text-center">Last Month Remaining AMT</th>
                                            <th class="text-center">Total AMT</th>
                                            <th class="text-center">Remaining AMT</th>
                                            <th class="text-center">Title</th>
                                            @if (auth()->user()->role->name === 'Super Admin')
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pettycash as $value)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $value->branch->name ?? 'N/A' }}</td>
                                                <td class="text-center">
                                                    {{ \Carbon\Carbon::parse($value->date)->format('F Y') }}</td>
                                                <td class="text-center">{{ $value->amount }}</td>
                                                <td class="text-center">{{ $value->lm_remaining_cash }}</td>
                                                <td class="text-center">{{ $value->total_amount }}</td>
                                                <td class="text-center">{{ $value->remaining_cash }}</td>
                                                <td class="text-center">{{ $value->title }}</td>
                                                @if (auth()->user()->role->name === 'Super Admin')
                                                    <td class="text-center">
                                                        @if ($value->status == 'on')
                                                            <a href="{{ route('pettycash-addcash.status', $value->id) }}"
                                                                class="btn btn-success btn-sm">On</a>
                                                        @else
                                                            <a href="{{ route('pettycash-addcash.status', $value->id) }}"
                                                                class="btn btn-danger btn-sm">Off</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @can('edit_pettycash')
                                                            <a data-toggle="modal"
                                                                data-target="#editCategory{{ $value->id }}"
                                                                class="btn btn-primary btn-sm" data-toggle="tooltip"
                                                                title="Edit">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                        @endcan
                                                        @include('pettycash::cash_add.edit')
                                                        @can('delete_pettycash')
                                                            <button id="delete" class="btn btn-danger btn-sm"
                                                                data-toggle="tooltip" title="Delete"
                                                                onclick="event.preventDefault();
                                                                if (confirm('Are you sure? It will delete the data permanently!')) {
                                                                    document.getElementById('destroy{{ $value->id }}').submit();
                                                                }">
                                                                <i class="fa fa-trash"></i>
                                                                <form id="destroy{{ $value->id }}" class="d-none"
                                                                    action="{{ route('pettycash-addcash.destroy', $value->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                </form>
                                                            </button>
                                                        @endcan
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Branch</th>
                                            <th class="text-center">Date (Month)</th>
                                            <th class="text-center">Add AMT</th>
                                            <th class="text-center">Last Month Remaining AMT</th>
                                            <th class="text-center">Total AMT</th>
                                            <th class="text-center">Remaining AMT</th>
                                            <th class="text-center">Title</th>
                                            @if (auth()->user()->role->name === 'Super Admin')
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Action</th>
                                            @endif
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
    </style>
@endsection
