<form action="{{ route('hr.user-leaves.status-reject', $userLeave->id) }}" id="userLeaveRejectForm" method="post">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between">

                <div class="erp-filter-item flex-100">
                    <div class="input-block mb-0 erp-step-input-block">
                        <label class="col-form-label">Reject Reason <span class="text-danger">*</span></label>
                        <textarea  rows="4" class="form-control" name="reject_reason"></textarea>
                    </div>
                </div>

                <div class="erp-filter-item flex-100 mt-4">
                    <div class="erp-search-btn-wrap text-center">
                        <button class=" erp-search-btn text-center" type="submit">Submit</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>
