<form action="{{ route('settings.role-management.update', $item->id) }}" id="roleUpdateForm" method="post">
    @csrf
    <div class="erp-modal-body-content">
        <div class="input-block mb-2">
            <label class="col-form-label">Role Name <span class="text-danger">*</span></label>
            <input class="form-control" name="title" value="{{ $item->title }}" required type="text">
            <span class="name_error ie-span"></span>
        </div>
        <div class="input-block mb-3">
            <label class="col-form-label">Description </label>
            <textarea cols="30" rows="3" class="form-control" name="description">{!! $item->description??'' !!}</textarea>
        </div>
        <div class="input-block erp-step-input-block mb-2">
            <label class="col-form-label">
                <input type="checkbox" name="is_default" value="1" {{$item->is_default ==$item::IS_DEFAULT_YES ? 'checked' : ''}}> <span class="ms-1">Is it Default</span>
            </label>
        </div>
        <div class="submit-section mt-2">
            <button class="btn btn-primary submit-btn" type="submit">Submit</button>
        </div>
    </div>
</form>
