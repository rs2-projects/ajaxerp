<!-- Add Vat Tax Type Modal -->
<div id="addVatTaxTypeModal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header erp-modal-header">
                <h5 class="modal-title">Create Sales Tax</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body erp-modal-body">
                <form action="{{ route('settings.vat-tax-type.store') }}" method="post" id="vatTaxTypeStoreForm">
                    @csrf
                    <div class="erp-modal-body-content ">
                        <div class="input-block erp-step-input-block mb-2">
                            <label class="col-form-label">Tax Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control"  name="tax_name" required>
                        </div>

                        <div class="input-block erp-step-input-block mb-2">
                            <label class="col-form-label">Tax Rate(%) </label>
                            <input type="number" step="0.01" class="form-control"  name="tax_rate" min="0.01" required>
                        </div>
                        <div class="input-block erp-step-input-block mb-2">
                            <label class="col-form-label">Your Tax Number </label>
                            <input type="text" class="form-control"  name="tax_number">
                        </div>
                        <div class="input-block erp-step-input-block mb-2">
                            <label class="col-form-label">Description<span class="text-danger">*</span></label>
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
<!-- /Add Vat Tax Modal -->
