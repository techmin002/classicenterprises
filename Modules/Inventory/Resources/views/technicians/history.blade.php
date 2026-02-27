@extends('setting::layouts.master')
@section('title', $staff->name . ' - Item History')

@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('inventory.technicians.show', $staff->id) }}">Technician Inventory</a></li>
    <li class="breadcrumb-item active">{{ $staff->name }} History</li>
</ol>
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">

            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold">{{ $staff->name }} - {{ ucfirst($history->first()->item_type ?? '') }} History</h4>
                <a href="{{ route('inventory.technicians.show', $staff->id) }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
            </div>

            @php
                $totalAssigned = $history->sum('assigned_qty');
                $totalReturned = $history->sum(function($h){ return $h->returns->sum('returned_qty'); });
                $totalUsed = $history->sum(function($h){ return $h->returns->sum('used_qty'); });
                $totalBroken = $history->sum(function($h){ return $h->returns->sum('broken_qty'); });
                $remaining = $totalAssigned - ($totalReturned + $totalUsed + $totalBroken);
            @endphp

            {{-- Summary Boxes --}}
            <div class="row mb-4 g-3">
                <div class="col-lg-2 col-md-4 col-6">
                    <div class="card text-white bg-primary shadow-sm">
                        <div class="card-body text-center py-3">
                            <h5 class="fw-bold">{{ number_format($totalAssigned) }}</h5>
                            <p class="mb-0">Assigned</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-6">
                    <div class="card text-white bg-success shadow-sm">
                        <div class="card-body text-center py-3">
                            <h5 class="fw-bold">{{ number_format($totalReturned) }}</h5>
                            <p class="mb-0">Returned</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-6">
                    <div class="card text-white bg-warning shadow-sm">
                        <div class="card-body text-center py-3">
                            <h5 class="fw-bold">{{ number_format($totalUsed) }}</h5>
                            <p class="mb-0">Used</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-6">
                    <div class="card text-white bg-danger shadow-sm">
                        <div class="card-body text-center py-3">
                            <h5 class="fw-bold">{{ number_format($totalBroken) }}</h5>
                            <p class="mb-0">Broken</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-6">
                    <div class="card text-white bg-info shadow-sm">
                        <div class="card-body text-center py-3">
                            <h5 class="fw-bold">{{ number_format($remaining) }}</h5>
                            <p class="mb-0">Remaining</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- History Table --}}
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white fw-bold">
                    <i class="fas fa-history me-2"></i> Assignment History
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover text-center mb-0" id="history-table">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Assigned Qty</th>
                                <th>Returned</th>
                                <th>Used</th>
                                <th>Broken</th>
                                <th>Remaining</th>
                                <th>Status</th>
                                <th>Remarks</th>
                                <th>Assigned At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($history as $row)
                            @php
                                $returned = $row->returns->sum('returned_qty');
                                $used = $row->returns->sum('used_qty');
                                $broken = $row->returns->sum('broken_qty');
                                $rowRemaining = $row->assigned_qty - ($returned + $used + $broken);
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row->assigned_qty }}</td>
                                <td>{{ $returned }}</td>
                                <td>{{ $used }}</td>
                                <td>{{ $broken }}</td>
                                <td>{{ $rowRemaining }}</td>
                                <td>
                                    @php
                                        $statusClass = match($row->status) {
                                            'assigned' => 'warning',
                                            'returned' => 'info',
                                            'verified' => 'success',
                                            default => 'secondary',
                                        };
                                    @endphp
                                    <span class="badge badge-{{ $statusClass }}">{{ ucfirst($row->status) }}</span>
                                </td>
                                <td>
                                    @foreach($row->returns as $ret)
                                        <span class="d-block small text-muted">
                                            {{ $ret->remarks ?? '-' }}
                                        </span>
                                    @endforeach
                                </td>
                                <td>{{ $row->assigned_at->format('d M, Y H:i') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center">No history found for this item.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#history-table').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 25,
        order: [[8, 'desc']],
    });
});
</script>
@endpush
@endsection
