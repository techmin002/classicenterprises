<!-- Edit AMC Modal -->
<div class="modal fade" id="editAmcModal{{ $amc->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editAmcModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="editAmcModalLabel">Edit Amc policy</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>s

            <form action="{{ route('amc.update', $amc->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">AMC Details</h3>
                    </div>
                    <div class="card-body">
                        <div class="row gy-3">
                            <div class="col-md-3">
                                <label>Title <span class="text-danger">*</span></label>
                                <input type="text" value="{{ $amc->title }}" name="title" class="form-control"
                                    placeholder="Enter Title" required>
                            </div>
                            <div class="col-md-3">
                                <label>Year <span class="text-danger">*</span></label>
                                <input type="text" name="year" value="{{ $amc->year }}" class="form-control"
                                    placeholder="Enter Year" required>
                            </div>
                            <div class="col-md-3">
                                <label>Month <span class="text-danger">*</span></label>
                                <select name="month" class="form-control" required>
                                    <option value="">Select Month</option>
                                    @for ($m = 0; $m <= 12; $m++)
                                        <option value="{{ $m }}" {{ $amc->month == $m ? 'selected' : '' }}>
                                            {{ $m }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label>Price <span class="text-danger">*</span></label>
                                <input type="number" value="{{ $amc->price }}" step="0.01" name="price"
                                    class="form-control" placeholder="Enter Price" required>
                            </div>

                            <div class="col-md-12 mt-3">
                                <label>Description </label>
                                <textarea name="description" class="form-control" rows="3" placeholder="Enter Description (optional)">{{ $amc->description }}</textarea>
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
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
