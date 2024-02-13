@extends('layout.backend.auth')

@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Product</h4>
                <p>Manage your productes</p>
            </div>
            {{-- <div class="page-btn">
                <button type="button" class="btn btn-primary waves-effect waves-light btn-added" data-bs-toggle="modal"
                    data-bs-target=".product-modal-xl">Add Product</button>
            </div> --}}
        </div>

        <div class="row">
            <div class="col-lg-8 col-sm-12 col-8">
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
                                                            class="badges bg-warning" style="color: white">Edit</a>

                                                    </li>
                                                    <li>
                                                        <a href="#delete{{ $productlist_array->unique_key }}"
                                                            data-bs-toggle="modal"
                                                            data-id="{{ $productlist_array->unique_key }}"
                                                            data-bs-target=".productdelete-modal-xl{{ $productlist_array->unique_key }}"
                                                            class="badges bg-danger" style="color: white">Delete</a>
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
            <div class="col-lg-4 col-sm-12 col-4">
                <div class="card">
                    <div class="card-body">
                        <div class="modal-header">
                            <h5 class="modal-title" id="productLargeModalLabel">New Product</h5>
                        </div>
                        <div class="modal-body">
                            <form autocomplete="off" method="POST" action="{{ route('productlist.store') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Name <span style="color: red;">*</span></label>
                                            <input type="text" name="name" placeholder="Enter product name" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 button-align">
                                        <button type="submit" class="btn btn-submit me-2">Create</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade product-modal-xl" tabindex="-1" data-bs-backdrop="static" role="dialog"
            aria-labelledby="productLargeModalLabel" aria-hidden="true">
            @include('page.backend.product.create')
        </div>
    </div>
@endsection
