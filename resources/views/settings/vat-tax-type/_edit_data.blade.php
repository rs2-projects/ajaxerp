<form action="{{ route('settings.vat-tax-type.update',$item->id) }}" id="vatTaxTypeUpdateForm" method="post">
    @csrf
    <div class="erp-modal-body-content ">
        <div class="input-block erp-step-input-block mb-2">
            <label class="col-form-label">Tax Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" value="{{ $item->name }}" name="tax_name" required>
        </div>

        <div class="input-block erp-step-input-block mb-2">
            <label class="col-form-label">Tax Rate(%) </label>
            <input type="number" step="0.01" value="{{ $item->tax_rate }}" class="form-control"  name="tax_rate" min="0.01" required>
        </div>
        <div class="input-block erp-step-input-block mb-2">
            <label class="col-form-label">Your Tax Number </label>
            <input type="text" class="form-control" value="{{ $item->account_no }}" name="tax_number">
        </div>
        <div class="input-block erp-step-input-block mb-2">
            <label class="col-form-label">Description<span class="text-danger">*</span></label>
            <textarea class="form-control" name="description" rows="2">{!! $item->description !!}</textarea>
        </div>
        <div class="submit-section mt-2">
            <button class="btn btn-primary submit-btn" type="submit">Save</button>
        </div>
    </div>
</form>
