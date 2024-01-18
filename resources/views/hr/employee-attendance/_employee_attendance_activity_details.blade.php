
<div class="row mt-2">
    <div class="col-md-6">
        <div class="card recent-activity">
            <div class="card-body">
                <h5 class="card-title">Activity</h5>
                <ul class="res-activity-list">
                    @if(!empty($activity_history))
                        @foreach($activity_history as $activity)
                            <li>
                                <p class="mb-0">Punch {{ $activity::TYPES[$activity->type] }} at</p>
                                <p class="res-activity-time">
                                    <i class="fa fa-clock-o"></i>
                                    {{ getFormattedTime2($activity->datetime) }}.
                                </p>
                            </li>
                        @endforeach
                    @endif

                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card punch-status">
            <div class="card-body">
                <h5 class="card-title">Set Attendance</h5>

                <table class="table table-bordered table-hover" id="add_attendance_content_table">
                    <thead>
                    <tr>
                        <th>Type</th>
                        <th>Time</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            @if($last_flag == \App\Models\AttendanceHistory::TYPE_IN)
                                Punch Out
                            @else
                                Punch In
                            @endif
                        </td>
                        <td>
                            <input type="hidden" class="form-control" name="flag[]" value="{{ ($last_flag == \App\Models\AttendanceHistory::TYPE_IN)?2:1 }}">
                            <input type="time" class="form-control" min="{{ $last_activity_time }}" name="time[]" required>
                        </td>
                    </tr>

                    </tbody>
                </table>
                <div class="">
                    <button type="button" class="btn btn-sm btn-success d-inline" onclick='addNewAttendance()'><i class="fa fa-plus-circle"></i></button>
                    <button type="button" class="btn btn-sm btn-danger d-inline" onclick='removeLastRow()'><i class="fa fa-minus-circle"></i></button>
                </div>

                <div class="submit-section">
                    <button class="erp-search-btn text-center" type="submit">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>
