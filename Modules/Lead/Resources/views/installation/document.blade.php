@extends('setting::layouts.master')

@section('title', "Customer Documents's")
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active"> Customer Documents</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1> Customer Documents</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active"> Customer Documents</li>
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
                                <div class="row g-4">
                                    <!-- Document Image -->
                                    <div class="col-md-6">
                                        <div class="card shadow-sm">
                                            <div class="card-header bg-primary text-white">
                                                Product Image
                                            </div>
                                            <div class="card-body text-center">
                                                @if ($customer->product_document)
                                                    <img src="{{ asset('receipts/' . $customer->product_document) }}"
                                                        alt="Document Image" class="img-fluid rounded border"
                                                        style="max-height: 300px;">
                                                @else
                                                    <p class="text-muted">No Document Uploaded</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Warranty Card -->
                                    <div class="col-md-6">
                                        <div class="card shadow-sm">
                                            <div class="card-header bg-success text-white">
                                                Warranty Card
                                            </div>
                                            <div class="card-body text-center">
                                                @if ($customer->warranty_card)
                                                    <img src="{{ asset('receipts/' . $customer->warranty_card) }}"
                                                        alt="Warranty Card" class="img-fluid rounded border"
                                                        style="max-height: 300px;">
                                                @else
                                                    <p class="text-muted">No Warranty Card Uploaded</p>
                                                @endif
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
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@endsection
