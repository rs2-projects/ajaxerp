@extends('layouts.settings-layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        <div class="erp-add-employee-wrapper mb-3">
            <div class="erp-add-employee">
                <a href="javascript:void(0)" class="btn add-btn erp-add-employee" data-bs-toggle="modal" data-bs-target="#add_office_time_modal"><i class="fa-solid fa-plus"></i> Add Office Time</a>

            </div>
        </div>

        <div class="erp-employee-list-wrapper">
            <div class="erp-main-filter-wrapper bg-card attd-table">
                <div class="my-attendance-box-item flex-100 ">
                    <div class="my-attendance-report-wrapper">
                        <div class="erp-header-main-wrap d-flex justify-content-between align-items-center">
                            <div class="erp-box-header">
                                <h4>Office Time </h4>
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
    @include('settings.office-time._add_office_time_modal')
    @include('settings.office-time._edit_office_time_modal')
@endsection

@section('css')

@endsection

@section('css_plugins')
@endsection

@section('js_plugins')
@endsection

@section('js')
    <script>
        $(document).ready(function(){
            getData();

            $(document).on("change", ".is_weekend_checkbox", function() {
            // $(".is_weekend_checkbox").on('change', function () {
                if ($(this).is(':checked')) {
                    let day = $(this).attr('data-day');
                    $("."+day+"_start_time").attr('required', false);
                    $("."+day+"_end_time").attr('required', false);
                } else {
                    let day = $(this).attr('data-day');
                    $("."+day+"_start_time").attr('required', true);
                    $("."+day+"_end_time").attr('required', true);
                }
            });

            $("#officeTimeStoreForm").on('submit', function (e) {
                var self = this;
                e.preventDefault();
                var formData = new FormData($(self)[0]);
                $(".ie-span").text("").hide();
                var url = $(self).attr('action');

                formPost(url, formData, function (res) {
                    if (res.status == 200) {
                        $("#add_office_time_modal").modal('hide');
                        $(self)[0].reset();
                        showSuccessAlert('Success',res.message)
                        getData();
                    } else {
                        showErrorAlert('Error',res.message)
                    }
                    getData();
                }, 'show_input_error');
            });

            $(document).on("submit", "#officeTimeStoreFormEdit", function(e) {
                var self = this;
                e.preventDefault();
                var formData = new FormData($(self)[0]);
                $(".ie-span").text("").hide();
                var url = $(self).attr('action');

                formPost(url, formData, function (res){
                    if(res.status == 200){
                        $("#edit_office_time_modal").modal('hide');
                        // $(self)[0].reset();
                        showSuccessAlert('Success',res.message)
                        getData();
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                    getData();
                }, 'show_input_error');
            });

        });

        function getData(){
            getPaginatedListData("{{ route('settings.office-time.filtered') }}", "#ajax-data-load");
        }

        function getPaginatedData(button) {
            getPaginatedListData($(button).attr('data-href'), "#ajax-data-load");
        }



        function editItem(id){
            let url = "{{route('settings.office-time.edit', ':id')}}";
            url = url.replace(':id', id);
            ajaxGet(url, {}, function (response) {
                if (response.status == 200) {
                    $("#edit_office_time_modal_body").html(response.view);
                    $("#edit_office_time_modal").modal('show');
                } else {
                    toastr.error(response.message);
                }
            }, 'default');
        }
    </script>
@endsection


