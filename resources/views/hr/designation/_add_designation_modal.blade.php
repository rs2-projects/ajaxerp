<!-- Add designation Modal -->
<div id="add_designation_modal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header erp-modal-header">
                <h5 class="modal-title">Add Designation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body erp-modal-body">
                <form action="{{ route('hr.designation.store') }}" id="designationStoreForm" method="post">
                    @csrf
                    <div class="erp-modal-body-content">
                        <div class="input-block mb-2">
                            <label class="col-form-label">Department <span class="text-danger">*</span></label>
                            <select class="select select-step select2" name="department_id" required>
                                <option value="">Select Department</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach

                            </select>
                            <span class="department_id_error ie-span"></span>
                        </div>
                        <div class="input-block mb-2">
                            <label class="col-form-label">Designation Name <span class="text-danger">*</span></label>
                            <input class="form-control" name="name" required type="text">
                            <span class="name_error ie-span"></span>
                        </div>
                        <div class="input-block mb-3">
                            <label class="col-form-label">Description </label>

                            <textarea cols="30" rows="3" class="form-control" name="description"></textarea>
                        </div>
                        <div class="submit-section mt-2">
                            <button class="btn btn-primary submit-btn" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add designation Modal -->
