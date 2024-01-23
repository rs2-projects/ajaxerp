@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        <div class="my-attendance-wrapper d-flex justify-content-start flex-wrap">
            <div class="my-attendance-box-item bg-card">
                <div class="erp-box-header">
                    <h4>Timesheet <span> ({{ getFormattedDate(\Carbon\Carbon::now(),'d M, Y') }})</span></h4>
                </div>
                <div class="erp-box-body erp-punch-body">

                    <div class="punch-in-out-box position-relative">
                        <div class="pulse-css"></div>
                        <label class="switch punch-switch ">

                            <input type="checkbox" id="attendanceCheckbox" {{ ($new_punch_type == \App\Models\AttendanceHistoryToday::TYPE_OUT) ? 'checked' : '' }}>
                            <div class="slider slider--0">Punch Out</div>
                            <div class="slider slider--1">
                                <div></div>
                                <div></div>
                            </div>
                            <div class="slider slider--2"></div>
                            <div class="slider slider--3">Punch In</div>
                        </label>
                        <h4 class="help-title">Press & Hold</h4>
                    </div>
                    <div
                        class="punch-child-box d-flex justify-content-between flex-wrap mt-3 align-items-center">
                        <div class="punch-hour-box">
                            <h4>Working Time</h4>
                            <p>{{ $working_hours }} hrs</p>

                        </div>
                        <div class="punch-overtime">
                            <h4>Overtime</h4>
                            <p>{{ $overtime['overtime'] }} hrs</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="my-attendance-box-item bg-card">
                <div class="erp-box-header">
                    <h4>Today Activity</h4>
                </div>
                <div class="erp-box-body erp-timeline">
                    <ul class="timeline list-unstyled today-activity-data">
                        @foreach($attendance_history_today as $item)
                            <li>
                                <div class="timeline-time text-end">
                                    <span class="time d-inline-block punch-badge">{{ $item::TYPES[$item->type] }}</span>
                                </div>
                                <div class="timeline-icon">
                                    <a href="javascript:void(0);"></a>
                                </div>
                                <div class="timeline-body">
                                    <div class="timeline-header er-punch">
                                        <span class="d-block p-in">Punch {{ $item::TYPES[$item->type] }} at</span>
                                        <span class="d-block p-time">{{ getFormattedTime2($item->datetime) }}</span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            {{--<div class="my-attendance-box-item bg-card">
                <div class="erp-box-header">
                    <h4>Check In's</h4>
                </div>
                <div class="erp-checkin-box">
                    <div class="checkin-wrapper">
                        <div
                            class="checkin-item d-flex justify-content-center align-items-center flex-wrap">
                            <div class="checkin-input-box flex-70">
                                <label for="input-label"
                                       class="form-label custom-erp-form-label">Area/Title</label>
                                <input type="text" class="form-control custom-erp-form-control">
                            </div>

                            <div class="checkin-btn-box flex-100 text-center">
                                <button class="btn">Check In Now</button>
                            </div>
                        </div>
                    </div>
                    <div class="erp-box-body erp-timeline checkin-timeline">
                        <ul class="timeline list-unstyled">
                            <li>
                                <div class="timeline-icon">
                                    <a href="javascript:void(0);"></a>
                                </div>
                                <div class="timeline-body">
                                    <div class="timeline-header er-punch">
                                        <span class="d-block p-in">Check In at</span>
                                        <span class="d-block p-time">10:00 AM On
															<strong>Mohammadpur</strong> For Site Visit</span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="timeline-icon">
                                    <a href="javascript:void(0);"></a>
                                </div>
                                <div class="timeline-body">
                                    <div class="timeline-header er-punch">
                                        <span class="d-block p-out">Check In at</span>
                                        <span class="d-block p-time">02:00 PM On <strong>Shymoli</strong>
															For Marketing</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>--}}
            <div class="my-attendance-box-item bg-card flex-100 attd-table">
                <div class="my-attendance-report-wrapper">
                    <div class="erp-header-main-wrap d-flex justify-content-between align-items-center">
                        <div class="erp-box-header">
                            <h4>Attendance Status </h4>
                        </div>
                        <div class="erp-filter-box d-flex align-items-center justify-content-end">

                            <form>
                                <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-end">
                                    <div class="erp-filter-item">
                                        <h6 class="me-2">Search By: </h6>
                                    </div>
                                    <div class="erp-filter-item">
                                        <div class=" form-focus select-focus custom-form-focus">
                                            <select class="select floating select2-box" required name="month">
                                                <option value="">Select Month</option>
                                                @foreach($months as $key=>$month)
                                                    <option value="{{ $key }}"
                                                        {{ $key == request()->month ? 'selected' : '' }}>
                                                        {{ $month }}
                                                    </option>

                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                    <div class="erp-filter-item">
                                        <div class=" form-focus select-focus custom-form-focus">
                                            <select class="select floating select2-box" name="year" required>
                                                <option value="">-</option>
                                                @for($i=(date('Y') - 2);$i<=(date('Y'));$i++)
                                                    <option value="{{$i}}" {{ (request()->year == $i)?'selected':'' }}>{{ $i }}</option>
                                                @endfor

                                            </select>

                                        </div>
                                    </div>
                                    <div class="erp-filter-item">
                                        <div class="erp-search-btn-wrap">
                                            <button class=" erp-search-btn">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>

                    <div class="table-main-wrapper pt-4">
                        <div class="table-header-wrapper d-flex flex-wrap">
                            <div class="table-header-item my-att">
                                <h4>SL</h4>
                            </div>
                            <div class="table-header-item my-att text-center">
                                <h4>Date</h4>
                            </div>
                            <div class="table-header-item my-att text-center">
                                <h4>Punch In</h4>
                            </div>
                            <div class="table-header-item my-att text-center">
                                <h4>Punch Out</h4>
                            </div>
                            <div class="table-header-item my-att text-center">
                                <h4>Break Time (Hour)</h4>
                            </div>
                            <div class="table-header-item my-att text-center">
                                <h4>Over Time (Hour)</h4>
                            </div>
                        </div>
                        <div class="table-body-wrapper">
                            @php($sl = 0)
                            @while($attendance_list_end_date->gte($attendance_list_start_date))
                                @php($sl++)
                                @php($report = $attendance_reports->where('date', $attendance_list_end_date->format('Y-m-d'))->first())
                                <div class="table-body-item-wrapper d-flex flex-wrap">
                                    <div class="table-body-item my-att">
                                        <h4>{{ $sl }}</h4>
                                    </div>
                                    <div class="table-body-item my-att ">
                                        <h4 class="text-center">{{ getFormattedDate($attendance_list_end_date->format('Y-m-d'),'j M, Y') }}</h4>
                                    </div>
                                    <div class="table-body-item my-att">
                                        <h4 class="text-center">{{ getFormattedTime2($report->time_in ?? null) }}</h4>
                                    </div>
                                    <div class="table-body-item my-att ">
                                        <h4 class="text-center">{{ getFormattedTime2($report->time_out ?? null) }}</h4>
                                    </div>
                                    <div class="table-body-item my-att ">
                                        <h4 class="text-center">{{ $report->total_break_time ?? '' }} </h4>
                                    </div>
                                    <div class="table-body-item my-att ">
                                        <h4 class="text-center">{{ $report->total_overtime ?? '' }}</h4>
                                    </div>
                                </div>
                                @php($attendance_list_end_date->subDay())
                            @endwhile
                        </div>
                    </div>

                </div>
            </div>
        </div>


    </div>
    <!--End::row-1 -->
@endsection

@section('modals')

@endsection

@section('css')

@endsection

@section('css_plugins')

@endsection

@section('js_plugins')

@endsection

@section('js')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAw74VNUecFrAFANUq9WnHIKPVAPsCqyZg&libraries=drawing,places&v=weekly&callback=initialize" defer></script>
    <script>
        function getCurrentPosition() {
            return new Promise((resolve, reject) => {
                navigator.geolocation.getCurrentPosition(
                    function (position) {
                        resolve({ latitude: position.coords.latitude, longitude: position.coords.longitude });
                    },
                    function (error) {
                        reject(error);
                    }
                );
            });
        }

        $('#attendanceCheckbox').on('change', function () {
            getCurrentPosition()
                .then(({ latitude, longitude }) => {
                    let url = "{{route('user.attendance.punch')}}";
                    ajaxGet(url, { latitude: latitude, longitude: longitude }, function (response) {
                        if (response.status == 200) {
                            console.log(response);
                            toastr.success('Success');
                            window.location.reload();
                        } else {
                            toastr.error(response.message);
                        }
                    }, 'default');
                })
                .catch(error => {
                    console.error("Error getting geolocation:", error);
                    toastr.error('Please enable your location');
                });
        });

    </script>
@endsection


