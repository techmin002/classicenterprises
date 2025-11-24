@extends('setting::layouts.master')

@section('title', 'Followups')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Followups</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Followups</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Followups</li>
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

                        <!-- /.card -->

                        <div class="card">
                            <div class="card-header">


                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Date & Time</th>
                                            <th class="text-center">Follow By</th>
                                            <th class="text-center">Lead Type</th>
                                            <th class="text-center">Response</th>
                                            <th class="text-center">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($leads as $key => $exp)

                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $exp->name }}</td>
                                                <td class="text-center">{{ \Carbon\Carbon::parse($exp->followups)->format('m/d/Y h:i A') }} </td>
                                                <td class="text-center">
                                                    @php
                                                        $id = $exp->created_by;
                                                        $emp = App\Models\User::where('id', $id)
                                                            ->select('name')
                                                            ->first();
                                                    @endphp
                                                    {{ $emp->name ?? 'Not Found' }}
                                                </td>
                                                <td class="text-center">{{ ucfirst($exp->lead_type) }}</td>
                                                <td class="text-center">
                                                    {{ $exp->message }}
                                                </td>

                                                <td>

                                                    <a href="{{ route('leads.show',$exp->id) }}">View Responses</a>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Date & Time</th>
                                            <th class="text-center">Follow By</th>
                                            <th class="text-center">Lead Type</th>
                                            <th class="text-center">Response</th>
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

@endsection
