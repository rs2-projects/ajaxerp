<!-- Add Attendance Modal -->
<div class="modal custom-modal fade" id="add_bulk_attendance_modal" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header erp-modal-header">
                <h5 class="modal-title">Add Attendance Info</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('hr.employee-attendance.bulk-attendance-store') }}" id="bulkAttendanceStoreForm" method="post" enctype = "multipart/form-data">
                    @csrf
                    <div class="row" id="attendanceDateSection">
                        <div class="col-md-12">
                            <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between">
                                <div class="erp-filter-item flex-48">
                                    <div class="input-block erp-step-input-block mb-0">
                                        <label class="col-form-label">Select Date<span class="text-danger">*</span></label>
                                        <div class="cal-icon"><input class="form-control datetimepicker"  name="date" id="date_id" type="text" ></div>
                                    </div>
                                </div>
                                <div class="erp-filter-item flex-48">
                                    <div class="erp-search-btn-wrap text-center">
                                        <button class="erp-search-btn text-center" type="button" onclick="getAttendanceInfo()">Get Details</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="display: none" id="attendanceInfoSection">
                        <div class="col-md-12">
                            <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between">

                                <div class="erp-filter-item flex-100">
                                    <div class="input-block erp-step-input-block mb-0">
                                        <label class="col-form-label">Select Employee <span class="text-danger">*</span></label>
                                        <select class="employee-multiselect" id="employee_ids" name="employee_ids[]" multiple="multiple" >

                                        </select>
                                    </div>
                                </div>
                                <div class="erp-filter-item flex-32">
                                    <div class="input-block em-s-input-block mb-0">
                                        <label class="col-form-label">Punch In </label>
                                        <div class="cal-icon-2"><input class="form-control" name="time_in" type="time" ></div>
                                    </div>
                                </div>
                                <div class="erp-filter-item flex-32">
                                    <div class="input-block em-s-input-block mb-0">
                                        <label class="col-form-label ">Punch Out </label>
                                        <div class="cal-icon-2"><input class="form-control " name="time_out" type="time" ></div>
                                    </div>
                                </div>
                                <div class="erp-filter-item flex-32">
                                    <div class="erp-search-btn-wrap text-center">
                                        <button class="erp-search-btn text-center" type="button" onclick="changeDate()">Change Date</button>
                                    </div>
                                </div>
                                <div class="erp-filter-item flex-100">
                                    <div class="erp-search-btn-wrap text-center">
                                        <button class=" erp-search-btn text-center" type="submit">Add Attendance</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Add Attendance Modal -->
