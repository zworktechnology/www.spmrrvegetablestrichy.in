@extends('layout.backend.auth')

@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Product</h4>
            </div>
            <div class="page-btn">
                <button type="button" class="btn btn-primary waves-effect waves-light btn-added" data-bs-toggle="modal"
                    data-bs-target=".product-modal-xl">Add Product</button>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-12 col-sm-12 col-12">
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
                                            <td><a href="#edit{{ $productlist_array->unique_key }}" data-bs-toggle="modal"
                                                    data-id="{{ $productlist_array->unique_key }}"
                                                    data-bs-target=".productlistedit-modal-xl{{ $productlist_array->unique_key }}"
                                                    class="badges bg-lightyellow" style="color: white">Edit</a></td>
                                        </tr>


                                        <div class="modal fade productlistedit-modal-xl{{ $productlist_array->unique_key }}"
                                            tabindex="-1" role="dialog"
                                            aria-labelledby="productlistediteditLargeModalLabel{{ $productlist_array->unique_key }}"
                                            aria-hidden="true">
                                            @include('page.backend.product.productlistedit')
                                        </div>
                                    @endforeach
                                </tbody>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>

    <div class="modal fade product-modal-xl" tabindex="-1" role="dialog" aria-labelledby="productLargeModalLabel"
        aria-hidden="true">
        @include('page.backend.product.create')
    </div>


    </div>
@endsection
