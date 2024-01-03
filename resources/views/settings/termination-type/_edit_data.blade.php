<form action="{{ route('settings.termination-type.update', $item->id) }}" id="terminationTypeUpdateForm" method="post">
    @csrf
    <div class="erp-modal-body-content ">
        <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-3 ">
            <div class="erp-filter-item flex-100">
                <div class="input-block erp-step-input-block mb-0">
                    <label class="col-form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" value="{{ $item->name }}" required class="form-control"  >
                    <span class="name_error ie-span"></span>
                </div>
            </div>
            <div class="erp-filter-item flex-100">
                <div class="input-block erp-step-input-block mb-0">
                    <label class="col-form-label">Description </label>
                    <textarea class="form-control" rows="2" name="description">{!! $item->description !!}</textarea>
                </div>
            </div>

        </div>

        <div class="submit-section mt-2">
            <button class="btn btn-primary submit-btn" type="submit">Save</button>
        </div>
    </div>
</form>
