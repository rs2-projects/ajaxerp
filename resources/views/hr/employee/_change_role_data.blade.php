<form action="{{ route('hr.employee.update-role', $item->id) }}" id="changeRoleUpdateForm" method="post">
    @csrf
    <div class="erp-modal-body-content">
        <div class="input-block mb-2">
            <label class="col-form-label">Role <span class="text-danger">*</span></label>
            <select class="select select-step select2-box select2" name="role_id" id="role_id"  required>
                <option value="">Select Role</option>
                @foreach($roles as $key=>$role)
                    <option value="{{ $role->id }}" {{$role->id == $item->role_id ? 'selected' : ''}}>{{ $role->title }}</option>
                @endforeach
            </select>
            <span class="name_error ie-span"></span>
        </div>
        <div class="submit-section mt-2">
            <button class="btn btn-primary submit-btn" type="submit">Update</button>
        </div>
    </div>
</form>
