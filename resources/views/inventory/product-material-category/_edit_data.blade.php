<form action="{{ route('inventory.product-material-category.update', $item->id) }}" id="categoryUpdateForm" method="post">
    @csrf
    <div class="erp-modal-body-content">
        <div class="input-block mb-2">
            <label class="col-form-label">Category Name <span class="text-danger">*</span></label>
            <input class="form-control" name="name" value="{{ $item->name }}" required type="text">
            <span class="name_error ie-span"></span>
        </div>
        <div class="input-block mb-2">
            <label class="col-form-label">Calculator Type <span class="text-danger">*</span></label>
            <select class="select select2 select-step" name="calculator_type" required>
                @foreach($calculator_types as $key=>$type)
                    <option {{ ($key == $item->calculator_type) ? 'selected' : ''}} value="{{ $key }}">{{ $type }}</option>
                @endforeach
            </select>
        </div>
        <div class="input-block mb-2">
            <label class="col-form-label">SRP Markup Percent (%)</label>
            <input class="form-control" type="number" value="{{ $item->srp_markup_percent }}" min="0" name="srp_markup_percent">
        </div>
        <div class="input-block mb-2">
            <label class="col-form-label">Wholesale Discount Percent (%) </label>
            <input class="form-control" type="number" value="{{ $item->wholesale_discount_percent }}" min="0" name="wholesale_discount_percent">
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
