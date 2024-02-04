<form action="{{ route('inventory.product-material-category.update', $item->id) }}" id="categoryUpdateForm" method="post">
    @csrf
    <div class="erp-modal-body-content">
        <div class="input-block mb-2">
            <label class="col-form-label">Category Name <span class="text-danger">*</span></label>
            <input class="form-control" name="name" value="{{ $item->name }}" required type="text">
            <span class="name_error ie-span"></span>
        </div>
        <div class="input-block mb-3">
            <label class="col-form-label">Description </label>

            <textarea cols="30" rows="3" class="form-control" name="description">{!! $item->description??'' !!}</textarea>
        </div>
        <div class="submit-section mt-2">
            <button class="btn btn-primary submit-btn" type="submit">Submit</button>
        </div>
    </div>
</form>
