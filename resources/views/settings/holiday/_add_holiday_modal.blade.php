<!-- Add Holiday Modal -->
<div id="add_holiday_modal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header erp-modal-header">
                <h5 class="modal-title">Add Holiday</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body erp-modal-body">
                <form action="{{ route('settings.holidays.store') }}" id="holidayStoreForm" method="post">
                    @csrf
                    <div class="erp-modal-body-content ">
                        <div class="input-block erp-step-input-block mb-2">
                            <label class="col-form-label">Holiday Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" required class="form-control"  >
                            <span class="title_error ie-span"></span>
                        </div>
                        <div class="input-block erp-step-input-block mb-2">
                            <label class="col-form-label">Description </label>
                            <input type="text" name="description" class="form-control" >
                        </div>
                        <div class="erp-date-range-offcanvas d-flex justify-content-between flex-wrap w-100">
                            <div class="input-block erp-step-input-block mb-2 flex-48">
                                <label class="col-form-label">Date From <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input type="text" name="start_date" required class="form-control datetimepicker">
                                    <span class="start_date_error ie-span"></span>
                                </div>
                            </div>
                            <div class="input-block erp-step-input-block mb-2 flex-48">
                                <label class="col-form-label">Date To <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input type="text" name="end_date" required class="form-control datetimepicker">
                                    <span class="end_date_error ie-span"></span>
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
<!-- /Add Resignation Modal -->
