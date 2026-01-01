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
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Inventories</li>
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

                    <div class="card">

                        <!-- Tabs -->
                        <div class="card-header p-2">
                            <h3>Machineries Details</h3>
                            <ul class="nav nav-tabs" id="inventory-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="accessories-tab" data-toggle="tab" href="#accessories" role="tab">
                                        Machineries In
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="machineries-tab" data-toggle="tab" href="#machineries" role="tab">
                                        Machineries Out
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- Tab Content -->
                        <div class="card-body">
                            <div class="tab-content" id="inventory-tabs-content">

                                <!-- Accessories Tab -->
                                <div class="tab-pane fade show active" id="accessories" role="tabpanel">
                                    @if($machineries->isEmpty())
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i>
                                        No machineries inventory found
                                    </div>
                                    @else
                                    <div class="table-responsive">
                                        <table id="example1" class="table table-bordered table-striped table-hover text-center">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>SN</th>
                                                    <th>Machinery Name</th>
                                                    <th>Quantity</th>
                                                    <th>Date</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $sn = 1; @endphp

                                                {{-- Device Purchase machinery --}}
                                                @foreach ($machineries as $inventory)
                                                <tr>
                                                    <td>{{ $sn++ }}</td>
                                                    <td>{{ $inventory->machinery->name ?? 'N/A' }}</td>
                                                    <td>{{ number_format($inventory->quantity) }}</td>
                                                    <td>{{ $inventory->created_at }}</td>
                                                </tr>
                                                @endforeach

                                                {{-- Stock Transfer machinery --}}
                                                @foreach ($transferMachineries as $item)
                                                <tr>
                                                    <td>{{ $sn++ }}</td>
                                                    <td>{{ $item->machinery->name }}</td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td>{{ $item->created_at }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @endif
                                </div>

                                <!-- Machineries Tab -->
                                <div class="tab-pane fade" id="machineries" role="tabpanel">
                                    @if($machineries->isEmpty())
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i>
                                        No accessories inventory found
                                    </div>
                                    @else
                                    <div class="table-responsive">
                                        <table id="example2" class="table table-bordered table-striped table-hover text-center">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>SN</th>
                                                    <th>Machinery Name</th>
                                                    <th>Quantity</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($machineries as $inventory)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $inventory->machineries->name ?? 'N/A' }}</td>
                                                    <td>
                                                        {{ number_format($inventory->quantity) }}
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

        // Accessories table
        $('#example1').DataTable({
            responsive: true
            , autoWidth: false
            , pageLength: 25
            , dom: '<"top"<"float-left"l><"float-right"f>>rt<"bottom"<"float-left"i><"float-right"p>>'
        });

        // Machineries table (load only when tab is opened)
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            if ($(e.target).attr('href') === '#machineries' &&
                !$.fn.DataTable.isDataTable('#example2')) {

                $('#example2').DataTable({
                    responsive: true
                    , autoWidth: false
                    , pageLength: 25
                    , dom: '<"top"<"float-left"l><"float-right"f>>rt<"bottom"<"float-left"i><"float-right"p>>'
                });
            }
        });

    });

</script>
@endpush
