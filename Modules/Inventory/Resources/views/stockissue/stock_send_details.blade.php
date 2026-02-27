<!-- Stock Send Modal -->
<div class="modal fade"
     id="StockSendModal{{ $issue->id }}"
     tabindex="-1"
     role="dialog"
     aria-hidden="true">

    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content shadow-lg border-0">

            <!-- Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    Stock Transfer Details
                </h5>
                <button type="button"
                        class="close text-white"
                        data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <!-- Body -->
            <div class="modal-body bg-light">

                @forelse($issue->stockTransfers as $transfer)

                    <!-- Transfer Info Card -->
                    <div class="card mb-4 shadow-sm border-0">
                        <div class="card-body">

                            <div class="row mb-3">

                                <div class="col-md-4">
                                    <strong>From Branch:</strong><br>
                                    <span class="text-primary">
                                        {{ $transfer->fromBranch->name ?? 'N/A' }}
                                    </span>
                                </div>

                                <div class="col-md-4">
                                    <strong>To Branch:</strong><br>
                                    <span class="text-success">
                                        {{ $transfer->toBranch->name ?? 'N/A' }}
                                    </span>
                                </div>

                                <div class="col-md-4">
                                    <strong>Date:</strong><br>
                                    {{ $transfer->transfer_date
                                        ? \Carbon\Carbon::parse($transfer->transfer_date)->format('d M Y')
                                        : 'N/A' }}
                                </div>

                            </div>

                            <div class="row mb-3">

                                <div class="col-md-4">
                                    <strong>Status:</strong><br>

                                    @switch($transfer->status)
                                        @case('pending')
                                            <span class="badge badge-warning">Pending</span>
                                            @break

                                        @case('in_transit')
                                            <span class="badge badge-info">In Transit</span>
                                            @break

                                        @case('completed')
                                            <span class="badge badge-success">Completed</span>
                                            @break

                                        @case('cancelled')
                                            <span class="badge badge-danger">Cancelled</span>
                                            @break
                                    @endswitch
                                </div>

                                <div class="col-md-4">
                                    <strong>Created By:</strong><br>
                                    {{ $transfer->creator->name ?? 'N/A' }}
                                </div>

                                <div class="col-md-4">
                                    <strong>Remarks:</strong><br>
                                    {{ $transfer->remarks ?? '-' }}
                                </div>

                            </div>

                        </div>
                    </div>

                    <!-- Accessories -->
                    <div class="card mb-3 shadow-sm">
                        <div class="card-header bg-info text-white">
                            Accessories
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-bordered table-sm text-center mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Qty</th>
                                        <th>Image</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transfer->accessories as $accessory)
                                        <tr>
                                            <td>{{ $accessory->name }}</td>
                                            <td>{{ $accessory->pivot->quantity }}</td>
                                            <td>
                                                @if(!empty($accessory->image))
                                                    <img src="{{ asset('upload/images/accessory/'.$accessory->image) }}"
                                                         width="60">
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-muted">
                                                No Accessories
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Machineries -->
                    <div class="card mb-3 shadow-sm">
                        <div class="card-header bg-success text-white">
                            Machineries
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-bordered table-sm text-center mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Qty</th>
                                        <th>Image</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transfer->machineries as $machinery)
                                        <tr>
                                            <td>{{ $machinery->name }}</td>
                                            <td>{{ $machinery->pivot->quantity }}</td>
                                            <td>
                                                @if(!empty($machinery->image))
                                                    <img src="{{ asset('upload/images/machinery/'.$machinery->image) }}"
                                                         width="60">
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-muted">
                                                No Machineries
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Technical Tools -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-warning">
                            Technical Tools
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-bordered table-sm text-center mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Qty</th>
                                        <th>Image</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transfer->technicaltools as $tool)
                                        <tr>
                                            <td>{{ $tool->tool_name }}</td>
                                            <td>{{ $tool->pivot->quantity }}</td>
                                            <td>
                                                @if(!empty($tool->image))
                                                    <img src="{{ asset('upload/images/technicaltools/'.$tool->image) }}"
                                                         width="60">
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-muted">
                                                No Technical Tools
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                @empty
                    <div class="text-center text-muted py-5">
                        No Stock Transfers found for this Stock Issue.
                    </div>
                @endforelse

            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>
