<div class="modal fade" id="editCategory{{ $exp->id }}" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #0837a4; color: #fff;">
                <h3 class="modal-title fs-5">Assign</h3>
            </div>
            <form action="{{ route('installation-category-assign.store', $exp->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="container">
                        <div class="row gy-3">

                            <!-- Customer Name -->
                            <div class="col-lg-6">
                                <label class="form-label">Customer Name:</label>
                                <input type="text" class="form-control" value="{{ $exp->lead->name ?? 'N/A' }}" disabled>
                            </div>

                            <!-- Already Assigned Lead -->
                            <div class="col-lg-6">
                                <label class="form-label">Current Assign Lead:</label>
                                <input type="text" class="form-control" value="{{ $exp->assignLead->name ?? 'No User Assigned' }}" disabled>
                            </div>

                            <!-- Assign Lead Dropdown -->
                            <div class="col-lg-12 mt-2">
                                <label class="form-label">Assign Lead</label>
                                <select class="form-control" name="user_id" required>
                                    <option value="" disabled selected>Assign Lead</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ isset($exp->user_id) && $exp->user_id == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} - {{ $user->email }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Message -->
                            <div class="col-lg-12 mt-2">
                                <label class="form-label">Message</label>
                                <textarea name="message" class="form-control" required>{{ $exp->message }}</textarea>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-start">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <button type="button" data-dismiss="modal" class="btn btn-danger">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>