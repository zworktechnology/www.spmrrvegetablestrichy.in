@extends('layout.backend.auth')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="dash-widget">
                    <div class="dash-widgetimg">
                        <span><img src="{{ asset('assets/backend/img/icons/dash1.svg') }}" alt="img"></span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5>$<span class="counters" data-count="307144.00">$307,144.00</span></h5>
                        <h6>Total Purchase Due</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="dash-widget dash1">
                    <div class="dash-widgetimg">
                        <span><img src="{{ asset('assets/backend/img/icons/dash2.svg') }}" alt="img"></span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5>$<span class="counters" data-count="4385.00">$4,385.00</span></h5>
                        <h6>Total Sales Due</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="dash-widget dash2">
                    <div class="dash-widgetimg">
                        <span><img src="{{ asset('assets/backend/img/icons/dash3.svg') }}" alt="img"></span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5>$<span class="counters" data-count="385656">385,656</span></h5>
                        <h6>Total Sale Amount</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="dash-widget dash3">
                    <div class="dash-widgetimg">
                        <span><img src="{{ asset('assets/backend/img/icons/dash4.svg') }}" alt="img"></span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5>$<span class="counters" data-count="40000.00">400.00</span></h5>
                        <h6>Total Sale Amount</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
