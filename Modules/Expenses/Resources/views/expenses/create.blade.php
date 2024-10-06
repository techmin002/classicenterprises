<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #08A4A4; color: #ffff;">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Expenses </h1>
            </div>
            <form action="{{ route('expenses.store') }}" id="expenseForm" method="post">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="row gy-3">
                            <div class="col-lg-12" data-select2-id="select2-data-5-a5wr">
                                <label class="form-label12">Expense Type</label>
                                <select class="js-example-basic-single form-control select2-hidden-accessible" name="expense_type" data-select2-id="select2-data-1-5agx" id="type" tabindex="-1" aria-hidden="true">
                                <option value="1">Electricity</option>
                                <option value="2">Water</option>
                                <option value="3">Other</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label12">Vendor Name</label>
                                <input class="form-control" placeholder="Enter Vendor Name" type="text" name="vendor" id="vendor">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label12">Title</label>
                                <input class="form-control" placeholder="Enter Title" type="text" name="title" id="title">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label12">Date</label>
                                <input class="form-control" placeholder="" type="date" name="date" id="date">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label12">Mode of Payment </label>
                                <select class="form-select" name="mode">
                                    <option value="Cash">Cash</option>
                                    <option value="Card">Card</option>
                                    <option value="Upi">UPI</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label12">Amount (INR)</label>
                                <input class="form-control" placeholder="" type="text" name="amount">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-start">
    
                    <button type="submit" name="submit" id="btnSubmit" class="btn btn-success">Save Item</button>

                    <button type="cancel" data-dismiss="modal" class="btn btn-danger">Cancel</button>
                </div>
            </form>
            <span id="output"></span>
        </div>
    </div>
  </div>