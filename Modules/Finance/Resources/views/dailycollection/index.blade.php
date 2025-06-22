@extends('setting::layouts.master')

@section('title', 'Daily Collection')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active"> Daily Collection </li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1> Daily Collection </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active"> Daily Collection</li>
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
                                <form action="{{ route('deposite.history.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group d-flex">
                                                <label class="form-label mt-2">Opening Balance:</label>
                                                <input type="number" class="form-control w-50" name="amount"
                                                    value="{{ $balance->amount ?? 0 }}" style="margin-left: 2%" readonly>
                                            </div>
                                            <a href="{{ route('deposite.history') }}" class="btn btn-sm btn-info">
                                                Deposited History <i class="fa fa-eye"></i>
                                            </a>


                                        </div>
                                        <div class="col-md-3">
                                            <input type="file" name="image" class="form-control" required>
                                        </div>
                                        <div class="col-md-3">
                                            <select name="bank" id="" class="form-control w-75">
                                                <option value="" selected disabled>Select Bank</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-sm btn-success" type="submit">Save Change</button>
                                            <a href="{{ route('all-collection') }}"
                                                class="btn btn-sm btn-info mt-4">All Collections <i class="fa fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                </form>

                            </div>
                            <!-- /.card-header -->
                            <form action="{{ route('closing.amount.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="amount" value="{{ $grandTotal }}">
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">S.N</th>
                                                <th class="text-center">Name</th>
                                                <th class="text-center">Method</th>
                                                <th class="text-center">Date</th>
                                                <th class="text-center">Message</th>
                                                <th class="text-center">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!$alreadyClosed)
                                                @forelse($collections as $item)
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        <td class="text-center">{{ $item->name }}</td>
                                                        <td class="text-center">{{ $item->payment_method }}</td>
                                                        <td class="text-center">{{ $item->created_at }}</td>
                                                        <td class="text-center">{{ $item->message }}</td>
                                                        <td class="text-center">₹{{ $item->amount }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center">No collections today.</td>
                                                    </tr>
                                                @endforelse
                                            @endif
                                        </tbody>

                                        <tfoot>
                                            <tr>
                                                <th class="text-center" colspan="5">Total</th>
                                                <th class="text-center">
                                                    ₹{{ $alreadyClosed ? '0.00' : number_format($grandTotal, 2) }} /-
                                                </th>
                                            </tr>
                                        </tfoot>

                                    </table>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    @if (!$alreadyClosed)
                                        <button class="btn btn-info btn-sm" type="submit">Closing Amount</button>
                                    @endif
                                </div>
                            </form>

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
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@endsection
