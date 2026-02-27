<!-- Assign Item Modal -->
<div class="modal fade" id="assignModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg" style="border-radius: 15px;">

            <div class="modal-header bg-primary text-white justify-content-between">
                <h4 class="mb-0">Assign Items to {{ $staff->name }}</h4>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form method="POST" action="{{ route('inventory.technicians.assign.store') }}">
                    @csrf
                    <input type="hidden" name="staff_id" value="{{ $staff->id }}">

                    <!-- ACCESSORIES -->
                    <div class="form-group">
                        <label>Accessories</label>
                        <div class="accessoryContainer"></div>
                        <button type="button" class="btn btn-outline-success btn-sm mt-2 addAccessory">
                            <i class="fas fa-plus"></i> Add Accessory
                        </button>
                    </div>

                    <!-- TECHNICAL TOOLS -->
                    <div class="form-group">
                        <label>Technical Tools</label>
                        <div class="toolContainer"></div>
                        <button type="button" class="btn btn-outline-info btn-sm mt-2 addTool">
                            <i class="fas fa-plus"></i> Add Technical Tool
                        </button>
                    </div>

                    <!-- Remarks -->
                    <div class="form-group mt-3">
                        <label>Remarks</label>
                        <textarea name="remarks" class="form-control" rows="3" placeholder="Optional remarks..."></textarea>
                    </div>

                    <!-- Submit -->
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-plus-circle"></i> Assign Items
                        </button>
                        <button type="button" class="btn btn-secondary ml-2" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const accessories = @json($accessories);
    const technicalTools = @json($technicalTools);

    /* ===============================
       ACCESSORY ROW (WITH UNIT)
    =============================== */
    function createAccessoryRow(container) {

        const index = container.querySelectorAll('.row').length;

        const options = accessories.map(item => {
            return `<option 
                        value="${item.id}" 
                        data-unit="${item.unit}"
                    >
                        ${item.name} (Available: ${item.stock_quantity})
                    </option>`;
        }).join('');

        const row = document.createElement('div');
        row.className = 'row mb-2';
        row.innerHTML = `
            <div class="col-md-5">
                <select name="accessories[${index}][item_id]" 
                        class="form-control accessory-select" required>
                    <option value="">Select Accessory</option>
                    ${options}
                </select>
            </div>

            <div class="col-md-3">
                <input type="number"
                       name="accessories[${index}][assigned_qty]"
                       class="form-control"
                       min="1" value="1" required>
            </div>

            <div class="col-md-2">
                <input type="text"
                       class="form-control accessory-unit"
                       placeholder="Unit"
                       readonly>
            </div>

            <div class="col-md-2">
                <button type="button"
                        class="btn btn-danger btn-sm remove-row">X</button>
            </div>
        `;

        container.appendChild(row);
    }

    /* ===============================
       TECHNICAL TOOL ROW (NO UNIT)
    =============================== */
    function createToolRow(container) {

        const index = container.querySelectorAll('.row').length;

        const options = technicalTools.map(item => {
            return `<option value="${item.id}">
                        ${item.name} (Available: ${item.stock_quantity})
                    </option>`;
        }).join('');

        const row = document.createElement('div');
        row.className = 'row mb-2';
        row.innerHTML = `
            <div class="col-md-6">
                <select name="technical_tools[${index}][item_id]" 
                        class="form-control" required>
                    <option value="">Select Tool</option>
                    ${options}
                </select>
            </div>

            <div class="col-md-4">
                <input type="number"
                       name="technical_tools[${index}][assigned_qty]"
                       class="form-control"
                       min="1" value="1" required>
            </div>

            <div class="col-md-2">
                <button type="button"
                        class="btn btn-danger btn-sm remove-row">X</button>
            </div>
        `;

        container.appendChild(row);
    }

    /* ===============================
       ADD ACCESSORY
    =============================== */
    document.querySelector('.addAccessory')
        .addEventListener('click', function () {
            const container = document.querySelector('.accessoryContainer');
            createAccessoryRow(container);
        });

    /* ===============================
       ADD TOOL
    =============================== */
    document.querySelector('.addTool')
        .addEventListener('click', function () {
            const container = document.querySelector('.toolContainer');
            createToolRow(container);
        });

    /* ===============================
       REMOVE ROW
    =============================== */
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-row')) {
            e.target.closest('.row').remove();
        }
    });

    /* ===============================
       SHOW UNIT WHEN ACCESSORY SELECTED
    =============================== */
    document.addEventListener('change', function(e) {

        if (e.target.classList.contains('accessory-select')) {

            const selected = e.target.options[e.target.selectedIndex];
            let unit = selected.getAttribute('data-unit') || '';

            const unitMap = {
                'qty': 'Quantity',
                'ltr': 'Liter',
                'kg': 'Kilogram',
                'meter': 'Meter',
                'inch': 'Inch',
                'other': 'Other'
            };

            unit = unitMap[unit] ?? unit;

            const row = e.target.closest('.row');
            row.querySelector('.accessory-unit').value = unit;
        }
    });

});
</script>
