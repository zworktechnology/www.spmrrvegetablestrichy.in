@extends('layout.backend.auth')

@section('content')



   <div class="content">
      <div class="page-header">
         <div class="page-title">
            <h4>Add Purchase</h4>
         </div>
      </div>


      <div class="card">
         <div class="card-body">
            <div class="row">

               

               <div class="col-lg-16 col-sm-6 col-12">
                  <div class="form-group">
                     <label style="font-size:15px;padding-top: 5px;padding-bottom: 2px;">Supplier</label>
                     <select class="select">
                        <option value="" disabled selected hiddden>Select Supplier</option>
                           @foreach ($supplier as $suppliers)
                              <option value="{{ $suppliers->id }}">{{ $suppliers->name }}</option>
                           @endforeach
                     </select>
                  </div>
               </div>

               <div class="col-lg-16 col-sm-6 col-12">
                  <div class="form-group">
                     <label style="font-size:15px;padding-top: 5px;padding-bottom: 2px;">Branch</label>
                     <select class="select">
                        <option value="" disabled selected hiddden>Select Branch</option>
                           @foreach ($branch as $branches)
                              <option value="{{ $branches->id }}">{{ $branches->name }}</option>
                           @endforeach
                     </select>
                  </div>
               </div>

               <div class="col-lg-6 col-sm-6 col-12">
                  <div class="form-group">
                     <label style="font-size:15px;padding-top: 5px;padding-bottom: 2px;">Date</label>
                     <input type="date" name="date" placeholder="" value="{{ $today }}">
                  </div>
               </div>

               <div class="col-lg-6 col-sm-6 col-12">
                  <div class="form-group">
                     <label style="font-size:15px;padding-top: 5px;padding-bottom: 2px;">Time</label>
                     <input type="time" name="timenow" placeholder="" value="{{ $timenow }}">
                  </div>
               </div>

               
            </div>

<br/>
            <div class="row">
               <div class="table-responsive col-12">
                  <table class="table">
                     <thead>
                        <tr>
                           <th style="font-size:15px; width:28%;">Product</th>
                           <th style="font-size:15px; width:12%;">Bag</th>
                           <th style="font-size:15px; width:12%;">Kgs </th>
                           <th style="font-size:15px; width:18%;">Rate</th>
                           <th style="font-size:15px; width:20%;">Amount</th>
                           <th style="width:10%;"></th>
                        </tr>
                     </thead>
                     <tbody id="product_fields">
                        <tr>
                           <td class="productimgname">
                              <input type="hidden"id="purchase_detail_id"name="purchase_detail_id[]" />
                              <select class="select product_id"name="product_id[]" id="product_id"required>
                                 <option value="" selected hidden class="text-muted">Select Product</option>
                                    @foreach ($product as $products)
                                       <option value="{{ $products->id }}">{{ $products->name }}</option>
                                    @endforeach
                              </select>
                           </td>
                           <td><input type="text" class="form-control" id="bag" name="bag[]" placeholder="Bag" value="" required /></td>
                           <td><input type="text" class="form-control" id="kgs" name="kgs[]" placeholder="kgs" value="" required /></td>
                           <td><input type="text" class="form-control" id="price_per_kg" name="price_per_kg[]" placeholder="Price Per Kg" value="" required /></td>
                           <td class="text-end"><input type="text" class="form-control" id="total_price" name="total_price[]" placeholder="Amount" value="" required /></td>
                           <td>
                              <button style="width: 100px;"class="py-1 text-white font-medium rounded-lg text-sm  text-center btn btn-success"
                              type="button" id="addproductfields" value="Add">Add</button>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>





         </div>
      </div>






   </div>
   
<script language="JavaScript">

$(document).ready(function() {
   $("#addproductfields").click(function() {


      alert('');
   });
});


</script>

@endsection

