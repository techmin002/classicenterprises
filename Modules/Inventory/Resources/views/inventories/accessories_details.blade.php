@extends('setting::layouts.master')

@section('title', 'Accessory Movements')

@section('content')
<div class="content-wrapper">

    <!-- Header -->
    <section class="content-header">
        <div class="container-fluid mb-3">
           <h1 class="fw-bold text-primary">
    Movements of <span class="text-dark">{{ $accessoryName }}</span>
</h1>

            <ol class="breadcrumb float-sm-right bg-light rounded p-2 shadow-sm">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active">Accessory Movements</li>
            </ol>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">

            @if ($accessoryMovements->isEmpty())
                <div class="alert alert-info rounded shadow-sm d-flex align-items-center">
                    <i class="fas fa-info-circle me-2 fs-4"></i> No movements found for this accessory.
                </div>
            @else
                <!-- SUMMARY BOXES -->
                <div class="row mb-4 g-3">
                    <div class="col-lg-4 col-md-6">
                        <div class="card shadow-lg border-0 text-white" style="background: linear-gradient(135deg,#28a745,#218838);">
                            <div class="card-body text-center py-4">
                                <i class="fas fa-arrow-down fa-2x mb-2"></i>
                                <h3 class="fw-bold">{{ number_format($totalIn) }}</h3>
                                <p class="mb-0 fw-semibold">Total IN</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="card shadow-lg border-0 text-white" style="background: linear-gradient(135deg,#dc3545,#c82333);">
                            <div class="card-body text-center py-4">
                                <i class="fas fa-arrow-up fa-2x mb-2"></i>
                                <h3 class="fw-bold">{{ number_format($totalOut) }}</h3>
                                <p class="mb-0 fw-semibold">Total OUT</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-12">
                        <div class="card shadow-lg border-0 text-white" style="background: linear-gradient(135deg,#17a2b8,#117a8b);">
                            <div class="card-body text-center py-4">
                                <i class="fas fa-boxes fa-2x mb-2"></i>
                                <h3 class="fw-bold">{{ number_format($remaining) }}</h3>
                                <p class="mb-0 fw-semibold">Remaining</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TABLE -->
                <div class="card shadow-lg rounded">
                    <div class="card-header bg-primary text-white fw-bold">
                        <i class="fas fa-stream me-2"></i> Movement Details
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-hover table-striped table-bordered align-middle text-center" id="table-movements">
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
                                @foreach ($accessoryMovements as $key => $movement)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <span class="fw-bold">{{ number_format($movement->quantity) }}</span>
                                            <br>
                                            <span class="badge bg-secondary shadow-sm">{{ $movement->unit }}</span>
                                        </td>
                                        @php
                                            $typeColor = match ($movement->movement_type) {
                                                'Purchase','Transfer Received' => 'success',
                                                'Transfer Sent','Sale' => 'danger',
                                                'Used','Broken' => 'warning text-dark',
                                                default => 'info',
                                            };
                                        @endphp
                                        <td><span class="badge bg-{{ $typeColor }} shadow-sm">{{ $movement->movement_type }}</span></td>
                                        <td>{{ $movement->from_branch ?? '-' }}</td>
                                        <td>{{ $movement->to_branch ?? '-' }}</td>
                                        <td>{{ optional($movement->created_at)->format('d-m-Y H:i') ?? '-' }}</td>
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
        dom: '<"top mb-2"<"float-left"l><"float-right"f>>rt<"bottom mt-2"<"float-left"i><"float-right"p>>'
    });
});
</script>
@endpush
