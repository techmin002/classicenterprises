@extends('setting::layouts.master')

@section('title', 'Assign AMC')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Assign AMC</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Assign AMC</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Assign AMC</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <ul class="nav nav-pills mb-3 d-flex gap-4" id="pills-tab" role="tablist">
                    <li class="nav-item me-2" role="presentation">
                        <button class="nav-link active" id="pills-registeruser-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-registeruser" type="button" role="tab"
                            aria-controls="pills-registeruser" aria-selected="true">Register User</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-outsideruser-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-outsideruser" type="button" role="tab"
                            aria-controls="pills-outsideruser" aria-selected="false">Outsider User</button>
                    </li>
                </ul>

                <div class="tab-content" id="pills-tabContent">
                    {{-- Register User --}}
                    <div class="tab-pane fade show active" id="pills-registeruser" role="tabpanel"
                        aria-labelledby="pills-registeruser-tab" tabindex="0">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="btn-container d-flex justify-content-between">
                                            <h3><strong>Register Customer</strong></h3>
                                            <a href="{{ route('registercustomer.assign') }}"
                                                class="btn btn-info text-white"><i class="fa fa-plus"></i> Assign AMC</a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <table id="example1" class="table table-bordered table-striped datatable-custom">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">S.N</th>
                                                    <th class="text-center">Name</th>
                                                    <th class="text-center">Mobile</th>
                                                    <th class="text-center">Address</th>
                                                    <th class="text-center">Amc Type</th>
                                                    <th class="text-center">Amount</th>
                                                    <th class="text-center">Date</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($register as $key => $customer)
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        <td class="text-center">{{ $customer->customer->lead->name }}</td>
                                                        <td class="text-center">{{ $customer->customer->lead->mobile }}</td>
                                                        <td class="text-center">{{ $customer->customer->lead->address }}
                                                        </td>
                                                        <td class="text-center">{{ $customer->amc->title }}</td>
                                                        <td class="text-center">Rs.{{ $customer->amount ?? '0' }}</td>
                                                        <td class="text-center">{{ $customer->date }}</td>
                                                        <td class="text-center">
                                                            <a href="#" class="btn btn-sm btn-primary"><i
                                                                    class="fa fa-eye"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th class="text-center">S.N</th>
                                                    <th class="text-center">Name</th>
                                                    <th class="text-center">Mobile</th>
                                                    <th class="text-center">Address</th>
                                                    <th class="text-center">Amc Type</th>
                                                    <th class="text-center">Amount</th>
                                                    <th class="text-center">Date</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Outsider User --}}
                    <div class="tab-pane fade" id="pills-outsideruser" role="tabpanel"
                        aria-labelledby="pills-outsideruser-tab" tabindex="0">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="btn-container d-flex justify-content-between">
                                            <h3><strong>Outsider Customer</strong></h3>
                                            <a href="{{ route('outsidercustomer.assign') }}"
                                                class="btn btn-info text-white"><i class="fa fa-plus"></i> Assign AMC</a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <table id="example2" class="table table-bordered table-striped datatable-custom">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">S.N</th>
                                                    <th class="text-center">Name</th>
                                                    <th class="text-center">Mobile</th>
                                                    <th class="text-center">Address</th>
                                                    <th class="text-center">Amc Type</th>
                                                    <th class="text-center">Amount</th>
                                                    <th class="text-center">Date</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($outsider as $key => $customer)
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        <td class="text-center">{{ $customer->customer_name }}</td>
                                                        <td class="text-center">{{ $customer->contact }}</td>
                                                        <td class="text-center">{{ $customer->address }}</td>
                                                        <td class="text-center">{{ $customer->amc->title }}</td>
                                                        <td class="text-center">Rs.{{ $customer->amount ?? '0' }}</td>
                                                        <td class="text-center">{{ $customer->date }}</td>
                                                        <td class="text-center">
                                                            <a href="{{ route('amc_customer.details',$) }}" class="btn btn-sm btn-primary"><i
                                                                    class="fa fa-eye"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th class="text-center">S.N</th>
                                                    <th class="text-center">Name</th>
                                                    <th class="text-center">Mobile</th>
                                                    <th class="text-center">Address</th>
                                                    <th class="text-center">Amc Type</th>
                                                    <th class="text-center">Amount</th>
                                                    <th class="text-center">Date</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
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

@push('scripts')
    <script>
        $(function() {
            // Initialize DataTables for all custom datatables
            $('.datatable-custom').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 10,
                order: []
            });

            // Fix for DataTables inside Bootstrap 5 tabs
            $('a[data-bs-toggle="pill"]').on('shown.bs.tab', function() {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust()
                    .responsive.recalc();
            });
        });
    </script>
@endpush
