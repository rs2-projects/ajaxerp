<!-- Add Category Modal -->
<div id="addBoardEmbossedModal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="{{ route('settings.board-embossed.store') }}" id="boardEmbossedStoreForm" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header erp-modal-header">
                    <h5 class="modal-title">Add Plate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body erp-modal-body">
                    <div class="erp-modal-body-content">
                        <div class="input-block mb-2">
                            <label class="col-form-label">Name <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="name" required>
                            <span class="name_error ie-span"></span>
                        </div>
                        <div class="input-block mb-2">
                            <label class="col-form-label">Production Cost <span class="text-danger">*</span></label>
                            <input class="form-control" type="number" name="production_cost" min="0" required>
                            <span class="model_error ie-span"></span>
                        </div>
                        <div class="input-block mb-3">
                            <label class="col-form-label"> Code <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="code" required>
                        </div>
                        <div class="input-block mb-2">
                            <label class="col-form-label">Image</label>
                            <input type="file" class="form-control" name="image" accept="image/*">
                        </div>

                        <div class="input-block mb-3">
                            <label class="col-form-label">Note </label>
                            <textarea cols="30" rows="3" class="form-control" name="note"></textarea>
                        </div>
                        <div class="submit-section mt-2">
                            <button class="btn btn-primary submit-btn" type="submit">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- /Add Department Modal -->
