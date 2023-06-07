<div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="bankLargeModalLabel">Add new Bank</h5>
        </div>
        <div class="modal-body">
            <form autocomplete="off" method="POST" action="{{ route('bank.store') }}">
                @csrf
                <div class="row">
                    <div class="col-lg-6 col-sm-12 col-12">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" id="name" placeholder="Bank Name">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Details</label>
                            <textarea type="text" name="details" placeholder="Enter your Bank Details"></textarea>
                        </div>
                    </div>
                   
                    <hr>
                    <div class="col-lg-12 button-align">
                        <button type="submit" class="btn btn-submit me-2">Submit</button>
                        <a href="{{ route('bank.index') }}"><button type="button" class="btn btn-cancel" data-bs-dismiss="modal"
                            aria-label="Close">Cancel</button></a>
                    </div>
                </div>
            </form>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
