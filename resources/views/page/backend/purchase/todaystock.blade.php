<div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="todaystockLargeModalLabel{{ $allbranches->id }}">Today Stock</h5>
            <a><button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button></a>
        </div>

        <div class="modal-body">
            <div class="card">
               <div class="card-body">
                  

                  <div class="row">
                     <div class="col-lg-6  col-sm-6 col-6">
                        <div class="row" style="background: #969fde;">
                              <div class="col-lg-8 col-sm-8 col-8 border">
                                 <span class="" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px; ">Received Product</span>
                              </div>
                              <div class="col-lg-2 col-sm-2 col-2 border">
                                 <span class="" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px; ">Bag / Kg</span>
                              </div>
                              <div class="col-lg-2 col-sm-2 col-2 border">
                                 <span class="" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px; ">Count</span>
                              </div>
                        </div>
                        @foreach ($purchase_data as $keydata => $p_datas)
                        @foreach ($p_datas['terms'] as $keydata => $terms_arr)
                        @if ($terms_arr['purchase_id'] == $p_datas['id'])
                        @if ($allbranches->id == $p_datas['branch_id'])
                        <div class="row">
                              <div class="col-lg-8 col-sm-8 col-8 border">
                                 <span class=""style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px; ">{{ $terms_arr['product_name']}}</span>
                              </div>
                              <div class="col-lg-2 col-sm-2 col-2 border">
                                 <span class=""style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px; ">{{ $terms_arr['bag']}}</span>
                              </div>
                              <div class="col-lg-2 col-sm-2 col-2 border">
                                 <span class=""style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px; ">{{ $terms_arr['kgs']}}</span>
                              </div>
                        </div>
                        @endif
                        @endif
                        @endforeach
                           @endforeach
                     </div>
                     <div class="col-lg-6  col-sm-6 col-6">
                        
                        <div class="row" style="background: #22bf46;">
                              <div class="col-lg-8 col-sm-8 col-8 border">
                                 <span class="" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px; ">Sold Product</span>
                              </div>
                              <div class="col-lg-2 col-sm-2 col-2 border">
                                 <span class="" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px; ">Bag / Kg</span>
                              </div>
                              <div class="col-lg-2 col-sm-2 col-2 border">
                                 <span class="" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px; ">Count</span>
                              </div>
                        </div>
                        @if($salesbranchwise_terms != "")
                        @foreach ($salesbranchwise_terms as $keydata => $salesbranchwise_term_arr)
                        @if ($allbranches->id == $salesbranchwise_term_arr['branch_id'])
                        <div class="row">
                              <div class="col-lg-8 col-sm-8 col-8 border">
                                 <span class=""style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px; ">{{ $salesbranchwise_term_arr['product_name']}}</span>
                              </div>
                              <div class="col-lg-2 col-sm-2 col-2 border">
                                 <span class=""style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px; ">{{ $salesbranchwise_term_arr['bag']}}</span>
                              </div>
                              <div class="col-lg-2 col-sm-2 col-2 border">
                                 <span class=""style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px; ">{{ $salesbranchwise_term_arr['kgs']}}</span>
                              </div>
                        </div>
                        @endif
                        
                        @endforeach
                        @endif
                     </div>
                  </div>

               </div>
            </div>
         </div>


        
   </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
