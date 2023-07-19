<div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="purchaseorderviewLargeModalLabel{{ $purchasedata['unique_key'] }}">Purchase Order Details</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">



        <div class="card">
            <div class="card-body">
               <div style="padding-bottom: 25px;">
               <h6 >Bill No : #<span style="font-weight:700;" class="purchaseorder_bill_no"></span></h6>

            </div>
         <div class="invoice-box table-height" style="max-width: 1600px;width:100%;overflow: auto;padding: 0;font-size: 14px;line-height: 24px;color: #555;">
               <div class="row">

                  <div class="col-lg-4 col-sm-3 col-12">
                     <div class="card">
                        <div class="card-body">
                        <span  class=""><font style="vertical-align: inherit;margin-bottom:25px;vertical-align: inherit;font-size:16px;color:#3a3435;font-weight:700;line-height: 35px; ">BASIC INFO</font></span><br>
                        <span style="font-size:14px; color:black;">Bill No: </span>&nbsp;&nbsp;&nbsp; #<span  class="purchaseorder_bill_no" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"></span><br>
                        <span style="font-size:14px; color:black;">Date: </span>&nbsp;&nbsp;&nbsp;<span  class="purchaseorder_date" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"></span><br>
                        <span style="font-size:14px; color:black;">Time: </span>&nbsp;&nbsp;&nbsp;<span  class="purchaseorder_time" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"></span><br>
                        <span style="font-size:14px; color:black;">Bank Name: </span>&nbsp;&nbsp;&nbsp;<span  class="purchaseorderbank_namedata" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"></span><br>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-4 col-sm-3 col-12">
                     <div class="card">
                        <div class="card-body">
                        <span  class=""><font style="vertical-align: inherit;margin-bottom:25px;vertical-align: inherit;font-size:16px;color:#3a3435;font-weight:700;line-height: 35px; ">SUPPLIER INFO</font></span><br>
                        <span style="font-size:14px; color:black;">Name: </span>&nbsp;&nbsp;&nbsp;<span  class="purchaseorder_suppliername" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"></span><br>
                        <span style="font-size:14px; color:black;">Contact No: </span>&nbsp;&nbsp;&nbsp;<span  class="purchaseordersupplier_contact_number" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"></span><br>
                        <span style="font-size:14px; color:black;">Shop Name: </span>&nbsp;&nbsp;&nbsp;<span  class="purchaseordersupplier_shop_name" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"></span><br>
                        <span style="font-size:14px; color:black;">Address: </span>&nbsp;&nbsp;&nbsp;<span  class="purchaseordersupplier_shop_address" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"></span><br>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-4 col-sm-3 col-12">
                     <div class="card">
                        <div class="card-body">
                        <span  class=""><font style="vertical-align: inherit;margin-bottom:25px;vertical-align: inherit;font-size:16px;color:#3a3435;font-weight:700;line-height: 35px; ">BRANCH INFO</font></span><br>
                        <span style="font-size:14px; color:black;">Name: </span>&nbsp;&nbsp;&nbsp;<span  class="purchaseorderbranchname" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"></span><br>
                        <span style="font-size:14px; color:black;">Contact No: </span>&nbsp;&nbsp;&nbsp;<span  class="purchaseorderbranch_contact_number" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"></span><br>
                        <span style="font-size:14px; color:black;">Shop Name: </span>&nbsp;&nbsp;&nbsp;<span  class="purchaseorderbranch_shop_name" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"></span><br>
                        <span style="font-size:14px; color:black;">Address: </span>&nbsp;&nbsp;&nbsp;<span  class="purchaseorderbranch_address" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"></span><br>
                        </div>
                     </div>
                  </div>








               </div>
               <div class="row">
                  <div class="col-lg-1"></div>
                  <div class="col-lg-9 col-9  col-sm-11">
                  <h7 style="color:black;font-weight:700;">PRODUCTS</h7>
                     <div class="row">


                                 <div class="col-lg-3 col-sm-3 col-12 border">
                                    <span class="" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px; ">Product</span>
                                 </div>
                                 <div class="col-lg-2 col-sm-3 col-12 border">
                                    <span class="" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px; ">Bag / Kg</span>
                                 </div>
                                 <div class="col-lg-2 col-sm-3 col-12 border">
                                    <span class="" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px; ">Count</span>
                                 </div>
                                 <div class="col-lg-2 col-sm-3 col-12 border">
                                    <span class="" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px; ">Price / Count</span>
                                 </div>
                                 <div class="col-lg-3 col-sm-3 col-12 border">
                                    <span class="" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px; ">Amount</span>
                                 </div>
                     </div>
                     <div class="row ">
                           @foreach ($purchasedata['terms'] as $index => $term_arr)
                              @if ($term_arr['purchase_id'] == $purchasedata['id'])
                                 <div class="col-lg-3 col-sm-3 col-12 border">
                                    <span class=""style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px; ">{{ $term_arr['product_name'] }}</span>
                                 </div>
                                 <div class="col-lg-2 col-sm-3 col-12 border">
                                    <span class=""style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px; ">{{ $term_arr['bag'] }}</span>
                                 </div>
                                 <div class="col-lg-2 col-sm-3 col-12 border">
                                    <span class=""style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px; ">{{ $term_arr['kgs'] }}</span>
                                 </div>
                                 <div class="col-lg-2 col-sm-3 col-12 border">
                                    <span class=""style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px; ">{{ $term_arr['price_per_kg'] }}</span>
                                 </div>
                                 <div class="col-lg-3 col-sm-3 col-12 border">
                                    <span class=""style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px; ">{{ $term_arr['total_price'] }}</span>
                                 </div>
                              @endif
                           @endforeach
                     </div>
                  </div>
                  <div class="col-lg-1 col-1 col-sm-12"></div>

               </div><br/>
               <div class="row">
                  <div class="col-lg-1 col-1"></div>
                  <div class="col-lg-9 col-9 col-sm-12">
                  <h7 style="color:black;font-weight:700;">EXTRA COST</h7>
                        <div class="row">
                           <div class="col-lg-7 col-sm-7 col-7 border">
                              <span class="" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px; ">Note</span>
                           </div>
                           <div class="col-lg-5 col-sm-4 col-4 border">
                              <span class="" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px; ">Extracost</span>
                           </div>
                        </div>
                        <div class="row">
                           @foreach ($purchasedata['Extracost_Arr'] as $index => $Extracost_Arr)
                              @if ($Extracost_Arr['purchase_id'] == $purchasedata['id'])
                           <div class="col-lg-7 col-sm-7 col-7 border">
                              <span class=""style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px; ">{{ $Extracost_Arr['extracost_note'] }}</span>
                           </div>
                           <div class="col-lg-5 col-sm-4 col-4 border">
                              <span class=""style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px; ">{{ $Extracost_Arr['extracost'] }}</span>
                           </div>
                           @endif
                           @endforeach
                        </div>
                  </div>
               </div>
<br/>

         </div>

         <div class="row">
            <div class="col-lg-6 ">
               <div class="total-order w-100 max-widthauto mb-4">
                  <ul>
                     <li class="total">
                        <h4>Total</h4>
                        <h5 class="">₹ <span  class="purchaseorder_total_amount"></span></h5>
                     </li>
                     <li class="total">
                        <h4>Commission Amount </h4>
                        <h5>₹ <span  class="purchaseorder_commision"></span></h5>
                     </li>
                     <li class="total">
                        <h4>Total Extra Cost </h4>
                        <h5>₹ <span  class="purchaseorder_extra_cost"></span></h5>
                     </li>
                     <li class="total">
                        <h4>Gross Amount</h4>
                        <h5>₹ <span  class="purchaseorder_grossamont"></span></h5>
                     </li>
                  </ul>
               </div>
            </div>
            <div class="col-lg-6 ">
               <div class="total-order w-100 max-widthauto mb-4">
                  <ul>
                  <li class="total">
                        <h4>Old Balance</h4>
                        <h5>₹ <span  class="purchaseorder_old_balance"></span></h5>
                     </li>
                     <li class="total">
                        <h4>Grand Total</h4>
                        <h5>₹ <span  class="purchaseorder_grand_total"></span></h5>
                     </li>
                     <li class="total">
                        <h4>Paid Amount</h4>
                        <h5 style="color:green">₹ <span  class="purchaseorder_paid_amount"></span></h5>
                     </li>
                     <li class="total">
                        <h4>Balance Amount</h4>
                        <h5 style="color:red">₹ <span  class="purchaseorder_balance_amount"></span></h5>
                     </li>
                  </ul>
               </div>
               </div>
            </div>
         </div>
   </div>


        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
