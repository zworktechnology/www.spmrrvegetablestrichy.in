@extends('layout.backend.auth')

@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Payment - Purchase</h4>
            </div>
            <div class="page-btn">
                <div class="row">
                    <div style="display: flex;">
                        <form autocomplete="off" method="POST" action="{{ route('purchasepayment.datefilter') }}">
                            @method('PUT')
                            @csrf
                            <div style="display: flex">
                                <div style="margin-right: 10px;"><input type="date" name="from_date" required
                                        class="form-control from_date" value="{{ $today }}"></div>
                                <div style="margin-right: 10px;"><input type="submit" class="btn btn-success"
                                        value="Search" /></div>
                            </div>
                        </form>
                        <button type="button" class="btn btn-primary waves-effect waves-light btn-added"
                            data-bs-toggle="modal" data-bs-target=".purchasepayment-modal-xl">Add Payment</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-2 col-sm-4 col-6">
                <a href="{{ route('purchasepayment.index') }}" style="color: black">
                    <div class="dash-widget">
                        <div class="dash-widgetcontent">
                            <h6 style="font-weight: bold;">All</h6>
                        </div>
                    </div>
                </a>
            </div>
            @foreach ($allbranch as $keydata => $allbranches)
                <div class="col-lg-2 col-sm-4 col-6">
                    <a href="{{ route('purchasepayment.branchdata', ['branch_id' => $allbranches->id]) }}" style="color: black">
                        <div class="dash-widget">
                            <div class="dash-widgetcontent">
                                <h6 style="font-weight: bold;">{{ $allbranches->shop_name }}</h6>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table customerdatanew">
                        <thead>
                            <tr>
                                <th>Sl. No</th>
                                <th>Date</th>
                                <th>Branch</th>
                                <th>Supplier</th>
                                <th>Old Balance</th>
                                <th>Paid</th>
                                <th>Pending Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $keydata => $P_PaymentData)
                                <tr>
                                    <td>{{ ++$keydata }}</td>
                                    <td>{{ date('d M Y', strtotime($P_PaymentData->date)) }} -
                                        {{ date('h:i A', strtotime($P_PaymentData->time)) }}</td>
                                    <td>{{ $P_PaymentData->branch_id }}</td>
                                    <td>{{$P_PaymentData->supplier_id }}</td>
                                    <td>{{$P_PaymentData->oldblance }}</td>
                                    <td>{{ $P_PaymentData->amount }}</td>
                                    <td>{{ $P_PaymentData->payment_pending }}</td>
                                    
                                    
                                </tr>

                              
                               
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal fade purchasepayment-modal-xl" tabindex="-1" role="dialog" aria-labelledby="purchasepaymentLargeModalLabel"
            aria-hidden="true" data-bs-backdrop="static">
            @include('page.backend.purchasepayment.create')
        </div>


    </div>
@endsection
