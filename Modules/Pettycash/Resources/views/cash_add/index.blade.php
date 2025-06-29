@extends('setting::layouts.master')

@section('title', 'Petty Cash')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Petty Cash</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Petty Cash</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Petty Cash</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- Card -->
                        <div class="card">
                            <div class="card-header">
                                @can('create_pettycash')
                                    <h3 class="card-title float-right">
                                        <a class="btn btn-info text-white" data-toggle="modal"
                                            data-target="#exampleModalCenter">
                                            <i class="fa fa-plus"></i> Create
                                        </a>
                                    </h3>
                                    @include('pettycash::cash_add.create')
                                @endcan
                            </div>

                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Title</th>
                                            <th class="text-center">Amount</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Month</th>
                                            <th class="text-center">Last Month Remaining Amount</th>
                                            <th class="text-center">Total Amount</th>
                                            <th class="text-center">Remaining Amount</th>
                                            <th class="text-center">Branch</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pettycash as $value)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $value->title }}</td>
                                                <td class="text-center">{{ $value->amount }}</td>
                                                <td class="text-center">{{ $value->date }}</td>
                                                <td class="text-center">{{ $value->month_name }}</td>
                                                <td class="text-center">{{ $value->lm_remaining_cash }}</td>
                                                <td class="text-center">{{ $value->total_amount }}</td>
                                                <td class="text-center">{{ $value->remaining_cash }}</td>
                                                <td class="text-center">{{ $value->branch->name ?? 'N/A' }}</td>
                                                <td class="text-center">
                                                    @if ($value->status == 'on')
                                                        <a href="{{ route('pettycash-addcash.status', $value->id) }}"
                                                            class="btn btn-success btn-sm">On</a>
                                                    @else
                                                        <a href="{{ route('pettycash-addcash.status', $value->id) }}"
                                                            class="btn btn-danger btn-sm">Off</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    @can('edit_pettycash')
                                                        <a data-toggle="modal" data-target="#editCategory{{ $value->id }}"
                                                            class="btn btn-primary btn-sm" data-toggle="tooltip" title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    @endcan
                                                    @include('pettycash::cash_add.edit')
                                                    @can('delete_pettycash')
                                                        <button id="delete" class="btn btn-danger btn-sm"
                                                            data-toggle="tooltip" title="Delete"
                                                            onclick="event.preventDefault();
                                                            if (confirm('Are you sure? It will delete the data permanently!')) {
                                                                document.getElementById('destroy{{ $value->id }}').submit();
                                                            }">
                                                            <i class="fa fa-trash"></i>
                                                            <form id="destroy{{ $value->id }}" class="d-none"
                                                                action="{{ route('pettycash-addcash.destroy', $value->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
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
                                            <th class="text-center">Title</th>
                                            <th class="text-center">Amount</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Month</th>
                                            <th class="text-center">Last Month Remaining Amount</th>
                                            <th class="text-center">Total Amount</th>
                                            <th class="text-center">Remaining Amount</th>
                                            <th class="text-center">Branch</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>

    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection
