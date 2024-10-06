@extends('setting::layouts.master')

@section('title', 'Inquiries')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Inquiries</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Inquiries</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Inquiries</li>
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
                
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>S.N</th>
                      <th>Name</th>
                      <th class="text-center">Contact</th>
                      <th class="text-center">Email</th>
                      <th class="text-center">service</th>
                      <th class="text-center">Message</th>
                      <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($contacts as $key => $value)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $value->name }}</td>
                            <td class="text-center">{{ $value->contact }} </td>
                            <td class="text-center">{{ $value->email }} </td>
                            <td class="text-center">
                                {{ $value->service_id }}
                            </td>
                            <td class="text-center">
                                {!! $value->message !!}
                            </td>
                            <td class="text-center">
                                <button id="delete" class="btn btn-danger btn-sm" onclick="
                                event.preventDefault();
                                if (confirm('Are you sure? It will delete the data permanently!')) {
                                    document.getElementById('destroy{{ $value->id }}').submit()
                                }
                                ">
                                <i class="fa fa-trash"></i>
                                <form id="destroy{{ $value->id }}" class="d-none" action="{{ route('inquires.destroy', $value->id) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                </form>
                            </button>
                            </td>
                          </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>S.N</th>
                      <th>Name</th>
                      <th class="text-center">Contact</th>
                      <th class="text-center">Email</th>
                      <th class="text-center">service</th>
                      <th class="text-center">Message</th>
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
