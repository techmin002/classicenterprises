@extends('setting::layouts.master')

@section('title', 'Expenses')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Expenses</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Expenses</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Expenses</li>
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

                        <div class="card">
                            <div class="card-header">
                                <!-- ✅ Filter Buttons -->
                                <div class="btn-group petty-filter" role="group">
                                    <a href="{{ route('petty.expenses.index', ['filter' => '7days']) }}"
                                        class="btn {{ request('filter') == '7days' ? 'active-btn' : '' }}">7 Days</a>

                                    <a href="{{ route('petty.expenses.index', ['filter' => '15days']) }}"
                                        class="btn {{ request('filter') == '15days' ? 'active-btn' : '' }}">15 Days</a>

                                    <a href="{{ route('petty.expenses.index', ['filter' => '1month']) }}"
                                        class="btn {{ request('filter') == '1month' ? 'active-btn' : '' }}">1 Month</a>

                                    <button id="customBtn"
                                        class="btn {{ request('start_date') && request('end_date') ? 'active-btn' : '' }}"
                                        type="button">Custom</button>
                                </div>

                                <!-- ✅ Create Expense Button -->
                                @can('create_expense')
                                    <h3 class="card-title float-right"><a class="btn btn-info text-white" data-toggle="modal"
                                            data-target="#exampleModalCenter"><i class="fa fa-plus"></i> Create</a> </h3>
                                @endcan
                                @include('expenses::expenses.create')
                            </div>

                            <!-- ✅ Custom Date Filter -->
                            <div id="customDateFilter"
                                style="{{ request('start_date') && request('end_date') ? '' : 'display:none;' }}; margin:10px;">
                                <form method="GET" action="{{ route('petty.expenses.index') }}" class="row g-2">
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
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Expense Type</th>
                                            <th class="text-center">Amount</th>
                                            <th class="text-center">Mode</th>
                                            <th class="text-center">Title</th>
                                            <th class="text-center">Receipt</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($expenses as $exp)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">
                                                    {{ $exp->created_at ? $exp->created_at->format('Y.m.d') : 'N/A' }}
                                                </td>
                                                <td class="text-center">{{ $exp->category['title'] ?? 'N/A' }}</td>
                                                <td class="text-center">{{ $exp->amount }}</td>
                                                <td class="text-center">{{ ucfirst($exp->mode) }}</td>
                                                <td class="text-center">{{ $exp->title }}</td>
                                                <td class="text-center">
                                                    @if ($exp->receipt)
                                                        <a href="{{ asset('upload/images/expenses-receipt/' . $exp->receipt) }}"
                                                            target="_blank">View Receipt</a>
                                                    @else
                                                        <span class="text-muted">No Receipt</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @can('edit_expense')
                                                        <a data-toggle="modal" data-target="#editCategory{{ $exp->id }}"
                                                            class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                                    @endcan
                                                    @include('expenses::expenses.edit')

                                                    @can('delete_expense')
                                                        <button id="delete" class="btn btn-danger btn-sm"
                                                            onclick="
                                                                event.preventDefault();
                                                                if (confirm('Are you sure? It will delete the data permanently!')) {
                                                                    document.getElementById('destroy{{ $exp->id }}').submit()
                                                                }
                                                            ">
                                                            <i class="fa fa-trash"></i>
                                                            <form id="destroy{{ $exp->id }}" class="d-none"
                                                                action="{{ route('expenses.destroy', $exp->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('delete')
                                                            </form>
                                                        </button>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Expense Type</th>
                                            <th class="text-center">Amount</th>
                                            <th class="text-center">Mode</th>
                                            <th class="text-center">Title</th>
                                            <th class="text-center">Receipt</th>
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

    {{-- ✅ Custom Filter Button Script --}}
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

    {{-- ✅ Filter Buttons Custom CSS --}}
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
