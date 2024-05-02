<!-- Add Category Modal -->
<div id="maintenance_product_modal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <form action="" id="maintenanceProductStoreForm" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header erp-modal-header">
                    <h5 class="modal-title">Maintenance Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body erp-modal-body">
                    <div class="erp-modal-body-content">
                        <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-start justify-content-between mb-3 ">
                            <input type="hidden" name="asset_product_id" id="maintenance_id" value="">
                            <input type="hidden" name="maintenance_type" id="maintenance_type" value="">
                            <input type="hidden" name="asset_assign_id" id="asset_assign_id" value="">
                            <div class="input-block flex-48 mb-2">
                                <label class="col-form-label">Date <span class="text-danger">*</span></label>
                                <input class="form-control datetimepicker" id="maintenance_date" type="text" name="date" value="{{ now()->format('Y-m-d') }}" required>
                                <span class="name_error ie-span"></span>
                            </div>
                        
                            <div class="input-block flex-48 mb-2">
                                <label class="col-form-label">SL No <span class="text-danger">*</span></label>
                                <input class="form-control " id="maintenance_sl_no" value="" name="sl_no" type="text" required>
                            </div>

                            <div class="input-block flex-48 mb-2">
                                <label class="col-form-label">Model <span class="text-danger">*</span></label>
                                <input class="form-control " id="maintenance_model" value="" name="model" type="text" required>
                            </div>

                            <div class="input-block flex-48 mb-2">
                                <label class="col-form-label">Warranty Date</label>
                                <input class="form-control datetimepicker" id="maintenance_warranty_date" type="text" name="warranty">
                                <span class="name_error ie-span"></span>
                            </div>
                            <div class="input-block flex-48 mb-3">
                                <label class="col-form-label">Reason <span class="text-danger">*</span></label>
                                <textarea cols="30" rows="3" id="maintenance_reason" class="form-control" name="reason" required></textarea>
                            </div>
                            <div class="input-block flex-48 mb-3">
                                <label class="col-form-label">Remarks <span class="text-danger">*</span></label>
                                <textarea cols="30" rows="3" id="maintenance_remarks" class="form-control" name="remarks" required></textarea>
                            </div>
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
