@extends('setting::layouts.master')

@section('title', 'Support Ticket')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Support Queue</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Support Queue</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Support Queue</li>
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
                                @can('create_ticket')
                                    <h3 class="card-title float-right">
                                        <a class="btn btn-primary text-white" data-toggle="modal"
                                            data-target="#exampleModalCenter">
                                            <i class="fa fa-plus"></i> Create
                                        </a>
                                    </h3>
                                @endcan
                                @include('outsidersupportdashboard::supports.create')
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Contact</th>
                                            <th class="text-center">Product</th>
                                            <th class="text-center">Address</th>
                                            <th class="text-center">Home Address</th>
                                            <th class="text-center">Support Type</th>
                                            <th class="text-center">Priority</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $value)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $value->name }}</td>
                                                <td class="text-center">{{ $value->contact }}</td>
                                                <td class="text-center">{{ $value->product }}</td>
                                                <td class="text-center">{{ $value->address }}</td>
                                                <td class="text-center">{{ $value->home_address }}</td>
                                                <td class="text-center">{{ $value->support_type }}</td>
                                                <td class="text-center">{{ $value->priority }}</td>

                                                <td>
                                                    @can('edit_ticket')
                                                        <a href="" class="btn btn-success btn-xs w-75"
                                                            data-toggle="modal"
                                                            data-target="#exampleModal{{ $value->id }}">Action</a>
                                                    @endcan
                                                    {{-- modal start --}}
                                                    <div class="modal fade" id="exampleModal{{ $value->id }}"
                                                        tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content border-0 shadow">

                                                                <!-- Modal Header -->
                                                                <div class="modal-header bg-primary text-white">
                                                                    <div>
                                                                        <h5 class="modal-title mb-0" id="exampleModalLabel">
                                                                            <i class="fa fa-headset mr-2"></i> Take Action
                                                                        </h5>

                                                                    </div>
                                                                    <button type="button" class="close text-white"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>

                                                                <!-- Modal Body -->
                                                                <form
                                                                    action="{{ route('outsidersupportdashboard-task.assignstore', $value->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <div class="modal-body">
                                                                        <input type="hidden" name="customer_id"
                                                                            value="{{ $value->id }}">

                                                                        <!-- Comment option -->
                                                                        <div class="border rounded bg-light p-2">
                                                                            <div class="form-check mb-2">
                                                                                <input
                                                                                    class="form-check-input comment-radio"
                                                                                    type="radio" name="action_type"
                                                                                    id="commentOption{{ $value->id }}"
                                                                                    value="comment" checked>

                                                                                <label
                                                                                    class="form-check-label font-weight-bold"
                                                                                    for="commentOption{{ $value->id }}">Comment</label>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Assign option -->
                                                                        <div class="border rounded bg-light p-2 mt-2">
                                                                            <div class="form-check">
                                                                                <input class="form-check-input assign-radio"
                                                                                    type="radio" name="action_type"
                                                                                    id="assignOption{{ $value->id }}"
                                                                                    value="assign">

                                                                                <label
                                                                                    class="form-check-label font-weight-bold"
                                                                                    for="assignOption{{ $value->id }}">Assign</label>
                                                                            </div>
                                                                        </div>
                                                                        <!-- Hidden Select User -->
                                                                        <div id="assignUserSection{{ $value->id }}"
                                                                            class="form-group mt-2 assign-section d-none">
                                                                            <label for="assign_to"
                                                                                class="font-weight-bold">Select User</label>

                                                                            @php
                                                                                $branchId = $value->branch_id ?? null;
                                                                                $branchUsers = $users[$branchId] ?? [];
                                                                            @endphp

                                                                            <select name="assign_to"
                                                                                id="assign_to_{{ $value->id }}"
                                                                                class="form-control">
                                                                                <option value="" disabled selected>
                                                                                    Select User</option>
                                                                                @foreach ($branchUsers as $user)
                                                                                    <option value="{{ $user->name }}">
                                                                                        {{ $user->name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>

                                                                        <!-- Message -->
                                                                        <div class="form-group mt-3">
                                                                            <label for="message"
                                                                                class="font-weight-bold">Message</label>
                                                                            <textarea name="message" id="message" class="form-control" rows="4" placeholder="Enter message..."></textarea>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Modal Footer -->
                                                                    <div class="modal-footer bg-light">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">
                                                                            <i class="fa fa-times mr-1"></i> Close
                                                                        </button>
                                                                        <button type="submit" class="btn btn-success">
                                                                            <i class="fa fa-paper-plane mr-1"></i> Save
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- modal end --}}

                                                    <a href="" class="btn btn-primary btn-xs w-75 mt-2"
                                                        data-toggle="modal"
                                                        data-target="#exampleModal1{{ $value->id }}">Note</a>

                                                    {{-- modal start --}}
                                                    <div class="modal fade" id="exampleModal1{{ $value->id }}"
                                                        tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content border-0 shadow">
                                                                <!-- Modal Header -->
                                                                <div class="modal-header bg-primary text-white">
                                                                    <div>

                                                                    </div>
                                                                    <button type="button" class="close text-white"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>

                                                                <!-- Modal Body -->
                                                                <div class="modal-body">
                                                                    {{ $value->message }}
                                                                </div>

                                                                <!-- Modal Footer -->
                                                                <div class="modal-footer bg-light">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- modal end --}}

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>S.N</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Contact</th>
                                            <th class="text-center">Product</th>
                                            <th class="text-center">Address</th>
                                            <th class="text-center">Home Address</th>
                                            <th class="text-center">Support Type</th>
                                            <th class="text-center">Priority</th>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.modal').forEach(function(modal) {
            const taskId = modal.id.replace('exampleModal', '');

            const commentRadio = modal.querySelector(`#commentOption${taskId}`);
            const assignRadio = modal.querySelector(`#assignOption${taskId}`);
            const assignSection = modal.querySelector(`#assignUserSection${taskId}`);

            function toggleAssignField() {
                if (assignRadio && assignRadio.checked) {
                    assignSection.classList.remove('d-none');
                } else {
                    assignSection.classList.add('d-none');
                }
            }

            if (commentRadio && assignRadio && assignSection) {
                commentRadio.addEventListener('change', toggleAssignField);
                assignRadio.addEventListener('change', toggleAssignField);
                // initialize on load
                toggleAssignField();
            }
        });
    });
</script>
