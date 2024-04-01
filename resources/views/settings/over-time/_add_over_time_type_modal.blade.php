<!-- Add Office time Modal -->
<div id="add_over_time_type_modal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header erp-modal-header">
                <h5 class="modal-title">Add Over Time Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body erp-modal-body">
                <form action="{{ route('settings.over-time-type.store') }}" id="OverTimeStoreForm" method="post">
                    @csrf
                    <div class="erp-modal-body-content ">
                        <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-3 ">
                            <div class="erp-filter-item flex-100">
                                <div class="input-block erp-step-input-block mb-0">
                                    <label class="col-form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control" required >
                                    <span class="title_error ie-span"></span>
                                </div>
                            </div>
                            <div class="erp-filter-item flex-100">
                                <div class="input-block erp-step-input-block mb-0">
                                    <label class="col-form-label">Description</label>
                                    <textarea class="form-control" name="description" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="erp-filter-item flex-48">
                                <div class="input-block erp-step-input-block mb-0 two">
                                    <label class="col-form-label">Salary Type</label>
                                    <select class="select select-step" name="salary_type" required>
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
                            <div class="erp-filter-item flex-48">
                                <div class="input-block mb-0 erp-step-input-block ">
                                    <label class="col-form-label">Special Rate (%) <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Percentage of Daily Rate of Basic / Gross Salary"><i class="fa-duotone fa-exclamation"></i></span></label>
                                    <input type="number" step="any" class="form-control " name="special_rate" required value="100">
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
