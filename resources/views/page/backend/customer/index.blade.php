@extends('layout.backend.auth')

@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Customer</h4>
            </div>
            <div class="page-btn">
                <button type="button" class="btn btn-primary waves-effect waves-light btn-added" data-bs-toggle="modal"
                    data-bs-target=".cusomer-modal-xl">Add Customer</button>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table  customerdatanew">
                        <thead>
                            <tr>
                                <th>Sl. No</th>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Shop Name</th>
                                <th>Total Sale</th>
                                <th>Total Paid</th>
                                <th>Total Balance</th>
                                <th>Status</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customerarr_data as $keydata => $customertdata)
                                <tr>
                                    <td>{{ ++$keydata }}</td>
                                    <td>{{ $customertdata['name'] }}</td>
                                    <td>{{ $customertdata['contact_number'] }}</td>
                                    <td>{{ $customertdata['shop_name'] }}</td>
                                    <td>₹ {{ $customertdata['total_sale_amt'] }}</td>
                                    <td>₹ {{ $customertdata['total_paid'] }}</td>
                                    <td>₹ {{ $customertdata['balance_amount'] }}</td>
                                    @if ($customertdata['status'] == 0)
                                        <td><span class="badges bg-lightgreen">Active</span></td>
                                    @else
                                        <td><span class="badges bg-lightred">De-Active</span></td>
                                    @endif
                                    <td>
                                        <ul class="list-unstyled hstack gap-1 mb-0">
                                            <li>
                                                <a href="#edit{{ $customertdata['unique_key'] }}" data-bs-toggle="modal"
                                                    data-id="{{ $customertdata['unique_key'] }}"
                                                    data-bs-target=".cusomeredit-modal-xl{{ $customertdata['unique_key'] }}" class="badges bg-lightyellow" style="color: white">Edit</a>
                                            </li>
                                            <li>
                                                <a href="#delete{{ $customertdata['unique_key'] }}" data-bs-toggle="modal"
                                                    data-id="{{ $customertdata['unique_key'] }}"
                                                    data-bs-target=".cusomerdelete-modal-xl{{ $customertdata['unique_key'] }}" class="badges bg-lightgrey" style="color: white">Delete</a>
                                            </li>

                                            <li>
                                                <a href="#customercheckbalance{{ $customertdata['unique_key'] }}" data-bs-toggle="modal" 
                                                    data-id="{{ $customertdata['id'] }}"
                                                    data-bs-target=".customercheckbalance-modal-xl{{ $customertdata['unique_key'] }}" class="badges bg-lightred customercheckbalance" style="color: white">Check Balance</a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>

                                <div class="modal fade cusomeredit-modal-xl{{ $customertdata['unique_key'] }}" tabindex="-1"
                                    role="dialog" data-bs-backdrop="static" aria-labelledby="customereditLargeModalLabel{{ $customertdata['unique_key'] }}"
                                    aria-hidden="true">
                                    @include('page.backend.customer.edit')
                                </div>


                                <div class="modal fade customercheckbalance-modal-xl{{ $customertdata['unique_key'] }}" tabindex="-1"
                                    role="dialog" data-bs-backdrop="static" aria-labelledby="customercheckbalanceLargeModalLabel{{ $customertdata['unique_key'] }}"
                                    aria-hidden="true">
                                    @include('page.backend.customer.checkbalance')
                                </div>

                                <div class="modal fade cusomerdelete-modal-xl{{ $customertdata['unique_key'] }}"
                                    tabindex="-1" role="dialog"data-bs-backdrop="static"
                                    aria-labelledby="customerdeleteLargeModalLabel{{ $customertdata['unique_key'] }}"
                                    aria-hidden="true">
                                    @include('page.backend.customer.delete')
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal fade cusomer-modal-xl" tabindex="-1" role="dialog" aria-labelledby="customerLargeModalLabel"
            aria-hidden="true" data-bs-backdrop="static">
            @include('page.backend.customer.create')
        </div>


    </div>
@endsection
