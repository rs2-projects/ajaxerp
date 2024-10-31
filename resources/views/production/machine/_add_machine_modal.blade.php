<!-- Add Category Modal -->
<div id="addMachineModal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="{{ route('production.machine.store') }}" id="machineStoreForm" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header erp-modal-header">
                    <h5 class="modal-title">Add New Machine</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body erp-modal-body">
                    <div class="erp-modal-body-content">
                        <div class="input-block mb-2">
                            <label class="col-form-label">Machine Name <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="name" required>
                            <span class="name_error ie-span"></span>
                        </div>
                        <div class="input-block mb-2">
                            <label class="col-form-label">Machine Model</label>
                            <input class="form-control" type="text" name="model">
                            <span class="model_error ie-span"></span>
                        </div>
                        <div class="input-block mb-2">
                            <label class="col-form-label">Machine Code</label>
                            <input class="form-control" type="text" name="machine_code">
                            <span class="machine_code_error ie-span"></span>
                        </div>
                        <div class="input-block mb-2">
                            <label class="col-form-label">Production Cost </label>
                            <input class="form-control" type="number" name="production_cost" min="0">
                            <span class="model_error ie-span"></span>
                        </div>
                        <div class="input-block mb-2">
                            <label class="col-form-label">Machine Image</label>
                            <input type="file" class="form-control " name="image" accept="image/*">
                        </div>
                        <div class="input-block mb-2">
                            <label class="col-form-label">Machine Color</label>
                            <input class="form-control" type="text" name="color">
                        </div>
                        <div class="input-block mb-3">
                            <label class="col-form-label">Description </label>
                            <textarea cols="30" rows="3" class="form-control" name="description"></textarea>
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
