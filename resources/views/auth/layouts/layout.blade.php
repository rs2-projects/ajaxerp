<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">
@include('auth.layouts._head')

<body class="account-page">

<!-- Main Wrapper -->
<div class="main-wrapper">
    @yield('content')
</div>
<!-- /Main Wrapper -->

@include('auth.layouts._scripts')
</body>
</html>
