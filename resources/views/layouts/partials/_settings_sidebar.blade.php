<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">

            <ul class="sidebar-vertical">
                <li class="menu-title">
                    <span>Administration</span>
                </li>

                <li>
                    <a href="{{ route('dashboard') }}"><i class="fa fa-home erp-back-home"></i> <span>Back To Home</span></a>
                </li>
                <li>
                    <a href="{{ route('settings.office-time') }}" class="{{ ($activeMenu == 'settings.office-time')?'active':'' }}"><i class="la la-share-alt"></i> <span>Office Time</span></a>
                </li>
                <li>
                    <a href="{{ route('settings.over-time') }}" class="{{ ($activeMenu == 'settings.over-time')?'active':'' }}"><i class="la la-clock-o"></i> <span>Overtime</span></a>
                </li>
                <li>
                    <a href="weekend-setting.html"><i class="la la-building"></i> <span>Weekend</span></a>
                </li>
                <li>
                    <a href="holiday-setting.html"><i class="la la-object-ungroup"></i> <span>Holidays</span></a>
                </li>
                <li>
                    <a href="leave-type-setting.html"><i class="la la-cogs"></i> <span>Leave Type</span></a>
                </li>
                <li>
                    <a href="geo-setting.html"><i class="la la-globe"></i> <span>GEO Location</span></a>
                </li>
                <li class="menu-title">
                    <span>Payroll</span>
                </li>
                <li>
                    <a href="salary-setting.html" class="active"><i class="la la-crosshairs"></i> <span>Salary</span></a>
                </li>

                <li>
                    <a href="absent-setting.html"><i class="la la-crosshairs"></i> <span>Absent Penalty</span></a>
                </li>
                <li>
                    <a href="late-penalty-setting.html"><i class="la la-crosshairs"></i> <span>Late Penalty</span></a>
                </li>
                <li>
                    <a href="bonus-setting.html"><i class="la la-crosshairs"></i> <span>Bonus</span></a>
                </li>


            </ul>
        </div>
    </div>
</div>
