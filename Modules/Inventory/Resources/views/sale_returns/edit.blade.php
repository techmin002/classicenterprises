@extends('setting::layouts.master')

@section('title', 'Edit Return')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">
            <div class="container-fluid">
                <h4 class="text-primary">
                    <i class="fas fa-undo-alt"></i> Edit Sale Return
                </h4>
            </div>
        </section>

        <section class="content">

            <div class="container-fluid">

                <form method="POST" action="{{ route('sale-returns.update', $return->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="card card-primary">

                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-file-invoice"></i>
                                Sale Invoice : <b>{{ $return->sale->invoice_number }}</b>
                            </h3>
                        </div>

                        <div class="card-body">

                            <div class="table-responsive">

                                <table class="table table-bordered table-hover">

                                    <thead class="bg-light">
                                        <tr>
                                            <th width="40%">Product</th>
                                            <th width="20%">Return Qty</th>
                                            <th width="20%">Price</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @foreach ($return->items as $index => $item)
                                            <tr>

                                                <td>
                                                    <strong>{{ $item->name }}</strong>
                                                </td>

                                                <td>
                                                    <input type="number" class="form-control"
                                                        name="items[{{ $index }}][quantity]"
                                                        value="{{ $item->quantity }}" min="1">
                                                </td>

                                                <td>
                                                    <input type="text" class="form-control"
                                                        name="items[{{ $index }}][price]"
                                                        value="{{ $item->price }}">
                                                </td>

                                                <input type="hidden" name="items[{{ $index }}][accessory_id]"
                                                    value="{{ $item->accessory_id }}">

                                                <input type="hidden" name="items[{{ $index }}][machinery_id]"
                                                    value="{{ $item->machinery_id }}">

                                                <input type="hidden" name="items[{{ $index }}][name]"
                                                    value="{{ $item->name }}">

                                            </tr>
                                        @endforeach

                                    </tbody>

                                </table>

                            </div>


                            <div class="row mt-4">

                                <div class="col-md-6">

                                    <label><i class="fas fa-comment"></i> Remarks</label>

                                    <textarea name="remarks" class="form-control" rows="3" placeholder="Enter return remarks...">{{ $return->remarks }}</textarea>

                                </div>

                            </div>

                        </div>

                        <div class="card-footer text-right">

                            <a href="{{ route('sale-returns.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>

                            <button class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Return
                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </section>

    </div>

@endsection
