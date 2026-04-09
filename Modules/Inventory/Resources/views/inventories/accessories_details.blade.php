@extends('setting::layouts.master')

@section('title', 'Accessory Movements')

@section('content')
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid mb-3">
           <h1 class="fw-bold text-primary">
                Movements of <span class="text-dark">{{ $accessoryName }}</span>
           </h1>

            <ol class="breadcrumb float-sm-right bg-light rounded p-2 shadow-sm">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Accessory Movements</li>
            </ol>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            @if ($accessoryMovements->isEmpty())
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> No movements found.
                </div>
            @else
                <div class="row mb-4 g-3">
                    <div class="col-lg-4 col-md-6">
                        <div class="card text-white" style="background: #28a745;">
                            <div class="card-body text-center py-4">
                                <i class="fas fa-arrow-down fa-2x mb-2"></i>
                                <h3 class="fw-bold">{{ number_format($totalIn) }}</h3>
                                <p>Total IN</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card text-white" style="background: #dc3545;">
                            <div class="card-body text-center py-4">
                                <i class="fas fa-arrow-up fa-2x mb-2"></i>
                                <h3 class="fw-bold">{{ number_format($totalOut) }}</h3>
                                <p>Total OUT</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="card text-white" style="background: #17a2b8;">
                            <div class="card-body text-center py-4">
                                <i class="fas fa-boxes fa-2x mb-2"></i>
                                <h3 class="fw-bold">{{ number_format($remaining) }}</h3>
                                <p>Remaining</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-stream"></i> Movement Details
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-hover table-bordered text-center" id="table-movements">
                            <thead class="table-dark">
                                <tr>
                                    <th>SN</th>
                                    <th>Quantity</th>
                                    <th>Type</th>
                                    <th>From Branch</th>
                                    <th>To Branch</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($accessoryMovements as $key => $movement)
                                    @php
                                        $typeColor = match ($movement->movement_type) {
                                            'Purchase','Transfer Received','Sale Return' => 'success',
                                            'Transfer Sent','Sale' => 'danger',
                                            'Used','Broken' => 'warning text-dark',
                                            default => 'info',
                                        };
                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <strong>{{ number_format($movement->quantity) }}</strong>
                                            <br>
                                            <span class="badge bg-secondary">{{ $movement->unit }}</span>
                                        </td>
                                        <td><span class="badge bg-{{ $typeColor }}">{{ $movement->movement_type }}</span></td>
                                        <td>{{ $movement->from_branch ?? '-' }}</td>
                                        <td>{{ $movement->to_branch ?? '-' }}</td>
                                        <td>{{ optional($movement->created_at)->format('d-m-Y H:i') ?? '-' }}</td>
                                        <td>
    @if(!empty($movement->route))
        <a href="{{ $movement->route }}" class="btn btn-sm btn-primary">
            <i class="fas fa-eye"></i>
        </a>
    @else
        -
    @endif
</td>
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
    });
});
</script>
@endpush