<!-- Create AMC Modal -->
<div class="modal fade" id="createAmcModal" tabindex="-1" role="dialog" aria-labelledby="createAmcModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="createAmcModalLabel">Create New AMC Policy</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <!-- Form -->
            <form action="{{ route('amc.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- AMC Details Card -->
                <div class="card mb-0">
                    <div class="card-header">
                        <h4 class="card-title mb-0">AMC Details</h4>
                    </div>

                    <div class="card-body">
                        <div class="row gy-3">

                            <!-- AMC Type -->
                            <div class="col-md-6">
                                <label class="font-weight-bold">AMC Type <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" placeholder="Enter AMC Type"
                                    required>
                            </div>

                            <!-- Price -->
                            <div class="col-md-6">
                                <label class="font-weight-bold">Price <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="price" class="form-control"
                                    placeholder="Enter Price" required>
                            </div>

                            <!-- Description -->
                            <div class="col-md-12 mt-2">
                                <label class="font-weight-bold">Description</label>
                                <textarea name="description" rows="3" class="form-control" placeholder="Enter Description (Optional)"></textarea>
                            </div>

                            <!-- Publish Status -->
                            <div class="col-md-12 mt-3">
                                <label class="font-weight-bold d-block">Publish</label>
                                <input type="checkbox" name="status" checked data-bootstrap-switch
                                    data-off-color="danger" data-on-color="success">
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-success px-4">Submit</button>
                    <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">Cancel</button>
                </div>

            </form>
        </div>
    </div>
</div>
