@extends('layout.backend.auth')

@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Payment - Sales</h4>
            </div>
            <div class="page-btn">
                <div class="row">
                    <div style="display: flex;">
                        <form autocomplete="off" method="POST" action="{{ route('salespayment.datefilter') }}">
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
                            data-bs-toggle="modal" data-bs-target=".salespayment-modal-xl">Add Sales Payment</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
        @php

           preg_match("/[^\/]+$/", Request::url(), $matches);
       $pos = $matches[0];
       @endphp
            <div class="col-lg-2 col-sm-4 col-6">
                <a href="{{ route('salespayment.index') }}" style="color: black">
                    <div class="dash-widget" @if ($pos == "salespayment")
                    style="border-color:red; background-color: red;"
                    @endif>
                        <div class="dash-widgetcontent">
                            <h6 @if ($pos == "salespayment") style="font-weight: bold; color:white" @endif>All</h6>
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
                    <a href="{{ route('salespayment.branchdata', ['branch_id' => $allbranches->id]) }}" style="color: black">
                        <div class="dash-widget"@if ($last_word == $allbranches->id)
                            style="border-color:red; background-color: red;"
                    @endif>
                            <div class="dash-widgetcontent">
                                <h6 @if ($last_word == $allbranches->id) style="font-weight: bold; color:white" @endif>{{ $allbranches->shop_name }}</h6>
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
                                <th>Customer</th>
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
                                    <td>{{$P_PaymentData->customer_id }}</td>
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

        <div class="modal fade salespayment-modal-xl" tabindex="-1" role="dialog" aria-labelledby="salespaymentLargeModalLabel"
            aria-hidden="true" data-bs-backdrop="static">
            @include('page.backend.salespayment.create')
        </div>


    </div>
@endsection
