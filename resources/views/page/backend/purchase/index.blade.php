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
                            @foreach ($data as $keydata => $purchasedata)
                                <tr>
                                    <td>{{ $purchasedata->bill_no }}</td>
                                    <td>{{ $purchasedata->date }}{{ $purchasedata->time }}</td>
                                    <td></td>
                                    <td></td>
                                    <td>{{ $purchasedata->total }}</td>
                                    @if ($purchasedata->status == 0)
                                        <td><span class="badges bg-lightgreen">Active</span></td>
                                    @else
                                        <td><span class="badges bg-lightred">De-Active</span></td>
                                    @endif
                                    <td>
                                        <ul class="list-unstyled hstack gap-1 mb-0">
                                            <li>
                                                <a href="#edit{{ $purchasedata->unique_key }}" data-bs-toggle="modal"
                                                    data-id="{{ $purchasedata->unique_key }}"
                                                    data-bs-target=".purchaseedit-modal-xl{{ $purchasedata->unique_key }}" class="badges bg-lightyellow" style="color: white">Edit</a>
                                            </li>
                                            <li>
                                                <a href="#delete{{ $purchasedata->unique_key }}" data-bs-toggle="modal"
                                                    data-id="{{ $purchasedata->unique_key }}"
                                                    data-bs-target=".purchasedelete-modal-xl{{ $purchasedata->unique_key }}" class="badges bg-lightgrey" style="color: white">Delete</a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>

                                <div class="modal fade purchaseedit-modal-xl{{ $purchasedata->unique_key }}" tabindex="-1"
                                    role="dialog" aria-labelledby="purchaseeditLargeModalLabel{{ $purchasedata->unique_key }}"
                                    aria-hidden="true">
                                    @include('page.backend.purchase.edit')
                                </div>

                                <div class="modal fade purchasedelete-modal-xl{{ $purchasedata->unique_key }}"
                                    tabindex="-1" role="dialog"
                                    aria-labelledby="purchasedeleteLargeModalLabel{{ $purchasedata->unique_key }}"
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
