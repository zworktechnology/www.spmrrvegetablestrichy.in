@extends('layout.backend.auth')

@section('content')


<div class="content">
<button  onclick="printDiv('printableArea')"  class="btn-success btn-sm" ><i class="fa fa-print"></i> Print</button>
      <a href="{{ route('sales.index') }}"><button  class="btn-danger btn-sm" style="color:white"> back</button> </a>

      <div  id="printableArea">

   <div class="card" style="text-transform: uppercase;">
      <div class="card-body">
      <div class="page-header">
         <div class="page-title">
         <h4>Sales Bill</h4>
         </div>
      </div>
         <div style="background-color: #fff;">

            <div class="row py-2">
               <div class="col-lg-12  col-sm-12 col-12">
                  <img src="{{ asset('assets/backend/img/spmheader.jpg') }}">
               </div>
            </div>
            <h4 class="py-1" style="font-size:15px;color: black; font-weight:800">{{ $customer_upper }}</h4>
            <div class="row">
               <div class="col-lg-10  col-sm-8 col-8">
               <span style="font-size:11px" >Bill No.  &nbsp;<span style="font-weight:600"># {{ $SalesData->bill_no}}</span></span>
               </div>
               <div class="col-lg-2  col-sm-4 col-4">
               <span style="font-size:11px" >Date: &nbsp;<span style="font-weight:600">{{ date('d-m-Y', strtotime($SalesData->date))}}</span></span>
               </div>
            </div>

                  <table style="width: 100%;line-height: inherit;text-align: left;overflow: auto;margin:15px auto;">
                     <tr class="heading " style="background:#eee;">
                        <td style="padding: 3px;vertical-align: middle;font-weight: 600;color: black;font-size: 11px;">
                        Product Name
                        </td>
                        <td style="padding: 3px;vertical-align: middle;font-weight: 600;color: black;font-size: 11px;">
                        Bag / Kg
                        </td>
                        <td style="padding: 3px;vertical-align: middle;font-weight: 600;color: black;font-size: 11px;">
                        Count
                        </td>
                        <td style="padding: 3px;vertical-align: middle;font-weight: 600;color: black;font-size: 11px;">
                        Price / Count
                        </td>
                        <td style="padding: 3px;vertical-align: middle;font-weight: 600;color: black;font-size: 11px;">
                        Amount
                        </td>
                     </tr>
                     @foreach ($SalesProduct_darta as $index => $SalesProduct_darta_arr)
                           @if ($SalesProduct_darta_arr->sales_id == $SalesData->id)
                     <tr class="details" style="border-bottom:1px solid #E9ECEF ;">
                        <td style="padding: 7px;vertical-align: top; vertical-align: inherit;vertical-align: inherit;font-size: 11px;color:#000;font-weight: 600;">
                        @foreach ($productlist as $products)
                                    @if ($products->id == $SalesProduct_darta_arr->productlist_id)
                                    {{ $products->name }}
                                    @endif
                                 @endforeach
                        </td>
                        <td style="padding: 7px;vertical-align: top; vertical-align: inherit;vertical-align: inherit;font-size: 11px;color:#000;font-weight: 600;">
                        {{ $SalesProduct_darta_arr->bagorkg }}
                        </td>
                        <td style="padding: 7px;vertical-align: top;vertical-align: inherit;vertical-align: inherit;font-size: 11px;color:#000;font-weight: 600;">
                        {{ $SalesProduct_darta_arr->count }}
                        </td>
                        <td style="padding: 7px;vertical-align: top; vertical-align: inherit;vertical-align: inherit;font-size: 11px;color:#000;font-weight: 600;">
                        {{ $SalesProduct_darta_arr->price_per_kg }}
                        </td>
                        <td style="padding: 7px;vertical-align: top; vertical-align: inherit;vertical-align: inherit;font-size: 11px;color:#000;font-weight: 600;">
                        {{ $SalesProduct_darta_arr->total_price }}
                        </td>
                     </tr>
                     @endif
                        @endforeach
                  </table>



               @if ($SalesData->extra_cost)
                  <table style="width: 100%;line-height: inherit;text-align: left;overflow: auto;margin:15px auto;">
                     <tr class="heading " style="background:#eee;">
                        <td style="padding: 3px;vertical-align: middle;font-weight: 800;color: black;font-size: 11px; ">ExtraCost Note</td>
                        <td style="padding: 3px;vertical-align: middle;font-weight: 800;color: black;font-size: 11px; ">Cost</td>
                     </tr>
                     <tr class="details" style="border-bottom:1px solid #E9ECEF ;">
                        <td style="padding: 7px;vertical-align: top; vertical-align: inherit;vertical-align: inherit;font-size: 11px;color:#000;font-weight: 600;">{{ $SalesData->note }}</td>
                        <td style="padding: 7px;vertical-align: top; vertical-align: inherit;vertical-align: inherit;font-size: 11px;color:#000;font-weight: 600;">{{ $SalesData->extra_cost }}</td>
                     </tr>
                  </table>
               @endif


                  <div class="row">
                        <div class="col-lg-7  col-sm-5 col-3"></div>
                        <div class="col-lg-5  col-sm-7 col-9">
                           <div class="total-order w-100 max-widthauto">
                              <ul>
                                 <li>
                                    <h4 style="font-size: 11px;color:blue;font-weight: 600;">Extra Charge</h4>
                                    <h5 style="font-size: 11px;color:blue;font-weight: 600;">₹ <span  class="">{{ $SalesData->extra_cost}}</span></h5>
                                 </li>
                                 <li>
                                    <h4 style="font-size: 11px;color:green;font-weight: 600;">Gross Amount</h4>
                                    <h5 style="font-size: 11px;color:green;font-weight: 600;">₹ <span  class="">{{ $SalesData->gross_amount}}</span></h5>
                                 </li>
                                 <li class="">
                                    <h4 style="font-size: 11px;color:blue;font-weight: 600;">Old Balance</h4>
                                    <h5 style="font-size: 11px;color:blue;font-weight: 600;">₹ <span  class="">{{ $SalesData->old_balance}}</span></h5>
                                 </li>
                                 <li class="">
                                    <h4 style="font-size: 11px;color:red;font-weight: 600;">Grand Total</h4>
                                    <h5 style="font-size: 11px;color:red;font-weight: 600;">₹ <span  class="">{{ $SalesData->grand_total}}</span></h5>
                                 </li>
                                 <li>
                                    <h4 style="font-size: 11px;color:blue;font-weight: 600;">Paid Amount</h4>
                                    <h5 style="font-size: 11px;color:blue;font-weight: 600;">₹ <span  class="">{{ $SalesData->paid_amount}}</span></h5>
                                 </li>
                                 <li class="">
                                    <h4 style="font-size: 11px;color:red;font-weight: 600;">Nett Balance</h4>
                                    <h5 style="font-size: 11px;color:red;font-weight: 600;">₹ <span  class="">{{ $SalesData->balance_amount}}</span></h5>
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
