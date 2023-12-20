<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">

            <ul class="sidebar-vertical">
                <li class="menu-title">
                    <span>Main</span>
                </li>

                <li>
                    <a href="index.html" class="{{ ($activeMenu == 'dashboard')?'active':'' }}"><i class="la la-dashboard"></i> <span>Dashboard</span></a>
                </li>


                <li class="submenu">
                    <a href="javascript:void(0);" class="{{ ($activeMenu == 'hr.employee' || $activeMenu == 'hr.employee.create' || $activeMenu == 'hr.department' || $activeMenu == 'hr.designation') ? 'active' : '' }} noti-dot"><i class="la la-users"></i> <span> HR Corporate</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li class="submenu">
                            <a href="javascript:void(0);"> <span>Attendance</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li ><a href="my-attendance.html"><span>My Attendance</span></a></li>
                                <li><a href="reports.html"><span>Reports</span></a></li>
                                <li><a href="employee-attendance.html"><span>Employee Attendance</span></a></li>


                            </ul>
                        </li>
                        <li>
                            <a href="leave.html"> <span>Leaves</span></a>
                        </li>
                        <li>
                            <a href="{{ route('hr.employee') }}" class="{{ ($activeMenu == 'hr.employee' || $activeMenu == 'hr.employee.create') ? 'active' : '' }}"><span>Employee</span></a>
                        </li>
                        <li>
                            <a href="notice.html"><span>Notice</span></a>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);" class="{{ ($activeMenu == 'hr.department' || $activeMenu == 'hr.designation')?'active':'' }}"> <span>More</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="{{ route('hr.department') }}" class="{{ ($activeMenu == 'hr.department')?'active':'' }}"><span>Department</span></a></li>
                                <li><a href="{{ route('hr.designation') }}" class="{{ ($activeMenu == 'hr.designation')? 'active' : ''}}"><span>Designation</span></a></li>

                                <li class="submenu">
                                    <a href="javascript:void(0);"> <span> Resignation</span> <span class="menu-arrow"></span></a>
                                    <ul>
                                        <li><a href="resignation-notice.html">Resignation Notice</a></li>
                                        <li><a href="resignation-list.html">Resignation List</a></li>
                                    </ul>
                                </li>
                                <li class="submenu">
                                    <a href="javascript:void(0);"> <span> Termination</span> <span class="menu-arrow"></span></a>
                                    <ul>
                                        <li><a href="termination-notice.html">Termination Notice</a></li>
                                        <li><a href="terminated-employee.html">Terminated Employee</a></li>
                                        <li><a href="termination-tyoe">Termination Type</a></li>
                                    </ul>
                                </li>
                                <li class="submenu">
                                    <a href="javascript:void(0);"> <span> Promotion</span> <span class="menu-arrow"></span></a>
                                    <ul>
                                        <li><a href="promoted-employee.html">Promoted Employee</a></li>
                                        <li><a href="promotion-type.html">Promotion Type</a></li>
                                    </ul>
                                </li>

                            </ul>
                        </li>

                    </ul>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);" class="noti-dot"><i class="la la-cube"></i> <span> HR Factory Force</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li class="submenu">
                            <a href="javascript:void(0);"> <span>Attendance</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="javascript:void(0);"><span>My Attendance</span></a></li>
                                <li><a href="javascript:void(0);"><span>Reports</span></a></li>
                                <li><a href="javascript:void(0);"><span>Employee Attendance</span></a></li>


                            </ul>
                        </li>
                        <li>
                            <a href="leave.html"> <span>Leaves</span></a>
                        </li>
                        <li>
                            <a href="employee.html"><span>Employee</span></a>
                        </li>
                        <li>
                            <a href="notice.html"><span>Notice</span></a>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"> <span>More</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="javascript:void(0);"><span>Department</span></a></li>
                                <li><a href="javascript:void(0);"><span>Designation</span></a></li>

                                <li class="submenu">
                                    <a href="javascript:void(0);"> <span> Resignation</span> <span class="menu-arrow"></span></a>
                                    <ul>
                                        <li><a href="javascript:void(0);">Resignation Notice</a></li>
                                        <li><a href="javascript:void(0);">Resignation List</a></li>
                                    </ul>
                                </li>
                                <li class="submenu">
                                    <a href="javascript:void(0);"> <span> Termination</span> <span class="menu-arrow"></span></a>
                                    <ul>
                                        <li><a href="javascript:void(0);">Termination Notice</a></li>
                                        <li><a href="javascript:void(0);">Terminated Employee</a></li>
                                        <li><a href="javascript:void(0);">Termination Type</a></li>
                                    </ul>
                                </li>
                                <li class="submenu">
                                    <a href="javascript:void(0);"> <span> Promotion</span> <span class="menu-arrow"></span></a>
                                    <ul>
                                        <li><a href="javascript:void(0);">Promoted Employee</a></li>
                                        <li><a href="javascript:void(0);">Promotion Type</a></li>
                                    </ul>
                                </li>

                            </ul>
                        </li>

                    </ul>
                </li>




                <li class="menu-title">
                    <span>Performance</span>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-graduation-cap"></i> <span> Performance </span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="javascript:void(0);"> Performance Indicator </a></li>
                        <li><a href="javascript:void(0);"> Performance Review </a></li>
                        <li><a href="javascript:void(0);"> Performance Appraisal </a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-crosshairs"></i> <span> Goals </span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="javascript:void(0);"> Goal List </a></li>
                        <li><a href="javascript:void(0);"> Goal Type </a></li>
                    </ul>
                </li>


                <li class="menu-title">
                    <span>Administration</span>
                </li>

                <li>
                    <a href="{{ route('settings.office-time') }}"><i class="la la-cog"></i> <span>Settings</span></a>
                </li>

            </ul>
        </div>
    </div>
</div>
