<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #08A4A4; color: #ffff;">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Request Leave</h1>
            </div>
            <form action="{{ route('leaves.store') }}" id="expenseForm" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="row gy-3">
                           
                            
                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Title</label>
                                <input class="form-control" placeholder="Enter Title" type="text" name="title" id="title">
                            </div>
                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Leave Type </label>
                                <select class="form-control" name="leave_type_id">
                                    <option value="" selected disabled>Select Leave Type</option>
                                    @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                                   @endforeach
                                </select>
                            </div>
                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Start Date</label>
                                <input class="form-control" placeholder="" type="date" name="start_date">
                            </div>
                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">End Date</label>
                                <input class="form-control" placeholder="" type="date" name="end_date" id="date">
                            </div>
                            <div class="mt-3 col-lg-12">
                                <label class="form-label12">Description </label>
                                <textarea name="description" class="form-control" required id=""></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-start">
    
                    <button type="submit" name="submit" id="btnSubmit" class="btn btn-success">Save Item</button>

                    <button type="cancel" data-dismiss="modal" class="btn btn-danger">Cancel</button>
                </div>
            </form>
        </div>
    </div>
  </div>