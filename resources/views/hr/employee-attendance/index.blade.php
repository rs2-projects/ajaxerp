@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        @if(hasPermission('manage-employee-attendance'))
            <div class="erp-add-employee-wrapper mb-3">
                <div class="erp-add-employee">
                    <a href="#" class="btn add-btn erp-add-employee" data-bs-toggle="modal" data-bs-target="#add_bulk_attendance_modal"><i class="fa-solid fa-plus"></i> Add Bulk Attendance</a>
                    <a href="#" class="btn add-btn erp-add-employee mx-2" data-bs-toggle="modal" data-bs-target="#add_attendance_modal"><i class="fa-solid fa-plus"></i> Add Attendance</a>

                </div>
            </div>
        @endif
        <div class="erp-employee-list-wrapper">
            <div class="erp-main-filter-wrapper bg-card attd-table">
                <div class="my-attendance-box-item flex-100 ">
                    <div class="my-attendance-report-wrapper">
                        <form>
                            <div class="erp-header-main-wrap d-flex justify-content-between align-items-center">

                                <div class="erp-filter-box d-flex align-items-center justify-content-start flex-100">

                                    <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-start">

                                        <div class="erp-filter-item flex-20">
                                            <div class="input-block erp-step-input-block ">
                                                <select class="select select-step" name="employee_id_search">
                                                    <option value="">Select Employee</option>
                                                    @foreach($getEmployees as $employee)
                                                        <option value="{{ $employee->id }}" {{ ($employee->id == request()->employee_id_search) ? 'selected' : '' }}>{{ $employee->full_name??'N/A' }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="erp-filter-item flex-20">
                                            <div class="input-block em-s-input-block mb-0">
                                                <label class="col-form-label">Start Date </label>
                                                <div class="cal-icon"><input class="form-control datetimepicker" value="{{ request()->start_date }}" name="start_date" type="text" ></div>
                                            </div>
                                        </div>
                                        <div class="erp-filter-item flex-20">
                                            <div class="input-block em-s-input-block mb-0">
                                                <label class="col-form-label ">End Date </label>
                                                <div class="cal-icon"><input class="form-control datetimepicker" value="{{ request()->end_date }}" name="end_date" type="text" ></div>
                                            </div>
                                        </div>
                                        <div class="erp-filter-item">
                                            <div class="erp-search-btn-wrap">
                                                <button class=" erp-search-btn" type="submit">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="big-table pt-4">
                            <div class="de-table-wrapper">
                                <div class="table-responsive">
                                    <table class="table mb-0 erp-table">
                                        <thead class="erp-thead">
                                            <tr class="erp-tr">
                                                <th class="erp-th">Employee </th>
                                                @if(!empty($result_dates))
                                                    @foreach($result_dates as $result_date)
                                                        <th class="erp-th text-center">{{ getFormattedDate($result_date,'d') }}</th>
                                                    @endforeach
                                                @endif
                                                {{--<th class="erp-th text-center">01 </th>
                                                <th class="erp-th text-center">02 </th>
                                                <th class="erp-th text-center">03 </th>
                                                <th class="erp-th text-center">04 </th>
                                                <th class="erp-th text-center">05 </th>
                                                <th class="erp-th text-center erp-weekend"><span>06 </span></th>
                                                <th class="erp-th text-center erp-weekend"><span>07</span></th>
                                                <th class="erp-th text-center">08 </th>
                                                <th class="erp-th text-center">09 </th>
                                                <th class="erp-th text-center">10 </th>
                                                <th class="erp-th text-center">11 </th>
                                                <th class="erp-th text-center">12 </th>
                                                <th class="erp-th text-center">13 </th>
                                                <th class="erp-th text-center">14 </th>
                                                <th class="erp-th text-center erp-holiday"> <span>15</span></th>
                                                <th class="erp-th text-center">16 </th>
                                                <th class="erp-th text-center">17 </th>
                                                <th class="erp-th text-center">18 </th>
                                                <th class="erp-th text-center">19 </th>
                                                <th class="erp-th text-center">20 </th>
                                                <th class="erp-th text-center">21 </th>
                                                <th class="erp-th text-center">22 </th>
                                                <th class="erp-th text-center">23 </th>
                                                <th class="erp-th text-center">24 </th>
                                                <th class="erp-th text-center">25 </th>
                                                <th class="erp-th text-center">26 </th>
                                                <th class="erp-th text-center">27 </th>
                                                <th class="erp-th text-center">28 </th>
                                                <th class="erp-th text-center">29 </th>
                                                <th class="erp-th text-center">30 </th>
                                                <th class="erp-th text-center">31 </th>--}}
                                            </tr>
                                        </thead>
                                        <tbody class="erp-tbody">
                                        @if(!empty($getEmployees))
                                            @foreach($getEmployees as  $employee)
                                                <tr class="erp-tbody-tr">

                                                    <td class="erp-tbody-td table-employee-name">
                                                        <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100">
                                                            <div class="em-pro-img-box">
                                                                <img src="{{ asset($employee->show_image) }}" alt="">
                                                            </div>
                                                            <div class="em-pro-details-box">
                                                                <h5>{{ $employee->full_name??'N/A' }}</h5>
                                                                <p class="em-id">ID: <span> #{{ $employee->employee_id??'N/A' }}</span></p>

                                                            </div>
                                                        </div>
                                                    </td>
                                                    @if(!empty($result_dates))
                                                        @foreach($result_dates as $result_date)
                                                            @php
                                                                $report = \App\Helpers\AttendanceHelper::getAttendanceReport($employee->id, $result_date);
                                                            @endphp
                                                            <td class="erp-tbody-td text-center">
                                                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#attendance_edit_info_modal" onclick="showAttendanceDetails({{ $employee->id }}, '{{ $result_date }}')" class="text-center d-table-title erp-{{ $report['show_status'] }}">
                                                                    <span class="attd-badge ">{!! $report['icon_status'] !!}</span>
                                                                </a>
                                                            </td>
                                                        @endforeach
                                                    @endif

                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
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
    @include('hr.employee-attendance._add_bulk_attendance_modal')
    @include('hr.employee-attendance._add_attendance_modal')

    <!-- Add Attendance Modal -->
    <div class="modal custom-modal fade" id="attendance_edit_info_modal" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
            </div>
        </div>
    </div>
@endsection

@section('css')

@endsection

@section('css_plugins')
    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}">
@endsection

@section('js_plugins')
    <!-- MULTI SELECT JS-->
    <script src="{{asset('assets/plugins/multipleselect/multiple-select.js')}}"></script>
    <script src="{{asset('assets/plugins/multipleselect/multi-select.js')}}"></script>

    <script src="{{ asset('assets/plugins/jquery-steps/jquery.steps.min.js') }}"></script>
    <!-- Datetimepicker JS -->
    <script src="{{asset('assets/js/moment.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap-datetimepicker.min.js')}}"></script>

@endsection

@section('js')
    <script>
        $(document).ready(function(){
            employeeSelect2();
            initializeDatepicker();

            $("#bulkAttendanceStoreForm").on('submit', function (e) {
                var self = this;
                e.preventDefault();
                var formData = new FormData($(self)[0]);
                $(".ie-span").text("").hide();
                var url = $(self).attr('action');

                formPost(url, formData, function (res) {
                    if(res.status == 200){
                        $("#add_bulk_attendance_modal").modal('hide');
                        $(self)[0].reset();
                        showSuccessAlert('Success',res.message)
                        // getData();
                        window.location.reload();
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');
            });

            $("#attendanceStoreForm").on('submit', function (e) {
                var self = this;
                e.preventDefault();
                var formData = new FormData($(self)[0]);
                $(".ie-span").text("").hide();
                var url = $(self).attr('action');

                formPost(url, formData, function (res) {
                    if(res.status == 200){
                        $("#add_attendance_modal").modal('hide');
                        $(self)[0].reset();
                        showSuccessAlert('Success',res.message)
                        // getData();
                        window.location.reload();
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');
            });

            $(document).on('submit', "#attendanceUpdateByDateForm", function (e) {
            // $("#attendanceUpdateByDateForm").on('submit', function (e) {
                var self = this;
                e.preventDefault();
                var formData = new FormData($(self)[0]);
                $(".ie-span").text("").hide();
                var url = $(self).attr('action');

                formPost(url, formData, function (res) {
                    if(res.status == 200){
                        $("#attendance_edit_info_modal").modal('hide');
                        $(self)[0].reset();
                        showSuccessAlert('Success',res.message)
                        // getData();
                        window.location.reload();
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');
            });

        });



        function getAttendanceInfo(){
            let date = $('#date_id').val();

            ajaxGet("{{ route('hr.employee-attendance.get-employees-by-attendance-date') }}", {date:date}, function (response) {
                if (response.status == 200) {
                    console.log(response);
                    $("#employee_ids").html(response.view);
                    employeeSelect2();
                } else {
                    toastr.error(response.message);
                }
            }, 'default');

            if(date){
                $('#attendanceDateSection').slideUp();
                $('#attendanceInfoSection').slideDown();
            }
        }

        function changeDate(){
            $('#attendanceDateSection').slideDown();
            $('#attendanceInfoSection').slideUp();
            employeeSelect2();
        }

        function employeeSelect2() {
            $('#employee_ids').multipleSelect({

                filter: true,
                placeholder: 'Select Employee',
                minimumCountSelected: 4,
                filterPlaceholder: 'Search Employee',
                selectAll: true,
                onOpen: function () {
                    $(".employee-multiselect .ms-drop ul>li:first-child label").contents().filter(function() {
                        return this.nodeType === 3;
                    }).replaceWith("Select All Employees");
                },
            });
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
    </script>

    <script>

        function showAttendanceDetails(employee_id, date) {
            var append_dom = $("#attendance_edit_info_modal .modal-content");
            var form_route = "{{ route('hr.employee-attendance.get-employee-attendance-edit-details-by-date') }}";
            var csrf_token = $('input[name="_token"]').val();

            $.ajax({
                type: "POST",
                url: form_route,
                data: {employee_id: employee_id, date: date, _token: csrf_token},
                success: function (response) {
                    console.log(response.html_view);
                    append_dom.html(response.html_view);
                }
            });
        }

        var last_flag = 1;

        function getAttendanceDetails() {
            var employee_id = $("#add_attendance_employee").val();
            var date = $("#add_attendance_date").val();
            if (employee_id == '') {
                alert("Please select employee.");
                return false;
            }
            if (date == '') {
                alert("Please select date.");
                return false;
            }
            var append_dom = $("#add_attendance_append_dom");
            var form_route = "{{ route('hr.employee-attendance.get-employee-attendance-activity-details-by-date') }}";
            var csrf_token = $('input[name="_token"]').val();

            $.ajax({
                type: "POST",
                url: form_route,
                data: {employee_id: employee_id, date: date, _token: csrf_token},
                success: function (html) {
                    append_dom.html(html.html_view);
                    last_flag = html.last_flag;
                }
            });
        }

        function editAttendance(attendance_id) {
            var append_dom = $("#attendance_edit_info_modal .modal-content");
            var form_route = "{{ route('hr.employee-attendance.get-employee-attendance-edit-details-by-date.edit-form') }}";
            var csrf_token = $('input[name="_token"]').val();

            $.ajax({
                type: "POST",
                url: form_route,
                data: {attendance_id: attendance_id, _token: csrf_token},
                success: function (response) {
                    append_dom.html(response.html_view);
                }
            });
        }


        /*function addNewAttendance() {
            var this_flag = 1;
            if (last_flag == 1) {
                last_flag = 2;
                this_flag = 1;
            } else {
                last_flag = 1;
                this_flag = 2;
            }
            var html_content = "<tr>\n" +
                "                        <td>\n";
            if (last_flag == 1) {
                html_content = html_content + "Punch Out\n";
            } else {
                html_content = html_content + "Punch In\n";
            }
            html_content = html_content + " </td>\n" +
                "                        <td>\n" +
                "                            <input type=\"hidden\" class=\"form-control\" name=\"flag[]\" value=\"" + this_flag + "\">\n" +
                "                            <input type=\"time\" class=\"form-control\" name=\"time[]\" required>\n" +
                "                        </td>\n" +
                "                    </tr>";

            console.log(html_content);
            $("#add_attendance_content_table tbody").append(html_content);
        }*/

        function addNewAttendance() {
            var this_flag = 1;
            if (last_flag == 1) {
                last_flag = 2;
                this_flag = 1;
            } else {
                last_flag = 1;
                this_flag = 2;
            }

            // Get the last time input value
            var lastTimeInput = $('#add_attendance_content_table tbody tr:last-child input[name="time[]"]');
            var lastTimeValue = lastTimeInput.val();

            var html_content = "<tr>\n" +
                "                        <td>\n";
            if (last_flag == 1) {
                html_content = html_content + "Punch Out\n";
            } else {
                html_content = html_content + "Punch In\n";
            }
            html_content = html_content + " </td>\n" +
                "                        <td>\n" +
                "                            <input type=\"hidden\" class=\"form-control\" name=\"flag[]\" value=\"" + this_flag + "\">\n" +
                "                            <input type=\"time\" class=\"form-control\" name=\"time[]\" required";

            // Set the min attribute based on the last time entry
            if (lastTimeValue) {
                html_content += " min=\"" + lastTimeValue + "\"";
            }

            html_content += ">\n" +
                "                        </td>\n" +
                "                    </tr>";

            console.log(html_content);
            $("#add_attendance_content_table tbody").append(html_content);
        }



        function removeLastRow() {
            if ($('#add_attendance_content_table tr').length > 1) {
                if (last_flag == 1) {
                    last_flag = 2;
                } else {
                    last_flag = 1;
                }
                $('#add_attendance_content_table tr:last').remove();
            }
        }

        function checkAttendanceAdd() {
            if($("#add_attendance_append_dom input[type='time']").val()) {
                return true;
            } else {
                alert("Please add at least 1 attendance.");
            }
            return false;
        }

    </script>
@endsection


