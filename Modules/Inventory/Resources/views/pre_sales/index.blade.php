@extends('setting::layouts.master')

@section('title', "Pre Sales")

@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Pre Sales</li>
</ol>
@endsection

@section('content')
<style>
.modal-modern {
    border-radius: 20px;
    overflow: hidden;
}

.modal-header-modern {
    background: linear-gradient(90deg, #007bff, #0056b3);
    color: white;
}

.modal-body-modern {
    padding: 25px;
    background: #f8f9fa;
}

.modal-footer-modern {
    background: #f1f1f1;
}

.section-title {
    font-weight: 600;
    margin-bottom: 10px;
    border-bottom: 2px solid #ddd;
    padding-bottom: 5px;
}

/* Summary Cards */
.summary-box {
    color: #fff;
    padding: 15px;
    border-radius: 10px;
}
.summary-box h5 {
    margin: 0;
}

/* Table */
.table-modern {
    background: white;
    border-radius: 10px;
    overflow: hidden;
}
.table-modern thead {
    background: #007bff;
    color: white;
}
.table-modern th, .table-modern td {
    text-align: center;
    padding: 10px;
}
</style>

<div class="content-wrapper">

    <!-- HEADER -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="mb-0">Pre Sales</h1>
                {{-- @can('create_presales') --}}
                <button class="btn btn-primary" data-toggle="modal" data-target="#preSaleModal">
                    <i class="fa fa-plus"></i> Create
                </button>
                {{-- @endcan --}}
            </div>
        </div>
    </section>

    <!-- CONTENT -->
    <section class="content">
        <div class="container-fluid">

            <div class="card shadow-sm">
                <div class="card-body">

                    <!-- FILTER -->
                    <div class="mb-3">
                        <a href="{{ route('pre-sales.index') }}" class="btn btn-sm btn-outline-dark {{ request('status')==''?'active':'' }}">All</a>
                        <a href="{{ route('pre-sales.index',['status'=>'pending']) }}" class="btn btn-sm btn-outline-warning {{ request('status')=='pending'?'active':'' }}">Pending</a>
                        <a href="{{ route('pre-sales.index',['status'=>'confirmed']) }}" class="btn btn-sm btn-outline-success {{ request('status')=='confirmed'?'active':'' }}">Confirmed</a>
                        <a href="{{ route('pre-sales.index',['status'=>'cancelled']) }}" class="btn btn-sm btn-outline-danger {{ request('status')=='cancelled'?'active':'' }}">Cancelled</a>
                    </div>

                    <!-- TABLE -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center">

                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>#</th>
                                    <th>Booking No</th>
                                    <th>Customer</th>
                                    <th>Contact</th>
                                    <th>Advance</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                    <th>View</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($preSales as $preSale)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><strong>{{ $preSale->booking_number }}</strong></td>
                                    <td>{{ $preSale->customer_name }}</td>
                                    <td>{{ $preSale->contact }}</td>

                                    <td class="text-success font-weight-bold">
                                        {{ number_format($preSale->advance_amount,2) }}
                                    </td>

                                    <td class="text-primary font-weight-bold">
                                        {{ number_format($preSale->total_amount,2) }}
                                    </td>

                                    <td>
                                        @if($preSale->status=='pending')
                                            <span class="badge badge-warning">Pending</span>
                                        @elseif($preSale->status=='confirmed')
                                            <span class="badge badge-success">Confirmed</span>
                                        @else
                                            <span class="badge badge-danger">Cancelled</span>
                                        @endif
                                    </td>

                                    <td>{{ $preSale->created_at->format('d M Y') }}</td>

                                    <!-- ACTION -->
                                    <td>
                                        @if($preSale->status=='pending')
                                            <form action="{{ route('pre-sales.confirm',$preSale->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button class="btn btn-success btn-sm" onclick="return confirm('Convert to sale?')">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                            </form>

                                            <form action="{{ route('pre-sales.cancel',$preSale->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button class="btn btn-danger btn-sm" onclick="return confirm('Cancel booking?')">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>

                                    <!-- VIEW BUTTON -->
                                    <td>
                                        @can('show_presales')
                                        <button class="btn btn-info btn-sm"
                                            data-toggle="modal"
                                            data-target="#viewModal{{ $preSale->id }}">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                        @endcan
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10">No Data Found</td>
                                </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                    {{-- ✅ TABLE ENDS HERE — modals are now OUTSIDE the table --}}

                </div>
            </div>

        </div>
    </section>

</div>

{{-- ============================================================ --}}
{{-- ✅ ALL VIEW MODALS — placed OUTSIDE <table> and <div.card>   --}}
{{-- ============================================================ --}}
@foreach($preSales as $preSale)
<div class="modal fade" id="viewModal{{ $preSale->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content modal-modern">

            <!-- HEADER -->
            <div class="modal-header modal-header-modern">
                <h4 class="modal-title">
                    <i class="fa fa-eye mr-2"></i>
                    {{ $preSale->booking_number }}
                </h4>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            <!-- BODY -->
            <div class="modal-body modal-body-modern">

                <!-- CUSTOMER -->
                <h5 class="section-title text-primary">Customer Details</h5>

                <div class="row g-3 mb-4">
                    <div class="col-md-4"><b>Name:</b> {{ $preSale->customer_name }}</div>
                    <div class="col-md-4"><b>Contact:</b> {{ $preSale->contact }}</div>
                    <div class="col-md-4"><b>Email:</b> {{ $preSale->email ?? '-' }}</div>
                    <div class="col-md-12"><b>Address:</b> {{ $preSale->address ?? '-' }}</div>
                </div>

                <!-- PAYMENT -->
                <h5 class="section-title text-success">Payment Summary</h5>

                <div class="row text-center mb-4">
                    <div class="col-md-4">
                        <div class="summary-box bg-primary">
                            <p>Total</p>
                            <h5>{{ number_format($preSale->total_amount,2) }}</h5>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="summary-box bg-success">
                            <p>Advance</p>
                            <h5>{{ number_format($preSale->advance_amount,2) }}</h5>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="summary-box bg-danger">
                            <p>Balance</p>
                            <h5>{{ number_format($preSale->balance_due,2) }}</h5>
                        </div>
                    </div>
                </div>

                <!-- ITEMS -->
                <h5 class="section-title text-dark">Items</h5>

                <table class="table table-modern">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Name</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($preSale->items as $item)
                        <tr>
                            <td>
                                <span class="badge {{ $item->type=='accessory' ? 'badge-success' : 'badge-warning' }}">
                                    {{ ucfirst($item->type) }}
                                </span>
                            </td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price, 2) }}</td>
                            <td>{{ number_format($item->total, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

            <!-- FOOTER -->
            <div class="modal-footer modal-footer-modern">
                <button class="btn btn-secondary px-4" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
@endforeach

@endsection