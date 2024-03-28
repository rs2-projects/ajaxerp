@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        @if(hasPermission('manage-employees'))
            <div class="erp-add-employee-wrapper mb-3">
                <div class="erp-add-employee">
                    <a href="{{ route('hr.employee.create') }}" class="btn add-btn erp-add-employee ms-2" ><i class="fa-solid fa-plus"></i> Add Employee</a>
                    {{-- <a href="#" class="btn add-btn erp-add-employee ms-2" data-bs-toggle="modal" data-bs-target="#import_employee"><i class="fa-solid fa-plus"></i>Import</a>
                    <a href="#" class="btn add-btn erp-add-employee" ><i class="fa-solid fa-plus"></i> Export</a> --}}
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
                                    <div class="erp-filter-item flex-5">
                                        <h6 class="me-2">Search By: </h6>
                                    </div>

                                    <div class="erp-filter-item flex-30">
                                        <div class="search-box table-search position-relative">
                                            <input class="form-control" type="text" id="keyword_filtered" placeholder=" Name, ID, Phone, Email">
                                            <button class="btn position-absolute search-btn" onclick="getData()" type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
                                        </div>
                                    </div>
                                    <div class="erp-filter-item flex-63 text-end">
                                        <div class="erp-filter-by d-flex align-items-center justify-content-end">
                                            <a href="#" data-bs-toggle="offcanvas" data-bs-target="#filter-by" aria-controls="offcanvasRight"><span class="me-1"><i class="fa-solid fa-arrow-up-wide-short"></i></span>Filter</a>
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
    @include('hr.employee._change_role')
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

            filterData.keyword_filtered = $("#keyword_filtered").val()
            $("#keyword_filtered").on('input', function () {
                filterData.keyword_filtered = $(this).val();
            });

            $("#designationStoreForm").on('submit', function (e) {
                var self = this;
                e.preventDefault();
                var formData = new FormData($(self)[0]);
                $(".ie-span").text("").hide();
                var url = $(self).attr('action');

                formPost(url, formData, function (res) {
                    if (res.status == 200) {
                        $("#add_designation_modal").modal('hide');
                        $(self)[0].reset();
                        showSuccessAlert('Success', res.message)
                        getData();
                    } else {
                        showErrorAlert('Error', res.message)
                    }
                }, 'show_input_error');
            });

            $(document).on("submit", "#changeRoleUpdateForm", function(e) {
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                $(".ie-span").text("").hide();
                var url = $(this).attr('action');

                formPost(url, formData, function (res){
                    if(res.status == 200){
                        $("#editRoleModal").modal('hide');
                        showSuccessAlert('Success',res.message)
                        getData();
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');
            });
        });

        function getData(){
            getPaginatedListData("{{ route('hr.employee.filtered') }}", "#ajax-data-load", filterData);
        }

        function getPaginatedData(button) {
            getPaginatedListData($(button).attr('data-href'), "#ajax-data-load", filterData);
        }

        function editRole(id){
            let url = "{{route('hr.employee.edit-role', ':id')}}";
            url = url.replace(':id', id);
            ajaxGet(url, {}, function (response) {
                if (response.status == 200) {
                    $("#edit_role_modal_body").html(response.view);
                    $("#editRoleModal").modal('show');
                    initializeSelect()
                } else {
                    toastr.error(response.message);
                }
            }, 'default');
        }

        function initializeSelect() {
            $('.select2').select2({
                minimumResultsForSearch: -1,
                width: '100%'
            });
        }

    </script>
@endsection


