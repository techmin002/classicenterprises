@extends('setting::layouts.master')

@section('title', 'Expenses')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Expenses</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Expenses</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Expenses</li>
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
                  <h3 class="card-title float-right"><a class="btn btn-info text-white" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-plus"></i> Create</a> </h3>
                  @include('expenses::expenses.create')
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th class="text-center">S.N</th>
                      <th class="text-center">Title</th>
                      <th class="text-center">Amount</th>
                      <th class="text-center">Date</th>
                      <th class="text-center">Mode</th>
                      <th class="text-center">Vendor</th>
                      <th class="text-center">Status</th>
                      
                    </tr>
                    </thead>
                    <tbody>
                      @foreach ($expenses as $key => $exp)
                      <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $exp->title }}</td>
                        <td class="text-center">{{ $exp->amount }}</td>
                        <td class="text-center">{{ $exp->date }}</td>
                        <td class="text-center">{{ $exp->mode }}</td>
                        <td class="text-center">{{ $exp->vendor }}</td>
                        <td class="text-center">
                          <a href=""><i class="fa fa-edit"></i></a>
                          <a href=""><i class="fa fa-trash"></i></a>
                        </td>
                      </tr>
                      @endforeach
                      
                    </tbody>
                    <tfoot>
                    <tr>
                      <th class="text-center">S.N</th>
                      <th class="text-center">Title</th>
                      <th class="text-center">Amount</th>
                      <th class="text-center">Date</th>
                      <th class="text-center">Mode</th>
                      <th class="text-center">Vednor</th>
                      <th class="text-center">Status</th>
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
