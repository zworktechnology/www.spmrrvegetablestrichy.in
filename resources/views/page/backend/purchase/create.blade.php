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
         <form autocomplete="off" method="POST" action="{{ route('purchase.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
            
               <div class="col-lg-16 col-sm-6 col-12">
                  <div class="form-group">
                     <label style="font-size:15px;padding-top: 5px;padding-bottom: 2px;">Supplier<span style="color: red;">*</span> </label>
                     <select class="select" name="supplier_id" id="supplier_id">
                        <option value="" disabled selected hiddden>Select Supplier</option>
                           @foreach ($supplier as $suppliers)
                              <option value="{{ $suppliers->id }}">{{ $suppliers->name }}</option>
                           @endforeach
                     </select>
                  </div>
               </div>

               <div class="col-lg-16 col-sm-6 col-12">
                  <div class="form-group">
                     <label style="font-size:15px;padding-top: 5px;padding-bottom: 2px;">Branch<span style="color: red;">*</span></label>
                     <select class="select branch_id" name="branch_id" id="branch_id">
                        <option value="" disabled selected hiddden>Select Branch</option>
                           @foreach ($branch as $branches)
                              <option value="{{ $branches->id }}">{{ $branches->name }}</option>
                           @endforeach
                     </select>
                  </div>
               </div>

               <div class="col-lg-6 col-sm-6 col-12">
                  <div class="form-group">
                     <label style="font-size:15px;padding-top: 5px;padding-bottom: 2px;">Date<span style="color: red;">*</span></label>
                     <input type="date" name="date" placeholder="" value="{{ $today }}">
                  </div>
               </div>

               <div class="col-lg-6 col-sm-6 col-12">
                  <div class="form-group">
                     <label style="font-size:15px;padding-top: 5px;padding-bottom: 2px;">Time<span style="color: red;">*</span></label>
                     <input type="time" name="time" placeholder="" value="{{ $timenow }}">
                  </div>
               </div>

               
               <div class="col-lg-16 col-sm-6 col-12">
                  <div class="form-group">
                     <label style="font-size:15px;padding-top: 5px;padding-bottom: 2px;">Bill No<span style="color: red;">*</span></label>
                     <input type="text" name="billno" placeholder="Bill No" id="billno" value="{{ $billno }}" style="background-color: #e9ecef;" readonly>
                  </div>
               </div>

               <div class="col-lg-16 col-sm-6 col-12">
                  <div class="form-group">
                     <label style="font-size:15px;padding-top: 5px;padding-bottom: 2px;">Bank<span style="color: red;">*</span></label>
                     <select class="select" name="bank_id" id="bank_id">
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
                           <th style="font-size:15px; width:12%;">Bag</th>
                           <th style="font-size:15px; width:12%;">Kgs </th>
                           <th style="font-size:15px; width:18%;">Price / Kg</th>
                           <th style="font-size:15px; width:20%;">Amount</th>
                           
                        </tr>
                     </thead>
                     <tbody id="product_fields">
                        <tr>
                           <td class="">
                              <input type="hidden"id="purchase_detail_id"name="purchase_detail_id[]" />
                              <select class=" form-control product_id" name="product_id[]" id="product_id1"required>
                                 <option value="" selected hidden class="text-muted">Select Product</option>
                                    @foreach ($product as $products)
                                       <option value="{{ $products->id }}">{{ $products->name }}</option>
                                    @endforeach
                              </select>
                           </td>
                           <td><input type="text" class="form-control" id="bag" name="bag[]" placeholder="Bag" value="" required /></td>
                           <td><input type="text" class="form-control kgs" id="kgs" name="kgs[]" placeholder="kgs" value="" required /></td>
                           <td><input type="text" class="form-control price_per_kg" id="price_per_kg" name="price_per_kg[]" placeholder="Price Per Kg" value="" required /></td>
                           <td class="text-end"><input type="text" class="form-control total_price" readonly id="total_price"  style="background-color: #e9ecef;" name="total_price[]" placeholder="" value="" required /></td>
                           <td>
                              <button style="width: 100px;"class="py-1 text-white font-medium rounded-lg text-sm  text-center btn btn-primary"
                              type="button" id="addproductfields" value="Add">Add</button>
                           </td>
                        </tr>
                     </tbody>
                     <tbody>
                        <tr>
                           <td></td>
                           <td></td>
                           <td></td>
                           <td style="font-size:15px;color: black;" class="text-end">Total</td>
                           <td><input type="text" class="form-control total_amount" id="total_amount" name="total_amount" readonly style="background-color: #e9ecef;" /></td>
                           
                        </tr>
                        <tr>
                           <td colspan="3"><input type="text" class="form-control" id="extracost_note" placeholder="Note" name="extracost_note" required/></td>
                           <td style="font-size:15px;color: black;" class="text-end">Extra Cost<span style="color: red;">*</span></td>
                           <td><input type="text" class="form-control extracost" id="extracost" placeholder="Extra Cost" name="extracost"/></td>
                        </tr>
                        <tr>
                           <td colspan="4" class="text-end" style="font-size:15px;color: black;">Gross Amount</td>
                           <td><input type="text" class="form-control gross_amount" id="gross_amount" placeholder="Gross Amount" readonly style="background-color: #e9ecef;" name="gross_amount"/></td>
                        </tr>
                        <tr>
                           <td colspan="4" class="text-end" style="font-size:15px;color: red;">Old Balance</td>
                           <td><input type="text" class="form-control old_balance" id="old_balance" placeholder="Old Balance" readonly value="0" style="background-color: #e9ecef;" name="old_balance"/></td>
                        </tr>
                        <tr>
                           <td colspan="4" class="text-end" style="font-size:15px;color: green;">Grand Total</td>
                           <td><input type="text" class="form-control grand_total" id="grand_total" readonly placeholder="Grand Total" style="background-color: #e9ecef;" name="grand_total"/></td>
                        </tr>
                        <tr>
                           <td colspan="4" class="text-end" style="font-size:15px;color: black;">Payable Amount<span style="color: red;">*</span></td>
                           <td><input type="text" class="form-control payable_amount" name="payable_amount" placeholder="Payable Amount" id="payable_amount"></td>
                        </tr>
                        <tr>
                           <td colspan="4" class="text-end" style="font-size:15px;color: black;">Pending Amount</td>
                           <td><input type="text" class="form-control pending_amount" name="pending_amount" readonly style="background-color: #e9ecef;" placeholder="Pending Amount" id="pending_amount"></td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>

               <br/><br/>

            
            <div class="modal-footer">
               <input type="submit" class="btn btn-primary" name="submit" value="submit"style="margin-right: 10%;" />
            </div>
         </form>


            




         </div>
      </div>
   </div>

@endsection
