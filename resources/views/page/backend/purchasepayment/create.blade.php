<div class="modal-dialog modal-l">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="purchasepaymentLargeModalLabel">Add new Payment</h5>
        </div>
        <div class="modal-body">
            <form autocomplete="off" method="POST" action="{{ route('purchasepayment.store') }}">
                @csrf

                <div class="row">
                    <div class="col-lg-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Date</label>
                            <input type="date" name="date" placeholder="" value="{{ $today }}" required>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Time</label>
                            <input type="time" name="time" placeholder="" value="{{ $timenow }}" required>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Supplier <span style="color: red;">*</span></label>
                            <select class="form-control js-example-basic-single select ppayment_supplier_id" name="supplier_id" id="supplier_id" required>
                                    <option value="" disabled selected hiddden>Select Supplier</option>
                                    @foreach ($supplier as $suppliers)
                                        <option value="{{ $suppliers->id }}">{{ $suppliers->name }}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Branch <span style="color: red;">*</span></label>
                            <select class="form-control js-example-basic-single select ppayment_branch_id" name="branch_id" id="branch_id" required>
                                    <option value="" disabled selected hiddden>Select Branch</option>
                                    @foreach ($allbranch as $branches)
                                        <option value="{{ $branches->id }}">{{ $branches->shop_name }}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="col-lg-12 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Old Balance</label>
                            <input type="text" name="oldblance" id="oldblance" readonly class="oldblance" style="color:red" placeholder="Enter Amount">
                            <input type="hidden" name="payment_purchase_id" id="payment_purchase_id" value=""/>
                        </div> 
                    </div>
                    <div class="col-lg-12 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Payable Amount <span style="color: red;">*</span></label>
                            <input type="text" name="payment_payableamount" id="payment_payableamount" class="payment_payableamount" placeholder="Enter Amount">
                        </div>
                    </div>

                    <div class="col-lg-12 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Pending</label>
                            <input type="text" name="payment_pending" id="payment_pending" readonly style="color:#d91617;font-weight: 700;font-size: 17px;" class="payment_pending" placeholder="Enter Amount">
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
