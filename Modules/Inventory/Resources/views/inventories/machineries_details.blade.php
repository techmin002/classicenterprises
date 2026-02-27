@extends('setting::layouts.master')

@section('title', 'Machinery Movements')

@section('content')
    <div class="content-wrapper">

        <!-- Header -->
        <section class="content-header">
            <div class="container-fluid">
                <h1>Machinery Movements of {{ $machineryMovements->first()->machinery->name ?? 'N/A' }}</h1>
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Machinery Movements</li>
                </ol>
            </div>
        </section>

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">

                @if ($machineryMovements->isEmpty())
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        No movements found for this machinery.
                    </div>
                @else
                    <!-- ================= SUMMARY BOXES ================= -->
                    <div class="row mb-3">

                        <!-- TOTAL IN -->
                        <div class="col-lg-4 col-6">
                            <div class="small-box bg-success shadow-sm">
                                <div class="inner">
                                    <h3>{{ number_format($totalIn) }}</h3>
                                    <p>Total IN</p>
                                </div>
                                <div class="icon"><i class="fas fa-arrow-down"></i></div>
                            </div>
                        </div>

                        <!-- TOTAL OUT -->
                        <div class="col-lg-4 col-6">
                            <div class="small-box bg-danger shadow-sm">
                                <div class="inner">
                                    <h3>{{ number_format($totalOut) }}</h3>
                                    <p>Total OUT</p>
                                </div>
                                <div class="icon"><i class="fas fa-arrow-up"></i></div>
                            </div>
                        </div>

                        <!-- REMAINING -->
                        <div class="col-lg-4 col-6">
                            <div class="small-box bg-info shadow-sm">
                                <div class="inner">
                                    <h3>{{ number_format($remaining) }}</h3>
                                    <p>Remaining Quantity</p>
                                </div>
                                <div class="icon"><i class="fas fa-boxes"></i></div>
                            </div>
                        </div>

                    </div>

                    <!-- ================= TABLE ================= -->
                    <div class="card shadow-sm">
                        <div class="card-body table-responsive">
                            <table class="table table-bordered table-striped text-center" id="table-movements">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>SN</th>
                                        {{-- <th>Machinery</th> --}}
                                        <th>Quantity</th>
                                        <th>Type</th>
                                        <th>From Branch</th>
                                        <th>To</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($machineryMovements as $key => $movement)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            {{-- <td>{{ $movement->machinery->name ?? 'N/A' }}</td> --}}
                                            <td>
                                                @if (in_array($movement->movement_type, ['Purchase', 'Transfer Received']))
                                                    <span
                                                        class="badge badge-success">{{ number_format($movement->quantity) }}</span>
                                                @else
                                                    <span
                                                        class="badge badge-danger">{{ number_format($movement->quantity) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($movement->movement_type === 'Sell')
                                                    <span class="badge badge-warning">Sell</span>
                                                @elseif($movement->movement_type === 'Transfer Sent')
                                                    <span class="badge badge-danger">Transfer Sent</span>
                                                @else
                                                    <span class="badge badge-info">{{ $movement->movement_type }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $movement->from_branch ?? '-' }}</td>
                                            <td>{{ $movement->to_branch ?? '-' }}</td>
                                           
{{-- {{ $transfer->created_at ? \Carbon\Carbon::parse($transfer->created_at)->format('d M Y, h:i A') : '-' }} --}}

                                            <td>{{ $movement->created_at ? \Carbon\Carbon::parse($movement->created_at)->format('d M Y, h:i A') : '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                @endif
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $('#table-movements').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 25,
                dom: '<"top"<"float-left"l><"float-right"f>>rt<"bottom"<"float-left"i><"float-right"p>>'
            });
        });
    </script>
@endpush
