<form action="{{ route('production.production-staff.update', $item->id) }}" id="prodStaffUpdateForm" method="post">
    @csrf
    <div class="erp-modal-body-content">
        <div class="input-block mb-2">
            <label class="col-form-label">Title <span class="text-danger">*</span></label>
            <input class="form-control" name="title" value="{{ $item->title }}" required type="text">
            <span class="title_error ie-span"></span>
        </div>
        <div class="input-block mb-2">
            <label class="col-form-label">User Name <span class="text-danger">*</span></label>
            <input class="form-control" name="user_name" value="{{ $item->user_name }}" required type="text">
            <span class="user_name_error ie-span"></span>
        </div>
        {{-- <div class="input-block mb-2">
            <label class="col-form-label">Password</label>
            <input class="form-control" name="password" value="{{ $item->color }}" type="text">
        </div> --}}
        <div class="submit-section mt-2">
            <button class="btn btn-primary submit-btn" type="submit">Save</button>
        </div>
    </div>
</form>
