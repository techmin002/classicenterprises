@extends('setting::layouts.master')
@section('title', $staff->name . ' - Assigned Items')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('inventory.technicians.index') }}">Technicians</a></li>
        <li class="breadcrumb-item active">{{ $staff->name }} Inventory</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">

                {{-- Technician Assignments --}}
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">{{ $staff->name }} - Assigned Items</h3>
                        <span class="badge badge-light">
                            Branch: {{ $staff->branch->name ?? 'N/A' }} | Total: {{ $assignments->count() }}
                            <a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#assignModal">
                                <i class="fas fa-plus-circle"></i> Assign Item
                            </a>
                        </span>
                    </div>

                    <div class="card-body p-0">
                        @if ($assignments->isEmpty())
                            <div class="alert alert-info text-center m-3">
                                <i class="fas fa-info-circle"></i> No assignments found.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table id="assignments-table" class="table table-hover table-bordered text-center mb-0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Item</th>
                                            <th>Type</th>
                                            <th>Assigned Qty</th>
                                            <th>Returned</th>
                                            <th>Used</th>
                                            <th>Broken</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($assignments->groupBy(['item_type', 'item_id']) as $type => $items)
                                            @foreach ($items as $itemId => $rows)
                                                @php
                                                    $row = $rows->first();

                                                    $totalAssigned = $rows->sum('assigned_qty');

                                                    $totalReturned = $rows->sum(function ($r) {
                                                        return $r->returns->sum('returned_qty');
                                                    });

                                                    $totalUsed = $rows->sum(function ($r) {
                                                        return $r->returns->sum('used_qty');
                                                    });

                                                    $totalBroken = $rows->sum(function ($r) {
                                                        return $r->returns->sum('broken_qty');
                                                    });

                                                    $statusClass = match ($row->status) {
                                                        'assigned' => 'warning',
                                                        'returned' => 'info',
                                                        'verified' => 'success',
                                                        default => 'secondary',
                                                    };
                                                @endphp

                                                <tr>
                                                    <td>{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>
                                                    <td>{{ $row->item_name }}</td>
                                                    <td>{{ ucfirst($type) }}</td>
                                                    <td>{{ $totalAssigned }}</td>
                                                    <td>{{ $totalReturned }}</td>
                                                    <td>{{ $totalUsed }}</td>
                                                    <td>{{ $totalBroken }}</td>
                                                    <td>
                                                        <span
                                                            class="badge badge-{{ $statusClass }}">{{ ucfirst($row->status) }}</span>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('inventory.technicians.itemHistory', [$staff->id, $type, $itemId]) }}"
                                                            class="btn btn-sm btn-info">
                                                            <i class="fas fa-history"></i> History
                                                        </a>

                                                        @if ($row->status === 'assigned')
                                                            <button type="button" class="btn btn-sm btn-success verify-btn"
                                                                data-staff="{{ $staff->id }}"
                                                                data-item-type="{{ $type }}"
                                                                data-item-id="{{ $itemId }}"
                                                                data-item-name="{{ $row->item_name }}"
                                                                data-assigned="{{ $totalAssigned }}">
                                                                <i class="fas fa-check-circle"></i> Verify
                                                            </button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            {{-- Assign Item Modal --}}
            @include('inventory::technicians.assign')
        </section>
    </div>

    {{-- Verify Modal --}}
    @include('inventory::technicians.verify')

@endsection
