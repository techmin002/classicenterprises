<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #0837a4; color: #fff;">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Bike For Services</h1>
            </div>
            <form action="{{ route('service.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="row gy-3">
                            <div class="col-lg-6">
                                <label class="form-label12">Select Bike</label>
                                <select class="form-control" name="bike_id" required>
                                    <option value="" selected disabled>Select Bike Number</option>
                                    @foreach ($bike as $value)
                                        <option value="{{ $value->id }}">{{ $value->bikenumber }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-6">
                                <label class="form-label12">Amount</label>
                                <input class="form-control" placeholder="Enter Amount" type="text" name="amount"
                                    required>
                            </div>

                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Date</label>
                                <input class="form-control" type="date" name="date" required>
                            </div>

                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">KM</label>
                                <input class="form-control" placeholder="Enter Kilometer" type="text" name="km"
                                    required>
                            </div>
                            {{-- new --}}
                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Mode of Payment </label>
                                <select class="form-control" name="mode">
                                    <option value="" selected disabled>Select Payment Mode</option>
                                    <option value="petty cash">Petty Cash</option>
                                    <option value="online">Online</option>
                                    <option value="cheque">Cheque</option>
                                </select>
                            </div>
                            <div class="mt-3 col-lg-6" data-select2-id="select2-data-5-a5wr">
                                <label class="form-label12">Receipt</label>
                                <input type="file" class="form-contro" name="image" required>
                            </div>
                            {{-- new --}}
                            <div class="col-lg-12">
                                <label class="form-label12">Message</label>
                                <textarea name="message" class="form-control" required></textarea>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label12">Publish</label><br>
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
        <span id="output"></span>
    </div>
</div>
