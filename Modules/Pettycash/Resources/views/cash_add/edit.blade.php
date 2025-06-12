<div class="modal fade" id="editCategory{{ $value->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #0837a4; color: #ffff;">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Category </h1>
            </div>
            <form action="{{ route('pettycash-addcash.update', $value->id) }}" method="post"
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
                                        value="{{ $value->title }}" name="title">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label12">Amount</label>
                                    <input class="form-control" placeholder="Enter Amount" type="number"
                                        value="{{ $value->amount }}" name="amount">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label12">Date</label>
                                <input class="form-control" placeholder="Select date" type="date" name="date"
                                    value="{{ $value->date }}">
                            </div>
                        </div>
                        {{-- <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label12">image</label>
                                    <input class="form-control" placeholder="Enter Title" type="file" name="image"
                                        id="image">
                                </div>
                            </div> --}}
                        <div class="col-lg-12" data-select2-id="select2-data-5-a5wr">
                            <div class="form-group">
                                <label class="form-label12">Branch </label>
                                <select class="form-control" name="branch_id">
                                    <option value="" selected disabled>Select Branch</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}"
                                            @if ($branch->id == $value->branch_id) selected @endif>{{ $branch->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label12">Last Month Remaining Cash</label>
                                <input type="number" class="form-control" name="lm_remaining_cash"
                                    value="{{ $value->lm_remaining_cash }}" required>
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
                                            @if (isset($value->month) && $value->month == $key) selected @endif>
                                            {{ $month }}
                                        </option>
                                    @endforeach
                                </select>

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
