@extends('layout.backend.auth')

@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Sales Report</h4>
            </div>
        </div>

        <form autocomplete="off" method="POST" action="{{ route('sales.report_view') }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-2 col-sm-6 col-12">
                            <div class="form-group">
                                <label>From Date</label>
                                <input type="date" name="salesreport_fromdate" id="salesreport_fromdate" >
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-12">
                            <div class="form-group">
                                <label>To Date</label>
                                <input type="date" name="salesreport_todate" id="salesreport_todate">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Branch</label>
                                <select class="select salesreport_branch form-control js-example-basic-single" name="salesreport_branch"
                                    id="salesreport_branch">
                                    <option value=""  selected >Select Branch</option>
                                    @foreach ($branch as $branches)
                                        <option value="{{ $branches->id }}">{{ $branches->shop_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Customer</label>
                                <select class="select form-control js-example-basic-single" name="salesreport_customer" id="salesreport_customer">
                                    <option value="" selected >Select Customer</option>
                                    @foreach ($Customer as $Customers)
                                        <option value="{{ $Customers->id }}">{{ $Customers->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-1 col-sm-6 col-12">
                            <div class="form-group">
                                <label style="color: white">Action</label>
                                <input type="submit" class="btn btn-primary" name="submit" value="Search" />
                            </div>
                        </div>
                        <div class="col-lg-1 col-sm-6 col-12">
                            <div class="form-group">
                                <label style="color: white">Prit</label>

                                @if (($fromdate != '') && ($todate == '') && ($branch_id == '') && ($customer_id == ''))
                                <a href="/f_sales_pdfexport/{{$fromdate}}" class="badges bg-lightgrey btn btn-added">Pdf Export</a>

                                @elseif (($todate != '') && ($fromdate == '') && ($branch_id == '') && ($customer_id == ''))
                                <a href="/t_sales_pdfexport/{{$todate}}" class="badges bg-lightgrey btn btn-added">Pdf Export</a>

                                @elseif (($branch_id != '') && ($fromdate == '') && ($todate == '') && ($customer_id == ''))
                                <a href="/b_sales_pdfexport/{{$branch_id}}" class="badges bg-lightgrey btn btn-added">Pdf Export</a>

                                @elseif (($customer_id != '') && ($fromdate == '') && ($todate == '') && ($branch_id == ''))
                                <a href="/c_sales_pdfexport/{{$customer_id}}" class="badges bg-lightgrey btn btn-added">Pdf Export</a>

                                @elseif (($fromdate != '') && ($todate != '') && ($customer_id == '') && ($branch_id == ''))
                                <a href="/ft_sales_pdfexport/{{$fromdate}}/{{$todate}}" class="badges bg-lightgrey btn btn-added">Pdf Export</a>

                                @elseif (($fromdate != '') && ($branch_id != '') && ($todate == '') && ($customer_id == ''))
                                <a href="/fb_sales_pdfexport/{{$fromdate}}/{{$branch_id}}" class="badges bg-lightgrey btn btn-added">Pdf Export</a>

                                @elseif (($fromdate != '') && ($customer_id != '') && ($todate == '') && ($branch_id == ''))
                                <a href="/fc_sales_pdfexport/{{$fromdate}}/{{$customer_id}}" class="badges bg-lightgrey btn btn-added">Pdf Export</a>

                                @elseif (($todate != '') && ($branch_id != '') && ($fromdate == '') && ($customer_id == ''))
                                <a href="/tb_sales_pdfexport/{{$todate}}/{{$branch_id}}" class="badges bg-lightgrey btn btn-added">Pdf Export</a>

                                @elseif (($todate != '') && ($customer_id != '') && ($fromdate == '') && ($branch_id == ''))
                                <a href="/tc_sales_pdfexport/{{$todate}}/{{$customer_id}}" class="badges bg-lightgrey btn btn-added">Pdf Export</a>

                                @elseif (($branch_id != '') && ($customer_id != '') && ($fromdate == '') && ($todate == ''))
                                <a href="/bc_sales_pdfexport/{{$branch_id}}/{{$customer_id}}" class="badges bg-lightgrey btn btn-added">Pdf Export</a>

                                @elseif (($fromdate != '') && ($todate != '') && ($customer_id != '') && ($branch_id == ''))
                                <a href="/ftc_sales_pdfexport/{{$fromdate}}/{{$todate}}/{{$customer_id}}" class="badges bg-lightgrey btn btn-added">Pdf Export</a>

                                @elseif (($fromdate != '') && ($todate != '') && ($branch_id != '') && ($customer_id == ''))
                                <a href="/ftb_sales_pdfexport/{{$fromdate}}/{{$todate}}/{{$branch_id}}" class="badges bg-lightgrey btn btn-added">Pdf Export</a>

                                @elseif (($fromdate != '') && ($todate != '') && ($branch_id != '') && ($customer_id != ''))
                                <a href="/ftbc_sales_pdfexport/{{$fromdate}}/{{$todate}}/{{$branch_id}}/{{$customer_id}}" class="badges bg-lightgrey btn btn-added">Pdf Export</a>

                                @else
                                <a href="/sales_pdfexport" class="badges bg-lightgrey btn btn-added">Pdf Export</a>

                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                    @foreach ($Sales_data as $keydata => $Sales_datas)
                        @if ($Sales_datas['unique_key'] != '')

                        @if($keydata == 0)
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>From Date :<span style="color: red">{{ $Sales_datas['fromdateheading'] }}</span></label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>To Date :<span style="color: red">{{ $Sales_datas['todateheading'] }}</span></label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Branch :<span style="color: red"> {{ $Sales_datas['branchheading'] }}</span></label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Customer : <span style="color: red">{{ $Sales_datas['customerheading'] }}</span></label>
                            </div>
                        </div>
                        @endif
                        @endif
                    @endforeach
                    </div>
                </div>
            </div>

            <div class="card">
            
                <div class="card-body">
                    <div class="row">
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
                                                        {{ $terms_array['product_name'] }} - {{ $terms_array['kgs'] }}{{ $terms_array['bag'] }}-{{ $terms_array['price_per_kg'] }}<br/>
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

        </form>
    </div>
@endsection
