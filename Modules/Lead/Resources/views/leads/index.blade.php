@extends('setting::layouts.master')

@section('title', "{$type} Leads")
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">{{ ucfirst($type) }} Leads</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ ucfirst($type) }} Leads</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">{{ ucfirst($type) }} Leads</li>
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
                                <!-- Left: Filter Buttons -->
                                <div class="btn-group petty-filter" role="group">
                                    <a href="{{ route($leadtype, ['filter' => '7days']) }}"
                                        class="btn {{ request('filter') == '7days' ? 'active-btn' : '' }}">7 Days</a>

                                    <a href="{{ route($leadtype, ['filter' => '15days']) }}"
                                        class="btn {{ request('filter') == '15days' ? 'active-btn' : '' }}">15 Days</a>

                                    <a href="{{ route($leadtype, ['filter' => '1month']) }}"
                                        class="btn {{ request('filter') == '1month' ? 'active-btn' : '' }}">1 Month</a>

                                    <button id="customBtn"
                                        class="btn {{ request('start_date') && request('end_date') ? 'active-btn' : '' }}"
                                        type="button">Custom</button>
                                </div>
                                @can('create_leads')
                                    <h3 class="card-title float-right"><a class="btn btn-info text-white" data-toggle="modal"
                                            data-target="#exampleModalCenter"><i class="fa fa-plus"></i> Create</a> </h3>
                                @endcan
                                @include('lead::leads.create')
                            </div>
                            <!-- Custom Date Filter -->
                            <div id="customDateFilter"
                                style="{{ request('start_date') && request('end_date') ? '' : 'display:none;' }}; margin:10px;">
                                <form method="GET" action="{{ route($leadtype) }}" class="row g-2">
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
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Lead ID</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Mobile</th>
                                            <th class="text-center">Address</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Time</th>
                                            <th class="text-center">Lead Source</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($leads as $key => $exp)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $exp->id }}</td>
                                                <td class="text-center">{{ $exp->name }}</td>
                                                <td class="text-center">{{ $exp->mobile }}</td>
                                                <td class="text-center">{{ $exp->address }}</td>
                                                <td class="text-center">
                                                    {{ \Carbon\Carbon::parse($exp->created_at)->format('d-m-Y | h:i A') }}
                                                </td>

                                                <td class="text-center text-muted">
                                                    {{ $exp->created_time ?? 'N/A' }}
                                                </td>
                                                <td class="text-center">{{ $exp->lead_source }}</td>

                                                <td>
                                                    <div class="row">
                                                        @can('show_leads')
                                                            <div class="col-md-12"> <a type="button"
                                                                    class="btn btn-info btn-sm"
                                                                    href="{{ route('leads.show', $exp->id) }}">View
                                                                    Responses</a>
                                                            </div>
                                                        @endcan
                                                        {{-- <a type="button" href="{{ route('lead.details', $exp->id) }}"
                                                            class="btn btn-info btn-sm my-2" disabled data-toggle="tooltip"
                                                            data-placement="top" title="Details">Detail's
                                                        </a> --}}
                                                        <div class="col-md-12 mt-2">
                                                            @can('edit_leads')
                                                                <a type="button" href="{{ route('lead.clients', $exp->id) }}"
                                                                    class="btn btn-secondary btn-sm" data-toggle="tooltip"
                                                                    data-placement="top" title="Move To Installation Queue">
                                                                    <i class="fa fa-shopping-cart"></i>
                                                                </a>

                                                                <a type="button" class="btn btn-warning btn-sm"
                                                                    data-toggle="modal"
                                                                    data-target="#branchTransferModal{{ $exp->id }}"
                                                                    data-toggle="tooltip" data-placement="top"
                                                                    title="Move To Branch ">
                                                                    <i class="fas fa-exchange-alt"></i>
                                                                </a>

                                                                <!-- Modal -->
                                                                <div class="modal fade"
                                                                    id="branchTransferModal{{ $exp->id }}"
                                                                    tabindex="-1" role="dialog"
                                                                    aria-labelledby="branchTransferModalLabel"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title"
                                                                                    id="branchTransferModalLabel">
                                                                                    Lead Transfer</h5>
                                                                                <button type="button" class="close"
                                                                                    data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <!-- Branch transfer form -->
                                                                                <form action="{{ route('lead.transfer') }}"
                                                                                    method="POST">
                                                                                    @csrf

                                                                                    <div class="form-group">
                                                                                        <label>Lead :
                                                                                            {{ $exp->name }}</label>
                                                                                    </div>

                                                                                    <div class="form-group">
                                                                                        <input type="hidden" name="lead_id"
                                                                                            value="{{ $exp->id }}">
                                                                                        <label>Select Branch</label>
                                                                                        <select name="branch_id"
                                                                                            class="form-control" required>
                                                                                            <option value="" selected
                                                                                                disabled>
                                                                                                Select Branch</option>
                                                                                            @foreach ($branches as $branch)
                                                                                                @if ($branch->id != $exp->branch_id)
                                                                                                    <!-- Exclude current branch -->
                                                                                                    <option
                                                                                                        value="{{ $branch->id }}">
                                                                                                        {{ $branch->name }}
                                                                                                        ({{ $branch->branch_code ?? 'N/A' }})
                                                                                                    </option>
                                                                                                @endif
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                    <button type="submit"
                                                                                        class="btn btn-success">Submit</button>
                                                                                </form>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <a data-toggle="modal"
                                                                    data-target="#editCategory{{ $exp->id }}"
                                                                    class="btn btn-primary btn-sm"><i class="fa fa-edit"></i>
                                                                </a>
                                                            @endcan
                                                            @include('lead::leads.edit')
                                                            @can('delete_leads')
                                                                <button id="delete" class="btn btn-danger btn-sm"
                                                                    onclick="event.preventDefault();if (confirm('Are you sure? It will delete the data permanently!')) {document.getElementById('destroy{{ $exp->id }}').submit()}">
                                                                    <i class="fa fa-trash"></i>
                                                                    <form id="destroy{{ $exp->id }}" class="d-none"
                                                                        action="{{ route('leads.destroy', $exp->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('delete')
                                                                    </form>
                                                                </button>
                                                            @endcan
                                                        </div>

                                                    </div>

                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Lead ID</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Mobile</th>
                                            <th class="text-center">Address</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Time</th>
                                            <th class="text-center">Lead Source</th>
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
