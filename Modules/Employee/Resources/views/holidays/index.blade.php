@extends('setting::layouts.master')

@section('title', 'Holidays')

@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Holidays</li>
</ol>
@endsection

@section('content')
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Holidays</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title float-right">
                        <a class="btn btn-info text-white" data-toggle="modal" data-target="#createHoliday">
                            <i class="fa fa-plus"></i> Create
                        </a>
                    </h3>

                    @include('employee::holidays.create')
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">S.N</th>
                                <th class="text-center">Title</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($holidays as $holiday)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $holiday->title }}</td>
                                <td class="text-center">{{ $holiday->date }}</td>

                                <td class="text-center">

                                    <!-- View -->
                                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#viewHoliday{{ $holiday->id }}">
                                        <i class="fa fa-eye"></i>
                                    </button>

                                    <!-- Edit -->
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editHoliday{{ $holiday->id }}">
                                        <i class="fa fa-edit"></i>
                                    </button>

                                    <!-- Delete -->
                                    <button class="btn btn-danger btn-sm"
                                        onclick="event.preventDefault(); if(confirm('Are you sure?')) document.getElementById('delete{{ $holiday->id }}').submit();">
                                        <i class="fa fa-trash"></i>
                                    </button>

                                    <form id="delete{{ $holiday->id }}" method="POST"
                                        action="{{ route('holidays.destroy', $holiday->id) }}" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>

                                    @include('employee::holidays.view')
                                    @include('employee::holidays.edit')

                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>

        </div>
    </section>
</div>
@endsection