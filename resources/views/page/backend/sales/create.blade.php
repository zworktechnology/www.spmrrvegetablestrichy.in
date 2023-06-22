@extends('layout.backend.auth')

@section('content')

   <div class="content">
      <div class="page-header">
         <div class="page-title">
            <h4>Add Sales</h4>
         </div>
      </div>

      <div class="card">
         <div class="card-body">
         <form autocomplete="off" method="POST" action="{{ route('sales.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
               <div class="col-lg-3 col-sm-6 col-12">
                  <div class="form-group">
                     <label style="font-size:15px;padding-top: 5px;padding-bottom: 2px;">Bill No<span style="color: red;">*</span></label>
                     <input type="text" name="sales_billno" placeholder="Bill No" id="sales_billno" value="{{ $salesbillno }}" style="background-color: #e9ecef;" readonly>
                  </div>
               </div>
            </div>
            <div class="row">

               <div class="col-lg-3 col-sm-6 col-12">
                  <div class="form-group">
                     <label style="font-size:15px;padding-top: 5px;padding-bottom: 2px;">From Branch<span style="color: red;">*</span></label>
                     <select class="select sales_branch_id" name="sales_branch_id" id="sales_branch_id">
                        <option value="" disabled selected hiddden>Select Branch</option>
                           @foreach ($branch as $branches)
                              <option value="{{ $branches->id }}">{{ $branches->shop_name }}</option>
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
                              <option value="{{ $customer_array->id }}">{{ $customer_array->name }}</option>
                           @endforeach
                     </select>
                  </div>
               </div>



               <div class="col-lg-3 col-sm-6 col-12">
                  <div class="form-group">
                     <label style="font-size:15px;padding-top: 5px;padding-bottom: 2px;">Date<span style="color: red;">*</span></label>
                     <input type="date" name="sales_date" placeholder="" value="{{ $today }}">
                  </div>
               </div>

               <div class="col-lg-3 col-sm-6 col-12" hidden>
                  <div class="form-group">
                     <label style="font-size:15px;padding-top: 5px;padding-bottom: 2px;">Time<span style="color: red;">*</span></label>
                     <input type="time" name="sales_time" placeholder="" value="{{ $timenow }}">
                  </div>
               </div>



               <div class="col-lg-3 col-sm-6 col-12">
                  <div class="form-group">
                     <label style="font-size:15px;padding-top: 5px;padding-bottom: 2px;">Bank<span style="color: red;">*</span></label>
                     <select class="select" name="sales_bank_id" id="sales_bank_id">
                        <option value="" disabled selected hiddden>Select Bank</option>
                        @foreach ($bank as $banks)
                           <option value="{{ $banks->id }}">{{ $banks->name }}</option>
                        @endforeach
                     </select>
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
                           <th style="font-size:15px; width:12%;">Bag / Kg</th>
                           <th style="font-size:15px; width:12%;">Count </th>

                        </tr>
                     </thead>
                     <tbody id="sales_productfields">
                        <tr>
                           <td class="">
                              <input type="hidden"id="sales_detail_id"name="sales_detail_id[]" />
                              <select class=" form-control sales_product_id" name="sales_product_id[]" id="sales_product_id1"required>
                                 <option value="" selected hidden class="text-muted">Select Product</option>
                                    @foreach ($productlist as $productlists)
                                       <option value="{{ $productlists->id }}">{{ $productlists->name }}</option>
                                    @endforeach
                              </select>
                           </td>
                           <td><select class=" form-control sales_bagorkg" name="sales_bagorkg[]" id="sales_bagorkg1"required>
                                 <option value="" selected hidden class="text-muted">Select</option>
                                     <option value="bag">Bag</option>
                                    <option value="kg">Kg</option>
                              </select>
                           </td>
                           <td><input type="text" class="form-control sales_count" id="sales_count" name="sales_count[]" placeholder="count" value="" required /></td>
                           <td>
                              <button style="width: 35px;"class="py-1 text-white font-medium rounded-lg text-sm  text-center btn btn-primary"
                              type="button" id="addsalesproductfields" value="Add">+</button>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>

               <br/><br/>


            <div class="modal-footer">
            <input type="submit" class="btn btn-primary" onclick="salessubmitForm(this);"/>
               <a href="{{ route('sales.index') }}" class="btn btn-danger" value="">Cancel</a>
            </div>
         </form>







         </div>
      </div>
   </div>

@endsection
