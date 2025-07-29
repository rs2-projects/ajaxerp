@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        <div class="erp-employee-list-wrapper">
            <div class="erp-main-filter-wrapper bg-card attd-table">
                <div class="my-attendance-box-item flex-100 ">
                    <div class="my-attendance-report-wrapper">
                        <div class="erp-header-main-wrap d-flex justify-content-start align-items-center">
                            <div class="erp-filter-box d-flex align-items-center justify-content-start flex-70">
                                <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-start flex-100">
                                    <div class="erp-filter-item">
                                        <h6 class="me-2">Search By: </h6>
                                    </div>
                                    <div class="erp-filter-item flex-25">
                                        <div class=" form-focus select-focus custom-form-focus">
                                            <input type="text" id="keyword_filtered" class="form-control search-product-in" placeholder="Product Name / Code">

                                        </div>
                                    </div>
                                    <div class="erp-filter-item flex-20">
                                        <div class=" form-focus select-focus custom-form-focus">
                                            <select class="select floating select2-box" id="stock_filter">
                                                <option value="">All Stock</option>
                                                <option value="stock_warning">Stock Warning</option>
                                                <option value="stock_alert">Stock Alert</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="erp-filter-item">
                                        <div class="erp-search-btn-wrap">
                                            <button class=" erp-search-btn" type="button" onclick="getData()">Search</button>
                                        </div>
                                    </div>
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

@endsection

@section('js_plugins')
    <!-- MULTI SELECT JS-->
    <script src="{{asset('assets/plugins/multipleselect/multiple-select.js')}}"></script>
    <script src="{{asset('assets/plugins/multipleselect/multi-select.js')}}"></script>
@endsection

@section('js')
    <script>
        var filterData = {
            keyword_filtered: '',
            stock_filter: '',
        };
        $(document).ready(function() {
            getData();
            
            filterData.keyword_filtered = $("#keyword_filtered").val()
            $("#keyword_filtered").on('input', function () {
                filterData.keyword_filtered = $(this).val();
            });
            filterData.stock_filter = $("#stock_filter").val()
            $("#stock_filter").on('change', function () {
                filterData.stock_filter = $(this).val();
            });
        });

        function getData(){
            getPaginatedListData("{{ route('report.product-material-stock-report.filtered') }}", "#ajax-data-load", filterData);
        }

        function getPaginatedData(button) {
            getPaginatedListData($(button).attr('data-href'), "#ajax-data-load", filterData);
        }
    </script>
@endsection


