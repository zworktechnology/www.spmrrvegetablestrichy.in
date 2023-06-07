<div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="supplierLargeModalLabel">Add new Supplier</h5>
        </div>
        <div class="modal-body">
            <form autocomplete="off" method="POST" action="{{ route('supplier.store') }}">
                @csrf
                <div class="row">
                    <div class="col-lg-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" placeholder="Enter Supplier name">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Contact Number</label>
                            <input type="text" name="contact_number" placeholder="Enter Supplier Number">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="text" name="email" placeholder="Enter Supplier email address">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Shop Name</label>
                            <input type="text" name="shop_name" placeholder="Enter Shop Name">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Shop Address</label>
                            <input type="text" name="shop_address" placeholder="Enter Shop Address">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Shop Contact Number</label>
                            <input type="text" name="shop_contact_number" placeholder="Enter Shop Contact Number">
                        </div>
                    </div>
                    <hr>
                    <div class="col-lg-12 button-align">
                        <button type="submit" class="btn btn-submit me-2">Submit</button>
                        <a href="{{ route('supplier.index') }}"><button type="button" class="btn btn-cancel" data-bs-dismiss="modal"
                            aria-label="Close">Cancel</button></a>
                    </div>
                </div>
            </form>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
