@extends('setting::layouts.master')

@section('title', ' Service')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Service</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Service</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Service</li>
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
                            <div class="card-header">
                                <h3><strong>AMC Customer</strong></h3>
                            </div>
                            <div class="card-body">
                                <table id="example3" class="table table-bordered table-striped datatable-custom">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Mobile</th>
                                            <th class="text-center">AMC</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">Paid</th>
                                            <th class="text-center">Due</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @foreach ($serviceData as $key => $data)
    <tr>
        <td class="text-center">{{ $loop->iteration }}</td>

        {{-- Customer Name --}}
        <td class="text-center">{{ $data['customer_name'] }}</td>

        {{-- AMC Name --}}
        <td class="text-center">{{ $data['amc_name'] }}</td>

        {{-- AMC Period --}}
        <td class="text-center">{{ $data['amc_period'] }}</td>

        {{-- Assigned Date --}}
        <td class="text-center">{{ $data['assign_date']->format('d-m-Y') }}</td>

        {{-- All calculated service dates --}}
        <td class="text-center">
            @foreach($data['service_dates'] as $date)
                <span class="badge badge-info d-block mb-1">
                    {{ $date->format('d-m-Y') }}
                </span>
            @endforeach
        </td>

        <td class="text-center">
            <a href="" class="btn btn-primary btn-sm" data-toggle="modal"
               data-target="#exampleModalamc{{ $data['customer_id'] }}">
                Create Ticket
            </a>

            {{-- MODAL --}}
            <div class="modal fade" id="exampleModalamc{{ $data['customer_id'] }}" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content border-0 shadow">

                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">
                                <i class="fa fa-headset mr-2"></i>
                                Create Support Ticket
                            </h5>
                            <button type="button" class="close text-white" data-dismiss="modal">
                                &times;
                            </button>
                        </div>

                        <form action="{{ route('amccustomer-ticket.store') }}" method="POST">
                            @csrf

                            <div class="modal-body">

                                <input type="hidden" name="type" value="amc">
                                <input type="hidden" name="customer_id" value="{{ $data['customer_id'] }}">

                                <div class="form-group">
                                    <label>Support Type</label>
                                    <select name="support_type" class="form-control">
                                        <option value="">Select Support Type</option>
                                        <option value="normal_service">Normal Service</option>
                                        <option value="maintenance">Maintenance</option>
                                        <option value="location_shifting">Location Shifting</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Priority</label>
                                    <select name="priority" class="form-control">
                                        <option value="">Select Priority</option>
                                        <option value="high">High</option>
                                        <option value="medium">Medium</option>
                                        <option value="low">Low</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>AMC</label>
                                    <input type="text" class="form-control" value="AMC In" readonly>
                                    <input type="hidden" name="amc" value="in">
                                </div>

                                {{-- Warranty Calculation --}}
                                @php
                                    $warrantyExpiry = Carbon\Carbon::parse($data['assign_date'])->addYear();
                                    $isWarrantyIn = now()->lt($warrantyExpiry);
                                @endphp

                                <div class="form-group">
                                    <label>Warranty</label>
                                    <input type="text" class="form-control"
                                        value="{{ $isWarrantyIn ? 'Warranty In' : 'Warranty Out' }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label>Message</label>
                                    <textarea name="message" class="form-control" rows="3"></textarea>
                                </div>

                            </div>

                            <div class="modal-footer bg-light">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                    Close
                                </button>
                                <button type="submit" class="btn btn-success">
                                    Create Support
                                </button>
                            </div>

                        </form>

                    </div>
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
                                            <th class="text-center">AMC</th>
                                            <th class="text-center">Paid</th>
                                            <th class="text-center">Total</th>
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
