<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #08A4A4; color: #ffff;">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Create response</h1>
            </div>
            <form action="{{ route('response.store') }}" id="expenseForm" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="row gy-3">
                            <div class="mt-3 col-lg-12">
                                <label class="form-label12">Message </label>
                                <textarea name="message" class="form-control" required id=""></textarea>
                            </div>
                            <input type="hidden" name="lead_id" value="{{ $lead->id }}">
                            <div class="mt-3 col-lg-12">
                                <div class="form-group">
                                    <label>Date and time:</label>
                                      <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                          <input type="text" class="form-control datetimepicker-input" name="date_time" data-target="#reservationdatetime"/>
                                          <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
                                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                          </div>
                                      </div>
                                  </div>
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