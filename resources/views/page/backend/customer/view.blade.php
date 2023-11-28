@extends('layout.backend.auth')

@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Customer View</h4>
            </div>

            @php
                $lastword = Request::url();
                preg_match("/[^\/]+$/", $lastword, $matches);
                $last_word = $matches[0];
                @endphp


            <form autocomplete="off" method="POST" action="{{ route('customer.viewfilter', ['unique_key' => $unique_key, 'last_word' => $last_word]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="page-btn" style="display: flex">

                    <div class="col-lg-4 col-sm-6 col-12" style="margin: 0px 3px;">
                        <div class="form-group">
                            <label>From</label>
                            <input type="date" name="fromdate" id="fromdate" value="{{$fromdate}}"
                                style="color:black">
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-12" style="margin: 0px 3px;">
                        <div class="form-group">
                            <label>To</label>
                            <input type="date" name="todate" id="todate" value="{{$todate}}"
                                style="color:black">
                        </div>
                    </div>
                    <input type="hidden" name="customerid" id="customerid" value="{{ $customer_id }}" />
                    <input type="hidden" name="uniquekey" id="uniquekey" value="{{ $unique_key }}" />
                    <input type="hidden" name="branchid" id="branchid" value="{{ $last_word }}" />
                    <div class="col-lg-2 col-sm-6 col-12" style="margin: 0px 3px;">
                        <div class="form-group">
                            <label style="opacity: 0%;">Action</label>
                            <input type="submit" class="btn btn-primary" name="submit" value="Search" />
                        </div>
                    </div>
                    
                </div>
            </form>
            <a href="{{ route('customer.index') }}" class="badges bg-green" style="color: white;margin-right: 10px;">Back</a>   
        </div>
        <div class="row" >
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="dash-widget">
                    <div class="dash-widgetcontent">
                        <h5>{{ $Customername }}</h5>
                        <h6 style="color:red">Branch - {{$GETBranchname}}</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="dash-widget dash1">
                    <div class="dash-widgetcontent">
                        <h5>₹ <span class="counters" data-count="{{ $tot_saleAmount }}"></span></h5>
                        <h6>Total Sales Value</h6>
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


        <div class="col-lg-12 col-sm-12 col-12" >
                <div class="page-header">
                    <div class="page-title">
                        <h4>Sales</h4>
                    </div>
                </div>


                <div class="card">
                    <div class="card-body">
                    @if ($Sales_data != '')
                            <div class="table-responsive">
                                <table class="table  customerdatanew">
                                    <thead style="background: #5e54c966;">
                                        <tr>
                                        <th>S.No</th>
                                            <th>Date</th>
                                            <th>Customer</th>
                                            <th>Branch</th>
                                            <th>Type</th>
                                            <th>Bill No</th>
                                            <th style="">Particulars</th>
                                            <th style="">Debit</th>
                                            <th style="">Credit</th>
                                            <th style="">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody style="background: #f8f9fa;">

                                        @foreach ($Sales_data as $keydata => $Sales_datas)
                                            @if ($Sales_datas['unique_key'] != '')
                                                <tr>
                                                <td>{{ ++$keydata }}</td>
                                                    <td>{{ $Sales_datas['date'] }}</td>
                                                    <td>{{ $Sales_datas['customer_name'] }}</td>
                                                    <td>{{ $Sales_datas['branch_name'] }}</td>
                                                    <td>{{ $Sales_datas['type'] }}</td>
                                                    <td>{{ $Sales_datas['bill_no'] }}</td>
                                                    <td style="text-transform: uppercase;">
                                                    @if ($Sales_datas['type'] == 'SALES')
                                                    @foreach ($Sales_datas['sales_terms'] as $index => $terms_array)
                                                    @if ($terms_array['sales_id'] == $Sales_datas['id'])
                                                    {{ $terms_array['product_name'] }} - {{ $terms_array['kgs'] }}{{ $terms_array['bag'] }}-{{ $terms_array['price_per_kg'] }},<br/>
                                                    @endif
                                                    @endforeach
                                                    @endif
                                                    </td>

                                                    <td>{{ $Sales_datas['gross_amount'] }}</td>
                                                    
                                                    <td>{{ $Sales_datas['paid_amount'] }}</td>
                                                    <td>{{ $Sales_datas['balance_amount'] }}</td>
                                                </tr>


                                            @endif
                                        @endforeach


                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            

            



        </div>
    </div>
@endsection
