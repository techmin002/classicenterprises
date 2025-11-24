@extends('setting::layouts.master')

@section('title', 'Customer Details')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Customer Details</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Customer Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Customer Details</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Customer Info Card -->
                <div class="card shadow-sm mb-4 border-0 rounded">
                    <div class="card-header bg-primary text-white d-flex align-items-center">
                        <i class="bi bi-person-circle me-2"></i>
                        <h5 class="card-title mb-0">Customer Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6 mb-2"><strong>Customer ID:</strong> {{ $customer->id ?? '-' }}
                            </div>
                            <div class="col-12 col-md-6 mb-2">
                                <strong>Username:</strong>
                                {{ $customer->user_name }}
                            </div>
                            <div class="col-12 col-md-6 mb-2"><strong>Name:</strong>
                                {{ $customer->customer->lead->name ?? $customer->customer_name }}
                            </div>
                            <div class="col-12 col-md-6 mb-2"><strong>Address:</strong>
                                {{ $customer->customer->lead->address ?? $customer->address }}</div>
                            <div class="col-12 col-md-6 mb-2"><strong>Contact:</strong>
                                {{ $customer->customer->lead->mobile ?? $customer->contact }}
                            </div>
                            <div class="col-12 col-md-6 mb-2"><strong>Email:</strong>
                                {{ $customer->customer->lead->email ?? $customer->email }}
                            </div>
                            <div class="col-12 col-md-6 mb-2"><strong>Amc Sales:</strong>
                                {{ ucfirst($customer->sales) }}</div>
                            <div class="col-12 col-md-6 mb-2"><strong>Amc Type:</strong>
                                {{ ucfirst($customer->amc->title) }}</div>

                            <div class="col-12 col-md-6 mb-2"><strong>Duration:</strong>
                                {{ $customer->amc->year }} Years</div>
                            <div class="col-12 col-md-6 mb-2"><strong>Date:</strong>
                                {{ \Carbon\Carbon::parse($customer->updated_at)->format('d-m-Y | h:i A') }}</div>
                            <div class="col-12 col-md-6 mb-2"><strong>Time: </strong><span
                                    class="text-muted">{{ $customer->formatted_time }}</span></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow-sm mb-4 border-0 rounded">
                            <div class="card-header bg-success text-white d-flex align-items-center">
                                <i class="bi bi-currency-dollar me-2"></i>
                                <h5 class="card-title mb-0">Payment Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-2"><strong>Total Amount:</strong>
                                    {{ $customer->amount ?? 'total_amount' }}</div>
                                <div class="mb-2"><strong>Paid Amount:</strong> {{ ($customer->cash_amount + ) ?? '0' }}</div>
                                <div class="mb-2 text-danger"><strong>Due Amount:</strong>
                                    {{ $customer->due_amount ?? 'due_amount' }}
                                </div>

                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-12 col-md-3">
                        <a href="{{ route('customer.pdf', $customer->id) }}" class="btn btn-success">
                            <i class="bi bi-file-earmark-pdf"></i> Download PDF
                        </a>
                    </div> --}}
                </div>

            </div>
        </section>
    </div>
@endsection
