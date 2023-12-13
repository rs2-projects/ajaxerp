<form action="{{ route('settings.bonus-type.update',$item->id) }}" id="bonusTypeFormEdit" method="post">
    @csrf
    <div class="erp-modal-body-content ">
        <div class="input-block erp-step-input-block mb-2">
            <label class="col-form-label">Title<span class="text-danger">*</span></label>
            <input type="text" name="title" value="{{ $item->title }}" required class="form-control"  >
            <span class="title_error ie-span"></span>
        </div>
        <div class="input-block erp-step-input-block mb-2">
            <label class="col-form-label">Description</label>
            <textarea class="form-control" name="description" rows="2"> {!! $item->description !!} </textarea>
        </div>
        <div class="submit-section mt-2">
            <button class="btn btn-primary submit-btn" type="submit">Save</button>
        </div>
    </div>
</form>
