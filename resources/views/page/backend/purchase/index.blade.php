@extends('layout.backend.auth')

@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Purchase</h4>
            </div>
            <div class="page-btn">
                <div class="row">
                    <div style="display: flex;">
                        <form autocomplete="off" method="POST" action="{{ route('purchase.datefilter') }}">
                            @method('PUT')
                            @csrf
                            <div style="display: flex">
                                <div style="margin-right: 10px;"><input type="date" name="from_date" required
                                        class="form-control from_date" value="{{ $today }}"></div>
                                <div style="margin-right: 10px;"><input type="submit" class="btn btn-success"
                                        value="Search" /></div>
                            </div>
                        </form>
                        <a href="{{ route('purchase.create') }}" class="btn btn-added" style="margin-right: 10px;">Add
                            Purchase</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-2 col-sm-4 col-6">
                <a href="{{ route('purchase.index') }}" style="color: black">
                    <div class="dash-widget">
                        <div class="dash-widgetcontent">
                            <h6 style="font-weight: bold;">All</h6>
                        </div>
                    </div>
                </a>
            </div>
            @foreach ($allbranch as $keydata => $allbranches)
                <div class="col-lg-2 col-sm-4 col-6">
                    <a href="{{ route('purchase.branchdata', ['branch_id' => $allbranches->id]) }}" style="color: black">
                        <div class="dash-widget">
                            <div class="dash-widgetcontent">
                                <h6 style="font-weight: bold;">{{ $allbranches->shop_name }}</h6>
                            </div>
                        </div>
                    </a>
                    <a href="#todaystock{{ $allbranches->id }}" data-bs-toggle="modal"data-id="{{ $allbranches->id }}"
                            data-bs-target=".todaystock-modal-xl{{ $allbranches->id }}" class="btn btn-added btn-primary " style="color:black;background-color: #bcdce4 !important;font-size: 13px;font-weight: 600;">{{ $allbranches->shop_name }} - Stock</a>

                            <div class="modal fade todaystock-modal-xl{{ $allbranches->id }}" tabindex="-1"role="dialog" data-bs-backdrop="static"
                                aria-labelledby="todaystockLargeModalLabel{{ $allbranches->id }}"aria-hidden="true">
                                @include('page.backend.purchase.todaystock')
                            </div>
                </div>
            @endforeach
        </div>
        

            

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table  customerdatanew">
                        <thead>
                            <tr>
                                <th>Bill No</th>
                                <th>Supplier</th>
                                <th>Branch</th>
                                <th>Product Details</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($purchase_data as $keydata => $purchasedata)
                                <tr>
                                    <td>#{{ $purchasedata['bill_no'] }}</td>
                                    <td>{{ $purchasedata['supplier_name'] }}</td>
                                    <td>{{ $purchasedata['branch_name'] }}</td>
                                    <td>ONION - 2 Bag</td>
                                    <td>{{ $purchasedata['gross_amount'] }}</td>
                                    <td>
                                        <ul class="list-unstyled hstack gap-1 mb-0">
                                            @if ($purchasedata['status'] == 0)
                                                <li>
                                                    <a href="{{ route('purchase.edit', ['unique_key' => $purchasedata['unique_key']]) }}"
                                                        class="badges bg-lightyellow" style="color: white">Edit</a>
                                                </li>
                                            @endif
                                            <li hidden>
                                                <a href="#delete{{ $purchasedata['unique_key'] }}" data-bs-toggle="modal"
                                                    data-id="{{ $purchasedata['unique_key'] }}"
                                                    data-bs-target=".purchasedelete-modal-xl{{ $purchasedata['unique_key'] }}"
                                                    class="badges bg-lightgrey" style="color: white">Delete</a>
                                            </li>
                                            <li>
                                                <a href="#purchaseview{{ $purchasedata['unique_key'] }}"
                                                    data-bs-toggle="modal" data-id="{{ $purchasedata['id'] }}"
                                                    data-bs-target=".purchaseview-modal-xl{{ $purchasedata['unique_key'] }}"
                                                    class="badges bg-lightred purchaseview" style="color: white">View</a>

                                            </li>

                                            <li>
                                                @if ($purchasedata['status'] == 0)
                                                    <a href="{{ route('purchase.invoice', ['unique_key' => $purchasedata['unique_key']]) }}"
                                                        class="badges bg-lightgreen" style="color: white">Pattial</a>
                                                @elseif ($purchasedata['status'] == 1)
                                                    <a href="{{ route('purchase.print_view', ['unique_key' => $purchasedata['unique_key']]) }}"
                                                        class="badges bg-green" style="color: white">Generated Invoice</a>
                                                @endif
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>




    </div>
@endsection
