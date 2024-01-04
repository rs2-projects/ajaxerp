<form action="{{ route('user.resignation.update',$item->id) }}" id="userResignationUpdateForm" method="post">
    @csrf
    <div class="erp-modal-body-content">
        <div class="input-block mb-2">
            <label class="col-form-label">Resignation Date <span class="text-danger">*</span></label>
            <div class="cal-icon">
                <input type="text" value="{{ $item->resignation_date }}" name="resignation_date" required class="form-control datetimepicker">
            </div>
        </div>
        <div class="input-block mb-2">
            <label class="col-form-label">Reason </label>
            <textarea class="form-control" name="reason" required rows="4">{!! $item->reason !!}</textarea>
        </div>
        <div class="submit-section mt-2">
            <button class="btn btn-primary submit-btn">Submit</button>
        </div>
    </div>
</form>
