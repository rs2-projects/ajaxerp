<form action="{{ route('settings.office-time.update',$item->id) }}" id="officeTimeStoreFormEdit" method="post">
    @csrf
    <div class="erp-modal-body-content ">
        <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-3 ">
            <div class="erp-filter-item flex-48">
                <div class="input-block erp-step-input-block mb-0">
                    <label class="col-form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" required name="name" value="{{$item->name}}" placeholder="Title" class="form-control"  >
                    <span class="name_error ie-span"></span>
                </div>
            </div>
            <div class="erp-filter-item flex-48">
                <div class="input-block erp-step-input-block mb-0">
                    <label class="col-form-label">Working Hour <span class="text-danger">*</span></label>
                    <input type="number" required name="working_hour" value="{{ $item->working_hour }}" step="any" min="1"  placeholder="Working Hour" class="form-control"  >
                    <span class="working_hour_error ie-span"></span>
                </div>
            </div>
            <div class="erp-filter-item flex-100">
                <div class="input-block erp-step-input-block mb-0">
                    <label class="col-form-label">Description <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="description" placeholder="Description" rows="1">{!! $item->description !!}</textarea>
                </div>
            </div>
            <div class="erp-filter-item flex-100">
                <div class="erp-child-office-time-wrapper">
                    <div class="erp-child-office-time-header d-flex flex-wrap justify-content-between">
                        <div class="erp-child-office-time-header-item flex-17">
                            <div class="input-block erp-step-input-block mb-0">
                                <label class="col-form-label">Days</label>
                            </div>
                        </div> <div class="erp-child-office-time-header-item flex-17">
                            <div class="input-block erp-step-input-block mb-0">
                                <label class="col-form-label">Start</label>
                            </div>
                        </div>
                        <div class="erp-child-office-time-header-item flex-17">
                            <div class="input-block erp-step-input-block mb-0">
                                <label class="col-form-label">End</label>
                            </div>
                        </div>
                        <div class="erp-child-office-time-header-item flex-17">
                            <div class="input-block erp-step-input-block mb-0">
                                <label class="col-form-label">Weekend</label>
                                <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Mark the day, If you want to make it as a weekend" data-bs-original-title="Mark the day, If you want to make it as a weekend"><i class="fa-duotone fa-exclamation"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="erp-child-office-time-body-wrapper">
                        @foreach($item->officeTimes as $week_day)
                            <div class="erp-child-office-time-body d-flex flex-wrap justify-content-between">
                                <div class="erp-child-office-time-body-item flex-17">
                                    <div class="input-block erp-step-input-block mb-0">
                                        <input type="text" class="form-control" name="days[]" value="{{ $week_day->day }}" readonly required>
                                        <span class="{{ $week_day->day }}_error ie-span"></span>
                                    </div>
                                </div>
                                <div class="erp-child-office-time-body-item flex-17">
                                    <div class="input-block erp-step-input-block mb-0">
                                        <input type="time" class="form-control {{ $week_day->day }}_start_time" value="{{ $week_day->start_time }}" name="{{ $week_day->day }}_start_time" {{($week_day->is_weekend != 1) ? 'required' : ''}}>
                                        <span class="{{ $week_day->day }}_start_time_error ie-span"></span>
                                    </div>
                                </div>
                                <div class="erp-child-office-time-body-item flex-17">
                                    <div class="input-block erp-step-input-block mb-0">
                                        <input type="time" class="form-control {{ $week_day->day }}_end_time" value="{{ $week_day->end_time }}" name="{{ $week_day->day }}_end_time" {{($week_day->is_weekend != 1) ? 'required' : ''}}>
                                        <span class="{{ $week_day->day }}_end_time_error ie-span"></span>
                                    </div>
                                </div>
                                <div class="erp-child-office-time-body-item flex-17">
                                    <div class="input-block erp-step-input-block mb-0">
                                        <div class="checkbox">
                                            <label class="col-form-label">
                                                <input type="checkbox" name="{{ $week_day->day }}_is_weekend" class="me-2 {{ $week_day->day }}_is_weekend is_weekend_checkbox" data-day="{{ $week_day->day }}" value="1" {{($week_day->is_weekend == 1) ? 'checked' : ''}}> Weekend
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>

                </div>
            </div>


        </div>

        <div class="submit-section mt-2">
            <button class="btn btn-primary submit-btn" type="submit">Save</button>
        </div>
    </div>
</form>
