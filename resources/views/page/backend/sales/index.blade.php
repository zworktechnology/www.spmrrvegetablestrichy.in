@extends('layout.backend.auth')

@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Sales</h4>
            </div>
            <div style="display: flex;">
                <form autocomplete="off" method="POST" action="{{ route('sales.datefilter') }}" style="display: flex;">
                    @method('PUT')
                    @csrf
                    <div style="display: flex">
                        <div style="margin-right: 10px;"><input type="date" name="from_date" required
                                class="form-control from_date" value="{{ $today }}"></div>
                        <div style="margin-right: 10px;"><input type="submit" class="btn btn-success" value="Search" />
                        </div>
                    </div>
                </form>
                <a href="{{ route('sales.create') }}" class="btn btn-added">Add Sales</a>
            </div>
        </div>
        <div class="row py-2" style="margin-bottom:10px;">
        @php

           preg_match("/[^\/]+$/", Request::url(), $matches);
       $pos = $matches[0];
       @endphp
            <div class="col-lg-2 col-sm-4 col-6">
                <a href="{{ route('sales.index') }}" style="color: black">
                    <div class="dash-widget" @if ($pos == "sales")
                    style="color: black; border-color:red; background-color: #fff8f0; margin-bottom:18px;"
                    @endif>
                        <div class="dash-widgetcontent">
                            <h6 style="font-weight: bold;">All</h6>
                        </div>
                    </div>
                </a>
            </div>
                            @php
                            $lastword = Request::url();
                            preg_match("/[^\/]+$/", $lastword, $matches);
                            $last_word = $matches[0];
                            @endphp
            @foreach ($allbranch as $keydata => $allbranches)
                <div class="col-lg-2 col-sm-4 col-6">
                    <a href="{{ route('sales.branchdata', ['branch_id' => $allbranches->id]) }}" style="color: black">
                        <div class="dash-widget"  @if ($last_word == $allbranches->id)
                    style="color: black; border-color:red; background-color: #fff8f0;"
                    @endif>
                            <div class="dash-widgetcontent">
                                <h6 style="font-weight: bold;">{{ $allbranches->shop_name }}</h6>
                            </div>
                        </div>
                    </a>
                    <a href="#todaystock{{ $allbranches->id }}" data-bs-toggle="modal"data-id="{{ $allbranches->id }}"
                            data-bs-target=".todaystock-modal-xl{{ $allbranches->id }}" class="btn btn-added btn-primary " style="color:black;background-color: #e4c6bc !important;font-size: 13px;font-weight: 600;">{{ $allbranches->shop_name }} - Stock</a>

                            <div class="modal fade todaystock-modal-xl{{ $allbranches->id }}" tabindex="-1"role="dialog" data-bs-backdrop="static"
                                aria-labelledby="todaystockLargeModalLabel{{ $allbranches->id }}"aria-hidden="true">
                                @include('page.backend.sales.todaystock')
                            </div>
                </div>
            @endforeach
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table  customerdatanew">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Bill No</th>
                                <th>Customer</th>
                                <th>Branch</th>
                                <th>Product Details</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Sales_data as $keydata => $Sales_datas)
                                <tr>
                                    <td>{{ date('d-m-Y', strtotime($Sales_datas['date'])) }}</td>
                                    <td>#{{ $Sales_datas['bill_no'] }}</td>
                                    <td>{{ $Sales_datas['customer_name'] }}</td>
                                    <td>{{ $Sales_datas['branch_name'] }}</td>
                                    <td style="text-transform: uppercase;">
                                    @foreach ($Sales_datas['sales_terms'] as $index => $terms_array)
                                                    @if ($terms_array['sales_id'] == $Sales_datas['id'])
                                                    {{ $terms_array['product_name'] }} - {{ $terms_array['kgs'] }}{{ $terms_array['bag'] }},<br/>
                                                    @endif
                                                    @endforeach
                                    </td>
                                    <td>{{ $Sales_datas['gross_amount'] }}</td>
                                    <td>
                                        <ul class="list-unstyled hstack gap-1 mb-0">
                                        @if ($Sales_datas['date'] == $today_date)
                                            @if ($Sales_datas['status'] == 1)
                                                <li>
                                                    <a href="{{ route('sales.edit', ['unique_key' => $Sales_datas['unique_key']]) }}"
                                                        class="badges bg-lightyellow" style="color: white">Edit</a>
                                                </li>
                                            @endif
                                        @endif
                                            <li>
                                                <a href="#salesview{{ $Sales_datas['unique_key'] }}" data-bs-toggle="modal"
                                                    data-id="{{ $Sales_datas['id'] }}"
                                                    data-bs-target=".salesview-modal-xl{{ $Sales_datas['unique_key'] }}"
                                                    class="badges bg-lightred salesview" style="color: white">View</a>

                                            </li>
                                            <li>

                                                @if ($Sales_datas['status'] == 1)
                                                    <a href="{{ route('sales.print_view', ['unique_key' => $Sales_datas['unique_key']]) }}"
                                                        class="badges bg-green" style="color: white">Generated Invoice</a>
                                                @endif
                                            </li>


                                        </ul>
                                    </td>
                                </tr>

                                <div class="modal fade salesview-modal-xl{{ $Sales_datas['unique_key'] }}" tabindex="-1"
                                    role="dialog" data-bs-backdrop="static"
                                    aria-labelledby="salesviewLargeModalLabel{{ $Sales_datas['unique_key'] }}"
                                    aria-hidden="true">
                                    @include('page.backend.sales.view')
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>




    </div>
@endsection
