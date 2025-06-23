<div class="modal fade" id="editTransfer{{ $transfer->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content shadow-lg border-0 rounded-3 overflow-hidden">
            <div class="modal-header bg-gradient-primary text-white align-items-center">
                <div class="d-flex align-items-center">
                    <span class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center mr-3" style="width:40px;height:40px;">
                        <i class="fas fa-edit fa-lg"></i>
                    </span>
                    <div>
                        <h5 class="modal-title mb-0 font-weight-bold">
                            Edit Transfer <span class="text-light">#{{ $transfer->id }}</span>
                        </h5>
                        <small class="text-white-50">Modify stock transfer details</small>
                    </div>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="font-size:2rem;">&times;</span>
                </button>
            </div>
            <form action="{{ route('stock-transfers.update', $transfer->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body bg-light px-4 py-4">
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body py-3">
                                    <div class="form-group">
                                        <label class="font-weight-bold text-primary"><i class="fas fa-map-marker-alt mr-2"></i>From Branch</label>
                                        <select class="form-control select2" name="from_branch_id" required>
                                            @foreach($branches as $branch)
                                                <option value="{{ $branch->id }}" {{ $transfer->from_branch_id == $branch->id ? 'selected' : '' }}>
                                                    {{ $branch->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold text-success"><i class="fas fa-map-marker-alt mr-2"></i>To Branch</label>
                                        <select class="form-control select2" name="to_branch_id" required>
                                            @foreach($branches as $branch)
                                                <option value="{{ $branch->id }}" {{ $transfer->to_branch_id == $branch->id ? 'selected' : '' }}>
                                                    {{ $branch->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body py-3">
                                    <div class="form-group">
                                        <label class="font-weight-bold"><i class="fas fa-calendar-alt mr-2 text-secondary"></i>Transfer Date</label>
                                        <input type="date" class="form-control" name="transfer_date" 
                                               value="{{ old('transfer_date', $transfer->transfer_date) }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold"><i class="fas fa-info-circle mr-2 text-secondary"></i>Status</label>
                                        <select class="form-control" name="status" required>
                                            <option value="pending" {{ $transfer->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="in_transit" {{ $transfer->status == 'in_transit' ? 'selected' : '' }}>In Transit</option>
                                            <option value="completed" {{ $transfer->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="cancelled" {{ $transfer->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="font-weight-bold"><i class="fas fa-comment-dots mr-2 text-secondary"></i>Remarks</label>
                        <textarea class="form-control" name="remarks" rows="2">{{ $transfer->remarks }}</textarea>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="row">
                        <div class="col-md-6 mb-4 mb-md-0">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-gradient-primary text-white d-flex align-items-center justify-content-between">
                                    <div>
                                        <i class="fas fa-tools mr-2"></i>
                                        <span class="font-weight-bold">Accessories</span>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-light add-accessory" data-transfer-id="{{ $transfer->id }}">
                                        <i class="fas fa-plus"></i> Add
                                    </button>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover mb-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Qty</th>
                                                    <th>Condition</th>
                                                    <th>Serial Numbers</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="accessories-container-{{ $transfer->id }}">
                                                @foreach($transfer->accessories as $index => $accessory)
                                                <tr>
                                                    <td>
                                                        <select class="form-control form-control-sm" name="accessories[{{ $index }}][accessory_id]" required>
                                                            <option value="">Select Accessory</option>
                                                            @foreach($accessories as $acc)
                                                                <option value="{{ $acc->id }}" 
                                                                    {{ $accessory->id == $acc->id ? 'selected' : '' }}
                                                                    data-quantity="{{ $acc->quantity }}">
                                                                    {{ $acc->name }} (Avail: {{ $acc->quantity }})
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control form-control-sm" 
                                                               name="accessories[{{ $index }}][quantity]" 
                                                               value="{{ $accessory->pivot->quantity }}" 
                                                               min="1" required>
                                                    </td>
                                                    <td>
                                                        <select class="form-control form-control-sm" name="accessories[{{ $index }}][condition]" required>
                                                            <option value="new" {{ $accessory->pivot->condition == 'new' ? 'selected' : '' }}>New</option>
                                                            <option value="used" {{ $accessory->pivot->condition == 'used' ? 'selected' : '' }}>Used</option>
                                                            <option value="refurbished" {{ $accessory->pivot->condition == 'refurbished' ? 'selected' : '' }}>Refurbished</option>
                                                            <option value="damaged" {{ $accessory->pivot->condition == 'damaged' ? 'selected' : '' }}>Damaged</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                               name="accessories[{{ $index }}][serial_numbers]"
                                                               placeholder="Enter Serial Numbers (comma separated)"
                                                               value="{{ $accessory->pivot->serial_numbers }}">
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-outline-danger remove-row">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-gradient-success text-white d-flex align-items-center justify-content-between">
                                    <div>
                                        <i class="fas fa-cogs mr-2"></i>
                                        <span class="font-weight-bold">Machineries</span>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-light add-machinery" data-transfer-id="{{ $transfer->id }}">
                                        <i class="fas fa-plus"></i> Add
                                    </button>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover mb-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Qty</th>
                                                    <th>Condition</th>
                                                    <th>Serial Numbers</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="machineries-container-{{ $transfer->id }}">
                                                @foreach($transfer->machineries as $index => $machinery)
                                                <tr>
                                                    <td>
                                                        <select class="form-control form-control-sm" name="machineries[{{ $index }}][machinery_id]" required>
                                                            <option value="">Select Machinery</option>
                                                            @foreach($machineries as $mach)
                                                                <option value="{{ $mach->id }}" 
                                                                    {{ $machinery->id == $mach->id ? 'selected' : '' }}
                                                                    data-quantity="{{ $mach->quantity }}">
                                                                    {{ $mach->name }} (Avail: {{ $mach->quantity }})
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control form-control-sm" 
                                                               name="machineries[{{ $index }}][quantity]" 
                                                               value="{{ $machinery->pivot->quantity }}" 
                                                               min="1" required>
                                                    </td>
                                                    <td>
                                                        <select class="form-control form-control-sm" name="machineries[{{ $index }}][condition]" required>
                                                            <option value="new" {{ $machinery->pivot->condition == 'new' ? 'selected' : '' }}>New</option>
                                                            <option value="used" {{ $machinery->pivot->condition == 'used' ? 'selected' : '' }}>Used</option>
                                                            <option value="refurbished" {{ $machinery->pivot->condition == 'refurbished' ? 'selected' : '' }}>Refurbished</option>
                                                            <option value="damaged" {{ $machinery->pivot->condition == 'damaged' ? 'selected' : '' }}>Damaged</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                               name="machineries[{{ $index }}][serial_numbers]"
                                                               placeholder="Enter Serial Numbers (comma separated)"
                                                               value="{{ $machinery->pivot->serial_numbers }}">
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-outline-danger remove-row">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-gradient-light border-0">
                    <button type="button" class="btn btn-outline-secondary px-4" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save mr-1"></i>Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize select2
    $('.select2').select2({
        width: '100%',
        theme: 'bootstrap4'
    });

    // Prepare accessory options HTML once
    const accessoryOptions = `
        <option value="">Select Accessory</option>
        @foreach($accessories as $acc)
            <option value="{{ $acc->id }}" data-quantity="{{ $acc->quantity }}">
                {{ $acc->name }} (Avail: {{ $acc->quantity }})
            </option>
        @endforeach
    `;

    // Prepare machinery options HTML once
    const machineryOptions = `
        <option value="">Select Machinery</option>
        @foreach($machineries as $mach)
            <option value="{{ $mach->id }}" data-quantity="{{ $mach->quantity }}">
                {{ $mach->name }} (Avail: {{ $mach->quantity }})
            </option>
        @endforeach
    `;

    // Add accessory row
    $('.add-accessory').click(function() {
        const transferId = $(this).data('transfer-id');
        const container = $('#accessories-container-' + transferId);
        const index = container.find('tr').length;

        const row = `
        <tr>
            <td>
                <select class="form-control form-control-sm" name="accessories[${index}][accessory_id]" required>
                    ${accessoryOptions}
                </select>
            </td>
            <td>
                <input type="number" class="form-control form-control-sm" 
                       name="accessories[${index}][quantity]" 
                       value="1" min="1" required>
            </td>
            <td>
                <select class="form-control form-control-sm" name="accessories[${index}][condition]" required>
                    <option value="new">New</option>
                    <option value="used">Used</option>
                    <option value="refurbished">Refurbished</option>
                    <option value="damaged">Damaged</option>
                </select>
            </td>
             <td>
                <input type="text" class="form-control form-control-sm"
                       name="accessories[${index}][serial_numbers]"
                       placeholder="Enter Serial Numbers (comma separated)">
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-outline-danger remove-row">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>`;

        container.append(row);
    });

    // Add machinery row
    $('.add-machinery').click(function() {
        const transferId = $(this).data('transfer-id');
        const container = $('#machineries-container-' + transferId);
        const index = container.find('tr').length;

        const row = `
        <tr>
            <td>
                <select class="form-control form-control-sm" name="machineries[${index}][machinery_id]" required>
                    ${machineryOptions}
                </select>
            </td>
            <td>
                <input type="number" class="form-control form-control-sm" 
                       name="machineries[${index}][quantity]" 
                       value="1" min="1" required>
            </td>
            <td>
                <select class="form-control form-control-sm" name="machineries[${index}][condition]" required>
                    <option value="new">New</option>
                    <option value="used">Used</option>
                    <option value="refurbished">Refurbished</option>
                    <option value="damaged">Damaged</option>
                </select>
            </td>
            <td>
                <input type="text" class="form-control form-control-sm"
                       name="machineries[${index}][serial_numbers]"
                       placeholder="Enter Serial Numbers (comma separated)">
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-outline-danger remove-row">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>`;

        container.append(row);
    });

    // Remove row
    $(document).on('click', '.remove-row', function() {
        $(this).closest('tr').remove();
    });

    // Update quantity max based on selected item
    $(document).on('change', 'select[name*="[accessory_id]"], select[name*="[machinery_id]"]', function() {
        const selectedOption = $(this).find('option:selected');
        const maxQuantity = selectedOption.data('quantity') || 0;
        const quantityInput = $(this).closest('tr').find('input[type="number"]');
        
        quantityInput.attr('max', maxQuantity);
        if (parseInt(quantityInput.val()) > maxQuantity) {
            quantityInput.val(maxQuantity);
        }
    });
});
</script>

<style>
    .select2-container--bootstrap4 .select2-selection--single {
        height: calc(1.5em + 0.75rem + 2px);
        padding: 0.375rem 0.75rem;
    }
    .select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow {
        height: calc(1.5em + 0.75rem + 2px);
    }
</style>
@endpush