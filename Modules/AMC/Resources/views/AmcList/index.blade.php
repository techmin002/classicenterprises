@extends('setting::layouts.master')

@section('title', 'AMC List')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">AMC List</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>AMC</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">AMC</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title float-right">
                                    <!-- Button to Open Modal -->
                                    @can('create_customers')
                                    <button type="button" class="btn btn-info text-white" data-toggle="modal"
                                        data-target="#createAmcModal">
                                        <i class="fa fa-plus"></i> Create
                                    </button>
                                    @endcan
                                </h3>
                                @include('amc::AmcList.create')
                            </div>
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Amc Type</th>
                                            {{-- <th class="text-center">Duration</th> --}}
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Description</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($amcs as $amc)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $amc->title }}</td>
                                                {{-- <td class="text-center">
                                                    {{ $amc->year }} Years
                                                    @if ($amc->month > 0)
                                                        {{ $amc->month }} Month
                                                    @endif
                                                </td> --}}
                                                <td class="text-center">{{ $amc->price }}</td>
                                                <td class="text-center">{{ $amc->description }}</td>
                                                <td class="text-center">
                                                    @if ($amc->status == 'on')
                                                        <a href="{{ route('amc.status', $amc->id) }}"
                                                            class="btn btn-success btn-sm">On</a>
                                                    @else
                                                        <a href="{{ route('amc.status', $amc->id) }}"
                                                            class="btn btn-danger btn-sm">Off</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    @can('edit_customers')
                                                    <button type="button" class="btn btn-primary text-white btn-sm"
                                                        data-toggle="modal" data-target="#editAmcModal{{ $amc->id }}" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    @endcan
                                                    @include('amc::AmcList.edit')
                                                        @can('delete_customers')
                                                    <form action="{{ route('amc.destroy', $amc->id) }}" method="POST"
                                                        style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Are you sure you want to delete this item?');">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                        @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Amc Type</th>
                                            {{-- <th class="text-center">Duration</th> --}}
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Description</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

@endsection
