<!-- Add Category Modal -->
<div id="disposed_product_modal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <form action="" id="disposedProductStoreForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header erp-modal-header">
                    <h5 class="modal-title">Disposed Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body erp-modal-body">
                    <div class="erp-modal-body-content">
                        <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-start justify-content-between mb-3 ">
                            <input type="hidden" name="asset_product_id" id="disposed_id" value="">
                            <div class="input-block flex-48 mb-2">
                                <label class="col-form-label">Date <span class="text-danger">*</span></label>
                                <input class="form-control datetimepicker" type="text" name="date" value="{{ now()->format('Y-m-d') }}" required>
                                <span class="name_error ie-span"></span>
                            </div>

                            <div class="input-block flex-48 mb-2">
                                <label class="col-form-label">Qty <span class="text-danger">*</span></label>
                                <input class="form-control" id="sell_qty" name="qty" type="number" min="1" required >
                            </div>

                            <div class="input-block flex-48 mb-3">
                                <label class="col-form-label">Remarks <span class="text-danger">*</span></label>
                                <textarea cols="30" rows="3" class="form-control" name="remarks" required></textarea>
                            </div>

                            <div class="input-block flex-48 mb-2">
                                <label class="col-form-label">Attachment</label>
                                <input class="form-control" type="file" name="attachment[]" multiple>
                                <span class="name_error ie-span"></span>
                            </div>
                            <div class="submit-section mt-2">
                                <button class="btn btn-primary submit-btn" type="submit">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- /Add Department Modal -->
