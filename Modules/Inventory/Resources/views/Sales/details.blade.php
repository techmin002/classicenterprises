@extends('setting::layouts.master')

@section('title', "Sale Details - #{$sale->invoice_number}")
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('sales.index') }}">Sales</a></li>
        <li class="breadcrumb-item active">Details #{{ $sale->invoice_number }}</li>
    </ol>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Sale Details</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-header bg-info text-white">
                            <h3 class="card-title">Invoice #{{ $sale->invoice_number }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h5>Customer Information</h5>
                                    <p><strong>Name:</strong> {{ $sale->customer_name }}</p>
                                    <p><strong>Contact:</strong> {{ $sale->contact }}</p>
                                    <p><strong>Type:</strong> {{ ucfirst($sale->customer_type) }}</p>
                                </div>
                                <div class="col-md-6 text-right">
                                    <h5>Payment Information</h5>
                                    <p><strong>Total Amount:</strong> {{ number_format($sale->total_amount, 2) }}</p>
                                    <p><strong>Paid Amount:</strong> {{ number_format($sale->paid_amount, 2) }}</p>
                                    <p><strong>Balance Due:</strong> {{ number_format($sale->balance_due, 2) }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="mb-3">Accessories</h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Quantity</th>
                                                    <th>Unit Price</th>
                                                    <th>Total</th>
                                                    <th>Warranty</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($sale->saleAccessories as $accessory)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $accessory->accessory->name ?? $accessory->name }}</td>
                                                    <td>{{ $accessory->quantity }}</td>
                                                    <td>{{ number_format($accessory->price, 2) }}</td>
                                                    <td>{{ number_format($accessory->total, 2) }}</td>
                                                    <td>
                                                        @if($accessory->warranty == 'none')
                                                            No Warranty
                                                        @else
                                                            {{ strtoupper($accessory->warranty) }}
                                                        @endif
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">No accessories found</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <h4 class="mb-3">Machineries</h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Quantity</th>
                                                    <th>Unit Price</th>
                                                    <th>Total</th>
                                                    <th>Warranty</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($sale->saleMachineries as $machinery)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $machinery->machinery->name ?? $machinery->name }}</td>
                                                    <td>{{ $machinery->quantity }}</td>
                                                    <td>{{ number_format($machinery->price, 2) }}</td>
                                                    <td>{{ number_format($machinery->total, 2) }}</td>
                                                    <td>
                                                        @if($machinery->warranty == 'none')
                                                            No Warranty
                                                        @else
                                                            {{ strtoupper($machinery->warranty) }}
                                                        @endif
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">No machineries found</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('sales.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Sales
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection