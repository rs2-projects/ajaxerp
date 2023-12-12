<!-- Add Office time Modal -->
<div id="add_office_time_modal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header erp-modal-header">
                <h5 class="modal-title">Add Office Time</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body erp-modal-body">
                <form action="{{ route('settings.office-time.store') }}" id="officeTimeStoreForm" method="post">
                    @csrf
                    <div class="erp-modal-body-content ">
                        <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-3 ">
                            <div class="erp-filter-item flex-48">
                                <div class="input-block erp-step-input-block mb-0">
                                    <label class="col-form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" required name="title" placeholder="Title" class="form-control"  >
                                    <span class="title_error ie-span"></span>
                                </div>
                            </div>
                            <div class="erp-filter-item flex-48">
                                <div class="input-block erp-step-input-block mb-0">
                                    <label class="col-form-label">Description </label>
                                    <textarea class="form-control" name="description" placeholder="Description" rows="1"></textarea>
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
                                                <label class="col-form-label">Working Hour</label>
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
                                        @foreach($week_days as $week_day)
                                            <div class="erp-child-office-time-body d-flex flex-wrap justify-content-between">
                                                <div class="erp-child-office-time-body-item flex-17">
                                                    <div class="input-block erp-step-input-block mb-0">
                                                        <input type="text" class="form-control" name="days[]" value="{{ $week_day }}" readonly required>
                                                        <span class="{{ $week_day }}_error ie-span"></span>
                                                    </div>
                                                </div>
                                                <div class="erp-child-office-time-body-item flex-17">
                                                    <div class="input-block erp-step-input-block mb-0">
                                                        <input type="time" class="form-control {{ $week_day }}_start_time" name="{{ $week_day }}_start_time" required>
                                                        <span class="{{ $week_day }}_start_time_error ie-span"></span>
                                                    </div>
                                                </div>
                                                <div class="erp-child-office-time-body-item flex-17">
                                                    <div class="input-block erp-step-input-block mb-0">
                                                        <input type="time" class="form-control {{ $week_day }}_end_time" name="{{ $week_day }}_end_time" required>
                                                        <span class="{{ $week_day }}_end_time_error ie-span"></span>
                                                    </div>
                                                </div>
                                                <div class="erp-child-office-time-body-item flex-17">
                                                    <div class="input-block erp-step-input-block mb-0">
                                                        <input type="number" step="any" class="form-control {{ $week_day }}_working_hour" value="0" name="{{ $week_day }}_working_hour" required>
                                                        <span class="{{ $week_day }}_working_hour_error ie-span"></span>
                                                    </div>
                                                </div>
                                                <div class="erp-child-office-time-body-item flex-17">
                                                    <div class="input-block erp-step-input-block mb-0">
                                                        <div class="checkbox">
                                                            <label class="col-form-label">
                                                                <input type="checkbox" name="{{ $week_day }}_is_weekend" class="me-2 {{ $week_day }}_is_weekend is_weekend_checkbox" data-day="{{ $week_day }}" value="1"> Weekend
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        {{--<div class="erp-child-office-time-body d-flex flex-wrap justify-content-between">
                                            <div class="erp-child-office-time-body-item flex-17">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <input type="text" class="form-control" name="days[]" value="sunday" disabled>
                                                </div>
                                            </div>
                                            <div class="erp-child-office-time-body-item flex-17">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <input type="time" class="form-control start_time_sunday" name="start_time[]">
                                                </div>
                                            </div>
                                            <div class="erp-child-office-time-body-item flex-17">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <input type="time" class="form-control end_time_sunday" name="end_time[]">
                                                </div>
                                            </div>
                                            <div class="erp-child-office-time-body-item flex-17">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <div class="checkbox">
                                                        <label class="col-form-label">
                                                            <input type="checkbox" name="checkbox is_weekend_sunday" name="is_weekend[]" class="me-2"> Weekend
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="erp-child-office-time-body d-flex flex-wrap justify-content-between">
                                            <div class="erp-child-office-time-body-item flex-17">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <input type="text" class="form-control" name="days[]" value="saturday" disabled>
                                                </div>
                                            </div>
                                            <div class="erp-child-office-time-body-item flex-17">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <input type="time" class="form-control start_time_saturday" name="start_time[]">
                                                </div>
                                            </div>
                                            <div class="erp-child-office-time-body-item flex-17">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <input type="time" class="form-control end_time_saturday" name="end_time[]">
                                                </div>
                                            </div>
                                            <div class="erp-child-office-time-body-item flex-17">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <div class="checkbox">
                                                        <label class="col-form-label">
                                                            <input type="checkbox" name="checkbox is_weekend_saturday" name="is_weekend[]" class="me-2"> Weekend
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="erp-child-office-time-body d-flex flex-wrap justify-content-between">
                                            <div class="erp-child-office-time-body-item flex-17">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <input type="text" class="form-control" name="days[]" value="saturday" disabled>
                                                </div>
                                            </div>
                                            <div class="erp-child-office-time-body-item flex-17">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <input type="time" class="form-control start_time_saturday" name="start_time[]">
                                                </div>
                                            </div>
                                            <div class="erp-child-office-time-body-item flex-17">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <input type="time" class="form-control end_time_saturday" name="end_time[]">
                                                </div>
                                            </div>
                                            <div class="erp-child-office-time-body-item flex-17">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <div class="checkbox">
                                                        <label class="col-form-label">
                                                            <input type="checkbox" name="checkbox is_weekend_saturday" name="is_weekend[]" class="me-2"> Weekend
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="erp-child-office-time-body d-flex flex-wrap justify-content-between">
                                            <div class="erp-child-office-time-body-item flex-17">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <input type="text" class="form-control" name="days[]" value="saturday" disabled>
                                                </div>
                                            </div>
                                            <div class="erp-child-office-time-body-item flex-17">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <input type="time" class="form-control start_time_saturday" name="start_time[]">
                                                </div>
                                            </div>
                                            <div class="erp-child-office-time-body-item flex-17">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <input type="time" class="form-control end_time_saturday" name="end_time[]">
                                                </div>
                                            </div>
                                            <div class="erp-child-office-time-body-item flex-17">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <div class="checkbox">
                                                        <label class="col-form-label">
                                                            <input type="checkbox" name="checkbox is_weekend_saturday" name="is_weekend[]" class="me-2"> Weekend
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="erp-child-office-time-body d-flex flex-wrap justify-content-between">
                                            <div class="erp-child-office-time-body-item flex-17">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <input type="text" class="form-control" name="days[]" value="saturday" disabled>
                                                </div>
                                            </div>
                                            <div class="erp-child-office-time-body-item flex-17">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <input type="time" class="form-control start_time_saturday" name="start_time[]">
                                                </div>
                                            </div>
                                            <div class="erp-child-office-time-body-item flex-17">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <input type="time" class="form-control end_time_saturday" name="end_time[]">
                                                </div>
                                            </div>
                                            <div class="erp-child-office-time-body-item flex-17">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <div class="checkbox">
                                                        <label class="col-form-label">
                                                            <input type="checkbox" name="checkbox is_weekend_saturday" name="is_weekend[]" class="me-2"> Weekend
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="erp-child-office-time-body d-flex flex-wrap justify-content-between">
                                            <div class="erp-child-office-time-body-item flex-17">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <input type="text" class="form-control" name="days[]" value="saturday" disabled>
                                                </div>
                                            </div>
                                            <div class="erp-child-office-time-body-item flex-17">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <input type="time" class="form-control start_time_saturday" name="start_time[]">
                                                </div>
                                            </div>
                                            <div class="erp-child-office-time-body-item flex-17">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <input type="time" class="form-control end_time_saturday" name="end_time[]">
                                                </div>
                                            </div>
                                            <div class="erp-child-office-time-body-item flex-17">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <div class="checkbox">
                                                        <label class="col-form-label">
                                                            <input type="checkbox" name="checkbox is_weekend_saturday" name="is_weekend[]" class="me-2"> Weekend
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>--}}

                                    </div>

                                </div>
                            </div>


                        </div>

                        <div class="submit-section mt-2">
                            <button class="btn btn-primary submit-btn" type="submit">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add Office time Modal -->
