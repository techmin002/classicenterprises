@extends('setting::layouts.master')

@section('title', 'Edit Stock Transfer')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('stock-transfers.index') }}">Stock Transfers</a></li>
        <li class="breadcrumb-item active">Edit Transfer #{{ $transfer->reference_number }}</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Stock Transfer #{{ $transfer->reference_number }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('stock-transfers.index') }}">Stock Transfers</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow">
                            <div class="card-header bg-primary text-white">
                                <h3 class="card-title">Edit Transfer Details</h3>
                            </div>
                            <form action="{{ route('stock-transfers.update', $transfer->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="card-body">
                                    <h3 class="mb-3 text-primary border-bottom pb-2 section-title">
                                        <i class="fas fa-exchange-alt me-2"></i>
                                        Transfer Information
                                    </h3>
                                    <div class="container-fluid">
                                        <div class="row gy-4">
                                            <div class="col-lg-4">
                                                <label class="form-label12 fw-semibold">From Branch</label>
                                                <select class="form-control border-primary shadow-sm select2" name="from_branch_id" required>
                                                    @foreach($branches as $branch)
                                                        <option value="{{ $branch->id }}" {{ $transfer->from_branch_id == $branch->id ? 'selected' : '' }}>
                                                            {{ $branch->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="form-label12 fw-semibold">To Branch</label>
                                                <select class="form-control border-primary shadow-sm select2" name="to_branch_id" required>
                                                    @foreach($branches as $branch)
                                                        <option value="{{ $branch->id }}" {{ $transfer->to_branch_id == $branch->id ? 'selected' : '' }}>
                                                            {{ $branch->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="form-label12 fw-semibold">Transfer Date</label>
                                                <input type="date" class="form-control border-primary shadow-sm" 
                                                    name="transfer_date" value="{{ $transfer->transfer_date }}" required>
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="form-label12 fw-semibold">Status</label>
                                                <select class="form-control border-primary shadow-sm" name="status" required>
                                                    <option value="pending" {{ $transfer->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="in_transit" {{ $transfer->status == 'in_transit' ? 'selected' : '' }}>In Transit</option>
                                                    <option value="completed" {{ $transfer->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                    <option value="cancelled" {{ $transfer->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-8">
                                                <label class="form-label12 fw-semibold">Remarks</label>
                                                <textarea name="remarks" class="form-control border-primary shadow-sm" rows="2">{{ $transfer->remarks }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <h3 class="mt-5 mb-3 text-success border-bottom pb-2 section-title">
                                        <i class="fas fa-plug me-2"></i>
                                        Accessories Transfer
                                    </h3>
                                    <div class="container-fluid">
                                        @foreach($transfer->accessories as $index => $accessory)
                                        <div class="row gy-4 item-row accessory-row" id="accessory-row-{{ $accessory->id }}">
                                            <div class="col-lg-3">
                                                <label class="form-label12 fw-semibold">Accessory Name</label>
                                                <select class="form-control border-success shadow-sm accessory-name" 
                                                    name="accessories[{{ $accessory->id }}][id]" required>
                                                    <option value="">Select Accessory</option>
                                                    @foreach($accessories as $acc)
                                                        <option value="{{ $acc->id }}" 
                                                            data-quantity="{{ $acc->quantity }}"
                                                            {{ $acc->id == $accessory->id ? 'selected' : '' }}>
                                                            {{ $acc->name }} (Avail: {{ $acc->quantity }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-2">
                                                <label class="form-label12 fw-semibold">Quantity</label>
                                                <input class="form-control border-success shadow-sm accessory-quantity" 
                                                    name="accessories[{{ $accessory->id }}][quantity]" 
                                                    value="{{ $accessory->pivot->quantity }}" type="number" min="1" required>
                                            </div>
                                            <div class="col-lg-3">
                                                <label class="form-label12 fw-semibold">Condition</label>
                                                <select class="form-control border-success shadow-sm" 
                                                    name="accessories[{{ $accessory->id }}][condition]" required>
                                                    <option value="new" {{ $accessory->pivot->condition == 'new' ? 'selected' : '' }}>New</option>
                                                    <option value="used" {{ $accessory->pivot->condition == 'used' ? 'selected' : '' }}>Used</option>
                                                    <option value="refurbished" {{ $accessory->pivot->condition == 'refurbished' ? 'selected' : '' }}>Refurbished</option>
                                                    <option value="damaged" {{ $accessory->pivot->condition == 'damaged' ? 'selected' : '' }}>Damaged</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-3">
                                                <label class="form-label12 fw-semibold">Serial Numbers</label>
                                                <input class="form-control border-success shadow-sm" 
                                                    name="accessories[{{ $accessory->id }}][serial_numbers]"
                                                    value="{{ $accessory->pivot->serial_numbers }}"
                                                    placeholder="Comma separated serial numbers">
                                            </div>
                                            <div class="col-lg-1 d-flex align-items-end">
                                                <button type="button" class="btn btn-sm btn-danger remove-item" 
                                                    data-row="accessory-row-{{ $accessory->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        @endforeach
                                        <div id="newAccessoryContainer"></div>
                                        <button type="button" id="addAccessory" class="btn btn-outline-success mt-3">
                                            <i class="fas fa-plus-circle"></i> Add Accessory
                                        </button>
                                    </div>

                                    <h3 class="mt-5 mb-3 text-warning border-bottom pb-2 section-title">
                                        <i class="fas fa-cogs me-2"></i>
                                        Machinery Transfer
                                    </h3>
                                    <div class="container-fluid">
                                        @foreach($transfer->machineries as $index => $machinery)
                                        <div class="row gy-4 item-row machinery-row" id="machinery-row-{{ $machinery->id }}">
                                            <div class="col-lg-3">
                                                <label class="form-label12 fw-semibold">Machinery Name</label>
                                                <select class="form-control border-warning shadow-sm machinery-name" 
                                                    name="machineries[{{ $machinery->id }}][id]" required>
                                                    <option value="">Select Machinery</option>
                                                    @foreach($machineries as $mach)
                                                        <option value="{{ $mach->id }}" 
                                                            data-quantity="{{ $mach->quantity }}"
                                                            {{ $mach->id == $machinery->id ? 'selected' : '' }}>
                                                            {{ $mach->name }} (Avail: {{ $mach->quantity }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-2">
                                                <label class="form-label12 fw-semibold">Quantity</label>
                                                <input class="form-control border-warning shadow-sm machinery-quantity" 
                                                    name="machineries[{{ $machinery->id }}][quantity]" 
                                                    value="{{ $machinery->pivot->quantity }}" type="number" min="1" required>
                                            </div>
                                            <div class="col-lg-3">
                                                <label class="form-label12 fw-semibold">Condition</label>
                                                <select class="form-control border-warning shadow-sm" 
                                                    name="machineries[{{ $machinery->id }}][condition]" required>
                                                    <option value="new" {{ $machinery->pivot->condition == 'new' ? 'selected' : '' }}>New</option>
                                                    <option value="used" {{ $machinery->pivot->condition == 'used' ? 'selected' : '' }}>Used</option>
                                                    <option value="refurbished" {{ $machinery->pivot->condition == 'refurbished' ? 'selected' : '' }}>Refurbished</option>
                                                    <option value="damaged" {{ $machinery->pivot->condition == 'damaged' ? 'selected' : '' }}>Damaged</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-3">
                                                <label class="form-label12 fw-semibold">Serial Numbers</label>
                                                <input class="form-control border-warning shadow-sm" 
                                                    name="machineries[{{ $machinery->id }}][serial_numbers]"
                                                    value="{{ $machinery->pivot->serial_numbers }}"
                                                    placeholder="Comma separated serial numbers">
                                            </div>
                                            <div class="col-lg-1 d-flex align-items-end">
                                                <button type="button" class="btn btn-sm btn-danger remove-item" 
                                                    data-row="machinery-row-{{ $machinery->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        @endforeach
                                        <div id="newMachineryContainer"></div>
                                        <button type="button" id="addMachinery" class="btn btn-outline-warning mt-3">
                                            <i class="fas fa-plus-circle"></i> Add Machinery
                                        </button>
                                    </div>
                                </div>

                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update Transfer
                                    </button>
                                    <a href="{{ route('stock-transfers.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        .form-label12 {
            font-size: 1.05rem;
            color: #222;
            margin-bottom: 0.3rem;
            letter-spacing: 0.5px;
        }
        
        .form-control {
            border-radius: 0.7rem;
            font-size: 1rem;
            transition: box-shadow 0.2s, border-color 0.2s;
        }
        
        .section-title {
            letter-spacing: 1px;
            font-size: 1.25rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .item-row {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 0.7rem;
            padding: 1rem;
            margin-bottom: 1rem;
            border: 1px solid #e0f7fa;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }
        
        .select2-container--default .select2-selection--single {
            height: calc(1.5em + 0.75rem + 2px);
            padding: 0.375rem 0.75rem;
            border: 1px solid #ced4da;
            border-radius: 0.7rem;
        }
    </style>

    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap4'
            });

            let accessoryIndex = {{ $transfer->accessories->count() }};
            let machineryIndex = {{ $transfer->machineries->count() }};

            // Add accessory row
            $('#addAccessory').click(function() {
                accessoryIndex++;
                const row = `
                <div class="row gy-4 item-row accessory-row" id="accessory-row-new-${accessoryIndex}">
                    <div class="col-lg-3">
                        <label class="form-label12 fw-semibold">Accessory Name</label>
                        <select class="form-control border-success shadow-sm accessory-name" name="new_accessories[${accessoryIndex}][id]" required>
                            <option value="">Select Accessory</option>
                            @foreach($accessories as $acc)
                                <option value="{{ $acc->id }}" data-quantity="{{ $acc->quantity }}">
                                    {{ $acc->name }} (Avail: {{ $acc->quantity }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <label class="form-label12 fw-semibold">Quantity</label>
                        <input class="form-control border-success shadow-sm accessory-quantity" 
                            name="new_accessories[${accessoryIndex}][quantity]" type="number" value="1" min="1" required>
                    </div>
                    <div class="col-lg-3">
                        <label class="form-label12 fw-semibold">Condition</label>
                        <select class="form-control border-success shadow-sm" 
                            name="new_accessories[${accessoryIndex}][condition]" required>
                            <option value="new">New</option>
                            <option value="used">Used</option>
                            <option value="refurbished">Refurbished</option>
                            <option value="damaged">Damaged</option>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label class="form-label12 fw-semibold">Serial Numbers</label>
                        <input class="form-control border-success shadow-sm" 
                            name="new_accessories[${accessoryIndex}][serial_numbers]"
                            placeholder="Comma separated serial numbers">
                    </div>
                    <div class="col-lg-1 d-flex align-items-end">
                        <button type="button" class="btn btn-sm btn-danger remove-item" 
                            data-row="accessory-row-new-${accessoryIndex}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>`;
                $('#newAccessoryContainer').append(row);
                
                // Set max quantity when accessory is selected
                $(`#accessory-row-new-${accessoryIndex} .accessory-name`).change(function() {
                    const maxQty = $(this).find(':selected').data('quantity');
                    $(this).closest('.accessory-row').find('.accessory-quantity').attr('max', maxQty);
                });
            });

            // Add machinery row
            $('#addMachinery').click(function() {
                machineryIndex++;
                const row = `
                <div class="row gy-4 item-row machinery-row" id="machinery-row-new-${machineryIndex}">
                    <div class="col-lg-3">
                        <label class="form-label12 fw-semibold">Machinery Name</label>
                        <select class="form-control border-warning shadow-sm machinery-name" name="new_machineries[${machineryIndex}][id]" required>
                            <option value="">Select Machinery</option>
                            @foreach($machineries as $mach)
                                <option value="{{ $mach->id }}" data-quantity="{{ $mach->quantity }}">
                                    {{ $mach->name }} (Avail: {{ $mach->quantity }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <label class="form-label12 fw-semibold">Quantity</label>
                        <input class="form-control border-warning shadow-sm machinery-quantity" 
                            name="new_machineries[${machineryIndex}][quantity]" type="number" value="1" min="1" required>
                    </div>
                    <div class="col-lg-3">
                        <label class="form-label12 fw-semibold">Condition</label>
                        <select class="form-control border-warning shadow-sm" 
                            name="new_machineries[${machineryIndex}][condition]" required>
                            <option value="new">New</option>
                            <option value="used">Used</option>
                            <option value="refurbished">Refurbished</option>
                            <option value="damaged">Damaged</option>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label class="form-label12 fw-semibold">Serial Numbers</label>
                        <input class="form-control border-warning shadow-sm" 
                            name="new_machineries[${machineryIndex}][serial_numbers]"
                            placeholder="Comma separated serial numbers">
                    </div>
                    <div class="col-lg-1 d-flex align-items-end">
                        <button type="button" class="btn btn-sm btn-danger remove-item" 
                            data-row="machinery-row-new-${machineryIndex}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>`;
                $('#newMachineryContainer').append(row);
                
                // Set max quantity when machinery is selected
                $(`#machinery-row-new-${machineryIndex} .machinery-name`).change(function() {
                    const maxQty = $(this).find(':selected').data('quantity');
                    $(this).closest('.machinery-row').find('.machinery-quantity').attr('max', maxQty);
                });
            });

            // Remove row
            $(document).on('click', '.remove-item', function() {
                const rowId = $(this).data('row');
                $(`#${rowId}`).remove();
            });

            // Set max quantity for existing items when changed
            $(document).on('change', '.accessory-name, .machinery-name', function() {
                const maxQty = $(this).find(':selected').data('quantity');
                $(this).closest('.item-row').find('.accessory-quantity, .machinery-quantity').attr('max', maxQty);
            });

            // Initialize max quantities for existing items
            $('.accessory-name, .machinery-name').each(function() {
                const maxQty = $(this).find(':selected').data('quantity');
                $(this).closest('.item-row').find('.accessory-quantity, .machinery-quantity').attr('max', maxQty);
            });
        });
    </script>
@endsection