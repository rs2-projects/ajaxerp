<!-- Add Resignation Modal -->
<div id="add_user_termination_modal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header erp-modal-header">
                <h5 class="modal-title">Add Termination</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body erp-modal-body">
                <form action="{{ route('hr.user-termination.store') }}" id="userTerminationStoreForm" method="post">
                    @csrf
                    <div class="erp-modal-body-content">
                        <div class="input-block erp-step-input-block mb-2">
                            <label class="col-form-label">Employee <span class="text-danger">*</span></label>
                            <select class="select select-step" name="user_id" required>
                                <option value="">Select Employee</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-block mb-2">
                            <label class="col-form-label">Notice Date <span class="text-danger">*</span></label>
                            <div class="cal-icon">
                                <input type="text" name="notice_date" required class="form-control datetimepicker">
                            </div>
                        </div>
                        <div class="input-block erp-step-input-block mb-2">
                            <label class="col-form-label">Termination Type <span class="text-danger">*</span></label>
                            <select class="select select-step" name="settings_termination_type_id" required>
                                <option value="">Select Type</option>
                                @foreach($terminationTypes as $terminationType)
                                    <option value="{{ $terminationType->id }}">{{ $terminationType->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-block mb-2">
                            <label class="col-form-label">Reason <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="reason" rows="4"></textarea>
                        </div>
                        <div class="submit-section mt-2">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add Resignation Modal -->
