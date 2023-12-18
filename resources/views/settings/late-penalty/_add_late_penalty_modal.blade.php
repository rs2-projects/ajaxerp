<!-- Add Absent Modal -->
<div id="add_late_penalty_modal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header erp-modal-header">
                <h5 class="modal-title">Add Late Penalty</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body erp-modal-body">
                <form action="{{ route('settings.late-penalty.store') }}" id="latePenaltyStoreForm" method="post">
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

                            <div class="erp-filter-item flex-100">
                                <div class="input-block erp-step-input-block mb-0">
                                    <label class="col-form-label">Late Count Time <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="in minutes" data-bs-original-title="in minutes"><i class="fa-duotone fa-exclamation"></i></span></label>
                                    <input type="number" min="0" value="0" required name="late_count_minutes" class="form-control">
                                    <span class="late_count_minutes_error ie-span"></span>
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
