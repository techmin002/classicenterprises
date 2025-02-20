<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #08A4A4; color: #ffff;">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Create Lead</h1>
            </div>
            <form action="{{ route('leads.store') }}" id="expenseForm" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="row gy-3">


                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Name</label>
                                <input class="form-control" placeholder="Enter name" type="text" name="name"
                                    id="name">
                            </div>
                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Email</label>
                                <input class="form-control" placeholder="" type="email" name="email">
                            </div>
                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Contact Number </label>
                                <input class="form-control" placeholder="Enter mobile number" type="tel"  oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" pattern="\d{10}"maxlength="10" name="mobile" id="mobile" required
                                title="Please enter exactly 10 digits">
                            </div>

                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Alternate Contact Number </label>
                                <input class="form-control" placeholder="Enter alternate mobile number" type="tel"  oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" pattern="\d{10}"maxlength="10" name="landline" id="landline"
                                title="Please enter exactly 10 digits">
                            </div>
                            <input type="hidden" name="type" value="{{ $type }}">

                            <div class="mt-3 col-lg-6">
                                <div class="form-group">
                                    <label>Next Followup Date:</label>
                                    <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input" name="date_time"
                                            data-target="#reservationdatetime" />
                                        <div class="input-group-append" data-target="#reservationdatetime"
                                            data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if(auth()->user()->role['name'] === 'Super Admin')
                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Branch</label>
                                <select name="branch_id" id="" class="form-control">
                                    <option value="" selected disabled>Select Branch</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            <div class="mt-3 col-lg-12">
                                <label class="form-label12">Address</label>
                                <input class="form-control" placeholder="" type="text" name="address" id="address">
                            </div>
                            <div class="mt-3 col-lg-12">
                                <label class="form-label12">Lead Source</label>
                                <input class="form-control" placeholder="Eg. Facebook, wahatsApp Etc." type="text" name="lead_source" id="lead_source">
                            </div>
                            <div class="mt-3 col-lg-12">
                                <label class="form-label12">Message </label>
                                <textarea name="message" class="form-control" required id=""></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-start">

                    <button type="submit" name="submit" id="btnSubmit" class="btn btn-success">Save Lead</button>

                    <button type="cancel" data-dismiss="modal" class="btn btn-danger">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
