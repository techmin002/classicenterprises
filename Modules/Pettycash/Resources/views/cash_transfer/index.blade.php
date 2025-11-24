@extends('setting::layouts.master')

@section('title', 'Petty Cash')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Petty Cash Transfer</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Petty Cash Transfer</h1>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-header">
                                <!-- Left: Filter Buttons -->
                                <div class="btn-group petty-filter" role="group">
                                    <a href="{{ route('pettycash-transfer.index', ['filter' => '7days']) }}"
                                        class="btn {{ request('filter') == '7days' ? 'active-btn' : '' }}">7 Days</a>

                                    <a href="{{ route('pettycash-transfer.index', ['filter' => '15days']) }}"
                                        class="btn {{ request('filter') == '15days' ? 'active-btn' : '' }}">15 Days</a>

                                    <a href="{{ route('pettycash-transfer.index', ['filter' => '1month']) }}"
                                        class="btn {{ request('filter') == '1month' ? 'active-btn' : '' }}">1 Month</a>

                                    <button id="customBtn"
                                        class="btn {{ request('start_date') && request('end_date') ? 'active-btn' : '' }}"
                                        type="button">Custom</button>
                                </div>
                            </div>

                            <!-- Custom Date Filter -->
                            <div id="customDateFilter"
                                style="{{ request('start_date') && request('end_date') ? '' : 'display:none;' }}; margin:10px;">
                                <form method="GET" action="{{ route('pettycash-transfer.index') }}" class="row g-2">
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
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Amount</th>
                                            <th class="text-center">Transfer Mode</th>
                                            <th class="text-center">Description</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($transfer as $tra)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $tra->branch->name }}</td>
                                                <td class="text-center">
                                                    {{ \Carbon\Carbon::parse($tra->date)->format('Y.m.d') }}</td>
                                                <td class="text-center">{{ $tra->amount }}</td>
                                                <td class="text-center">{{ $tra->transfer_method ?? 'N/A' }}</td>
                                                <td class="text-center">{{ $tra->description }}</td>
                                                <td class="text-center">
                                                    <button class="btn btn-warning btn-sm">Transferred</button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center text-danger">No transfers found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                             <th class="text-center">S.N</th>
                                            <th class="text-center">Branch</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Amount</th>
                                            <th class="text-center">Transfer Mode</th>
                                            <th class="text-center">Description</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

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
