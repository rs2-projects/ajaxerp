<!-- Add Category Modal -->
<div id="addProdStaffModal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="{{ route('production.production-staff.store') }}" id="prodStaffStoreForm" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header erp-modal-header">
                    <h5 class="modal-title">Add Production Staff</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body erp-modal-body">
                    <div class="erp-modal-body-content">
                        <div class="input-block mb-2">
                            <label class="col-form-label">Title <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="title" required>
                            <span class="title_error ie-span"></span>
                        </div>
                        <div class="input-block mb-2">
                            <label class="col-form-label">User Name <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="user_name" required>
                            <span class="user_name_error ie-span"></span>
                        </div>
                        <div class="input-block mb-2">
                            <label class="col-form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control " name="password" required>
                            <span class="password_error ie-span"></span>
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
