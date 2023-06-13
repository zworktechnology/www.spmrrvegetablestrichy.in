<div class="modal-dialog modal-l">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="customercheckbalanceLargeModalLabel{{ $customertdata['unique_key'] }}">Total Balance Report - {{ $customertdata['name'] }}</h5>
            <a href="{{ route('customer.index') }}"><button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button></a>
        </div>
        <div class="modal-body">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        
                        <div class="col-lg-6 col-sm-6 col-6 border" style="vertical-align: inherit;vertical-align: inherit;font-size: 16px;color:black;font-weight: 600;line-height: 35px; ">Branch</div>
                        <div class="col-lg-6 col-sm-6 col-6 border" style="vertical-align: inherit;vertical-align: inherit;font-size: 16px;color:black;font-weight: 600;line-height: 35px; ">Balance Amount</div>
                    </div>
                    <div class="row">
                    @php
                        $total = 0;
                    @endphp
                    @foreach ($tot_balance_Arr as $keydata => $tot_balance_Array)
                     @if ($tot_balance_Array['customer_id'] == $customertdata['id'])

                     @php
                        $total += $tot_balance_Array['balance_amount'];
                    @endphp
                        
                        <div class="col-lg-6 col-sm-6 col-6 border" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px; "><span class="">{{ $tot_balance_Array['branch_name'] }}</span></div>
                        <div class="col-lg-6 col-sm-6 col-6 border" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px; ">₹ <span class="">{{ $tot_balance_Array['balance_amount'] }}</span></div>
                        @endif  
                        @endforeach
                    </div>
                    <div class="row">
                   
                        <div class="col-lg-6 col-sm-6 col-6 border" style="vertical-align: inherit;vertical-align: inherit;font-size: 16px;color:black;font-weight: 600;line-height: 35px; ">Total</div>
                        <div class="col-lg-6 col-sm-6 col-6 border" style="vertical-align: inherit;vertical-align: inherit;font-size: 16px;color:black;font-weight: 600;line-height: 35px; ">₹ <span class="suplier_totbalnce">{{ $total }}</span></div>
                    </div>
                </div>
            </div>
        
               
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
