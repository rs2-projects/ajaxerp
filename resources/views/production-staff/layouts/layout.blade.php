<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none" data-layout-mode="light" data-layout-width="fluid" data-layout-position="fixed" data-layout-style="default">
@include('production-staff.layouts.partials._head')
<body>
<!-- Main Wrapper -->
<div class="main-wrapper">

    <!-- Header -->
    @include('production-staff.layouts.partials._header')
    <!-- /Header -->

    <!-- Sidebar -->
    @include('production-staff.layouts.partials._sidebar')
    <!-- /Sidebar -->

    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid bg-white">

            <!-- PAGE-HEADER -->
            @include('production-staff.layouts.partials._page_header')
            <!-- PAGE-HEADER END -->

            <!-- Start::row-1 -->
            @yield('content')
            <!--End::row-1 -->
        </div>
        <!-- /Page Content -->

    </div>
    <!-- /Page Wrapper -->

</div>
<!-- /Main Wrapper -->

@yield('modals')


@include('production-staff.layouts.partials._scripts')

</body>
</html>
