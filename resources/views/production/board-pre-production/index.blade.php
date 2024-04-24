@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        {{-- @if(hasPermission('manage-finished-goods')) --}}
            <div class="erp-add-employee-wrapper mb-3">
                <div class="erp-add-employee">
                    <a href="{{route('production.board-pre-production.create')}}" class="btn add-btn erp-add-employee ms-2" ><i class="fa-solid fa-plus"></i> Create Board Pre-Production </a>
                </div>
            </div>
        {{-- @endif --}}
        <div class="erp-employee-list-wrapper">
            <div class="erp-main-filter-wrapper bg-card attd-table">
                <div class="my-attendance-box-item flex-100 ">
                    <div class="my-attendance-report-wrapper">
                        <div class="erp-header-main-wrap d-flex justify-content-between align-items-center">
                            <div class="erp-filter-box d-flex align-items-center justify-content-end flex-100">
                                <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-end flex-100">
                                    <div class="erp-filter-item">
                                        <h6 class="me-2">Search By: </h6>
                                    </div>
                                    <div class="erp-filter-item flex-25">
                                        <div class=" form-focus select-focus custom-form-focus">
                                            <input type="text" id="keyword_filtered" class="form-control search-product-in" placeholder="Board Pre Production">

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
    @include('production.board-pre-production._send_to_production_modal')
@endsection

@section('css')
    <style>
        .unit-bottom{
            margin-bottom: 30px !important;
        }
        .estimated-output-wrapper {
            padding: 10px;
            border: 1px dashed #ddd;
            margin-bottom: 10px;
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
            category_filtered: ''
        };
        $(document).ready(function() {
            getData();
            filterData.keyword_filtered = $("#keyword_filtered").val()
            $("#keyword_filtered").on('input', function () {
                filterData.keyword_filtered = $(this).val();
            });
        });
        
        function getData(){
            getPaginatedListData("{{ route('production.board-pre-production.filtered') }}", "#ajax-data-load", filterData);
        }

        function getPaginatedData(button) {
            getPaginatedListData($(button).attr('data-href'), "#ajax-data-load", filterData);
        }

        function sendToProduction(id){
            let url = "{{route('production.board-pre-production.get-production-details', ':id')}}";
            url = url.replace(':id', id);
            ajaxGet(url, {}, function (response) {
                if (response.status == 200) {
                    $("#edit_data_modal_body").html(response.view);
                    $("#sendToProductionModal").modal('show');
                } else {
                    toastr.error(response.message);
                }
            }, 'default');
        }

    </script>
@endsection


