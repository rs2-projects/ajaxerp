<form action="{{ route('settings.board-embossed.update', $item->id) }}" id="boardEmbossedUpdateForm" method="post">
    @csrf
    <div class="erp-modal-body-content">
        <div class="input-block mb-2">
            <label class="col-form-label">Name <span class="text-danger">*</span></label>
            <input class="form-control" name="name" value="{{ $item->name }}" required type="text">
            <span class="name_error ie-span"></span>
        </div>
        <div class="input-block mb-2">
            <label class="col-form-label">Production Cost <span class="text-danger">*</span></label>
            <input class="form-control" type="number" value="{{ formatNumber($item->production_cost) }}" name="production_cost" min="0" required>
            <span class="model_error ie-span"></span>
        </div>
        <div class="input-block mb-3">
            <label class="col-form-label">Code <span class="text-danger">*</span></label>
            <input class="form-control" name="code" value="{{ $item->code }}" type="text" required>
        </div>
        <div class="input-block mb-2">
            <label class="col-form-label">Product Image</label>
            <div class="d-flex">
                <input type="file" class="form-control " name="image" accept="image/*">
                <img class="edit-img-src" src="{{ $item->show_image }}" width="30">
            </div>
        </div>

        <div class="input-block mb-3">
            <label class="col-form-label">Note </label>
            <textarea cols="30" rows="3" class="form-control" name="note">{!! $item->note??'' !!}</textarea>
        </div>
        <div class="submit-section mt-2">
            <button class="btn btn-primary submit-btn" type="submit">Submit</button>
        </div>
    </div>
</form>
