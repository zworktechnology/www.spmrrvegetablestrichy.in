@extends('layout.backend.auth')

@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Stock Management</h4>
            </div>
        </div>


        <div class="row">

            <div class="col-lg-2 col-sm-4 col-6">
                <a href="{{ route('stockmanagement.index') }}" style="color: black">
                    <div class="dash-widget">
                        <div class="dash-widgetcontent">
                            <h6 style="font-weight: bold;">All</h6>
                        </div>
                    </div>
                </a>
            </div>
            @foreach ($branch_data as $keydata => $allbranches)
            <div class="col-lg-2 col-sm-4 col-6">

                    <div class="dash-widget">
                        <div class="dash-widgetcontent">
                            <h6 style="font-weight: bold;">

                            <a href="#branch_view{{ $allbranches->id }}" data-bs-toggle="modal"data-id="{{ $allbranches->id }}"
                            data-bs-target=".branch_view-modal-xl{{ $allbranches->id }}" style="color:black">{{ $allbranches->shop_name }}</a>

                            </h6>
                        </div>
                    </div>
            </div>

            <div class="modal fade branch_view-modal-xl{{ $allbranches->id }}" tabindex="-1"role="dialog" data-bs-backdrop="static"
             aria-labelledby="branch_viewLargeModalLabel{{ $allbranches->id }}"aria-hidden="true">
               @include('page.backend.product.branch_view')
            </div>
            @endforeach
        </div>


         <div class="row">
            <div class="col-lg-12 col-sm-12 col-12">
                  <div class="card">
                     <div class="card-body">
                        <div class="table-responsive">
                              <table class="table  customerdatanew">
                                 <thead>
                                    <tr>
                                          <th>Sl. No</th>
                                          <th>Branch</th>
                                          <th>Product</th>
                                          <th>Bags</th>
                                          <th>Kilograms</th>
                                          <th>Status</th>
                                          <th>Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    @foreach ($product_data as $keydata => $producttdata)
                                          <tr>
                                             <td>{{ ++$keydata }}</td>
                                             <td>{{ $producttdata['branch'] }}</td>
                                             <td>{{ $producttdata['productlist'] }}</td>
                                             <td>{{ $producttdata['available_stockin_bag'] }}</td>
                                             <td>{{ $producttdata['available_stockin_kilograms'] }}</td>
                                             @if ($producttdata['status'] == 0)
                                                <td><span class="badges bg-lightgreen">Active</span></td>
                                             @else
                                                <td><span class="badges bg-lightred">De-Active</span></td>
                                             @endif
                                             <td>
                                                <ul class="list-unstyled hstack gap-1 mb-0">
                                                      <li>
                                                         <a href="#edit{{ $producttdata['unique_key'] }}" data-bs-toggle="modal"
                                                            data-id="{{ $producttdata['unique_key'] }}"
                                                            data-bs-target=".productedit-modal-xl{{ $producttdata['unique_key'] }}" class="badges bg-lightyellow" style="color: white">Edit</a>
                                                      </li>
                                                      <li>
                                                         <a href="#delete{{ $producttdata['unique_key'] }}" data-bs-toggle="modal"
                                                            data-id="{{ $producttdata['unique_key'] }}"
                                                            data-bs-target=".productdelete-modal-xl{{ $producttdata['unique_key'] }}" class="badges bg-lightgrey" style="color: white">Delete</a>
                                                      </li>
                                                </ul>
                                             </td>
                                          </tr>

                                          <div class="modal fade productedit-modal-xl{{ $producttdata['unique_key'] }}" tabindex="-1"
                                             role="dialog" data-bs-backdrop="static" aria-labelledby="producteditLargeModalLabel{{ $producttdata['unique_key'] }}"
                                             aria-hidden="true">
                                             @include('page.backend.product.edit')
                                          </div>

                                          <div class="modal fade productdelete-modal-xl{{ $producttdata['unique_key'] }}"
                                             tabindex="-1" data-bs-backdrop="static" role="dialog"
                                             aria-labelledby="productdeleteLargeModalLabel{{ $producttdata['unique_key'] }}"
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

         </div>

        <div class="modal fade product-modal-xl" tabindex="-1" data-bs-backdrop="static" role="dialog" aria-labelledby="productLargeModalLabel"
            aria-hidden="true">
            @include('page.backend.product.create')
        </div>


    </div>
@endsection
