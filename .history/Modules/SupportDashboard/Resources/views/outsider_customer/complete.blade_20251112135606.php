@extends('setting::layouts.master')

@section('title', ' Complete')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Complete</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Complete</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Complete</li>
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

                        <!-- /.card -->
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Mobile</th>
                                            <th class="text-center">Address</th>
                                            <th class="text-center">Product</th>
                                            <th class="text-center">Amount</th>
                                            <th class="text-center">Paid</th>
                                            <th class="text-center">Due</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customers as $key => $customer)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $customer->customer_name }}</td>
                                                <td class="text-center">{{ $customer->contact }}</td>
                                                <td class="text-center">{{ $customer->address }}</td>
                                                <td class="text-center">Hello</td>
                                                <td class="text-center">{{ $customer->total_amount }}</td>
                                                <td class="text-center">{{ $customer->paid_amount ?? '0' }}</td>
                                                <td class="text-center text-danger">{{ $customer->due_amount }}</td>
                                                <td class="text-center">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <a type="button"
                                                                href="{{ route('outsidercustomer-ticket.details', $customer->id) }}"
                                                                class="btn btn-primary btn-sm" disabled
                                                                data-toggle="tooltip" data-placement="top" title="Details">
                                                                Detail's
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Mobile</th>
                                            <th class="text-center">Address</th>
                                            <th class="text-center">Product</th>
                                            <th class="text-center">Amount</th>
                                            <th class="text-center">Paid</th>
                                            <th class="text-center">Due</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    <script>
        document.querySelectorAll('.view-btn').forEach(btn => {
            const box = btn.closest('td').querySelector('.details-box');

            btn.addEventListener('mouseenter', () => {
                box.style.display = 'block';
            });

            btn.addEventListener('mouseleave', () => {
                // Hide only after a small delay to allow smooth hover transition
                setTimeout(() => {
                    if (!box.matches(':hover')) {
                        box.style.display = 'none';
                    }
                }, 150);
            });

            box.addEventListener('mouseenter', () => {
                box.style.display = 'block';
            });

            box.addEventListener('mouseleave', () => {
                box.style.display = 'none';
            });
        });
    </script>


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
