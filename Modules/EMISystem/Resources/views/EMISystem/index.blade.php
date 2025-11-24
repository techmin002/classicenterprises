@extends('setting::layouts.master')

@section('title', 'EMI Plans')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">EMI Plans</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>EMI Plans Management</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">EMI Plans</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title float-right">
                                    <a class="btn btn-info text-white" data-toggle="modal"
                                        data-target="#emiPlanCreateModal">
                                        <i class="fa fa-plus"></i> Create New Plan
                                    </a>
                                </h3>
                                @include('emisystem::EMISystem.create')
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                <table id="emiPlansTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">ID</th>
                                            <th class="text-center">Title</th>
                                            <th class="text-center">Duration (Months)</th>
                                            <th class="text-center">Interest Rate</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($emiPlan as $plan)
                                            <tr>
                                                <td class="text-center">{{ $plan->id }}</td>
                                                <td class="text-center">{{ $plan->title }}</td>
                                                <td class="text-center">{{ $plan->duration }}</td>
                                                <td class="text-center">{{ $plan->interest_rate }}%</td>
                                                <td class="text-center">
                                                    @if ($plan->status == 1)
                                                        <span class="badge badge-success">Active</span>
                                                    @else
                                                        <span class="badge badge-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ Route('emi.system.edit', $plan->id) }}"
                                                        class="btn btn-sm btn-success"><i class="fa fa-edit"></i></a>
                                                    <form action="{{ route('emi.system.destroy', $plan->id) }}"
                                                        method="POST" style="display:inline-block;"
                                                        onsubmit="return confirm('Are you sure you want to delete this EMI Plan?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"><i
                                                                class="fa fa-trash"></i></button>
                                                    </form>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">ID</th>
                                            <th class="text-center">Title</th>
                                            <th class="text-center">Duration (Months)</th>
                                            <th class="text-center">Interest Rate</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

    <script>
        $(function() {
            // Initialize DataTable
            $('#emiPlansTable').DataTable({
                "responsive": true,
                "autoWidth": false,
            });

            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection
