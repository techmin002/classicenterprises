<div class="modal fade" id="editCategory{{ $exp->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #0837a4; color: #fff;">
                <h3 class="modal-title fs-5" id="staticBackdropLabel">Assign</h3>
            </div>
            <form action="{{ route('outsidercustomer-assign.store', $exp->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="container">
                        <input type="hidden" name='customer_id' value="{{ $exp->id }}">
                        <div class="row gy-3">
                            <div class="col-lg-6">
                                <label class="form-label">Customer Name:</label>
                                <input type="text" class="form-control" value="{{ $exp->customer_name ?? 'N/A' }}"
                                    disabled>
                            </div>
                            @if ($exp->status == 'assign')
                                <div class="col-lg-6">
                                    <label class="form-label">Assign Lead:</label>
                                    <input type="text" class="form-control"
                                        value="{{ $exp->user->name ?? 'No User Assigned' }}" disabled>
                                </div>
                            @endif

                        </div>
                        <div class="col-lg-12 mt-2">
                            <label class="form-label">Assign Lead</label>
                            <select class="form-control" name="user_id" required>
                                <option value="" disabled {{ empty($value->user_id) ? 'selected' : '' }}>
                                    Assign Lead</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ isset($value->user_id) && $value->user_id == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} - {{ $user->email }}
                                    </option>
                                @endforeach
                            </select>

                        </div>
                        <div class="col-lg-12 mt-2">
                            <label class="form-label12">Message</label>
                            <textarea name="message" class="form-control" required>{{ $exp->message }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-start">
                    <button type="submit" name="submit" id="btnSubmit" class="btn btn-success">Submit</button>
                    <button type="button" data-dismiss="modal" class="btn btn-danger">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    <span id="output"></span>
</div>
