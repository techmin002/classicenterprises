<div class="modal fade" id="details{{ $value->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #0837a4; color: #fff;">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Details</h1>
            </div>

            <div class="modal-body">
                <div class="container">
                    <div class="row gy-3">
                        <div class="col-md-12">
                            <h5>Branch Name: {{ $value->bike->branch->name ?? 'N/A' }}</h5>
                            <h5>Bike Number: {{ $value->bike->bikenumber }}</h5>
                        </div>
                        <hr>
                        <div class="mt-3 col-lg-6">
                            <label class="form-label12">Model No: </label>
                            <input class="form-control" value="{{ $value->bike->model }}" readonly>
                        </div>
                        <div class="mt-3 col-lg-6">
                            <label class="form-label12">Amount: </label>
                            <input class="form-control" value="{{ $value->amount }}" readonly>
                        </div>
                        <div class="mt-3 col-lg-6">
                            <label class="form-label12">Mode: </label>
                            <input class="form-control" value="{{ $value->mode }}" readonly>
                        </div>
                        <div class="mt-3 col-lg-6">
                            <label class="form-label12">Date: </label>
                            <input class="form-control" value="{{ $value->date }}" readonly>
                        </div>
                        <div class="mt-3 col-lg-6">
                            <label class="form-label12">KM: </label>
                            <input class="form-control" value="{{ $value->km }}" readonly>
                        </div>
                        <div class="mt-3 col-lg-6">
                            <label class="form-label12">Payment Type: </label>
                            <input class="form-control" value="{{ $value->payment_type }}" readonly>
                        </div>
                        <div class="mt-3 col-lg-6">
                            <label class="form-label12">Petrol Pump: </label>
                            <input class="form-control" value="{{ $value->petrol_pump ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mt-3 col-lg-6">
                            <label class="form-label12">Cheque Number: </label>
                            <input class="form-control" value="{{ $value->cheque_number ?? 'N/A' }}" readonly>
                        </div>
                        <div class="mt-3 col-lg-6">
                            <label class="form-label12">Receipt: </label> <br>
                            <a href="{{ asset('upload/images/petrol-receipt/' . $value->image) }}" target="_blank"
                                alt="">View Receipt</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer justify-content-start">
                <button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
            </div>
        </div>
        <span id="output"></span>
    </div>
</div>
