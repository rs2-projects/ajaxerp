@extends('auth.layouts.layout')
@section('content')
    <div class="account-content">

        <div class="container">

            <!-- Account Logo -->
            <div class="account-logo">
                <a href="#"><img src="{{ asset('assets') }}/img/logo2.png" alt="Dreamguy's Technologies"></a>
            </div>
            <!-- /Account Logo -->

            <div class="account-box">
                <div class="account-wrapper">
                    <h3 class="account-title">Login</h3>
                    <p class="account-subtitle">Access to your dashboard</p>

                    <!-- Account Form -->
                    <form action="#">
                        <div class="input-block mb-4">
                            <label class="col-form-label">Email Address</label>
                            <input class="form-control" type="text" value="admin@dreamguystech.com">
                        </div>
                        <div class="input-block mb-4">
                            <div class="row align-items-center">
                                <div class="col">
                                    <label class="col-form-label">Password</label>
                                </div>
                                <div class="col-auto">
                                    <a class="text-muted" href="#">
                                        Forgot password?
                                    </a>
                                </div>
                            </div>
                            <div class="position-relative">
                                <input class="form-control" type="password" value="123456" id="password">
                                <span class="fa-solid fa-eye-slash" id="toggle-password"></span>
                            </div>
                        </div>
                        <div class="input-block mb-4 text-center">
                            <button class="btn btn-primary account-btn" type="submit">Login</button>
                        </div>

                    </form>
                    <!-- /Account Form -->

                </div>
            </div>
        </div>
    </div>
@endsection
