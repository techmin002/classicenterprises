<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #0837a4; color: #fff;">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Petty Cash</h1>
            </div>
            <form action="{{ route('pettycash-addcash.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="row gy-3">

                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Title</label>
                                <input class="form-control" placeholder="Enter Title Name" type="text"
                                    name="title" required>
                            </div>

                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Amount</label>
                                <input class="form-control" placeholder="Enter Amount" type="number" name="amount" required>
                            </div>

                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Date</label>
                                <input class="form-control" placeholder="Select date" type="date" name="date" required>
                            </div>
                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Last Month Remaining Cash</label>
                                <input type="number" class="form-control" name="lm_remaining_cash" value="{{ $lasttotal }}" readonly>
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
                <div class="modal-footer justify-content-start">
                    <button type="submit" name="submit" id="btnSubmit" class="btn btn-success">Save Item</button>
                    <button type="button" data-dismiss="modal" class="btn btn-danger">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
