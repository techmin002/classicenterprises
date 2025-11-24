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
                                {{$customer->customer_name}}
                            </div>
                            <div class="col-12 col-md-6 mb-2"><strong>Name:</strong> {{ $customer->customer->lead->name ?? $customer->customer_name }}
                            </div>
                            <div class="col-12 col-md-6 mb-2"><strong>Address:</strong>
                                {{ $customer->lead->address ?? '-' }}</div>
                            <div class="col-12 col-md-6 mb-2"><strong>Contact:</strong> {{ $customer->lead->mobile ?? '-' }}
                            </div>
                            <div class="col-12 col-md-6 mb-2"><strong>Email:</strong> {{ $customer->lead->email ?? '-' }}
                            </div>
                            <div class="col-12 col-md-6 mb-2"><strong>Lead Source:</strong>
                                {{ ucfirst($customer->lead->lead_source ?? '-') }}</div>

                            {{-- @if ($customer->lead->lead_source == 'staff')
                                <div class="col-12 col-md-6 mb-2"><strong>Staff:</strong>
                                    {{ ucfirst($customer->lead->staff->name ?? 'N/A') }}</div>
                            @endif --}}
                            {{-- @if ($customer->lead->lead_source == 'customer')
                                @if ($customer->lead->is_refere == 'customer')
                                    <div class="col-12 col-md-6 mb-2"><strong>Refer By Customer:</strong>
                                        {{ $customer->lead->referByCustomer->lead->name ?? 'Customer' }}
                                    </div>
                                @else
                                    <div class="col-12 col-md-6 mb-2"><strong>Refer By Customer:</strong>
                                        {{ ucfirst($customer->lead->refer_by ?? 'N/A') }}</div>
                                @endif
                            @endif --}}

                            <div class="col-12 col-md-6 mb-2"><strong>Sales Convert:</strong>
                                {{ $customer->convertedBy->name ?? '-' }}</div>
                            <div class="col-12 col-md-6 mb-2"><strong>Date:</strong>
                                {{ \Carbon\Carbon::parse($customer->updated_at)->format('d-m-Y | h:i A') }}</div>
                            <div class="col-12 col-md-6 mb-2"><strong>Time: </strong><span
                                    class="text-muted">{{ $customer->formatted_time }}</span></div>
                            <div class="col-12 col-md-6 mb-2"><strong>Assign To:</strong>
                                {{ $customer->assignLead->name ?? 'No User Assigned' }}
                            </div>
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
                                    {{ $customer->total_amount ?? 'total_amount' }}</div>
                                <div class="mb-2"><strong>Paid Amount:</strong> {{ $customer->paid_amount ?? '0' }}</div>
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
