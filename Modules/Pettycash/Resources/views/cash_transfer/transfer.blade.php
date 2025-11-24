@php
    use Carbon\Carbon;
    $monthYear = Carbon::parse($req->date)->format('F Y'); // e.g., "July 2025"
    $dateOnly = Carbon::parse($req->date)->format('Y-m-d'); // original full date for hidden field
@endphp

<div class="modal fade" id="exampleModalCentercashtransfer{{ $req->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #0837a4; color: #ffff;">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Transfer Petty Cash</h1>
            </div>

            <form action="{{ route('petty-cash-transfer.store', $req->id) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="row gy-3">
                            <!-- Amount -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label12">Amount</label>
                                    <input class="form-control" placeholder="Enter Amount" type="number" name="amount"
                                        value="{{ $req->amount }}">
                                </div>
                            </div>

                            <!-- Month Display -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label12">Date (Month)</label>
                                    <input class="form-control" type="text" name="month_display"
                                        value="{{ $monthYear }}" readonly>
                                    <input type="hidden" name="month_compare_date" value="{{ $dateOnly }}">
                                </div>
                            </div>

                            <!-- Transfer Date -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label12">Date</label>
                                    <input class="form-control" placeholder="Select date" type="date" name="date">
                                </div>
                            </div>

                            <!-- Transfer Method -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label12">Transfer Method</label>
                                    <select name="transfer_method" class="form-control"
                                        onchange="toggleChequeField(this, {{ $req->id }})" required>
                                        <option value="">-- Select Method --</option>
                                        <option value="cash">Cash</option>
                                        <option value="cheque">Cheque</option>
                                        <option value="online">Online</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Cheque Number (hidden by default) -->
                            <div class="col-md-6 cheque-field cheque-field-{{ $req->id }}" style="display: none;">
                                <div class="form-group">
                                    <label class="form-label12">Cheque Number</label>
                                    <input type="text" class="form-control" name="cheque_number"
                                        placeholder="Enter Cheque Number">
                                </div>
                            </div>

                            <!-- Receipt Upload -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label12">Upload Receipt</label>
                                    <input type="file" class="form-control" name="receipt"
                                        accept="image/*,application/pdf">
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label12">Description</label>
                                    <textarea name="description" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="branch_id" value="{{ $req->branch_id }}">
                    </div>
                </div>

                <div class="modal-footer justify-content-start">
                    <button type="submit" class="btn btn-success">Transfer</button>
                    <button type="button" data-dismiss="modal" class="btn btn-danger">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JS for cheque toggle -->
<script>
    function toggleChequeField(select, id) {
        const chequeField = document.querySelector('.cheque-field-' + id);
        if (select.value === 'cheque') {
            chequeField.style.display = 'block';
        } else {
            chequeField.style.display = 'none';
        }
    }
</script>
