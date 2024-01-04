<form action="{{ route('hr.user-resignation.status-reject',$item->id) }}" id="userResignationRejectForm" method="post">
    @csrf
    <div class="erp-modal-body-content">
        <div class="input-block mb-2">
            <label class="col-form-label">Reject Reason </label>
            <textarea class="form-control" name="reject_reason" rows="4">{!! $item->reject_reason !!}</textarea>
        </div>
        <div class="submit-section mt-2">
            <button class="btn btn-primary submit-btn">Submit</button>
        </div>
    </div>
</form>
