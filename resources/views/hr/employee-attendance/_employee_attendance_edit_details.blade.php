<div class="modal-header erp-modal-header">
    <h5 class="modal-title">Attendance Info</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <div class="card punch-status">
                <div class="card-body">
                    <h5 class="card-title">Timesheet <small class="text-muted">{{ getFormattedDate($date,'j F, Y') }}</small></h5>
                    <div class="punch-det">
                        <h6>Punch In at</h6>
                        <p>{{ ($attendance_report) ? getFormattedDate($attendance_report->time_in,'D, jS M Y') : 'None' }} {{ ($attendance_report) ? getFormattedTime2($attendance_report->time_in) : '' }}</p>
                    </div>
                    <div class="punch-info">
                        <div class="punch-hours">
                            <span>{{ ($attendance_report) ? $attendance_report->total_work_time : '0.00' }} hrs</span>
                        </div>
                    </div>
                    <div class="punch-det">
                        <h6>Punch Out at</h6>
                        <p>{{ ($attendance_report) ? getFormattedDate($attendance_report->time_out,'D, jS M Y') : 'None' }} {{ ($attendance_report) ? getFormattedTime2($attendance_report->time_out) : '' }}</p>
                    </div>
                    <div class="statistics">
                        <div class="row">
                            <div class="col-md-6 col-6 text-center">
                                <div class="stats-box">
                                    <p>Break</p>
                                    <h6>{{ ($attendance_report) ? $attendance_report->total_break_time : '0:00' }} hrs</h6>
                                </div>
                            </div>
                            <div class="col-md-6 col-6 text-center">
                                <div class="stats-box">
                                    <p>Overtime</p>
                                    <h6>{{ ($attendance_report) ? $attendance_report->total_overtime : '0:00' }} hrs</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card recent-activity">
                <div class="card-body">
                    <h5 class="card-title">Activity</h5>
                    <ul class="res-activity-list">
                        @foreach($activity_history as $activity)
                            <li class="">
                                <p class="mb-0">Punch {{ $activity::TYPES[$activity->type] }} at</p>
                                <p class="res-activity-time">
                                    <i class="fa-regular fa-clock"></i>
                                    {{ getFormattedTime2($activity->datetime) }}.
                                </p>
                                @if(hasPermission('manage-employee-attendance'))
                                    <a href="javascript:void(0)" onclick="editAttendance({{$activity->id}})" class="edit-icon edit-attd">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
