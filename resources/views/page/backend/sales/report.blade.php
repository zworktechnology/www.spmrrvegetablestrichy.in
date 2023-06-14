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
                                        <option value="{{ $branches->id }}">{{ $branches->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Choose Customer</label>
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
                
                    
                        <h4 class="sales_report_heading" style="margin-left: 3%;margin-top: 2%;">
                        @foreach ($Sales_data as $keydata => $sales_data_arr)
                        @if ($sales_data_arr['unique_key'] != '')

                            @if($keydata == 0)
                            {{ $sales_data_arr['heading'] }}
                            @endif


                        
                        @endif
                        @endforeach
                        </h4>
                    
                <div class="card-body">
                    <div class="row">
                        @if ($Sales_data != '')
                            <div class="table-responsive">
                                <table class="table  customerdatanew">
                                    <thead>
                                        <tr>
                                            <th>Bill No</th>
                                            <th>Date & Time</th>
                                            <th>Customer</th>
                                            <th>Branch</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($Sales_data as $keydata => $Sales_datas)
                                            @if ($Sales_datas['unique_key'] != '')
                                                <tr>
                                                    <td>#{{ $Sales_datas['bill_no'] }}</td>
                                                    <td>{{ date('d M Y', strtotime($Sales_datas['date'])) }} -
                                                        {{ date('h:i A', strtotime($Sales_datas['time'])) }}</td>
                                                    <td>{{ $Sales_datas['customer_name'] }}</td>
                                                    <td>{{ $Sales_datas['branch_name'] }}</td>
                                                    <td>{{ $Sales_datas['gross_amount'] }}</td>
                                                    <td>

                                                        <ul class="list-unstyled hstack gap-1 mb-0">
                                                            <li>

                                                                <a href="{{ route('sales.edit', ['unique_key' => $Sales_datas['unique_key']]) }}"
                                                                    class="badges bg-lightyellow"
                                                                    style="color: white">Edit</a>
                                                            </li>
                                                            <li>
                                                                  <a href="#salesview{{ $Sales_datas['unique_key'] }}" data-bs-toggle="modal"
                                                                  data-id="{{ $Sales_datas['id'] }}" 
                                                                  data-bs-target=".salesview-modal-xl{{ $Sales_datas['unique_key'] }}"
                                                                  class="badges bg-lightred salesview" style="color: white">View</a>

                                                            </li>
                                                            <li>
                                                                <a href="{{ route('sales.invoice', ['unique_key' => $Sales_datas['unique_key']]) }}"
                                                                    class="badges bg-lightgreen"
                                                                    style="color: white">Invoice</a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>

                                                <div class="modal fade salesview-modal-xl{{ $Sales_datas['unique_key'] }}"
                                                      tabindex="-1" role="dialog" data-bs-backdrop="static"
                                                      aria-labelledby="salesviewLargeModalLabel{{ $Sales_datas['unique_key'] }}"
                                                      aria-hidden="true">
                                                      @include('page.backend.sales.view')
                                                </div>

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
