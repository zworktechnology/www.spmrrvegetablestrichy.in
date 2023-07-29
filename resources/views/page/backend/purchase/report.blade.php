@extends('layout.backend.auth')

@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Purchase Report</h4>
            </div>
        </div>

        <form autocomplete="off" method="POST" action="{{ route('purchase.report_view') }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-2 col-sm-6 col-12">
                            <div class="form-group">
                                <label>From Date</label>
                                <input type="date" name="purchasereport_fromdate" id="purchasereport_fromdate">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>To Date</label>
                                <input type="date" name="purchasereport_todate" id="purchasereport_todate">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Branch</label>
                                <select class="purchasereport_branch form-control js-example-basic-single select" name="purchasereport_branch"
                                    id="purchasereport_branch">
                                    <option value="" selected>Select Branch</option>
                                    @foreach ($branch as $branches)
                                        <option value="{{ $branches->id }}">{{ $branches->shop_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Supplier</label>
                                <select class="form-control js-example-basic-single select" name="purchasereport_supplier" id="purchasereport_supplier">
                                    <option value="" selected>Select Supplier</option>
                                    @foreach ($supplier as $suppliers)
                                        <option value="{{ $suppliers->id }}">{{ $suppliers->name }}</option>
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
                    @foreach ($purchase_data as $keydata => $purchase)
                        @if ($purchase['unique_key'] != '')

                        @if($keydata == 0)
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>From Date :<span style="color: red">{{ $purchase['fromdateheading'] }}</span></label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>To Date :<span style="color: red">{{ $purchase['todateheading'] }}</span></label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Branch :<span style="color: red"> {{ $purchase['branchheading'] }}</span></label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Supplier : <span style="color: red">{{ $purchase['supplierheading'] }}</span></label>
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
                        @if ($purchase_data != '')
                            <div class="table-responsive">
                                <table class="table  customerdatanew">
                                    <thead style="background: #5e54c966;">
                                        <tr>
                                            <th>S.No</th>
                                            <th>Type</th>
                                            <th>Bill No</th>
                                            <th>Date & Time</th>
                                            <th>Supplier</th>
                                            <th>Branch</th>
                                            <th>Products</th>
                                            <th>Grand Total</th>
                                        </tr>
                                    </thead>
                                    <tbody style="background: #f8f9fa;">

                                        @foreach ($purchase_data as $keydata => $purchasedata)
                                            @if ($purchasedata['unique_key'] != '')
                                                <tr>

                                                    <td>{{ ++$keydata }}</td>
                                                    @if ($purchasedata['purchase_order'] == NULL) 
                                                    <td style="text-transform: uppercase;color:#198754"> Purchase </td>
                                                    @elseif ($purchasedata['purchase_order'] == '1')
                                                    <td style="text-transform: uppercase;color:red;">Purchase Order</td>
                                                    @endif
                                                    <td>#{{ $purchasedata['bill_no'] }}</td>
                                                    <td>{{ date('d M Y', strtotime($purchasedata['date'])) }} -
                                                        {{ date('h:i A', strtotime($purchasedata['time'])) }}</td>
                                                    <td>{{ $purchasedata['supplier_name'] }}</td>
                                                    <td>{{ $purchasedata['branch_name'] }}</td>
                                                    <td style="text-transform: uppercase;">
                                                    @foreach ($purchasedata['terms'] as $index => $terms_array)
                                                    @if ($terms_array['purchase_id'] == $purchasedata['id'])
                                                    {{ $terms_array['product_name'] }} - {{ $terms_array['kgs'] }}{{ $terms_array['bag'] }},<br/>
                                                    @endif
                                                    @endforeach
                                                    </td>
                                                    <td>{{ $purchasedata['gross_amount'] }}</td>
                                                </tr>

                                                <div class="modal fade purchaseview-modal-xl{{ $purchasedata['unique_key'] }}"
                                                    tabindex="-1" role="dialog" data-bs-backdrop="static"
                                                    aria-labelledby="purchaseviewLargeModalLabel{{ $purchasedata['unique_key'] }}"
                                                    aria-hidden="true">
                                                    @include('page.backend.purchase.view')
                                                </div>

                                                <div class="modal fade purchasedelete-modal-xl{{ $purchasedata['unique_key'] }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="purchasedeleteLargeModalLabel{{ $purchasedata['unique_key'] }}"
                                                    aria-hidden="true">
                                                    @include('page.backend.purchase.delete')
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
