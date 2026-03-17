@extends('setting::layouts.master')

@section('title', 'Machinery Movements')

@section('content')
<div class="content-wrapper">

    <!-- HEADER -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="fw-bold text-primary">
                    Movements of <span class="text-dark">{{ $machineryName }}</span>
                </h1>
                <ol class="breadcrumb bg-light rounded p-2 shadow-sm">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Machinery Movements</li>
                </ol>
            </div>
        </div>
    </section>

    <!-- MAIN CONTENT -->
    <section class="content">
        <div class="container-fluid">

            @if ($machineryMovements->isEmpty())
                <div class="alert alert-info rounded shadow-sm d-flex align-items-center">
                    <i class="fas fa-info-circle me-2 fs-4"></i> No movements found for this machinery.
                </div>
            @else

                <!-- ================= SUMMARY BOXES ================= -->
                <div class="row mb-4 g-3">
                    <div class="col-lg-4 col-md-6">
                        <div class="card shadow-lg border-0 text-white" style="background: linear-gradient(135deg,#28a745,#218838);">
                            <div class="card-body text-center py-4">
                                <i class="fas fa-arrow-down fa-3x mb-2"></i>
                                <h3 class="fw-bold">{{ number_format($totalIn) }}</h3>
                                <p class="mb-0 fw-semibold">Total IN <small class="text-light">(Purchase, Transfer In, Sale Return)</small></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="card shadow-lg border-0 text-white" style="background: linear-gradient(135deg,#dc3545,#c82333);">
                            <div class="card-body text-center py-4">
                                <i class="fas fa-arrow-up fa-3x mb-2"></i>
                                <h3 class="fw-bold">{{ number_format($totalOut) }}</h3>
                                <p class="mb-0 fw-semibold">Total OUT <small class="text-light">(Sale, Transfer Out)</small></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-12">
                        <div class="card shadow-lg border-0 text-white" style="background: linear-gradient(135deg,#17a2b8,#117a8b);">
                            <div class="card-body text-center py-4">
                                <i class="fas fa-boxes fa-3x mb-2"></i>
                                <h3 class="fw-bold">{{ number_format($remaining) }}</h3>
                                <p class="mb-0 fw-semibold">Remaining Quantity</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ================= MOVEMENT TABLE ================= -->
                <div class="card shadow-lg rounded">
                    <div class="card-header bg-primary text-white fw-bold d-flex align-items-center">
                        <i class="fas fa-stream me-2"></i> Movement Details
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-hover table-striped table-bordered align-middle text-center" id="table-movements example">
                            <thead class="table-dark text-uppercase">
                                <tr>
                                    <th>SN</th>
                                    <th>Quantity</th>
                                    <th>Type</th>
                                    <th>From Branch</th>
                                    <th>To Branch</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($machineryMovements as $key => $movement)
                                    <tr class="align-middle">
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <span class="badge {{ in_array($movement->movement_type, ['Purchase','Transfer Received','Sale Return']) ? 'bg-success' : 'bg-danger' }}">
                                                {{ number_format($movement->quantity) }}
                                            </span>
                                            <br>
                                            <small class="text-muted">{{ $movement->unit }}</small>
                                        </td>
                                        <td>
                                            @php
                                                $typeColor = match ($movement->movement_type) {
                                                    'Purchase' => 'success',
                                                    'Transfer Received' => 'info',
                                                    'Sale Return' => 'primary',
                                                    'Transfer Sent' => 'warning',
                                                    'Sale' => 'danger',
                                                    default => 'secondary',
                                                };
                                            @endphp
                                            <span class="badge bg-{{ $typeColor }}">{{ $movement->movement_type }}</span>
                                        </td>
                                        <td>{{ $movement->from_branch ?? '-' }}</td>
                                        <td>{{ $movement->to_branch ?? '-' }}</td>
                                        <td>{{ optional($movement->created_at)->format('d M Y, h:i A') ?? '-' }}</td>
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
        order: [[5, 'desc']],
        dom: '<"top mb-3"<"d-flex justify-content-between"<"left"l><"right"f>>>rt<"bottom mt-3 d-flex justify-content-between"<"left"i><"right"p>>',
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search movements..."
        }
    });
});
</script>
@endpush