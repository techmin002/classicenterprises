@extends('setting::layouts.master')

@section('title','Sales Returns')

@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Sales Returns</li>
</ol>
@endsection

@section('content')

<div class="content-wrapper">

<section class="content-header">
<div class="container-fluid">
<div class="row mb-2">

<div class="col-sm-6">
<h1>Sales Returns</h1>
</div>

<div class="col-sm-6 text-right">
<button class="btn btn-info"
data-toggle="modal"
data-target="#saleReturnModal">
<i class="fa fa-plus"></i> Create
</button>
</div>

</div>
</div>
</section>

<section class="content">

<div class="card shadow">

<div class="card-body">

<table class="table table-bordered table-striped table-hover">

<thead class="thead-dark">
<tr>

<th class="text-center">ID</th>
<th class="text-center">Return Invoice</th>
<th class="text-center">Sale Invoice</th>
<th class="text-center">Total</th>
<th class="text-center">Action</th>

</tr>
</thead>

<tbody>

@foreach($returns as $return)

<tr>

<td class="text-center">{{ $return->id }}</td>

<td class="text-center">{{ $return->return_invoice }}</td>

<td class="text-center">{{ $return->sale->invoice_number }}</td>

<td class="text-center text-success font-weight-bold">
{{ number_format($return->total_return_amount,2) }}
</td>

<td class="text-center">

<a href="{{ route('sale-returns.show',$return->id) }}"
class="btn btn-info btn-sm">
<i class="fa fa-eye"></i>
</a>

<a href="{{ route('sale-returns.edit',$return->id) }}"
class="btn btn-warning btn-sm">
<i class="fa fa-edit"></i>
</a>

<form action="{{ route('sale-returns.destroy',$return->id) }}"
method="POST"
style="display:inline">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm"
onclick="return confirm('Are you sure?')">

<i class="fa fa-trash"></i>

</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

</section>

</div>

@include('inventory::sale_returns.create')

@endsection