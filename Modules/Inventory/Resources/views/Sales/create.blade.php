<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #08A4A4; color: #ffff;">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Create Sale</h1>
            </div>
            <form action="{{ route('sales_store') }}" id="saleForm" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="row gy-3">

                            <div class="col-md-6">
                                <label for="name" class="form-label">Costumer</label>
                                <select class="form-select" name="customer_id" id="customer_id">
                                    <option value="">Select Customer</option>
                                   
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="contact" class="form-label">Contact</label>
                                <input type="text" class="form-control" name="contact" id="contact"
                                    placeholder="Enter Contact Number">
                            </div>
                            <div class="col-md-6">
                                <label for="type" class="form-label">Type</label>
                                <select class="form-select" name="type" id="type">
                                    <option value="" selected>Select Type</option>
                                    <option value="Cash">Vendor</option>
                                    <option value="Credit">Customer</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="paid" class="form-label">Paid</label>
                                <input type="number" class="form-control" name="paid" id="paid"
                                    placeholder="Enter Paid Amount">
                            </div>
                            <div class="col-md-6">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" class="form-control" name="price" id="price"
                                    placeholder="Enter Total Price">
                            </div>
                            <div class="col-md-6">
                                <label for="pending" class="form-label">Pending</label>
                                <input type="number" class="form-control" name="pending" id="pending"
                                    placeholder="Enter Pending Amount">
                            </div>
                            <div class="col-md-6">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control" name="date" id="date"
                                    placeholder="Enter Sale Date">
                            </div>
                            <div class="col-md-6">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" name="status" id="status">
                                    <option value="" selected>Select Status</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Cancelled">Cancelled</option>
                                </select>
                            </div>

                            </div>
                               
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-start">
                    <button type="submit" name="submit" id="btnSubmit" class="btn btn-success">Save Sale</button>
                    <button type="button" data-dismiss="modal" class="btn btn-danger">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
