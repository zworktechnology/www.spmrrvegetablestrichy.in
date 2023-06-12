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
                                <select class="select purchasereport_branch" name="purchasereport_branch"
                                    id="purchasereport_branch">
                                    <option value="" disabled selected hiddden>Select Branch</option>
                                    @foreach ($branch as $branches)
                                        <option value="{{ $branches->id }}">{{ $branches->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Choose Supplier</label>
                                <select class="select" name="purchasereport_supplier" id="purchasereport_supplier">
                                    <option value="" disabled selected hiddden>Select Supplier</option>
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
                        @if ($purchase_data != '')
                            <div class="table-responsive">
                                <table class="table  customerdatanew">
                                    <thead>
                                        <tr>
                                            <th>Bill No</th>
                                            <th>Date & Time</th>
                                            <th>Supplier</th>
                                            <th>Branch</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($purchase_data as $keydata => $purchasedata)
                                            @if ($purchasedata['unique_key'] != '')
                                                <tr>
                                                    <td>#{{ $purchasedata['bill_no'] }}</td>
                                                    <td>{{ date('d M Y', strtotime($purchasedata['date'])) }} -
                                                        {{ date('h:i A', strtotime($purchasedata['date'])) }}</td>
                                                    <td>{{ $purchasedata['supplier_name'] }}</td>
                                                    <td>{{ $purchasedata['branch_name'] }}</td>
                                                    <td>{{ $purchasedata['gross_amount'] }}</td>
                                                    <td>

                                                        <ul class="list-unstyled hstack gap-1 mb-0">
                                                            <li>

                                                                <a href="{{ route('purchase.edit', ['unique_key' => $purchasedata['unique_key']]) }}"
                                                                    class="badges bg-lightyellow"
                                                                    style="color: white">Edit</a>
                                                            </li>
                                                            <li hidden>
                                                                <a href="#delete{{ $purchasedata['unique_key'] }}"
                                                                    data-bs-toggle="modal"
                                                                    data-id="{{ $purchasedata['unique_key'] }}"
                                                                    data-bs-target=".purchasedelete-modal-xl{{ $purchasedata['unique_key'] }}"
                                                                    class="badges bg-lightgrey"
                                                                    style="color: white">Delete</a>
                                                            </li>
                                                            <li>
                                                                <a href="#purchaseview{{ $purchasedata['unique_key'] }}"
                                                                    data-bs-toggle="modal"
                                                                    data-id="{{ $purchasedata['id'] }}"
                                                                    data-bs-target=".purchaseview-modal-xl{{ $purchasedata['unique_key'] }}"
                                                                    class="badges bg-lightred purchaseview"
                                                                    style="color: white">View</a>

                                                            </li>
                                                            <li>
                                                                <a href="{{ route('purchase.invoice', ['unique_key' => $purchasedata['unique_key']]) }}"
                                                                    class="badges bg-lightgreen"
                                                                    style="color: white">Invoice</a>
                                                            </li>
                                                        </ul>
                                                    </td>
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
