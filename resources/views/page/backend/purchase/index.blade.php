@extends('layout.backend.auth')

@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Purchase</h4>
            </div>
            <div class="page-btn">
                <a href="{{ route('purchase.create') }}" class="btn btn-added">Add Purchase</a>
            </div>
        </div>


        <div class="row">
            @foreach ($allbranch as $keydata => $allbranches)
            <div class="col-lg-3 col-sm-6 col-12">
                <a href="{{ route('purchase.branchdata', ['branch_id' => $allbranches->id]) }}" style="color: black">
                    <div class="dash-widget">
                        <div class="dash-widgetimg">
                            <span><img src="{{ asset('assets/backend/img/icons/dash1.svg') }}" alt="img"></span>
                        </div>
                        <div class="dash-widgetcontent">
                            <h5>{{ $allbranches->name }}</h5>
                            <h6></h6>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach  
            <div class="col-lg-3 col-sm-6 col-12">
                <a href="{{ route('purchase.index') }}" style="color: black">
                    <div class="dash-widget">
                        <div class="dash-widgetimg">
                            <span><img src="{{ asset('assets/backend/img/icons/dash1.svg') }}" alt="img"></span>
                        </div>
                        <div class="dash-widgetcontent">
                            <h5>All</h5>
                            <h6></h6>
                        </div>
                    </div>
                </a>
            <div style="display: flex; margin-bottom: 10px;">
                <a href="" style="color: white; margin-left: 10px; " class="badges bg-lightyellow">All</a>
                @foreach ($allbranch as $keydata => $allbranches)
                    <a href="" style="color: white; margin-left: 10px; " class="badges bg-lightyellow">{{ $allbranches->name }}</a>
                @endforeach
            </div>
        </div>

        <div class="card">
            <div class="card-body">
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
                                                    class="badges bg-lightyellow" style="color: white">Edit</a>
                                            </li>
                                            <li hidden>
                                                <a href="#delete{{ $purchasedata['unique_key'] }}" data-bs-toggle="modal"
                                                    data-id="{{ $purchasedata['unique_key'] }}"
                                                    data-bs-target=".purchasedelete-modal-xl{{ $purchasedata['unique_key'] }}"
                                                    class="badges bg-lightgrey" style="color: white">Delete</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('purchase.view', ['unique_key' => $purchasedata['unique_key']]) }}"
                                                    class="badges bg-lightred" style="color: white">View</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('purchase.invoice', ['unique_key' => $purchasedata['unique_key']]) }}"
                                                    class="badges bg-lightgreen" style="color: white">Invoice</a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>



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
