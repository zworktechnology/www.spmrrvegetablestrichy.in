@extends('layout.backend.auth')

@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Customer View</h4>
            </div>
            <form autocomplete="off" method="POST" action="{{ route('customer.viewfilter') }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="page-btn" style="display: flex">

                    <div class="col-lg-4 col-sm-6 col-12" style="margin: 0px 3px;">
                        <div class="form-group">
                            <label>From</label>
                            <input type="date" name="fromdate" id="fromdate" value="{{ $fromdate }}"
                                style="color:black">
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-12" style="margin: 0px 3px;">
                        <div class="form-group">
                            <label>To</label>
                            <input type="date" name="todate" id="todate" value="{{ $todate }}"
                                style="color:black">
                        </div>
                    </div>
                    <input type="hidden" name="customerid" id="customerid" value="{{ $customer_id }}" />
                    <input type="hidden" name="uniquekey" id="uniquekey" value="{{ $unique_key }}" />
                    <div class="col-lg-2 col-sm-6 col-12" style="margin: 0px 3px;">
                        <div class="form-group">
                            <label style="opacity: 0%;">Action</label>
                            <input type="submit" class="btn btn-primary" name="submit" value="Search" />
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-6 col-12" style="margin: 0px 3px;">
                        <div class="form-group">
                            <label style="opacity: 0%;">Action</label>
                            <a href="{{ route('customer.view', ['unique_key' => $unique_key]) }}">
                                <input type="button" class="btn btn-primary" name="Show All" value="All" />
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="dash-widget">
                    <div class="dash-widgetcontent">
                        <h5>{{ $Customername }}</h5>
                        <h6>Branch - Summary</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="dash-widget dash1">
                    <div class="dash-widgetcontent">
                        <h5>₹ <span class="counters" data-count="0"></span></h5>
                        <h6>Total Sales Value</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="dash-widget dash2">
                    <div class="dash-widgetcontent">
                        <h5>₹ <span class="counters" data-count="0"></span></h5>
                        <h6>Total Paid Value</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="dash-widget dash3">
                    <div class="dash-widgetcontent">
                        <h5>₹ <span class="counters" data-count="0"></span></h5>
                        <h6>Total Balance Value</h6>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-12 col-sm-12 col-12" style="display: flex;">
            <div class="col-lg-6 col-sm-6 col-6" style="margin-right: 5px;">
                <div class="page-header">
                    <div class="page-title">
                        <h4>Sales</h4>
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
                                    @foreach ($Sales_data as $keydata => $Sales_datas)
                                        <tr>
                                            <td>{{ $Sales_datas['branch_name'] }}</td>
                                            <td>{{ date('d-m-Y', strtotime($Sales_datas['date'])) }}</td>
                                            <td>{{ $Sales_datas['bill_no'] }}</td>
                                            @if ($Sales_datas['sales_order'] == '1')
                                                <td> Sales Order </td>
                                            @elseif ($Sales_datas['sales_order'] == null)
                                                <td> Sales </td>
                                            @endif
                                            <td>
                                                @foreach ($Sales_datas['terms'] as $index => $terms_array)
                                                    @if ($terms_array['sales_id'] == $Sales_datas['id'])
                                                        {{ $terms_array['product_name'] }} -
                                                        {{ $terms_array['kgs'] }}{{ $terms_array['bag'] }},<br />
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
                        <h4>Sales Receipt</h4>
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
                                    @foreach ($salesPayment_data as $keydata => $salesPayment_datas)
                                        <tr>
                                            <td>{{ $salesPayment_datas['branch_name'] }}</td>
                                            <td>{{ date('d-m-Y', strtotime($salesPayment_datas['date'])) }}</td>
                                            <td>{{ $salesPayment_datas['salespayment_discount'] }}</td>
                                            <td>{{ $salesPayment_datas['paid_amount'] }}</td>
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
