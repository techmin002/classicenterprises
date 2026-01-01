<!-- View Modal -->
<div class="modal fade" id="StockSendModal{{ $tool->id }}" tabindex="-1" role="dialog" aria-labelledby="StockSendModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content shadow-lg border-0 rounded-3 overflow-hidden">
            <div class="modal-header bg-gradient-primary text-white align-items-center">
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="font-size:2rem;">&times;</span>
                </button>
            </div>
            @forelse($issue->stockTransfers as $transfer)

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
                                    <span class="text-muted ml-2">{{ $transfer->user->name ?? 'N/A' }}</span>
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
                    <div class="col-md-12 mb-4 mb-md-0">
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
                                                <th>Image</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($transfer->accessories as $accessory)
                                            <tr>
                                                <td>{{ $accessory->name }}</td>
                                                <td><span class="badge badge-secondary px-2">{{ $accessory->pivot->quantity }}</span></td>
                                                <td>
                                                    @if (!empty($accessory->image))
                                                    <img src="{{ asset('upload/images/accessory/' . $accessory->image) }}" alt="Accessory Image" width="60">
                                                    @else
                                                    N/A
                                                    @endif
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
                    <div class="col-md-12">
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
                                                <th>Image</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($transfer->machineries as $machinery)
                                            <tr>
                                                <td>{{ $machinery->name }}</td>
                                                <td><span class="badge badge-secondary px-2">{{ $machinery->pivot->quantity }}</span></td>
                                                <td>
                                                    @if ($machinery->image ?? false)
                                                    <img src="{{ asset('upload/images/machinery/' . $machinery->image) }}" alt="Machinery Image" width="60">
                                                    @else
                                                    N/A
                                                    @endif
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
                    <div class="col-md-12">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-gradient-warning text-white d-flex align-items-center">
                                <i class="fas fa-cogs mr-2"></i>
                                <span class="font-weight-bold">Technical Tools</span>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover mb-0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Name</th>
                                                <th>Quantity</th>
                                                <th>Image</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($transfer->technicaltools as $data)
                                            <tr>
                                                <td>{{ $data->tool_name }}</td>
                                                <td><span class="badge badge-secondary px-2">{{ $data->pivot->quantity }}</span></td>
                                                <td>
                                                    @if ($data->image ?? false)
                                                    <img src="{{ asset('upload/images/technicaltools/' . $data->image) }}" alt="Tool Image" width="60">
                                                    @else
                                                    N/A
                                                    @endif
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">No Technical Tools</td>
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

            @empty
            <div class="text-center text-muted py-4">
                No Stock Transfer found for this Stock Issue
            </div>
            @endforelse
            <div class="modal-footer bg-gradient-light border-0">
                <button type="button" class="btn btn-outline-secondary px-4" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>
