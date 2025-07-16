<div class="modal fade" id="editCategory{{ $exp->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #0837a4; color: #fff;">
                <h3 class="modal-title fs-5" id="staticBackdropLabel">Assign</h3>
            </div>
            <form action="{{ route('installation-assign.store', $exp->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="container">
                        <div class="row gy-3">
                            <div class="col-lg-12">
                                <label class="form-label">Assign Lead</label>
                                <select class="form-control" name="lead_id" required>
                                    <option value="" disabled {{ empty($value->lead_id) ? 'selected' : '' }}>Assign Lead</option>
                                    @foreach ($leads as $lead)
                                        <option value="{{ $lead->id }}"
                                            {{ isset($value->lead_id) && $lead->id == $value->lead_id ? 'selected' : '' }}>
                                            {{ $lead->name }} - {{ $lead->mobile }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-12">
                                <label class="form-label12">Message</label>
                                <textarea name="message" class="form-control" required>{{ $exp->message }}</textarea>
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
