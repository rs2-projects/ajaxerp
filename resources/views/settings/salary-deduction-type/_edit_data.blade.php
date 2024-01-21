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
                    <label class="col-form-label">Rate Type <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Point Four Epos Solutions"><i class="fa-duotone fa-exclamation"></i></span></label>
                    <select class="select select-step select2" name="rate_type" required>
                        <option value="">Select Type</option>
                        <option value="0" {{ ($item->rate_type == $item::RATE_TYPE_PERCENT) ? 'selected' : '' }}>Percentage</option>
                        <option value="1" {{ ($item->rate_type == $item::RATE_TYPE_FIXED_AMOUNT) ? 'selected' : '' }}>Flat</option>

                    </select>
                    <span class="rate_type_error ie-span"></span>
                </div>
            </div>
            <div class="erp-filter-item flex-48">
                <div class="input-block erp-step-input-block mb-0 two">
                    <label class="col-form-label">Salary Type <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Point Four Epos Solutions"><i class="fa-duotone fa-exclamation"></i></span></label>
                    <select class="select select-step select2" name="salary_type" required>
                        <option value="">Select Salary Type</option>
                        <option value="0" {{ ($item->salary_type == $item::SALARY_TYPE_BASIC_SALARY) ? 'selected' : '' }}>Basic Salary</option>
                        <option value="1" {{ ($item->salary_type == $item::SALARY_TYPE_GROSS_SALARY) ? 'selected' : '' }}>Gross Salary</option>

                    </select>
                    <span class="salary_type_error ie-span"></span>
                </div>
            </div>

            <div class="erp-filter-item flex-100">
                <div class="input-block mb-0 erp-step-input-block ">
                    <label class="col-form-label">Rate </label>
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
