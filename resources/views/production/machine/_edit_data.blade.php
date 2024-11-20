<form action="{{ route('production.machine.update', $item->id) }}" id="machineUpdateForm" method="post">
    @csrf
    <div class="erp-modal-body-content">
        <div class="input-block mb-2">
            <label class="col-form-label">Machine Name <span class="text-danger">*</span></label>
            <input class="form-control" name="name" value="{{ $item->name }}" required type="text">
            <span class="name_error ie-span"></span>
        </div>
        <div class="input-block mb-2">
            <label class="col-form-label">Machine Model</label>
            <input class="form-control" name="model" value="{{ $item->model }}" type="text">
            <span class="model_error ie-span"></span>
        </div>
        <div class="input-block mb-2">
            <label class="col-form-label">Machine Code</label>
            <input class="form-control" type="text" name="machine_code" value="{{ $item->machine_code }}">
            <span class="machine_code_error ie-span"></span>
        </div>
        <div class="input-block mb-2">
            <label class="col-form-label">Production Cost</label>
            <input class="form-control" type="number" value="{{ formatNumber($item->production_cost) }}" name="production_cost" min="0">
            <span class="model_error ie-span"></span>
        </div>

        <div class="input-block mb-2">
            <label class="col-form-label">Machine Image</label>
            <div class="d-flex">
                <input type="file" class="form-control " name="image" accept="image/*">
                @if($item->image)
                    <img class="edit--modal-data-img-src" src="{{ $item->show_image }}" width="30">
                @endif
            </div>
        </div>
        <div class="input-block mb-2">
            <label class="col-form-label">Machine Color</label>
            <input class="form-control" name="color" value="{{ $item->color }}" type="text">
        </div>
        <div class="input-block mb-3">
            <label class="col-form-label">Description </label>
            <textarea cols="30" rows="3" class="form-control" name="description">{!! $item->description??'' !!}</textarea>
        </div>
        <div class="submit-section mt-2">
            <button class="btn btn-primary submit-btn" type="submit">Save</button>
        </div>
    </div>
</form>
