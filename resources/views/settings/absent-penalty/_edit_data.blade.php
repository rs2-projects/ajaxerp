<form action="{{ route('settings.absent-penalty.update', $item->id) }}" id="absentPenaltyUpdateForm" method="post">
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
                    <textarea class="form-control" rows="2" name="description"> {!! $item->description !!} </textarea>
                </div>
            </div>

            <div class="erp-filter-item flex-48">
                <div class="input-block erp-step-input-block mb-0 two">
                    <label class="col-form-label">Deduct Type <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Point Four Epos Solutions"><i class="fa-duotone fa-exclamation"></i></span></label>
                    <select class="select select-step select2" name="rate_type" required>
                        <option value="">Select Deduct Type</option>
                        @foreach(\App\Models\SettingsAbsentPenalty::RATE_TYPES as $key => $value)
                            <option value="{{ $key }}" {{ ($item->rate_type == $key) ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach

                    </select>
                    <span class="rate_type_error ie-span"></span>
                </div>
            </div>
            <div class="erp-filter-item flex-48">
                <div class="input-block erp-step-input-block mb-0 two">
                    <label class="col-form-label">Salary Type <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Point Four Epos Solutions"><i class="fa-duotone fa-exclamation"></i></span></label>
                    <select class="select select-step select2" name="salary_type" required>
                        <option value="">Select Salary Type</option>
                        @foreach(\App\Models\SettingsAbsentPenalty::SALARY_TYPES as $key => $value)
                            <option value="{{ $key }}" {{ ($item->salary_type == $key) ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach

                    </select>
                    <span class="salary_type_error ie-span"></span>
                </div>
            </div>
            <div class="erp-filter-item flex-100">
                <div class="input-block mb-0 erp-step-input-block ">
                    <label class="col-form-label">Deduct Value </label>
                    <input type="number" min="0" step="any" class="form-control" value="{{ $item->rate }}" required name="rate">
                    <span class="rate_error ie-span"></span>
                </div>
            </div>

        </div>

        <div class="submit-section mt-2">
            <button class="btn btn-primary submit-btn" type="submit">Save</button>
        </div>
    </div>
</form>
