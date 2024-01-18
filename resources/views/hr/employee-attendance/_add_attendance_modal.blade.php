<!-- Add Attendance Modal -->
<div class="modal custom-modal fade" id="add_attendance_modal" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header erp-modal-header">
                <h5 class="modal-title">Add Attendance Info</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('hr.employee-attendance.attendance-store') }}" id="attendanceStoreForm" method="post" enctype = "multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between">
                                <div class="erp-filter-item flex-32">
                                    <div class="input-block erp-step-input-block mb-0">
                                        <label class="col-form-label">Select Employee <span class="text-danger">*</span></label>
                                        <select class="select select-step select2" id="add_attendance_employee" name="employee" required>
                                            <option value="">-</option>
                                            @if(!empty($employees))
                                                @foreach($employees as $employee)
                                                    <option value="{{ $employee->id }}" {{ ($employee->id == request()->employee)?'selected':'' }}>{{ $employee->full_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="erp-filter-item flex-32">
                                    <div class="input-block erp-step-input-block mb-0">
                                        <label class="col-form-label">Select Date<span class="text-danger">*</span></label>
                                        <div class="cal-icon"><input class="form-control datetimepicker" required name="date" id="add_attendance_date" type="text" ></div>
                                    </div>
                                </div>

                                <div class="erp-filter-item flex-32">
                                    <div class="erp-search-btn-wrap text-center">
                                        <button class="erp-search-btn text-center" type="button" onclick="getAttendanceDetails()">Get Details</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="add_attendance_append_dom">

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Add Attendance Modal -->
