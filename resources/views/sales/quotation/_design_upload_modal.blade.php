<!-- design  Modal -->
<div id="design_upload_modal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="{{ route('sales.invoice.design_upload') }}" id="designUploadFormSubmit" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header erp-modal-header">
                    <h5 class="modal-title">Upload Design</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body erp-modal-body">
                    <div class="erp-modal-body-content ">
                        <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-3 ">
                            <div class="erp-filter-item flex-100">
                                <div class="multiple-receipt-box d-flex flex-wrap position-relative">
                                    <div class="multiple-receipt-item flex-100">
                                        <div class="input-block erp-step-input-block mb-0">
                                            <label class="col-form-label">Upload Design <span class="text-danger"> </span></label>
                                            <input type="file" class="form-control" name="design[]" placeholder="Upload Design" accept="image/*,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                                            <input type="hidden" class="form-control" name="invoice_id" placeholder="Upload Design">
                                        </div>
                                    </div>
                                </div>
                            </div>

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
<!-- /design  Modal -->
