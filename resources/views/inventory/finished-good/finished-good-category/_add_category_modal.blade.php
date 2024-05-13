<!-- Add Finished Good Category Modal -->
<div id="addCategoryModal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="{{ route('inventory.finished-good-category.store') }}" id="categoryStoreForm" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header erp-modal-header">
                    <h5 class="modal-title">Add Finished Good Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body erp-modal-body">
                    <div class="erp-modal-body-content">
                        <div class="input-block mb-2">
                            <label class="col-form-label">Category Name <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="name" required>
                            <span class="name_error ie-span"></span>
                        </div>
                        <div class="input-block mb-3">
                            <label class="col-form-label">Description </label>
                            <textarea cols="30" rows="3" class="form-control" name="description"></textarea>
                            <span class="description_error ie-span"></span>
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
<!-- /Add Finished Good Category Modal -->
