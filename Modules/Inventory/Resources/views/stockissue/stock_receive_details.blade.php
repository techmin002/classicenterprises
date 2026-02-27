<!-- Stock Receive Modal -->
@foreach ($stockIssues as $issue)
<div class="modal fade" id="StockReceiveModal{{ $issue->id }}" tabindex="-1" role="dialog" aria-labelledby="StockReceiveModalLabel{{ $issue->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('stock-issue.receive', $issue->id) }}" method="POST">

            @csrf
            <div class="modal-content">

                <!-- Header -->
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">Receive Stock</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    <input type="hidden" name="stock_issue_id" value="{{ $issue->id }}">

                    @php
                        $transfer = $issue->stockTransfers()->latest()->first();
                    @endphp

                    <p><strong>From Branch:</strong> {{ $transfer?->fromBranch->name ?? 'N/A' }}</p>
                    <p><strong>To Branch:</strong> {{ $transfer?->toBranch->name ?? $issue->branch->name ?? 'N/A' }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($transfer?->status ?? $issue->status) }}</p>
                    <hr>

                    <h5 class="text-primary mb-2">Items to Receive</h5>
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Name</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Machineries --}}
                            @foreach ($transfer?->machineries ?? [] as $mach)
                                <tr>
                                    <td>Machinery</td>
                                    <td>{{ $mach->name ?? 'N/A' }}</td>
                                    <td>{{ $mach->pivot->quantity ?? 0 }}</td>
                                </tr>
                            @endforeach

                            {{-- Accessories --}}
                            @foreach ($transfer?->accessories ?? [] as $acc)
                                <tr>
                                    <td>Accessory</td>
                                    <td>{{ $acc->name ?? 'N/A' }}</td>
                                    <td>{{ $acc->pivot->quantity ?? 0 }}</td>
                                </tr>
                            @endforeach

                            {{-- Technical Tools --}}
                            @foreach ($transfer?->technicaltools ?? [] as $tool)
                                <tr>
                                    <td>Technical Tool</td>
                                    <td>{{ $tool->tool_name ?? 'N/A' }}</td>
                                    <td>{{ $tool->pivot->quantity ?? 0 }}</td>
                                </tr>
                            @endforeach

                            {{-- Show message if no items --}}
                            @if(empty($transfer?->machineries) && empty($transfer?->accessories) && empty($transfer?->technicaltools))
                                <tr>
                                    <td colspan="3" class="text-center text-muted">No items sent yet.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <div class="form-group">
                        <label>Remarks / Notes (Optional)</label>
                        <textarea name="remarks" class="form-control" rows="2">{{ old('remarks') }}</textarea>
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    @if($transfer)
                        <button type="submit" class="btn btn-success btn-sm">Confirm Received</button>
                    @else
                        <button type="button" class="btn btn-secondary btn-sm" disabled>No Transfer Sent Yet</button>
                    @endif
                </div>

            </div>
        </form>
    </div>
</div>
@endforeach
