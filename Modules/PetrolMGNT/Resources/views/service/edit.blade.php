<div class="modal fade" id="editCategory{{ $value->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #0837a4; color: #fff;">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Details of Bike For Services</h1>
            </div>
            <form action="{{ route('service.update', $value->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="container">
                        <div class="row gy-3">
                            <div class="col-lg-6">
                                <label class="form-label12">Select Bike</label>
                                <select class="form-control" name="bike_id" required>
                                    <option value="" disabled>Select Bike</option>
                                    @foreach ($bike as $bikeOption)
                                        <option value="{{ $bikeOption->id }}"
                                            {{ $bikeOption->id == $value->bike_id ? 'selected' : '' }}>
                                            {{ $bikeOption->bikenumber }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-6">
                                <label class="form-label12">Amount</label>
                                <input class="form-control" placeholder="Enter Amount" type="text" name="amount"
                                    value="{{ $value->amount }}" required>
                            </div>

                            <div class="col-lg-6">
                                <label class="form-label12">Date</label>
                                <input class="form-control" type="date" name="date"
                                    value="{{ $value->date }}" required>
                            </div>

                            <div class="col-lg-6">
                                <label class="form-label12">KM</label>
                                <input class="form-control" placeholder="Enter Kilometer" type="text" name="km"
                                    value="{{ $value->km }}" required>
                            </div>

                            <div class="col-lg-6 mt-3">
                                <label class="form-label12">Mode of Payment</label>
                                <select class="form-control" name="mode" required>
                                    <option value="" disabled>Select Payment Mode</option>
                                    <option value="petty cash" {{ $value->mode === 'petty cash' ? 'selected' : '' }}>Petty Cash</option>
                                    <option value="online" {{ $value->mode === 'online' ? 'selected' : '' }}>Online</option>
                                    <option value="cheque" {{ $value->mode === 'cheque' ? 'selected' : '' }}>Cheque</option>
                                </select>
                            </div>

                            <div class="col-lg-6 mt-3">
                                <label class="form-label12">Receipt</label>
                                <input type="file" class="form-control" name="image">
                                @if ($value->image)
                                    <small class="text-muted">Current: <a href="{{ asset('upload/images/service-receipt/' . $value->image) }}" target="_blank">View Receipt</a></small>
                                @endif
                            </div>

                            <div class="col-lg-12">
                                <label class="form-label12">Message</label>
                                <textarea name="message" class="form-control" required>{{ $value->message }}</textarea>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label12">Publish</label><br>
                                <input type="checkbox" name="status"
                                    {{ $value->status === 'on' ? 'checked' : '' }}
                                    data-bootstrap-switch data-off-color="danger" data-on-color="success">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-start">
                    <button type="submit" name="submit" id="btnSubmit" class="btn btn-success">Update</button>
                    <button type="button" data-dismiss="modal" class="btn btn-danger">Cancel</button>
                </div>
            </form>
        </div>
        <span id="output"></span>
    </div>
</div>
