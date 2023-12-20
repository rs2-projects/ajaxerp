<form action="{{ route('hr.designation.update', $item->id) }}" id="designationUpdateForm" method="post">
    @csrf
    <div class="erp-modal-body-content">
        <div class="input-block mb-2">
            <label class="col-form-label">Department <span class="text-danger">*</span></label>
            <select class="select select-step select2" name="department_id" required>
                <option value="">Select Department</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}" {{($item->department_id == $department->id) ? 'selected' : ''}}>{{ $department->name }}</option>
                @endforeach

            </select>
            <span class="department_id_error ie-span"></span>
        </div>
        <div class="input-block mb-2">
            <label class="col-form-label">Designation Name <span class="text-danger">*</span></label>
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
