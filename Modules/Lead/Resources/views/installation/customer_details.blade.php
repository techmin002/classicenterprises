@extends('setting::layouts.master')

@section('title', "Customer Detail's")
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active"> Customer Detail's</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1> Customer Detail's</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active"> Customer Detail's</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <!-- /.card -->

                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-12">
                                        <strong>Customer: </strong>{{ $customer->lead['name'] }}
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-2">
                                      <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                        <button class="nav-link active" id="v-pills-home-tab" data-toggle="pill" data-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Machineries</button>
                                        <button class="nav-link" id="v-pills-profile-tab" data-toggle="pill" data-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Accessories</button>
                                      </div>
                                    </div>
                                    <div class="col-10">
                                      <div class="tab-content" id="v-pills-tabContent">
                                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                            <div class="row">
                                                <dic class="col-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4>Machineries</h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <table id="" class="table table-bordered">
                                                                    <thead>
                                                                        <th>S.N</th>
                                                                        <th>Name</th>
                                                                        <th>Image</th>
                                                                        <th>Price</th>
                                                                        <th>Created At</th>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($customer->products as $product)
                                                                        <tr>
                                                                            <td>{{ $loop->iteration }}</td>
                                                                            <td>
                                                                                @php
                                                                                    $pro=Modules\Product\Entities\Machinery::select('name','original_price','image')->where('id',$product['product_id'])->first();
                                                                                @endphp
                                                                                {{ $pro->name }}
                                                                            </td>
                                                                            <td>
                                                                                <img src="{{ asset('upload/images/machinery/'.$pro['image']) }}" class="w-25" alt="">
                                                                            </td>
                                                                            <td>{{ $product['product_price'] }}</td>
                                                                            <td>{{ $product['created_at'] }}</td>

                                                                        </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </dic>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                            <div class="row">
                                                <dic class="col-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4>Accessories</h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <th>S.N</th>
                                                                        <th>Name</th>
                                                                        <th>Image</th>
                                                                        <th>Price</th>
                                                                        <th>Created At</th>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($customer->accessories as $accessory)
                                                                        <tr>
                                                                            <td>{{ $loop->iteration }}</td>
                                                                            <td>
                                                                                @php
                                                                                    $pro=Modules\Product\Entities\Accessory::select('name','original_price','image')->where('id',$product['product_id'])->first();
                                                                                @endphp
                                                                                {{ $pro->name }}
                                                                            </td>
                                                                            <td>
                                                                                <img src="{{ asset('upload/images/accessory/'.$pro['image']) }}" class="w-25" alt="">
                                                                            </td>
                                                                            <td>{{ $product['product_price'] }}</td>
                                                                            <td>{{ $product['created_at'] }}</td>

                                                                        </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </dic>
                                            </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                               </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <script>
       $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
    </script>
@endsection

