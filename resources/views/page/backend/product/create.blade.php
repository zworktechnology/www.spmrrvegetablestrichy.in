<div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="productLargeModalLabel">Add new Product</h5>
        </div>
        <div class="modal-body">
            <form autocomplete="off" method="POST" action="{{ route('product.store') }}">
                @csrf
                <div class="row">
                    <div class="col-lg-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" placeholder="Enter Product name">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Description</label>
                            <textarea type="text" name="description" placeholder="Enter Description"></textarea>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Available Stockin Bags</label>
                            <input type="text" name="available_stockin_bag" placeholder="Enter Available Stockin Bags">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Available Stockin Kilograms</label>
                            <input type="text" name="available_stockin_kilograms" placeholder="Enter Available Stockin Kilograms">
                        </div>
                    </div>
                    <hr>
                    <div class="col-lg-12 button-align">
                        <button type="submit" class="btn btn-submit me-2">Submit</button>
                        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal"
                            aria-label="Close">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
