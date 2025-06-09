<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #0837a4; color: #ffff;">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Petty Cash </h1>
            </div>
            <form action="{{ route('pettycash-addcash.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="row gy-3">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label12">Title</label>
                                    <input class="form-control" placeholder="Enter Title Name" type="text"
                                        name="title">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label12">Amount</label>
                                    <input class="form-control" placeholder="Enter Amount" type="number"
                                        name="amount">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label12">Date</label>
                                <input class="form-control" placeholder="Select date" type="date" name="date">
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
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label12">Last Month Remaining Cash</label>
                                <input type="text" class="form-control" name="remaining_cash" value="remaining_cash"
                                    readonly>
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
                                        <option value="{{ $key }}">{{ $month }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label12">Description</label>
                                <textarea name="description" id="" class="form-control"></textarea>
                            </div>
                        </div> --}}
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
