<!-- jQuery -->
<script src="{{ asset('assets') }}/js/jquery-3.7.0.min.js"></script>

<!-- Bootstrap Core JS -->
<script src="{{ asset('assets') }}/js/bootstrap.bundle.min.js"></script>

@yield('js_plugins')
<!-- Custom JS -->
<script src="{{ asset('assets') }}/js/toastr.min.js"></script>
<script src="{{ asset('assets') }}/js/alert.js"></script>
<script src="{{ asset('assets') }}/js/sweetalert2@11.js"></script>
<script src="{{ asset('assets') }}/js/app.js"></script>
<script src="{{ asset('assets') }}/js/ajax-request.js"></script>
<script>
    $(document).ready(function () {
        setTimeout(function () {
            @if (session('error'))
            toastr.error('{{Session::get("error")}}', 'Error!');
            @endif
            @if (session('info'))
            toastr.error('{{Session::get("info")}}', 'Info!');
            @endif
            @if (session('failed'))
            toastr.error('{{Session::get("failed")}}', 'Error!');
            @endif
            @if (session('success'))
            toastr.success('{{Session::get("success")}}', 'Success');
            @endif
        }, 300);
    });
</script>
@yield('js')
