<!-- Add Category Modal -->
<div id="repair_product_modal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="" id="repairProductStoreForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header erp-modal-header">
                    <h5 class="modal-title">Repair Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body erp-modal-body">
                    <div class="erp-modal-body-content">
                        <input type="hidden" name="repair_id" id="repair_id" value="">
                        <div class="input-block mb-2">
                            <label class="col-form-label">Date <span class="text-danger">*</span></label>
                            <input class="form-control datetimepicker" type="text" name="repair_date" value="{{ now()->format('Y-m-d') }}" required>
                            <span class="name_error ie-span"></span>
                        </div>

                        <div class="input-block  mb-3">
                            <label class="col-form-label">Note <span class="text-danger">*</span></label>
                            <textarea cols="30" rows="3" class="form-control" name="repair_note" required></textarea>
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
