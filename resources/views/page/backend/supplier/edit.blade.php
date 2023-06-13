<div class="modal-dialog modal-l">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="suppliereditLargeModalLabel{{ $suppliertdata['unique_key'] }}">Update Supplier</h5>
        </div>
        <div class="modal-body">
        <form autocomplete="off" method="POST"
                    action="{{ route('supplier.edit', ['unique_key' => $suppliertdata['unique_key']]) }}" enctype="multipart/form-data">
                   
                   @csrf
                <div class="row">
                    <div class="col-lg-12 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" placeholder="Enter Supplier name" value="{{ $suppliertdata['name'] }}">
                        </div>
                    </div>
                    <div class="col-lg-12 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Contact Number</label>
                            <input type="text" name="contact_number" placeholder="Enter Contact Number" value="{{ $suppliertdata['contact_number'] }}">
                        </div>
                    </div>
                    <div class="col-lg-12 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="text" name="email" placeholder="Enter Supplier email address" value="{{ $suppliertdata['email_address'] }}">
                        </div>
                    </div>
                    <div class="col-lg-12 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Shop Name</label>
                            <input type="text" name="shop_name" placeholder="Enter Shop Name" value="{{ $suppliertdata['shop_name'] }}">
                        </div>
                    </div>
                    <div class="col-lg-12 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Shop Address</label>
                            <input type="text" name="shop_address" placeholder="Enter Shop Address" value="{{ $suppliertdata['shop_address'] }}">
                        </div>
                    </div>
                    <div class="col-lg-12 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Shop Contact Number</label>
                            <input type="text" name="shop_contact_number" placeholder="Enter Shop Contact Number" value="{{ $suppliertdata['shop_contact_number'] }}">
                        </div>
                    </div>
                    <div class="col-lg-12 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Status</label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    <input class="form-check-input" type="radio" value="0"
                                        {{ $suppliertdata['status'] == 0 ? 'checked' : '' }}
                                        aria-label="Radio button for following text input" name="status">
                                </div>
                                <input type="text" class="form-control" value="Active">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-sm-6 col-12">
                        <div class="form-group">
                            <label style="color:white">Status</label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    <input class="form-check-input" type="radio" value="1"
                                        {{ $suppliertdata['status'] == 1 ? 'checked' : '' }}
                                        aria-label="Radio button for following text input" name="status">
                                </div>
                                <input type="text" class="form-control" value="De-Active">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="col-lg-12 button-align">
                        <button type="submit" class="btn btn-submit me-2">Update</button>
                        <a href="{{ route('supplier.index') }}">
                            <button type="button" class="btn btn-cancel" data-bs-dismiss="modal"
                                aria-label="Close">Cancel</button>
                        </a>
                    </div>
                </div>
            </form>
        </div>

        
    </div><!-- /.modal-content -->
</div>

 