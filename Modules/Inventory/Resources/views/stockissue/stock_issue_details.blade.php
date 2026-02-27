<!-- View Modal -->
<div class="modal fade"
     id="viewModal{{ $issue->id }}"
     tabindex="-1"
     role="dialog"
     aria-labelledby="viewModalLabel{{ $issue->id }}"
     aria-hidden="true">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 shadow-lg">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Stock Issue Details</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body text-justify">

                {{-- Requested Info --}}
                <p><strong>Requested By:</strong> {{ $issue->user->name ?? 'N/A' }}</p>
                <p><strong>Branch:</strong> {{ $issue->branch->name ?? 'N/A' }}</p>
                <p><strong>Remark / Message:</strong> {{ $issue->message ?? '-' }}</p>
                <p><strong>Status:</strong> {{ ucfirst($issue->status) }}</p>
                <p><strong>Requested At:</strong> {{ $issue->created_at->format('d M Y, h:i A') }}</p>

                <hr>

                <h5 class="mb-3"><strong>Requested Items</strong></h5>
                <table class="table table-bordered table-striped text-center">
                    <thead>
                        <tr>
                            <th>S.N</th>
                            <th>Item Type</th>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Image</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $sn = 1; @endphp
                        @foreach ($issue->machineries as $mach)
                            <tr>
                                <td>{{ $sn++ }}</td>
                                <td>Machinery</td>
                                <td>{{ $mach->machinery->name ?? 'N/A' }}</td>
                                <td>{{ $mach->quantity }}</td>
                                <td>
                                    @if (!empty($mach->machinery->image))
                                        <img src="{{ asset('upload/images/machinery/' . $mach->machinery->image) }}" width="60">
                                    @else N/A @endif
                                </td>
                            </tr>
                        @endforeach

                        @foreach ($issue->accessories as $acc)
                            <tr>
                                <td>{{ $sn++ }}</td>
                                <td>Accessory</td>
                                <td>{{ $acc->accessory->name ?? 'N/A' }}</td>
                                <td>{{ $acc->quantity }}</td>
                                <td>
                                    @if (!empty($acc->accessory->image))
                                        <img src="{{ asset('upload/images/accessory/' . $acc->accessory->image) }}" width="60">
                                    @else N/A @endif
                                </td>
                            </tr>
                        @endforeach

                        @foreach ($issue->technicalTools as $tech)
                            <tr>
                                <td>{{ $sn++ }}</td>
                                <td>Technical Tool</td>
                                <td>{{ $tech->technicalTool->tool_name ?? 'N/A' }}</td>
                                <td>{{ $tech->quantity }}</td>
                                <td>
                                    @if (!empty($tech->technicalTool->image))
                                        <img src="{{ asset('upload/images/technicaltools/' . $tech->technicalTool->image) }}" width="60">
                                    @else N/A @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <hr>

                {{-- Transfer/Accept Details --}}
                @foreach($issue->stockTransfers as $transfer)
                    <h5 class="mb-2"><strong>Transfer #{{ $transfer->id }}</strong> 
                        ({{ ucfirst($transfer->status) }})</h5>
                    <p>
                        <strong>From:</strong> {{ $transfer->fromBranch->name ?? 'N/A' }} <br>
                        <strong>To:</strong> {{ $transfer->toBranch->name ?? 'N/A' }} <br>
                        <strong>Transfer Date:</strong> 
{{ $transfer->transfer_date ? \Carbon\Carbon::parse($transfer->transfer_date)->format('d M Y') : '-' }}

                        {{-- <strong>Transfer Date:</strong> {{ $transfer->transfer_date->format('d M Y') ?? '-' }} <br> --}}
                        <strong>Remarks:</strong> {{ $transfer->remarks ?? '-' }} <br>
                        <strong>Created At:</strong> 
{{ $transfer->created_at ? \Carbon\Carbon::parse($transfer->created_at)->format('d M Y, h:i A') : '-' }}


                        {{-- <strong>Created At:</strong> {{ $transfer->created_at->format('d M Y, h:i A') ?? '-' }} <br> --}}
                        @if($transfer->received_at)
                        <strong>Received At:</strong> 
{{ $transfer->received_at ? \Carbon\Carbon::parse($transfer->received_at)->format('d M Y, h:i A') : '-' }}
   
                        {{-- <strong>Received At:</strong> {{ $transfer->received_at->format('d M Y, h:i A') }} --}}
                        @endif
                    </p>

                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>Item Type</th>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Condition</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transfer->machineries as $mach)
                                <tr>
                                    <td>Machinery</td>
                                    <td>{{ $mach->name ?? 'N/A' }}</td>
                                    <td>{{ $mach->pivot->quantity ?? 0 }}</td>
                                    <td>{{ $mach->pivot->condition ?? '-' }}</td>
                                </tr>
                            @endforeach

                            @foreach($transfer->accessories as $acc)
                                <tr>
                                    <td>Accessory</td>
                                    <td>{{ $acc->name ?? 'N/A' }}</td>
                                    <td>{{ $acc->pivot->quantity ?? 0 }}</td>
                                    <td>{{ $acc->pivot->condition ?? '-' }}</td>
                                </tr>
                            @endforeach

                            @foreach($transfer->technicaltools as $tool)
                                <tr>
                                    <td>Technical Tool</td>
                                    <td>{{ $tool->tool_name ?? 'N/A' }}</td>
                                    <td>{{ $tool->pivot->quantity ?? 0 }}</td>
                                    <td>{{ $tool->pivot->condition ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <hr>
                @endforeach

            </div>
        </div>
    </div>
</div>
