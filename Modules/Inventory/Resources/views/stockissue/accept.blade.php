<!-- Accept Stock Request Modal -->
@foreach ($stockIssues as $tool)
<div class="modal fade" id="acceptModal{{ $tool->id }}" tabindex="-1" role="dialog" aria-labelledby="acceptModalLabel{{ $tool->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('stock-issue.accept', $tool->id) }}" method="POST">
            @csrf
            <div class="modal-content">

                <!-- Header -->
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Accept Stock Request</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <!-- Body -->
                <div class="modal-body text-justify">
                    <input type="hidden" name="stock_issue_id" value="{{ $tool->id }}">
                    <input type="hidden" name="status" value="in_transit">

                    <!-- Branch Info -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>From Branch</label>
                            <select name="from_branch_id" class="form-control" required>
                                <option value="">-- Select Branch --</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label>To Branch</label>
                            <input type="text" class="form-control" value="{{ $tool->branch?->name ?? 'N/A' }}" readonly>
                            <input type="hidden" name="to_branch_id" value="{{ $tool->branch?->id }}">
                        </div>

                        <div class="col-md-4">
                            <label>Transfer Date</label>
                            <input type="date" name="transfer_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>

                    <!-- Remarks -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label>Remarks</label>
                            <textarea name="remarks" class="form-control" rows="2"></textarea>
                        </div>
                    </div>

                    <hr>

                    <!-- Requested Items -->
                    <h5 class="text-primary mb-2">Requested Items</h5>
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Name</th>
                                <th width="120">Quantity</th>
                            </tr>
                        </thead>
                        <tbody>

                            {{-- Machineries --}}
                            @foreach ($tool->machineries as $i => $mach)
                                <tr>
                                    <td>Machinery</td>
                                    <td>{{ $mach->machinery->name ?? 'N/A' }}</td>
                                    <td>
                                        <input type="number" name="machineries[{{ $i }}][quantity]" value="{{ $mach->quantity }}" min="1" class="form-control">
                                        <input type="hidden" name="machineries[{{ $i }}][machinery_id]" value="{{ $mach->machinery_id }}">
                                    </td>
                                </tr>
                            @endforeach

                            {{-- Accessories --}}
                            @foreach ($tool->accessories as $i => $acc)
                                <tr>
                                    <td>Accessory</td>
                                    <td>{{ $acc->accessory->name ?? 'N/A' }}</td>
                                    <td>
                                        <input type="number" name="accessories[{{ $i }}][quantity]" value="{{ $acc->quantity }}" min="1" class="form-control">
                                        <input type="hidden" name="accessories[{{ $i }}][accessory_id]" value="{{ $acc->accessory_id }}">
                                    </td>
                                </tr>
                            @endforeach

                            {{-- Technical Tools --}}
                            @foreach ($tool->technicalTools as $i => $tech)
                                <tr>
                                    <td>Technical Tool</td>
                                    <td>{{ $tech->technicalTool->tool_name ?? 'N/A' }}</td>
                                    <td>
                                        <input type="number" name="technical_tools[{{ $i }}][quantity]" value="{{ $tech->quantity }}" min="1" class="form-control">
                                        <input type="hidden" name="technical_tools[{{ $i }}][technical_tool_id]" value="{{ $tech->technical_tool_id }}">
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success btn-sm">Confirm & Transfer</button>
                </div>

            </div>
        </form>
    </div>
</div>
@endforeach
