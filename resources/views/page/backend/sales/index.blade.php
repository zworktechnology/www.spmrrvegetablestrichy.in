@extends('layout.backend.auth')

@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Sales</h4>
            </div>
            <div class="page-btn">
            <a href="{{ route('sales.create') }}" class="btn btn-added">Add Sales</a>
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
                                <th>Customer</th>
                                <th>Branch</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Sales_data as $keydata => $Sales_datas)
                                <tr>
                                    <td>#{{ $Sales_datas['bill_no'] }}</td>
                                    <td>{{ date('d M Y', strtotime($Sales_datas['date'])) }} - {{ date('h:i A', strtotime($Sales_datas['date'])) }}</td>
                                    <td>{{ $Sales_datas['customer_name'] }}</td>
                                    <td>{{ $Sales_datas['branch_name'] }}</td>
                                    <td>{{ $Sales_datas['gross_amount'] }}</td>
                                    <td>
                                        <ul class="list-unstyled hstack gap-1 mb-0">
                                            <li>

                                                <a href="{{ route('sales.edit', ['unique_key' => $Sales_datas['unique_key']]) }}" class="badges bg-lightyellow" style="color: white">Edit</a>
                                            </li>
                                            <li>
                                                <a href="#salesview{{ $Sales_datas['unique_key'] }}" data-bs-toggle="modal"
                                                    data-id="{{ $Sales_datas['id'] }}" 
                                                    data-bs-target=".salesview-modal-xl{{ $Sales_datas['unique_key'] }}"
                                                    class="badges bg-lightred salesview" style="color: white">View</a>
                                                
                                            </li>
                                            <li>
                                                <a href="{{ route('sales.invoice', ['unique_key' => $Sales_datas['unique_key']]) }}" class="badges bg-lightgreen" style="color: white">Invoice</a>
                                            </li>
                                            
                                        </ul>
                                    </td>
                                </tr>

                                <div class="modal fade salesview-modal-xl{{ $Sales_datas['unique_key'] }}"
                                    tabindex="-1" role="dialog" data-bs-backdrop="static"
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
