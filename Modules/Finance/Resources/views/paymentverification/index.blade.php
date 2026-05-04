@extends('setting::layouts.master')

@section('title', 'Payment Verification')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Payment Verification</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6"><h1>Payment Verification</h1></div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Payment Verification</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row"><div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">S.N</th>
                                        <th class="text-center">Customer Name</th>
                                        <th class="text-center">Branch Name</th>
                                        <th class="text-center">Lead Name</th>
                                        <th class="text-center">Method</th>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Message</th>
                                        <th class="text-center">Total Amount</th>
                                        <th class="text-center">Paid Amount</th>
                                        <th class="text-center">Remaining Amount</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                              <tbody>
@forelse($data as $value)
    <tr>
        <td class="text-center">{{ $loop->iteration }}</td>

        {{-- Customer --}}
        <td class="text-center">
            {{ $value->customer_name }}
        </td>

        {{-- Branch --}}
        <td class="text-center">
            {{ optional($value->branch)->name ?? '-' }}
        </td>

        {{-- Lead --}}
        <td class="text-center">
            {{ $value->lead_name }}
        </td>

        {{-- Method --}}
        <td class="text-center">
           <span class="badge badge-info">
        {{ ucfirst($value->method ?? 'N/A') }}
    </span>
        </td>

        {{-- Date --}}
        <td class="text-center">
            {{ $value->created_at ? $value->created_at->format('d M Y, h:i A') : '-' }}
        </td>

        {{-- Message --}}
        <td class="text-center">
            {{ $value->message ?? '-' }}
        </td>

        {{-- Amounts --}}
        <td class="text-center text-primary font-weight-bold">
            ₹{{ number_format($value->total_amount ?? 0) }}
        </td>

        <td class="text-center text-success font-weight-bold">
            ₹{{ number_format($value->paid_amount ?? 0) }}
        </td>

        <td class="text-center text-danger font-weight-bold">
            ₹{{ number_format($value->remaining_amount ?? 0) }}
        </td>

        {{-- Status --}}
        <td class="text-center">
            @if ($value->status === 'on')
                <button type="button"
                        class="btn btn-primary btn-sm"
                        data-toggle="modal"
                        data-target="#verifyModal{{ $value->id }}">
                    Verify Amount
                </button>
            @else
                <span class="badge badge-success p-2">
                    Verified
                </span>
            @endif
        </td>
    </tr>
@empty
    <tr>
        <td colspan="11" class="text-center text-muted">
            No collections available.
        </td>
    </tr>
@endforelse
</tbody>
                            </table>
                        </div>
                    </div>
                </div></div>
            </div>
        </section>
    </div>

    {{-- Modal Include --}}
    @foreach($data as $value)
        @if ($value->status === 'on')
            @include('finance::paymentverification.verifyamount', ['value' => $value])
        @endif
    @endforeach
@endsection
