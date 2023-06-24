@extends('layout.backend.auth')

@section('content')

   <div class="content">
      <div class="page-header">
         <div class="page-title">
            <h4>Update Sales</h4>
         </div>
      </div>

      <div class="card">
         <div class="card-body">
         <form autocomplete="off" method="POST" action="{{ route('sales.update', ['unique_key' => $SalesData->unique_key]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">
               <div class="col-lg-3 col-sm-6 col-12">
                  <div class="form-group">
                     <label style="font-size:15px;padding-top: 5px;padding-bottom: 2px;">From Branch<span style="color: red;">*</span></label>
                     <select class="select sales_branch_id" name="sales_branch_id" id="sales_branch_id">
                        <option value="" disabled selected hiddden>Select Branch</option>
                           @foreach ($branch as $branches)
                              <option value="{{ $branches->id }}"@if ($branches->id === $SalesData->branch_id) selected='selected' @endif>{{ $branches->name }}</option>
                           @endforeach
                     </select>
                  </div>
               </div>
            
               <div class="col-lg-3 col-sm-6 col-12">
                  <div class="form-group">
                     <label style="font-size:15px;padding-top: 5px;padding-bottom: 2px;">To Customer<span style="color: red;">*</span> </label>
                     <select class="select" name="sales_customerid" id="sales_customerid">
                        <option value="" disabled selected hiddden>Select Customer</option>
                           @foreach ($customer as $customer_array)
                              <option value="{{ $customer_array->id }}"@if ($customer_array->id === $SalesData->customer_id) selected='selected' @endif>{{ $customer_array->name }}</option>
                           @endforeach
                     </select>
                  </div>
               </div>

               <div class="col-lg-3 col-sm-6 col-12">
                  <div class="form-group">
                     <label style="font-size:15px;padding-top: 5px;padding-bottom: 2px;">Date<span style="color: red;">*</span></label>
                     <input type="date" name="sales_date" placeholder="" value="{{ $SalesData->date }}">
                  </div>
               </div>

               <div class="col-lg-3 col-sm-6 col-12">
                  <div class="form-group">
                     <label style="font-size:15px;padding-top: 5px;padding-bottom: 2px;">Time<span style="color: red;">*</span></label>
                     <input type="time" name="sales_time" placeholder="" value="{{ $SalesData->time }}">
                  </div>
               </div>

               
               

            

            </div>

            <br/>

            <div class="row">
               <div class="table-responsive col-12">
                  <table class="table">
                     <thead>
                           <button style="width: 35px;"class="py-1 text-white font-medium rounded-lg text-sm  text-center btn btn-primary"
                              type="button" id="addsalesproductfields" value="Add">+</button>
                        <tr>
                           <th style="font-size:15px; width:28%;">Product</th>
                           <th style="font-size:15px; width:12%;">Bag / Kg</th>
                           <th style="font-size:15px; width:12%;">Count </th>
                           
                        </tr>
                     </thead>
                     <tbody id="sales_productfields">
                     @foreach ($SalesProducts as $index => $Sales_Products)
                        <tr>
                           <td class="">
                              <input type="hidden"id="sales_detail_id"name="sales_detail_id[]" value="{{ $Sales_Products->id }}"/>
                              @foreach ($productlist as $products)
                                 @if ($products->id == $Sales_Products->productlist_id)
                                    <input type="text"class="form-control" name="product_name[]" value="{{ $products->name }}" readonly>
                                    <input type="hidden" id="sales_product_id" name="sales_product_id[]" value="{{ $Sales_Products->productlist_id }}" />
                                    
                                 @endif
                              @endforeach
                           </td>
                           <td><input type="text" class="form-control" id="sales_bagorkg" readonly name="sales_bagorkg[]" placeholder="Bag" value="{{ $Sales_Products->bagorkg }}" required /></td>
                           <td><input type="text" class="form-control sales_count" id="sales_count" readonly name="sales_count[]" placeholder="kgs" value="{{ $Sales_Products->count }}" required /></td>
                           <td><button style="width: 35px;" class="text-white font-medium rounded-lg text-sm  text-center btn btn-danger remove-salestr" type="button" >-</button>
                           </td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>

               <br/><br/>

            
            <div class="modal-footer">
               <input type="submit" class="btn btn-primary" name="submit" value="submit" />
               <a href="{{ route('sales.index') }}" class="btn btn-danger" value="">Cancel</a>
            </div>
         </form>


            




         </div>
      </div>
   </div>

@endsection
