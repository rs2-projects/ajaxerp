<!-- Add Absent Modal -->
<div id="add_absent_penalty_modal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header erp-modal-header">
                <h5 class="modal-title">Add Absent Penalty</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body erp-modal-body">
                <form action="{{ route('settings.absent-penalty.store') }}" id="absentPenaltyStoreForm" method="post">
                    @csrf
                    <div class="erp-modal-body-content ">
                        <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-3 ">
                            <div class="erp-filter-item flex-100">
                                <div class="input-block erp-step-input-block mb-0">
                                    <label class="col-form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" required class="form-control"  >
                                    <span class="title_error ie-span"></span>
                                </div>
                            </div>
                            <div class="erp-filter-item flex-100">
                                <div class="input-block erp-step-input-block mb-0">
                                    <label class="col-form-label">Description </label>
                                    <textarea class="form-control" rows="2" name="description"></textarea>
                                </div>
                            </div>

                            <div class="erp-filter-item flex-48">
                                <div class="input-block erp-step-input-block mb-0 two">
                                    <label class="col-form-label">Deduct Type <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Point Four Epos Solutions"><i class="fa-duotone fa-exclamation"></i></span></label>
                                    <select class="select select-step select2" onchange="changeRateType(this.value)" name="rate_type" required>
                                        <option value="">Select Deduct Type</option>
                                        <option value="0">Percentage</option>
                                        <option value="1">Flat</option>

                                    </select>
                                    <span class="rate_type_error ie-span"></span>
                                </div>
                            </div>
                            <div class="erp-filter-item flex-48 hide-show-salary-type" style="display: none">
                                <div class="input-block erp-step-input-block mb-0 two">
                                    <label class="col-form-label">Salary Type <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Point Four Epos Solutions"><i class="fa-duotone fa-exclamation"></i></span></label>
                                    <select class="select select-step select2" name="salary_type" required>
                                        <option value="">Select Salary Type</option>
                                        <option value="0">Basic Salary</option>
                                        <option value="1">Gross Salary</option>

                                    </select>
                                    <span class="salary_type_error ie-span"></span>
                                </div>
                            </div>
                            <div class="erp-filter-item flex-48">
                                <div class="input-block mb-0 erp-step-input-block ">
                                    <label class="col-form-label">Deduct Value </label>
                                    <input type="number" min="0" step="any" class="form-control" required name="rate">
                                    <span class="rate_error ie-span"></span>
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
<!-- /Add Overtime Modal -->
