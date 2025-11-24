@extends('setting::layouts.master')

@section('title', 'Ticket Create')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Ticket Create</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Ticket Create</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Ticket Create</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section class="content">
            <div class="container-fluid">
                <ul class="nav nav-pills mb-3 d-flex gap-4" id="pills-tab" role="tablist">
                    <li class="nav-item me-2" role="presentation">
                        <button class="nav-link active" id="pills-registeruser-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-registeruser" type="button" role="tab"
                            aria-controls="pills-registeruser" aria-selected="true">Register Customer</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-outsideruser-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-outsideruser" type="button" role="tab"
                            aria-controls="pills-outsideruser" aria-selected="false">Outsider Customer</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-amcuser-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-amcuser" type="button" role="tab" aria-controls="pills-amcuser"
                            aria-selected="false">AMC Customer</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    {{-- Register Customer --}}
                    
                </div>
            </div>
        </section>
    </div>
@endsection
