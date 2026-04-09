<div class="modal fade" id="viewHoliday{{ $holiday->id }}">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5>Holiday Details</h5>
            </div>

            <div class="modal-body">

                <p><strong>Title:</strong> {{ $holiday->title }}</p>
                <p><strong>Date:</strong> {{ $holiday->date }}</p>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

        </div>

    </div>
</div>