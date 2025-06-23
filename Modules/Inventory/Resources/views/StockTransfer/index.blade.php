@extends('setting::layouts.master')

@section('title', "Stock Transfer")
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0 bg-light rounded shadow-sm px-3 py-2">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Stock Transfer</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper bg-white rounded shadow-sm p-3">
        <section class="content-header mb-3">
            <div class="container-fluid">
                <div class="row mb-2 align-items-center">
                    <div class="col-sm-6">
                        <h1 class="font-weight-bold text-primary">Stock Transfer</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right bg-light rounded px-2 py-1">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Stock Transfer</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                <h3 class="card-title mb-0">Stock Transfer List</h3>
                                <div class="ml-auto">
                                    <a class="btn btn-light text-primary font-weight-bold" data-toggle="modal"
                                        data-target="#createStockTransfer"><i class="fa fa-plus"></i> Create</a>
                                    @include('inventory::StockTransfer.create')
                                </div>
                            </div>
                            <div class="card-body bg-light">
                                <table id="example1" class="table table-bordered table-striped table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">From Location</th>
                                            <th class="text-center">To Location</th>
                                            <th class="text-center">Total Quantity</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($stockTransfers as $key => $transfer)
                                        <tr>
                                            <td class="text-center align-middle">{{ $key + 1 }}</td>
                                            <td class="text-center align-middle">{{ optional($transfer->fromBranch)->name ?? 'N/A' }}</td>
                                            <td class="text-center align-middle">{{ optional($transfer->toBranch)->name ?? 'N/A' }}</td>
                                            <td class="text-center align-middle">
                                                {{
                                                    ($transfer->accessories && $transfer->accessories->count() > 0 ? $transfer->accessories->sum('pivot.quantity') : 0)
                                                    +
                                                    ($transfer->machineries && $transfer->machineries->count() > 0 ? $transfer->machineries->sum('pivot.quantity') : 0)
                                                }}
                                            </td>
                                            <td class="text-center align-middle">
                                                {{ $transfer->transfer_date ? \Carbon\Carbon::parse($transfer->transfer_date)->format('d M Y') : 'N/A' }}
                                            </td>
                                            <td class="text-center align-middle">
                                                <span class="badge
                                                    @if($transfer->status == 'pending') badge-warning
                                                    @elseif($transfer->status == 'in_transit') badge-info
                                                    @elseif($transfer->status == 'completed') badge-success
                                                    @elseif($transfer->status == 'cancelled') badge-danger
                                                    @endif py-2 px-3 font-weight-bold text-uppercase">
                                                    {{ ucfirst($transfer->status) }}
                                                </span>
                                            </td>
                                            <td class="text-center align-middle">
                                                <div class="btn-group">
                                                    <button class="btn btn-info btn-sm" data-toggle="modal"
                                                        data-target="#viewTransfer{{ $transfer->id }}"
                                                        title="View Details">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                    @include('inventory::StockTransfer.view', ['transfer' => $transfer])
                                                    
                                                    @if($transfer->status == 'pending' || $transfer->status == 'in_transit')
                                                    <button class="btn btn-primary btn-sm" data-toggle="modal"
                                                        data-target="#editTransfer{{ $transfer->id }}"
                                                        title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    @include('inventory::StockTransfer.edit', ['transfer' => $transfer])
                                                    @endif
                                                    
                                                    <form action="{{ route('stock-transfers.destroy', $transfer->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" 
                                                            onclick="return confirm('Are you sure?')"
                                                            title="Delete">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
        <style>
            .content-wrapper {
                background: #f8f9fa;
            }
            .card {
                border-radius: 10px;
            }
            .table th, .table td {
                vertical-align: middle !important;
            }
            .btn-group .btn {
                margin-right: 2px;
            }
            .btn-group .btn:last-child {
                margin-right: 0;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
        <script>
            $(function () {
                $('[data-toggle="tooltip"]').tooltip();
                $('#example1').DataTable({
                    "responsive": true,
                    "autoWidth": false,
                    "order": [[0, "asc"]],
                    "columnDefs": [
                        { "orderable": false, "targets": 6 }
                    ]
                });
            });
        </script>
    @endpush
@endsection