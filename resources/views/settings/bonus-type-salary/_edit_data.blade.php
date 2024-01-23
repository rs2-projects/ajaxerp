<form action="{{ route('settings.bonus-type-salary.update',$item->id) }}" id="bonusTypeSalaryFormEdit" method="post">
    @csrf
    <div class="erp-modal-body-content ">
        <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-3 ">
            <div class="erp-filter-item flex-48">
                <div class="input-block erp-step-input-block mb-0 two">
                    <label class="col-form-label">Bonus <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Select Bonus From Settings"><i class="fa-duotone fa-exclamation"></i></span></label>
                    <select class="select select-step select2" name="settings_bonus_type_id" required>
                        <option value="">Select Bonus</option>
                        @foreach($bonusTypes as $key=> $row)
                            <option value="{{ $row->id }}" {{($row->id == $item->settings_bonus_type_id) ? 'selected' : ''}}>{{ $row->title }}</option>
                        @endforeach
                    </select>
                    <span class="settings_bonus_type_id_error ie-span"></span>
                </div>
            </div>
            <div class="erp-filter-item flex-48">
                <div class="input-block erp-step-input-block mb-0 two">
                    <label class="col-form-label">Salary </label>
                    <select class="select select-step select2" name="settings_salary_type_id" required>
                        <option value="">Select Salary</option>
                        @foreach($salaryTypes as $key=> $row)
                            <option value="{{ $row->id }}" {{($row->id == $item->settings_salary_type_id) ? 'selected' : ''}}>{{ $row->title }}</option>
                        @endforeach
                    </select>
                    <span class="settings_salary_type_id_error ie-span"></span>
                </div>
            </div>

            <div class="erp-filter-item flex-48">
                <div class="input-block erp-step-input-block mb-0 two">
                    <label class="col-form-label">Type </label>
                    <select class="select select-step select2" onchange="changeRateType(this.value)" name="rate_type" required>
                        <option value="">Select Type</option>
                        @foreach(\App\Models\SettingsBonusTypeSalaryBonus::RATE_TYPES as $key => $value)
                            <option value="{{ $key }}" {{ ($item->rate_type == $key) ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                    <span class="rate_type_error ie-span"></span>
                </div>
            </div>
            <div class="erp-filter-item flex-48 hide-show-salary-type" style="display:{{ ($item->rate_type == $item::RATE_TYPE_FIXED_AMOUNT) ? 'none' : 'inline' }}">
                <div class="input-block erp-step-input-block mb-0 two">
                    <label class="col-form-label">Salary Type <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Point Four Epos Solutions"><i class="fa-duotone fa-exclamation"></i></span></label>
                    <select class="select select-step select2" name="salary_type">
                        <option value="">Select Salary Type</option>
                        @foreach(\App\Models\SettingsBonusTypeSalaryBonus::SALARY_TYPES_DROPDOWN as $key => $value)
                            <option value="{{ $key }}" {{ ($item->salary_type == $key) ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach

                    </select>
                    <span class="salary_type_error ie-span"></span>
                </div>
            </div>

            <div class="erp-filter-item flex-48">
                <div class="input-block mb-0 erp-step-input-block ">
                    <label class="col-form-label">Value <span class="hide-show-value-symbol" style="display: {{ ($item->rate_type == $item::RATE_TYPE_FIXED_AMOUNT) ? 'none' : 'inline' }}">(%)</span> </label>
                    <input type="number" min="0" value="{{ $item->rate }}" step="any" class="form-control" required name="rate">
                    <span class="rate_error ie-span"></span>
                </div>
            </div>
        </div>
        <div class="submit-section mt-2">
            <button class="btn btn-primary submit-btn" type="submit">Save</button>
        </div>

    </div>
</form>
