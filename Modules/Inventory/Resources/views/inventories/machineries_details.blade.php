@extends('setting::layouts.master')

@section('title', 'Machinery Movements')

@section('content')
<div class="content-wrapper">

<section class="content-header">
    <div class="container-fluid d-flex justify-content-between">
        <h1 class="fw-bold text-primary">
            Movements of <span class="text-dark">{{ $machineryName }}</span>
        </h1>
    </div>
</section>

<section class="content">
<div class="container-fluid">

@if($machineryMovements->isEmpty())
    <div class="alert alert-info">No movements found.</div>
@else

<!-- SUMMARY -->
<div class="row mb-3">

<div class="col-md-3">
<div class="card bg-success text-white text-center p-3">
<h4>{{ $totalIn }}</h4>
<small>Total IN</small>
</div>
</div>

<div class="col-md-3">
<div class="card bg-danger text-white text-center p-3">
<h4>{{ $totalOut }}</h4>
<small>Total OUT</small>
</div>
</div>

<div class="col-md-3">
<div class="card bg-warning text-dark text-center p-3">
<h4>{{ $machineryMovements->where('movement_type','Used')->sum('quantity') }}</h4>
<small>Used</small>
</div>
</div>

<div class="col-md-3">
<div class="card bg-info text-white text-center p-3">
<h4>{{ $remaining }}</h4>
<small>Remaining</small>
</div>
</div>

</div>

<!-- TABLE -->
<div class="card shadow">
<div class="card-header bg-primary text-white">Movement Details</div>

<div class="card-body table-responsive">
<table class="table table-bordered text-center" id="table-movements">

<thead class="table-dark">
<tr>
<th>SN</th>
<th>Qty</th>
<th>Type</th>
<th>From</th>
<th>To</th>
<th>Date</th>
<th>Action</th>
</tr>
</thead>

<tbody>
@foreach($machineryMovements as $key => $m)

@php
$color = match($m->movement_type){
    'Purchase' => 'success',
    'Transfer Received' => 'info',
    'Sale Return' => 'primary',
    'Transfer Sent' => 'warning',
    'Sale' => 'danger',
    'Used' => 'dark',
    default => 'secondary'
};
@endphp

<tr>
<td>{{ $key+1 }}</td>

<td>
<span class="badge 
@if(in_array($m->movement_type,['Purchase','Transfer Received','Sale Return'])) bg-success
@elseif($m->movement_type=='Used') bg-warning text-dark
@else bg-danger
@endif">
{{ $m->quantity }}
</span>
</td>

<td>
<span class="badge bg-{{ $color }}">{{ $m->movement_type }}</span>
</td>

<td>{{ $m->from_branch ?? '-' }}</td>
<td>{{ $m->to_branch ?? '-' }}</td>
<td>{{ optional($m->created_at)->format('d M Y H:i') }}</td>

<td>
@if(!empty($m->route))
<a href="{{ $m->route }}" class="btn btn-sm btn-primary">
<i class="fas fa-eye"></i>
</a>
@endif
</td>

</tr>

@endforeach
</tbody>

</table>
</div>
</div>

@endif

</div>
</section>

</div>
@endsection

@push('scripts')
<script>
$('#table-movements').DataTable({
    order: [[5,'desc']]
});
</script>
@endpush