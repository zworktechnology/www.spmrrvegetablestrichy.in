@extends('layout.backend.auth')

@section('content')


<div class="content">
   <div class="page-header">
      <div class="page-title">
      <h4>Purchase Details</h4>
      </div>
   </div>
      <div class="card">
         <div class="card-body">
            <div class="card-sales-split">
            <h2>Bill No : #{{ $PurchaseData->bill_no}}</h2>
               
         </div>
         <div class="invoice-box table-height" style="max-width: 1600px;width:100%;overflow: auto;margin:15px auto;padding: 0;font-size: 14px;line-height: 24px;color: #555;">
            <table cellpadding="0" cellspacing="0" style="width: 100%;line-height: inherit;text-align: left;">
               <tbody>
                  <tr class="top">
                     <td colspan="6" style="padding: 5px;vertical-align: top;">
                        <table style="width: 100%;line-height: inherit;text-align: left;">
                           <tbody>
                              <tr>
                                 <td style="padding:5px;vertical-align:top;text-align:left;padding-bottom:20px">
                                 <font style="vertical-align: inherit;margin-bottom:25px;"><font style="vertical-align: inherit;font-size:16px;color:#dc3545;font-weight:700;line-height: 35px; ">Supplier Info</font></font><br>
                                 <font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"> {{ $suppliername->name }}</font></font><br>
                                 <font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"> {{ $suppliername->shop_name }}</font></font><br>
                                 <font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"> {{ $suppliername->contact_number }}</font></font><br>
                                 <font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"> {{ $suppliername->shop_address }}</font></font><br>
                                 </td>
                                 <td style="padding:5px;vertical-align:top;text-align:left;padding-bottom:20px">
                                 <font style="vertical-align: inherit;margin-bottom:25px;"><font style="vertical-align: inherit;font-size:16px;color:#dc3545;font-weight:700;line-height: 35px; ">Branch Info</font></font><br>
                                 <font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"> {{ $branchname->name }} </font></font><br>
                                 <font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"> {{ $branchname->shop_name }}</font></font><br>
                                 <font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">{{ $branchname->contact_number }}</font></font><br>
                                 <font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"> {{ $branchname->address }}</font></font><br>
                                 </td>
                                 <td style="padding:5px;vertical-align:top;text-align:left;padding-bottom:20px">
                                 <font style="vertical-align: inherit;margin-bottom:25px;"><font style="vertical-align: inherit;font-size:16px;color:#dc3545;font-weight:700;line-height: 35px; ">Invoice Info</font></font><br>
                                 <font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"> Date </font></font><br>
                                 <font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"> Time </font></font><br>
                                 <font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"> Bank</font></font><br>
                                 <font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"> Payment Status</font></font><br>
                                 </td>
                                 <td style="padding:5px;vertical-align:top;text-align:right;padding-bottom:20px">
                                 <font style="vertical-align: inherit;margin-bottom:25px;"><font style="vertical-align: inherit;font-size:14px;color:#7367F0;font-weight:600;line-height: 35px; ">&nbsp;</font></font><br>
                                 <font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">{{ date('d M Y', strtotime($PurchaseData->date)) }}</font></font><br>
                                 <font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#2E7D32;font-weight: 400;"> {{ date('h:i A', strtotime($PurchaseData->time)) }}</font></font><br>
                                 <font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#2E7D32;font-weight: 400;"> {{ $bankname->name }}</font></font><br>
                                 <font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#2E7D32;font-weight: 400;"> Completed</font></font><br>
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </td>
                  </tr>
                  <tr class="heading " style="background: #F3F2F7;">
                     <td style="padding: 5px;vertical-align: middle;font-weight: 600;color: #5E5873;font-size: 14px;padding: 10px; ">
                     Sl.No
                     </td>
                     <td style="padding: 5px;vertical-align: middle;font-weight: 600;color: #5E5873;font-size: 14px;padding: 10px; ">
                     Product Name
                     </td>
                     <td style="padding: 5px;vertical-align: middle;font-weight: 600;color: #5E5873;font-size: 14px;padding: 10px; ">
                     Bag
                     </td>
                     <td style="padding: 5px;vertical-align: middle;font-weight: 600;color: #5E5873;font-size: 14px;padding: 10px; ">
                     Kgs
                     </td>
                     <td style="padding: 5px;vertical-align: middle;font-weight: 600;color: #5E5873;font-size: 14px;padding: 10px; ">
                     Price / Kg
                     </td>
                     <td style="padding: 5px;vertical-align: middle;font-weight: 600;color: #5E5873;font-size: 14px;padding: 10px; ">
                     Amount
                     </td>
                     
                  </tr>
                  @foreach ($PurchaseProducts as $index => $Purchase_Products)
                  <tr class="details" style="border-bottom:1px solid #E9ECEF ;">
                     <td style="padding: 10px;vertical-align: top; ">
                     {{ ++$index }}
                     </td>
                     <td style="padding: 10px;vertical-align: top; display: flex;align-items: center;">
                     @foreach ($productlist as $products)
                        @if ($products->id == $Purchase_Products->productlist_id)
                        {{ $products->name }}
                        @endif
                     @endforeach
                     </td>
                     <td style="padding: 10px;vertical-align: top; ">
                     {{ $Purchase_Products->bag }}
                     </td>
                     <td style="padding: 10px;vertical-align: top; ">
                     {{ $Purchase_Products->kgs }}
                     </td>
                     <td style="padding: 10px;vertical-align: top; ">
                     {{ $Purchase_Products->price_per_kg }}
                     </td>
                     <td style="padding: 10px;vertical-align: top; ">
                     ₹ {{ $Purchase_Products->total_price }}
                     </td>
                  </tr>
                  @endforeach
                  
               </tbody>
            </table>
         </div>

         <div class="row">
            <div class="col-lg-6 ">
               <div class="total-order w-100 max-widthauto m-auto mb-4">
                  <ul>
                     <li>
                        <h4>Total</h4>
                        <h5>₹ {{ $PurchaseData->total_amount}}</h5>
                     </li>
                     <li>
                        <h4>Extra Cost </h4>
                        <h5>₹ {{ $PurchaseData->extra_cost}}</h5>
                     </li>
                     <li>
                        <h4>Old Balance</h4>
                        <h5>₹ {{ $PurchaseData->old_balance}}</h5>
                     </li>
                  </ul>
               </div>
            </div>
            <div class="col-lg-6 ">
               <div class="total-order w-100 max-widthauto m-auto mb-4">
                  <ul>
                     <li>
                        <h4>Grand Total</h4>
                        <h5>₹ {{ $PurchaseData->grand_total}}</h5>
                     </li>
                     <li class="total">
                        <h4>Paid Amount</h4>
                        <h5 style="color:green">₹ {{ $PurchaseData->paid_amount}}</h5>
                     </li>
                     <li class="total">
                        <h4>Balance Amount</h4>
                        <h5 style="color:red">₹ {{ $PurchaseData->balance_amount}}</h5>
                     </li>
                  </ul>
               </div>
               </div>
            </div>
         </div>
   </div>
</div>

@endsection