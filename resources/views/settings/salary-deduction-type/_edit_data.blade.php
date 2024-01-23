<form action="{{ route('settings.salary-deduction-type.update',$item->id) }}" id="salaryDeductionTypeUpdateForm" method="post">
    @csrf
    <div class="erp-modal-body-content ">
        <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-3 ">
            <div class="input-block erp-step-input-block mb-2">
                <label class="col-form-label">Title<span class="text-danger">*</span></label>
                <input type="text" name="title" value="{{ $item->title }}" required class="form-control"  >
                <span class="title_error ie-span"></span>
            </div>
            <div class="erp-filter-item flex-48">
                <div class="input-block erp-step-input-block mb-0 two">
                    <label class="col-form-label">Rate Type </label>
                    <select class="select select-step select2" onchange="changeRateType(this.value)" name="rate_type" required>
                        <option value="">Select Type</option>
                        @foreach(\App\Models\SettingsSalaryDeductionType::RATE_TYPES as $key => $value)
                            <option value="{{ $key }}" {{ ($item->rate_type == $key) ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach

                    </select>
                    <span class="rate_type_error ie-span"></span>
                </div>
            </div>
            <div class="erp-filter-item flex-48">
                <div class="input-block erp-step-input-block mb-0 two hide-show-salary-type" style="display:{{ ($item->rate_type == $item::RATE_TYPE_FIXED_AMOUNT) ? 'none' : 'inline' }}">
                    <label class="col-form-label">Salary Type </label>
                    <select class="select select-step select2" name="salary_type">
                        <option value="">Select Salary Type</option>
                        @foreach(\App\Models\SettingsSalaryDeductionType::SALARY_TYPES_DROPDOWN as $key => $value)
                            <option value="{{ $key }}" {{ ($item->salary_type == $key) ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach

                    </select>
                    <span class="salary_type_error ie-span"></span>
                </div>
            </div>

            <div class="erp-filter-item flex-48">
                <div class="input-block mb-0 erp-step-input-block ">
                    <label class="col-form-label">Rate <span class="hide-show-value-symbol" style="display: {{ ($item->rate_type == $item::RATE_TYPE_FIXED_AMOUNT) ? 'none' : 'inline' }}">(%)</span></label>
                    <input type="number" min="0" step="any" value="{{ $item->rate }}" class="form-control" required name="rate">
                    <span class="rate_error ie-span"></span>
                </div>
            </div>
            <div class="input-block erp-step-input-block mb-2">
                <label class="col-form-label">Description</label>
                <textarea class="form-control" name="description" rows="2">{!! $item->description !!}</textarea>
            </div>
        </div>
        <div class="submit-section mt-2">
            <button class="btn btn-primary submit-btn" type="submit">Save</button>
        </div>

    </div>
</form>
