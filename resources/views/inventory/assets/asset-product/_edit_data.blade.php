<form action="{{ route('inventory.asset-product.update', $item->id) }}" id="productUpdateForm" method="post">
    @csrf
    <div class="erp-modal-body-content">
        <div class="input-block mb-2">
            <label class="col-form-label">Product Name <span class="text-danger">*</span></label>
            <input class="form-control" name="name" value="{{ $item->name }}" type="text">
            <span class="name_error ie-span"></span>
        </div>
        <div class="input-block mb-2">
            <label class="col-form-label">Category <span class="text-danger">*</span></label>
            <select class="select floating select2-box select2" name="asset_product_category_id">
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option {{ $category->id == $item->asset_product_category_id ? 'selected' : ''}} 
                        value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            <span class="asset_product_category_id_error ie-span"></span>
        </div>
        <div class="input-block mb-2">
            <label class="col-form-label">Product Image</label>
            <div class="d-flex">
                <input type="file" class="form-control " name="image" accept="image/*">
                <img class="edit-img-src" src="{{ $item->show_image }}" width="30">
            </div>
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
