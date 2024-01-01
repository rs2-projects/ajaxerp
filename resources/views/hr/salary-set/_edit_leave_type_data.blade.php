<form action="{{ route('hr.salary-set.leave-type-set.update', $item->id) }}" id="leaveTypeSetUpdateForm" method="post">
    @csrf
    <div class="erp-modal-body-content">
        <section class="erp-em-general-info">
            <div class="erp-em-reg-step-wrapper d-flex flex-wrap flex-100">
                <div class="erp-em-reg-step-item flex-100">
                    <div class="input-block erp-step-input-block ">
                        <label class="col-form-label">Leave Types: <span class="text-danger">*</span></label>
                        <select class="select select-step" multiple name="settings_leave_type_id[]" id="settings_leave_type_id" required>
                            @foreach($settingsLeaveTypes as $settingsLeaveType)
                                <option value="{{ $settingsLeaveType->id }}" {{ in_array($settingsLeaveType->id, $selected_leave_type_ids) ? 'selected' : '' }}>{{ $settingsLeaveType->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </section>
        <div class="submit-section mt-2">
            <button class="btn btn-primary submit-btn" type="submit">Submit</button>
        </div>
    </div>
</form>
