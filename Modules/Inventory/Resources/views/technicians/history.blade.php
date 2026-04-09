@extends('setting::layouts.master')
@section('title', $staff->name . ' - Item History')

@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item">
        <a href="{{ route('inventory.technicians.show', $staff->id) }}">Technician Inventory</a>
    </li>
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
                $totalReturned = $history->sum(fn($h) => $h->returns->sum('returned_qty'));
                $totalUsed     = $history->sum(fn($h) => $h->returns->sum('used_qty'));
                $totalBroken   = $history->sum(fn($h) => $h->returns->sum('broken_qty'));
                $remaining     = $totalAssigned - ($totalReturned + $totalUsed + $totalBroken);
            @endphp

            {{-- Summary --}}
            <div class="row mb-4 g-3">
                <div class="col-lg-2 col-md-4 col-6">
                    <div class="card text-white bg-primary shadow-sm text-center py-3">
                        <h5>{{ number_format($totalAssigned) }}</h5>
                        <small>Assigned</small>
                    </div>
                </div>

                <div class="col-lg-2 col-md-4 col-6">
                    <div class="card text-white bg-success shadow-sm text-center py-3">
                        <h5>{{ number_format($totalReturned) }}</h5>
                        <small>Returned</small>
                    </div>
                </div>

                <div class="col-lg-2 col-md-4 col-6">
                    <div class="card text-white bg-warning shadow-sm text-center py-3">
                        <h5>{{ number_format($totalUsed) }}</h5>
                        <small>Used</small>
                    </div>
                </div>

                <div class="col-lg-2 col-md-4 col-6">
                    <div class="card text-white bg-danger shadow-sm text-center py-3">
                        <h5>{{ number_format($totalBroken) }}</h5>
                        <small>Broken</small>
                    </div>
                </div>

                <div class="col-lg-2 col-md-4 col-6">
                    <div class="card text-white bg-info shadow-sm text-center py-3">
                        <h5>{{ number_format($remaining) }}</h5>
                        <small>Remaining</small>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white fw-bold">
                    <i class="fas fa-history me-2"></i> Assignment History
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover text-center" id="history-table">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Assigned</th>
                                <th>Returned</th>
                                <th>Used (with date/time)</th>
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
                                $used     = $row->returns->sum('used_qty');
                                $broken   = $row->returns->sum('broken_qty');
                                $rowRemaining = $row->assigned_qty - ($returned + $used + $broken);
                            @endphp

                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row->assigned_qty }}</td>
                                <td class="text-success fw-bold">{{ $returned }}</td>

                                {{-- USED: show each usage with date/time --}}
                                <td class="text-warning text-start">
                                    @forelse($row->returns as $ret)
                                        @if($ret->used_qty > 0)
                                            <div>
                                                <strong>{{ $ret->used_qty }}</strong> Used
                                                <br>
                                                <small class="text-muted">
                                                    {{ $ret->verified_at->format('d M Y H:i') }}
                                                </small>
                                            </div>
                                        @endif
                                    @empty
                                        -
                                    @endforelse
                                </td>

                                <td class="text-danger fw-bold">{{ $broken }}</td>
                                <td>{{ $rowRemaining }}</td>

                                {{-- Status --}}
                                <td>
                                    @php
                                        $statusClass = match($row->status) {
                                            'assigned' => 'warning',
                                            'returned' => 'info',
                                            'verified' => 'success',
                                            default => 'secondary',
                                        };
                                    @endphp
                                    <span class="badge badge-{{ $statusClass }}">
                                        {{ ucfirst($row->status) }}
                                    </span>
                                </td>

                                {{-- Remarks --}}
                                <td class="text-start">
                                    @foreach($row->returns as $ret)
                                        @if($ret->remarks)
                                            <div class="small text-muted">
                                                💬 {{ $ret->remarks }}
                                            </div>
                                        @endif
                                    @endforeach
                                </td>

                                <td>{{ $row->assigned_at->format('d M, Y H:i') }}</td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="9" class="text-center">
                                    No history found for this item.
                                </td>
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
$(document).ready(function () {
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