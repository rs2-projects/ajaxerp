@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        <div class="erp-employee-list-wrapper">
            <div class="erp-main-filter-wrapper bg-card attd-table">
                <div class="my-attendance-box-item flex-100 ">
                    <div class="my-attendance-report-wrapper">
                        <div class="erp-header-main-wrap d-flex justify-content-between align-items-center">
                            {{-- <div class="erp-box-header">
                                <h4>Total Product : <span class="total-material-product" id="total_product">{{ $total_product }}</span> </h4>
                            </div> --}}
                            <div class="erp-filter-box d-flex align-items-center justify-content-start flex-70">

                                <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-start flex-100">
                                    <div class="erp-filter-item">
                                        <h6 class="me-2">Search By: </h6>
                                    </div>
                                    <div class="erp-filter-item flex-25">
                                        <div class=" form-focus select-focus custom-form-focus">
                                            <input type="text" id="keyword_filtered" class="form-control search-product-in" placeholder="Item Name">

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

                        {{-- <ul class="nav nav-tabs erp-nav-tabs justify-content-center status_type mt-4" id="myTab" role="tablist">
                            <li class="nav-item erp-nav-item" role="presentation">
                                <button class="nav-link active erp-nav-link" data="all" id="all-purchase-tab" data-bs-toggle="tab" data-bs-target="#all-purchase" type="button" role="tab" aria-controls="home" aria-selected="true">All</button>
                            </li>
                            <li class="nav-item erp-nav-item" role="presentation">
                                <button class="nav-link erp-nav-link" data="other" id="all-purchase-tab" data-bs-toggle="tab" data-bs-target="#all-purchase" type="button" role="tab" aria-controls="home" aria-selected="false">Other</button>
                            </li>
                            <li class="nav-item erp-nav-item" role="presentation">
                                <button class="nav-link erp-nav-link" data="board" id="all-purchase-tab" data-bs-toggle="tab" data-bs-target="#all-purchase" type="button" role="tab" aria-controls="home" aria-selected="false">Board</button>
                            </li>
                            <li class="nav-item erp-nav-item" role="presentation">
                                <button class="nav-link erp-nav-link" data="paper" id="new-purchase-tab" data-bs-toggle="tab" data-bs-target="#new-purchase" type="button" role="tab" aria-controls="profile" aria-selected="false">Paper</button>
                            </li>
                        </ul> --}}

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
    @include('inventory.reuse-items._details_modal')
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
            keyword_filtered: '',
            status_filtered: 'all',
        };
        $(document).ready(function() {
            getData();
            filterData.keyword_filtered = $("#keyword_filtered").val()
            $("#keyword_filtered").on('input', function () {
                filterData.keyword_filtered = $(this).val();
            });

            // $('.status_type li').on('click', function () {
            //     filterData.status_filtered = $('.status_type .active').attr('data');
            //     getData();
            // });
        });

        function getData(){
            getPaginatedListData("{{ route('inventory.reuse-items.filtered') }}", "#ajax-data-load", filterData);
        }

        function getPaginatedData(button) {
            getPaginatedListData($(button).attr('data-href'), "#ajax-data-load", filterData);
        }

        function reuseItemDetails(id) {
            let route = "{{ route('inventory.reuse-items.details', ':id') }}";
            route = route.replace(':id', id);
            ajaxGet(route, {}, function (response) {
                if (response.status == 200) {
                    $('#reuseItemDetailsModalBody').html(response.view);
                    $('#reuseItemDetailsModal').modal('show');
                } else {
                    showErrorAlert('',response.message);
                }
            });
        }
    </script>
@endsection


