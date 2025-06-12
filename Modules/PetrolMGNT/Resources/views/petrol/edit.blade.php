<div class="modal fade" id="editCategory{{ $value->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #0837a4; color: #fff;">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Bike Details</h1>
            </div>
            <form action="{{ route('petrol.update', $value->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="container">
                        <div class="row gy-3">
                            <div class="col-lg-6">
                                <div class="form-group">
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
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label12">Amount</label>
                                    <input class="form-control" placeholder="Enter Amount" type="text"
                                        value="{{ $value->amount }}" required name="amount">
                                </div>
                            </div>
                        </div>

                        <div class="row gy-3">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label12">Date</label>
                                    <input class="form-control" type="date" required name="date"
                                        value="{{ $value->date }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label12">KM</label>
                                    <input class="form-control" placeholder="Enter Kilometer" type="text"
                                        name="km" required value="{{ $value->km }}">
                                </div>
                            </div>
                        </div>

                        <div class="row gy-3">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label12">Message</label>
                                    <textarea name="message" class="form-control" required>{{ $value->message }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-2">
                            <div class="card card-secondary">
                                <div class="card-header">
                                    <h3 class="card-title">Publish</h3>
                                </div>
                                <div class="card-body">
                                    <input type="checkbox" name="status"
                                        {{ $value->status === 'on' ? 'checked' : '' }}
                                        data-bootstrap-switch data-off-color="danger" data-on-color="success">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-center">
                    <button type="submit" name="submit" id="btnSubmit" class="btn btn-success">Save Item</button>
                    <button type="button" data-dismiss="modal" class="btn btn-danger">Cancel</button>
                </div>
            </form>
        </div>
        <span id="output"></span>
    </div>
</div>
