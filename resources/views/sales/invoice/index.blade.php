@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        <div class="erp-add-employee-wrapper mb-3">
            <div class="erp-add-employee">

                <a href="{{ route('sales.invoice.create') }}" class="btn add-btn erp-add-employee ms-2" ><i class="fa-solid fa-plus"></i> Create Invoice</a>

            </div>
        </div>
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
                                            <input type="text" class="form-control search-product-in" placeholder="Invoice ID">

                                        </div>
                                    </div>
                                    <div class="erp-filter-item flex-15">
                                        <div class=" form-focus select-focus custom-form-focus">
                                            <select class="select floating select2-box" id="status_filter">
                                                <option>Select Invoice Status</option>
                                                @foreach($statuses as $key=>$status)
                                                    <option value="{{ $key }}"
                                                        {{ $key == request()->month ? 'selected' : '' }}>
                                                        {{ ucfirst($status) }}
                                                    </option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                    <div class="erp-filter-item flex-15">
                                        <div class=" form-focus select-focus custom-form-focus">
                                            <select class="select floating select2-box" id="month_filter">
                                                <option>Select Month</option>
                                                @foreach($months as $key=>$month)
                                                <option {{ $key==request()->month ? 'selected' : '' }} value="{{ $key }}">
                                                    {{ucfirst($month)}}
                                                </option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                    <div class="erp-filter-item flex-15">
                                        <div class=" form-focus select-focus custom-form-focus">
                                            <select class="select floating select2-box">
                                                <option>Select Year</option>
                                                <option>2023</option>
                                                <option>2022</option>
                                                <option>2021</option>
                                                <option>Last Year</option>
                                                <option>Last Two Years</option>

                                            </select>

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
    <!--End::row-1 -->
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
            status_filter: '',
            month_filter: ''
        };
        $(document).ready(function() {
            getData();
            filterData.status_filter = $("#status_filter").val()
            $("#status_filter").on('input', function () {
                filterData.status_filter = $(this).val();
            });

            filterData.month_filter = $("#month_filter").val()
            $("#month_filter").on('change', function () {
                filterData.month_filter = $(this).val();
            });
        });

        function getData(){
            getPaginatedListData("{{ route('sales.invoice.filtered') }}", "#ajax-data-load", filterData);
        }

        function getPaginatedData(button) {
            getPaginatedListData($(button).attr('data-href'), "#ajax-data-load", filterData);
        }

    </script>
@endsection
