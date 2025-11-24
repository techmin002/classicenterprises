@extends('setting::layouts.master')

@section('title', 'Lead Details')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Lead Details</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Lead Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Lead Details</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Lead Info Card -->
                <div class="card shadow-sm mb-4 border-0 rounded">
                    <div class="card-header bg-primary text-white d-flex align-items-center">
                        <i class="bi bi-person-circle me-2"></i>
                        <h5 class="card-title mb-0">Lead Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6 mb-2"><strong>Lead ID:</strong> {{ $lead->id ?? '-' }}
                            </div>
                            <div class="col-12 col-md-6 mb-2"><strong>Name:</strong> {{ $lead->name ?? '-' }}
                            </div>
                            <div class="col-12 col-md-6 mb-2"><strong>Address:</strong>
                                {{ $lead->address ?? '-' }}</div>
                            <div class="col-12 col-md-6 mb-2"><strong>Contact:</strong> {{ $lead->mobile ?? '-' }}
                            </div>
                            <div class="col-12 col-md-6 mb-2"><strong>Email:</strong> {{ $lead->email ?? '-' }}
                            </div>
                            <div class="col-12 col-md-6 mb-2"><strong>Date:</strong>
                                {{ \Carbon\Carbon::parse($lead->created_at)->format('d-m-Y | h:i A') }}</div>
                            <div class="col-12 col-md-6 mb-2">
                                <strong>Time: </strong>
                                <span class="text-muted">{{ $lead->formatted_time }}</span>
                            </div>
                            <div class="col-12 col-md-6 mb-2"><strong>Lead Source:</strong>
                                {{ $lead->lead_source }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
