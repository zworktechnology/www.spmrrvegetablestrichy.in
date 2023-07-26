@extends('layout.backend.auth')

@section('content')

   <div class="content">
         <div class="page-header">
            <div class="page-title">
                <h4 style="text-transform: uppercase;color:red"><span style="color:green;">supplier</span> - {{$suppliername}} </h4>
            </div>
        </div>

        <form autocomplete="off" method="POST" action="{{ route('supplier.viewfilter') }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            <div class="card">
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
                            <input type="hidden" name="supplierid" id="supplierid" value="{{$supplier_id}}"/>
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


         <div class="col-lg-12 col-sm-12 col-12" style="display: flex;">
            <div class="col-lg-6 col-sm-6 col-6">
                <div class="page-header">
                    <div class="page-title">
                        <h4 style="text-transform: uppercase;"><span style="color:green;">purchase</span> </h4>
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
                                    <th>Billno</th>
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
                                                <td style="text-transform: uppercase; color:#3f8fd5">  Purchase Order </td>
                                            @elseif ($purchase_datas['purchase_order'] == NULL)
                                                <td style="text-transform: uppercase; color:#14a763">  Purchase </td>
                                            @endif
                                    <td style="text-transform: uppercase;">
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

            <div class="col-lg-6 col-sm-6 col-6">
                <div class="page-header">
                    <div class="page-title">
                        <h4 style="text-transform: uppercase;"><span style="color:green;">purchase receipt</span> </h4>
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
                                    <th>Purchase Receipt</th>
                                    <th>Discount</th>
                                    <th>Paid</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($PurchasePayment_data as $keydata => $PurchasePayment_datas)
                                <tr>
                                    <td>{{ $PurchasePayment_datas['branch_name'] }}</td>
                                    <td>{{ date('d-m-Y', strtotime($PurchasePayment_datas['date'])) }}</td>
                                    <td>Receipt</td>
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
