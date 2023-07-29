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
                                <input type="date" name="salesreport_fromdate" id="salesreport_fromdate">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>To Date</label>
                                <input type="date" name="salesreport_todate" id="salesreport_todate">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Branch</label>
                                <select class="select salesreport_branch" name="salesreport_branch"
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
                                <select class="select" name="salesreport_customer" id="salesreport_customer">
                                    <option value=""  selected >Select Customer</option>
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
                                            <th>Type</th>
                                            <th>Bill No</th>
                                            <th>Date & Time</th>
                                            <th>Customer</th>
                                            <th>Branch</th>
                                            <th>Products</th>
                                            <th>Grand Total</th>
                                        </tr>
                                    </thead>
                                    <tbody style="background: #f8f9fa;">

                                        @foreach ($Sales_data as $keydata => $Sales_datas)
                                            @if ($Sales_datas['unique_key'] != '')
                                                <tr>
                                                    <td>{{ ++$keydata }}</td>
                                                    @if ($Sales_datas['sales_order'] == NULL) 
                                                    <td style="text-transform: uppercase;color:#198754"> Sales </td>
                                                    @elseif ($Sales_datas['sales_order'] == '1')
                                                    <td style="text-transform: uppercase;color:red;">Sales Order</td>
                                                    @endif
                                                    <td>#{{ $Sales_datas['bill_no'] }}</td>
                                                    <td>{{ date('d M Y', strtotime($Sales_datas['date'])) }} -
                                                        {{ date('h:i A', strtotime($Sales_datas['time'])) }}</td>
                                                    <td>{{ $Sales_datas['customer_name'] }}</td>
                                                    <td>{{ $Sales_datas['branch_name'] }}</td>
                                                    <td style="text-transform: uppercase;">
                                                    @foreach ($Sales_datas['sales_terms'] as $index => $terms_array)
                                                    @if ($terms_array['sales_id'] == $Sales_datas['id'])
                                                    {{ $terms_array['product_name'] }} - {{ $terms_array['kgs'] }}{{ $terms_array['bag'] }},<br/>
                                                    @endif
                                                    @endforeach
                                                    </td>
                                                    <td>{{ $Sales_datas['gross_amount'] }}</td>
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
