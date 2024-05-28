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
                @if(isEmployee())
                    <li>
                        <a href="{{ route('user.attendance') }}" class="{{ ($activeMenu == 'user.attendance')?'active':'' }}"><i class="la la-dashboard"></i> <span>My Attendance</span></a>
                    </li>
                    <li>
                        <a href="{{ route('user.leaves') }}" class="{{ ($activeMenu == 'user.leaves')?'active':'' }}"><i class="la la-dashboard"></i> <span>My Leaves</span></a>
                    </li>
                    <li>
                        <a href="{{ route('user.resignation') }}" class="{{ ($activeMenu == 'user.resignation')?'active':'' }}"><i class="la la-dashboard"></i> <span>My Resignation</span></a>
                    </li>
                @endif


                @if(hasPermission(
                    'view-departments','manage-departments','view-designations','manage-designations','view-employees','manage-employees','view-employee-termination','manage-employee-termination','view-employee-resignation','manage-employee-resignation','view-employee-leave','manage-employee-leave','view-employee-attendance','manage-employee-attendance','view-contractors','manage-contractors','view-salary-set','manage-salary-set'
                ))
                    <li class="menu-title">
                        <span>HR & Payroll</span>
                    </li>
                <li class="submenu">
                    <a href="javascript:void(0);" class="{{ ($activeMenu == 'hr.employee' || $activeMenu == 'hr.employee.create' || $activeMenu == 'hr.employee.edit' || $activeMenu == 'hr.employee.details'
                        || $activeMenu == 'hr.department' || $activeMenu == 'hr.designation'
                        || $activeMenu == 'hr.salary-set' || $activeMenu == 'hr.salary-create'
                        || $activeMenu == 'hr.user-leaves') || $activeMenu == 'hr.employee-attendance' ? 'active' : '' }} noti-dot"><i class="la la-users"></i> <span> HR Corporate</span> <span class="menu-arrow"></span></a>
                    <ul>
                        @if(hasPermission('view-employee-attendance','manage-employee-attendance'))
                            <li class="submenu">
                                <a href="javascript:void(0);"> <span>Attendance</span> <span class="menu-arrow"></span></a>
                                <ul>
                                    {{--<li><a href="reports.html"><span>Reports</span></a></li>--}}
                                    <li><a href="{{ route('hr.employee-attendance') }}"><span>Employee Attendance</span></a></li>
                                </ul>
                            </li>
                        @endif
                        @if(hasPermission('view-employee-leave','manage-employee-leave'))
                            <li>
                                <a href="{{ route('hr.user-leaves') }}" class="{{ ($activeMenu == 'hr.user-leaves') ? 'active' : '' }}"> <span>Leaves</span></a>
                            </li>
                        @endif
                        @if(hasPermission('view-employees','manage-employees'))
                            <li>
                                <a href="{{ route('hr.employee') }}" class="{{ ($activeMenu == 'hr.employee' || $activeMenu == 'hr.employee.create' || $activeMenu == 'hr.employee.edit' || $activeMenu == 'hr.employee.details') ? 'active' : '' }}"><span>Employee</span></a>
                            </li>
                        @endif
                        @if(hasPermission('view-contractors','manage-contractors'))
                            <li>
                                <a href="{{ route('hr.user-contractor') }}" class="{{ ($activeMenu == 'hr.user-contractor') ? 'active' : '' }}"><span>Contractors</span></a>
                            </li>
                        @endif
                        @if(hasPermission('view-salary-set','manage-salary-set'))
                            <li>
                                <a href="{{ route('hr.salary-set') }}" class="{{ ($activeMenu == 'hr.salary-set' || $activeMenu == 'hr.salary-set.create') ? 'active' : '' }}"><span>Salary Set</span></a>
                            </li>
                        @endif
                            @if(hasPermission(
                                'view-departments','manage-departments','view-designations','manage-designations','view-employee-termination','manage-employee-termination','view-employee-resignation','manage-employee-resignation'
                            ))
                            <li class="submenu">
                                <a href="javascript:void(0);" class="{{ ($activeMenu == 'hr.department' || $activeMenu == 'hr.designation' || $activeMenu == 'hr.user-termination' || $activeMenu == 'hr.user-resignation')?'active':'' }}"> <span>More</span> <span class="menu-arrow"></span></a>
                                <ul>
                                    @if(hasPermission('view-departments','manage-departments'))
                                        <li><a href="{{ route('hr.department') }}" class="{{ ($activeMenu == 'hr.department')?'active':'' }}"><span>Department</span></a></li>
                                    @endif
                                    @if(hasPermission('view-designations','manage-designations'))
                                        <li><a href="{{ route('hr.designation') }}" class="{{ ($activeMenu == 'hr.designation')? 'active' : ''}}"><span>Designation</span></a></li>
                                    @endif
                                    @if(hasPermission('view-employee-termination','manage-employee-termination'))
                                        <li><a href="{{ route('hr.user-termination') }}" class="{{ ($activeMenu == 'hr.user-termination')? 'active' : ''}}"><span>Terminated Employee</span></a></li>
                                    @endif
                                    @if(hasPermission('view-employee-resignation','manage-employee-resignation'))
                                        <li><a href="{{ route('hr.user-resignation') }}" class="{{ ($activeMenu == 'hr.user-resignation')? 'active' : ''}}"><span>Resignation List</span></a></li>
                                    @endif
                                </ul>
                            </li>
                        @endif

                    </ul>
                </li>
                @endif

                {{-- PAYROLL --}}
                @if(hasPermission( 'generate-salary','view-salary','manage-salary' ))
                    <li class="submenu">
                        <a href="javascript:void(0);" class="{{ ($activeMenu == 'hr.generate-salary' || $activeMenu == 'payroll.generated-salary') ? 'active' : '' }} noti-dot"><i class="la la-money"></i> <span> Payroll</span> <span class="menu-arrow"></span></a>
                        <ul>
                            @if(hasPermission('generate-salary'))
                                <li>
                                    <a href="{{ route('payroll.generate-salary') }}" class="{{ ($activeMenu == 'payroll.generate-salary') ? 'active' : '' }}"> <span>Generate Salary</span></a>
                                </li>
                            @endif
                            @if(hasPermission('view-salary','manage-salary'))
                                <li>
                                    <a href="{{ route('payroll.generated-salary') }}" class="{{ ($activeMenu == 'payroll.generated-salary') ? 'active' : '' }}"><span>Salary List</span></a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                {{-- procurement --}}
                @if(hasPermission( 'view-suppliers','manage-suppliers','view-product-material-purchase-orders','manage-product-material-purchase-orders','product-material-purchase-order-payment','view-asset-product-purchase-request','create-asset-product-purchase-request','manage-asset-product-purchase-request','view-asset-product-purchase-orders','manage-asset-product-purchase-orders','asset-product-purchase-order-payment' ))
                    <li class="menu-title">
                        <span>Procurement</span>
                    </li>
                    @if(hasPermission('view-asset-product-purchase-request','create-asset-product-purchase-request','manage-asset-product-purchase-request','view-asset-product-purchase-orders','manage-asset-product-purchase-orders','asset-product-purchase-order-payment'))
                        <li class="submenu">
                            <a href="javascript:void(0);" class="{{ ($activeMenu == 'procurement.user.asset-purchase-request.index' || $activeMenu == 'procurement.admin.asset-purchase-request.index' || $activeMenu == 'procurement.asset-purchase-order.index') ? 'active' : '' }} "><i class="la la-stack-exchange"></i> <span>Assets</span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                @if(hasPermission('create-asset-product-purchase-request'))
                                    <li><a href="{{ route('procurement.user.asset-purchase-request.index') }}" class="{{ ( $activeMenu == 'procurement.user.asset-purchase-request.index') ? 'active' : '' }}"><span>Purchase Request</span></a></li>
                                @endif
                                @if(hasPermission('view-asset-product-purchase-request','manage-asset-product-purchase-request'))
                                    <li><a href="{{ route('procurement.admin.asset-purchase-request.index') }}" class="{{ ( $activeMenu == 'procurement.admin.asset-purchase-request.index') ? 'active' : '' }}"><span>Purchase Request Manage</span></a></li>
                                @endif
                                @if(hasPermission( 'view-asset-product-purchase-orders','manage-asset-product-purchase-orders','asset-product-purchase-order-payment' ))
                                    <li><a href="{{ route('procurement.asset-purchase-order.index') }}" class="{{ ( $activeMenu == 'procurement.asset-purchase-order.index') ? 'active' : '' }}"> <span>Purchase Order(P.O)</span></a></li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if(hasPermission( 'view-product-material-purchase-orders','manage-product-material-purchase-orders','product-material-purchase-order-payment' ))
                        <li class="submenu">
                            <a href="javascript:void(0);" class="{{ ( $activeMenu == 'procurement.product-material-purchase.index') ? 'active' : '' }}"> <i class="la la-user-md"></i><span>Production Materials</span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                @if(hasPermission( 'view-product-material-purchase-orders','manage-product-material-purchase-orders','product-material-purchase-order-payment' ))
                                    <li><a href="{{ route('procurement.product-material-purchase.index') }}" class="{{ ($activeMenu == 'procurement.product-material-purchase.index') ? 'active' : '' }}"> <span>Purchase Order (P.O)</span></a></li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if(hasPermission( 'view-suppliers','manage-suppliers'))
                        <li>
                            <a href="{{ route('procurement.supplier.index') }}" class="{{ ($activeMenu == 'procurement.supplier.index') ? 'active' : '' }}">  <i class="la la-truck"></i><span>Suppliers</span></a>
                        </li>
                    @endif
                @endif

                <!--Sales and Order-->
                @if(hasPermission( 'view-customers','manage-customers','view-invoices','manage-invoices','make-payment','deliver-items'))
                    <li class="menu-title">
                        <span>Sales & Orders</span>
                    </li>
                    @if(hasPermission( 'view-customers','manage-customers' ))
                        <li>
                            <a href="{{ route('sales.customer.index') }}" class="{{ $activeMenu == 'sales.customer.index' ? 'active' : ''}}"><i class="la la-get-pocket"></i> <span>Customers</span></a>
                        </li>
                    @endif
                    @if(hasPermission( 'view-invoices','manage-invoices','make-payment','deliver-items'))
                        <li>
                            <a href="{{ route('sales.invoice.index') }}" class="{{ $activeMenu == 'sales.invoice.index' ? 'active' : ''}}"><i class="la la-file-pdf-o"></i> <span>Invoices</span></a>
                        </li>
                    @endif
                @endif

                {{-- inventory --}}
                @if(hasPermission( 'view-material-requests','deliver-requested-materials','view-product-material-category','manage-product-material-category','view-product-material','manage-product-material','view-asset-product-category','manage-asset-product-category','view-asset-product','manage-asset-product','view-finished-goods-category','manage-finished-goods-category','view-finished-goods','manage-finished-goods','view-received-products','receive-products'))
                    <li class="menu-title">
                        <span>Inventory</span>
                    </li>
                    @if(hasPermission( 'view-material-requests','deliver-requested-materials'))
                        <li>
                            <a href="{{route('inventory.material-request.index')}}"  class="{{ ($activeMenu == 'inventory.material-request.index') ? 'active' : ''}}"><i class="la la-tencent-weibo"></i> <span>Material Request<small class="small-rs-text">(Prod.)</small></span></a>
                        </li>
                    @endif
                    @if(hasPermission( 'view-product-material-category','manage-product-material-category','view-product-material','manage-product-material'))
                        <li class="submenu">
                            <a href="javascript:void(0);" class="{{ ($activeMenu == 'inventory.product-material.index' || $activeMenu =='inventory.product-material-category.index') ? 'active' : '' }} noti-dot"><i class="la la-get-pocket"></i> <span> Product Material</span> <span class="menu-arrow"></span></a>
                            <ul>
                                @if(hasPermission( 'view-product-material','manage-product-material'))
                                    <li>
                                        <a href="{{ route('inventory.product-material.index') }}" class="{{ ($activeMenu == 'inventory.product-material.index') ? 'active' : ''}}"> <span>Material List</span></a>
                                    </li>
                                @endif
                                @if(hasPermission( 'view-product-material-category','manage-product-material-category'))
                                    <li>
                                        <a href="{{ route('inventory.product-material-category.index') }}" class="{{ ($activeMenu == 'inventory.product-material-category.index') ? 'active' : '' }}"> <span>Category</span></a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if(hasPermission( 'view-asset-product-category','manage-asset-product-category','view-asset-product','manage-asset-product'))
                        <li class="submenu">
                            <a href="javascript:void(0);" class="{{ ($activeMenu == 'inventory.asset-product-category.index' || $activeMenu == 'inventory.asset-product.index') ? 'active' : '' }} noti-dot"><i class="la la-object-ungroup"></i> <span> Assets</span> <span class="menu-arrow"></span></a>
                            <ul>
                                @if(hasPermission( 'view-asset-product','manage-asset-product'))
                                    <li>
                                        <a href="{{ route('inventory.asset-product.index') }}" class="{{ ($activeMenu == 'inventory.asset-product.index') ? 'active' : '' }}"> <span>Assets List</span></a>
                                    </li>
                                @endif
                                @if(hasPermission( 'view-asset-product-category','manage-asset-product-category'))
                                    <li>
                                        <a href="{{ route('inventory.asset-product-category.index') }}" class="{{ ($activeMenu == 'inventory.asset-product-category.index') ? 'active' : '' }}"> <span>Category</span></a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if(hasPermission( 'view-finished-goods-category','manage-finished-goods-category','view-finished-goods','manage-finished-goods','view-received-products','receive-products'))
                        <li class="submenu">
                            <a href="javascript:void(0);" class="{{ ($activeMenu == 'inventory.finished-good-category.index' || $activeMenu == 'inventory.finished-good.index' || $activeMenu == 'inventory.receive-product.index') ? 'active' : '' }} noti-dot"><i class="la la-object-ungroup"></i> <span> Finished Goods</span> <span class="menu-arrow"></span></a>
                            <ul>
                                @if(hasPermission('view-received-products','receive-products'))
                                    <li>
                                        <a href="{{ route('inventory.receive-product.index') }}" class="{{ ($activeMenu == 'inventory.receive-product.index') ? 'active' : '' }}"> <span>Receive Products</span></a>
                                    </li>
                                @endif
                                @if(hasPermission( 'view-finished-goods','manage-finished-goods'))
                                    <li>
                                        <a href="{{ route('inventory.finished-good.index') }}" class="{{ ($activeMenu == 'inventory.finished-good.index') ? 'active' : '' }}"> <span>Goods List</span></a>
                                    </li>
                                @endif
                                @if(hasPermission( 'view-finished-goods-category','manage-finished-goods-category'))
                                    <li>
                                        <a href="{{ route('inventory.finished-good-category.index') }}" class="{{ ($activeMenu == 'inventory.finished-good-category.index') ? 'active' : '' }}"> <span>Category</span></a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    <li class="submenu">
                        <a href="javascript:void(0);" class="{{ ($activeMenu == 'inventory.boards.index') ? 'active' : '' }} noti-dot"><i class="la la-object-ungroup"></i> <span> Finished Boards</span> <span class="menu-arrow"></span></a>
                        <ul>
                            <li>
                                <a href="{{ route('inventory.boards.index') }}" class="{{ ($activeMenu == 'inventory.boards.index') ? 'active' : '' }}"> <span>Board List</span></a>
                            </li>
                        </ul>
                    </li>
                @endif

                {{-- production & pre production --}}
                @if(hasPermission('view-machines','manage-machines','view-pre-productions', 'manage-pre-productions','verify-pre-productions','view-production','manage-processes','receive-production-materials','dispatch-production-materials','view-board-pre-productions','manage-board-pre-productions','verify-board-pre-productions','view-board-production','receive-board-production-materials','dispatch-board-production-materials','production-board-print-barcode'))
                    <li class="menu-title">
                        <span>Pre-Production & Production</span>
                    </li>
                    @if(hasPermission('view-pre-productions', 'manage-pre-productions','verify-pre-productions','view-production','manage-processes','receive-production-materials','dispatch-production-materials'))
                        <li class="submenu">
                            <a href="javascript:void(0);" class="{{ ($activeMenu == 'production.pre-production.index' || $activeMenu == 'production.production.index') ? 'active' : '' }} noti-dot"><i class="la la-archive"></i> <span> Kitchen Production</span> <span class="menu-arrow"></span></a>
                            <ul>
                                @if(hasPermission('view-pre-productions','manage-pre-productions','verify-pre-productions'))
                                    <li>
                                        <a href="{{route('production.pre-production.index')}}" class="{{ ($activeMenu == 'production.pre-production.index') ? 'active' : '' }}"> <span>Pre Production</span></a>
                                    </li>
                                @endif
                                @if(hasPermission('view-production','manage-processes','receive-production-materials','dispatch-production-materials'))
                                    <li>
                                        <a href="{{route('production.production.index')}}" class="{{ ($activeMenu == 'production.production.index') ? 'active' : '' }}"><span>Production</span></a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if(hasPermission('view-board-pre-productions','manage-board-pre-productions','verify-board-pre-productions','view-board-production','receive-board-production-materials','dispatch-board-production-materials','production-board-print-barcode'))
                        <li class="submenu">
                            <a href="javascript:void(0);" class="{{ ($activeMenu == 'production.board-pre-production.index' || $activeMenu == 'production.board-production.index' || $activeMenu == 'production.board-production.pending-verification') ? 'active' : '' }} noti-dot"><i class="la la-server"></i> <span> Board Production</span> <span class="menu-arrow"></span></a>
                            <ul>
                                @if(hasPermission('view-board-pre-productions','manage-board-pre-productions'))
                                    <li>
                                        <a href="{{route('production.board-pre-production.index')}}" class="{{ ($activeMenu == 'production.board-pre-production.index') ? 'active' : '' }}"> <span>Pre Production</span></a>
                                    </li>
                                @endif
                                @if(hasPermission('verify-board-pre-productions'))
                                    <li>
                                        <a href="{{route('production.board-production.pending-verification')}}" class="{{ ($activeMenu == 'production.board-production.pending-verification') ? 'active' : '' }}"><span>Pending Verification</span></a>
                                    </li>
                                @endif
                                @if(hasPermission('view-board-production','receive-board-production-materials','dispatch-board-production-materials','production-board-print-barcode'))
                                    <li>
                                        <a href="{{route('production.board-production.index')}}" class="{{ ($activeMenu == 'production.board-production.index') ? 'active' : '' }}"><span>Production</span></a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if(hasPermission('view-machines','manage-machines'))
                        <li>
                            <a href="{{route('production.machine.index')}}" class="{{ ($activeMenu == 'production.machine.index') ? 'active' : '' }}"><i class="la la-fax"></i> <span>Machines</span></a>
                        </li>
                    @endif
                    @if(hasPermission('view-plate','manage-plate'))
                        <li>
                            <a href="{{ route('settings.board-embossed.index') }}" class="{{ ($activeMenu == 'settings.board-embossed.index') ? 'active' : '' }}"><i class="la la-crosshairs"></i> <span>Plate</span></a>
                        </li>
                    @endif
                    @if(hasPermission('view-production-staff','manage-production-staff'))
                        <li>
                            <a href="{{route('production.production-staff.index')}}" class="{{ ($activeMenu == 'production.production-staff.index') ? 'active' : '' }}"><i class="la la-fax"></i> <span>Production Staff</span></a>
                        </li>
                    @endif
                @endif

                @if(hasPermission( 'view-warehouse','manage-warehouse'))
                    <li class="menu-title">
                        <span>Warehouse</span>
                    </li>
                    @if(hasPermission( 'view-warehouse','manage-warehouse'))
                        <li>
                            <a href="{{ route('inventory.warehouse.index') }}" class="{{ ($activeMenu == 'inventory.warehouse.index' || $activeMenu == 'inventory.warehouse.create') ? 'active' : '' }}"><i class="la la-icons"></i> <span>Warehouse</span></a>
                        </li>
                    @endif
                @endif

                @if(hasPermission( 'view-chart-of-accounts','manage-chart-of-accounts','view-transactions','manage-transactions','add-expenses','verify-transactions'))
                    <li class="menu-title">
                        <span>Accounting</span>
                    </li>
                        @if(hasPermission( 'view-chart-of-accounts','manage-chart-of-accounts'))
                            <li>
                                <a href="{{ route('accounting.chart-of-accounts.index') }}" class="{{ ($activeMenu == 'accounting.chart-of-accounts.index') ? 'active' : '' }}"><i class="la la-git"></i> <span>Chart Of Account</span></a>
                            </li>
                        @endif
                    <li>
                        @if(hasPermission( 'view-transactions','manage-transactions','add-expenses','verify-transactions'))
                            <a href="{{ route('accounting.transaction.index') }}" class="{{ ($activeMenu == 'accounting.transaction.index') ? 'active' : '' }}"><i class="la la-houzz"></i> <span>Transaction</span></a>
                        @endif
                    </li>
                @endif

                @if(hasPermission( 'manage-administration-settings', 'manage-payroll-settings', 'manage-tax-settings', 'manage-role-permission-settings'))
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
