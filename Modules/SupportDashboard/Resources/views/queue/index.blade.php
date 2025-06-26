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

                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>ID</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">User Name</th>
                                            <th class="text-center">Contact</th>
                                            <th class="text-center">Product</th>
                                            <th class="text-center">Address</th>
                                            <th class="text-center">Support Type</th>
                                            <th class="text-center">Priority</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $value)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $value->id }}</td>

                                                <td>{{ $value->customer->lead->name }}</td>
                                                <td>{{ $value->customer->lead->user_name }}</td>
                                                <td>{{ $value->customer->lead->mobile }}</td>
                                                <td>
                                                    @foreach ($value->customer->products as $product)
                                                        {{ $product->product['name'] }}
                                                    @endforeach
                                                </td>
                                                <td>{{ $value->customer->lead->address }}
                                                </td>
                                                <td>{{ $value->support_type }}</td>
                                                <td>{{ $value->priority }}</td>

                                                <td>
                                                    <a href="" class="btn btn-success btn-xs w-75" data-toggle="modal"
                                                        data-target="#exampleModal{{ $value->id }}">Action</a>

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
                                                                        <small>Customer:
                                                                            <strong>{{ ucfirst($value->customer->lead->name) }}</strong></small>
                                                                    </div>
                                                                    <button type="button" class="close text-white"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>

                                                                <!-- Modal Body -->
                                                                <form
                                                                    action="{{ route('supportdashboard-task.assignstore', $value->id) }}"
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
                                                                            <select name="assign_to" id="assign_to"
                                                                                class="form-control">
                                                                                <option value="" disabled selected>
                                                                                    Select User</option>
                                                                                <option value="a">A</option>
                                                                                <option value="b">B</option>
                                                                                <option value="c">C</option>
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

                                                    <a href="" class="btn btn-primary btn-xs w-75 mt-2" data-toggle="modal"
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
                                                                        <small>Customer:
                                                                            <strong>{{ ucfirst($value->customer->lead->name) }}</strong></small>
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
                                            <th>ID</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">User Name</th>
                                            <th class="text-center">Contact</th>
                                            <th class="text-center">Product</th>
                                            <th class="text-center">Address</th>
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
