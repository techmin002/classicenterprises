@extends('setting::layouts.master')

@section('title', "Customer Detail's")
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Customer Detail's</li>
</ol>
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Customer Detail's</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <strong>Customer: </strong>{{ $customer->lead['name'] ?? '-' }}
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-2">
                                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                        aria-orientation="vertical">
                                        <button class="nav-link active" id="v-pills-machineries-tab" data-toggle="pill"
                                            data-target="#v-pills-machineries" type="button" role="tab"
                                            aria-controls="v-pills-machineries" aria-selected="true">Machineries</button>
                                        <button class="nav-link" id="v-pills-accessories-tab" data-toggle="pill"
                                            data-target="#v-pills-accessories" type="button" role="tab"
                                            aria-controls="v-pills-accessories" aria-selected="false">Accessories</button>
                                    </div>
                                </div>

                                <div class="col-10">
                                    <div class="tab-content" id="v-pills-tabContent">

                                        {{-- MACHINERIES TAB --}}
                                        <div class="tab-pane fade show active" id="v-pills-machineries" role="tabpanel"
                                            aria-labelledby="v-pills-machineries-tab">
                                            <div class="card">
                                                <div class="card-header"><h4>Machineries</h4></div>
                                                <div class="card-body">
                                                    <table class="table table-bordered text-center">
                                                        <thead>
                                                            <tr>
                                                                <th>S.N</th>
                                                                <th>Name</th>
                                                                <th>Image</th>
                                                                <th>Price</th>
                                                                <th>Quantity</th>
                                                                <th>Amount</th>
                                                                <th>Created At</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($customer->products as $product)
                                                                @php
                                                                    $pro = Modules\Product\Entities\Machinery::select('name','original_price','image')
                                                                            ->where('id', $product['product_id'])
                                                                            ->first();
                                                                @endphp
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $pro->name ?? '-' }}</td>
                                                                    <td>
                                                                        <img src="{{ asset('upload/images/machinery/' . ($pro->image ?? 'default.png')) }}"
                                                                            style="width: 200px" alt="">
                                                                    </td>
                                                                    <td>{{ $product['product_price'] }}</td>
                                                                    <td>{{ $product['product_qty'] }}</td>
                                                                    <td>{{ $product['product_total'] }}</td>
                                                                    <td>{{ $product['created_at'] }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- ACCESSORIES TAB --}}
                                        <div class="tab-pane fade" id="v-pills-accessories" role="tabpanel"
                                            aria-labelledby="v-pills-accessories-tab">
                                            <div class="card">
                                                <div class="card-header"><h4>Accessories</h4></div>
                                                <div class="card-body">
                                                    <table class="table table-bordered text-center">
                                                        <thead>
                                                            <tr>
                                                                <th>S.N</th>
                                                                <th>Name</th>
                                                                <th>Image</th>
                                                                <th>Price</th>
                                                                <th>Quantity</th>
                                                                <th>Amount</th>
                                                                <th>Created At</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($customer->accessories as $accessory)
                                                                @php
                                                                    $pro = Modules\Product\Entities\Accessory::select('name','original_price','image')
                                                                            ->where('id', $accessory['accessory_id'])
                                                                            ->first();
                                                                @endphp
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $pro->name ?? '-' }}</td>
                                                                    <td>
                                                                        <img src="{{ asset('upload/images/accessory/' . ($pro->image ?? 'default.png')) }}"
                                                                            style="width: 200px" alt="">
                                                                    </td>
                                                                    <td>{{ $accessory['accessory_price'] }}</td>
                                                                    <td>{{ $accessory['accessory_qty'] }}</td>
                                                                    <td>{{ $accessory['accessory_total'] }}</td>
                                                                    <td>{{ $accessory['created_at'] }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->

                </div>
            </div>
        </div>
    </section>
</div>

<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
@endsection