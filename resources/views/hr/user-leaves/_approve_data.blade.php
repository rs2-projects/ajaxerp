<form action="{{ route('hr.user-leaves.status-approve', $userLeave->id) }}" id="userLeaveApproveForm" method="post">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between">
                <input type="hidden" value="{{ $userLeave->settings_leave_type_id }}" id="edit_settings_leave_type_id">
                <input type="hidden" value="{{ $userLeave->user_id }}" id="edit_user_id">
                <input type="hidden" value="{{ $userLeave->id }}" id="userLeaveId" >
                <div class="erp-filter-item flex-48">
                    <div class="input-block mb-0 erp-step-input-block">
                        <label class="col-form-label">Date From <span class="text-danger">*</span></label>
                        <div class="cal-icon">
                            <input type="text" class="form-control datetimepicker edit_start_date" value="{{ $userLeave->start_date }}" id="approve_start_date" name="start_date" autocomplete="off" required>
                        </div>
                    </div>
                </div>
                <div class="erp-filter-item flex-48">
                    <div class="input-block mb-0 erp-step-input-block">
                        <label class="col-form-label">Date To <span class="text-danger">*</span></label>
                        <div class="cal-icon">
                            <input type="text" class="form-control datetimepicker edit_end_date" value="{{ $userLeave->end_date }}" id="approve_end_date" name="end_date" autocomplete="off" required>
                        </div>
                    </div>
                </div>
                <div class="erp-filter-item flex-48">
                    <div class="input-block mb-0 erp-step-input-block">
                        <label class="col-form-label">Number of Days <span class="text-danger">*</span></label>
                        <input type="number" class="form-control " value="{{ $userLeave->number_of_days }}" name="number_of_days" id="approve_number_of_days" required readonly>
                    </div>
                </div>
                <div class="erp-filter-item flex-48">
                    <div class="input-block mb-0 erp-step-input-block">
                        <label class="col-form-label">Remaining Leave <span class="text-danger">*</span></label>
                        <input type="number" class="form-control " value="0" name="remaining_leave" id="edit_remaining_leave" readonly>
                    </div>
                </div>
                {{--<div class="erp-filter-item flex-100">
                    <div class="input-block mb-0 erp-step-input-block">
                        <label class="col-form-label">Leave Reason <span class="text-danger">*</span></label>
                        <textarea  rows="4" class="form-control" name="reason">{!! $userLeave->reason !!}</textarea>
                    </div>
                </div>--}}

                <div class="erp-filter-item flex-100 mt-4">
                    <div class="erp-search-btn-wrap text-center">
                        <button class=" erp-search-btn text-center" type="submit">Submit</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>
