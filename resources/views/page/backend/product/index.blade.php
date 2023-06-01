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

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table  customerdatanew">
                        <thead>
                            <tr>
                                <th>Sl. No</th>
                                <th>Product</th>
                                <th>Available Stockin Bags</th>
                                <th>Available Stockin Kilograms</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $keydata => $producttdata)
                                <tr>
                                    <td>{{ ++$keydata }}</td>
                                    <td>{{ $producttdata->name }}</td>
                                    <td>{{ $producttdata->available_stockin_bag }}</td>
                                    <td>{{ $producttdata->available_stockin_kilograms }}</td>
                                    @if ($producttdata->status == 0)
                                        <td><span class="badges bg-lightgreen">Active</span></td>
                                    @else
                                        <td><span class="badges bg-lightred">De-Active</span></td>
                                    @endif
                                    <td>
                                        <ul class="list-unstyled hstack gap-1 mb-0">
                                            <li>
                                                <a href="#edit{{ $producttdata->unique_key }}" data-bs-toggle="modal"
                                                    data-id="{{ $producttdata->unique_key }}"
                                                    data-bs-target=".productedit-modal-xl{{ $producttdata->unique_key }}" class="badges bg-lightyellow" style="color: white">Edit</a>
                                            </li>
                                            <li>
                                                <a href="#delete{{ $producttdata->unique_key }}" data-bs-toggle="modal"
                                                    data-id="{{ $producttdata->unique_key }}"
                                                    data-bs-target=".productdelete-modal-xl{{ $producttdata->unique_key }}" class="badges bg-lightgrey" style="color: white">Delete</a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>

                                <div class="modal fade productedit-modal-xl{{ $producttdata->unique_key }}" tabindex="-1"
                                    role="dialog" aria-labelledby="producteditLargeModalLabel{{ $producttdata->unique_key }}"
                                    aria-hidden="true">
                                    @include('page.backend.product.edit')
                                </div>

                                <div class="modal fade productdelete-modal-xl{{ $producttdata->unique_key }}"
                                    tabindex="-1" role="dialog"
                                    aria-labelledby="productdeleteLargeModalLabel{{ $producttdata->unique_key }}"
                                    aria-hidden="true">
                                    @include('page.backend.product.delete')
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
