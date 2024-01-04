@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        <div class="erp-add-employee-wrapper mb-3">
            <div class="erp-add-employee">
                <a href="javascript:void(0)" class="btn add-btn erp-add-employee" data-bs-toggle="modal" data-bs-target="#add_user_resignation_modal"><i class="fa-solid fa-plus"></i> Add Resignation</a>

            </div>
        </div>
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
                                            <input class="form-control" type="text" placeholder=" Name, ID, Department, Designation">
                                            <button class="btn position-absolute search-btn" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
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
    @include('hr.user-resignation._add_user_resignation_modal')
    @include('hr.user-resignation._edit_user_resignation_modal')
    @include('hr.user-resignation._reject_user_resignation_modal')
@endsection

@section('css')

@endsection

@section('css_plugins')
    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}">
@endsection

@section('js_plugins')
    <!-- Datetimepicker JS -->
    <script src="{{asset('assets/js/moment.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap-datetimepicker.min.js')}}"></script>
@endsection

@section('js')
    <script>
        var filterData = {
            keyword_filtered: '',
        };
        $(document).ready(function(){
            getData();
            initializeDatepicker();
            $('.nav-tabs .nav-link').on('click', function() {
                getData();
            });

            filterData.keyword_filtered = $("#keyword_filtered").val()

            $("#keyword_filtered").on('input', function () {
                filterData.keyword_filtered = $(this).val();
            });

            $("#userResignationStoreForm").on('submit', function (e) {
                var self = this;
                e.preventDefault();
                var formData = new FormData($(self)[0]);
                $(".ie-span").text("").hide();
                var url = $(self).attr('action');
                formPost(url, formData, function (res) {
                    if(res.status == 200){
                        $("#add_user_resignation_modal").modal('hide');
                        $(self)[0].reset();
                        showSuccessAlert('Success',res.message)
                        getData();
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');
            });

            $(document).on("submit", "#userResignationUpdateForm", function(e) {
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                $(".ie-span").text("").hide();
                var url = $(this).attr('action');

                formPost(url, formData, function (res){
                    if(res.status == 200){
                        $("#edit_user_resignation_modal").modal('hide');
                        showSuccessAlert('Success',res.message)
                        getData();
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');
            });

            $(document).on("submit", "#userResignationRejectForm", function(e) {
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                $(".ie-span").text("").hide();
                var url = $(this).attr('action');

                formPost(url, formData, function (res){
                    if(res.status == 200){
                        $("#reject_user_resignation_modal").modal('hide');
                        showSuccessAlert('Success',res.message)
                        getData();
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');
            });

        });

        function getData(){

            getPaginatedListData("{{ route('hr.user-resignation.filtered') }}", "#ajax-data-load", filterData);
        }

        function getPaginatedData(button) {
            getPaginatedListData($(button).attr('data-href'), "#ajax-data-load", filterData);
        }

        function editItem(id){
            let url = "{{route('hr.user-resignation.edit', ':id')}}";
            url = url.replace(':id', id);
            ajaxGet(url, {}, function (response) {
                if (response.status == 200) {
                    console.log(response)
                    $("#edit_user_resignation_modal_body").html(response.view);
                    $("#edit_user_resignation_modal").modal('show');
                    initializeDatepicker();
                    leaveTypeSelect2();
                } else {
                    toastr.error(response.message);
                }
            }, 'default');
        }
        function approveItem(id){
            let url = "{{route('hr.user-leaves.status-approve', ':id')}}";
            url = url.replace(':id', id);
            ajaxGet(url, {}, function (response) {
                if (response.status == 200) {
                    console.log(response)
                    $("#approve_user_leave_modal_body").html(response.view);
                    $("#approve_user_leave_modal").modal('show');
                    initializeDatepicker();
                    editLeaveTypeChnage($("#edit_settings_leave_type_id"));

                    $('#approve_start_date').on('dp.change', function(e){
                        console.log('1');
                        updateNumberOfDaysApprove();
                    });
                    $('#approve_end_date').on('dp.change', function(e){
                        console.log('2');
                        updateNumberOfDaysApprove();
                    });
                } else {
                    toastr.error(response.message);
                }
            }, 'default');
        }

        function rejectItem(id){
            let url = "{{route('hr.user-resignation.status-reject', ':id')}}";
            url = url.replace(':id', id);
            ajaxGet(url, {}, function (response) {
                if (response.status == 200) {
                    console.log(response)
                    $("#reject_user_resignation_modal_body").html(response.view);
                    $("#reject_user_resignation_modal").modal('show');
                } else {
                    toastr.error(response.message);
                }
            }, 'default');
        }

        function initializeDatepicker() {
            $('.datetimepicker').datetimepicker({
                //format: 'DD/MM/YYYY',
                format: 'YYYY-MM-DD',
                icons: {
                    up: "fa fa-angle-up",
                    down: "fa-solid fa-angle-down",
                    next: 'fa-solid fa-angle-right',
                    previous: 'fa-solid fa-angle-left'
                }
            });
        }

        $(document).ready(function () {
            $('#start_date').on('dp.change', function(e){
                updateNumberOfDays();
            });
            $('#end_date').on('dp.change', function(e){
                updateNumberOfDays();
            });
        });

        function updateNumberOfDays() {

           let startDate = $('#start_date').val();//2024-01-02
            let endDate = $('#end_date').val();//2024-01-04

            if(!startDate || !endDate) {
                $("#number_of_days").val(0);
                return false;
            }

            // Convert date strings to Date objects
            let startDateTime = new Date(startDate).getTime();
            let endDateTime = new Date(endDate).getTime();

            if(startDate > endDate) {
                $('#end_date').val('');
                $("#number_of_days").val(0);
                showInfoAlert('Oops!', 'End date can\'t be less then start date!');
                return false;
            }

            // Calculate the time difference in milliseconds
            let timeDifference = endDateTime - startDateTime;

            // Convert milliseconds to days
            let daysDifference = timeDifference / (1000 * 60 * 60 * 24);
            daysDifference += 1;
            $("#number_of_days").val(daysDifference);
        }
        function updateNumberOfDaysEdit() {
            console.log('3')
           let startDate = $('#edit_start_date').val();//2024-01-02
            let endDate = $('#edit_end_date').val();//2024-01-04

            if(!startDate || !endDate) {
                $("#edit_number_of_days").val(0);
                return false;
            }

            // Convert date strings to Date objects
            let startDateTime = new Date(startDate).getTime();
            let endDateTime = new Date(endDate).getTime();

            if(startDate > endDate) {
                $('#edit_end_date').val('');
                $("#edit_number_of_days").val(0);
                showInfoAlert('Oops!', 'End date can\'t be less then start date!');
                return false;
            }

            // Calculate the time difference in milliseconds
            let timeDifference = endDateTime - startDateTime;

            // Convert milliseconds to days
            let daysDifference = timeDifference / (1000 * 60 * 60 * 24);
            daysDifference += 1;
            $("#edit_number_of_days").val(daysDifference);
        }

        function updateNumberOfDaysApprove() {
            console.log('3')
           let startDate = $('#approve_start_date').val();//2024-01-02
            let endDate = $('#approve_end_date').val();//2024-01-04

            if(!startDate || !endDate) {
                $("#approve_number_of_days").val(0);
                return false;
            }

            // Convert date strings to Date objects
            let startDateTime = new Date(startDate).getTime();
            let endDateTime = new Date(endDate).getTime();

            if(startDate > endDate) {
                $('#approve_end_date').val('');
                $("#approve_number_of_days").val(0);
                showInfoAlert('Oops!', 'End date can\'t be less then start date!');
                return false;
            }

            // Calculate the time difference in milliseconds
            let timeDifference = endDateTime - startDateTime;

            // Convert milliseconds to days
            let daysDifference = timeDifference / (1000 * 60 * 60 * 24);
            daysDifference += 1;
            $("#approve_number_of_days").val(daysDifference);
        }

        function employeeChange(value){

            let user_id = $(value).val();
            let url = "{{ route('ajax.get-leave-type-by-user') }}"

            ajaxGet(url, {user_id: user_id}, function (response) {
                if (response.status == 200) {
                    $("#settings_leave_type_id").html(response.view);
                } else {
                    toastr.error(response.message);
                    // trigger change leave type
                    $("#settings_leave_type_id").html('<option value="">Select Leave Type</option>');
                    $("#settings_leave_type_id").trigger('change');
                }
            }, 'default');
        }

        function LeaveTypeChnage(value){
            let leave_type_id = $(value).val();
            let user_id = $("#user_id").val();
            let url = "{{ route('ajax.get-user-total-leave-by-leave-type') }}"

            ajaxGet(url, {leave_type_id: leave_type_id,user_id:user_id}, function (response) {
                if (response.status == 200) {
                    $("#remaining_leave").val(response.data.remaining_leaves);

                } else {
                    toastr.error(response.message);
                }
            }, 'default');
        }
        function editLeaveTypeChnage(value){
            console.log(value);
            let leave_type_id = $(value).val();
            let user_id = $("#edit_user_id").val();
            let userLeaveId = $("#userLeaveId").val();
            let url = "{{ route('ajax.get-user-total-leave-by-leave-type-edit') }}"

            ajaxGet(url, {leave_type_id: leave_type_id,user_id:user_id,userLeaveId:userLeaveId}, function (response) {
                if (response.status == 200) {
                    $("#edit_remaining_leave").val(response.data.remaining_leaves);

                } else {
                    toastr.error(response.message);
                }
            }, 'default');
        }function editLeaveTypeChnage(value){
            console.log(value);
            let leave_type_id = $(value).val();
            let user_id = $("#edit_user_id").val();
            let userLeaveId = $("#userLeaveId").val();
            let url = "{{ route('ajax.get-user-total-leave-by-leave-type-edit') }}"

            ajaxGet(url, {leave_type_id: leave_type_id,user_id:user_id,userLeaveId:userLeaveId}, function (response) {
                if (response.status == 200) {
                    $("#edit_remaining_leave").val(response.data.remaining_leaves);

                } else {
                    toastr.error(response.message);
                }
            }, 'default');
        }

        function leaveTypeSelect2() {
            $('#edit_settings_leave_type_id').select2({
                minimumResultsForSearch: -1,
                width: '100%'
            });
        }

    </script>

@endsection


