<div class="modal fade" id="createStockTransfer" tabindex="-1" role="dialog" aria-labelledby="createStockTransferTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="max-width: 1100px;">
        <div class="modal-content shadow-lg modal-advanced" style="border-radius: 24px; border: none;">
            <div class="modal-header justify-content-center modal-header-advanced">
                <h1 class="modal-title fs-3 fw-bold text-white" id="staticBackdropLabel">
                    <i class="bi bi-truck me-2"></i>
                    Create Stock Transfer
                </h1>
            </div>
            <form action="{{ route('stock-transfers.store') }}" method="post" class="needs-validation" novalidate id="stockTransferForm">
                @csrf
                <div class="modal-body modal-body-advanced">
                    <div class="transfer-details-card p-4 mb-4">
                        <h3 class="mb-3 text-primary border-bottom pb-2 section-title">
                            <i class="bi bi-card-checklist me-2"></i>
                            Transfer Information
                        </h3>
                        <div class="row gy-4">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="from_branch_id" class="form-label12 fw-semibold">From Branch</label>
                                    <select class="form-control border-primary shadow-sm" id="from_branch_id" name="from_branch_id" required>
                                        <option value="">Select Source Branch</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select a source branch</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="to_branch_id" class="form-label12 fw-semibold">To Branch</label>
                                    <select class="form-control border-primary shadow-sm" id="to_branch_id" name="to_branch_id" required>
                                        <option value="">Select Destination Branch</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select a destination branch</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="transfer_date" class="form-label12 fw-semibold">Transfer Date</label>
                                    <input type="date" class="form-control border-primary shadow-sm" id="transfer_date" name="transfer_date" value="{{ date('Y-m-d') }}" required>
                                    <div class="invalid-feedback">Please select a transfer date</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="status" class="form-label12 fw-semibold">Status</label>
                                    <select class="form-control border-primary shadow-sm" id="status" name="status" required>
                                        <option value="pending" selected>Pending</option>
                                        <option value="in_transit">In Transit</option>
                                        <option value="completed">Completed</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                    <div class="invalid-feedback">Please select a status</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="remarks" class="form-label12 fw-semibold">Remarks</label>
                                    <textarea name="remarks" id="remarks" class="form-control border-primary shadow-sm" rows="2" placeholder="Transfer remarks"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="machinery-transfer-card p-4 mb-4">
                        <h3 class="mb-3 text-warning border-bottom pb-2 section-title">
                            <i class="bi bi-cpu me-2"></i>
                            Machinery Transfer
                        </h3>
                        <div id="machineryContainer">
                            <!-- Machinery rows will be added here -->
                        </div>
                        <button type="button" id="addMachinery" class="btn btn-warning mt-3">
                            <i class="bi bi-plus-circle"></i> Add Machinery
                        </button>
                        <div id="machineryError" class="text-danger mt-2 d-none">At least one machinery item is required</div>
                    </div>

                    <div class="accessories-transfer-card p-4">
                        <h3 class="mb-3 text-success border-bottom pb-2 section-title">
                            <i class="bi bi-plug me-2"></i>
                            Accessories Transfer
                        </h3>
                        <div id="accessoriesContainer">
                            <!-- Accessories rows will be added here -->
                        </div>
                        <button type="button" id="addAccessory" class="btn btn-success mt-3">
                            <i class="bi bi-plus-circle"></i> Add Accessory
                        </button>
                        <div id="accessoryError" class="text-danger mt-2 d-none">At least one accessory item is required</div>
                    </div>
                </div>
                <div class="modal-footer justify-content-start modal-footer-advanced">
                    <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow-sm" id="submitBtn">
                        <i class="bi bi-check-circle me-2"></i>Create Transfer
                    </button>
                    <button type="button" data-dismiss="modal" class="btn btn-outline-secondary px-5 py-2 fw-bold shadow-sm">
                        <i class="bi bi-x-circle me-2"></i>Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    :root {
        --primary-gradient: linear-gradient(90deg, #4b6cb7 0%, #182848 100%);
        --warning-gradient: linear-gradient(90deg, #ff9a9e 0%, #fad0c4 100%);
        --success-gradient: linear-gradient(90deg, #a1c4fd 0%, #c2e9fb 100%);
        --border-radius: 12px;
        --transition-speed: 0.3s;
    }

    .modal-advanced {
        background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
        border-radius: 24px;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .modal-header-advanced {
        background: var(--primary-gradient);
        color: white;
        border-top-left-radius: 24px;
        border-top-right-radius: 24px;
        padding: 1.5rem;
    }

    .modal-body-advanced {
        background: #ffffff;
        padding: 2rem;
    }

    .modal-footer-advanced {
        background: #f8f9fa;
        border-bottom-left-radius: 24px;
        border-bottom-right-radius: 24px;
        padding: 1.5rem;
    }

    .transfer-details-card,
    .machinery-transfer-card,
    .accessories-transfer-card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        margin-bottom: 1.5rem;
        transition: transform var(--transition-speed) ease;
    }

    .transfer-details-card:hover,
    .machinery-transfer-card:hover,
    .accessories-transfer-card:hover {
        transform: translateY(-2px);
    }

    .form-label12 {
        font-size: 0.95rem;
        color: #495057;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .form-control {
        border-radius: var(--border-radius);
        border: 1px solid #e0e0e0;
        transition: all var(--transition-speed);
    }

    .form-control:focus {
        border-color: #4b6cb7;
        box-shadow: 0 0 0 0.2rem rgba(75, 108, 183, 0.15);
    }

    .form-control.is-invalid {
        border-color: #dc3545;
    }

    .section-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #343a40;
        display: flex;
        align-items: center;
    }

    .item-row {
        background: #f9f9f9;
        border-radius: var(--border-radius);
        padding: 1rem;
        margin-bottom: 1rem;
        border-left: 4px solid #4b6cb7;
        transition: all var(--transition-speed);
    }

    .item-row:hover {
        background: #f0f4f8;
    }

    .btn-primary {
        background: var(--primary-gradient);
        border: none;
        transition: all var(--transition-speed);
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-warning {
        background: var(--warning-gradient);
        border: none;
        color: #343a40;
        transition: all var(--transition-speed);
    }

    .btn-warning:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-success {
        background: var(--success-gradient);
        border: none;
        color: #343a40;
        transition: all var(--transition-speed);
    }

    .btn-success:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .remove-item {
        transition: all var(--transition-speed);
    }

    .remove-item:hover {
        transform: scale(1.1);
    }

    /* Loading state */
    .btn-loading {
        position: relative;
        pointer-events: none;
    }

    .btn-loading:after {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        margin: -0.5em 0 0 -0.5em;
        width: 1em;
        height: 1em;
        border: 2px solid rgba(255, 255, 255, 0.5);
        border-radius: 50%;
        border-top-color: #fff;
        animation: spin 0.6s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>

<script>
    $(document).ready(function() {
        let accessoryIndex = 0;
        let machineryIndex = 0;
        let isSubmitting = false;

        // Initialize form validation
        initFormValidation();

        // Add accessory row
        $('#addAccessory').on('click', function() {
            accessoryIndex++;
            const row = `
            <div class="row gy-3 item-row accessory-row" id="accessory-row-${accessoryIndex}">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="form-label12 fw-semibold">Accessory</label>
                        <select class="form-control border-success shadow-sm" name="accessories[${accessoryIndex}][accessory_id]" required>
                            <option value="">Select Accessory</option>
                            @foreach ($accessories as $accessory)
                                <option value="{{ $accessory->id }}" data-quantity="{{ $accessory->quantity }}">
                                    {{ $accessory->name }} (Available: {{ $accessory->quantity }})
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Please select an accessory</div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label class="form-label12 fw-semibold">Quantity</label>
                        <input class="form-control border-success shadow-sm" 
                               name="accessories[${accessoryIndex}][quantity]" 
                               type="number" 
                               value="1" 
                               min="1"
                               required>
                        <div class="invalid-feedback">Please enter a valid quantity</div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label class="form-label12 fw-semibold">Serial Numbers</label>
                        <input class="form-control border-success shadow-sm" 
                               name="accessories[${accessoryIndex}][serial_numbers]" 
                               type="text" 
                               placeholder="Optional serial numbers">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label class="form-label12 fw-semibold">Condition</label>
                        <select class="form-control border-success shadow-sm" name="accessories[${accessoryIndex}][condition]" required>
                            <option value="new">New</option>
                            <option value="used">Used</option>
                            <option value="refurbished">Refurbished</option>
                            <option value="damaged">Damaged</option>
                        </select>
                        <div class="invalid-feedback">Please select a condition</div>
                    </div>
                </div>
                <div class="col-lg-1 d-flex align-items-end">
                    <button type="button" class="btn btn-outline-danger remove-item" data-row="accessory-row-${accessoryIndex}">
                        <i class="bi bi-x-circle"></i> Remove
                    </button>
                </div>
            </div>`;
            $('#accessoriesContainer').append(row);
            $('#accessoryError').addClass('d-none');
        });

        // Add machinery row
        $('#addMachinery').on('click', function() {
            machineryIndex++;
            const row = `
            <div class="row gy-3 item-row machinery-row" id="machinery-row-${machineryIndex}">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="form-label12 fw-semibold">Machinery</label>
                        <select class="form-control border-warning shadow-sm" name="machineries[${machineryIndex}][machinery_id]" required>
                            <option value="">Select Machinery</option>
                            @foreach ($machineries as $machinery)
                                <option value="{{ $machinery->id }}" data-quantity="{{ $machinery->quantity }}">
                                    {{ $machinery->name }} (Available: {{ $machinery->quantity }})
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Please select a machinery</div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label class="form-label12 fw-semibold">Quantity</label>
                        <input class="form-control border-warning shadow-sm" 
                               name="machineries[${machineryIndex}][quantity]" 
                               type="number" 
                               value="1" 
                               min="1"
                               required>
                        <div class="invalid-feedback">Please enter a valid quantity</div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label class="form-label12 fw-semibold">Serial Numbers</label>
                        <input class="form-control border-warning shadow-sm" 
                               name="machineries[${machineryIndex}][serial_numbers]" 
                               type="text" 
                               placeholder="Optional serial numbers">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label class="form-label12 fw-semibold">Condition</label>
                        <select class="form-control border-warning shadow-sm" name="machineries[${machineryIndex}][condition]" required>
                            <option value="new">New</option>
                            <option value="used">Used</option>
                            <option value="refurbished">Refurbished</option>
                            <option value="damaged">Damaged</option>
                        </select>
                        <div class="invalid-feedback">Please select a condition</div>
                    </div>
                </div>
                <div class="col-lg-1 d-flex align-items-end">
                    <button type="button" class="btn btn-outline-danger remove-item" data-row="machinery-row-${machineryIndex}">
                        <i class="bi bi-x-circle"></i> Remove
                    </button>
                </div>
            </div>`;
            $('#machineryContainer').append(row);
            $('#machineryError').addClass('d-none');
        });

        // Remove row
        $(document).on('click', '.remove-item', function() {
            const rowId = $(this).data('row');
            const $row = $(`#${rowId}`);
            
            $row.fadeOut(300, function() {
                $(this).remove();
                validateItemCount();
            });
        });

        // Validate quantity against available stock
        $(document).on('change', 'select[name*="[accessory_id]"], select[name*="[machinery_id]"]', function() {
            const maxQuantity = $(this).find('option:selected').data('quantity');
            const quantityInput = $(this).closest('.item-row').find('input[name*="[quantity]"]');
            quantityInput.attr('max', maxQuantity);
        });

        // Form submission handler
        $('#stockTransferForm').on('submit', function(e) {
            e.preventDefault();
            
            if (isSubmitting) return;
            
            // Validate form
            if (!this.checkValidity()) {
                e.stopPropagation();
                $(this).addClass('was-validated');
                validateItemCount();
                return;
            }
            
            // Validate at least one item exists
            if ($('.accessory-row').length === 0 && $('.machinery-row').length === 0) {
                $('#accessoryError').removeClass('d-none');
                $('#machineryError').removeClass('d-none');
                return;
            }
            
            // Add loading state
            isSubmitting = true;
            const $submitBtn = $('#submitBtn');
            $submitBtn.addClass('btn-loading');
            $submitBtn.prop('disabled', true);
            
            // Submit form
            this.submit();
        });

        // Initialize form validation
        function initFormValidation() {
            // Prevent default form submission
            $('#stockTransferForm').on('submit', function(e) {
                if (!this.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                $(this).addClass('was-validated');
            });
            
            // Add first row for each section
            $('#addAccessory').trigger('click');
            $('#addMachinery').trigger('click');
        }

        // Validate item count
        function validateItemCount() {
            if ($('.accessory-row').length === 0) {
                $('#accessoryError').removeClass('d-none');
            } else {
                $('#accessoryError').addClass('d-none');
            }
            
            if ($('.machinery-row').length === 0) {
                $('#machineryError').removeClass('d-none');
            } else {
                $('#machineryError').addClass('d-none');
            }
        }

        // Prevent same branch selection
        $('#from_branch_id, #to_branch_id').change(function() {
            const fromBranch = $('#from_branch_id').val();
            const toBranch = $('#to_branch_id').val();
            
            if (fromBranch && toBranch && fromBranch === toBranch) {
                alert('Source and destination branches cannot be the same');
                $(this).val('').focus();
            }
        });
    });
</script>