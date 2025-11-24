@extends('setting::layouts.master')

@section('title', ' Ticket Queue')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active"> Ticket Queue</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Ticket Queue</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Ticket Queue</li>
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
                                            <th class="text-center">Warranty</th>
                                            <th class="text-center">Category</th>
                                            <th class="text-center">Priority</th>
                                            <th class="text-center">Time</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customers as $key => $exp)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $exp->customer->lead->name ?? 'N/A' }}</td>
                                                <td class="text-center">{{ $exp->customer->lead->mobile ?? 'N/A' }}</td>
                                                <td class="text-center">{{ $exp->customer->lead->address ?? 'N/A' }}</td>
                                                <td class="text-center">
                                                    @foreach ($exp->customer->products as $customerProduct)
                                                        {{ $customerProduct->product->name }}
                                                    @endforeach
                                                </td>
                                                <td class="text-center">{{ $exp->warranty }}</td>
                                                <td class="text-center">{{ $exp->support_type }}</td>
                                                <td class="text-center">{{ $exp->priority }}</td>
                                                <td class="text-center text-danger">{{ $$exp->created_time }}</td>
                                                {{-- <td>HELLO</td> --}}
                                                <td>
                                                    <div class="d-flex align-items-center gap-2 mb-2">
                                                        <a data-toggle="modal"
                                                            data-target="#editCategory{{ $exp->id }}"
                                                            style="margin-left: 3px" class="btn btn-primary btn-sm">
                                                            <i class="fa fa-user-plus" title="Move to Assign"></i>
                                                        </a>
                                                        @include('supportdashboard::register_customer.assign_action')
                                                        <button id="delete" class="btn btn-danger btn-sm" disabled
                                                            onclick="event.preventDefault();if (confirm('Are you sure? It will delete the data permanently!')) {document.getElementById('destroy{{ $exp->id }}').submit()}">
                                                            <i class="fa fa-trash"></i>
                                                            <form id="destroy{{ $exp->id }}" class="d-none"
                                                                action="{{ route('leads.destroy', $exp->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('delete')
                                                            </form>
                                                        </button>
                                                    </div>

                                                    <!-- Second row: Note button -->
                                                    <div>
                                                        <button type="button" class="btn btn-info btn-sm" title="Note"
                                                            data-toggle="modal"
                                                            data-target="#noteModal{{ $exp->id }}">
                                                            <i class="fa fa-sticky-note"></i> Note
                                                        </button>
                                                    </div>

                                                    @php
                                                        // Fetch all notes for this lead
                                                        $notes = Modules\SupportDashboard\Entities\TicketNote::where(
                                                            'ticket_id',
                                                            $exp->id,
                                                        )
                                                            ->orderBy('created_at', 'desc')
                                                            ->get();
                                                    @endphp

                                                    <!-- Note Modal -->
                                                    <div class="modal fade" id="noteModal{{ $exp->id }}"
                                                        tabindex="-1" role="dialog" title="Note"
                                                        aria-labelledby="noteModalLabel{{ $exp->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-md" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="noteModalLabel{{ $exp->id }}">Notes
                                                                    </h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>

                                                                <div class="modal-body">

                                                                    <!-- Form for new note -->
                                                                    <form
                                                                        action="{{ route('registercustomer-ticket.message.update', $exp->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <div class="form-group">
                                                                            <label>Add Note</label>
                                                                            <input type="text" name="note"
                                                                                class="form-control"
                                                                                placeholder="Enter note" required>
                                                                        </div>
                                                                        <button type="submit"
                                                                            class="btn btn-success btn-sm mt-2">Submit</button>
                                                                    </form>

                                                                    <!-- Existing Notes Table -->
                                                                    <div class="mb-3 mt-3">
                                                                        <strong>Existing Notes:</strong>

                                                                        @if ($notes->count())
                                                                            <div class="table-responsive mt-2 text-center">
                                                                                <table id="note"
                                                                                    class="table table-bordered table-striped">
                                                                                    <thead class="bg-dark">
                                                                                        <tr>
                                                                                            <th>S.N</th>
                                                                                            <th>Note</th>
                                                                                            <th>Date</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        @foreach ($notes as $index => $note)
                                                                                            <tr>
                                                                                                <td>{{ $index + 1 }}
                                                                                                </td>
                                                                                                <td>{{ $note->note }}
                                                                                                </td>
                                                                                                <td>{{ $note->created_at->format('d M Y, h:i A') }}
                                                                                                </td>
                                                                                            </tr>
                                                                                        @endforeach
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        @else
                                                                            <p class="text-muted mt-2">No notes added yet.
                                                                            </p>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <a type="button" href="{{ route('ticket_customer.details', $exp->id) }}"
                                                        class="btn btn-info btn-sm mt-2" disabled data-toggle="tooltip"
                                                        data-placement="top" title="Details">Detail's
                                                    </a>

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
                                            <th class="text-center">Warranty</th>
                                            <th class="text-center">Category</th>
                                            <th class="text-center">Priority</th>
                                            <th class="text-center">Time</th>
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
