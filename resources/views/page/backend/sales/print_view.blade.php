@extends('layout.backend.auth')

@section('content')
    <div class="content">
        <button onclick="printDiv('printableArea')" class="badges bg-lightgreen"><i class="fa fa-print"></i> Print</button>
        <a href="{{ route('sales.index') }}"><button class="badges bg-lightgrey" style="color:black"> back</button> </a>

        <div id="printableArea">
            <div class="page-header">
                <div class="page-title">
                    <h4>Sales Details</h4>

                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div style="padding-bottom: 25px;">
                        <h4>Bill No : #{{ $SalesData->bill_no }}</h4>

                    </div>
                    <div class="invoice-box table-height"
                        style="max-width: 1600px;width:100%;overflow: auto;padding: 0;font-size: 14px;line-height: 24px;color: #555;">
                        <div class="row">

                            <div class="col-lg-4 col-sm-4 col-6">
                                <div class="card">
                                    <div class="card-body">
                                        <span class="">
                                            <font
                                                style="vertical-align: inherit;margin-bottom:25px;vertical-align: inherit;font-size:16px;color:#3a3435;font-weight:700;line-height: 35px; ">
                                                BASIC INFO</font>
                                        </span><br>
                                        <span style="font-size:14px; color:black;">Bill No: </span>&nbsp;&nbsp;&nbsp; #<span
                                            class="purchase_bill_no"
                                            style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">{{ $SalesData->bill_no }}</span><br>
                                        <span style="font-size:14px; color:black;">Date: </span>&nbsp;&nbsp;&nbsp;<span
                                            class="date"
                                            style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">{{ date('d M Y', strtotime($SalesData->date)) }}</span><br>
                                        <span style="font-size:14px; color:black;">Time: </span>&nbsp;&nbsp;&nbsp;<span
                                            class="time"
                                            style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">{{ date('h:i A', strtotime($SalesData->time)) }}</span><br>
                                        <span style="font-size:14px; color:black;">Bank Name: </span>&nbsp;&nbsp;&nbsp;<span
                                            class="bank_namedata"
                                            style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">{{ $bankname->name }}</span><br>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-4 col-6">
                                <div class="card">
                                    <div class="card-body">
                                        <span class="">
                                            <font
                                                style="vertical-align: inherit;margin-bottom:25px;vertical-align: inherit;font-size:16px;color:#3a3435;font-weight:700;line-height: 35px; ">
                                                CUSTOMER INFO</font>
                                        </span><br>
                                        <span style="font-size:14px; color:black;">Name: </span>&nbsp;&nbsp;&nbsp;<span
                                            class="suppliername"
                                            style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">{{ $customer_idname->name }}</span><br>
                                        <span style="font-size:14px; color:black;">Contact No:
                                        </span>&nbsp;&nbsp;&nbsp;<span class="supplier_contact_number"
                                            style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">{{ $customer_idname->shop_name }}</span><br>
                                        <span style="font-size:14px; color:black;">Shop Name: </span>&nbsp;&nbsp;&nbsp;<span
                                            class="supplier_shop_name"
                                            style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">{{ $customer_idname->contact_number }}</span><br>
                                        <span style="font-size:14px; color:black;">Address: </span>&nbsp;&nbsp;&nbsp;<span
                                            class="supplier_shop_address"
                                            style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">{{ $customer_idname->shop_address }}</span><br>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-4 col-6">
                                <div class="card">
                                    <div class="card-body">
                                        <span class="">
                                            <font
                                                style="vertical-align: inherit;margin-bottom:25px;vertical-align: inherit;font-size:16px;color:#3a3435;font-weight:700;line-height: 35px; ">
                                                BRANCH INFO</font>
                                        </span><br>
                                        <span style="font-size:14px; color:black;">Name: </span>&nbsp;&nbsp;&nbsp;<span
                                            class="branchname"
                                            style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">{{ $branchname->name }}</span><br>
                                        <span style="font-size:14px; color:black;">Contact No:
                                        </span>&nbsp;&nbsp;&nbsp;<span class="branch_contact_number"
                                            style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">{{ $branchname->shop_name }}</span><br>
                                        <span style="font-size:14px; color:black;">Shop Name: </span>&nbsp;&nbsp;&nbsp;<span
                                            class="branch_shop_name"
                                            style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">{{ $branchname->contact_number }}</span><br>
                                        <span style="font-size:14px; color:black;">Address: </span>&nbsp;&nbsp;&nbsp;<span
                                            class="branch_address"
                                            style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">{{ $branchname->address }}</span><br>
                                    </div>
                                </div>
                            </div>








                        </div>



                        <table style="width: 100%;line-height: inherit;text-align: left;overflow: auto;margin:15px auto;">
                            <tr class="heading " style="background: #F3F2F7;">
                                <td
                                    style="padding: 5px;vertical-align: middle;font-weight: 600;color: black;font-size: 16px;padding: 10px; ">
                                    Product Name
                                </td>
                                <td
                                    style="padding: 5px;vertical-align: middle;font-weight: 600;color: black;font-size: 16px;padding: 10px; ">
                                    Bag / Kg
                                </td>
                                <td
                                    style="padding: 5px;vertical-align: middle;font-weight: 600;color: black;font-size: 16px;padding: 10px; ">
                                    Count
                                </td>
                                <td
                                    style="padding: 5px;vertical-align: middle;font-weight: 600;color: black;font-size: 16px;padding: 10px; ">
                                    Price / Count
                                </td>
                                <td
                                    style="padding: 5px;vertical-align: middle;font-weight: 600;color: black;font-size: 16px;padding: 10px; ">
                                    Amount
                                </td>
                            </tr>
                            @foreach ($SalesProduct_darta as $index => $SalesProduct_darta_arr)
                                @if ($SalesProduct_darta_arr->sales_id == $SalesData->id)
                                    <tr class="details" style="border-bottom:1px solid #E9ECEF ;">
                                        <td
                                            style="padding: 10px;vertical-align: top; vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"">
                                            @foreach ($productlist as $products)
                                                @if ($products->id == $SalesProduct_darta_arr->productlist_id)
                                                    {{ $products->name }}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td
                                            style="padding: 10px;vertical-align: top; vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"">
                                            {{ $SalesProduct_darta_arr->bagorkg }}
                                        </td>
                                        <td
                                            style="padding: 10px;vertical-align: top;vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"">
                                            {{ $SalesProduct_darta_arr->count }}
                                        </td>
                                        <td
                                            style="padding: 10px;vertical-align: top; vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"">
                                            {{ $SalesProduct_darta_arr->price_per_kg }}
                                        </td>
                                        <td
                                            style="padding: 10px;vertical-align: top; vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"">
                                            {{ $SalesProduct_darta_arr->total_price }}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </table>





                        <br />

                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-6">
                            <div class="total-order w-100 max-widthauto mb-4">
                                <ul>
                                    <li>
                                        <h4>Total</h4>
                                        <h5>₹ {{ $SalesData->total_amount }}</h5>
                                    </li>
                                    <li>
                                        <h4>Extra Cost </h4>
                                        <h5>₹ {{ $SalesData->extra_cost }}</h5>
                                    </li>
                                    <li>
                                        <h4>Old Balance</h4>
                                        <h5>₹ {{ $SalesData->old_balance }}</h5>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-6 col-6">
                            <div class="total-order w-100 max-widthauto mb-4">
                                <ul>
                                    <li>
                                        <h4>Grand Total</h4>
                                        <h5>₹ {{ $SalesData->grand_total }}</h5>
                                    </li>
                                    <li class="total">
                                        <h4>Paid Amount</h4>
                                        <h5 style="color:green">₹ {{ $SalesData->paid_amount }}</h5>
                                    </li>
                                    <li class="total">
                                        <h4>Balance Amount</h4>
                                        <h5 style="color:red">₹ {{ $SalesData->balance_amount }}</h5>
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
