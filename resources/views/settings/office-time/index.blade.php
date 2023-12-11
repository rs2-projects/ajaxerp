@extends('layouts.settings-layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">

        <div class="erp-employee-list-wrapper">
            <div class="erp-main-filter-wrapper d-flex justify-content-center ">
                <div class="erp-notice-board-wrapper flex-50 bg-card">

                    <div class="erp-em-reg-step-wrapper d-flex flex-wrap mt-3">

                        <div class="erp-group-input flex-100 d-flex justify-content-between flex-wrap">
                            <h4 class="group-input-title flex-100">Office Time</h4>
                            <div class="erp-em-reg-step-item flex-48">
                                <div class="input-block erp-step-input-block ">
                                    <label class="col-form-label">Start Time <span class="text-red">*</span></label>
                                    <input class="form-control " type="Time" value="09:15:00">
                                </div>
                            </div>
                            <div class="erp-em-reg-step-item flex-48">
                                <div class="input-block erp-step-input-block ">
                                    <label class="col-form-label">End Time <span class="text-red">*</span></label>
                                    <input class="form-control " type="Time" value="06:00:00">
                                </div>
                            </div>
                        </div>
                        <div class="erp-group-input flex-100 d-flex justify-content-between flex-wrap mt-3">
                            <h4 class="group-input-title flex-100">Break Time</h4>

                            <div class="erp-em-reg-step-item flex-48">
                                <div class="input-block erp-step-input-block ">
                                    <label class="col-form-label"> Start Time<span class="text-red">*</span></label>
                                    <input class="form-control " type="Time" value="01:00:00">
                                </div>
                            </div>
                            <div class="erp-em-reg-step-item flex-48">
                                <div class="input-block erp-step-input-block ">
                                    <label class="col-form-label">End Time<span class="text-red">*</span></label>
                                    <input class="form-control " type="Time" value="02:00:00">
                                </div>
                            </div>
                        </div>

                        <div class="erp-group-input flex-100 d-flex justify-content-between flex-wrap mt-3">
                            <h4 class="group-input-title flex-100">Full / Half Day</h4>

                            <div class="erp-em-reg-step-item flex-48">
                                <div class="input-block erp-step-input-block ">
                                    <label class="col-form-label">Full Day Minimum (hours)<span class="text-red">*</span></label>
                                    <input class="form-control " type="text" value="7">
                                </div>
                            </div>
                            <div class="erp-em-reg-step-item flex-48">
                                <div class="input-block erp-step-input-block ">
                                    <label class="col-form-label">Half Day Minimum (hours)<span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="per month"><i class="fa-duotone fa-exclamation"></i></span></label>
                                    <input class="form-control " type="text" value="5">
                                </div>
                            </div>
                        </div>




                        <div class="erp-em-reg-step-item flex-100">
                            <div class="submit-section mt-2">
                                <button class="btn btn-primary submit-btn">Save</button>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

        </div>

    </div>
    <!--End::row-1 -->
@endsection

@section('modals')
@endsection

@section('css')

@endsection

@section('css_plugins')
@endsection

@section('js_plugins')
@endsection

@section('js')
@endsection


