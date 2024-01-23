<!-- Add Bonous Modal -->
<div id="add_salary_deduction_type_modal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header erp-modal-header">
                <h5 class="modal-title">Add Salary Deduction Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body erp-modal-body">
                <form action="{{ route('settings.salary-deduction-type.store') }}" id="salaryDeductionTypeStoreForm" method="post">
                    @csrf
                    <div class="erp-modal-body-content ">
                        <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-3 ">
                            <div class="input-block erp-step-input-block mb-2">
                                <label class="col-form-label">Title<span class="text-danger">*</span></label>
                                <input type="text" name="title" required class="form-control"  >
                                <span class="title_error ie-span"></span>
                            </div>
                            <div class="erp-filter-item flex-48">
                                <div class="input-block erp-step-input-block mb-0 two">
                                    <label class="col-form-label">Rate Type </label>
                                    <select class="select select-step select2" onchange="changeRateType(this.value)" name="rate_type" required>
                                        <option value="">Select Type</option>
                                        <option value="0">Percentage</option>
                                        <option value="1">Flat</option>

                                    </select>
                                    <span class="rate_type_error ie-span"></span>
                                </div>
                            </div>
                            <div class="erp-filter-item flex-48 hide-show-salary-type" style="display: none">
                                <div class="input-block erp-step-input-block mb-0 two">
                                    <label class="col-form-label">Salary Type </label>
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
                                    <label class="col-form-label">Rate <span class="hide-show-value-symbol" style="display: none">(%)</span></label>
                                    <input type="number" min="0" step="any" class="form-control" required name="rate">
                                    <span class="rate_error ie-span"></span>
                                </div>
                            </div>
                            <div class="input-block erp-step-input-block mb-2">
                                <label class="col-form-label">Description</label>
                                <textarea class="form-control" name="description" rows="2"></textarea>
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
