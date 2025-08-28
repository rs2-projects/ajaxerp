@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        <div class="erp-employee-list-wrapper">
            <div class="erp-main-filter-wrapper bg-card attd-table">
                <div class="my-attendance-box-item flex-100 ">
                    <div class="my-attendance-report-wrapper">
                        <div class="erp-header-main-wrap d-flex justify-content-between align-items-center">
                            <div class="erp-filter-box d-flex align-items-center justify-content-start flex-70">
                                <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-start flex-100">
                                    <div class="erp-filter-item">
                                        <h6 class="me-2">Search By: </h6>
                                    </div>
                                    <div class="erp-filter-item flex-20">
                                        <div class=" form-focus select-focus custom-form-focus">
                                            <input type="text" class="form-control search-product-in datetimepicker" id="date" placeholder="Date">

                                        </div>
                                    </div>
                                    <div class="erp-filter-item flex-25">
                                        <div class=" form-focus select-focus custom-form-focus">
                                            <input type="text" id="keyword_filtered" class="form-control search-product-in" placeholder="Product Name / Code">

                                        </div>
                                    </div>
                                    <div class="erp-filter-item">
                                        <div class="erp-search-btn-wrap">
                                            <button class=" erp-search-btn" type="button" onclick="getData()">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="erp-filter-item">
                                <div class="erp-search-btn-wrap">
                                    <button onclick="exportPDF()" class="erp-search-btn"><i class="fa fa-file"></i> Export PDF </button>
                                </div>
                            </div>
                        </div>

                        <div class="big-table pt-4">
                            <div class="de-table-wrapper" id="ajax-data-load">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End::row-1 -->
@endsection

@section('modals')
@endsection

@section('css')
    <style>
        .product-qrcode-img-box{
            width: 50px;
            height: 50px;
            margin-right: 7px;
        }
        .product-qrcode-img-box img{
            width: 100px;
            object-fit: cover;
            padding: 3px;
            border: 1px solid #ddd;
            border-radius: 7px;
        }
        
    </style>
@endsection

@section('css_plugins')
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}">
@endsection

@section('js_plugins')
    <!-- MULTI SELECT JS-->
    <script src="{{asset('assets/plugins/multipleselect/multiple-select.js')}}"></script>
    <script src="{{asset('assets/plugins/multipleselect/multi-select.js')}}"></script>
    <script src="{{asset('assets/js/moment.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap-datetimepicker.min.js')}}"></script>
    
@endsection

@section('js')
    <script>
        var filterData = {
            keyword_filtered: '',
            date: '',
        };
        $(document).ready(function() {
            initializeDatepicker();
            
            filterData.keyword_filtered = $("#keyword_filtered").val()
            $("#keyword_filtered").on('input', function () {
                filterData.keyword_filtered = $(this).val();
            });
            
            $('#date').on('dp.change', function(e){
                filterData.date = $(this).val();
            });

            getData();
        });

        function getData(){
            getPaginatedListData("{{ route('report.product-material-stock-report.filtered') }}", "#ajax-data-load", filterData);
        }

        function getPaginatedData(button) {
            getPaginatedListData($(button).attr('data-href'), "#ajax-data-load", filterData);
        }

        function exportPDF() {
            let url = "{{ route('report.product-material-stock-report.export-pdf') }}";
            url = url + "?keyword_filtered=" + filterData.keyword_filtered + "&date=" + filterData.date;
            window.open(url, '_blank');
        }

        function initializeDatepicker() {
            let today = moment().format('YYYY-MM-DD');
            $('.datetimepicker').datetimepicker({
                //format: 'DD/MM/YYYY',
                format: 'YYYY-MM-DD',
                defaultDate: today,
                icons: {
                    up: "fa fa-angle-up",
                    down: "fa-solid fa-angle-down",
                    next: 'fa-solid fa-angle-right',
                    previous: 'fa-solid fa-angle-left'
                }
            });
            filterData.date = today;
        }
    </script>
@endsection


