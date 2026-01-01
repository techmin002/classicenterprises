<div class="modal fade" id="acceptModal{{ $tool->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
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

                <div class="modal-body text-justify">

                    <input type="hidden" name="stock_issue_id" value="{{ $tool->id }}">
                    <!-- Branch Info -->
                    <div class="row">
                        <div class="col-md-4">
                            <label>From Branch</label>
                            <select name="from_branch_id" class="form-control" required>
                                <option value="">-- Select Branch --</option>
                                @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}">
                                    {{ $branch->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label>To Branch</label>
                            <input type="text" class="form-control" value="{{ $tool->user->branch->name ?? 'N/A'}}" readonly>
                            <input type="hidden" name="to_branch_id" value="{{ $tool->user->branch->id ?? '1' }}">
                        </div>

                        <div class="col-md-4">
                            <label>Transfer Date</label>
                            <input type="date" name="transfer_date" value="{{ date('Y-m-d') }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label>Status</label>
                            <select name="status" class="form-control" required>
                                <option value="pending">Pending</option>
                                <option value="in_transit">In Transit</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>

                        <div class="col-md-8">
                            <label>Remarks</label>
                            <textarea name="remarks" class="form-control" rows="2"></textarea>
                        </div>
                    </div>

                    <hr>

                    <!-- Requested Items -->
                    <h5 class="text-primary">Requested Items</h5>

                    <table class="table table-bordered mt-2 text-center">
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
                                <td>{{ $mach->machinery->name }}</td>
                                <td>
                                    <input type="number" name="machineries[{{ $i }}][quantity]" value="{{ $mach->quantity }}" min="1" class="form-control">

                                    <input type="hidden" name="machineries[{{ $i }}][machinery_id]" value="{{ $mach->machinery_id }}">

                                    <input type="hidden" name="machineries[{{ $i }}][condition]" value="used">
                                </td>
                            </tr>
                            @endforeach

                            {{-- Accessories --}}
                            @foreach ($tool->accessories as $i => $acc)
                            <tr>
                                <td>Accessory</td>
                                <td>{{ $acc->accessory->name }}</td>
                                <td>
                                    <input type="number" name="accessories[{{ $i }}][quantity]" value="{{ $acc->quantity }}" min="1" class="form-control">

                                    <input type="hidden" name="accessories[{{ $i }}][accessory_id]" value="{{ $acc->accessory_id }}">

                                    <input type="hidden" name="accessories[{{ $i }}][condition]" value="used">
                                </td>
                            </tr>
                            @endforeach

                            {{-- Technical Tools --}}
                            @foreach ($tool->technicalTools as $i => $tech)
                            <tr>
                                <td>Technical Tool</td>
                                <td>{{ $tech->technicalTool->tool_name }}</td>
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
                    <button type="submit" class="btn btn-success btn-sm">
                        Confirm & Transfer
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>
