@extends('setting::layouts.master')

@section('title', 'Inventories')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Inventories</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Inventories</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <nav>
                                    <div class="nav nav-tabs" id="inventory-tabs" role="tablist">
                                        <a class="nav-link active" id="accessories-tab" data-toggle="tab"
                                            href="#accessories" role="tab" aria-controls="accessories"
                                            aria-selected="true">
                                            Accessories
                                            <span
                                                class="badge badge-primary ml-2">{{ $filteredAccessories->count() }}</span>
                                        </a>
                                        <a class="nav-link" id="machineries-tab" data-toggle="tab" href="#machineries"
                                            role="tab" aria-controls="machineries" aria-selected="false">
                                            Machineries
                                            <span
                                                class="badge badge-primary ml-2">{{ $filteredMachineries->count() }}</span>
                                        </a>
                                        <a class="nav-link" id="technicaltools-tab" data-toggle="tab" href="#technicaltools"
                                            role="tab" aria-controls="technicaltools" aria-selected="false">
                                            Technical Tools
                                            <span
                                                class="badge badge-primary ml-2">{{ $filteredTechnicalTools->count() }}</span>
                                        </a>
                                    </div>
                                </nav>
                            </div>

                            <div class="card-body">
                                <div class="tab-content" id="inventory-tabs-content">
                                    <!-- Accessories Tab -->
                                    <div class="tab-pane fade show active" id="accessories" role="tabpanel"
                                        aria-labelledby="accessories-tab">
                                        @if ($filteredAccessories->isEmpty())
                                            <div class="alert alert-info">
                                                <i class="icon fas fa-info-circle"></i> No accessories inventory found
                                            </div>
                                        @else
                                            <div class="table-responsive">
                                                <table id="example1"
                                                    class="table table-hover table-bordered table-striped text-center">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th>SN</th>
                                                            <th>Accessories</th>
                                                            <th>Branch</th>
                                                            <th>Updated By</th>
                                                            <th>Quantity</th>
                                                            {{-- <th>Unit</th> --}}
                                                            {{-- <th>Opening Qty</th> --}}
                                                            <th>Status</th>
                                                            {{-- @canany(['edit_inventory', 'delete_inventory']) --}}
                                                            <th>Actions</th>
                                                            {{-- @endcanany --}}
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($filteredAccessories as $inventory)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $inventory->accessories->name ?? 'N/A' }}</td>
                                                                <td>{{ $inventory->branch->name ?? 'N/A' }}</td>
                                                                <td>{{ $inventory->user->name ?? 'N/A' }}</td>
                                                                {{-- <td>{{ number_format($inventory->quantity) }}</td> --}}
                                                                @php
                                                                    $unitMap = [
                                                                        'qty' => [
                                                                            'label' => 'Quantity',
                                                                            'color' => 'primary',
                                                                        ],
                                                                        'ltr' => [
                                                                            'label' => 'Liter',
                                                                            'color' => 'info',
                                                                        ],
                                                                        'kg' => [
                                                                            'label' => 'Kilogram',
                                                                            'color' => 'success',
                                                                        ],
                                                                        'meter' => [
                                                                            'label' => 'Meter',
                                                                            'color' => 'warning',
                                                                        ],
                                                                        'inch' => [
                                                                            'label' => 'Inch',
                                                                            'color' => 'secondary',
                                                                        ],
                                                                        'other' => [
                                                                            'label' => 'Other',
                                                                            'color' => 'dark',
                                                                        ],
                                                                    ];

                                                                    $unitCode = $inventory->accessories->units ?? '';
                                                                    $unitLabel = $unitMap[$unitCode]['label'] ?? 'N/A';
                                                                    $unitColor =
                                                                        $unitMap[$unitCode]['color'] ?? 'light';
                                                                @endphp

                                                                <td>
                                                                    <span
                                                                        class="fw-bold">{{ number_format($inventory->quantity) }}</span>
                                                                    <br>
                                                                    <span class="badge bg-{{ $unitColor }} shadow-sm">
                                                                        {{ $unitLabel }}
                                                                    </span>
                                                                </td>


                                                                {{-- <td>{{ number_format($inventory->opening_quantity) }}</td> --}}
                                                                <td>
                                                                    <span
                                                                        class="badge badge-{{ $inventory->status == 1 ? 'success' : 'danger' }}">
                                                                        {{ $inventory->status == 1 ? 'Active' : 'Inactive' }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    @can('show_inventory')
                                                                    <a href="{{ route('inventory.accessories', $inventory->accessories->id) }}"
                                                                        class="btn btn-sm btn-info" title="View">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                    @endcan
                                                                </td>
                                                                {{-- @canany(['edit_inventory', 'delete_inventory']) --}}
                                                                {{-- <td>
                                                        @can('edit_inventory')
                                                        <a href="{{ route('inventory.edit', $inventory->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                    </a>
                                                    @endcan
                                                    @can('delete_inventory')
                                                    <form action="{{ route('inventory.destroy', $inventory->id) }}" method="POST" style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                    @endcan
                                                    </td> --}}
                                                                {{-- @endcanany --}}
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Machineries Tab -->
                                    <div class="tab-pane fade" id="machineries" role="tabpanel"
                                        aria-labelledby="machineries-tab">
                                        @if ($filteredMachineries->isEmpty())
                                            <div class="alert alert-info">
                                                <i class="icon fas fa-info-circle"></i> No machineries inventory found
                                            </div>
                                        @else
                                            <div class="table-responsive">
                                                <table id="example2"
                                                    class="table table-hover table-bordered table-striped text-center">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th>SN</th>
                                                            <th>Machineries</th>
                                                            <th>Branch</th>
                                                            <th>Updated By</th>
                                                            <th>Quantity</th>
                                                            {{-- <th>Opening Qty</th> --}}
                                                            <th>Status</th>
                                                            {{-- @canany(['edit_inventory', 'delete_inventory']) --}}
                                                            <th>Actions</th>
                                                            {{-- @endcanany --}}
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
                                                                {{-- <td>{{ number_format($inventory->opening_quantity) }}</td> --}}
                                                                <td>
                                                                    <span
                                                                        class="badge badge-{{ $inventory->status == 1 ? 'success' : 'danger' }}">
                                                                        {{ $inventory->status == 1 ? 'Active' : 'Inactive' }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <a href="{{ route('inventory.machineries', $inventory->machineries->id) }}"
                                                                        class="btn btn-sm btn-info" title="View">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                </td>
                                                                {{-- @canany(['edit_inventory', 'delete_inventory'])
                                                    <td>
                                                        @can('edit_inventory')
                                                        <a href="{{ route('inventory.edit', $inventory->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                    </a>
                                                    @endcan
                                                    @can('delete_inventory')
                                                    <form action="{{ route('inventory.destroy', $inventory->id) }}" method="POST" style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                    @endcan
                                                    </td>
                                                    @endcanany --}}
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Technical Tools Tab -->
                                    <div class="tab-pane fade" id="technicaltools" role="tabpanel"
                                        aria-labelledby="technicaltools-tab">
                                        @if ($filteredTechnicalTools->isEmpty())
                                            <div class="alert alert-info">
                                                <i class="icon fas fa-info-circle"></i> No Technical Tools inventory found
                                            </div>
                                        @else
                                            <div class="table-responsive">
                                                <table id="example3"
                                                    class="table table-hover table-bordered table-striped text-center">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th>SN</th>
                                                            <th>Technical Tool</th>
                                                            <th>Branch</th>
                                                            <th>Updated By</th>
                                                            <th>Quantity</th>
                                                            {{-- <th>Opening Qty</th> --}}
                                                            <th>Status</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($filteredTechnicalTools as $inventory)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $inventory->technicaltools->tool_name ?? 'N/A' }}
                                                                </td>
                                                                <td>{{ $inventory->branch->name ?? 'N/A' }}</td>
                                                                <td>{{ $inventory->user->name ?? 'N/A' }}</td>
                                                                <td>{{ number_format($inventory->quantity) }}</td>
                                                                {{-- <td>{{ number_format($inventory->opening_quantity) }}</td> --}}
                                                                <td>
                                                                    <span
                                                                        class="badge badge-{{ $inventory->status ? 'success' : 'danger' }}">
                                                                        {{ $inventory->status ? 'Active' : 'Inactive' }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <a href="{{ route('inventory.technicaltools', $inventory->technicaltools->id) }}"
                                                                        class="btn btn-sm btn-info">
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

                                </div>
                            </div>
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
            // Initialize first table
            $('#example1').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 25,
                dom: '<"top"<"float-left"l><"float-right"f>><"clear">rt<"bottom"<"float-left"i><"float-right"p>><"clear">',
                columnDefs: [{
                    targets: -1,
                    orderable: false,
                    searchable: false
                }]
            });

            // Initialize second table when tab is shown
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                const target = $(e.target).attr("href");
                if (target === '#machineries' && !$.fn.DataTable.isDataTable('#example2')) {
                    $('#example2').DataTable({
                        responsive: true,
                        autoWidth: false,
                        pageLength: 25,
                        dom: '<"top"<"float-left"l><"float-right"f>><"clear">rt<"bottom"<"float-left"i><"float-right"p>><"clear">',
                        columnDefs: [{
                            targets: -1,
                            orderable: false,
                            searchable: false
                        }]
                    });
                }
            });

        });
    </script>
@endpush
