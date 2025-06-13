<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #0837a4; color: #ffff;">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Petty Cash </h1>
            </div>
            <form action="{{ route('petrol.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="row gy-3">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label12">Select Bike</label>
                                    <select class="form-control" name="bike_id">
                                        <option value="" selected disabled>Select Bike Number</option>
                                        @foreach ($bike as $value)
                                            <option value="{{ $value->id }}">{{ $value->bikenumber }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label12">Amount</label>
                                    <input class="form-control" placeholder="Enter Amount" type="text" required
                                        name="amount">
                                </div>
                            </div>
                        </div>
                        <div class="row gy-3">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label12">Date</label>
                                    <input class="form-control"  type="date" required
                                        name="date">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label12">KM</label>
                                    <input class="form-control" placeholder="Enter Killo Meter" type="text" required
                                        name="km">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label12">Message</label>
                                <textarea name="message" id=""  class="form-control" required></textarea>
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

    </div>
    <span id="output"></span>
</div>
</div>
</div>
