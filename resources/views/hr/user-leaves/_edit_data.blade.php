<form action="{{ route('hr.user-leaves.update', $userLeave->id) }}" id="userLeaveUpdateForm" method="post">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between">
                <input type="hidden" value="{{ $userLeave->user_id }}" id="edit_user_id" name="user_id">
                <input type="hidden" value="{{ $userLeave->id }}" id="userLeaveId" name="user_leave_id">
                <div class="erp-filter-item flex-48">
                    <div class="input-block erp-step-input-block mb-0">
                        <label class="col-form-label">Leave Type <span class="text-danger">*</span></label>
                        <select class="select select-step" onchange="editLeaveTypeChnage(this)" name="settings_leave_type_id" id="edit_settings_leave_type_id" required>
                            {{--<option value="">Select Leave Type</option>--}}
                                @foreach($settingsLeaveTypes as $settingsLeaveType)
                                    <option value="{{$settingsLeaveType->id}}" {{ ($settingsLeaveType->id == $userLeave->settings_leave_type_id) ? 'selected' : '' }}>{{ $settingsLeaveType->title }} - Annual {{ $settingsLeaveType->annual_leave_days }} Days</option>
                                @endforeach
                        </select>
                    </div>
                </div>

                <div class="erp-filter-item flex-23">
                    <div class="input-block erp-step-input-block mb-0">
                        <label class="col-form-label">Month <span class="text-danger">*</span></label>
                        <select class="select select-step month-select"  name="month" id="edit_month" required>
                            <option value="">Select Month</option>
                            @foreach(config('commonData.month_names') as $key => $month)
                                <option value="{{$key}}" {{ ($key ==  \Carbon\Carbon::make($userLeave->approve_start_date)->format('m')) ? 'selected' : ''}}>{{ucfirst($month)}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="erp-filter-item flex-23">
                    <div class="input-block erp-step-input-block mb-0">
                        <label class="col-form-label">Year <span class="text-danger">*</span></label>
                        <select class="select select-step year-select"  name="year" id="edit_year" required>
                            <option value="">Select Year</option>
                            <option value="{{ \Carbon\Carbon::now()->subYear()->format('Y') }}" {{ (\Carbon\Carbon::now()->subYear()->format('Y') == \Carbon\Carbon::make($userLeave->approve_start_date)->format('Y') ? ' selected' : '') }}> {{\Carbon\Carbon::now()->subYear()->format('Y')}} </option>
                            <option value="{{ \Carbon\Carbon::now()->format('Y') }}" {{ (\Carbon\Carbon::now()->format('Y') == \Carbon\Carbon::make($userLeave->approve_start_date)->format('Y') ? ' selected' : '') }}> {{\Carbon\Carbon::now()->format('Y')}} </option>
                            <option value="{{ \Carbon\Carbon::now()->addYear()->format('Y') }}" {{ (\Carbon\Carbon::now()->addYear()->format('Y') == \Carbon\Carbon::make($userLeave->approve_start_date)->format('Y') ? ' selected' : '') }}> {{\Carbon\Carbon::now()->addYear()->format('Y')}} </option>
                        </select>
                    </div>
                </div>

                <div class="erp-filter-item flex-48">
                    <div class="input-block mb-0 erp-step-input-block">
                        <label class="col-form-label">Date From <span class="text-danger">*</span></label>
                        <div class="cal-icon">
                            <input type="text" class="form-control datetimepicker edit_start_date" value="{{ $userLeave->start_date }}" id="edit_start_date" name="start_date" autocomplete="off" required>
                        </div>
                    </div>
                </div>
                <div class="erp-filter-item flex-48">
                    <div class="input-block mb-0 erp-step-input-block">
                        <label class="col-form-label">Date To <span class="text-danger">*</span></label>
                        <div class="cal-icon">
                            <input type="text" class="form-control datetimepicker edit_end_date" value="{{ $userLeave->end_date }}" id="edit_end_date" name="end_date" autocomplete="off" required>
                        </div>
                    </div>
                </div>
                <div class="erp-filter-item flex-48">
                    <div class="input-block mb-0 erp-step-input-block">
                        <label class="col-form-label">Number of Days <span class="text-danger">*</span></label>
                        <input type="number" class="form-control " value="{{ $userLeave->number_of_days }}" name="number_of_days" id="edit_number_of_days" required readonly>
                    </div>
                </div>
                <div class="erp-filter-item flex-48">
                    <div class="input-block mb-0 erp-step-input-block">
                        <label class="col-form-label">Remaining Leave <span class="text-danger">*</span></label>
                        <input type="number" class="form-control " value="0" name="remaining_leave" id="edit_remaining_leave" readonly>
                    </div>
                </div>
                <div class="erp-filter-item flex-100">
                    <div class="input-block mb-0 erp-step-input-block">
                        <label class="col-form-label">Leave Reason <span class="text-danger">*</span></label>
                        <textarea  rows="4" class="form-control" name="reason">{!! $userLeave->reason !!}</textarea>
                    </div>
                </div>

                <div class="erp-filter-item flex-100 mt-4">
                    <div class="erp-search-btn-wrap text-center">
                        <button class=" erp-search-btn text-center" type="submit">Submit</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>
