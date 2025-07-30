@extends('setting::layouts.master')

@section('title', 'AMC Details')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('amc.index') }}">AMC List</a></li>
        <li class="breadcrumb-item active">AMC Details</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h1>Accessories Details</h1>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h4>Title: {{ ucfirst($amc->title) }}</h4>
                        <a href="{{ route('amc.index') }}" class="btn btn-sm btn-secondary float-right">Back</a>
                    </div>
                    <div class="card-body">
                        @if ($amc->accessories && $amc->accessories->count() > 0)
                            <table id="example1" class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>S.N</th>
                                        <th>Accessory Name</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($amc->accessories as $index => $accessory)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $accessory->accessory->name ?? 'N/A' }}</td>
                                            <td>{{ $accessory->quantity }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>No accessories assigned.</p>
                        @endif
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection
