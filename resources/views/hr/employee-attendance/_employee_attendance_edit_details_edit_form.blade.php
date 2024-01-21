<div class="modal-header erp-modal-header">
    <h5 class="modal-title">
        @if(!empty($employee))
            {{ $employee->full_name??'' }}
        @else
            Attendance Info
        @endif
    </h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <div class="card recent-activity">
                <div class="card-body">
                    <h5 class="card-title">Edit Attendance</h5>
                    <p>
                        Time {{ ($att_data) ? $att_data::TYPES[$att_data->type] : 'None' }}
                    </p>
                    <form action="{{ route('hr.employee-attendance.get-employee-attendance-edit-details-by-date.update',$att_data->id) }}" id="attendanceUpdateByDateForm" method="post">
                        @csrf
                        <input type="time" class="form-control" name="time" value="{{ ($att_data->datetime != '') ? getFormattedTime($att_data->datetime) :'' }}" required>
                        <br>
                        <button type="submit" class="erp-search-btn text-center">Update</button>
                    </form>

                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card recent-activity">
                <div class="card-body">
                    <h4>
                        Date : {{ ($att_data) ? getFormattedDate($att_data->datetime,'D, jS M Y') : 'None' }}
                    </h4>


                </div>
            </div>
        </div>
    </div>
</div>
