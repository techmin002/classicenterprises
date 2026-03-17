@extends('setting::layouts.master')

@section('title', 'Return Details')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">
            <div class="container-fluid">
                <h4 class="text-primary">
                    <i class="fas fa-receipt"></i> Return Details
                </h4>
            </div>
        </section>

        <section class="content">

            <div class="container-fluid">

                <div class="card card-primary">

                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-file-invoice"></i>
                            Return Invoice : <b>{{ $return->return_invoice }}</b>
                        </h3>
                        <div class="col-md-6 text-right">
                            <strong>Created By :</strong>
                            {{ $return->creator->name ?? 'System' }}
                        </div>

                    </div>

                    <div class="card-body">

                        <div class="table-responsive">

                            <table class="table table-bordered table-striped table-hover">

                                <thead class="bg-light">

                                    <tr>
                                        <th width="40%">Product</th>
                                        <th width="15%">Quantity</th>
                                        <th width="15%">Price</th>
                                        <th width="20%">Total</th>
                                    </tr>

                                </thead>

                                <tbody>

                                    @php
                                        $grandTotal = 0;
                                    @endphp

                                    @foreach ($return->items as $item)
                                        @php
                                            $grandTotal += $item->total;
                                        @endphp

                                        <tr>

                                            <td>
                                                <strong>{{ $item->name }}</strong>
                                            </td>

                                            <td>
                                                <span class="badge badge-info">
                                                    {{ $item->quantity }}
                                                </span>
                                            </td>

                                            <td>
                                                Rs. {{ number_format($item->price, 2) }}
                                            </td>

                                            <td>
                                                <strong class="text-success">
                                                    Rs. {{ number_format($item->total, 2) }}
                                                </strong>
                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>

                                <tfoot>

                                    <tr>

                                        <th colspan="3" class="text-right">
                                            Grand Total
                                        </th>

                                        <th class="text-success">
                                            Rs. {{ number_format($grandTotal, 2) }}
                                        </th>

                                    </tr>

                                </tfoot>

                            </table>

                        </div>

                        @if ($return->remarks)
                            <div class="mt-3">

                                <label><i class="fas fa-comment"></i> Remarks</label>

                                <div class="alert alert-light border">
                                    {{ $return->remarks }}
                                </div>

                            </div>
                        @endif

                    </div>


                    <div class="card-footer text-right">

                        <a href="{{ route('sale-returns.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>

                    </div>

                </div>

            </div>

        </section>

    </div>

@endsection
