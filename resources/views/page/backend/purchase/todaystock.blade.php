<div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="todaystockLargeModalLabel"><span style="color:green">PURCHASE - {{ $allbranches->shop_name }} STOCK</span></h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">
            <div class="card">
               <div class="card-body">
                  <div class="row">
                     <div class="col-lg-12 col-sm-12 col-12">
                        <div class="row" style="background-color: lightgray">
                              <div class="col-lg-3 col-sm-3 col-3 border">
                                 <span class="" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px; ">Date</span>
                              </div>
                              
                              <div class="col-lg-3 col-sm-3 col-3 border">
                                 <span class="" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px; ">Supplier</span>
                              </div>
                              <div class="col-lg-4 col-sm-4 col-4 border">
                                 <span class="" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px; ">Product Name</span>
                              </div>
                              <div class="col-lg-2 col-sm-2 col-2 border">
                                 <span class="" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px; ">Count</span>
                              </div>
                        </div>
                        
                      @foreach ($PSTodayStockArr as $keydata => $p_datas)
                      @if ($allbranches->id == $p_datas['branch_id'])


                        <div class="row">
                        
                              <div class="col-lg-3 col-sm-3 col-3 border">
                                 <span class=""style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px; ">{{date('d-m-Y', strtotime($p_datas['today']))}}</span>
                              </div>
                             
                              <div class="col-lg-3 col-sm-3 col-3 border">
                                 <span class="" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px; text-transform: uppercase;">{{$p_datas['Sales_Customer']}}</span>
                              </div>
                              <div class="col-lg-4 col-sm-4 col-4 border">
                                 <span class=""style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px; text-transform: uppercase;">{{$p_datas['product_name']}}</span>
                              </div>
                             <div class="col-lg-2 col-sm-2 col-2 border">
                                <span class="" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px; ">{{$p_datas['product_count']}} {{$p_datas['bag_kg']}}</span>
                             </div>
                        </div>
                        @endif
                        @endforeach
                        
                     </div>
                  </div>

               </div>
            </div>
         </div>


        
   </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->




