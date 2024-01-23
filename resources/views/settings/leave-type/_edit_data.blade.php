<form action="{{ route('settings.leave-type.update',$item->id) }}" id="leaveTypeFormEdit" method="post">
    @csrf
    <div class="erp-modal-body-content d-flex flex-wrap justify-content-between">
        <div class="erp-em-reg-step-item flex-100">
            <div class="input-block erp-step-input-block mb-2">
                <label class="col-form-label">Title<span class="text-danger">*</span></label>
                <input type="text" name="title" value="{{ $item->title }}" required class="form-control"  >
                <span class="title_error ie-span"></span>
            </div>
        </div>
        <div class="erp-em-reg-step-item flex-100">
            <div class="input-block erp-step-input-block mb-2">
                <label class="col-form-label">Description</label>
                <textarea class="form-control" name="description" rows="2"> {!! $item->description !!} </textarea>
            </div>
        </div>
        <div class="erp-em-reg-step-item flex-48">
            <div class="input-block erp-step-input-block mb-2">
                <label class="col-form-label">Number of Days (Annual) <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Point Four Epos Solutions"><i class="fa-duotone fa-exclamation"></i></span></label>
                <input type="number" name="annual_leave_days" value="{{ $item->annual_leave_days??0 }}" required class="form-control"  >
                <span class="annual_leave_days_error ie-span"></span>
            </div>
        </div>
        <div class="erp-em-reg-step-item flex-48">
            <div class="input-block erp-step-input-block mb-2">
                <label class="col-form-label">Max Leave per Month <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Point Four Epos Solutions"><i class="fa-duotone fa-exclamation"></i></span></label>
                <input type="number" name="max_leave_per_month" value="{{ $item->max_leave_per_month??0 }}" class="form-control"  >
                <span class="max_leave_per_month_error ie-span"></span>
            </div>
        </div>

        <div class="erp-filter-item flex-100 mt-4 mb-2">
            <h4 class="offcanvas-title-erp">Extra Leave Penalty Settings</h4>
        </div>

        <div class="erp-filter-item flex-48">
            <div class="input-block erp-step-input-block mb-0 two">
                <label class="col-form-label">Salary Type <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Point Four Epos Solutions"><i class="fa-duotone fa-exclamation"></i></span></label>
                <select class="select select2 " name="salary_type" required>
                    <option value="">Select Type</option>
                    <option value="0" {{($item->salary_type == $item::SALARY_TYPE_BASIC_SALARY) ? 'selected' : ''}}>Basic Salary</option>
                    <option value="1" {{($item->salary_type == $item::SALARY_TYPE_GROSS_SALARY) ? 'selected' : ''}}>Gross Salary</option>

                </select>
            </div>
        </div>
        <div class="erp-filter-item flex-48">
            <div class="input-block mb-0 erp-step-input-block ">
                <label class="col-form-label">Rate (%) </label>
                <input type="number" step="any" class="form-control " name="rate" required value="{{$item->rate}}">
            </div>
        </div>

        <div class="erp-em-reg-step-item flex-100">
            <div class="submit-section mt-2">
                <button class="btn btn-primary submit-btn" type="submit">Save</button>
            </div>
        </div>
    </div>
</form>
