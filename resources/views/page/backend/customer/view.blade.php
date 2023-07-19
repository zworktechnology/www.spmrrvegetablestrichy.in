@extends('layout.backend.auth')

@section('content')

   <div class="content">
         <div class="page-header">
            <div class="page-title">
                <h4 style="text-transform: uppercase;color:red"><span style="color:green;">Customer</span> - {{$Customername}} </h4>
            </div>
        </div>

        <form autocomplete="off" method="POST" action="{{ route('customer.viewfilter') }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            <div class="card" style="background-color:#f5f5dc;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>From Date</label>
                                <input type="date" name="fromdate" id="fromdate" value="{{$fromdate}}" style="color:black">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>To Date</label>
                                <input type="date" name="todate" id="todate" value="{{$todate}}" style="color:black">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Branch</label>
                                <select class="branchid form-control js-example-basic-single select" name="branchid" style="color:black"
                                    id="branchid">
                                    <option value="" selected>Select Branch</option>
                                    @foreach ($branch as $branches)
                                        <option value="{{ $branches->id }}"@if ($branches->id === $branchid) selected='selected' @endif>{{ $branches->shop_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" name="customerid" id="customerid" value="{{$customer_id}}"/>
                            <input type="hidden" name="uniquekey" id="uniquekey" value="{{$unique_key}}"/>
                        </div>

                        <div class="col-lg-2 col-sm-6 col-12">
                            <div class="form-group">
                                <label>All</label>
                                <select class="viewall form-control" name="viewall" style="color:black"
                                    id="viewall">
                                    <option value="" selected>select</option>
                                    <option value="all" >View All</option>
                                    
                                </select>
                            </div>
                        </div>
                        
                        
                        <div class="col-lg-1 col-sm-6 col-12">
                            <div class="form-group">
                            <label>Action</label>
                                <input type="submit" class="btn btn-primary" name="submit" value="Search" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </form>


         <div class="page-header">
            <div class="page-title">
                <h4 style="text-transform: uppercase;"><span style="color:green;">Sales</span> </h4>
            </div>
         </div>
        
        <div class="card">
            <div class="card-body">
                  <div class="table-responsive">
                    <table class="table  supplierdatanew">
                        <thead style="background: #d7adca;">
                           <tr>
                              <th>S.No</th>
                              <th>Branch</th>
                              <th>Date</th>
                              <th>Billno</th>
                              <th>Product</th>
                              <th>Total</th>
                              <th>Paid</th>
                           </tr>
                        </thead>
                        <tbody style="background: #c5aab82e;">
                        @foreach ($Sales_data as $keydata => $Sales_datas)
                           <tr>
                              <td>{{ ++$keydata }}</td>
                              <td>{{ $Sales_datas['branch_name'] }}</td>
                              <td>{{ date('d-m-Y', strtotime($Sales_datas['date'])) }}</td>
                              <td>{{ $Sales_datas['bill_no'] }}</td>
                              <td style="text-transform: uppercase;">
                                    @foreach ($Sales_datas['terms'] as $index => $terms_array)
                                                    @if ($terms_array['sales_id'] == $Sales_datas['id'])
                                                    {{ $terms_array['product_name'] }} - {{ $terms_array['kgs'] }}{{ $terms_array['bag'] }},<br/>
                                                    @endif
                                                    @endforeach
                                    </td>
                              <td>{{ $Sales_datas['gross_amount'] }}</td>
                              <td>{{ $Sales_datas['paid_amount'] }}</td>
                           </tr>
                           @endforeach
                        </tbody>
                    </table>
                  </div>
            </div>
        </div>


        <div class="page-header">
            <div class="page-title">
                <h4 style="text-transform: uppercase;"><span style="color:green;">Sales receipt</span> </h4>
            </div>
         </div>
        <div class="card">
            <div class="card-body">
                  <div class="table-responsive">
                    <table class="table  supplierdatanew">
                        <thead style="background: #e7c766;">
                           <tr>
                              <th>S.No</th>
                              <th>Branch</th>
                              <th>Date</th>
                              <th>Sales Receipt</th>
                              <th>Discount</th>
                              <th>Paid</th>
                           </tr>
                        </thead>
                        <tbody style="background: #ddcb9557;">
                        @foreach ($salesPayment_data as $keydata => $salesPayment_datas)
                           <tr>
                              <td>{{ ++$keydata }}</td>
                              <td>{{ $salesPayment_datas['branch_name'] }}</td>
                              <td>{{ date('d-m-Y', strtotime($salesPayment_datas['date'])) }}</td>
                              <td>Receipt</td>
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
@endsection
