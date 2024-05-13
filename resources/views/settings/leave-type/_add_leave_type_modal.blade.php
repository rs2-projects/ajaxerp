<!-- Add Leave Type Modal -->
<div id="add_leave_type_modal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header erp-modal-header">
                <h5 class="modal-title">Add Leave Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body erp-modal-body">
                <form action="{{ route('settings.leave-type.store') }}" id="leaveTypeStoreForm" method="post">
                    @csrf
                    <div class="erp-modal-body-content d-flex flex-wrap justify-content-between">
                        <div class="erp-em-reg-step-item flex-100">
                            <div class="input-block erp-step-input-block mb-2">
                                <label class="col-form-label">Title<span class="text-danger">*</span></label>
                                <input type="text" name="title" required class="form-control"  >
                                <span class="title_error ie-span"></span>
                            </div>
                        </div>
                        <div class="erp-em-reg-step-item flex-100">
                            <div class="input-block erp-step-input-block mb-2">
                                <label class="col-form-label">Description</label>
                                <textarea class="form-control" name="description" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="erp-em-reg-step-item flex-48">
                            <div class="input-block erp-step-input-block mb-2">
                                <label class="col-form-label">Number of Days (Annual)</label>
                                <input type="number" name="annual_leave_days" required class="form-control"  >
                                <span class="annual_leave_days_error ie-span"></span>
                            </div>
                        </div>
                        <div class="erp-em-reg-step-item flex-48">
                            <div class="input-block erp-step-input-block mb-2">
                                <label class="col-form-label">Max Leave per Month</label>
                                <input type="number" name="max_leave_per_month" class="form-control"  >
                                <span class="max_leave_per_month_error ie-span"></span>
                            </div>
                        </div>

                        <div class="erp-filter-item flex-100 mt-4 mb-2">
                            <h4 class="offcanvas-title-erp">Extra Leave Penalty Settings</h4>
                        </div>

                        <div class="erp-filter-item flex-48">
                            <div class="input-block erp-step-input-block mb-0 two">
                                <label class="col-form-label">Salary Type </label>
                                <select class="select select2 " name="salary_type" required>
                                    <option value="">Select Type</option>
                                    <option value="0">Basic Salary</option>
                                    <option value="1">Gross Salary</option>

                                </select>
                            </div>
                        </div>
                        <div class="erp-filter-item flex-48">
                            <div class="input-block mb-0 erp-step-input-block ">
                                <label class="col-form-label">Rate (%) <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Percentage of Daily Rate of Basic / Gross Salary"><i class="fa-duotone fa-exclamation"></i></span></label>
                                <input type="number" step="any" class="form-control " name="rate" required value="100">
                            </div>
                        </div>

                        <div class="erp-em-reg-step-item flex-100 mt-3 ">
                            <div class="submit-section mt-2">
                                <button class="btn btn-primary submit-btn" type="submit">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add Resignation Modal -->
