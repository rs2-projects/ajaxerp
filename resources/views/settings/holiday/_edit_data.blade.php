<form action="{{ route('settings.holidays.update',$item->id) }}" id="holidayFormEdit" method="post">
    @csrf
    <div class="erp-modal-body-content ">
        <div class="input-block erp-step-input-block mb-2">
            <label class="col-form-label">Holiday Title <span class="text-danger">*</span></label>
            <input type="text" name="title" value="{{ $item->title }}" required class="form-control"  >
            <span class="title_error ie-span"></span>
        </div>
        <div class="input-block erp-step-input-block mb-2">
            <label class="col-form-label">Description </label>
            <input type="text" name="description" value="{{ $item->description }}" class="form-control" >
        </div>
        <div class="erp-date-range-offcanvas d-flex justify-content-between flex-wrap w-100">
            <div class="input-block erp-step-input-block mb-2 flex-48">
                <label class="col-form-label">Date From <span class="text-danger">*</span></label>
                <div class="cal-icon">
                    <input type="text" name="start_date" value="{{ $item->start_date }}" required class="form-control datetimepicker">
                    <span class="start_date_error ie-span"></span>
                </div>
            </div>
            <div class="input-block erp-step-input-block mb-2 flex-48">
                <label class="col-form-label">Date To <span class="text-danger">*</span></label>
                <div class="cal-icon">
                    <input type="text" name="end_date" value="{{ $item->end_date }}" required class="form-control datetimepicker">
                    <span class="end_date_error ie-span"></span>
                </div>
            </div>
        </div>

        <div class="submit-section mt-2">
            <button class="btn btn-primary submit-btn" type="submit">Save</button>
        </div>
    </div>
</form>
