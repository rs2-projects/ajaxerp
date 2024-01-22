<form action="{{ route('settings.late-penalty.update', $item->id) }}" id="latePenaltyUpdateForm" method="post">
    @csrf
    <div class="erp-modal-body-content ">
        <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-3 ">
            <div class="erp-filter-item flex-100">
                <div class="input-block erp-step-input-block mb-0">
                    <label class="col-form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" value="{{ $item->title }}" required class="form-control"  >
                    <span class="title_error ie-span"></span>
                </div>
            </div>
            <div class="erp-filter-item flex-100">
                <div class="input-block erp-step-input-block mb-0">
                    <label class="col-form-label">Description </label>
                    <textarea class="form-control" rows="2" name="description">{!! $item->description !!}</textarea>
                </div>
            </div>

            <div class="erp-filter-item flex-100">
                <div class="input-block erp-step-input-block mb-0">
                    <label class="col-form-label">Late Count Time <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="in minutes" data-bs-original-title="in minutes"><i class="fa-duotone fa-exclamation"></i></span></label>
                    <input type="number" min="0" value="{{ $item->late_count_minutes }}" required name="late_count_minutes" class="form-control">
                    <span class="late_count_minutes_error ie-span"></span>
                </div>
            </div>

            <div class="erp-filter-item flex-48">
                <div class="input-block erp-step-input-block mb-0 two">
                    <label class="col-form-label">Salary Type <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Point Four Epos Solutions"><i class="fa-duotone fa-exclamation"></i></span></label>
                    <select class="select2 select-step" name="salary_type" required>
                        <option value="">Select Type</option>
                        <option value="0" {{($item->salary_type == 0) ? 'selected' : ''}}>Basic Salary</option>
                        <option value="1" {{($item->salary_type == 1) ? 'selected' : ''}}>Gross Salary</option>

                    </select>
                </div>
            </div>
            <div class="erp-filter-item flex-48">
                <div class="input-block mb-0 erp-step-input-block ">
                    <label class="col-form-label">Rate (%) </label>
                    <input type="number" step="any" class="form-control " value="{{$item->rate}}" name="rate" required>
                </div>
            </div>

        </div>

        <div class="submit-section mt-2">
            <button class="btn btn-primary submit-btn" type="submit">Save</button>
        </div>
    </div>
</form>
