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
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($purchase_data as $keydata => $purchasedata)
                                <tr>
                                    <td>{{ $purchasedata['bill_no'] }}</td>
                                    <td>{{ date('d M Y', strtotime($purchasedata['date'])) }} - {{ date('h:i A', strtotime($purchasedata['time'])) }}</td>
                                    <td>{{ $purchasedata['supplier'] }}</td>
                                    <td>{{ $purchasedata['branch'] }}</td>
                                    <td>{{ $purchasedata['grand_total'] }}</td>
                                    @if ($purchasedata['balance_amount'] > 0)
                                        <td><span class="badges bg-lightred">Overdue</span></td>
                                    @else
                                        <td><span class="badges bg-lightgreen">Paid</span></td>
                                    @endif
                                    <td>
                                        <ul class="list-unstyled hstack gap-1 mb-0">
                                            <li>
                                                
                                                <a href="{{ route('purchase.edit', ['unique_key' => $purchasedata['unique_key']]) }}" class="badges bg-lightyellow" style="color: white">Edit</a>
                                            </li>
                                            <li hidden>
                                                <a href="#delete{{ $purchasedata['unique_key'] }}" data-bs-toggle="modal"
                                                    data-id="{{ $purchasedata['unique_key'] }}"
                                                    data-bs-target=".purchasedelete-modal-xl{{ $purchasedata['unique_key'] }}" class="badges bg-lightgrey" style="color: white">Delete</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('purchase.invoice', ['unique_key' => $purchasedata['unique_key']]) }}" class="badges bg-lightgreen" style="color: white">Generate Invoice</a>
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

        <div class="modal fade product-modal-xl" tabindex="-1" role="dialog" aria-labelledby="productLargeModalLabel"
            aria-hidden="true">
            @include('page.backend.product.create')
        </div>


    </div>
@endsection
