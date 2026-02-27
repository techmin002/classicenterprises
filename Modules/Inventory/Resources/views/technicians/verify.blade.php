{{-- Verify Modal (ONLY ONE COPY) --}}
<div class="modal fade" id="verifyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form method="POST" id="verifyForm" class="needs-validation" novalidate>
            @csrf
            <div class="modal-content border-0 shadow-lg rounded">
                
                <div class="modal-header bg-gradient-success text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-check-circle me-2"></i>
                        Verify Item: <span id="modalItemName" class="fw-bold"></span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="return_id" id="returnId">

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Returned Quantity</label>
                            <input type="number" name="returned_qty" class="form-control border-success" min="0" value="0" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Used Quantity</label>
                            <input type="number" name="used_qty" class="form-control border-warning" min="0" value="0" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Broken Quantity</label>
                            <input type="number" name="broken_qty" class="form-control border-danger" min="0" value="0" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Remarks</label>
                            <textarea name="remarks" class="form-control border-info" rows="3" placeholder="Optional remarks..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-success shadow-sm">
                        <i class="fas fa-check me-1"></i> Verify
                    </button>
                   <button type="button" class="btn btn-secondary shadow-sm" data-dismiss="modal">
    <i class="fas fa-times me-1"></i> Cancel
</button>

                </div>

            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function () {
    // DataTable
    $('#assignments-table').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 25,
        columnDefs: [{ targets: -1, orderable: false, searchable: false }]
    });

    // Open Verify Modal
    $('.verify-btn').click(function () {
        let staffId = $(this).data('staff');
        let itemType = $(this).data('item-type');
        let itemId = $(this).data('item-id');
        let itemName = $(this).data('item-name');
        let returnId = $(this).data('return-id') ?? 0;

        $('#modalItemName').text(itemName);
        $('#returnId').val(returnId);

        $('#verifyForm').attr(
            'action',
            "{{ url('inventory/technicians') }}/" + staffId + "/verify/" + itemType + "/" + itemId
        );

        $('#verifyModal').modal('show');
    });

    // Bootstrap validation
    (function () {
        'use strict';
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
    })();
});
</script>
