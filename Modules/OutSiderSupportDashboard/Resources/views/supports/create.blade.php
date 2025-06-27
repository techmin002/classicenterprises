<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 shadow">

            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white">
                <div>
                    <h5 class="modal-title mb-0" id="exampleModalLabel">
                        <i class="fa fa-headset mr-2"></i> Create Support Ticket
                    </h5>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal Body -->
            <form action="{{ route('outsidersupportdashboard-task.store') }}" method="POST">
                @csrf
                <div class="modal-body row">
                    <div class="form-group col-md-6">
                        <label for="name" class="font-weight-bold">Customer Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="product" class="font-weight-bold">Product</label>
                        <input type="text" name="product" id="product" class="form-control" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="email" class="font-weight-bold">Email</label>
                        <input type="email" name="email" id="email" class="form-control">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="contact" class="font-weight-bold">Contact</label>
                        <input type="text" name="contact" id="contact" class="form-control" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="date" class="font-weight-bold">Date</label>
                        <input type="date" name="date" id="date" class="form-control" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="branch_id" class="font-weight-bold">Branch</label>
                        <select name="branch_id" id="branch_id" class="form-control" required>
                            <option value="" disabled selected>Select Branch</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="support_type" class="font-weight-bold">Support Type</label>
                        <select name="support_type" id="support_type" class="form-control" required>
                            <option value="" selected disabled>Select Support Type</option>
                            <option value="normal_service">Normal Service</option>
                            <option value="maintenance">Maintenance</option>
                            <option value="location_shifting">Location Shifting</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="priority" class="font-weight-bold">Priority</label>
                        <select name="priority" id="priority" class="form-control" required>
                            <option value="" selected disabled>Select Priority</option>
                            <option value="high">High</option>
                            <option value="medium">Medium</option>
                            <option value="low">Low</option>
                        </select>
                    </div>
                    <!-- FIXED: Service Address -->
                    <div class="form-group col-md-6">
                        <label for="address" class="font-weight-bold">Service Address</label>
                        <textarea name="address" id="address" class="form-control" rows="2" placeholder="Enter service address..."></textarea>
                    </div>

                    <!-- FIXED: Home Address -->
                    <div class="form-group col-md-6">
                        <label for="home_address" class="font-weight-bold">Home Address</label>
                        <textarea name="home_address" id="home_address" class="form-control" rows="2" placeholder="Enter home address..."></textarea>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="message" class="font-weight-bold">Message</label>
                        <textarea name="message" id="message" class="form-control" rows="3" placeholder="Enter message..."></textarea>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fa fa-times mr-1"></i> Close
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-paper-plane mr-1"></i> Create
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
