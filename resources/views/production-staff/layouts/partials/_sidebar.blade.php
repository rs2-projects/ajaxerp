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
                
                <li>
                    <a href="{{route('production.production.index')}}" class="{{ ($activeMenu == 'production.production.index') ? 'active' : '' }}"><i class="la la-archive"></i> <span>Production</span></a>
                </li>
                
            </ul>
        </div>
    </div>
</div>
