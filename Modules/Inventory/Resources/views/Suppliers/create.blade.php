<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #08A4A4; color: #ffff;">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Create Supplier</h1>
            </div>
            <form action="{{ route('suppliers_store') }}" id="supplierForm" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="row gy-3">

                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Name</label>
                                <input class="form-control" placeholder="Enter name" type="text" name="name" id="name" required>
                            </div>
                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Email</label>
                                <input class="form-control" placeholder="Enter email" type="email" name="email" id="email">
                            </div>
                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Contact Number</label>
                                <input class="form-control" placeholder="Enter contact number" type="tel" name="contact" id="contact"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 15);" maxlength="15">
                            </div>
                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Address</label>
                                <input class="form-control" placeholder="Enter address" type="text" name="address" id="address">
                            </div>
                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">PAN</label>
                                <input class="form-control" placeholder="Enter PAN number" type="text" name="pan" id="pan">
                            </div>
                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">VAT</label>
                                <input class="form-control" placeholder="Enter VAT number" type="text" name="vat" id="vat">
                            </div>
                              <div class="mt-3 col-lg-6">
                                <label class="form-label12">Branch ID</label>
                                <select class="form-control" name="branch_id">
                                    <option value="">Select Branch</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" name="created_by" value="{{ auth()->user()->id }}">
                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Status</label>
                                <select class="form-control" name="status">
                                    <option value="" selected>Select Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                             <div class="mt-3 col-lg-12">
                                <label class="form-label12">Description</label>
                                <textarea name="discription" class="form-control" id="discription" rows="3" placeholder="Enter discription"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-start">
                    <button type="submit" name="submit" id="btnSubmit" class="btn btn-success">Save Supplier</button>
                    <button type="button" data-dismiss="modal" class="btn btn-danger">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
