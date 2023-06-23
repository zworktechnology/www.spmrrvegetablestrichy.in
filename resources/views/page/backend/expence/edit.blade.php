<div class="modal-dialog modal-l">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="expenceeditLargeModalLabel{{ $expenceData['unique_key'] }}">Update Expence</h5>
        </div>
        <div class="modal-body">
            <form autocomplete="off" method="POST"
                action="{{ route('expence.edit', ['unique_key' => $expenceData['unique_key']]) }}"
                enctype="multipart/form-data">

                @csrf
                <div class="row">
                    <div class="col-lg-12 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Date <span style="color: red;">*</span></label>
                            <input type="date" name="date" value="{{ $expenceData['date'] }}">
                        </div>
                    </div>
                    <div class="col-lg-12 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Time <span style="color: red;">*</span></label>
                            <input type="time" name="time" value="{{ $expenceData['time'] }}">
                        </div>
                    </div>
                    <div class="col-lg-12 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Branch <span style="color: red;">*</span></label>
                            <select class="select" name="branch_id">
                                <option value="" disabled selected hiddden>Select Branch</option>
                                   @foreach ($branch as $branches)
                                      <option value="{{ $branches->id }}" @if ($branches->id === $expenceData['branch_id']) selected='selected' @endif>{{ $branches->shop_name }}</option>
                                   @endforeach
                             </select>
                        </div>
                    </div>
                    <div class="col-lg-12 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Amount <span style="color: red;">*</span></label>
                            <input type="text" name="amount" placeholder="Enter Amount" value="{{ $expenceData['amount'] }}">
                        </div>
                    </div>
                    <div class="col-lg-12 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Note <span style="color: red;">*</span></label>
                            <input type="text" name="note" placeholder="Enter Note" value="{{ $expenceData['note'] }}">
                        </div>
                    </div>
                    <hr>
                    <div class="col-lg-12 button-align">
                        <button type="submit" class="btn btn-submit me-2">Update</button>
                            <button type="button" class="btn btn-cancel" data-bs-dismiss="modal"
                                aria-label="Close">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
