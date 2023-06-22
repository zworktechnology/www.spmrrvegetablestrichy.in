@extends('layout.backend.auth')

@section('content')

   <div class="content">
      <div class="page-header">
         <div class="page-title">
            <h4>Update Purchase</h4>
         </div>
      </div>

      <div class="card">
         <div class="card-body">
         <form autocomplete="off" method="POST" action="{{ route('purchase.update', ['unique_key' => $PurchaseData->unique_key]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">
               <div class="col-lg-3 col-sm-3 col-12">
                  <div class="form-group">
                     <label style="font-size:15px;padding-top: 5px;padding-bottom: 2px;">Supplier<span style="color: red;">*</span> </label>
                     <select class="select" name="supplier_id" id="supplier_id">
                        <option value="" disabled selected hiddden>Select Supplier</option>
                           @foreach ($supplier as $suppliers)
                              <option value="{{ $suppliers->id }}"@if ($suppliers->id === $PurchaseData->supplier_id) selected='selected' @endif>{{ $suppliers->name }}</option>
                           @endforeach
                     </select>
                  </div>
               </div>

               <div class="col-lg-3 col-sm-3 col-12">
                  <div class="form-group">
                     <label style="font-size:15px;padding-top: 5px;padding-bottom: 2px;">Branch<span style="color: red;">*</span></label>
                     <select class="select" name="branch_id" id="branch_id">
                        <option value="" disabled selected hiddden>Select Branch</option>
                           @foreach ($branch as $branches)
                              <option value="{{ $branches->id }}"@if ($branches->id === $PurchaseData->branch_id) selected='selected' @endif>{{ $branches->name }}</option>
                           @endforeach
                     </select>
                  </div>
               </div>

               <div class="col-lg-3 col-sm-3 col-12">
                  <div class="form-group">
                     <label style="font-size:15px;padding-top: 5px;padding-bottom: 2px;">Date<span style="color: red;">*</span></label>
                     <input type="date" name="date" placeholder="" value="{{ $PurchaseData->date }}">
                  </div>
               </div>
               <div class="col-lg-3 col-sm-3 col-12">
                  <div class="form-group">
                     <label style="font-size:15px;padding-top: 5px;padding-bottom: 2px;">Time<span style="color: red;">*</span></label>
                     <input type="time" name="time" placeholder="" value="{{ $PurchaseData->time }}">
                  </div>
               </div>
            </div>

            <br/>

            <div class="row">
               <div class="table-responsive col-12">
                  <table class="table">
                     <thead>
                           <button style="width: 35px;"class="py-1 text-white font-medium rounded-lg text-sm  text-center btn btn-primary"
                              type="button" id="addproductfields" value="Add">+</button>
                        <tr>
                           <th style="font-size:15px; width:28%;">Product</th>
                           <th style="font-size:15px; width:12%;">Bag / Kg</th>
                           <th style="font-size:15px; width:12%;">Count </th>
                           
                        </tr>
                     </thead>
                     <tbody id="product_fields">
                     @foreach ($PurchaseProducts as $index => $Purchase_Products)
                        <tr>
                           <td class="">
                              <input type="hidden"id="purchase_detail_id"name="purchase_detail_id[]" value="{{ $Purchase_Products->id }}"/>
                              @foreach ($productlist as $products)
                                 @if ($products->id == $Purchase_Products->productlist_id)
                                    <input type="text"class="form-control" name="product_name[]" value="{{ $products->name }}" readonly>
                                    <input type="hidden" id="product_id" name="product_id[]" value="{{ $Purchase_Products->productlist_id }}" />
                                 @endif
                              @endforeach
                           </td>
                           <td><input type="text" class="form-control" id="bagorkg" readonly name="bagorkg[]" placeholder="bagorkg" value="{{ $Purchase_Products->bagorkg }}" required /></td>
                           <td><input type="text" class="form-control count" id="count" readonly name="count[]" placeholder="count" value="{{ $Purchase_Products->count }}" required /></td>
                           <td><button style="width: 35px;" class="text-white font-medium rounded-lg text-sm  text-center btn btn-danger remove-tr" type="button" >-</button>
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
               <a href="{{ route('purchase.index') }}" class="btn btn-danger" value="">Cancel</a>
            </div>
         </form>


            




         </div>
      </div>
   </div>

@endsection
