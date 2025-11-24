@extends('setting::layouts.master')

@section('title', 'Stock Issue Requests')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Stock Issue</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Page Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Stock Issue</h1>
                    </div>
                    <div class="col-sm-6 text-right">

                    </div>
                </div>
            </div>
        </section>

        <!-- Table -->
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        {{-- @can('create_product') --}}
                        <h3 class="card-title float-right"><a class="btn btn-primary text-white" data-toggle="modal"
                                data-target="#requestModal"><i class="fa fa-plus"></i>
                                Request</a> </h3>
                        @include('inventory::stockissue.request')
                        {{-- @endcan --}}
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">S.N</th>
                                    <th class="text-center">Requested By</th>
                                    <th class="text-center">View Details</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stockIssues as $key => $tool)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $tool->user->name ?? 'N/A' }} <br>
                                            {{-- <small>ID: #{{ $tool->id }}</small> --}}
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-info btn-sm" data-toggle="modal"
                                                data-target="#viewModal{{ $tool->id }}">
                                                <i class="fa fa-eye"></i> View Details
                                            </button>
                                            @include('inventory::stockissue.viewdetails')
                                        </td>
                                        <td class="text-center">{{ $tool->created_at }}</td>
                                        <td class="text-center">
                                            @if ($tool->status == 'pending')
                                                <span class="badge badge-warning badge-sm">Pending</span>
                                            @elseif ($tool->status == 'accepted')
                                                <span class="badge badge-success badge-sm">Accepted</span>
                                            @elseif ($tool->status == 'rejected')
                                                <span class="badge badge-danger badge-sm">Rejected</span>
                                            @else
                                                <span class="badge badge-secondary badge-sm">Unknown</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if (Auth::user()->role->name === 'Super Admin')
                                                {{-- Only super admin can see buttons --}}
                                                @if ($tool->status == 'pending')
                                                    <button type="button" class="btn btn-sm btn-success"
                                                        data-toggle="modal" data-target="#acceptModal{{ $tool->id }}">
                                                        Accept
                                                    </button>
                                                    <!-- Accept Modal -->
                                                    <div class="modal fade" id="acceptModal{{ $tool->id }}"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="acceptModalLabel{{ $tool->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <form action="{{ route('stock-issue.accept', $tool->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <div class="modal-content">

                                                                    <!-- Modal Header -->
                                                                    <div class="modal-header bg-success text-white">
                                                                        <h5 class="modal-title">Accept Request</h5>
                                                                        <button type="button" class="close text-white"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>

                                                                    <!-- 👇 MESSAGE FIELD RIGHT AFTER HEADER -->
                                                                    <div class="px-4 pt-3">
                                                                        <label for="accept_message"><strong>Enter
                                                                                Message:</strong></label>
                                                                        <textarea name="message" class="form-control" id="accept_message" rows="3" required></textarea>
                                                                    </div>

                                                                    <!-- Footer Buttons -->
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                            class="btn btn-secondary btn-sm"
                                                                            data-dismiss="modal">Cancel</button>
                                                                        <button type="submit"
                                                                            class="btn btn-success btn-sm">Confirm
                                                                            Accept</button>
                                                                    </div>

                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>

                                                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                                        data-target="#rejectModal{{ $tool->id }}">
                                                        Reject
                                                    </button>
                                                    <!-- Reject Modal -->
                                                    <div class="modal fade" id="rejectModal{{ $tool->id }}"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="rejectModalLabel{{ $tool->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <form action="{{ route('stock-issue.reject', $tool->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-danger text-white">
                                                                        <h5 class="modal-title">Reject Request</h5>
                                                                        <button type="button" class="close text-white"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <label for="reject_message">Enter reason:</label>
                                                                        <textarea name="message" class="form-control" id="reject_message" rows="3" required></textarea>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                            class="btn btn-secondary btn-sm"
                                                                            data-dismiss="modal">Cancel</button>
                                                                        <button type="submit"
                                                                            class="btn btn-danger btn-sm">Confirm
                                                                            Reject</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @elseif ($tool->status == 'accepted')
                                                    <span type="button" class="badge badge-success" data-toggle="modal"
                                                        data-target="#Modal{{ $tool->id }}">
                                                        Note
                                                    </span>
                                                @elseif ($tool->status == 'rejected')
                                                    <span class="badge badge-danger" data-toggle="modal"
                                                        data-target="#Modal{{ $tool->id }}">
                                                        Note
                                                    </span>
                                                @endif
                                            @else
                                                {{-- Other users see only label --}}
                                                @if ($tool->status == 'pending')
                                                    <span class="badge badge-warning">Pending</span>
                                                @elseif ($tool->status == 'accepted')
                                                    <span class="badge badge-success" data-toggle="modal"
                                                        data-target="#Modal{{ $tool->id }}">
                                                        Note
                                                    </span>
                                                @elseif ($tool->status == 'rejected')
                                                    <span class="badge badge-danger" data-toggle="modal"
                                                        data-target="#Modal{{ $tool->id }}">
                                                        Note
                                                    </span>
                                                @endif
                                            @endif
                                            <!-- Modal -->
                                            <div class="modal fade" id="Modal{{ $tool->id }}" tabindex="-1" role="dialog"
                                                aria-labelledby="ModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header text-dark">
                                                            <h4 class="modal-title" id="ModalLabel">
                                                                <strong>Note:</strong>
                                                            </h4>
                                                            <button class="close text-dark" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-dark">
                                                            <h5>{{ $tool->message }}</p>.
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary btn-sm"
                                                                data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-center">S.N</th>
                                    <th class="text-center">Requested By</th>
                                    <th class="text-center">View Details</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection
