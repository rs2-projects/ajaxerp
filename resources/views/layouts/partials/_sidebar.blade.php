<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">

            <ul class="sidebar-vertical">
                <li class="menu-title">
                    <span>Main</span>
                </li>

                <li>
                    <a href="{{ route('dashboard') }}" class="{{ ($activeMenu == 'dashboard')?'active':'' }}"><i class="la la-dashboard"></i> <span>Dashboard</span></a>
                </li>
                @if(hasUserPermission(\App\Models\User::TYPE_EMPLOYEE))
                    <li>
                        <a href="{{ route('user.resignation') }}" class="{{ ($activeMenu == 'user.resignation')?'active':'' }}"><i class="la la-dashboard"></i> <span>Resignation</span></a>
                    </li>
                    <li>
                        <a href="{{ route('user.leaves') }}" class="{{ ($activeMenu == 'user.leaves')?'active':'' }}"><i class="la la-dashboard"></i> <span>Leaves</span></a>
                    </li>
                    <li>
                        <a href="{{ route('user.attendance') }}" class="{{ ($activeMenu == 'user.attendance')?'active':'' }}"><i class="la la-dashboard"></i> <span>My Attendance</span></a>
                    </li>
                @endif

                @if(hasUserPermission(\App\Models\User::TYPE_ADMIN))
                <li class="submenu">
                    <a href="javascript:void(0);" class="{{ ($activeMenu == 'hr.employee' || $activeMenu == 'hr.employee.create' || $activeMenu == 'hr.employee.edit' || $activeMenu == 'hr.employee.details'
                        || $activeMenu == 'hr.department' || $activeMenu == 'hr.designation'
                        || $activeMenu == 'hr.salary-set' || $activeMenu == 'hr.salary-create'
                        || $activeMenu == 'hr.user-leaves') || $activeMenu == 'hr.employee-attendance' ? 'active' : '' }} noti-dot"><i class="la la-users"></i> <span> HR Corporate</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li class="submenu">
                            <a href="javascript:void(0);"> <span>Attendance</span> <span class="menu-arrow"></span></a>
                            <ul>
                                {{--<li><a href="reports.html"><span>Reports</span></a></li>--}}
                                <li><a href="{{ route('hr.employee-attendance') }}"><span>Employee Attendance</span></a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="{{ route('hr.user-leaves') }}" class="{{ ($activeMenu == 'hr.user-leaves') ? 'active' : '' }}"> <span>Leaves</span></a>
                        </li>
                        <li>
                            <a href="{{ route('hr.employee') }}" class="{{ ($activeMenu == 'hr.employee' || $activeMenu == 'hr.employee.create' || $activeMenu == 'hr.employee.edit' || $activeMenu == 'hr.employee.details') ? 'active' : '' }}"><span>Employee</span></a>
                        </li>
                        <li>
                            <a href="{{ route('hr.user-contractor') }}" class="{{ ($activeMenu == 'hr.user-contractor') ? 'active' : '' }}"><span>Contractors</span></a>
                        </li>
                        <li>
                            <a href="{{ route('hr.salary-set') }}" class="{{ ($activeMenu == 'hr.salary-set' || $activeMenu == 'hr.salary-set.create') ? 'active' : '' }}"><span>Salary Set</span></a>
                        </li>
                        <li>
                            {{--<a href="notice.html"><span>Notice</span></a>--}}
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);" class="{{ ($activeMenu == 'hr.department' || $activeMenu == 'hr.designation' || $activeMenu == 'hr.user-termination' || $activeMenu == 'hr.user-resignation')?'active':'' }}"> <span>More</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="{{ route('hr.department') }}" class="{{ ($activeMenu == 'hr.department')?'active':'' }}"><span>Department</span></a></li>
                                <li><a href="{{ route('hr.designation') }}" class="{{ ($activeMenu == 'hr.designation')? 'active' : ''}}"><span>Designation</span></a></li>
                                <li><a href="{{ route('hr.user-termination') }}" class="{{ ($activeMenu == 'hr.user-termination')? 'active' : ''}}"><span>Terminated Employee</span></a></li>
                                <li><a href="{{ route('hr.user-resignation') }}" class="{{ ($activeMenu == 'hr.user-resignation')? 'active' : ''}}"><span>Resignation List</span></a></li>
{{--                                <li class="submenu">--}}
{{--                                    <a href="javascript:void(0);"> <span> Resignation</span> <span class="menu-arrow"></span></a>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="resignation-notice.html">Resignation Notice</a></li>--}}
{{--                                        <li><a href="#">Resignation List</a></li>--}}
{{--                                    </ul>--}}
{{--                                </li>--}}
                                {{--<li class="submenu">
                                    <a href="javascript:void(0);"> <span> Termination</span> <span class="menu-arrow"></span></a>
                                    <ul>
                                        <li><a href="termination-notice.html">Termination Notice</a></li>
                                        <li><a href="terminated-employee.html">Terminated Employee</a></li>
                                        <li><a href="termination-tyoe">Termination Type</a></li>
                                    </ul>
                                </li>--}}
                                {{--<li class="submenu">
                                    <a href="javascript:void(0);"> <span> Promotion</span> <span class="menu-arrow"></span></a>
                                    <ul>
                                        <li><a href="promoted-employee.html">Promoted Employee</a></li>
                                        <li><a href="promotion-type.html">Promotion Type</a></li>
                                    </ul>
                                </li>--}}

                            </ul>
                        </li>

                    </ul>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);" class="{{ ($activeMenu == 'hr.generate-salary' || $activeMenu == 'payroll.generated-salary') ? 'active' : '' }} noti-dot"><i class="la la-money"></i> <span> Payroll</span> <span class="menu-arrow"></span></a>
                    <ul>

                        <li>
                            <a href="{{ route('payroll.generate-salary') }}" class="{{ ($activeMenu == 'payroll.generate-salary') ? 'active' : '' }}"> <span>Generate Salary</span></a>
                        </li>
                        <li>
                            <a href="{{ route('payroll.generated-salary') }}" class="{{ ($activeMenu == 'payroll.generated-salary') ? 'active' : '' }}"><span>Salary List</span></a>
                        </li>
                    </ul>
                </li>
                {{--<li class="submenu">
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
                </li>--}}




                {{--<li class="menu-title">
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
                </li>--}}

                    <li class="menu-title">
                        <span>Inventory</span>
                    </li>
                    <li class="submenu">
                        <a href="javascript:void(0);" class="{{ ($activeMenu == 'inventory.product-material.index' || $activeMenu =='inventory.product-material-category.index') ? 'active' : '' }} noti-dot"><i class="la la-get-pocket"></i> <span> Product Material</span> <span class="menu-arrow"></span></a>
                        <ul>
                            <li>
                                <a href="{{ route('inventory.product-material.index') }}" class="{{ ($activeMenu == 'inventory.product-material.index') ? 'active' : ''}}"> <span>Material List</span></a>
                            </li>
                            <li>
                                <a href="{{ route('inventory.product-material-category.index') }}" class="{{ ($activeMenu == 'inventory.product-material-category.index') ? 'active' : '' }}"> <span>Category</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="javascript:void(0);" class="{{ ($activeMenu == 'inventory.asset-product-category.index' || $activeMenu == 'inventory.asset-product.index') ? 'active' : '' }} noti-dot"><i class="la la-object-ungroup"></i> <span> Assets</span> <span class="menu-arrow"></span></a>
                        <ul>
                            <li>
                                <a href="{{ route('inventory.asset-product.index') }}" class="{{ ($activeMenu == 'inventory.asset-product.index') ? 'active' : '' }}"> <span>Assets List</span></a>
                            </li>
                            <li>
                                <a href="{{ route('inventory.asset-product-category.index') }}" class="{{ ($activeMenu == 'inventory.asset-product-category.index') ? 'active' : '' }}"> <span>Category</span></a>
                            </li>
                        </ul>
                    </li>

                <li class="menu-title">
                    <span>Warehouse</span>
                </li>
                <li>
                    <a href="{{ route('inventory.warehouse.index') }}" class="{{ ($activeMenu == 'inventory.warehouse.index' || $activeMenu == 'inventory.warehouse.create') ? 'active' : '' }}"><i class="la la-icons"></i> <span>Warehouse</span></a>
                </li>

                <li class="menu-title">
                    <span>Accounting</span>
                </li>
                <li>
                    <a href="{{ route('accounting.chart-of-accounts.index') }}" class="{{ ($activeMenu == 'accounting.chart-of-accounts.index') ? 'active' : '' }}"><i class="la la-git"></i> <span>Chart Of Account</span></a>
                </li>

                <li class="menu-title">
                    <span>Administration</span>
                </li>

                <li>
                    <a href="{{ route('settings.office-time') }}"><i class="la la-cog"></i> <span>Settings</span></a>
                </li>
                @endif

            </ul>
        </div>
    </div>
</div>
