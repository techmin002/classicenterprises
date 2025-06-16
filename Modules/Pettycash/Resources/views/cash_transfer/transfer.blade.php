<div class="modal fade" id="exampleModalCentercashtransfer{{ $req->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #0837a4; color: #ffff;">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Transfer Petty Cash </h1>
            </div>
            <form action="{{ route('petty-cash-transfer.store',$req->id) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="row gy-3">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label12">Amount</label>
                                    <input class="form-control" placeholder="Enter Amount" type="number"
                                        name="amount" value="{{ $req->amount}}" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label12">Date</label>
                                    <input class="form-control" placeholder="Select date" type="date" name="date">
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="branch_id" value="{{ $req->branch_id }}">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label12">Description</label>
                                <textarea name="description" id="" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">

                    <button type="submit" name="submit" id="btnSubmit" class="btn btn-success">Transfer</button>

                    <button type="cancel" data-dismiss="modal" class="btn btn-danger">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    <span id="output"></span>
</div>
