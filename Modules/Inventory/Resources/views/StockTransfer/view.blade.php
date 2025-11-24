<div class="modal fade" id="viewTransfer{{ $transfer->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content shadow-lg border-0 rounded-3 overflow-hidden">
            <div class="modal-header bg-gradient-primary text-white align-items-center">
                <div class="d-flex align-items-center">
                    <span class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center mr-3" style="width:40px;height:40px;">
                        <i class="fas fa-exchange-alt fa-lg"></i>
                    </span>
                    <div>
                        <h5 class="modal-title mb-0 font-weight-bold">
                            Transfer Details <span class="text-light">#{{ $transfer->id }}</span>
                        </h5>
                        <small class="text-white-50">Detailed view of stock transfer</small>
                    </div>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="font-size:2rem;">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light px-4 py-4">
                <div class="row mb-4">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body py-3">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge badge-primary mr-2 px-2 py-1"><i class="fas fa-map-marker-alt"></i></span>
                                    <strong>From Branch:</strong>
                                    <span class="ml-2 text-primary">{{ $transfer->fromBranch->name }}</span>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge badge-success mr-2 px-2 py-1"><i class="fas fa-map-marker-alt"></i></span>
                                    <strong>To Branch:</strong>
                                    <span class="ml-2 text-success">{{ $transfer->toBranch->name }}</span>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge badge-info mr-2 px-2 py-1"><i class="fas fa-calendar-alt"></i></span>
                                    <strong>Date:</strong>
                                    <span class="ml-2 text-muted">{{ \Carbon\Carbon::parse($transfer->transfer_date)->translatedFormat('d M Y') }}</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="badge badge-secondary mr-2 px-2 py-1"><i class="fas fa-info-circle"></i></span>
                                    <strong>Status:</strong>
                                    <span class="ml-2">
                                        <span class="badge 
                                            @if($transfer->status == 'pending') badge-warning
                                            @elseif($transfer->status == 'in_transit') badge-info
                                            @elseif($transfer->status == 'completed') badge-success
                                            @elseif($transfer->status == 'cancelled') badge-danger
                                            @endif px-3 py-1 shadow-sm">
                                            {{ ucfirst($transfer->status) }}
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body py-3">
                                <div class="mb-2">
                                    <strong><i class="fas fa-comment-dots mr-2 text-secondary"></i>Remarks:</strong>
                                    <span class="text-muted ml-2">{{ $transfer->remarks ?? 'N/A' }}</span>
                                </div>
                                <div class="mb-2">
                                    <strong><i class="fas fa-user mr-2 text-secondary"></i>Created By:</strong>
                                    <span class="text-muted ml-2">{{ $transfer->created_by ?? 'N/A' }}</span>
                                </div>
                                <div>
                                    <strong><i class="fas fa-clock mr-2 text-secondary"></i>Created At:</strong>
                                    <span class="text-muted ml-2">{{ $transfer->created_at->format('d M Y H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="my-4">
                <div class="row">
                    <div class="col-md-6 mb-4 mb-md-0">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-gradient-primary text-white d-flex align-items-center">
                                <i class="fas fa-tools mr-2"></i>
                                <span class="font-weight-bold">Accessories</span>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover mb-0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Name</th>
                                                <th>Quantity</th>
                                                <th>Condition</th>
                                                <th>Serial Numbers</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($transfer->accessories as $accessory)
                                            <tr>
                                                <td>{{ $accessory->name }}</td>
                                                <td><span class="badge badge-light px-2">{{ $accessory->pivot->quantity }}</span></td>
                                                <td>
                                                    <span class="badge badge-pill 
                                                        @if($accessory->pivot->condition == 'good') badge-success
                                                        @elseif($accessory->pivot->condition == 'fair') badge-warning
                                                        @else badge-secondary
                                                        @endif">
                                                        {{ ucfirst($accessory->pivot->condition) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="text-monospace">{{ $accessory->pivot->serial_numbers ?? 'N/A' }}</span>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">No accessories</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-gradient-success text-white d-flex align-items-center">
                                <i class="fas fa-cogs mr-2"></i>
                                <span class="font-weight-bold">Machineries</span>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover mb-0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Name</th>
                                                <th>Quantity</th>
                                                <th>Condition</th>
                                                <th>Serial Numbers</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($transfer->machineries as $machinery)
                                            <tr>
                                                <td>{{ $machinery->name }}</td>
                                                <td><span class="badge badge-light px-2">{{ $machinery->pivot->quantity }}</span></td>
                                                <td>
                                                    <span class="badge badge-pill 
                                                        @if($machinery->pivot->condition == 'good') badge-success
                                                        @elseif($machinery->pivot->condition == 'fair') badge-warning
                                                        @else badge-secondary
                                                        @endif">
                                                        {{ ucfirst($machinery->pivot->condition) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="text-monospace">{{ $machinery->pivot->serial_numbers ?? 'N/A' }}</span>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">No machineries</td>
                                            </tr>
                                            @endforelse
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
                    <i class="fas fa-times mr-1"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>