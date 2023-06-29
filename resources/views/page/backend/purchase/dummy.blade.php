<div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="todaystockLargeModalLabel{{ $p_data['branch_id'] }}">Today Stock</h5>
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
                              <div class="col-lg-8 col-sm-8 col-8 border">
                                 <span class="" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px; ">Product Name</span>
                              </div>
                              <div class="col-lg-2 col-sm-2 col-2 border">
                                 <span class="" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px; ">Purchase</span>
                              </div>
                              <div class="col-lg-2 col-sm-2 col-2 border">
                                 <span class="" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px; ">Sales</span>
                              </div>
                        </div>
                        <div class="row" style="background-color: lightgray">
                            <div class="col-lg-8 col-sm-8 col-8 border">
                            </div>
                            <div class="col-lg-1 col-sm-1 col-1 border">
                               <span class="" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px; ">Bag</span>
                            </div>
                            <div class="col-lg-1 col-sm-1 col-1 border">
                                <span class="" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px; ">Kg</span>
                             </div>
                             <div class="col-lg-1 col-sm-1 col-1 border">
                                <span class="" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px; ">Bag</span>
                             </div>
                            <div class="col-lg-1 col-sm-1 col-1 border">
                               <span class="" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px; ">Kg</span>
                            </div>
                      </div>
                        @foreach ($p_data['terms'] as $index => $terms_products)
                              @if ($terms_products['purchase_id'] == $p_data['id'])
                        <div class="row">
                              <div class="col-lg-8 col-sm-8 col-8 border">
                                 <span class=""style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px; ">{{ $terms_products['product_name']}}</span>
                              </div>
                              <div class="col-lg-1 col-sm-1 col-1 border">
                                <span class="" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px; ">0</span>
                             </div>
                             <div class="col-lg-1 col-sm-1 col-1 border">
                                 <span class="" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px; ">1</span>
                              </div>
                              <div class="col-lg-1 col-sm-1 col-1 border">
                                 <span class="" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px; ">12</span>
                              </div>
                             <div class="col-lg-1 col-sm-1 col-1 border">
                                <span class="" style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px; ">0</span>
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




