<div class="modal fade" id="createHoliday">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('holidays.store') }}" method="POST">
            @csrf

            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5>Add Holiday</h5>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>

                    <div class="form-group mt-2">
                        <label>Date</label>
                        <input type="date" name="date" class="form-control" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>

        </form>
    </div>
</div>