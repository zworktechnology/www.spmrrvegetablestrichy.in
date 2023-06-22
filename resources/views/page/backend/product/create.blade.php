<div class="modal-dialog modal-l">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="productLargeModalLabel">Add new Product</h5>
        </div>
        <div class="modal-body">
            <form autocomplete="off" method="POST" action="{{ route('productlist.store') }}">
                @csrf
                <div class="row">
                    <div class="col-lg-12 col-sm-6 col-12" hidden>
                        <div class="form-group">
                            <label>Product</label>
                            <select class="select " name="productlist_id" id="productlist_id">
                                <option value="" disabled selected hiddden>Select Product</option>
                                @foreach ($productlistdata as $productlistdatas)
                                    <option value="{{ $productlistdatas->id }}">{{ $productlistdatas->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12 col-sm-6 col-12" hidden>
                        <div class="form-group">
                            <label>Branch</label>
                            <select class="select " name="branchid" id="branchid">
                                <option value="" disabled selected hiddden>Select Branch</option>
                                @foreach ($branch_data as $branch_datas)
                                    <option value="{{ $branch_datas->id }}">{{ $branch_datas->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Name <span style="color: red;">*</span></label>
                            <input type="text" name="name" placeholder="Enter name" required>
                        </div>
                    </div>
                    <div class="col-lg-12 col-sm-6 col-12" hidden>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea type="text" name="description" placeholder="Enter Description"></textarea>
                        </div>
                    </div>
                    <div class="col-lg-12 col-sm-6 col-12" hidden>
                        <div class="form-group">
                            <label>Available Stockin Kilograms</label>
                            <input type="text" name="available_stockin_kilograms" placeholder="Enter Available Stockin Kilograms">
                        </div>
                    </div>
                    <hr>
                    <div class="col-lg-12 button-align">
                        <button type="submit" class="btn btn-submit me-2">Submit</button>
                        <a href="{{ route('stockmanagement.index') }}"><button type="button" class="btn btn-cancel" data-bs-dismiss="modal"
                            aria-label="Close">Cancel</button></a>
                    </div>
                </div>
            </form>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
