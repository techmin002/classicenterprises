<div class="modal fade" id="editHoliday{{ $holiday->id }}">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('holidays.update', $holiday->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5>Edit Holiday</h5>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" value="{{ $holiday->title }}" class="form-control" required>
                    </div>

                    <div class="form-group mt-2">
                        <label>Date</label>
                        <input type="date" name="date" value="{{ $holiday->date }}" class="form-control" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>

        </form>
    </div>
</div>