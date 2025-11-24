<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Customer Details PDF</title>
    <style>
        /* ====== Global Styles ====== */
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            margin: 20px;
            background-color: #f8f9fa;
            color: #212529;
            font-size: 14px;
        }

        h5 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
        }

        strong {
            font-weight: 600;
        }

        /* ====== Card Styles ====== */
        .card {
            background: #fff;
            border-radius: 6px;
            border: 1px solid #dee2e6;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .card-header {
            padding: 10px 15px;
            font-weight: bold;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            align-items: center;
            gap: 8px;
            border-top-left-radius: 6px;
            border-top-right-radius: 6px;
        }

        .card-body {
            padding: 15px;
        }

        .card-title {
            margin: 0;
        }

        /* ====== Colors ====== */
        .bg-primary {
            background: #0d6efd;
            color: #fff;
        }

        .bg-warning {
            background: #ffc107;
            color: #212529;
        }

        .bg-info {
            background: #0dcaf0;
            color: #fff;
        }

        .bg-success {
            background: #198754;
            color: #fff;
        }

        /* ====== Grid System ====== */
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: -8px;
        }

        .col {
            padding: 8px;
        }

        .col-12 {
            flex: 0 0 100%;
        }

        .col-md-6 {
            flex: 0 0 50%;
        }

        .col-md-5 {
            flex: 0 0 41.6667%;
        }

        .col-md-4 {
            flex: 0 0 33.3333%;
        }

        .col-md-3 {
            flex: 0 0 25%;
        }

        @media(max-width:768px) {

            .col-md-6,
            .col-md-5,
            .col-md-4,
            .col-md-3 {
                flex: 0 0 100%;
            }
        }

        /* ====== Table Styles ====== */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        thead {
            background: #f1f3f5;
            font-weight: bold;
        }

        th,
        td {
            padding: 6px;
            border: 1px solid #dee2e6;
            text-align: center;
        }

        tbody tr:hover {
            background: #f8f9fa;
        }

        /* ====== Text Utilities ====== */
        .text-center {
            text-align: center;
        }

        .text-danger {
            color: #dc3545;
        }

        .text-muted {
            color: #6c757d;
        }

        .text-dark {
            color: #212529;
        }
    </style>
</head>

<body>

    <div>
        <!-- ===== Customer Info Card ===== -->
        <div class="card">
            <div class="card-header bg-primary">
                <h5 class="card-title text-dark">Customer Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col col-12 col-md-6"><strong>Customer ID:</strong> {{ $customer->id ?? '-' }}</div>
                    <div class="col col-12 col-md-6">
                        <strong>Username:</strong>
                        @if ($customer->user_name)
                            {{ $customer->user_name }}
                        @else
                            <span class="text-danger">Not Generate</span>
                        @endif
                    </div>
                    <div class="col col-12 col-md-6"><strong>Name:</strong> {{ $customer->lead->name ?? '-' }}</div>
                    <div class="col col-12 col-md-6"><strong>Address:</strong> {{ $customer->lead->address ?? '-' }}
                    </div>
                    <div class="col col-12 col-md-6"><strong>Contact:</strong> {{ $customer->lead->mobile ?? '-' }}
                    </div>
                    <div class="col col-12 col-md-6"><strong>Email:</strong> {{ $customer->lead->email ?? '-' }}</div>
                    <div class="col col-12 col-md-6"><strong>Lead Source:</strong>
                        {{ ucfirst($customer->lead->lead_source ?? '-') }}</div>


                    @if ($customer->lead->lead_source == 'staff')
                        <div class="col col-12 col-md-6"><strong>Staff:</strong>
                            {{ ucfirst($customer->lead->staff->name ?? '-') }}
                        </div>
                    @endif
                    @if ($customer->lead->lead_source == 'customer')
                        @if ($customer->lead->is_refere == 'customer')
                            <div class="col col-12 col-md-6"><strong>Refer By Customer:</strong>
                                {{ ucfirst($customer->lead->referByCustomer->lead->name ?? '-') }}
                            </div>
                        @else
                            <div class="col col-12 col-md-6"><strong>Refer By Customer:</strong>
                                {{ ucfirst($customer->lead->refer_by ?? '-') }}
                            </div>
                        @endif
                    @endif
                    <div class="col col-12 col-md-6"><strong>Sales Convert:</strong>
                        {{ $customer->convertedBy->name ?? '-' }}</div>
                    <div class="col col-12 col-md-6"><strong>Date:</strong>
                        {{ \Carbon\Carbon::parse($customer->updated_at)->format('d-m-Y | h:i A') }}</div>
                    <div class="col col-12 col-md-6"><strong>Time:</strong> <span
                            class="text-muted">{{ $customer->formatted_time }}</span></div>
                    <div class="col col-12 col-md-6"><strong>Assign To:</strong>
                        {{ $customer->assignLead->name ?? 'No User Assigned' }}</div>
                </div>
            </div>
        </div>

        <!-- ===== Product / Skim / Payment Row ===== -->
        <div class="row">
            <!-- Product List -->
            <div class="col col-12 col-md-5">
                <div class="card">
                    <div class="card-header bg-warning">
                        <h5 class="card-title text-dark">Product List</h5>
                    </div>
                    <div class="card-body" style="padding:0;">
                        <table>
                            <thead>
                                <tr>
                                    <th>S.N</th>
                                    <th>Name</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customer->products as $product)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @php
                                                $pro = Modules\Product\Entities\Machinery::select(
                                                    'name',
                                                    'original_price',
                                                    'image',
                                                )
                                                    ->where('id', $product['product_id'])
                                                    ->first();
                                            @endphp
                                            {{ $pro->name }}
                                        </td>
                                        <td>{{ $product['product_qty'] }}</td>
                                        <td>{{ $product['product_price'] }}</td>
                                        <td>{{ $product['product_total'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Skim List -->
            <div class="col col-12 col-md-4">
                <div class="card">
                    <div class="card-header bg-info">
                        <h5 class="card-title text-dark">Skim Details</h5>
                    </div>
                    <div class="card-body" style="padding:0;">
                        <table>
                            <thead>
                                <tr>
                                    <th>S.N</th>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($skims as $skim)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $skim->skim_item_name }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">No Skim Found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Payment Info -->
            <div class="col col-12 col-md-3">
                <div class="card">
                    <div class="card-header bg-success">
                        <h5 class="card-title text-dark">Payment Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-2"><strong>Total Amount:</strong> {{ $customer->total_amount }}</div>
                        <div class="mb-2"><strong>Paid Amount:</strong> {{ $customer->paid_amount ?? '0' }}</div>
                        <div class="mb-2 text-danger"><strong>Due Amount:</strong> {{ $customer->due_amount }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
