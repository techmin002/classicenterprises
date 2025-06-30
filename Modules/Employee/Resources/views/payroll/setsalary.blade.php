@extends('setting::layouts.master')

@section('title', 'Users')

@section('third_party_stylesheets')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection


@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="dash-content">

                    <div class="page-header">
                        <div class="page-block">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="page-header-title">
                                        <h4 class="m-b-10">
                                            Manage Employee Salary
                                        </h4>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                        <li class="breadcrumb-item">Employee Salary</li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                @can('create_payroll')
                                <h3 class="card-title float-right"><a class="btn btn-info text-white"
                                        href="{{ route('users.create') }}"><i class="fa fa-plus"></i> Create</a> </h3>
                                        @endcan
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Employee ID</th>
                                            <th>Name</th>
                                            <th class="text-center">Image</th>
                                            <th>Branch</th>
                                            <th>Salary</th>
                                            <th>Net Salary</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($employees as $key => $value)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('employee.details', $value->id) }}"
                                                        class="btn btn-outline-primary">EMP0000{{ $value->id }}</a>

                                                </td>
                                                <td>{{ $value->name }}</td>
                                                <td class="text-center">
                                                    @if ($value->user && $value->user->image)
                                                        <img src="{{ asset('upload/images/users/' . $value->user->image) }}"
                                                            width="60px" alt="{{ $value->name }}">
                                                    @else
                                                        <img src="{{ asset('upload/images/users/profile.webp') }}"
                                                            width="60px" alt="{{ $value->name }}">
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                        $branch = null;
                                                        if ($value->user) {
                                                            $branch = Modules\Branch\Entities\Branch::where(
                                                                'id',
                                                                $value->user->branch_id,
                                                            )
                                                                ->select('name')
                                                                ->first();
                                                        }
                                                    @endphp

                                                    {{ $branch->name ?? 'N/A' }}
                                                </td>

                                                {{-- <td>
                                                    @php($branch = Modules\Branch\Entities\Branch::where('id', $value->user->branch_id)->select('name')->first())
                                                    {{ $branch->name ?? 'N/A' }}
                                                </td> --}}
                                                @php($salary = Modules\Employee\Entities\EmployeeSalary::where('employee_id', $value->id)->first())
                                                <td>{{ $salary->salary ?? 'N/A' }}</td>
                                                <td>{{ $salary->salary ?? 'N/A' }}</td>

                                                <td class="text-center">
                                                    @can('edit_payroll')
                                                    <a href="{{ route('employee.details', $value->id) }}"
                                                        class="btn btn-primary"><i class="fa fa-eye"></i></a>
                                                        @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Employee ID</th>
                                            <th>Name</th>
                                            <th class="text-center">Image</th>
                                            <th>Branch</th>
                                            <th>Salary</th>
                                            <th>Net Salary</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
