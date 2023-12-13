@extends('layouts.settings-layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        <div class="erp-add-employee-wrapper mb-3">
            <div class="erp-add-employee">
                <a href="#" class="btn add-btn erp-add-employee" data-bs-toggle="modal" data-bs-target="#add_leave_type_modal"><i class="fa-solid fa-plus"></i> Add Leave Type</a>

            </div>
        </div>
        <div class="erp-employee-list-wrapper">
            <div class="erp-main-filter-wrapper bg-card attd-table">
                <div class="my-attendance-box-item flex-100 ">
                    <div class="my-attendance-report-wrapper">
                        <div class="erp-header-main-wrap d-flex justify-content-between align-items-center">
                            <div class="erp-box-header">
                                <h4>Leave type Setting </h4>
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
    @include('settings.leave-type._add_leave_type_modal')
    @include('settings.leave-type._edit_leave_type_modal')
@endsection

@section('css')

@endsection

@section('css_plugins')
    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}">
@endsection

@section('js_plugins')
    <!-- Datetimepicker JS -->
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{asset('assets/js/bootstrap-datetimepicker.min.js')}}"></script>
@endsection

@section('js')
    <script>
        $(document).ready(function(){
            getData();



            $("#leaveTypeStoreForm").on('submit', function (e) {
                var self = this;
                e.preventDefault();
                var formData = new FormData($(self)[0]);
                $(".ie-span").text("").hide();
                var url = $(self).attr('action');

                formPost(url, formData, function (res) {
                    $("#add_leave_type_modal").modal('hide');
                    $(self)[0].reset();
                    showSuccessAlert('Success',res.message)
                    getData();
                }, 'show_input_error');
            });

            $(document).on("submit", "#leaveTypeFormEdit", function(e) {
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                $(".ie-span").text("").hide();
                var url = $(this).attr('action');

                formPost(url, formData, function (res){
                    $("#edit_leave_type_modal").modal('hide');
                    showSuccessAlert('Success',res.message)
                    getData();
                }, 'show_input_error');
            });

        });

        function getData(){
            getPaginatedListData("{{ route('settings.leave-type.filtered') }}", "#ajax-data-load");
        }

        function getPaginatedData(button) {
            getPaginatedListData($(button).attr('data-href'), "#ajax-data-load");
        }



        function editItem(id){
            let url = "{{route('settings.leave-type.edit', ':id')}}";
            url = url.replace(':id', id);
            ajaxGet(url, {}, function (response) {
                if (response.status == 200) {
                    $("#edit_leave_type_modal_body").html(response.view);
                    $("#edit_leave_type_modal").modal('show');
                } else {
                    toastr.error(response.message);
                }
            }, 'default');
        }


    </script>
@endsection


