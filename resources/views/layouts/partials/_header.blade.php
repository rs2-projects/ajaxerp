<div class="header">

    <!-- Logo -->
    <div class="header-left">
        <a href="{{ route('dashboard') }}" class="logo">
            <img src="{{ asset('assets') }}/img/logo.webp" >
        </a>
        <a href="{{ route('dashboard') }}" class="logo2">
            <img src="{{ asset('assets') }}/img/logo.webp" class="sidebar-expanded" alt="Logo">
            <img src="{{ asset('assets') }}/img/logo-mini.png" class="sidebar-expanded-false" alt="Logo">
        </a>
    </div>
    <!-- /Logo -->

    <a id="toggle_btn" href="javascript:void(0);">
					<span class="bar-icon">
						<span></span>
						<span></span>
						<span></span>
					</span>
    </a>

    <!-- Header Title -->
    <div class="page-title-box">
        @if(session()->has('is_admin_access') && (session()->get('is_admin_access') === true) && (session()->get('admin_user_id') != ''))
            <div class="back-to-admin-btn">
                <a href="{{ route('hr.employee.login.back-to-admin') }}"><i class="fa fa-arrow-left"></i> Back To Your Account</a>
            </div>
        @else
            <h3>{{ config('app.name') }}</h3>
        @endif
    </div>
    <!-- /Header Title -->

    <a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa-solid fa-bars"></i></a>

    <!-- Header Menu -->
    <ul class="nav user-menu">

        <!-- Search -->
        {{-- <li class="nav-item">
            <div class="top-nav-search">
                <a href="javascript:void(0);" class="responsive-search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </a>
                <div class="search-box position-relative">
                    <input class="form-control" type="text" placeholder="Search here">
                    <button class="btn position-absolute search-btn" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </div>
        </li> --}}
        <!-- /Search -->
        <!-- Dark Switcher Start -->
        <li class="nav-item">
            <!-- Start::header-element -->
            <div class="header-element header-theme-mode">
                <!-- Start::header-link|layout-setting -->
                <a aria-label="anchor" href="javascript:void(0);" class="header-link layout-setting theme-change-btn d-none">
								<span class="light-layout">
									<!-- Start::header-link-icon -->
								<i class="la la-moon header-link-icon"></i>
                                    <!-- End::header-link-icon -->
								</span>
                    <span class="dark-layout">
									<!-- Start::header-link-icon -->
								<i class="la la-sun header-link-icon"></i>
                        <!-- End::header-link-icon -->
								</span>
                </a>
                <!-- End::header-link|layout-setting -->
            </div>
            <!-- End::header-element -->
        </li>
        <!-- Dark Switcher End -->
        <!-- Notifications -->
        @php($newerPickedItems = \App\Helpers\NewerPickedProductPurchase::getNewerPickedProduct())
        <li class="nav-item dropdown">
            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                <i class="fa-regular fa-bell"></i> 
                @if(count($newerPickedItems) > 0)
                    <span class="badge rounded-pill">{{ (count($newerPickedItems) > 5) ? '5+':count($newerPickedItems) }}</span>
                @endif
            </a>
            <div class="dropdown-menu notifications">
                <div class="topnav-dropdown-header">
                    <span class="notification-title">Newer Picked Items</span>
                    {{-- <a href="javascript:void(0)" class="clear-noti"> Clear All </a> --}}
                </div>
                <div class="noti-content">
                    <ul class="notification-list">
                        @foreach ($newerPickedItems as $newerPickedItem)
                            <li class="notification-message">
                                <a href="activities.html">
                                    <div class="chat-block d-flex">
                                        <span class="avatar flex-shrink-0">
                                            <img src="{{ asset('assets') }}/img/profiles/avatar-02.jpg" alt="User Image">
                                        </span>
                                        <div class="media-body flex-grow-1">
                                            <p class="noti-details">
                                                <span class="noti-title">{{ $newerPickedItem->user->full_name }}</span> 
                                                has picked newer item 
                                                <span class="noti-title">({{ $newerPickedItem->productMaterial->name }})</span>
                                                from 
                                                <span class="noti-title">#{{ $newerPickedItem->productMaterialPurchaseDetails->materialPurchase->purchase_id }}</span>
                                            </p>
                                            <p class="noti-time"><span class="notification-time">{{ Carbon\Carbon::parse($newerPickedItem->picked_at)->diffForHumans() }}</span></p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="topnav-dropdown-footer">
                    <a href="{{ route('inventory.material-request.newer-picked-materials') }}">View all Notifications</a>
                </div>
            </div>
        </li>
        <!-- /Notifications -->

        <!-- Message Notifications -->
        {{-- <li class="nav-item dropdown">
            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                <i class="fa-regular fa-comment"></i> <span class="badge rounded-pill">8</span>
            </a>
            <div class="dropdown-menu notifications">
                <div class="topnav-dropdown-header">
                    <span class="notification-title">Messages</span>
                    <a href="javascript:void(0)" class="clear-noti"> Clear All </a>
                </div>
                <div class="noti-content">
                    <ul class="notification-list">
                        <li class="notification-message">
                            <a href="chat.html">
                                <div class="list-item">
                                    <div class="list-left">
													<span class="avatar">
														<img src="{{ asset('assets') }}/img/profiles/avatar-09.jpg" alt="User Image">
													</span>
                                    </div>
                                    <div class="list-body">
                                        <span class="message-author">Richard Miles </span>
                                        <span class="message-time">12:28 AM</span>
                                        <div class="clearfix"></div>
                                        <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="notification-message">
                            <a href="chat.html">
                                <div class="list-item">
                                    <div class="list-left">
													<span class="avatar">
														<img src="{{ asset('assets') }}/img/profiles/avatar-02.jpg" alt="User Image">
													</span>
                                    </div>
                                    <div class="list-body">
                                        <span class="message-author">John Doe</span>
                                        <span class="message-time">6 Mar</span>
                                        <div class="clearfix"></div>
                                        <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="notification-message">
                            <a href="chat.html">
                                <div class="list-item">
                                    <div class="list-left">
													<span class="avatar">
														<img src="{{ asset('assets') }}/img/profiles/avatar-03.jpg" alt="User Image">
													</span>
                                    </div>
                                    <div class="list-body">
                                        <span class="message-author"> Tarah Shropshire </span>
                                        <span class="message-time">5 Mar</span>
                                        <div class="clearfix"></div>
                                        <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="notification-message">
                            <a href="chat.html">
                                <div class="list-item">
                                    <div class="list-left">
													<span class="avatar">
														<img src="{{ asset('assets') }}/img/profiles/avatar-05.jpg" alt="User Image">
													</span>
                                    </div>
                                    <div class="list-body">
                                        <span class="message-author">Mike Litorus</span>
                                        <span class="message-time">3 Mar</span>
                                        <div class="clearfix"></div>
                                        <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="notification-message">
                            <a href="chat.html">
                                <div class="list-item">
                                    <div class="list-left">
													<span class="avatar">
														<img src="{{ asset('assets') }}/img/profiles/avatar-08.jpg" alt="User Image">
													</span>
                                    </div>
                                    <div class="list-body">
                                        <span class="message-author"> Catherine Manseau </span>
                                        <span class="message-time">27 Feb</span>
                                        <div class="clearfix"></div>
                                        <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="topnav-dropdown-footer">
                    <a href="chat.html">View all Messages</a>
                </div>
            </div>
        </li> --}}
        <!-- /Message Notifications -->

        <li class="nav-item dropdown has-arrow main-drop">
            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
							<span class="user-img"><img src="{{ auth()->user()->show_image }}" alt="User Image">
							<span class="status online"></span></span>
                <span class="ms-2"> {{ auth()->user()->full_name }} </span>
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">My Profile</a>
                @if(hasPermission( 'manage-administration-settings', 'manage-payroll-settings', 'manage-tax-settings', 'manage-role-permission-settings'))
                    <a class="dropdown-item" href="{{ route('settings.office-time') }}">Settings</a>
                @endif
                <a class="dropdown-item" href="{{route('logout')}}">Logout</a>
            </div>
        </li>
    </ul>
    <!-- /Header Menu -->

    <!-- Mobile Menu -->
    <div class="dropdown mobile-user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-ellipsis-vertical"></i></a>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="profile.html">My Profile</a>
            <a class="dropdown-item" href="settings.html">Settings</a>
            <a class="dropdown-item" href="index.html">Logout</a>
        </div>
    </div>
    <!-- /Mobile Menu -->

</div>
