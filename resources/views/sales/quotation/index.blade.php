@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        @if(hasPermission('manage-invoices'))
            <div class="erp-add-employee-wrapper mb-3">
                <div class="erp-add-employee">
                    <a href="{{ route('sales.quotation.create') }}" class="btn add-btn erp-add-employee ms-2" ><i class="fa-solid fa-plus"></i> Create Quotation</a>
                </div>
            </div>
        @endif
        <div class="erp-employee-list-wrapper">
            <div class="erp-main-filter-wrapper bg-card attd-table">
                <div class="my-attendance-box-item flex-100 ">
                    <div class="my-attendance-report-wrapper">
                        <div class="erp-header-main-wrap d-flex justify-content-end align-items-center mb-4">

                            <div class="erp-filter-box d-flex align-items-center justify-content-end flex-100">

                                <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-end flex-100">
                                    <div class="erp-filter-item">
                                        <h6 class="me-2">Search By: </h6>
                                    </div>
                                    <div class="erp-filter-item flex-15">
                                        <div class=" form-focus select-focus custom-form-focus">
                                            <input type="text" class="form-control search-product-in" name="quotation_id"  id="quotation_id" placeholder="Quotation ID">

                                        </div>
                                    </div>
                                    <div class="erp-filter-item flex-15 ">
                                        <div class=" form-focus select-focus custom-form-focus">
                                            <input type="text" class="form-control search-product-in datetimepicker" id="start_date_filtered" placeholder="Start Date">

                                        </div>
                                    </div>
                                    <div class="erp-filter-item flex-15 ">
                                        <div class=" form-focus select-focus custom-form-focus">
                                            <input type="text" class="form-control search-product-in datetimepicker" id="end_date_filtered" placeholder="End Date">

                                        </div>
                                    </div>
                                    <div class="erp-filter-item">
                                        <div class="erp-search-btn-wrap">
                                            <button class=" erp-search-btn" onclick="getData()">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="my-attendance-report-wrapper">
                            <div class="big-table pt-4">
                                <div class="de-table-wrapper" id="ajax-data-load">

                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('modals')

@endsection
@section('css')
    <style>
        .delivered-status{
            display: inline-block;
            background: linear-gradient(to right, #55ce63 0, #37b34a 100%) !important;
            color: #fff !important;
            padding: 5px 20px;
            border-radius: 100px;
            line-height: 1;
        }
        .cancelled-status{
            display: inline-block;
            background: #ff0000;
            color: #fff !important;
            padding: 5px 20px;
            border-radius: 100px;
            line-height: 1;
        }
    </style>
@endsection

@section('css_plugins')
    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}">
@endsection

@section('js_plugins')
    <!-- Datetimepicker JS -->
    <script src="{{asset('assets/js/moment.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap-datetimepicker.min.js')}}"></script>
@endsection

@section('js')
    <script>
        var filterData = {
            quotation_id: '',
            status_filter: '',
            start_date_filtered:'',
            end_date_filtered:'',
        };
        $(document).ready(function() {
            getData();
            initializeDatepicker()
            filterData.quotation_id = $("#quotation_id").val()
            $("#quotation_id").on('input', function () {
                filterData.quotation_id = $(this).val();
            });
            $('#start_date_filtered').on('dp.change', function(e){
                filterData.start_date_filtered = $(this).val();
            });
            $('#end_date_filtered').on('dp.change', function(e){
                filterData.end_date_filtered = $(this).val();
            });

        });
        
        //get filtered data
        function getData(){
            getPaginatedListData("{{ route('sales.quotation.filtered') }}", "#ajax-data-load", filterData);
        }
        //get paginated data
        function getPaginatedData(button) {
            getPaginatedListData($(button).attr('data-href'), "#ajax-data-load", filterData);
        }
        //datepicker initialize
        function initializeDatepicker() {
            $('.datetimepicker').datetimepicker({
                //format: 'DD/MM/YYYY',
                format: 'YYYY-MM-DD',
                icons: {
                    up: "fa fa-angle-up",
                    down: "fa-solid fa-angle-down",
                    next: 'fa-solid fa-angle-right',
                    previous: 'fa-solid fa-angle-left'
                }
            });
        }
        

    </script>
@endsection
