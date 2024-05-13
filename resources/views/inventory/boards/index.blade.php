@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        {{-- @if(hasPermission('manage-finished-goods')) --}}
            {{--<div class="erp-add-employee-wrapper mb-3">
                <div class="erp-add-employee">
                    <a href="javascript:void(0)" class="btn add-btn erp-add-employee ms-2" data-bs-toggle="modal" data-bs-target="#addBoardsModal"><i class="fa-solid fa-plus"></i> New Boards</a>
                </div>
            </div>--}}
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
                                            <input type="text" id="keyword_filtered" class="form-control search-product-in" placeholder="Product Name / Code">

                                        </div>
                                    </div>
                                    {{--<div class="erp-filter-item flex-20">
                                        <div class=" form-focus select-focus custom-form-focus">
                                            <select class="select floating select2-box" id="category_filtered">
                                                <option value="">Select Category</option>
                                                @foreach($finished_good_categories as $finished_goods_category)
                                                    <option value="{{ $finished_goods_category->id }}"> {{ $finished_goods_category->name }} </option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>--}}
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
{{--    @include('inventory.boards._add_boards_modal')--}}
{{--    @include('inventory.boards._edit_boards_modal')--}}
@endsection

@section('css')
    <style>
        .edit-img-src{
            margin-left: 5px;
            border-radius: 5px;
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

            filterData.category_filtered = $("#category_filtered").val()
            $("#category_filtered").on('change', function () {
                filterData.category_filtered = $(this).val();
            });

            $("#finishedGoodsStoreForm").on('submit', function (e) {
                var self = this;
                e.preventDefault();
                var formData = new FormData($(self)[0]);
                $(".ie-span").text("").hide();
                var url = $(self).attr('action');

                formPost(url, formData, function (res) {
                    if(res.status == 200){
                        $("#addBoardsModal").modal('hide');
                        $(self)[0].reset();
                        showSuccessAlert('Success',res.message)
                        getData();
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');

            });

            $(document).on("submit", "#boardUpdateForm", function(e) {
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                $(".ie-span").text("").hide();
                var url = $(this).attr('action');

                formPost(url, formData, function (res){
                    if(res.status == 200){
                        $("#editBoardsModal").modal('hide');
                        showSuccessAlert('Success',res.message)
                        getData();
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');
            });
        });

        function getData(){
            getPaginatedListData("{{ route('inventory.boards.filtered') }}", "#ajax-data-load", filterData);
        }

        function getPaginatedData(button) {
            getPaginatedListData($(button).attr('data-href'), "#ajax-data-load", filterData);
        }

        function editItem(id){
            let url = "{{route('inventory.boards.edit', ':id')}}";
            url = url.replace(':id', id);
            ajaxGet(url, {}, function (response) {
                if (response.status == 200) {
                    $("#edit_board_modal_body").html(response.view);
                    $("#editBoardsModal").modal('show');
                    initializeSelect()
                } else {
                    toastr.error(response.message);
                }
            }, 'default');
        }

        function initializeSelect() {
            $('.select-step').select2({
                minimumResultsForSearch: -1,
                width: '100%'
            });
        }

    </script>
@endsection


