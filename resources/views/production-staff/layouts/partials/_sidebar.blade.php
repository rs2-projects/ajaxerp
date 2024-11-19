<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">

            <ul class="sidebar-vertical">
                <li class="menu-title">
                    <span>Production</span>
                </li>

                {{-- <li>
                    <a href="{{ route('production-staff.dashboard') }}" class="{{ ($activeMenu == 'production-staff.dashboard')?'active':'' }}"><i class="la la-dashboard"></i> <span>Dashboard</span></a>
                </li> --}}
                
                <li>
                    <a href="{{route('production-staff.production.production.index')}}" class="{{ ($activeMenu == 'production-staff.production.production.index') ? 'active' : '' }}"><i class="la la-archive"></i> <span>Production</span></a>
                </li>
                <li>
                    <a href="{{route('production-staff.requisition.index')}}" class="{{ ($activeMenu == 'production-staff.requisition.index') ? 'active' : '' }}"><i class="la la-archive"></i> <span>Requisition</span></a>
                </li>
                
            </ul>
        </div>
    </div>
</div>
