<div class="modal fade" id="editCategory{{ $value->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #0837a4; color: #fff;">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Bike Details</h5>
            </div>
            <form action="{{ route('bike.update', $value->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <!-- Bike Name -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bike Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $value->name }}"
                                required placeholder="Enter Bike Name">
                        </div>

                        <!-- Branch -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Branch</label>
                            <select class="form-control" name="branch_id">
                                <option value="" selected disabled>Select Branch</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}"
                                        @if ($branch->id == $value->branch_id) selected @endif>{{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Model No -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Model Number</label>
                            <input type="text" name="model" class="form-control" value="{{ $value->model }}"
                                required placeholder="Enter Model Number">
                        </div>

                        <!-- Bike Number -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bike Number</label>
                            <input type="text" name="bikenumber" class="form-control"
                                value="{{ $value->bikenumber }}" required placeholder="Enter Bike Number">
                        </div>

                        <!-- Status -->
                        <div class="col-md-6 mt-2">
                            <label class="form-label d-block">Status</label>
                            <input type="checkbox" name="status" {{ $value->status === 'on' ? 'checked' : '' }}
                                data-bootstrap-switch data-off-color="danger" data-on-color="success">
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-success">Save Item</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
