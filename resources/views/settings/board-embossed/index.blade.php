@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        @if(hasPermission('manage-asset-product-category'))
            <div class="erp-add-employee-wrapper mb-3">
                <div class="erp-add-employee">
                    <a href="javascript:void(0)" class="btn add-btn erp-add-employee" data-bs-toggle="modal" data-bs-target="#addBoardEmbossedModal"><i class="fa-solid fa-plus"></i> Add Plate</a>
                    <a class="btn add-btn erp-add-employee me-2" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#plateImportModal">
                        <i class="fa-solid fa-file-import"></i> Import Plates
                    </a>
                </div>
            </div>
        @endif
        <div class="erp-employee-list-wrapper">
            <div class="erp-main-filter-wrapper bg-card attd-table">
                <div class="my-attendance-box-item flex-100 ">
                    <div class="my-attendance-report-wrapper">
                        <div class="erp-header-main-wrap d-flex justify-content-between align-items-center">
                            <div class="erp-filter-box d-flex align-items-center justify-content-start flex-100">
                                <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-start flex-100">
                                    <div class="erp-filter-item flex-7">
                                        <h6 class="me-2">Search By: </h6>
                                    </div>

                                    <div class="erp-filter-item flex-30">
                                        <div class="search-box table-search position-relative">
                                            <input class="form-control" type="text" id="keyword_filtered" placeholder="Name">
                                            <button class="btn position-absolute search-btn" type="button" onclick="getData()"><i class="fa-solid fa-magnifying-glass"></i></button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="table-main-wrapper pt-4" id="ajax-data-load">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End::row-1 -->
@endsection

@section('modals')
    @include('settings.board-embossed._add_board_embossed_modal')
    @include('settings.board-embossed._edit_board_embossed_modal')
    @include('settings.board-embossed.__plate_import_modal')
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

@endsection

@section('js')
    <script>
        var filterData = {
            keyword_filtered: ''
        };
        $(document).ready(function() {
            getData();

            filterData.keyword_filtered = $("#keyword_filtered").val()
            $("#keyword_filtered").on('input', function () {
                filterData.keyword_filtered = $(this).val();
            });

            $("#boardEmbossedStoreForm").on('submit', function (e) {
                var self = this;
                e.preventDefault();
                var formData = new FormData($(self)[0]);
                $(".ie-span").text("").hide();
                var url = $(self).attr('action');

                formPost(url, formData, function (res) {
                    if(res.status == 200){
                        $("#addBoardEmbossedModal").modal('hide');
                        $(self)[0].reset();
                        showSuccessAlert('Success',res.message)
                        getData();
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');
            });

            $(document).on("submit", "#boardEmbossedUpdateForm", function(e) {
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                $(".ie-span").text("").hide();
                var url = $(this).attr('action');

                formPost(url, formData, function (res){
                    if(res.status == 200){
                        $("#editBoardEmbossedModal").modal('hide');
                        showSuccessAlert('Success',res.message)
                        getData();
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');
            });

        });

        function getData(){
            getPaginatedListData("{{ route('settings.board-embossed.filtered') }}", "#ajax-data-load", filterData);
        }

        function getPaginatedData(button) {
            getPaginatedListData($(button).attr('data-href'), "#ajax-data-load", filterData);
        }

        function editItem(id){
            let url = "{{route('settings.board-embossed.edit', ':id')}}";
            url = url.replace(':id', id);
            ajaxGet(url, {}, function (response) {
                if (response.status == 200) {
                    $("#edit_category_modal_body").html(response.view);
                    $("#editBoardEmbossedModal").modal('show');
                } else {
                    toastr.error(response.message);
                }
            }, 'default');
        }

    </script>
@endsection


