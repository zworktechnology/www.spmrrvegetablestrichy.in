@extends('layout.backend.auth')

@section('content')

   <div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>Supplier View</h4>
        </div>

        @php
                $lastword = Request::url();
                preg_match("/[^\/]+$/", $lastword, $matches);
                $last_word = $matches[0];
                @endphp


        <form autocomplete="off" method="POST" action="{{ route('supplier.viewfilter', ['unique_key' => $unique_key, 'last_word' => $last_word]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="page-btn" style="display: flex">

                <div class="col-lg-4 col-sm-6 col-12" style="margin: 0px 3px;">
                    <div class="form-group">
                        <label>From</label>
                        <input type="date" name="fromdate" id="fromdate" value="{{$fromdate}}" style="color:black">
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-12" style="margin: 0px 3px;">
                    <div class="form-group">
                        <label>To</label>
                        <input type="date" name="todate" id="todate" value="{{$todate}}" style="color:black">
                    </div>
                </div>
                <input type="hidden" name="supplierid" id="supplierid" value="{{$supplier_id}}"/>
                <input type="hidden" name="uniquekey" id="uniquekey" value="{{$unique_key}}"/>
                    <input type="hidden" name="branchid" id="branchid" value="{{ $last_word }}" />
                <div class="col-lg-2 col-sm-6 col-12" style="margin: 0px 3px;">
                    <div class="form-group">
                        <label style="opacity: 0%;">Action</label>
                        <input type="submit" class="btn btn-primary" name="submit" value="Search" />
                    </div>
                </div>
            </div>
        </form>
        <a href="{{ route('supplier.index') }}" class="badges bg-green" style="color: white;margin-right: 10px;">Back</a>   
    </div>
    <div class="row">
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="dash-widget">
                <div class="dash-widgetcontent">
                    <h5>{{ $suppliername }}</h5>
                    <h6 style="color:red">Branch - {{$GETBranchname}}</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="dash-widget dash1">
                <div class="dash-widgetcontent">
                    <h5>₹ <span class="counters" data-count="{{ $tot_purchaseAmount }}"></span></h5>
                    <h6>Total Purchase Value</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="dash-widget dash2">
                <div class="dash-widgetcontent">
                    <h5>₹ <span class="counters" data-count="{{ $total_amount_paid }}"></span></h5>
                    <h6>Total Paid Value</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="dash-widget dash3">
                <div class="dash-widgetcontent">
                    <h5>₹ <span class="counters" data-count="{{ $total_balance }}"></span></h5>
                    <h6>Total Balance Value</h6>
                </div>
            </div>
        </div>
    </div>



         <div class="col-lg-12 col-sm-12 col-12" style="display: flex;">
            <div class="col-lg-6 col-sm-6 col-6" style="margin-right: 5px;">
                <div class="page-header">
                    <div class="page-title">
                        <h4>Purchase</h4>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table  supplierdatanew">
                                <thead>
                                <tr>
                                    <th>Branch</th>
                                    <th>Date</th>
                                    <th>Bill No</th>
                                    <th>Bill Type</th>
                                    <th>Product</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($purchase_data as $keydata => $purchase_datas)
                                <tr>
                                    <td>{{ $purchase_datas['branch_name'] }}</td>
                                    <td>{{ date('d-m-Y', strtotime($purchase_datas['date'])) }}</td>
                                    <td>{{ $purchase_datas['bill_no'] }}</td>

                                            @if ($purchase_datas['purchase_order'] == '1')
                                                <td> Purchase Order </td>
                                            @elseif ($purchase_datas['purchase_order'] == NULL)
                                                <td> Purchase </td>
                                            @endif
                                    <td>
                                            @foreach ($purchase_datas['terms'] as $index => $terms_array)
                                                            @if ($terms_array['purchase_id'] == $purchase_datas['id'])
                                                            {{ $terms_array['product_name'] }} - {{ $terms_array['kgs'] }}{{ $terms_array['bag'] }},<br/>
                                                            @endif
                                                            @endforeach
                                            </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-sm-6 col-6" style="margin-left: 5px;">
                <div class="page-header">
                    <div class="page-title">
                        <h4>Purchase Receipt</h4>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table  supplierdatanew">
                                <thead>
                                <tr>
                                    <th>Branch</th>
                                    <th>Date</th>
                                    <th>Discount</th>
                                    <th>Paid</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($PurchasePayment_data as $keydata => $PurchasePayment_datas)
                                <tr>
                                    <td>{{ $PurchasePayment_datas['branch_name'] }}</td>
                                    <td>{{ date('d-m-Y', strtotime($PurchasePayment_datas['date'])) }}</td>
                                    <td>{{ $PurchasePayment_datas['purchasepayment_discount'] }}</td>
                                    <td>{{ $PurchasePayment_datas['paid_amount'] }}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


   </div>
@endsection
