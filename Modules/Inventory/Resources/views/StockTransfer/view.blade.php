@extends('setting::layouts.master')

@section('title', "Stock Transfer Details #{{ $transfer->id }}")

@section('breadcrumb')
<ol class="breadcrumb border-0 m-0 bg-light rounded shadow-sm px-3 py-2">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('stock-transfers.index') }}">Stock Transfer</a></li>
    <li class="breadcrumb-item active">Transfer #{{ $transfer->id }}</li>
</ol>
@endsection

@section('content')
<div class="content-wrapper bg-white rounded shadow-sm p-4">

    {{-- Header --}}
    <div class="d-flex align-items-center mb-4">
        <span class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mr-3" style="width:50px;height:50px;">
            <i class="fas fa-exchange-alt fa-lg"></i>
        </span>
        <h3 class="mb-0 text-primary font-weight-bold">Transfer Details #{{ $transfer->id }}</h3>
    </div>

    {{-- Transfer Info --}}
    <div class="row mb-4">
        <div class="col-md-6 mb-3 mb-md-0">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body py-3">
                    <p><strong>From Branch:</strong> {{ optional($transfer->fromBranch)->name ?? 'N/A' }}</p>
                    <p><strong>To Branch:</strong> {{ optional($transfer->toBranch)->name ?? 'N/A' }}</p>
                    <p><strong>Date:</strong> {{ optional($transfer->transfer_date) ? \Carbon\Carbon::parse($transfer->transfer_date)->translatedFormat('d M Y') : 'N/A' }}</p>
                    <p><strong>Status:</strong> 
                        <span class="badge
                            @if($transfer->status == 'pending') badge-warning
                            @elseif($transfer->status == 'in_transit') badge-info
                            @elseif($transfer->status == 'completed') badge-success
                            @elseif($transfer->status == 'cancelled') badge-danger
                            @else badge-secondary
                            @endif px-3 py-1 shadow-sm">
                            {{ ucfirst($transfer->status ?? 'N/A') }}
                        </span>
                    </p>
                    <p><strong>Created By:</strong> {{ $transfer->user->name ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body py-3">
                    <p><strong>Remarks:</strong> {{ $transfer->remarks ?? 'N/A' }}</p>
                    <p><strong>Created At:</strong> {{ optional($transfer->created_at)->format('d M Y H:i') ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Accessories Table --}}
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-header bg-gradient-primary text-white">
            <i class="fas fa-tools mr-2"></i> Accessories
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Condition</th>
                            <th>Serial Numbers</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transfer->accessories as $accessory)
                        <tr>
                            <td>{{ $accessory->name }}</td>
                            <td><span class="badge badge-secondary px-2">{{ $accessory->pivot->quantity ?? 0 }}</span></td>
                            <td>
                                <span class="badge badge-pill
                                    @if($accessory->pivot->condition == 'good') badge-success
                                    @elseif($accessory->pivot->condition == 'fair') badge-warning
                                    @else badge-secondary
                                    @endif">
                                    {{ ucfirst($accessory->pivot->condition ?? 'N/A') }}
                                </span>
                            </td>
                            <td>{{ $accessory->pivot->serial_numbers ?? 'N/A' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">No accessories</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Machineries Table --}}
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-header bg-gradient-success text-white">
            <i class="fas fa-cogs mr-2"></i> Machineries
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Condition</th>
                            <th>Serial Numbers</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transfer->machineries as $machinery)
                        <tr>
                            <td>{{ $machinery->name }}</td>
                            <td><span class="badge badge-secondary px-2">{{ $machinery->pivot->quantity ?? 0 }}</span></td>
                            <td>
                                <span class="badge badge-pill
                                    @if($machinery->pivot->condition == 'good') badge-success
                                    @elseif($machinery->pivot->condition == 'fair') badge-warning
                                    @else badge-secondary
                                    @endif">
                                    {{ ucfirst($machinery->pivot->condition ?? 'N/A') }}
                                </span>
                            </td>
                            <td>{{ $machinery->pivot->serial_numbers ?? 'N/A' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">No machineries</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Technical Tools Table --}}
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-header bg-gradient-warning text-white">
            <i class="fas fa-cogs mr-2"></i> Technical Tools
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Condition</th>
                            <th>Serial Numbers</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transfer->technicaltools as $tool)
                        <tr>
                            <td>{{ $tool->tool_name }}</td>
                            <td><span class="badge badge-secondary px-2">{{ $tool->pivot->quantity ?? 0 }}</span></td>
                            <td>
                                <span class="badge badge-pill
                                    @if($tool->pivot->condition == 'good') badge-success
                                    @elseif($tool->pivot->condition == 'fair') badge-warning
                                    @else badge-secondary
                                    @endif">
                                    {{ ucfirst($tool->pivot->condition ?? 'N/A') }}
                                </span>
                            </td>
                            <td>{{ $tool->pivot->serial_numbers ?? 'N/A' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">No Technical Tools</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <a href="{{ route('stock-transfers.index') }}" class="btn btn-outline-secondary mt-3">
        <i class="fas fa-arrow-left mr-1"></i> Back to Transfers
    </a>

</div>
@endsection