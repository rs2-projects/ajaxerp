<form action="{{ route('settings.over-time-type.update',$item->id) }}" id="overTimeStoreFormEdit" method="post">
    @csrf
    <div class="erp-modal-body-content ">
        <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-3 ">
            <div class="erp-filter-item flex-100">
                <div class="input-block erp-step-input-block mb-0">
                    <label class="col-form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" value="{{$item->title}}" class="form-control" required >
                    <span class="title_error ie-span"></span>
                </div>
            </div>
            <div class="erp-filter-item flex-100">
                <div class="input-block erp-step-input-block mb-0">
                    <label class="col-form-label">Description</label>
                    <textarea class="form-control" name="description" rows="3">{!! $item->description !!}</textarea>
                </div>
            </div>
            <div class="erp-filter-item flex-48">
                <div class="input-block erp-step-input-block mb-0 two">
                    <label class="col-form-label">Salary Type <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Point Four Epos Solutions"><i class="fa-duotone fa-exclamation"></i></span></label>
                    <select class="select2 select-step" name="salary_type" required>
                        <option value="0" {{($item->salary_type == 0) ? 'selected' : ''}}>Basic Salary</option>
                        <option value="1" {{($item->salary_type == 1) ? 'selected' : ''}}>Gross Salary</option>

                    </select>
                </div>
            </div>
            <div class="erp-filter-item flex-48">
                <div class="input-block mb-0 erp-step-input-block ">
                    <label class="col-form-label">Hourly Rate (%) </label>
                    <input type="number" step="any" class="form-control " value="{{$item->rate}}" name="rate" required value="0">
                </div>
            </div>

        </div>

        <div class="submit-section mt-2">
            <button class="btn btn-primary submit-btn" type="submit">Save</button>
        </div>
    </div>
</form>
