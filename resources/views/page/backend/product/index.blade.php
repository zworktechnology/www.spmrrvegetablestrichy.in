@extends('layout.backend.auth')

@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Product</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 col-sm-8 col-8">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table  customerdatanew">
                                <thead>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productlistdata as $keydata => $productlist_array)
                                        <tr>
                                            <td>{{ ++$keydata }}</td>
                                            <td>{{ $productlist_array->name }}</td>
                                            <td>
                                                <ul class="list-unstyled hstack gap-1 mb-0">
                                                    <li>
                                                        <a href="#edit{{ $productlist_array->unique_key }}"
                                                            data-bs-toggle="modal"
                                                            data-id="{{ $productlist_array->unique_key }}"
                                                            data-bs-target=".productlistedit-modal-xl{{ $productlist_array->unique_key }}"
                                                            class="badges bg-lightyellow" style="color: white">Edit</a>

                                                    </li>
                                                    <li>
                                                        <a href="#delete{{ $productlist_array->unique_key }}" data-bs-toggle="modal"
                                                            data-id="{{ $productlist_array->unique_key }}"
                                                            data-bs-target=".productdelete-modal-xl{{ $productlist_array->unique_key }}"
                                                            class="badges bg-lightgrey" style="color: white; background-color:brown">Del</a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>


                                        <div class="modal fade productlistedit-modal-xl{{ $productlist_array->unique_key }}"
                                            tabindex="-1" role="dialog"
                                            aria-labelledby="productlistediteditLargeModalLabel{{ $productlist_array->unique_key }}"
                                            aria-hidden="true">
                                            @include('page.backend.product.productlistedit')
                                        </div>

                                        <div class="modal fade productdelete-modal-xl{{ $productlist_array->unique_key }}"
                                            tabindex="-1" role="dialog"data-bs-backdrop="static"
                                            aria-labelledby="productdeleteLargeModalLabel{{ $productlist_array->unique_key }}"
                                            aria-hidden="true">
                                            @include('page.backend.product.delete')
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-8 col-4">
                @include('page.backend.product.create')
            </div>
        </div>
    </div>
@endsection
