<form action="{{ route('hr.salary-set.update', $item->id) }}" id="salarySetUpdateForm" method="post">
    @csrf
    <div class="erp-modal-body-content">
        <section class="erp-em-general-info">
            <div class="erp-em-reg-step-wrapper d-flex flex-wrap flex-100">
                <div class="erp-em-reg-step-item flex-48">
                    <div class="input-block erp-step-input-block ">
                        <label class="col-form-label">Name: <span class="text-red">*</span></label>
                        <input class="form-control" name="name" value="{{ $item->name }}" required type="text" placeholder="Name">
                        <span class="name_error ie-span"></span>
                    </div>
                </div>
                <div class="erp-em-reg-step-item flex-48">
                    <div class="input-block erp-step-input-block ">
                        <label class="col-form-label">Description: </label>
                        <textarea  class="form-control" name="description" cols="1" rows="1">{!! $item->description !!}</textarea>
                    </div>
                </div>
                <div class="erp-em-reg-step-item flex-48">
                    <div class="input-block erp-step-input-block ">
                        <label class="col-form-label">Salary Type: <span class="text-danger">*</span></label>
                        <select class="select2 no-search-select-step" name="settings_salary_type_id" required>
                            <option value="">--Select An Option--</option>
                            @foreach($settingsSalaryTypes as $settingsSalaryType)
                                <option value="{{ $settingsSalaryType->id }}" {{ ($item->settings_salary_type_id == $settingsSalaryType->id) ? 'selected' : '' }}>{{ $settingsSalaryType->title }}</option>
                            @endforeach
                        </select>
                        <span class="settings_salary_type_id_error ie-span"></span>
                    </div>
                </div>
                <div class="erp-em-reg-step-item flex-48">
                    <div class="input-block erp-step-input-block ">
                        <label class="col-form-label">Over Time: <span class="text-danger">*</span></label>
                        <select class="select2 no-search-select-step" name="settings_overtime_type_id" required>
                            <option value="">--Select An Option--</option>
                            @foreach($settingsOverTimeTypes as $settingsOverTimeType)
                                <option value="{{ $settingsOverTimeType->id }}" {{ ($item->settings_overtime_type_id == $settingsOverTimeType->id) ? 'selected' : '' }}>{{ $settingsOverTimeType->title }}</option>
                            @endforeach
                        </select>
                        <span class="settings_overtime_type_id_error ie-span"></span>
                    </div>
                </div>
                <div class="erp-em-reg-step-item flex-48">
                    <div class="input-block erp-step-input-block ">
                        <label class="col-form-label">Absent Penalty: <span class="text-danger">*</span></label>
                        <select class="select2 no-search-select-step" name="settings_absent_penalty_id" required>
                            <option value="">--Select An Option--</option>
                            @foreach($settingsAbsentPenalties as $settingsAbsentPenalty)
                                <option value="{{ $settingsAbsentPenalty->id }}" {{ ($item->settings_absent_penalty_id == $settingsAbsentPenalty->id) ? 'selected' : '' }}>{{ $settingsAbsentPenalty->title }}</option>
                            @endforeach
                        </select>
                        <span class="settings_absent_penalty_id_error ie-span"></span>
                    </div>
                </div>
                <div class="erp-em-reg-step-item flex-48">
                    <div class="input-block erp-step-input-block ">
                        <label class="col-form-label">Late Penalty: <span class="text-danger">*</span></label>
                        <select class="select2 no-search-select-step" name="settings_late_penalty_id" required>
                            <option value="">--Select An Option--</option>
                            @foreach($settingsLatePenalties as $settingsLatePenalty)
                                <option value="{{ $settingsLatePenalty->id }}" {{ ($item->settings_late_penalty_id == $settingsLatePenalty->id) ? 'selected' : '' }}>{{ $settingsLatePenalty->title }}</option>
                            @endforeach
                        </select>
                        <span class="settings_late_penalty_id_error ie-span"></span>
                    </div>
                </div>
                <div class="erp-em-reg-step-item flex-48">
                    <div class="input-block erp-step-input-block ">
                        <label class="col-form-label">Office Time : <span class="text-danger">*</span></label>
                        <select class="select2 no-search-select-step" name="settings_office_time_type_id" required>
                            <option value="">--Select An Option--</option>
                            @foreach($settingsOfficeTimeTypes as $settingsOfficeTimeType)
                                <option value="{{ $settingsOfficeTimeType->id }}" {{ ($item->settings_office_time_type_id == $settingsOfficeTimeType->id) ? 'selected' : '' }}>{{ $settingsOfficeTimeType->name }}</option>
                            @endforeach
                        </select>
                        <span class="settings_office_time_type_id_error ie-span"></span>
                    </div>
                </div>
                <div class="erp-em-reg-step-item flex-48">
                    <div class="input-block erp-step-input-block ">
                        <label class="col-form-label">Pay Period : <span class="text-danger">*</span></label>
                        <select class="select2 no-search-select-step" name="salary_generate_type" required>
                            <option value="">--Select An Option--</option>
                            <option value="1" {{ ($item->salary_generate_type == 1) ? 'selected' : '' }}>Half Month</option>
                            <option value="2" {{ ($item->salary_generate_type == 2) ? 'selected' : '' }}>Full Month</option>
                        </select>
                        <span class="salary_generate_type_error ie-span"></span>
                    </div>
                </div>
            </div>
        </section>
        <div class="submit-section mt-2">
            <button class="btn btn-primary submit-btn" type="submit">Submit</button>
        </div>
    </div>
</form>
