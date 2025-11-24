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
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Expenses</h1>
                    </div>
                </div>
            </div>
        </section>

        <!-- Expenses Table -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <!-- 🔹 Card Header with Filters & Create Button -->
                        <div class="card-header">
                            <!-- Left: Filter Buttons -->
                            <div class="btn-group petty-filter" role="group">
                                <a href="{{ route('expenses-categories.index', ['filter' => '7days']) }}"
                                    class="btn {{ request('filter') == '7days' ? 'active-btn' : '' }}">7 Days</a>

                                <a href="{{ route('expenses-categories.index', ['filter' => '15days']) }}"
                                    class="btn {{ request('filter') == '15days' ? 'active-btn' : '' }}">15 Days</a>

                                <a href="{{ route('expenses-categories.index', ['filter' => '1month']) }}"
                                    class="btn {{ request('filter') == '1month' ? 'active-btn' : '' }}">1 Month</a>

                                <button id="customBtn"
                                    class="btn {{ request('start_date') && request('end_date') ? 'active-btn' : '' }}"
                                    type="button">Custom</button>
                            </div>
                            <!-- Right: Create Button -->
                            @if (auth()->user()->role->name === 'Super Admin')
                                @can('create_expense')
                                    <h3 class="card-title float-right">
                                        <a class="btn btn-primary text-white" data-toggle="modal"
                                            data-target="#exampleModalCenter">
                                            <i class="fa fa-plus"></i> Create
                                        </a>
                                    </h3>
                                @endcan
                                @include('expenses::category.create')
                            @endif
                        </div>

                        <!-- 🔹 Custom Date Filter (below header) -->
                        <div id="customDateFilter"
                            style="{{ request('start_date') && request('end_date') ? '' : 'display: none;' }}; margin:10px;">
                            <form method="GET" action="{{ route('expenses-categories.index') }}" class="row g-2">
                                <div class="col-auto">
                                    <label for="start_date" class="form-label fw-bold text-dark">Start:</label>
                                    <input type="date" id="start_date" name="start_date"
                                        class="form-control shadow-sm rounded" value="{{ request('start_date') }}">
                                </div>
                                <div class="col-auto">
                                    <label for="end_date" class="form-label fw-bold text-dark">End:</label>
                                    <input type="date" id="end_date" name="end_date"
                                        class="form-control shadow-sm rounded" value="{{ request('end_date') }}">
                                </div>
                                <div class="col-auto d-flex align-items-end">
                                    <button type="submit" class="btn btn-success btn-sm shadow-sm px-4">Filter</button>
                                </div>
                            </form>
                        </div>

                        <!-- Card Body -->
                        <div class="card">
                            <div class="card-head">

                            </div>
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Branch</th>
                                            <th class="text-center">Title</th>
                                            <th class="text-center">Icon</th>
                                            <th class="text-center">Status</th>
                                            @if (auth()->user()->role->name === 'Super Admin')
                                                <th class="text-center">Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($expenses as $exp)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $exp->branch->name ?? 'N/A' }}</td>
                                                <td class="text-center">{{ $exp->title }}</td>
                                                <td class="text-center">
                                                    <img src="{{ asset('upload/images/expenses-category/' . $exp->image) }}"
                                                        alt="" height="100px">
                                                </td>
                                                <td class="text-center">
                                                    @if ($exp->status == 'on')
                                                        <a href="{{ route('expenseCategory.status', $exp->id) }}"
                                                            class="btn btn-success">On</a>
                                                    @else
                                                        <a href="{{ route('expenseCategory.status', $exp->id) }}"
                                                            class="btn btn-danger">Off</a>
                                                    @endif
                                                </td>
                                                @if (auth()->user()->role->name === 'Super Admin')
                                                    <td>
                                                        @can('edit_expense')
                                                            <a data-toggle="modal"
                                                                data-target="#editCategory{{ $exp->id }}"
                                                                class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                                        @endcan
                                                        @include('expenses::category.edit')
                                                        @can('delete_expense')
                                                            <button id="delete" class="btn btn-danger btn-sm"
                                                                onclick="
                                                            event.preventDefault();
                                                            if (confirm('Are you sure?')) {
                                                                document.getElementById('destroy{{ $exp->id }}').submit()
                                                            }">
                                                                <i class="fa fa-trash"></i>
                                                                <form id="destroy{{ $exp->id }}" class="d-none"
                                                                    action="{{ route('expenses-categories.destroy', $exp->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('delete')
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
                                            <th class="text-center">Title</th>
                                            <th class="text-center">Icon</th>
                                            <th class="text-center">Status</th>
                                            @if (auth()->user()->role->name === 'Super Admin')
                                                <th class="text-center">Action</th>
                                            @endif
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
@endsection

{{-- JS for Custom Filter --}}
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
{{-- Custom CSS for filter buttons --}}
<style>
    .petty-filter .btn {
        margin-right: 8px;
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
        box-shadow: 0 4px 10px rgba(13, 110, 253, 0.15);
    }

    .petty-filter .active-btn {
        background: linear-gradient(135deg, #0d6efd, #0b5ed7) !important;
        color: #fff !important;
        border: none !important;
        box-shadow: 0 6px 20px rgba(13, 110, 253, 0.35) !important;
        transform: translateY(-2px) scale(1.04);
    }
</style>
