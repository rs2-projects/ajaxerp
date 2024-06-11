@extends('auth.layouts.layout')
@section('content')
    <div class="account-content">

        <div class="container">

            <!-- Account Logo -->
            <div class="account-logo">
                <a href="#"><img src="{{ asset('assets') }}/img/logo2.png" alt="{{ config('app.name') }}"></a>
            </div>
            <!-- /Account Logo -->

            <div class="account-box">
                <div class="account-wrapper">
                    <h3 class="account-title">Reset Password</h3>
                    <p class="account-subtitle">Reset your password.</p>

                    <!-- Forgot Password Form -->
                    <form action="{{ route('reset-password') }}" id="loginForm">
                        @csrf
                        <input type="hidden" name="email" value="{{ request()->email }}">
                        <input type="hidden" name="token" value="{{ request()->token }}">
                        <div class="input-block mb-4">
                            <div class="row align-items-center">
                                <div class="col">
                                    <label class="col-form-label">Password</label>
                                </div>
                            </div>
                            <div class="position-relative">
                                <input class="form-control" type="password" name="password" value="" id="password" required>
                                <span class="fa-solid fa-eye-slash" id="toggle-password"></span>
                            </div>
                            <span class="password_error ie-span"></span>
                        </div>
                        <div class="input-block mb-4 text-center">
                            <button class="btn btn-primary account-btn" type="submit">Reset Password</button>
                        </div>

                        <div class="input-block mb-4 text-center">
                            <a href="{{ route('login') }}"> <i class="fa fa-arrow-left"></i> Remember Password? Back to login</a>
                        </div>

                    </form>
                    <!-- /Forgot Password Form -->

                </div>
            </div>
        </div>
    </div>
@endsection

@section('js_plugins')

@endsection
@section('js')
    <script>
        $(document).ready(function(){
            $("#loginForm").on('submit', function (e) {
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                $(".ie-span").text("").hide();
                var url = $(this).attr('action');
                formPost(url,formData,'redirect', function (xhr) {
                    if(xhr.status == 422){
                        $.each(xhr.responseJSON.errors, function(key, value){
                            $("."+key+"_error").text(value).show();
                            toastr.error(value);
                        });
                    }else{
                        toastr.error(xhr.message);
                    }
                });
            });
        });
    </script>
@endsection
