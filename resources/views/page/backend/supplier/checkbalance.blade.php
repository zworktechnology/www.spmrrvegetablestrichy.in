<div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="checkbalanceLargeModalLabel">Total Balance Report - {{ $suppliertdata['name'] }}</h5>
            <a href="{{ route('supplier.index') }}"><button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button></a>
        </div>
        <div class="modal-body">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 col-sm-6 col-12 border" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px; ">S.No</div>
                        <div class="col-lg-4 col-sm-6 col-12 border" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px; ">Branch</div>
                        <div class="col-lg-4 col-sm-6 col-12 border" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px; ">Balance Amount</div>
                    </div>
                    <div class="row">
                    @foreach ($alldata_branch as $keydata => $alldata_branchss)
                        <div class="col-lg-4 col-sm-6 col-12 border" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px; "><span class="">{{ ++$keydata }}</span></div>
                        <div class="col-lg-4 col-sm-6 col-12 border" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px; "><span class="">{{ $alldata_branchss->name }}</span></div>
                        <div class="col-lg-4 col-sm-6 col-12 border" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px; ">₹ <span class="supplier_balance{{ $keydata }}"></span></div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-sm-6 col-12 border" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px; "></div>
                        <div class="col-lg-4 col-sm-6 col-12 border" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px; ">Total</div>
                        <div class="col-lg-4 col-sm-6 col-12 border" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px; ">₹ <span class="suplier_totbalnce"></span></div>
                    </div>
                </div>
            </div>
        
               
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
