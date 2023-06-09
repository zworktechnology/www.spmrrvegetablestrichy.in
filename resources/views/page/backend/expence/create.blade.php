<div class="modal-dialog modal-l">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="customerLargeModalLabel">Add new Expence</h5>
        </div>
        <div class="modal-body">
            <form autocomplete="off" method="POST" action="{{ route('expence.store') }}">
                @csrf
                <div class="row">
                    <div class="col-lg-12 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Date</label>
                            <input type="date" name="date" value="{{ $today }}">
                        </div>
                    </div>
                    <div class="col-lg-12 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Time</label>
                            <input type="time" name="time" value="{{ $timenow }}">
                        </div>
                    </div>
                    <div class="col-lg-12 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Branch</label>
                            <select class="select" name="branch_id">
                                <option value="" disabled selected hiddden>Select Branch</option>
                                   @foreach ($branch as $branches)
                                      <option value="{{ $branches->id }}">{{ $branches->name }}</option>
                                   @endforeach
                             </select>
                        </div>
                    </div>
                    <div class="col-lg-12 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Amount</label>
                            <input type="text" name="amount" placeholder="Enter Amount">
                        </div>
                    </div>
                    <div class="col-lg-12 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Note</label>
                            <input type="text" name="note" placeholder="Enter Note">
                        </div>
                    </div>
                    <hr>
                    <div class="col-lg-12 button-align">
                        <button type="submit" class="btn btn-submit me-2">Submit</button>
                        <a href="{{ route('expence.index') }}"><button type="button" class="btn btn-cancel" data-bs-dismiss="modal"
                            aria-label="Close">Cancel</button></a>
                    </div>
                </div>
            </form>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
