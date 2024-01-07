@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        <div class="my-attendance-wrapper d-flex justify-content-center flex-wrap">
            <div class="my-attendance-box-item bg-card">
                <div class="erp-box-header">
                    <h4>Timesheet <span> ({{ getFormattedDate(\Carbon\Carbon::now(),'d M, Y') }})</span></h4>
                </div>
                <div class="erp-box-body erp-punch-body">

                    <div class="punch-in-out-box position-relative">
                        <div class="pulse-css"></div>
                        <label class="switch punch-switch ">

                            <input type="checkbox" id="attendanceCheckbox">
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
                            <p>7.30 hrs</p>
                        </div>
                        <div class="punch-overtime">
                            <h4>Overtime</h4>
                            <p>0.30 hrs</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="my-attendance-box-item bg-card">
                <div class="erp-box-header">
                    <h4>Today Activity</h4>
                </div>
                <div class="erp-box-body erp-timeline">
                    <ul class="timeline list-unstyled">
                        <li>
                            <div class="timeline-time text-end">
                                <span class="time d-inline-block punch-badge">IN</span>
                            </div>
                            <div class="timeline-icon">
                                <a href="javascript:void(0);"></a>
                            </div>
                            <div class="timeline-body">
                                <div class="timeline-header er-punch">
                                    <span class="d-block p-in">Punch In at</span>
                                    <span class="d-block p-time">10:00 AM</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="timeline-time text-end">
                                <span class="time d-inline-block punch-badge">OUT</span>
                            </div>
                            <div class="timeline-icon">
                                <a href="javascript:void(0);"></a>
                            </div>
                            <div class="timeline-body">
                                <div class="timeline-header er-punch">
                                    <span class="d-block p-out">Punch Out at</span>
                                    <span class="d-block p-time">11:00 AM</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="timeline-time text-end">
                                <span class="time d-inline-block punch-badge">IN</span>
                            </div>
                            <div class="timeline-icon">
                                <a href="javascript:void(0);"></a>
                            </div>
                            <div class="timeline-body">
                                <div class="timeline-header er-punch">
                                    <span class="d-block p-out">Punch In at</span>
                                    <span class="d-block p-time">01:00 PM</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="timeline-time text-end">
                                <span class="time d-inline-block punch-badge">OUT</span>
                            </div>
                            <div class="timeline-icon">
                                <a href="javascript:void(0);"></a>
                            </div>
                            <div class="timeline-body">
                                <div class="timeline-header er-punch">
                                    <span class="d-block p-out">Punch Out at</span>
                                    <span class="d-block p-time">06:00 PM</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="my-attendance-box-item bg-card">
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
            </div>
            <div class="my-attendance-box-item bg-card flex-100 attd-table">
                <div class="my-attendance-report-wrapper">
                    <div class="erp-header-main-wrap d-flex justify-content-between align-items-center">
                        <div class="erp-box-header">
                            <h4>Attendance Status </h4>
                        </div>
                        <div class="erp-filter-box d-flex align-items-center justify-content-end">

                            <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-end">
                                <div class="erp-filter-item">
                                    <h6 class="me-2">Search By: </h6>
                                </div>
                                <div class="erp-filter-item">
                                    <div class=" form-focus select-focus custom-form-focus">
                                        <select class="select floating select2-box">
                                            <option>Select Month</option>
                                            <option>January</option>
                                            <option>February</option>
                                            <option>March</option>
                                            <option>April</option>
                                            <option>May</option>
                                            <option>June</option>
                                            <option>July</option>
                                            <option>August</option>
                                            <option>September</option>
                                            <option>October</option>
                                            <option>November</option>
                                            <option>December</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="erp-filter-item">
                                    <div class=" form-focus select-focus custom-form-focus">
                                        <select class="select floating select2-box">
                                            <option>Select Year</option>
                                            <option>2023</option>
                                            <option>2022</option>
                                            <option>2021</option>
                                            <option>Last Year</option>
                                            <option>Last Two Years</option>

                                        </select>

                                    </div>
                                </div>
                                <div class="erp-filter-item">
                                    <div class="erp-search-btn-wrap">
                                        <button class=" erp-search-btn">Search</button>
                                    </div>
                                </div>
                            </div>
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
                            <div class="table-body-item-wrapper d-flex flex-wrap">
                                <div class="table-body-item my-att">
                                    <h4>01</h4>
                                </div>
                                <div class="table-body-item my-att ">
                                    <h4 class="text-center">14 November, 2023</h4>
                                </div>
                                <div class="table-body-item my-att">
                                    <h4 class="text-center">10:00 AM</h4>
                                </div>
                                <div class="table-body-item my-att ">
                                    <h4 class="text-center">06:00 PM</h4>
                                </div>
                                <div class="table-body-item my-att ">
                                    <h4 class="text-center">01:00 </h4>
                                </div>
                                <div class="table-body-item my-att ">
                                    <h4 class="text-center">00:30</h4>
                                </div>

                            </div>
                            <div class="table-body-item-wrapper d-flex flex-wrap">
                                <div class="table-body-item my-att">
                                    <h4>02</h4>
                                </div>
                                <div class="table-body-item my-att ">
                                    <h4 class="text-center">15 November, 2023</h4>
                                </div>
                                <div class="table-body-item my-att">
                                    <h4 class="text-center">10:00 AM</h4>
                                </div>
                                <div class="table-body-item my-att ">
                                    <h4 class="text-center">06:30 PM</h4>
                                </div>
                                <div class="table-body-item my-att ">
                                    <h4 class="text-center">01:00 </h4>
                                </div>
                                <div class="table-body-item my-att ">
                                    <h4 class="text-center">01:00</h4>
                                </div>

                            </div>
                            <div class="table-body-item-wrapper d-flex flex-wrap">
                                <div class="table-body-item my-att">
                                    <h4>03</h4>
                                </div>
                                <div class="table-body-item my-att ">
                                    <h4 class="text-center">16 November, 2023</h4>
                                </div>
                                <div class="table-body-item my-att">
                                    <h4 class="text-center">10:00 AM</h4>
                                </div>
                                <div class="table-body-item my-att ">
                                    <h4 class="text-center">07:30 PM</h4>
                                </div>
                                <div class="table-body-item my-att ">
                                    <h4 class="text-center">01:00 </h4>
                                </div>
                                <div class="table-body-item my-att ">
                                    <h4 class="text-center">01:30</h4>
                                </div>

                            </div>
                            <div class="table-body-item-wrapper d-flex flex-wrap">
                                <div class="table-body-item my-att">
                                    <h4>04</h4>
                                </div>
                                <div class="table-body-item my-att ">
                                    <h4 class="text-center">17 November, 2023</h4>
                                </div>
                                <div class="table-body-item my-att">
                                    <h4 class="text-center"></h4>
                                </div>
                                <div class="table-body-item my-att ">
                                    <h4 class="text-center"></h4>
                                </div>
                                <div class="table-body-item my-att ">
                                    <h4 class="text-center">00:00</h4>
                                </div>
                                <div class="table-body-item my-att ">
                                    <h4 class="text-center">00:00</h4>
                                </div>

                            </div>
                            <div class="table-body-item-wrapper d-flex flex-wrap">
                                <div class="table-body-item my-att">
                                    <h4>05</h4>
                                </div>
                                <div class="table-body-item my-att ">
                                    <h4 class="text-center">18 November, 2023</h4>
                                </div>
                                <div class="table-body-item my-att">
                                    <h4 class="text-center"></h4>
                                </div>
                                <div class="table-body-item my-att ">
                                    <h4 class="text-center"></h4>
                                </div>
                                <div class="table-body-item my-att ">
                                    <h4 class="text-center">00:00</h4>
                                </div>
                                <div class="table-body-item my-att ">
                                    <h4 class="text-center">00:00</h4>
                                </div>

                            </div>
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
        $('#attendanceCheckbox').on('change', function () {
            console.log('test');
            var isChecked = $(this).prop('checked');
            var action = isChecked ? 'punchIn' : 'punchOut';
            navigator.geolocation.getCurrentPosition(function (position) {
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;
                console.log(latitude, longitude);
                let url = "{{route('user.attendance.punch')}}";
                ajaxGet(url, {action:action,latitude:latitude,longitude:longitude}, function (response) {
                    if (response.status == 200) {
                        console.log(response)
                    } else {
                        toastr.error(response.message);
                    }
                }, 'default');
            });
        });
    </script>
@endsection


