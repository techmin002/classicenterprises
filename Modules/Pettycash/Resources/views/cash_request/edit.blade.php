<div class="modal fade" id="editCategory{{ $req->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #0837a4; color: #ffff;">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Category </h1>
            </div>
            <form action="{{ route('pettycash-request.update', $req->id) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="modal-body">
                    <div class="container">
                        <div class="row gy-3">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label12">Title</label>
                                    <input class="form-control" placeholder="Enter Title Name" type="text"
                                        value="{{ $req->title }}" name="title">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label12">Amount</label>
                                    <input class="form-control" placeholder="Enter Amount" type="number"
                                        value="{{ $req->amount }}" name="amount">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label12">Date</label>
                                <input class="form-control" placeholder="Select date" type="date" name="date"
                                    value="{{ $req->date }}">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label12">Month</label>
                                <select class="form-control" name="month">
                                    <option value="" selected disabled>Select Month</option>
                                    @foreach ([
        '01' => 'January',
        '02' => 'February',
        '03' => 'March',
        '04' => 'April',
        '05' => 'May',
        '06' => 'June',
        '07' => 'July',
        '08' => 'August',
        '09' => 'September',
        '10' => 'October',
        '11' => 'November',
        '12' => 'December',
    ] as $key => $month)
                                        <option value="{{ $key }}"
                                            @if (isset($req->month) && $req->month == $key) selected @endif>
                                            {{ $month }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label12">Description</label>
                                <textarea name="description" id="" class="form-control" required>{{ $req->description }}</textarea>
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
