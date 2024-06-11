@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        <div class="erp-add-employee-wrapper mb-3">
            @if(!empty($salary_set))
                <div class="erp-add-employee">
                    <a href="javascript:void(0)" class="btn add-btn erp-add-employee ms-2" data-bs-toggle="modal" data-bs-target="#add_user_leave"><i class="fa-solid fa-plus"></i> Add Leave</a>
                </div>
            @endif
        </div>
        <div class="erp-employee-list-wrapper">
            <div class="erp-main-filter-wrapper bg-card attd-table">
                <div class="my-attendance-box-item flex-100 ">
                    @if(empty($salary_set))
                        <div class="erp-leave-tab-wrapper" style="height: 56vh">
                            <div class="alert alert-danger" role="alert">
                                <h4>You have not been assigned any Salary Set. Please contact your HR or Admin.</h4>
                            </div>

                            <div>
                                <div class="punch-in-out-box position-relative">
                                    <div class="pulse-css"></div>
                                    <label class="switch punch-switch ">
                                        <div class="slider slider--0">No Access</div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="erp-leave-tab-wrapper">
                            <ul class="nav nav-tabs erp-nav-tabs justify-content-center" id="myTab" role="tablist">
                                <li class="nav-item erp-nav-item" role="presentation">
                                    <button class="nav-link active erp-nav-link" onclick="getData()" id="all-leave-tab" data-bs-toggle="tab" data-bs-target="#all-leave" type="button" role="tab" aria-controls="home" aria-selected="true">All</button>
                                </li>
                                <li class="nav-item erp-nav-item" role="presentation">
                                    <button class="nav-link erp-nav-link" onclick="getData()" id="pending-leave-tab" data-bs-toggle="tab" data-bs-target="#all-leave" type="button" role="tab" aria-controls="profile" aria-selected="false">Pending</button>
                                </li>
                                <li class="nav-item erp-nav-item" role="presentation">
                                    <button class="nav-link erp-nav-link" onclick="getData()" id="approved-leave-tab" data-bs-toggle="tab" data-bs-target="#all-leave" type="button" role="tab" aria-controls="contact" aria-selected="false">Approved</button>
                                </li>
                                <li class="nav-item erp-nav-item" role="presentation">
                                    <button class="nav-link erp-nav-link" onclick="getData()" id="rejected-leave-tab" data-bs-toggle="tab" data-bs-target="#all-leave" type="button" role="tab" aria-controls="contact" aria-selected="false">Rejected</button>
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
                    @endif
                </div>
            </div>
        </div>


    </div>
    <!--End::row-1 -->
@endsection

@section('modals')
    @include('user.leaves._add_user_leave_modal')
{{--    @include('user.leaves._edit_user_leave_modal')--}}
{{--    @include('user.leaves._approve_user_leave_modal')--}}
{{--    @include('user.leaves._reject_user_leave_modal')--}}
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
            yearSelect2()

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
                        $("#settings_leave_type_id").trigger('change');
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

            getPaginatedListData("{{ route('user.leaves.filtered') }}", "#ajax-data-load", filterData);
        }

        function getPaginatedData(button) {
            getPaginatedListData($(button).attr('data-href'), "#ajax-data-load", filterData);
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

            let leave_type_id = $("#settings_leave_type_id").val();
            if (!leave_type_id) {
                $("#number_of_days").val(0);
                toastr.error('Please select leave type');
                return false;
            }
            let user_id = "{{ auth()->user()->id }}"
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

        function LeaveTypeChnage(value){
            let leave_type_id = $(value).val();
            let user_id = "{{ auth()->user()->id }}"
            let url = "{{ route('ajax.get-user-total-leave-by-leave-type') }}"

            ajaxGet(url, {leave_type_id: leave_type_id,user_id:user_id}, function (response) {
                if (response.status == 200) {
                    $("#remaining_leave").val(response.data.remaining_leaves);

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
    </script>

@endsection


