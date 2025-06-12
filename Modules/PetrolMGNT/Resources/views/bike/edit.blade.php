<div class="modal fade" id="editCategory{{ $value->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #0837a4; color: #ffff;">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Bike Details </h1>
            </div>
            <form action="{{ route('bike.update', $value->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="modal-body">
                    <div class="container">
                        <div class="row gy-3">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label12">Name</label>
                                    <input class="form-control" placeholder="Enter Bike Name" type="text" value="{{ $value->name }}" required
                                        name="name">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label12">Model No</label>
                                    <input class="form-control" placeholder="Enter Model Number" type="text" value="{{ $value->model }}" required
                                        name="model">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label12">Bike Number</label>
                                <input class="form-control" placeholder="Enter Bike Number" type="text" value="{{ $value->bikenumber }}" required
                                    name="bikenumber">
                            </div>
                        </div>

                        <div class="col-md-12 mt-2">
                            <!-- Bootstrap Switch -->
                            <div class="card card-secondary">
                                <div class="card-header">
                                    <h3 class="card-title">Publish</h3>
                                </div>
                                <div class="card-body">
                                    <input type="checkbox" name="status" checked data-bootstrap-switch
                                        data-off-color="danger" data-on-color="success">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">

                    <button type="submit" name="submit" id="btnSubmit" class="btn btn-success">Save Item</button>

                    <button type="cancel" data-dismiss="modal" class="btn btn-danger">Cancel</button>
                </div>
            </form>
        </div>
        <span id="output"></span>
    </div>
</div>
</div>
