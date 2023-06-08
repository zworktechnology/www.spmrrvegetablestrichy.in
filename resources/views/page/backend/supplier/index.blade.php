@extends('layout.backend.auth')

@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Supplier</h4>
            </div>
            <div class="page-btn">           
               <button type="button" class="btn btn-primary waves-effect waves-light btn-added" data-bs-toggle="modal"
                    data-bs-target=".supplier-modal-xl">Add Supplier</button>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table  supplierdatanew">
                        <thead>
                            <tr>
                                <th>Sl. No</th>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Shop Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $keydata => $suppliertdata)
                                <tr>
                                    <td>{{ ++$keydata }}</td>
                                    <td>{{ $suppliertdata->name }}</td>
                                    <td>{{ $suppliertdata->contact_number }}</td>
                                    <td>{{ $suppliertdata->shop_name }}</td>
                                    @if ($suppliertdata->status == 0)
                                        <td><span class="badges bg-lightgreen">Active</span></td>
                                    @else
                                        <td><span class="badges bg-lightred">De-Active</span></td>
                                    @endif
                                    <td>
                                        <ul class="list-unstyled hstack gap-1 mb-0">
                                            <li>
                                                <a href="#edit{{ $suppliertdata->unique_key }}" data-bs-toggle="modal"
                                                    data-id="{{ $suppliertdata->unique_key }}"
                                                    data-bs-target=".supplieredit-modal-xl{{ $suppliertdata->unique_key }}" class="badges bg-lightyellow" style="color: white">Edit</a>
                                            </li>
                                            <li>
                                                <a href="#delete{{ $suppliertdata->unique_key }}" data-bs-toggle="modal" 
                                                    data-id="{{ $suppliertdata->unique_key }}"
                                                    data-bs-target=".supplierdelete-modal-xl{{ $suppliertdata->unique_key }}" class="badges bg-lightgrey" style="color: white">Delete</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('supplier.checkbalance', ['id' => $suppliertdata->id]) }}" class="badges bg-lightred" style="color: white">Check Balance</a>
                                            </li>
                                        </ul>

                                    </td>

                                </tr>

                                <div class="modal fade supplieredit-modal-xl{{ $suppliertdata->unique_key }}"
                                    tabindex="-1" role="dialog" data-bs-backdrop="static"
                                    aria-labelledby="suppliereditLargeModalLabel{{ $suppliertdata->unique_key }}"
                                    aria-hidden="true">
                                    @include('page.backend.supplier.edit')
                                </div>

                                <div class="modal fade supplierdelete-modal-xl{{ $suppliertdata->unique_key }}"
                                    tabindex="-1" role="dialog" data-bs-backdrop="static"
                                    aria-labelledby="supplierdeleteLargeModalLabel{{ $suppliertdata->unique_key }}"
                                    aria-hidden="true">
                                    @include('page.backend.supplier.delete')
                                </div>

                               
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal fade supplier-modal-xl" tabindex="-1" role="dialog" aria-labelledby="supplierLargeModalLabel"
            aria-hidden="true">
            @include('page.backend.supplier.create')
        </div>

    </div>
@endsection



