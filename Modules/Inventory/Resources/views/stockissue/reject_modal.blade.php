@foreach ($stockIssues as $tool)
<!-- Reject Stock Issue Modal -->
<div class="modal fade" id="rejectModal{{ $tool->id }}" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel{{ $tool->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('stock-issue.reject', $tool->id) }}" method="POST">
            @csrf
            <div class="modal-content">

                <!-- Header -->
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Reject Stock Request</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Body -->
                <div class="modal-body text-justify">
                    <p><strong>Requested By:</strong> {{ $tool->user->name ?? 'N/A' }}</p>
                    <p><strong>Branch:</strong> {{ $tool->branch?->name ?? 'N/A' }}</p>
                    <hr>
                    <label for="reject_message_{{ $tool->id }}">Enter reason for rejection:</label>
                    <textarea name="message" class="form-control" id="reject_message_{{ $tool->id }}" rows="3" required></textarea>
                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-danger btn-sm">
                        Confirm Reject
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>
@endforeach
