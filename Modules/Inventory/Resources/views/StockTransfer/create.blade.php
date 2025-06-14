<div class="modal fade" id="createStockTransfer" tabindex="-1" role="dialog" aria-labelledby="createStockTransferLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #08A4A4; color: #ffff;">
                <h1 class="modal-title fs-5" id="createStockTransferLabel">Create Stock Transfer</h1>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="from_warehouse_id">From Warehouse</label>
                                <select name="from_warehouse_id" id="from_warehouse_id" class="form-control">
                                    <option value="">Select</option>
                                   
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="to_warehouse_id">To Warehouse</label>
                                <select name="to_warehouse_id" id="to_warehouse_id" class="form-control">
                                    <option value="">Select</option>
                                    
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="stock_transfer_date">Stock Transfer Date</label>
                                <input type="date" name="stock_transfer_date" id="stock_transfer_date" class="form-control"
                                    value="{{ old('stock_transfer_date') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="reference_no">Reference No</label>
                                <input type="text" name="reference_no" id="reference_no" class="form-control"
                                    value="{{ old('reference_no') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="remark">Remark</label>
                                <textarea name="remark" id="remark" class="form-control" rows="3">{{ old('remark') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary">Save Stock Transfer</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
