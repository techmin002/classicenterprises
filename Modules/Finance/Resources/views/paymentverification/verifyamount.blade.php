<div class="modal fade" id="exampleModal{{ $value->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #0837a4; color: #ffff;">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Payment Verification </h1>
            </div>
            <form action="{{ route('payment-verification.store', $value->id) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="row gy-3">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label12">Total Amount</label>
                                    <input class="form-control" type="number" name="total_amount"
                                        value="{{ $value->total_amount }}" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label12">Paid Amount</label>
                                    <input class="form-control" type="number" name="paid_amount"
                                        value="{{ $value->paid_amount }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row gy-3">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label12">Remaining Amount</label>
                                    <input class="form-control" type="number" name="remaining_amount"
                                        value="{{ $value->remaining_amount }}" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label12">Date</label>
                                    <input class="form-control" type="date" name="date" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label12">Message</label>
                                <textarea name="message" id="" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">

                    <button type="submit" name="submit" id="btnSubmit" class="btn btn-success">Verified</button>

                    <button type="cancel" data-dismiss="modal" class="btn btn-danger">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    <span id="output"></span>
</div>
