@extends('setting::layouts.master')
@section('title', 'Petty Cash')

{{-- Petty Cash Filter Buttons Custom CSS --}}
<style>
    /* Common button base */
    .petty-filter .btn {
        margin-right: 12px;
        padding: 10px 26px;
        font-weight: 600;
        font-size: 15px;
        border-radius: 14px !important;
        transition: all 0.3s ease-in-out;
        position: relative;
    }

    /* Non-active buttons = secondary style */
    .petty-filter .btn:not(.active-btn) {
        background: #f1f3f5;
        color: #555;
        border: 1px solid #d1d5db;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .petty-filter .btn:not(.active-btn):hover {
        background: #e9ecef;
        color: #0d6efd;
        border-color: #0d6efd;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(13, 110, 253, 0.15);
    }

    /* Active button = royal standout */
    .petty-filter .active-btn {
        background: linear-gradient(135deg, #0d6efd, #0b5ed7) !important;
        color: #fff !important;
        border: none !important;
        box-shadow: 0 6px 20px rgba(13, 110, 253, 0.35) !important;
        transform: translateY(-2px) scale(1.04);
    }

    .petty-filter .active-btn::after {
        content: '';
        position: absolute;
        top: -6px;
        left: -6px;
        right: -6px;
        bottom: -6px;
        background: rgba(13, 110, 253, 0.2);
        border-radius: 18px;
        filter: blur(18px);
        z-index: -1;
    }
</style>

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Petty Cash Transaction</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Petty Cash Transaction</h1>
                    </div>
                </div>
            </div>
        </section>

        <!-- Filter Buttons -->
        <section class="content">
            <div class="mb-3">
                <div class="btn-group petty-filter" role="group">
                    <a href="{{ route('pettycash-transaction.index', ['filter' => '7days']) }}"
                        class="btn {{ request('filter') == '7days' ? 'active-btn' : '' }}">7 Days</a>

                    <a href="{{ route('pettycash-transaction.index', ['filter' => '15days']) }}"
                        class="btn {{ request('filter') == '15days' ? 'active-btn' : '' }}">15 Days</a>

                    <a href="{{ route('pettycash-transaction.index', ['filter' => '1month']) }}"
                        class="btn {{ request('filter') == '1month' ? 'active-btn' : '' }}">1 Month</a>

                    <button id="customBtn"
                        class="btn {{ request('start_date') && request('end_date') ? 'active-btn' : '' }}"
                        type="button">Custom</button>
                </div>

                <!-- Custom date filter (hidden by default) -->
                <div id="customDateFilter"
                    style="{{ request('start_date') && request('end_date') ? '' : 'display: none;' }}; margin-top: 10px;">
                    <form method="GET" action="{{ route('pettycash-transaction.index') }}" class="row g-2">
                        <div class="col-auto">
                            <label for="start_date" class="form-label fw-bold text-dark">Start Date:</label>
                            <input type="date" id="start_date" name="start_date" class="form-control shadow-sm rounded"
                                value="{{ request('start_date') }}">
                        </div>
                        <div class="col-auto">
                            <label for="end_date" class="form-label fw-bold text-dark">End Date:</label>
                            <input type="date" id="end_date" name="end_date" class="form-control shadow-sm rounded"
                                value="{{ request('end_date') }}">
                        </div>
                        <div class="col-auto d-flex align-items-end">
                            <button type="submit" class="btn btn-success btn-sm shadow-sm px-4">Filter</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Transactions Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">S.N</th>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Month</th>
                                        <th class="text-center">Type</th>
                                        <th class="text-center">Opening Balance</th>
                                        <th class="text-center">Amount</th>
                                        <th class="text-center">Closing Balance</th>
                                        <th class="text-center">Message</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactions as $value)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">
                                                {{ $value->created_at ? $value->created_at->format('Y.m.d') : 'N/A' }}</td>
                                            <td class="text-center">
                                                {{ $value->created_at->format('Y M') ?? 'N/A' }}
                                            </td>
                                            <td class="text-center">{{ ucfirst($value->category['title'] ?? 'N/A') }}</td>
                                            <td class="text-center">{{ number_format($value->total_cash_before, 2) }}</td>
                                            <td class="text-center">{{ number_format($value->amount, 2) }}</td>
                                            <td class="text-center">{{ number_format($value->remaining_cash_after, 2) }}
                                            </td>
                                            <td class="text-center">{{ $value->message }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-center">S.N</th>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Month</th>
                                        <th class="text-center">Type</th>
                                        <th class="text-center">Opening Balance</th>
                                        <th class="text-center">Amount</th>
                                        <th class="text-center">Closing Balance</th>
                                        <th class="text-center">Message</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- JS for Custom Button --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const customBtn = document.getElementById('customBtn');
            const customFilter = document.getElementById('customDateFilter');
            const filterButtons = document.querySelectorAll('.petty-filter .btn');

            // Custom button toggle
            customBtn.addEventListener('click', function() {
                // remove active from all
                filterButtons.forEach(btn => btn.classList.remove('active-btn'));

                // add active to custom button
                customBtn.classList.add('active-btn');

                // toggle filter
                if (customFilter.style.display === 'none') {
                    customFilter.style.display = 'block';
                } else {
                    customFilter.style.display = 'none';
                    customBtn.classList.remove('active-btn'); // hide active when closed
                }
            });
        });
    </script>
@endsection
