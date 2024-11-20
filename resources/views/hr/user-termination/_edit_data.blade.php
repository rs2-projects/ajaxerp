<form action="{{ route('hr.user-termination.update',$item->id) }}" id="userTerminationUpdateForm" method="post">
    @csrf
    <div class="erp-modal-body-content">
        <div class="input-block mb-2">
            <label class="col-form-label">Termination Date <span class="text-danger">*</span></label>
            <div class="cal-icon">
                <input type="text" name="termination_date" value="{{ $item->termination_date }}" required class="form-control datetimepicker">
            </div>
        </div>
        <div class="input-block erp-step-input-block mb-2">
            <label class="col-form-label">Termination Type <span class="text-danger">*</span></label>
            <select class="select select-step select2" name="settings_termination_type_id" required>
                <option value="">Select Type</option>
                @foreach($terminationTypes as $terminationType)
                    <option value="{{ $terminationType->id }}" {{ ($item->settings_termination_type_id == $terminationType->id) ? 'selected' : '' }}>{{ $terminationType->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="input-block mb-2">
            <label class="col-form-label">Reason <span class="text-danger">*</span></label>
            <textarea class="form-control" name="reason" rows="4" required>{!! $item->reason !!}</textarea>
        </div>
        <div class="submit-section mt-2">
            <button class="btn btn-primary submit-btn">Submit</button>
        </div>
    </div>
</form>
