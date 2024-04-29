<!-- Add Leave Modal -->
<div class="modal custom-modal fade" id="add_user_leave" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header erp-modal-header">
                <h5 class="modal-title">Add Leave</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('hr.user-leaves.store') }}" id="userLeavesStoreForm" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between">

                                <div class="erp-filter-item flex-48">
                                    <div class="input-block erp-step-input-block mb-0">
                                        <label class="col-form-label">Select Employee <span class="text-danger">*</span></label>
                                        <select class="select select-step" onchange="employeeChange(this)" name="user_id" id="user_id" required>
                                            <option value="">Select Employee</option>
                                            @foreach($employees as $employee)
                                                <option value="{{$employee->id}}">{{$employee->full_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="erp-filter-item flex-48">
                                    <div class="input-block erp-step-input-block mb-0">
                                        <label class="col-form-label">Leave Type <span class="text-danger">*</span></label>
                                        <select class="select select-step" onchange="LeaveTypeChnage(this)" name="settings_leave_type_id" id="settings_leave_type_id" required>
                                            <option value="">Select Leave Type</option>
{{--                                            @foreach($settingsLeaveTypes as $settingsLeaveType)--}}
{{--                                                <option value="{{$settingsLeaveType->id}}">{{$settingsLeaveType->title}}</option>--}}
{{--                                            @endforeach--}}
                                        </select>
                                    </div>
                                </div>
                                <div class="erp-filter-item flex-48">
                                    <div class="input-block erp-step-input-block mb-0">
                                        <label class="col-form-label">Month <span class="text-danger">*</span></label>
                                        <select class="select select-step"  name="month" id="month" required>
                                            <option value="">Select Month</option>
                                            @foreach(config('commonData.month_names') as $key => $month)
                                                <option value="{{$key}}">{{ucfirst($month)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="erp-filter-item flex-48">
                                    <div class="input-block erp-step-input-block mb-0">
                                        <label class="col-form-label">Year <span class="text-danger">*</span></label>
                                        <select class="select select-step year-select"  name="year" id="year" required>
                                            <option value="">Select Year</option>
                                            <option value="{{ \Carbon\Carbon::now()->subYear()->format('Y') }}"> {{\Carbon\Carbon::now()->subYear()->format('Y')}} </option>
                                            <option value="{{ \Carbon\Carbon::now()->format('Y') }}" selected> {{\Carbon\Carbon::now()->format('Y')}} </option>
                                            <option value="{{ \Carbon\Carbon::now()->addYear()->format('Y') }}"> {{\Carbon\Carbon::now()->addYear()->format('Y')}} </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="erp-filter-item flex-48">
                                    <div class="input-block mb-0 erp-step-input-block">
                                        <label class="col-form-label">Date From <span class="text-danger">*</span></label>
                                        <div class="cal-icon">
                                            <input type="text" class="form-control datetimepicker" id="start_date" name="start_date" autocomplete="off" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="erp-filter-item flex-48">
                                    <div class="input-block mb-0 erp-step-input-block">
                                        <label class="col-form-label">Date To <span class="text-danger">*</span></label>
                                        <div class="cal-icon">
                                            <input type="text" class="form-control datetimepicker" id="end_date" name="end_date" autocomplete="off" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="erp-filter-item flex-48">
                                    <div class="input-block mb-0 erp-step-input-block">
                                        <label class="col-form-label">Number of Days <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control " name="number_of_days" id="number_of_days" required readonly>
                                    </div>
                                </div>
                                <div class="erp-filter-item flex-48">
                                    <div class="input-block mb-0 erp-step-input-block">
                                        <label class="col-form-label">Remaining Leave <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control " value="0" name="remaining_leave" id="remaining_leave" readonly>
                                    </div>
                                </div>
                                <div class="erp-filter-item flex-100">
                                    <div class="input-block mb-0 erp-step-input-block">
                                        <label class="col-form-label">Leave Reason <span class="text-danger">*</span></label>
                                        <textarea  rows="4" class="form-control" name="reason"></textarea>
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
            </div>
        </div>
    </div>
</div>
