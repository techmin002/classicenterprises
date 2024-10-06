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
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card set-card ">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-11">
                                                <h5>Employee Salary</h5>
                                            </div>
                                            <div class="col-1 text-end">
                                                @if ($salary == null)
                                                    <a href="" title="Set Salary" class="btn btn-sm btn-primary"
                                                        data-toggle="modal" data-target="#addSalary">
                                                        <i class="fa fa-plus"></i>
                                                    </a>
                                                @else
                                                    <a href="" title="Edit Salary" class="btn btn-sm btn-primary"
                                                        data-toggle="modal" data-target="#editSalary">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endif
                                                <!-- Add Salary Modal -->
                                                <div class="modal fade" id="addSalary" tabindex="-1" role="dialog"
                                                    aria-labelledby="addSalaryLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="addSalaryLabel">Salary Add
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="{{ route('employeesalary.store') }}"
                                                                method="post">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="input-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"
                                                                                id="basic-addon1">Salary
                                                                            </span>
                                                                        </div>
                                                                        <input type="number" min="1"
                                                                            class="form-control" name="salary"
                                                                            placeholder="Enter Salary here"
                                                                            aria-label="amount"
                                                                            aria-describedby="basic-addon1" required>
                                                                        <input type="hidden" name="emp_id"
                                                                            value="{{ $employee->id }}">
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Save
                                                                        changes</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Edit Salary Modal -->
                                                <div class="modal fade" id="editSalary" tabindex="-1" role="dialog"
                                                    aria-labelledby="editSalaryLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editSalaryLabel">Salary Edit
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="{{ route('employeesalary.update') }}"
                                                                method="post">
                                                                @csrf
                                                                @method('put')
                                                                <div class="modal-body">
                                                                    <div class="input-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"
                                                                                id="basic-addon1">Salary
                                                                            </span>
                                                                        </div>
                                                                        <input type="number" min="1"
                                                                            class="form-control" name="salary"
                                                                            value="{{ $salary['salary'] ?? '0' }}"
                                                                            placeholder="Enter Salary here"
                                                                            aria-label="amount"
                                                                            aria-describedby="basic-addon1" required>
                                                                        <input type="hidden" name="salary_id"
                                                                            value="{{ $salary['id'] ?? '' }}">
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Save
                                                                        changes</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="project-info d-flex text-sm">
                                            <div class="project-info-inner mr-3 col-11">
                                                <b class="m-0"> Payslip Type </b>
                                                <div class="project-amnt pt-1">Monthly Payslip</div>
                                            </div>
                                            <div class="project-info-inner mr-3 col-1">
                                                <b class="m-0"> Salary </b>
                                                <div class="project-amnt pt-1">Rs. {{ $salary->salary ?? '0' }}</div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- allowance -->
                            <div class="col-md-6">
                                <div class="card set-card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-11">
                                                <h5>Allowance</h5>
                                            </div>
                                            <div class="col-1 text-end">
                                                <a href="" title="Set Allowance" class="btn btn-sm btn-primary"
                                                    data-toggle="modal" data-target="#addAllowance">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                            </div>
                                            <!-- Add Allowance Modal -->
                                            <div class="modal fade" id="addAllowance" tabindex="-1" role="dialog"
                                                aria-labelledby="addAllowanceLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="addAllowanceLabel">Allowance Add
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('employeeallowance.store') }}"
                                                            method="post">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"
                                                                            id="basic-addon1">Title
                                                                        </span>
                                                                    </div>
                                                                    <input type="text" class="form-control"
                                                                        name="title" placeholder="Enter Title here"
                                                                        aria-label="title" aria-describedby="basic-addon1"
                                                                        required>

                                                                </div>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"
                                                                            id="basic-addon1">Type
                                                                        </span>
                                                                    </div>
                                                                    <select name="type" id=""
                                                                        class="form-control">
                                                                        <option value="" selected disabled>Select
                                                                            Type</option>
                                                                        <option value="fixed">Fixed</option>
                                                                        <option value="percentage">Percentage</option>
                                                                    </select>
                                                                </div>

                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"
                                                                            id="basic-addon1">Amount
                                                                        </span>
                                                                    </div>
                                                                    <input type="number" min="1"
                                                                        class="form-control" name="amount"
                                                                        placeholder="Enter Amount here"
                                                                        aria-label="amount"
                                                                        aria-describedby="basic-addon1" required>
                                                                    <input type="hidden" name="emp_id"
                                                                        value="{{ $employee->id }}">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Save
                                                                    changes</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" card-body table-border-style" style=" overflow:auto">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Employee Name</th>
                                                        <th>Title</th>
                                                        <th>Type</th>
                                                        <th>Amount</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($employee->allowance as $allowance)
                                                        <tr>
                                                            <td>{{ $employee->name }}
                                                            </td>

                                                            <td>{{ $allowance->title }} </td>

                                                            <td>{{ $allowance->type }}</td>
                                                            <td>{{ $allowance->amount }}</td>
                                                            <td class="d-flex">
                                                                <!-- Edit Button -->
                                                                <a href="#" data-toggle="modal"
                                                                    data-target="#editAllowance{{ $allowance->id }}"
                                                                    class="btn btn-info btn-sm rounded-circle">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                                &nbsp;
                                                                <!-- Delete Button -->
                                                                <a href="{{ route('employeeallowance.delete', $allowance->id) }}"
                                                                    onclick="return confirm('Are you sure you want to delete this?')"
                                                                    class="btn btn-danger btn-sm rounded-circle">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                            </td>

                                                            <!-- Edit Allowance Modal -->
                                                            <div class="modal fade"
                                                                id="editAllowance{{ $allowance->id }}" tabindex="-1"
                                                                role="dialog"
                                                                aria-labelledby="editAllowanceLabel{{ $allowance->id }}"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="editAllowanceLabel{{ $allowance->id }}">
                                                                                Edit Allowance
                                                                            </h5>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <form
                                                                            action="{{ route('employeeallowance.update', $allowance->id) }}"
                                                                            method="post">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <div class="modal-body">
                                                                                <div class="input-group mb-3">
                                                                                    <div class="input-group-prepend">
                                                                                        <span class="input-group-text"
                                                                                            id="basic-addon1">Title</span>
                                                                                    </div>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="title"
                                                                                        placeholder="Enter Title here"
                                                                                        value="{{ $allowance->title }}"
                                                                                        aria-label="title"
                                                                                        aria-describedby="basic-addon1"
                                                                                        required>
                                                                                </div>

                                                                                <div class="input-group mb-3">
                                                                                    <div class="input-group-prepend">
                                                                                        <span class="input-group-text"
                                                                                            id="basic-addon1">Type</span>
                                                                                    </div>
                                                                                    <select name="type"
                                                                                        class="form-control" required>
                                                                                        <option value="" disabled>
                                                                                            Select Type</option>
                                                                                        <option value="fixed"
                                                                                            {{ $allowance->type == 'fixed' ? 'selected' : '' }}>
                                                                                            Fixed</option>
                                                                                        <option value="percentage"
                                                                                            {{ $allowance->type == 'percentage' ? 'selected' : '' }}>
                                                                                            Percentage</option>
                                                                                    </select>
                                                                                </div>

                                                                                <div class="input-group mb-3">
                                                                                    <div class="input-group-prepend">
                                                                                        <span class="input-group-text"
                                                                                            id="basic-addon1">Amount</span>
                                                                                    </div>
                                                                                    <input type="number" min="1"
                                                                                        class="form-control"
                                                                                        name="amount"
                                                                                        value="{{ $allowance->amount }}"
                                                                                        placeholder="Enter Amount here"
                                                                                        aria-label="amount"
                                                                                        aria-describedby="basic-addon1"
                                                                                        required>
                                                                                    <input type="hidden" name="emp_id"
                                                                                        value="{{ $employee->id }}">
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-dismiss="modal">Close</button>
                                                                                <button type="submit"
                                                                                    class="btn btn-primary">Save
                                                                                    changes</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Commission/ Insentive -->
                            <div class="col-md-6">
                                <div class="card set-card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-11">
                                                <h5>Sales Insentive</h5>
                                            </div>
                                            <div class="col-1 text-end">
                                                <a data-toggle="modal" data-target="#addInsentive" title=""
                                                    class="btn btn-sm btn-primary" data-bs-original-title="Create">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                                <div class="modal fade" id="addInsentive" tabindex="-1" role="dialog"
                                                    aria-labelledby="addInsentiveLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="addInsentiveLabel">Insentive
                                                                    Add
                                                                </h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="{{ route('employeeinsentive.store') }}"
                                                                method="post">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="input-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"
                                                                                id="basic-addon1">Title
                                                                            </span>
                                                                        </div>
                                                                        <input type="text" class="form-control"
                                                                            name="title" placeholder="Enter Title here"
                                                                            aria-label="title"
                                                                            aria-describedby="basic-addon1" required>

                                                                    </div>
                                                                    <div class="input-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"
                                                                                id="basic-addon1">Sales Amount
                                                                            </span>
                                                                        </div>
                                                                        <input type="number" name="sale_amount"
                                                                            class="form-control" id="">
                                                                    </div>

                                                                    <div class="input-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"
                                                                                id="basic-addon1">Insentive Amount
                                                                            </span>
                                                                        </div>
                                                                        <input type="number" min="1"
                                                                            class="form-control" name="insentive"
                                                                            placeholder="Enter insentive here"
                                                                            aria-label="inentive"
                                                                            aria-describedby="basic-addon1" required>
                                                                        <input type="hidden" name="emp_id"
                                                                            value="{{ $employee->id }}">
                                                                    </div>
                                                                    <div class="input-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"
                                                                                id="basic-addon1">Date
                                                                            </span>
                                                                        </div>
                                                                        <input type="date" min="1"
                                                                            class="form-control" name="date"
                                                                            placeholder="Enter date here"
                                                                            aria-label="date"
                                                                            aria-describedby="basic-addon1" required>

                                                                    </div>
                                                                    <div class="input-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"
                                                                                id="basic-addon1">Description
                                                                            </span>
                                                                        </div>
                                                                        <textarea name="description" class="form-control" id="" cols="30" rows="2"></textarea>

                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Save
                                                                        changes</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" card-body table-border-style" style=" overflow:auto">

                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>

                                                    <tr>
                                                        <th>Employee Name</th>
                                                        <th>Title</th>
                                                        <th>Insentive</th>
                                                        <th>Sale Amount</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($employee->insentive as $insentive)
                                                        <tr>
                                                            <td>{{ $employee->name }}
                                                            </td>
                                                            <td>{{ $insentive->title }}</td>

                                                            <td>{{ $insentive->insentive_amount }}</td>
                                                            <td>{{ $insentive->sale_amount }}
                                                            </td>

                                                            <td class="Action">
                                                                <a href="" data-toggle="modal"
                                                                    data-target="#editInsentive{{ $insentive->id }}"
                                                                    class="btn btn-info btn-sm rounded-circle"><i
                                                                        class="fa fa-edit"></i></a>
                                                                <a href="{{ route('employeeinsentive.delete', $insentive->id) }}"
                                                                    onclick="return confirm('Are you sure you want to delete this?')"
                                                                    class="btn btn-danger btn-sm rounded-circle"><i
                                                                        class="fa fa-trash"></i></a>
                                                            </td>
                                                            <div class="modal fade"
                                                                id="editInsentive{{ $insentive->id }}" tabindex="-1"
                                                                role="dialog" aria-labelledby="editInsentiveLabel"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="editInsentiveLabel">Insentive Edit
                                                                            </h5>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <form
                                                                            action="{{ route('employeeinsentive.update', $insentive->id) }}"
                                                                            method="post">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <div class="modal-body">
                                                                                <div class="input-group mb-3">
                                                                                    <div class="input-group-prepend">
                                                                                        <span class="input-group-text"
                                                                                            id="basic-addon1">Title
                                                                                        </span>
                                                                                    </div>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="title"
                                                                                        value="{{ $insentive->title }}"
                                                                                        placeholder="Enter Title here"
                                                                                        aria-label="title"
                                                                                        aria-describedby="basic-addon1"
                                                                                        required>

                                                                                </div>
                                                                                <div class="input-group mb-3">
                                                                                    <div class="input-group-prepend">
                                                                                        <span class="input-group-text"
                                                                                            id="basic-addon1">Sales Amount
                                                                                        </span>
                                                                                    </div>
                                                                                    <input type="number"
                                                                                        value="{{ $insentive->sale_amount }}"
                                                                                        name="sale_amount"
                                                                                        class="form-control"
                                                                                        id="">
                                                                                </div>

                                                                                <div class="input-group mb-3">
                                                                                    <div class="input-group-prepend">
                                                                                        <span class="input-group-text"
                                                                                            id="basic-addon1">Insentive
                                                                                            Amount
                                                                                        </span>
                                                                                    </div>
                                                                                    <input type="number" min="1"
                                                                                        class="form-control"
                                                                                        value="{{ $insentive->insentive_amount }}"
                                                                                        name="insentive"
                                                                                        placeholder="Enter insentive here"
                                                                                        aria-label="inentive"
                                                                                        aria-describedby="basic-addon1"
                                                                                        required>
                                                                                    <input type="hidden" name="emp_id"
                                                                                        value="{{ $employee->id }}">
                                                                                </div>
                                                                                <div class="input-group mb-3">
                                                                                    <div class="input-group-prepend">
                                                                                        <span class="input-group-text"
                                                                                            id="basic-addon1">Date
                                                                                        </span>
                                                                                    </div>
                                                                                    <input type="date" min="1"
                                                                                        class="form-control"
                                                                                        name="date"
                                                                                        placeholder="Enter date here"
                                                                                        aria-label="date"
                                                                                        aria-describedby="basic-addon1"
                                                                                        value="{{ $insentive->date }}"
                                                                                        required>

                                                                                </div>
                                                                                <div class="input-group mb-3">
                                                                                    <div class="input-group-prepend">
                                                                                        <span class="input-group-text"
                                                                                            id="basic-addon1">Description
                                                                                        </span>
                                                                                    </div>
                                                                                    <textarea name="description" class="form-control" id="" cols="30" rows="2">{{ $insentive->description }}</textarea>

                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-dismiss="modal">Close</button>
                                                                                <button type="submit"
                                                                                    class="btn btn-primary">Save
                                                                                    changes</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Advanced Pay-->
                            <div class="col-md-6">
                                <div class="card set-card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-11">
                                                <h5>Advanced Pay</h5>
                                            </div>
                                            <div class="col-1 text-end">
                                                <a data-toggle="modal" data-target="#addAdvancedPay" title=""
                                                    class="btn btn-sm btn-primary" data-bs-original-title="Create">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                                <div class="modal fade" id="addAdvancedPay" tabindex="-1"
                                                    role="dialog" aria-labelledby="addAdvancedPayLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="addAdvancedPayLabel">Advanced
                                                                    Pay Add
                                                                </h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="{{ route('employeeadvancedpay.store') }}"
                                                                method="post">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="input-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"
                                                                                id="basic-addon1">Title
                                                                            </span>
                                                                        </div>
                                                                        <input type="text" class="form-control"
                                                                            name="title" placeholder="Enter Title here"
                                                                            aria-label="title"
                                                                            aria-describedby="basic-addon1" required>

                                                                    </div>
                                                                    <div class="input-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"
                                                                                id="basic-addon1">Amount
                                                                            </span>
                                                                        </div>
                                                                        <input type="number" name="amount"
                                                                            class="form-control" id="">
                                                                    </div>

                                                                    <input type="hidden" name="emp_id"
                                                                        value="{{ $employee->id }}">
                                                                    <div class="input-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"
                                                                                id="basic-addon1">Date
                                                                            </span>
                                                                        </div>
                                                                        <input type="date" min="1"
                                                                            class="form-control" name="date"
                                                                            placeholder="Enter date here"
                                                                            aria-label="date"
                                                                            aria-describedby="basic-addon1" required>

                                                                    </div>
                                                                    <div class="input-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"
                                                                                id="basic-addon1">Reason
                                                                            </span>
                                                                        </div>
                                                                        <textarea name="reason" class="form-control" id="" cols="30" rows="2"></textarea>

                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Save
                                                                        changes</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class=" card-body table-border-style" style=" overflow:auto">

                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Employee</th>
                                                        <th>Title</th>
                                                        <th>Amount</th>
                                                        <th>Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($employee->advancePay as $advance)
                                                        <tr>
                                                            <td>{{ $employee->name }}</td>
                                                            <td>{{ $advance->title }}</td>
                                                            <td>{{ $advance->amount }}</td>
                                                            <td>{{ $advance->date }}</td>
                                                            <td>
                                                                <a class="btn btn-info btn-sm rounded-circle"
                                                                    data-toggle="modal"
                                                                    data-target="#editAdvancedPay{{ $advance->id }}"><i
                                                                        class="fa fa-edit"></i></a>
                                                                <a href="{{ route('employeeadvancedpay.delete', $advance->id) }}"
                                                                    onclick="return confirm('Are you sure you want to delete ?')"
                                                                    class="btn btn-danger btn-sm rounded-circle"><i
                                                                        class="fa fa-trash"></i></a>
                                                                {{-- edit advance pay --}}
                                                                <div class="modal fade"
                                                                    id="editAdvancedPay{{ $advance->id }}"
                                                                    tabindex="-1" role="dialog"
                                                                    aria-labelledby="editAdvancedPayLabel"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title"
                                                                                    id="editAdvancedPayLabel">Advance Pay
                                                                                    Edit
                                                                                </h5>
                                                                                <button type="button" class="close"
                                                                                    data-dismiss="modal"
                                                                                    aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <form
                                                                                action="{{ route('employeeadvancedpay.update', $advance->id) }}"
                                                                                method="post">
                                                                                @csrf
                                                                                @method('PUT')
                                                                                <div class="modal-body">
                                                                                    <div class="input-group mb-3">
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text"
                                                                                                id="basic-addon1">Title
                                                                                            </span>
                                                                                        </div>
                                                                                        <input type="text"
                                                                                            class="form-control"
                                                                                            name="title"
                                                                                            value="{{ $advance->title }}"
                                                                                            placeholder="Enter Title here"
                                                                                            aria-label="title"
                                                                                            aria-describedby="basic-addon1"
                                                                                            required>

                                                                                    </div>
                                                                                    <div class="input-group mb-3">
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text"
                                                                                                id="basic-addon1">Amount
                                                                                            </span>
                                                                                        </div>
                                                                                        <input type="number"
                                                                                            value="{{ $advance->amount }}"
                                                                                            name="amount"
                                                                                            class="form-control"
                                                                                            id="">
                                                                                    </div>
                                                                                    <div class="input-group mb-3">
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text"
                                                                                                id="basic-addon1">Date
                                                                                            </span>
                                                                                        </div>
                                                                                        <input type="date"
                                                                                            min="1"
                                                                                            class="form-control"
                                                                                            name="date"
                                                                                            placeholder="Enter date here"
                                                                                            aria-label="date"
                                                                                            aria-describedby="basic-addon1"
                                                                                            value="{{ $advance->date }}"
                                                                                            required>

                                                                                    </div>
                                                                                    <div class="input-group mb-3">
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text"
                                                                                                id="basic-addon1">Reason
                                                                                            </span>
                                                                                        </div>
                                                                                        <textarea name="reason" class="form-control" id="" cols="30" rows="2">{{ $insentive->description }}</textarea>

                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button"
                                                                                        class="btn btn-secondary"
                                                                                        data-dismiss="modal">Close</button>
                                                                                    <button type="submit"
                                                                                        class="btn btn-primary">Save
                                                                                        changes</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Service Maintainance-->
                            <div class="col-md-6">
                                <div class="card set-card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-11">
                                                <h5>Service Maintainance</h5>
                                            </div>
                                            <div class="col-1 text-end">
                                                <a data-toggle="modal" data-target="#addService" title=""
                                                    class="btn btn-sm btn-primary" data-bs-original-title="Create">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                                <div class="modal fade" id="addService" tabindex="-1" role="dialog"
                                                    aria-labelledby="addserviceLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="addserviceLabel">Service
                                                                    Maintainance
                                                                </h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="{{ route('employeeservice.store') }}"
                                                                method="post">
                                                                @csrf
                                                                <div class="modal-body">

                                                                    <div class="input-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"
                                                                                id="basic-addon1">Title
                                                                            </span>
                                                                        </div>
                                                                        <input type="text" name="title"
                                                                            class="form-control" id="" placeholder="Enter Product Name/ Customer Name">
                                                                    </div>
                                                                    <div class="input-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"
                                                                                id="basic-addon1">Amount
                                                                            </span>
                                                                        </div>
                                                                        <input type="number" name="amount"
                                                                            class="form-control" id="" placeholder="Service Incentive">
                                                                    </div>

                                                                    <input type="hidden" name="emp_id"
                                                                        value="{{ $employee->id }}">
                                                                    <div class="input-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"
                                                                                id="basic-addon1">Date
                                                                            </span>
                                                                        </div>
                                                                        <input type="date" min="1"
                                                                            class="form-control" name="date"
                                                                            placeholder="Enter date here"
                                                                            aria-label="date"
                                                                            aria-describedby="basic-addon1" required>

                                                                    </div>
                                                                    <div class="input-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"
                                                                                id="basic-addon1">Description
                                                                            </span>
                                                                        </div>
                                                                        <textarea name="description" id="" class="form-control" rows="3"></textarea>

                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Save
                                                                        changes</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" card-body table-border-style" style=" overflow:auto">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Employee Name</th>
                                                        <th>Title</th>
                                                        <th>Amount</th>
                                                        <th>Month</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($employee->service as $service)
                                                        <tr>
                                                            <td>{{ $employee->name }}
                                                            </td>
                                                            <td>{{ $service->title }}</td>
                                                            <td>{{ $service->amount }}
                                                            </td>
                                                            <td>{{ \Carbon\Carbon::parse($service->date)->format('d-M-Y') }}

                                                            </td>

                                                            <td class="Action">
                                                                <a class="btn btn-info btn-sm rounded-circle"
                                                                    data-toggle="modal"
                                                                    data-target="#editservice{{ $service->id }}"><i
                                                                        class="fa fa-edit"></i></a>
                                                                <a href="{{ route('employeeservice.delete', $service->id) }}"
                                                                    onclick="return confirm('Are you sure you want to delete ?')"
                                                                    class="btn btn-danger btn-sm rounded-circle"><i
                                                                        class="fa fa-trash"></i></a>

                                                                <div class="modal fade" id="editservice{{ $service->id }}" tabindex="-1"
                                                                    role="dialog" aria-labelledby="editserviceLabel"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="editserviceLabel">
                                                                                    Employee Services
                                                                                </h5>
                                                                                <button type="button" class="close"
                                                                                    data-dismiss="modal"
                                                                                    aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <form
                                                                                action="{{ route('employeeservice.update',$service->id) }}"
                                                                                method="post">
                                                                                @csrf
                                                                                @method('put')
                                                                                <div class="modal-body">

                                                                                    <div class="input-group mb-3">
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text"
                                                                                                id="basic-addon1">Title
                                                                                            </span>
                                                                                        </div>
                                                                                        <input type="text" name="title"
                                                                                            class="form-control" id="" value="{{ $service->title }}" placeholder="Enter Product Name/ Customer Name">
                                                                                    </div>
                                                                                    <div class="input-group mb-3">
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text"
                                                                                                id="basic-addon1">Amount
                                                                                            </span>
                                                                                        </div>
                                                                                        <input type="number" name="amount"
                                                                                            class="form-control" id="" value="{{ $service->amount }}" placeholder="Service Incentive">
                                                                                    </div>
                
                                                                                    
                                                                                    <div class="input-group mb-3">
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text"
                                                                                                id="basic-addon1">Date
                                                                                            </span>
                                                                                        </div>
                                                                                        <input type="date" min="1"
                                                                                            class="form-control" name="date"
                                                                                            placeholder="Enter date here"
                                                                                            aria-label="date"
                                                                                            aria-describedby="basic-addon1" value="{{ $service->date }}" required>
                
                                                                                    </div>
                                                                                    <div class="input-group mb-3">
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text"
                                                                                                id="basic-addon1">Description
                                                                                            </span>
                                                                                        </div>
                                                                                        <textarea name="description" id="" class="form-control" rows="3">{{ $service->title }}</textarea>
                
                                                                                    </div>

                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button"
                                                                                        class="btn btn-secondary"
                                                                                        data-dismiss="modal">Close</button>
                                                                                    <button type="submit"
                                                                                        class="btn btn-primary">Save
                                                                                        changes</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Classic Fund -->
                            <div class="col-md-6">
                                <div class="card set-card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-11">
                                                <h5>Classic Fund</h5>
                                            </div>
                                            <div class="col-1 text-end">
                                                <a data-toggle="modal" data-target="#addFund" title=""
                                                    class="btn btn-sm btn-primary" data-bs-original-title="Create">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                                <div class="modal fade" id="addFund" tabindex="-1" role="dialog"
                                                    aria-labelledby="addFundLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="addFundLabel">Classic
                                                                    Funds
                                                                </h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="{{ route('employeefund.store') }}"
                                                                method="post">
                                                                @csrf
                                                                <div class="modal-body">

                                                                    <div class="input-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"
                                                                                id="basic-addon1">Amount
                                                                            </span>
                                                                        </div>
                                                                        <input type="number" name="amount"
                                                                            class="form-control" id="">
                                                                    </div>

                                                                    <input type="hidden" name="emp_id"
                                                                        value="{{ $employee->id }}">
                                                                    <div class="input-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"
                                                                                id="basic-addon1">Date
                                                                            </span>
                                                                        </div>
                                                                        <input type="month" min="1"
                                                                            class="form-control" name="date"
                                                                            placeholder="Enter date here"
                                                                            aria-label="date"
                                                                            aria-describedby="basic-addon1" required>

                                                                    </div>

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Save
                                                                        changes</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" card-body table-border-style" style=" overflow:auto">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Employee Name</th>
                                                        <th>Amount</th>
                                                        <th>Month</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($employee->fund as $fund)
                                                        <tr>
                                                            <td>{{ $employee->name }}
                                                            </td>
                                                            <td>{{ $fund->amount }}
                                                            </td>
                                                            <td>{{ \Carbon\Carbon::parse($fund->month)->format('M-Y') }}

                                                            </td>

                                                            <td class="Action">
                                                                <a class="btn btn-info btn-sm rounded-circle"
                                                                    data-toggle="modal"
                                                                    data-target="#editFund{{ $fund->id }}"><i
                                                                        class="fa fa-edit"></i></a>
                                                                <a href="{{ route('employeefund.delete', $fund->id) }}"
                                                                    onclick="return confirm('Are you sure you want to delete ?')"
                                                                    class="btn btn-danger btn-sm rounded-circle"><i
                                                                        class="fa fa-trash"></i></a>

                                                                <div class="modal fade" id="editFund{{ $fund->id }}" tabindex="-1"
                                                                    role="dialog" aria-labelledby="editFundLabel"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="editFundLabel">
                                                                                    Classic
                                                                                    Funds
                                                                                </h5>
                                                                                <button type="button" class="close"
                                                                                    data-dismiss="modal"
                                                                                    aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <form
                                                                                action="{{ route('employeefund.update',$fund->id) }}"
                                                                                method="post">
                                                                                @csrf
                                                                                @method('put')
                                                                                <div class="modal-body">

                                                                                    <div class="input-group mb-3">
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text"
                                                                                                id="basic-addon1">Amount
                                                                                            </span>
                                                                                        </div>
                                                                                        <input type="number"
                                                                                            name="amount"
                                                                                            value="{{ $fund->amount }}"
                                                                                            class="form-control"
                                                                                            id="">
                                                                                    </div>

                                                                                    
                                                                                    <div class="input-group mb-3">
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text"
                                                                                                id="basic-addon1">Date
                                                                                            </span>
                                                                                        </div>
                                                                                        <input type="month"
                                                                                            min="1"
                                                                                            class="form-control"
                                                                                            name="date"
                                                                                            value="{{ $fund->month }}"
                                                                                            placeholder="Enter date here"
                                                                                            aria-label="date"
                                                                                            aria-describedby="basic-addon1"
                                                                                            required>

                                                                                    </div>

                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button"
                                                                                        class="btn btn-secondary"
                                                                                        data-dismiss="modal">Close</button>
                                                                                    <button type="submit"
                                                                                        class="btn btn-primary">Save
                                                                                        changes</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
