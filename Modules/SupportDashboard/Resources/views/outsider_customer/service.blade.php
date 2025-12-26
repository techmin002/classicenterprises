@extends('setting::layouts.master')

@section('title', ' Regular Service')

@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Regular Service</li>
</ol>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Outsider Customer Regular Service</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Regular Service</li>
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
                            <div class="card-body">
                                <table id="example4" class="table table-bordered table-striped datatable-custom">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Mobile</th>
                                            <th class="text-center">Address</th>
                                            <th class="text-center">Product</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($outsider as $key => $customer)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">
                                                {{ $customer->name }}
                                            </td>
                                            <td class="text-center">
                                                {{ $customer->contact_no }}
                                            </td>
                                            <td class="text-center">
                                                {{ $customer->address }}
                                            </td>
                                            <td class="text-center">
                                                {{ $customer->product_name }}
                                            </td>
                                            <td>
                                                <a href="" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModaloutsider{{ $customer->id }}"> Create
                                                    Ticket</a>

                                                <div class="modal fade" id="exampleModaloutsider{{ $customer->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content border-0 shadow">

                                                            <!-- Modal Header -->
                                                            <div class="modal-header bg-primary text-white">
                                                                <div>
                                                                    <h5 class="modal-title mb-0" id="exampleModalLabel">
                                                                        <i class="fa fa-headset mr-2"></i>Outsider Customer Ticket Create
                                                                    </h5>
                                                                    <small>Customer:
                                                                        <strong>{{ ucfirst($customer->name)
                                                                                }}</strong></small>
                                                                </div>
                                                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>

                                                            <!-- Modal Body -->
                                                            <form action="{{ route('outsider-ticket.create',$customer->id) }}" method="POST">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                                                                    <div class="form-group">
                                                                        <label for="support_type" class="font-weight-bold">Support
                                                                            Category</label>
                                                                        <select name="support_type" id="support_type" class="form-control">
                                                                            <option value="" selected disabled>
                                                                                Select Support Category
                                                                            </option>
                                                                            <option value="maintenance">
                                                                                Maintenance</option>
                                                                            <option value="filter_leakage">
                                                                                Filter Leakage</option>
                                                                            <option value="location_shifting">
                                                                                Location Shifting</option>
                                                                            <option value="regular_servicing">
                                                                                Regular Servicing</option>

                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="priority" class="font-weight-bold">Priority</label>
                                                                        <select name="priority" id="priority" class="form-control">
                                                                            <option value="" selected disabled>
                                                                                Select Priority</option>
                                                                            <option value="high">High
                                                                            </option>
                                                                            <option value="medium">Medium
                                                                            </option>
                                                                            <option value="low">Low</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="message" class="font-weight-bold">Message</label>
                                                                        <textarea name="message" id="message" class="form-control" rows="4" placeholder="Enter message..."></textarea>
                                                                    </div>
                                                                </div>

                                                                <!-- Modal Footer -->
                                                                <div class="modal-footer bg-light justify-content-start">
                                                                    <button type="submit" class="btn btn-success">Submit
                                                                    </button>
                                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel
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
                                            <th class="text-center">Address</th>
                                            <th class="text-center">Product</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
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
