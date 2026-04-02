<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">

            <ul class="sidebar-vertical">
                <li>
                    <a href="{{ route('dashboard') }}"><i class="fa fa-home erp-back-home"></i> <span>Back To Home</span></a>
                </li>
                @if(hasPermission( 'manage-administration-settings'))
                    <li>
                        <a href="{{ route('settings.company') }}" class="{{ ($activeMenu == 'settings.company') ? 'active' : '' }}"><i class="la la-building"></i> <span>Company</span></a>
                    </li>
                    <li class="menu-title">
                        <span>Administration</span>
                    </li>
                    <li>
                        <a href="{{ route('settings.office-time') }}" class="{{ ($activeMenu == 'settings.office-time')?'active':'' }}"><i class="la la-share-alt"></i> <span>Office Time</span></a>
                    </li>
                    <li>
                        <a href="{{ route('settings.over-time') }}" class="{{ ($activeMenu == 'settings.over-time')?'active':'' }}"><i class="la la-clock-o"></i> <span>Overtime</span></a>
                    </li>
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
                @endif

                @if(hasPermission( 'manage-payroll-settings'))
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
                    <li>
                        <a href="{{ route('settings.salary-deduction-type') }}" class="{{ ($activeMenu == 'settings.salary-deduction-type')?'active':'' }}"><i class="la la-crosshairs"></i> <span>Salary Deduction Type</span></a>
                    </li>
                @endif

                {{--<li class="menu-title">
                    <span>Production</span>
                </li>
                <li>
                    <a href="{{ route('settings.board-color.index') }}" class="{{ ($activeMenu == 'settings.board-color.index') ? 'active' : ''}}"><i class="la la-crosshairs"></i> <span>Board Color</span></a>
                </li>

                <li>
                    <a href="{{ route('settings.board-embossed.index') }}" class="{{ ($activeMenu == 'settings.board-embossed.index') ? 'active' : '' }}"><i class="la la-crosshairs"></i> <span>Board Embossed</span></a>
                </li>--}}

                @if(hasPermission( 'manage-tax-settings'))
                    <li class="menu-title">
                        <span>Tax Setting</span>
                    </li>
                    <li>
                        <a href="{{ route('settings.vat-tax-type.index') }}" class="{{ ($activeMenu == 'settings.vat-tax-type.index') ? 'active' : '' }}"><i class="la la-ioxhost"></i> <span>Vat Tax</span></a>
                    </li>
                @endif
                @if(hasPermission( 'manage-role-permission-settings'))
                    <li class="menu-title">
                        <span>Role Management</span>
                    </li>
                    <li>
                        <a href="{{ route('settings.role-management.index') }}" class="{{ ($activeMenu == 'settings.role-management.index') ? 'active' : '' }}"><i class="la la-users"></i> <span>Role Settings </span></a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
