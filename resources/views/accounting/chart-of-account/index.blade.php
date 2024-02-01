@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        <div class="erp-add-employee-wrapper mb-3">
            <div class="erp-add-employee">

                <a href="#" class="btn add-btn erp-add-employee ms-2" data-bs-toggle="modal" data-bs-target="#new-account"><i class="fa-solid fa-plus"></i> Add a New Account</a>
            </div>
        </div>
        <div class="erp-employee-list-wrapper">
            <div class="erp-main-filter-wrapper bg-card attd-table" id="ajax-data-load">

            </div>
        </div>


    </div>
    <!--End::row-1 -->
@endsection

@section('modals')

@endsection

@section('css')

@endsection

@section('css_plugins')

@endsection

@section('js_plugins')

@endsection

@section('js')
    <script>
        var filterData = {
            keyword_filtered: ''
        };
        $(document).ready(function() {
            getData();
        });

        function getData(){
            getPaginatedListData("{{ route('accounting.chart-of-accounts.filtered') }}", "#ajax-data-load", filterData);
        }

        function getPaginatedData(button) {
            getPaginatedListData($(button).attr('data-href'), "#ajax-data-load", filterData);
        }
    </script>
@endsection


