<!-- Add Resignation Modal -->
<div id="add_user_resignation_modal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header erp-modal-header">
                <h5 class="modal-title">Add Resignation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body erp-modal-body">
                <form action="{{ route('user.resignation.store') }}" id="userResignationStoreForm" method="post">
                    @csrf
                    <div class="erp-modal-body-content">
                        <div class="input-block mb-2">
                            <label class="col-form-label">Resignation Date <span class="text-danger">*</span></label>
                            <div class="cal-icon">
                                <input type="text" name="resignation_date" required class="form-control datetimepicker">
                            </div>
                        </div>
                        <div class="input-block mb-2">
                            <label class="col-form-label">Reason </label>
                            <textarea class="form-control" name="reason" required rows="4"></textarea>
                        </div>
                        <div class="submit-section mt-2">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add Resignation Modal -->
