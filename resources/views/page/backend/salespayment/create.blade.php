<div class="modal-dialog modal-l">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="salespaymentLargeModalLabel">Add new Payment</h5>
        </div>
        <div class="modal-body">
            <form autocomplete="off" method="POST" action="{{ route('salespayment.store') }}">
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
                            <label>Client <span style="color: red;">*</span></label>
                            <select class="form-control js-example-basic-single select spayment_customer_id" name="customer_id" id="customer_id" required>
                                    <option value="" disabled selected hiddden>Select Customer</option>
                                    @foreach ($customer as $customers)
                                        <option value="{{ $customers->id }}">{{ $customers->name }}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Branch</label>
                            <select class="form-control js-example-basic-single select spayment_branch_id" name="branch_id" id="branch_id" required>
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
                            <input type="text" name="sales_oldblance" id="sales_oldblance" readonly class="sales_oldblance" style="color:red" placeholder="Enter Amount">
                            <input type="hidden" name="payment_sales_id" id="payment_sales_id" value=""/>
                        </div>
                    </div>
                    <div class="col-lg-12 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Payable Amount</label>
                            <input type="text" name="spayment_payableamount" id="spayment_payableamount" class="spayment_payableamount" placeholder="Enter Amount">
                        </div>
                    </div>

                    <div class="col-lg-12 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Pending</label>
                            <input type="text" name="spayment_pending" id="spayment_pending" readonly style="color:#d91617;font-weight: 700;font-size: 17px;" class="spayment_pending" placeholder="Enter Amount">
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
