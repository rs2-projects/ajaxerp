<!-- Add Department Modal -->
<div id="add_department_modal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header erp-modal-header">
                <h5 class="modal-title">Add Department</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body erp-modal-body">
                <form action="{{ route('hr.department.store') }}" id="departmentStoreForm" method="post">
                    @csrf
                    <div class="erp-modal-body-content">
                        <div class="input-block mb-2">
                            <label class="col-form-label">Department Name <span class="text-danger">*</span></label>
                            <input class="form-control" name="name" required type="text">
                            <span class="name_error ie-span"></span>
                        </div>
                        <div class="input-block mb-3">
                            <label class="col-form-label">Description </label>

                            <textarea cols="30" rows="3" class="form-control" name="description"></textarea>
                        </div>
                        <div class="submit-section mt-2">
                            <button class="btn btn-primary submit-btn" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add Department Modal -->
