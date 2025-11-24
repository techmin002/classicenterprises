<!-- Create AMC Modal -->
<div class="modal fade" id="createAmcModal" tabindex="-1" role="dialog" aria-labelledby="createAmcModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="createAmcModalLabel">Create New Amc Policy</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('amc.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">AMC Details</h3>
                    </div>
                    <div class="card-body">
                        <div class="row gy-3">
                            <div class="col-md-4">
                                <label>Amc Type <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" placeholder="Enter Title"
                                    required>
                            </div>
                            <div class="col-md-4">
                                <label>Year <span class="text-danger">*</span></label>
                               <input type="number" name="year" class="form-control" placeholder="Enter Year" required>
                            </div>
                            {{-- <div class="col-md-3">
                                <label>Month <span class="text-danger">*</span></label>
                                <select name="month" class="form-control" required>
                                    <option value="">Select Month</option>
                                    @for ($m = 0; $m <= 12; $m++)
                                        <option value="{{ $m }}">{{ $m }}</option>
                                    @endfor
                                </select>
                            </div> --}}

                            <div class="col-md-4">
                                <label>Price <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="price" class="form-control"
                                    placeholder="Enter Price" required>
                            </div>

                            <div class="col-md-12 mt-3">
                                <label>Description </label>
                                <textarea name="description" class="form-control" rows="3" placeholder="Enter Description (optional)"></textarea>
                            </div>
                            <div class="mt-3 col-md-12">
                                <label class="form-label12">Publish</label>
                                <br>
                                <input type="checkbox" name="status" checked data-bootstrap-switch
                                    data-off-color="danger" data-on-color="success">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
