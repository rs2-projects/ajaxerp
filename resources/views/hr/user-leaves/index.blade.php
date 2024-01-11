@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        <div class="erp-add-employee-wrapper mb-3">
            <div class="erp-add-employee">
                <a href="javascript:void(0)" class="btn add-btn erp-add-employee ms-2" data-bs-toggle="modal" data-bs-target="#add_user_leave"><i class="fa-solid fa-plus"></i> Add Leave</a>
            </div>
        </div>
        <div class="erp-employee-list-wrapper">
            <div class="erp-main-filter-wrapper bg-card attd-table">
                <div class="my-attendance-box-item flex-100 ">
                    <div class="erp-leave-tab-wrapper">
                        <ul class="nav nav-tabs erp-nav-tabs justify-content-center" id="myTab" role="tablist">
                            <li class="nav-item erp-nav-item" role="presentation">
                                <button class="nav-link active erp-nav-link" onclick="getData()" id="all-leave-tab" data-bs-toggle="tab" data-bs-target="#all-leave" type="button" role="tab" aria-controls="home" aria-selected="true">All</button>
                            </li>
                            <li class="nav-item erp-nav-item" role="presentation">
                                <button class="nav-link erp-nav-link" onclick="getData()" id="pending-leave-tab" data-bs-toggle="tab" data-bs-target="#pending-leave" type="button" role="tab" aria-controls="profile" aria-selected="false">Pending</button>
                            </li>
                            <li class="nav-item erp-nav-item" role="presentation">
                                <button class="nav-link erp-nav-link" onclick="getData()" id="approved-leave-tab" data-bs-toggle="tab" data-bs-target="#approved-leave" type="button" role="tab" aria-controls="contact" aria-selected="false">Approved</button>
                            </li>
                            <li class="nav-item erp-nav-item" role="presentation">
                                <button class="nav-link erp-nav-link" onclick="getData()" id="rejected-leave-tab" data-bs-toggle="tab" data-bs-target="#rejected-leave" type="button" role="tab" aria-controls="contact" aria-selected="false">Rejected</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="all-leave" role="tabpanel" aria-labelledby="all-leave-tab">
                                <div class="my-attendance-report-wrapper">
                                    <div class="erp-header-main-wrap d-flex justify-content-between align-items-center">
                                        <div class="erp-box-header">
                                            <h4>All Leave History </h4>
                                        </div>
                                        <div class="erp-filter-box d-flex align-items-center justify-content-end">

                                            <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-end">
                                                <div class="erp-filter-item">
                                                    <h6 class="me-2">Search By: </h6>
                                                </div>
                                                <div class="erp-filter-item">
                                                    <div class=" form-focus select-focus custom-form-focus">
                                                        <select class="select floating select2-box">
                                                            <option>Select Month</option>
                                                            <option>January</option>
                                                            <option>February</option>
                                                            <option>March</option>
                                                            <option>April</option>
                                                            <option>May</option>
                                                            <option>June</option>
                                                            <option>July</option>
                                                            <option>August</option>
                                                            <option>September</option>
                                                            <option>October</option>
                                                            <option>November</option>
                                                            <option>December</option>
                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="erp-filter-item">
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
                                                        <button class=" erp-search-btn">Search</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="big-table pt-4">
                                        <div class="de-table-wrapper">
                                            <div class="" id="ajax-data-load">

                                            </div>
                                        </div>
                                    </div>

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

@section('modals')
    @include('hr.user-leaves._add_user_leave_modal')
    @include('hr.user-leaves._edit_user_leave_modal')
    @include('hr.user-leaves._approve_user_leave_modal')
    @include('hr.user-leaves._reject_user_leave_modal')
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
            leave_status : null,
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

            $("#userLeavesStoreForm").on('submit', function (e) {
                var self = this;
                e.preventDefault();
                var formData = new FormData($(self)[0]);
                $(".ie-span").text("").hide();
                var url = $(self).attr('action');
                formPost(url, formData, function (res) {
                    if(res.status == 200){
                        $("#add_user_leave").modal('hide');
                        $(self)[0].reset();
                        // user and leave tregger change
                        $("#user_id").trigger('change');
                        $("#settings_leave_type_id").trigger('change');
                        showSuccessAlert('Success',res.message)
                        getData();
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');
            });

            $(document).on("submit", "#userLeaveUpdateForm", function(e) {
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                $(".ie-span").text("").hide();
                var url = $(this).attr('action');

                formPost(url, formData, function (res){
                    if(res.status == 200){
                        $("#edit_user_leave_modal").modal('hide');
                        showSuccessAlert('Success',res.message)
                        getData();
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');
            });
            $(document).on("submit", "#userLeaveApproveForm", function(e) {
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                $(".ie-span").text("").hide();
                var url = $(this).attr('action');

                formPost(url, formData, function (res){
                    if(res.status == 200){
                        $("#approve_user_leave_modal").modal('hide');
                        showSuccessAlert('Success',res.message)
                        getData();
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');
            });

            $(document).on("submit", "#userLeaveRejectForm", function(e) {
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                $(".ie-span").text("").hide();
                var url = $(this).attr('action');

                formPost(url, formData, function (res){
                    if(res.status == 200){
                        $("#reject_user_leave_modal").modal('hide');
                        showSuccessAlert('Success',res.message)
                        getData();
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');
            });

        });

        function getData(){
            var activeTab = $('.nav-tabs .nav-link.active').attr('id');
            switch (activeTab) {
                case 'pending-leave-tab':
                    filterData.leave_status = 0;
                    break;
                case 'approved-leave-tab':
                    filterData.leave_status = 1;
                    break;
                case 'rejected-leave-tab':
                    filterData.leave_status = 2;
                    break;
                default:
                    // For the 'All' tab or any other case
                    filterData.leave_status = null;
                    break;
            }

            getPaginatedListData("{{ route('hr.user-leaves.filtered') }}", "#ajax-data-load", filterData);
        }

        function getPaginatedData(button) {
            getPaginatedListData($(button).attr('data-href'), "#ajax-data-load", filterData);
        }

        function editItem(id){
            let url = "{{route('hr.user-leaves.edit', ':id')}}";
            url = url.replace(':id', id);
            ajaxGet(url, {}, function (response) {
                if (response.status == 200) {
                    console.log(response)
                    $("#edit_user_leave_modal_body").html(response.view);
                    $("#edit_user_leave_modal").modal('show');
                    initializeDatepicker();
                    leaveTypeSelect2();
                    yearSelect2()
                    monthSelect2()

                    $('#edit_month').change(function () {
                        updateAvailableDatesEdit();
                    });

                    // Handle change event on year select
                    $('#edit_year').change(function () {
                        updateAvailableDatesEdit();
                    });

                    editLeaveTypeChnage($("#edit_settings_leave_type_id"));
                    $('#edit_start_date').on('dp.change', function(e){
                        console.log('1');
                        updateNumberOfDaysEdit();
                    });
                    $('#edit_end_date').on('dp.change', function(e){
                        console.log('2');
                        updateNumberOfDaysEdit();
                    });
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

                    let approve_start_date = $('#approve_start_date').val();
                    let approve_end_date = $('#approve_end_date').val();
                    let firstDayOfMonth = moment(approve_start_date, 'YYYY-MM').startOf('month').format('YYYY-MM-DD');
                    let lastDayOfMonth = moment(approve_end_date, 'YYYY-MM').endOf('month').format('YYYY-MM-DD');

                    if(firstDayOfMonth > lastDayOfMonth) {
                        // Update datetimepicker options for "Date From" input
                        $('#approve_start_date').data('DateTimePicker').maxDate(lastDayOfMonth);
                        $('#approve_start_date').data('DateTimePicker').minDate(firstDayOfMonth);

                        // Update datetimepicker options for "Date To" input
                        $('#approve_end_date').data('DateTimePicker').maxDate(lastDayOfMonth);
                        $('#approve_end_date').data('DateTimePicker').minDate(firstDayOfMonth);
                    } else {
                        // Update datetimepicker options for "Date From" input
                        $('#approve_start_date').data('DateTimePicker').minDate(firstDayOfMonth);
                        $('#approve_start_date').data('DateTimePicker').maxDate(lastDayOfMonth);

                        // Update datetimepicker options for "Date To" input
                        $('#approve_end_date').data('DateTimePicker').minDate(firstDayOfMonth);
                        $('#approve_end_date').data('DateTimePicker').maxDate(lastDayOfMonth);
                    }

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
            let url = "{{route('hr.user-leaves.status-reject', ':id')}}";
            url = url.replace(':id', id);
            ajaxGet(url, {}, function (response) {
                if (response.status == 200) {
                    console.log(response)
                    $("#reject_user_leave_modal_body").html(response.view);
                    $("#reject_user_leave_modal").modal('show');
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
            let user_id = $("#user_id").val();
            let leave_type_id = $("#settings_leave_type_id").val();
            if (!user_id) {
                $("#number_of_days").val(0);
                toastr.error('Please select employee');
                return false;
            }
            if (!leave_type_id) {
                $("#number_of_days").val(0);
                toastr.error('Please select leave type');
                return false;
            }

            ajaxGet("{{ route('user.get-user-leave-number-of-days') }}", {start_date: startDate, end_date: endDate,leave_type_id:leave_type_id,user_id:user_id}, function (response) {
                if (response.status == 200) {
                    $("#number_of_days").val(response.general_days_number);
                } else {
                    toastr.error(response.message);
                }
            }, 'default');
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

            let user_id = $("#edit_user_id").val();
            let leave_type_id = $("#edit_settings_leave_type_id").val();
            if (!user_id) {
                $("#edit_number_of_days").val(0);
                toastr.error('Please select employee');
                return false;
            }
            if (!leave_type_id) {
                $("#edit_number_of_days").val(0);
                toastr.error('Please select leave type');
                return false;
            }

            ajaxGet("{{ route('user.get-user-leave-number-of-days') }}", {start_date: startDate, end_date: endDate,leave_type_id:leave_type_id,user_id:user_id}, function (response) {
                if (response.status == 200) {
                    $("#edit_number_of_days").val(response.general_days_number);
                } else {
                    toastr.error(response.message);
                }
            }, 'default');
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

            let user_id = $("#edit_user_id").val();
            let leave_type_id = $("#edit_settings_leave_type_id").val();
            if (!user_id) {
                $("#edit_number_of_days").val(0);
                toastr.error('Please select employee');
                return false;
            }
            if (!leave_type_id) {
                $("#edit_number_of_days").val(0);
                toastr.error('Please select leave type');
                return false;
            }

            ajaxGet("{{ route('user.get-user-leave-number-of-days') }}", {start_date: startDate, end_date: endDate,leave_type_id:leave_type_id,user_id:user_id}, function (response) {
                if (response.status == 200) {
                    $("#approve_number_of_days").val(response.general_days_number);
                } else {
                    toastr.error(response.message);
                }
            }, 'default');

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
        }

        function leaveTypeSelect2() {
            $('#edit_settings_leave_type_id').select2({
                minimumResultsForSearch: -1,
                width: '100%'
            });
        }

        function yearSelect2() {
            $('.year-select').select2({
                minimumResultsForSearch: -1,
                width: '100%'
            });
        }
        function monthSelect2() {
            $('.month-select').select2({
                minimumResultsForSearch: -1,
                width: '100%'
            });
        }

    </script>

    <!-- Your updated script for datetimepicker -->
    <script>
        $(document).ready(function () {
            // Initialize datetimepicker
            $('.datetimepicker').datetimepicker({
                format: 'YYYY-MM-DD',
                useCurrent: false,
                showClear: true,
                showClose: true
            });

            // Handle change event on month select
            $('#month').change(function () {
                updateAvailableDates();
            });

            // Handle change event on year select
            $('#year').change(function () {
                updateAvailableDates();
            });

        });

        let prev_first_date;
        let prev_last_date;
        // Function to update available dates based on selected month and year
        function updateAvailableDates() {
            var selectedMonth = $('#month').val();
            var selectedYear = $('#year').val();

            if (selectedMonth && selectedYear) {
                // Calculate the first day of the selected month and year
                var firstDayOfMonth = moment(selectedYear + '-' + selectedMonth, 'YYYY-MM').startOf('month').format('YYYY-MM-DD');
                // Calculate the last day of the selected month and year
                var lastDayOfMonth = moment(selectedYear + '-' + selectedMonth, 'YYYY-MM').endOf('month').format('YYYY-MM-DD');

                if(firstDayOfMonth > prev_last_date) {
                    // Update datetimepicker options for "Date From" input
                    $('#start_date').data('DateTimePicker').maxDate(lastDayOfMonth);
                    $('#start_date').data('DateTimePicker').minDate(firstDayOfMonth);

                    // Update datetimepicker options for "Date To" input
                    $('#end_date').data('DateTimePicker').maxDate(lastDayOfMonth);
                    $('#end_date').data('DateTimePicker').minDate(firstDayOfMonth);
                } else {
                    // Update datetimepicker options for "Date From" input
                    $('#start_date').data('DateTimePicker').minDate(firstDayOfMonth);
                    $('#start_date').data('DateTimePicker').maxDate(lastDayOfMonth);

                    // Update datetimepicker options for "Date To" input
                    $('#end_date').data('DateTimePicker').minDate(firstDayOfMonth);
                    $('#end_date').data('DateTimePicker').maxDate(lastDayOfMonth);
                }

                prev_first_date = firstDayOfMonth;
                prev_last_date = lastDayOfMonth;

                // Clear the selected dates
                $('#start_date').val("");
                $('#end_date').val("");
            }
        }

        let edit_prev_first_date;
        let edit_prev_last_date;
        function updateAvailableDatesEdit() {
            console.log('call function')
            var selectedMonth = $('#edit_month').val();
            var selectedYear = $('#edit_year').val();

            if (selectedMonth && selectedYear) {
                // Calculate the first day of the selected month and year
                var firstDayOfMonth = moment(selectedYear + '-' + selectedMonth, 'YYYY-MM').startOf('month').format('YYYY-MM-DD');
                // Calculate the last day of the selected month and year
                var lastDayOfMonth = moment(selectedYear + '-' + selectedMonth, 'YYYY-MM').endOf('month').format('YYYY-MM-DD');

                if(firstDayOfMonth > edit_prev_last_date) {
                    // Update datetimepicker options for "Date From" input
                    $('#edit_start_date').data('DateTimePicker').maxDate(lastDayOfMonth);
                    $('#edit_start_date').data('DateTimePicker').minDate(firstDayOfMonth);

                    // Update datetimepicker options for "Date To" input
                    $('#edit_end_date').data('DateTimePicker').maxDate(lastDayOfMonth);
                    $('#edit_end_date').data('DateTimePicker').minDate(firstDayOfMonth);
                } else {
                    // Update datetimepicker options for "Date From" input
                    $('#edit_start_date').data('DateTimePicker').minDate(firstDayOfMonth);
                    $('#edit_start_date').data('DateTimePicker').maxDate(lastDayOfMonth);

                    // Update datetimepicker options for "Date To" input
                    $('#edit_end_date').data('DateTimePicker').minDate(firstDayOfMonth);
                    $('#edit_end_date').data('DateTimePicker').maxDate(lastDayOfMonth);
                }

                edit_prev_first_date = firstDayOfMonth;
                edit_prev_last_date = lastDayOfMonth;

                // Clear the selected dates
                $('#edit_start_date').val("");
                $('#edit_end_date').val("");
            }
        }


    </script>

@endsection


