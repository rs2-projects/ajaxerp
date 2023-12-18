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

        </div>

        <div class="submit-section mt-2">
            <button class="btn btn-primary submit-btn" type="submit">Save</button>
        </div>
    </div>
</form>
