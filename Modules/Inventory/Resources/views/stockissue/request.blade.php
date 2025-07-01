<!-- Modal: Request Stock -->
<div class="modal fade" id="requestModal" tabindex="-1" role="dialog" aria-labelledby="requestModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content shadow-lg" style="border-radius: 18px;">
            <div class="modal-header bg-info text-white justify-content-center">
                <h4>Request Technical Tool</h4>
            </div>
            <form action="{{ route('stock-issue.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- MACHINERY SECTION -->
                    <div class="form-group">
                        <label>Machineries</label>
                        <div id="machineryContainer"></div>
                        <button type="button" id="addMachinery" class="btn btn-outline-primary btn-sm mt-2">Add
                            Machinery</button>
                    </div>

                    <!-- ACCESSORY SECTION -->
                    <div class="form-group">
                        <label>Accessories</label>
                        <div id="accessoryContainer"></div>
                        <button type="button" id="addAccessory" class="btn btn-outline-success btn-sm mt-2">Add
                            Accessory</button>
                    </div>

                    <!-- TECHNICAL TOOLS SECTION -->
                    <div class="form-group">
                        <label>Technical Tools</label>
                        <div id="toolContainer"></div>
                        <button type="button" id="addTool" class="btn btn-outline-info btn-sm mt-2">Add Technical
                            Tool</button>
                    </div>

                    <!-- MESSAGE -->
                    <div class="form-group mt-3">
                        <label>Remark / Message</label>
                        <textarea name="message" class="form-control" rows="3" required placeholder="Enter message..."></textarea>
                    </div>
                </div>
                <div class="modal-footer justify-content-start">
                    <button type="submit" class="btn btn-success">Submit Request</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const machineries = @json($machineries); // pass this from controller
    const accessories = @json($accessories); // pass this from controller
    const technicalTools = @json($technicalTools); // pass this from controller

    function createRow(containerId, type, list) {
        const index = document.querySelectorAll(`#${containerId} .row`).length;
        const options = list.map(item => `<option value="${item.id}">${item.name}</option>`).join('');

        const row = document.createElement("div");
        row.className = "row mb-2";
        row.innerHTML = `
        <div class="col-md-6">
            <select name="${type}[${index}][id]" class="form-control" required>
                <option value="">Select ${type}</option>
                ${options}
            </select>
        </div>
        <div class="col-md-4">
            <input type="number" name="${type}[${index}][qty]" class="form-control" value="1" min="1" required>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger btn-sm remove-row"><i class="fa fa-times"></i></button>
        </div>
    `;
        document.getElementById(containerId).appendChild(row);
    }


    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('addMachinery').addEventListener('click', () => {
            createRow('machineryContainer', 'machineries', machineries);
        });
        document.getElementById('addAccessory').addEventListener('click', () => {
            createRow('accessoryContainer', 'accessories', accessories);
        });
        document.getElementById('addTool').addEventListener('click', () => {
            createRow('toolContainer', 'technical_tools', technicalTools);
        });

        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-row')) {
                e.target.closest('.row').remove();
            }
        });
    });
</script>
