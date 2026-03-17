@extends('setting::layouts.master')

@section('title','Technicians & Inventory')

@section('third_party_stylesheets')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')
<div class="content-wrapper">

    {{-- Content Header --}}
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Technicians & Inventory</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Inventory</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    {{-- Main Content --}}
    <section class="content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#technicians">
                                Technicians
                                <span class="badge badge-primary ml-2">{{ $technicians->count() }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#inventory">
                                Inventory
                                <span class="badge badge-success ml-2">
                                    {{ $filteredAccessories->count() + $filteredMachineries->count() + $filteredTechnicalTools->count() }}
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="card-body">
                    <div class="tab-content">

                        {{-- ================= TECHNICIANS TAB ================= --}}
                        <div class="tab-pane fade show active" id="technicians">
                            <div class="table-responsive">
                                <table id="technicianTable" class="table table-bordered table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Name</th>
                                            <th>Branch</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($technicians as $tech)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $tech->name }}</td>
                                                <td>{{ $tech->branch->name ?? '-' }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('inventory.technicians.show', $tech->id) }}" class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">No technicians found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- ================= INVENTORY TAB ================= --}}
                        <div class="tab-pane fade" id="inventory">

                            <ul class="nav nav-tabs mb-3">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#accessories">
                                        Accessories
                                        <span class="badge badge-primary ml-1">{{ $filteredAccessories->count() }}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#machineries">
                                        Machineries
                                        <span class="badge badge-primary ml-1">{{ $filteredMachineries->count() }}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#technicaltools">
                                        Technical Tools
                                        <span class="badge badge-primary ml-1">{{ $filteredTechnicalTools->count() }}</span>
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                {{-- ACCESSORIES --}}
                                <div class="tab-pane fade show active" id="accessories">
                                    @if ($filteredAccessories->isEmpty())
                                        <div class="alert alert-info">
                                            <i class="icon fas fa-info-circle"></i> No accessories inventory found
                                        </div>
                                    @else
                                        <div class="table-responsive">
                                            <table id="example1" class="table table-hover table-bordered table-striped text-center">
                                                <thead>
                                                    <tr>
                                                        <th>SN</th>
                                                        <th>Accessories</th>
                                                        <th>Branch</th>
                                                        <th>Updated By</th>
                                                        <th>Quantity</th>
                                                        <th>Status</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($filteredAccessories as $inventory)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $inventory->accessories->name ?? 'N/A' }}</td>
                                                            <td>{{ $inventory->branch->name ?? 'N/A' }}</td>
                                                            <td>{{ $inventory->user->name ?? 'N/A' }}</td>
                                                            <td>{{ number_format($inventory->quantity) }}</td>
                                                            <td>
                                                                <span class="badge badge-{{ $inventory->status == 1 ? 'success' : 'danger' }}">
                                                                    {{ $inventory->status == 1 ? 'Active' : 'Inactive' }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('inventory.accessories', $inventory->accessories->id) }}" class="btn btn-sm btn-info">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                </div>

                                {{-- MACHINERIES --}}
                                <div class="tab-pane fade" id="machineries">
                                    @if ($filteredMachineries->isEmpty())
                                        <div class="alert alert-info">
                                            <i class="icon fas fa-info-circle"></i> No machineries inventory found
                                        </div>
                                    @else
                                        <div class="table-responsive">
                                            <table id="example2" class="table table-hover table-bordered table-striped text-center">
                                                <thead>
                                                    <tr>
                                                        <th>SN</th>
                                                        <th>Machineries</th>
                                                        <th>Branch</th>
                                                        <th>Updated By</th>
                                                        <th>Quantity</th>
                                                        <th>Status</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($filteredMachineries as $inventory)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $inventory->machineries->name ?? 'N/A' }}</td>
                                                            <td>{{ $inventory->branch->name ?? 'N/A' }}</td>
                                                            <td>{{ $inventory->user->name ?? 'N/A' }}</td>
                                                            <td>{{ number_format($inventory->quantity) }}</td>
                                                            <td>
                                                                <span class="badge badge-{{ $inventory->status == 1 ? 'success' : 'danger' }}">
                                                                    {{ $inventory->status == 1 ? 'Active' : 'Inactive' }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('inventory.machineries', $inventory->machineries->id) }}" class="btn btn-sm btn-info">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                </div>

                                {{-- TECHNICAL TOOLS --}}
                                <div class="tab-pane fade" id="technicaltools">
                                    @if ($filteredTechnicalTools->isEmpty())
                                        <div class="alert alert-info">
                                            <i class="icon fas fa-info-circle"></i> No technical tools inventory found
                                        </div>
                                    @else
                                        <div class="table-responsive">
                                            <table id="example3" class="table table-hover table-bordered table-striped text-center">
                                                <thead>
                                                    <tr>
                                                        <th>SN</th>
                                                        <th>Technical Tool</th>
                                                        <th>Branch</th>
                                                        <th>Updated By</th>
                                                        <th>Quantity</th>
                                                        <th>Status</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($filteredTechnicalTools as $inventory)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $inventory->technicaltools->tool_name ?? 'N/A' }}</td>
                                                            <td>{{ $inventory->branch->name ?? 'N/A' }}</td>
                                                            <td>{{ $inventory->user->name ?? 'N/A' }}</td>
                                                            <td>{{ number_format($inventory->quantity) }}</td>
                                                            <td>
                                                                <span class="badge badge-{{ $inventory->status ? 'success' : 'danger' }}">
                                                                    {{ $inventory->status ? 'Active' : 'Inactive' }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('inventory.technicaltools', $inventory->technicaltools->id) }}" class="btn btn-sm btn-info">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                </div>

                            </div> {{-- tab-content --}}
                        </div> {{-- inventory tab --}}

                    </div>
                </div>
            </div>

        </div>
    </section>

</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {

    // Technicians DataTable
    $('#technicianTable').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 25,
        columnDefs: [{ targets: -1, orderable: false, searchable: false }]
    });

    // Inventory tables initialization
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        const target = $(e.target).attr("href");

        if (target === '#accessories' && !$.fn.DataTable.isDataTable('#example1')) {
            $('#example1').DataTable({
                responsive:true,
                autoWidth:false,
                pageLength:25,
                columnDefs:[{targets:-1, orderable:false, searchable:false}]
            });
        }

        if (target === '#machineries' && !$.fn.DataTable.isDataTable('#example2')) {
            $('#example2').DataTable({
                responsive:true,
                autoWidth:false,
                pageLength:25,
                columnDefs:[{targets:-1, orderable:false, searchable:false}]
            });
        }

        if (target === '#technicaltools' && !$.fn.DataTable.isDataTable('#example3')) {
            $('#example3').DataTable({
                responsive:true,
                autoWidth:false,
                pageLength:25,
                columnDefs:[{targets:-1, orderable:false, searchable:false}]
            });
        }
    });

});
</script>
@endpush