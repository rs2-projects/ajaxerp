<!-- Add Bonous Modal -->
<div id="add_bonus_type_modal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header erp-modal-header">
                <h5 class="modal-title">Add Bonus Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body erp-modal-body">
                <form action="{{ route('settings.bonus-type.store') }}" id="bonusTypeStoreForm" method="post">
                    @csrf
                    <div class="erp-modal-body-content ">
                        <div class="input-block erp-step-input-block mb-2">
                            <label class="col-form-label">Title<span class="text-danger">*</span></label>
                            <input type="text" name="title" required class="form-control"  >
                            <span class="title_error ie-span"></span>
                        </div>
                        <div class="input-block erp-step-input-block mb-2">
                            <label class="col-form-label">Description</label>
                            <textarea class="form-control" name="description" rows="2"></textarea>
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
