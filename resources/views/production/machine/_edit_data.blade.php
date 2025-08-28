<form action="{{ route('production.machine.update', $item->id) }}" id="machineUpdateForm" method="post">
    @csrf
    <div class="erp-modal-body-content">
        <div class="row mb-2">
            <div class="form-group col-md-6 mb-2">
                <label class="col-form-label">Type <span class="text-danger">*</span></label>
                <select class="form-control select" name="type" required>
                    <option value="">Select Type</option>
                    @foreach($machine_types as $key => $type)
                        <option value="{{ $key }}" {{ $item->type == $key ? 'selected' : '' }}>
                            {{ $type }}
                        </option>
                    @endforeach
                </select>
                <span class="type_error ie-span"></span>
            </div>

            <div class="form-group col-md-6 mb-2">
                <label class="col-form-label">Category <span class="text-danger">*</span></label>
                <select class="form-control select" name="category_id" required>
                    <option value="">Select Category</option>
                    @foreach($machine_categories as $category)
                        <option value="{{ $category->id }}" {{ $item->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-6 mb-2">
                <label class="col-form-label">Name <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="name" value="{{ $item->name }}" required>
                <span class="name_error ie-span"></span>
            </div>

            <div class="form-group col-md-6 mb-2">
                <label class="col-form-label">Model</label>
                <input class="form-control" type="text" name="model" value="{{ $item->model }}">
                <span class="model_error ie-span"></span>
            </div>

            <div class="form-group col-md-6 mb-2">
                <label class="col-form-label">Machine Code</label>
                <input class="form-control" type="text" name="machine_code" value="{{ $item->machine_code }}">
                <span class="machine_code_error ie-span"></span>
            </div>

            <div class="form-group col-md-6 mb-2">
                <label class="col-form-label">Production Cost</label>
                <input class="form-control" type="number" name="production_cost" min="0" value="{{ formatNumber($item->production_cost) }}">
                <span class="production_cost_error ie-span"></span>
            </div>

            <div class="form-group col-md-6 mb-2">
                <label class="col-form-label">Image</label>
                <div class="d-flex align-items-center gap-2">
                    <input type="file" class="form-control" name="image" accept="image/*">
                    @if($item->image)
                        <img src="{{ $item->show_image }}" width="30" class="img-thumbnail">
                    @endif
                </div>
            </div>

            <div class="form-group col-md-6 mb-2">
                <label class="col-form-label">Machine Color</label>
                <input class="form-control" type="text" name="color" value="{{ $item->color }}">
            </div>

            <div class="form-group col-md-12">
                <label class="col-form-label">Description</label>
                <textarea class="form-control" rows="3" name="description">{!! $item->description ?? '' !!}</textarea>
            </div>
        </div>
        <div class="submit-section mt-2">
            <button class="btn btn-primary submit-btn" type="submit">Save</button>
        </div>
    </div>
</form>
