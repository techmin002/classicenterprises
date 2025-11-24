@extends('setting::layouts.master')

@section('title', ' Report')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Report</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Report</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Report</li>
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
                                                @foreach ($amccustomer as $key => $customer)
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        @if ($customer->type == 'register')
                                                            <td class="text-center">{{ $customer->customer->lead->name }}
                                                            </td>
                                                        @else
                                                            <td class="text-center">{{ $customer->customer_name }}</td>
                                                        @endif
                                                        @if ($customer->type == 'register')
                                                            <td class="text-center">
                                                                {{ $customer->customer->lead->mobile }}</td>
                                                        @else
                                                            <td class="text-center">{{ $customer->contact }}</td>
                                                        @endif
                                                        <td class="text-center">{{ $customer->amc->title }}</td>
                                                        <td class="text-center">{{ $customer->amc->price }}</td>
                                                        <td class="text-center">Rs.{{ $customer->amount ?? '0' }}</td>
                                                        <td class="text-center">
                                                            Rs.{{ $customer->amc->price - $customer->amount ?? '0' }}
                                                        </td>
                                                        <td>
                                                            <a href="" class="btn btn-primary btn-sm"
                                                                data-toggle="modal"
                                                                data-target="#exampleModalamc{{ $customer->id }}"> Create
                                                                Ticket</a>

                                                            <div class="modal fade"
                                                                id="exampleModalamc{{ $customer->id }}" tabindex="-1"
                                                                role="dialog" aria-labelledby="exampleModalLabel"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog modal-lg" role="document">
                                                                    <div class="modal-content border-0 shadow">

                                                                        <!-- Modal Header -->
                                                                        <div class="modal-header bg-primary text-white">
                                                                            <div>
                                                                                <h5 class="modal-title mb-0"
                                                                                    id="exampleModalLabel">
                                                                                    <i class="fa fa-headset mr-2"></i>
                                                                                    Create
                                                                                    Support Ticket
                                                                                </h5>
                                                                                <small>Customer:
                                                                                    <strong>{{ ucfirst($customer->customer_name) }}</strong></small>
                                                                            </div>
                                                                            <button type="button"
                                                                                class="close text-white"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>

                                                                        <!-- Modal Body -->
                                                                        <form
                                                                            action="{{ route('amccustomer-ticket.store') }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <div class="modal-body">
                                                                                <input type="hidden" name='type'
                                                                                    value="amc">
                                                                                <input type="hidden" name="customer_id"
                                                                                    value="{{ $customer->id }}">
                                                                                <div class="form-group">
                                                                                    <label for="support_type"
                                                                                        class="font-weight-bold">Support
                                                                                        Type</label>
                                                                                    <select name="support_type"
                                                                                        id="support_type"
                                                                                        class="form-control">
                                                                                        <option value="" selected
                                                                                            disabled>
                                                                                            Select Support Type</option>
                                                                                        <option value="normal_service">
                                                                                            Normal
                                                                                            Service
                                                                                        </option>
                                                                                        <option value="maintenance">
                                                                                            Maintenance
                                                                                        </option>
                                                                                        <option value="location_shifting">
                                                                                            Location
                                                                                            Shifting
                                                                                        </option>
                                                                                    </select>
                                                                                </div>

                                                                                <div class="form-group">
                                                                                    <label for="priority"
                                                                                        class="font-weight-bold">Priority</label>
                                                                                    <select name="priority" id="priority"
                                                                                        class="form-control">
                                                                                        <option value="" selected
                                                                                            disabled>
                                                                                            Select Priority</option>
                                                                                        <option value="high">High
                                                                                        </option>
                                                                                        <option value="medium">Medium
                                                                                        </option>
                                                                                        <option value="low">Low</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="amc"
                                                                                        class="font-weight-bold">AMC</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        id="amc_display" value="AMC In"
                                                                                        readonly>
                                                                                    <input type="hidden" name="amc"
                                                                                        value="in">
                                                                                </div>
                                                                                @php
                                                                                    // Calculate warranty period (1 year from created_at)
                                                                                    $warrantyExpiryDate = Carbon\Carbon::parse(
                                                                                        $customer->created_at,
                                                                                    )->addYear();
                                                                                    $isWarrantyIn = Carbon\Carbon::now()->lt(
                                                                                        $warrantyExpiryDate,
                                                                                    );
                                                                                @endphp

                                                                                <div class="form-group">
                                                                                    <label for="warranty"
                                                                                        class="font-weight-bold">Warranty</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        id="warranty" name="warranty"
                                                                                        value="{{ $isWarrantyIn ? 'Warranty In' : 'Warranty Out' }}"
                                                                                        readonly>
                                                                                </div>

                                                                                <div class="form-group">
                                                                                    <label for="message"
                                                                                        class="font-weight-bold">Message</label>
                                                                                    <textarea name="message" id="message" class="form-control" rows="4" placeholder="Enter message..."></textarea>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Modal Footer -->
                                                                            <div class="modal-footer bg-light">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-dismiss="modal">
                                                                                    <i class="fa fa-times mr-1"></i> Close
                                                                                </button>
                                                                                <button type="submit"
                                                                                    class="btn btn-success">
                                                                                    <i class="fa fa-paper-plane mr-1"></i>
                                                                                    Create
                                                                                    Support
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
