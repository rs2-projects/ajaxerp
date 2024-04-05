@extends('production-staff.layouts.layout')
@section('content')

    <!-- Container-fluid starts-->
    <div class="container-fluid default-dashboard">
        <div class="row">
            <div class="col-12">
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
            </div>
            
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection


@section('css_plugins')
    <link rel="stylesheet" href="{{ asset('assets/css/external-css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/external-css/superadmin.css') }}">
@endsection

@section('js_plugins')
    <!-- Apex Chart -->
    <script src="{{ asset('assets') }}/plugins/chart/apex-chart/apex-chart.js"></script>
    <script src="{{ asset('assets') }}/plugins/chart/apex-chart/moment.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/chart/apex-chart/stock-prices.js"></script>


    <script src="{{ asset('assets') }}/js/default.js"></script>
    <script src="{{ asset('assets') }}/js/chart-widget.js"></script>
    <script src="{{ asset('assets') }}/plugins/chart/apex-chart/chart-custom.js"></script>


@endsection
