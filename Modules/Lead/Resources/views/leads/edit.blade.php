<div class="modal fade" id="editCategory{{ $exp->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #08A4A4; color: #ffff;">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Leads </h1>
            </div>
            <form action="{{ route('leads.update',$exp->id) }}" id="expenseForm" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="container">
                        <div class="row gy-3">
                           
                            
                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Name</label>
                                <input class="form-control" placeholder="Enter name" type="text" value="{{ $exp->name }}" name="name" id="name">
                            </div>
                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Contact Number </label>
                                <input class="form-control" placeholder="Enter mobile number" value="{{ $exp->mobile }}" type="text" name="mobile" id="mobile">
                            </div>
                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Email</label>
                                <input class="form-control" placeholder="" type="email" value="{{ $exp->email }}" name="email">
                            </div>
                           
                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Address</label>
                                <input class="form-control" placeholder="" type="text" value="{{ $exp->address }}" name="address" id="address">
                            </div>
                            <div class="mt-3 col-lg-12">
                                <label class="form-label12">Message </label>
                                <textarea name="message" class="form-control" required id="">{{ $exp->message }}</textarea>
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