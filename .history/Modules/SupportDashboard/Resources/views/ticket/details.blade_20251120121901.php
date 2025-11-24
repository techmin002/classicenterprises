@extends('setting::layouts.master')

@section('title', 'Customer Payments')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active"> Customer Payments</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Register Customer Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active"> Customer Payments</li>
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
                        <div class="card shadow-sm">
                            <div class="card-header bg-info text-white">
                                <h5><strong>Customer Information</strong>
                                    {{ $customer->customer->lead->name ?? ($customer->amccustomer->customer_name ?? $customer->customer_name) }}
                                    <h5>
                                        <h5><strong>Service Charge :</strong> {{ $customer->service_charge ?? 'Pending Service' }}</h5>
                            </div>

                            <div class="card-body">
                                <!-- Customer Details Card -->
                                <div class="col-12 mb-4">
                                    <div class="card border-success">
                                        <div class="card-header bg-success text-white">
                                            <strong>Customer Information Details</strong>
                                        </div>
                                        <div class="card-body p-2">
                                            <div class="row">
                                                @if ($customer->type == 'register')
                                                    <div class="col-12 col-md-6 mb-2"><strong>Customer ID:</strong>
                                                        {{ $customer->customer->id ?? '-' }}
                                                    </div>
                                                @endif
                                                <div class="col-12 col-md-6 mb-2">
                                                    <strong>Username:</strong>
                                                    {{ $customer->customer->user_name ?? ($customer->amccustomer->user_name ?? $customer->user_name) }}
                                                </div>
                                                <div class="col-12 col-md-6 mb-2"><strong>Name:</strong>
                                                    {{ $customer->customer->lead->name ?? ($customer->amccustomer->customer_name ?? $customer->customer_name) }}
                                                </div>
                                                <div class="col-12 col-md-6 mb-2"><strong>Address:</strong>
                                                    {{ $customer->customer->lead->address ?? ($customer->amccustomer->address ?? $customer->address) }}
                                                </div>
                                                <div class="col-12 col-md-6 mb-2"><strong>Contact:</strong>
                                                    {{ $customer->customer->lead->mobile ?? ($customer->amccustomer->contact ?? $customer->contact) }}
                                                </div>
                                                <div class="col-12 col-md-6 mb-2"><strong>Email:</strong>
                                                    {{ $customer->customer->lead->email ?? ($customer->amccustomer->customer_name ?? $customer->customer_name) }}
                                                </div>
                                                <div class="col-12 col-md-6 mb-2"><strong>Lead Source:</strong>
                                                    {{ $customer->customer->lead->lead_source ?? 'Outsider' }}
                                                </div>
                                                <div class="col-12 col-md-6 mb-2"><strong>Sales Convert:</strong>
                                                    {{ $customer->customer->convertedBy->name ?? ($customer->amccustomer->customer_name ?? $customer->customer_name) }}
                                                </div>


                                            

                                                <div class="col-12 col-md-6 mb-2"><strong>Assign To:</strong>
                                                    {{ $customer->customer->assignLead->name ?? ($customer->amccustomer->sales ?? $customer->customer_name) }}
                                                </div>
                                                {{-- <div class="col-12 col-md-6 mb-2"><strong>Date:</strong>
                                                    {{ \Carbon\Carbon::parse($customer->updated_at)->format('d-m-Y | h:i A') }}
                                                </div>
                                                <div class="col-12 col-md-6 mb-2"><strong>Time: </strong><span
                                                        class="text-muted">{{ $customer->created_time ?? 'N/A' }}</span>
                                                </div>
                                                <div class="col-12 col-md-6 mb-2"><strong>Assign To: </strong><span
                                                        class="text-muted">{{ $customer->created_time ?? 'N/A' }}</span>
                                                </div> --}}
                                                @if ($customer->type == 'outsider')
                                                    <div class="col-12 col-md-6 mb-2"><strong>Previous Product:
                                                        </strong><span
                                                            class="text-muted">{{ $customer->product_name ?? 'N/A' }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Payment Details Card -->
                                <div class="col-12 mb-4">
                                    <div class="card border-success">
                                        <div class="card-header bg-success text-white">
                                            <strong>Payment Details</strong>
                                        </div>
                                        <div class="card-body p-2">
                                            <table id="example1" class="table table-bordered table-striped mb-0">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th class="text-center">S.N</th>
                                                        <th class="text-center">Amount</th>
                                                        <th class="text-center">Payment Method</th>
                                                        <th class="text-center">Date</th>
                                                        <th class="text-center">Receipts</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($customer->payments as $key => $payment)
                                                        <tr>
                                                            <td class="text-center">{{ $loop->iteration }}</td>
                                                            <td class="text-center">{{ $payment->paid_amount }}</td>
                                                            <td class="text-center">{{ $payment->payment_method }}</td>
                                                            <td class="text-center">
                                                                {{ $payment->created_at->format('d-m-Y') }}</td>
                                                            <td class="text-center">
                                                                @if ($payment->cash_amount && $payment->cash_receipt)
                                                                    <a href="{{ asset('receipts/' . $payment->cash_receipt) }}"
                                                                        target="_blank" class="badge bg-success">Cash</a>
                                                                @endif
                                                                @if ($payment->online_amount && $payment->online_receipt)
                                                                    <a href="{{ asset('receipts/' . $payment->online_receipt) }}"
                                                                        target="_blank" class="badge bg-primary">Online</a>
                                                                @endif
                                                                @if ($payment->cheque_amount && $payment->cheque_receipt)
                                                                    <a href="{{ asset('receipts/' . $payment->cheque_receipt) }}"
                                                                        target="_blank"
                                                                        class="badge bg-warning text-dark">Cheque</a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Accessories Details Card -->
                                <div class="col-12">
                                    <div class="card border-primary">
                                        <div class="card-header bg-primary text-white">
                                            <strong>Accessories Details</strong>
                                        </div>
                                        <div class="card-body p-2">
                                            <table id="example2"
                                                class="table table-bordered table-striped mb-0 text-center ">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th>S.N</th>
                                                        <th>Name</th>
                                                        <th>Quantity</th>
                                                        <th>Price</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $grandTotal = 0;
                                                    @endphp
                                                    @foreach ($customer->accessories as $key => $acc)
                                                        @php
                                                            $grandTotal += $acc->accessory_total;
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $acc->accessory->name ?? 'N/A' }}</td>
                                                            <td>{{ $acc->accessory_qty }}</td>
                                                            <td>
                                                                {{ number_format($acc->accessory_price, 2) }}</td>
                                                            <td>
                                                                {{ number_format($acc->accessory_total, 2) }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr class="bg-light">
                                                        <th colspan="3">Grand Total:</th>
                                                        <th colspan="2" class="text-success text-center">
                                                            {{ number_format($grandTotal, 2) }}</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
