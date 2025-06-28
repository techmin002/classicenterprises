<!-- Create EMI Plan Modal -->
<div class="modal fade" id="emiPlanCreateModal" tabindex="-1" role="dialog" aria-labelledby="emiPlanCreateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="emiPlanCreateModalLabel">Create New EMI Plan</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('emi.system.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <!-- Title -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Plan Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title" required placeholder="Enter plan title">
                            </div>
                        </div>

                        <!-- Duration -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="duration">Duration (Months) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="duration" name="duration" required min="1" placeholder="Enter duration in months">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Interest Rate -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="interest_rate">Interest Rate (%) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" step="0.01" min="0" class="form-control" id="interest_rate" name="interest_rate" required placeholder="Enter interest rate">
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status <span class="text-danger">*</span></label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label for="description">Description (Optional)</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter plan description"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info">Create Plan</button>
                </div>
            </form>
        </div>
    </div>
</div>
