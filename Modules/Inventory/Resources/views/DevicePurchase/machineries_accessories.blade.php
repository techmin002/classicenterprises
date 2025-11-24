@extends('setting::layouts.master')

@section('title', 'Machineries & Accessories')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Machineries & Accessories</li>
    </ol>
@endsection
@php
    use Modules\Inventory\Entities\Accessories;
    use Modules\Inventory\Entities\Machineries;
@endphp
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Machineries And Accessories</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Machineries and Accessories</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">

                <div class="card card-primary card-outline">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="card-title mb-0">
                                <i class="fas fa-info-circle mr-2"></i> Purchase Information
                            </h3>
                        </div>
                        <div class="badge-group">
                            <span class="badge badge-info">
                                <i class="fas fa-user-tie mr-1"></i> Supplier: {{ $supplier->name ?? '-' }}
                            </span>
                            <span class="badge badge-info ml-2">
                                <i class="fas fa-file-invoice mr-1"></i> Bill No: {{ $bill_no ?? '-' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- MACHINERIES TABLE --}}
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title"><i class="fas fa-cogs mr-2"></i>Machineries List</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>SN</th>
                                        <th>Machinery</th>
                                        <th>Branch</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($machineries as $machinery)
                                        @php
                                            $mac = Machineries::find($machinery->machinery_id);
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $mac->name ?? '-' }}</td>
                                            <td>{{ $machinery->branch->name ?? '-' }}</td>
                                            <td>{{ $machinery->quantity }}</td>
                                            <td>{{ number_format($machinery->unit_price, 2) }}</td>
                                            <td>{{ number_format($machinery->total, 2) }}</td>
                                            <td>
                                                <span
                                                    class="badge {{ $machinery->status ? 'badge-success' : 'badge-warning' }}">
                                                    {{ $machinery->status ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4">No machineries found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- ACCESSORIES TABLE --}}
                <div class="card mt-4">
                    <div class="card-header bg-info text-white">
                        <h3 class="card-title"><i class="fas fa-tools mr-2"></i>Accessories List</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>SN</th>
                                        <th>Accessory</th>
                                        <th>Branch</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($accessories as $item)
                                        @php
                                            $acc = Accessories::find($item->accessory_id);
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                {{ $acc->name ?? '-' }}
                                                @if ($item->description)
                                                    <p class="text-muted small mb-0">{{ $item->description }}</p>
                                                @endif
                                            </td>
                                            <td>{{ $item->branch->name ?? '-' }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ number_format($item->unit_price, 2) }}</td>
                                            <td>{{ number_format($item->total, 2) }}</td>
                                            <td>
                                                <span
                                                    class="badge {{ $item->status ? 'badge-success' : 'badge-warning' }}">
                                                    {{ $item->status ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4">No accessories found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- SUMMARY CARD --}}
                <div class="card mt-4">
                    <div class="card-header bg-secondary text-white">
                        <h3 class="card-title"><i class="fas fa-calculator mr-2"></i>Purchase Summary</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <dl class="row mb-0">
                                    <dt class="col-sm-4">Total Machineries:</dt>
                                    <dd class="col-sm-8">{{ $machineries->count() }}</dd>

                                    <dt class="col-sm-4">Machineries Total:</dt>
                                    <dd class="col-sm-8">{{ number_format($machineries->sum('total'), 2) }}</dd>
                                </dl>
                            </div>
                            <div class="col-md-6">
                                <dl class="row mb-0">
                                    <dt class="col-sm-4">Total Accessories:</dt>
                                    <dd class="col-sm-8">{{ $accessories->count() }}</dd>

                                    <dt class="col-sm-4">Accessories Total:</dt>
                                    <dd class="col-sm-8">{{ number_format($accessories->sum('total'), 2) }}</dd>
                                </dl>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12 text-right">
                                <h4 class="mb-0">
                                    <span class="text-muted mr-2">Grand Total:</span>
                                    <span class="text-primary">
                                        {{ number_format($machineries->sum('total') + $accessories->sum('total'), 2) }}
                                    </span>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection
