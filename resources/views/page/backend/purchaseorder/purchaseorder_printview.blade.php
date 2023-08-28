@extends('layout.backend.auth')

@section('content')


<div class="content">
<button  onclick="printDiv('printableArea')"  class="btn-success btn-sm" ><i class="fa fa-print"></i> Print</button> 
      <a href="{{ route('purchaseorder.purchaseorder_index') }}"><button  class="btn-danger btn-sm" style="color:white"> back</button> </a>
   
   <div  id="printableArea">
   
      <div class="card">
         <div class="card-body">
         <div class="page-header">
            <div class="page-title">
            <h4>Purchase Order - InvoiceBill</h4>
            
            </div>
         </div>
         <div style="background-color: #dbe4d629;">

                  <div class="row py-2" style="margin-bottom: 20px;">
                     <div class="col-lg-6  col-sm-5 col-4">
                     <img src="{{ asset('assets/backend/img/spm.jpg') }}" alt="Logo" style="width: 100px">
                     </div>
                     <div class="col-lg-6  col-sm-7 col-8" style="margin-top: 5px;">
                        <span style="font-weight:600">SPM, NS83, 84 | RR, OT166, 167, 117, Gandhi Market, Trichy 8.</span>
                        <span style="font-weight:600"><p><img src="{{ asset('assets/backend/img/mobileicon.png') }}" style="margin-top:4px;">&nbsp; <span>9842428882, 9994065696, 9842528789</span></p></span>
                     </div>
                  </div>
               <h4 class="py-1" style="font-size:18px;color: black; font-weight:800">{{ $supplier_upper }}</h4>
               <div class="row">
                  <div class="col-lg-10  col-sm-8 col-8">
                  <span style="font-size:13px" >Bill No.  &nbsp;<span style="font-weight:600"># {{ $PurchaseData->bill_no}}</span></span>
                  </div>
                  <div class="col-lg-2  col-sm-4 col-4">
                  <span style="font-size:13px" >Date: &nbsp;<span style="font-weight:600">{{ date('d-m-Y', strtotime($PurchaseData->date))}}</span></span>
                  </div>
               </div>

                     <table style="width: 100%;line-height: inherit;text-align: left;overflow: auto;margin:15px auto;">
                        <tr class="heading " style="background:#eee;">
                           <td style="padding: 5px;vertical-align: middle;font-weight: 600;color: black;font-size: 13px;padding: 10px; ">
                           Product Name
                           </td>
                           <td style="padding: 5px;vertical-align: middle;font-weight: 600;color: black;font-size: 13px;padding: 10px; ">
                           Bag / Kg
                           </td>
                           <td style="padding: 5px;vertical-align: middle;font-weight: 600;color: black;font-size: 13px;padding: 10px; ">
                           Count
                           </td>
                           <td style="padding: 5px;vertical-align: middle;font-weight: 600;color: black;font-size: 13px;padding: 10px; ">
                           Price / Count
                           </td>
                           <td style="padding: 5px;vertical-align: middle;font-weight: 600;color: black;font-size: 13px;padding: 10px; ">
                           Amount
                           </td>
                        </tr>
                        @foreach ($PurchaseProducts as $index => $PurchaseProducts_array)
                              @if ($PurchaseProducts_array->purchase_id == $PurchaseData->id)
                        <tr class="details" style="border-bottom:1px solid #E9ECEF ;">
                           <td style="padding: 10px;vertical-align: top; vertical-align: inherit;vertical-align: inherit;font-size: 13px;color:#000;font-weight: 600;">
                           @foreach ($productlist as $products)
                                       @if ($products->id == $PurchaseProducts_array->productlist_id)
                                       {{ $products->name }}
                                       @endif
                                    @endforeach
                           </td>
                           <td style="padding: 10px;vertical-align: top; vertical-align: inherit;vertical-align: inherit;font-size: 13px;color:#000;font-weight: 600;">
                           {{ $PurchaseProducts_array->bagorkg }}
                           </td>
                           <td style="padding: 10px;vertical-align: top;vertical-align: inherit;vertical-align: inherit;font-size: 13px;color:#000;font-weight: 600;">
                           {{ $PurchaseProducts_array->count }}
                           </td>
                           <td style="padding: 10px;vertical-align: top; vertical-align: inherit;vertical-align: inherit;font-size: 13px;color:#000;font-weight: 600;">
                           {{ $PurchaseProducts_array->price_per_kg }}
                           </td>
                           <td style="padding: 10px;vertical-align: top; vertical-align: inherit;vertical-align: inherit;font-size: 13px;color:#000;font-weight: 600;">
                           {{ $PurchaseProducts_array->total_price }}
                           </td>
                        </tr>
                        @endif
                           @endforeach
                     </table>
                     <div class="row">
                           <div class="col-lg-7  col-sm-5 col-3"></div>
                           <div class="col-lg-5  col-sm-7 col-9">
                              <div class="total-order w-100 max-widthauto">
                                 <ul>
                                    <li>
                                       <h4 style="font-size: 13px;color:blue;font-weight: 600;">Commission Amount</h4>
                                       <h5 style="font-size: 13px;color:blue;font-weight: 600;">₹ <span  class="">{{ $PurchaseData->commission_amount}}</span></h5>
                                    </li>
                                    <li>
                                       <h4 style="font-size: 13px;color:green;font-weight: 600;">Extra Charge</h4>
                                       <h5 style="font-size: 13px;color:green;font-weight: 600;">₹ <span  class="">{{ $extracostamount}}</span></h5>
                                    </li>
                                    <li class="">
                                       <h4 style="font-size: 13px;color:blue;font-weight: 600;">Gross Amount</h4>
                                       <h5 style="font-size: 13px;color:blue;font-weight: 600;">₹ <span  class="">{{ $PurchaseData->gross_amount}}</span></h5>
                                    </li>
                                    <li class="">
                                       <h4 style="font-size: 13px;color:red;font-weight: 600;">Old Balance</h4>
                                       <h5 style="font-size: 13px;color:red;font-weight: 600;">₹ <span  class="">{{ $PurchaseData->old_balance}}</span></h5>
                                    </li>
                                    <li>
                                       <h4 style="font-size: 13px;color:blue;font-weight: 600;">Grand Total</h4>
                                       <h5 style="font-size: 13px;color:blue;font-weight: 600;">₹ <span  class="">{{ $PurchaseData->grand_total}}</span></h5>
                                    </li>
                                    <li class="">
                                       <h4 style="font-size: 13px;color:green;font-weight: 600;">Paid Amount</h4>
                                       <h5 style="font-size: 13px;color:green;font-weight: 600;">₹ <span  class="">{{ $PurchaseData->paid_amount}}</span></h5>
                                    </li>
                                    <li class="">
                                       <h4 style="font-size: 13px;color:red;font-weight: 600;">Nett Balance</h4>
                                       <h5 style="font-size: 13px;color:red;font-weight: 600;">₹ <span  class="">{{ $PurchaseData->balance_amount}}</span></h5>
                                    </li>
                                 </ul>    
                              </div>
                           </div>
                     </div>

               
            </div>
               
            
         </div>
      </div>
   </div>

</div>

@endsection