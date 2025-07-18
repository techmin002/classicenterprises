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
                                    <a class="btn btn-info text-white" href="{{ route('amc.create') }}">
                                        <i class="fa fa-plus"></i> Create
                                    </a>
                                </h3>
                            </div>
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Title</th>
                                            <th class="text-center">Duration</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Image</th>
                                            <th class="text-center">Description</th>
                                            <th class="text-center">Details</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($amcs as $amc)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $amc->title }}</td>
                                                <td class="text-center">{{ $amc->year }}. {{ $amc->month }} year</td>
                                                <td class="text-center">{{ $amc->price }}</td>
                                                <td class="text-center">
                                                    @if ($amc->image)
                                                        <img src="{{ asset('upload/images/amc/' . $amc->image) }}"
                                                            alt="AMC Image" class="img-thumbnail" style="max-width: 70px;">
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ $amc->description }}</td>
                                                <td class="text-center"><a href="{{ route('amc.show', $amc->id) }}"
                                                        class="btn btn-info btn-sm" title="Details">
                                                        <i class="fa fa-eye"></i>
                                                    </a></td>
                                                <td class="text-center">
                                                    @if ($amc->status == 'on')
                                                        <a href="{{ route('amc.status', $amc->id) }}"
                                                            class="btn btn-success btn-sm">On</a>
                                                    @else
                                                        <a href="{{ route('amc.status', $amc->id) }}"
                                                            class="btn btn-danger btn-sm">Off</a>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('amc.edit', $amc->id) }}"
                                                        class="btn btn-primary btn-sm" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('amc.destroy', $amc->id) }}" method="POST"
                                                        style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Are you sure you want to delete this item?');">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Title</th>
                                            <th class="text-center">Duration</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Image</th>
                                            <th class="text-center">Description</th>
                                            <th class="text-center">Details</th>
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
