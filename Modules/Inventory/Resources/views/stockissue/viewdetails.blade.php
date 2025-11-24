<!-- View Modal -->
<div class="modal fade" id="viewModal{{ $tool->id }}" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Stock Issued Details</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <p><strong>Requested By:</strong> {{ $tool->user->name ?? 'N/A' }}</p>
                <p><strong>Remark / Message:</strong> {{ $tool->message ?? '-' }}</p>

                <hr>
                <h5 class="mb-3"><strong>Issued Items</strong></h5>
                <table class="table table-bordered table-striped">
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

                        @foreach ($tool->machineries as $mach)
                            <tr>
                                <td>{{ $sn++ }}</td>
                                <td>Machinery</td>
                                <td>{{ $mach->machinery->name ?? 'N/A' }}</td>
                                <td>{{ $mach->quantity }}</td>
                                <td>
                                    @if ($mach->machinery->image ?? false)
                                        <img src="{{ asset('upload/images/machinery/' . $mach->machinery->image) }}"
                                            alt="Machinery Image" width="60">
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        @foreach ($tool->accessories as $acc)
                            <tr>
                                <td>{{ $sn++ }}</td>
                                <td>Accessory</td>
                                <td>{{ $acc->accessory->name ?? 'N/A' }}</td>
                                <td>{{ $acc->quantity }}</td>
                                <td>
                                    @if (!empty($acc->accessory->image))
                                        <img src="{{ asset('upload/images/accessory/' . $acc->accessory->image) }}"
                                            alt="Accessory Image" width="60">
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        @foreach ($tool->technicalTools as $tech)
                            <tr>
                                <td>{{ $sn++ }}</td>
                                <td>Technical Tool</td>
                                <td>{{ $tech->technicalTool->tool_name ?? 'N/A' }}</td>
                                <td>{{ $tech->quantity }}</td>
                                <td>
                                    @if ($tech->technicalTool->image ?? false)
                                        <img src="{{ asset('upload/images/technicaltools/' . $tech->technicalTool->image) }}"
                                            alt="Tool Image" width="60">
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
