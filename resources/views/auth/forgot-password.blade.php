@extends('auth.layouts.layout')
@section('content')
    <div class="account-content">

        <div class="container">

            <!-- Account Logo -->
            <div class="account-logo">
                <a href="#"><img src="{{ asset('assets') }}/img/logo.webp" alt="{{ config('app.name') }}"></a>
            </div>
            <!-- /Account Logo -->

            <div class="account-box">
                <div class="account-wrapper">
                    <h3 class="account-title">Forgot Your Password?</h3>
                    <p class="account-subtitle">Enter your email to reset your password</p>

                    <!-- Forgot Password Form -->
                    <form action="{{ route('forgot-password') }}" id="loginForm">
                        @csrf
                        <div class="input-block mb-4">
                            <label class="col-form-label">Email</label>
                            <input class="form-control" type="text" name="email" value="{{ old('email') }}" required>
                            <span class="email_error ie-span"></span>
                        </div>
                        <div class="input-block mb-4 text-center">
                            <button class="btn btn-primary account-btn" type="submit">Reset</button>
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
