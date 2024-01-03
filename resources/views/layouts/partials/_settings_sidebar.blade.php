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
                {{--<li>
                    <a href="weekend-setting.html"><i class="la la-building"></i> <span>Weekend</span></a>
                </li>--}}
                <li>
                    <a href="{{ route('settings.holidays') }}" class="{{ ($activeMenu == 'settings.holidays')?'active':'' }}"><i class="la la-object-ungroup"></i> <span>Holidays</span></a>
                </li>
                <li>
                    <a href="{{ route('settings.leave-type') }}" class="{{ ($activeMenu == 'settings.leave-type')?'active':'' }}"><i class="la la-cogs"></i> <span>Leave Type</span></a>
                </li>
                <li>
                    <a href="{{ route('settings.geo-location') }}" class="{{ ($activeMenu == 'settings.geo-location')?'active':'' }}"><i class="la la-globe"></i> <span>GEO Location</span></a>
                </li>
                <li>
                    <a href="{{ route('settings.termination-type') }}" class="{{ ($activeMenu == 'settings.termination-type')?'active':'' }}"><i class="la la-globe"></i> <span>Termination Type</span></a>
                </li>
                <li class="menu-title">
                    <span>Payroll</span>
                </li>
                <li>
                    <a href="{{ route('settings.salary-type') }}" class="{{ ($activeMenu == 'settings.salary-type' || $activeMenu == 'settings.salary-type.create' || $activeMenu == 'settings.salary-type.edit') ? 'active' : ''}}"><i class="la la-crosshairs"></i> <span>Salary</span></a>
                </li>

                <li>
                    <a href="{{ route('settings.absent-penalty') }}" class="{{ ($activeMenu == 'settings.absent-penalty') ? 'active' : '' }}"><i class="la la-crosshairs"></i> <span>Absent Penalty</span></a>
                </li>
                <li>
                    <a href="{{ route('settings.late-penalty') }}" class="{{ ($activeMenu == 'settings.late-penalty') ? 'active' : '' }}"><i class="la la-crosshairs"></i> <span>Late Penalty</span></a>
                </li>
                <li>
                    <a href="{{ route('settings.bonus-type') }}" class="{{ ($activeMenu == 'settings.bonus-type')?'active':'' }}"><i class="la la-crosshairs"></i> <span>Bonus</span></a>
                </li>
                <li>
                    <a href="{{ route('settings.bonus-type-salary') }}" class="{{ ($activeMenu == 'settings.bonus-type-salary')?'active':'' }}"><i class="la la-crosshairs"></i> <span>Salary Bonus</span></a>
                </li>

            </ul>
        </div>
    </div>
</div>
