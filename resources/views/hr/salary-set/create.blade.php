@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">

        <div class="erp-employee-list-wrapper">
            <form action="{{ route('hr.employee.store') }}" method="post" id="employeeStoreForm">
                @csrf
                <div class="erp-main-filter-wrapper d-flex justify-content-center ">
                    <div class="erp-add-em-step-wrapper bg-card flex-100">
                        <div class="erp-step-content-wrapper">
                            <div id="reg-employee">
                                <h3 class="d-none">Salary Set</h3>
                                <section class="erp-em-general-info">
                                    <div class="erp-em-reg-step-wrapper d-flex flex-wrap">

                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Name: <span class="text-red">*</span></label>
                                                <input class="form-control" name="name" required type="text" placeholder="Name">
                                                <span class="name_error ie-span"></span>
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Description: <span class="text-red">*</span></label>
                                                <textarea  class="form-control" name="description" cols="1" rows="1"></textarea>
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Salary Type: <span class="text-danger">*</span></label>
                                                <select class="select no-search-select-step" name="settings_salary_type_id" required>
                                                    <option value="">--Select An Option--</option>
                                                    @foreach($settingsSalaryTypes as $settingsSalaryType)
                                                        <option value="{{ $settingsSalaryType->id }}">{{ $settingsSalaryType->title }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="settings_salary_type_id_error ie-span"></span>
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Over Time: <span class="text-danger">*</span></label>
                                                <select class="select no-search-select-step" name="settings_overtime_type_id" required>
                                                    <option value="">--Select An Option--</option>
                                                    @foreach($settingsOverTimeTypes as $settingsOverTimeType)
                                                        <option value="{{ $settingsOverTimeType->id }}">{{ $settingsOverTimeType->title }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="settings_overtime_type_id_error ie-span"></span>
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Absent Penalty: <span class="text-danger">*</span></label>
                                                <select class="select no-search-select-step" name="settings_absent_penalty_id" required>
                                                    <option value="">--Select An Option--</option>
                                                    @foreach($settingsAbsentPenalties as $settingsAbsentPenalty)
                                                        <option value="{{ $settingsAbsentPenalty->id }}">{{ $settingsAbsentPenalty->title }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="settings_absent_penalty_id_error ie-span"></span>
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Late Penalty: <span class="text-danger">*</span></label>
                                                <select class="select no-search-select-step" name="settings_late_penalty_id" required>
                                                    <option value="">--Select An Option--</option>
                                                    @foreach($settingsLatePenalties as $settingsLatePenalty)
                                                        <option value="{{ $settingsLatePenalty->id }}">{{ $settingsLatePenalty->title }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="settings_late_penalty_id_error ie-span"></span>
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Office Time : <span class="text-danger">*</span></label>
                                                <select class="select no-search-select-step" name="settings_office_time_type_id" required>
                                                    <option value="">--Select An Option--</option>
                                                    @foreach($settingsOfficeTimeTypes as $settingsOfficeTimeType)
                                                        <option value="{{ $settingsOfficeTimeType->id }}">{{ $settingsOfficeTimeType->name }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="settings_office_time_type_id_error ie-span"></span>
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Salary Type : <span class="text-danger">*</span></label>
                                                <select class="select no-search-select-step" name="salary_generate_type" required>
                                                    <option value="">--Select An Option--</option>
                                                    <option value="1">Half Month</option>
                                                    <option value="2">Full Month</option>
                                                </select>
                                                <span class="salary_generate_type_error ie-span"></span>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                                <h3 class="d-none">Attendance Set</h3>
                                <section class="erp-step-attendance-wrapper">
                                    <div class="erp-em-reg-step-wrapper d-flex flex-wrap">

                                        <div class="erp-em-reg-step-item flex-20">
                                            <div class="input-block erp-step-input-block ">
                                                <div class="checkbox">
                                                    <label class="col-form-label"><input type="checkbox" value="1" name="attendance_type_fingerprint_device" class="me-1"> Finger Print Device  </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-40">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">
                                                    <input type="radio" name="attendance_type_location" onclick="locationType(this)" value="1">
                                                    In Geo
                                                </label>

                                                <label class="col-form-label">
                                                    <input type="radio" name="attendance_type_location" onclick="locationType(this)" value="2">
                                                    Any Location
                                                </label>
                                            </div>
                                        </div>

                                        <div class="erp-em-reg-step-item flex-100 location-hide-show" style="display: none">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Location: <span class="text-danger">*</span></label>
                                                <select class="select select-step" multiple name="settings_geo_location_id" id="settings_geo_location_id">
                                                    <option value="all">All</option>
                                                    @foreach($settingsGeoLocations as $settingsGeoLocation)
                                                        <option value="{{ $settingsGeoLocation->id }}">{{ $settingsGeoLocation->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                                <h3 class="d-none">Leave Types Set</h3>
                                <section class="erp-step-bank-info-wrapper">
                                    <div class="erp-em-reg-step-wrapper d-flex flex-wrap">
                                        <div class="erp-em-reg-step-item flex-100 location-hide-show">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Leave Types: <span class="text-danger">*</span></label>
                                                <select class="select select-step" multiple name="settings_leave_type_id" id="settings_leave_type_id" required>
                                                    <option value="all">All</option>
                                                    @foreach($settingsLeaveTypes as $settingsLeaveType)
                                                        <option value="{{ $settingsLeaveType->id }}">{{ $settingsLeaveType->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                                <h3 class="d-none">Employee Set</h3>
                                <section class="erp-step-salary-wrapper">
                                    <div class="table-main-wrapper pt-4" >
                                        <div class="table-header-wrapper d-flex flex-wrap">
                                            <div class="table-header-item em-list">
                                                <h4>SL</h4>
                                            </div>
                                            <div class="table-header-item em-list text-start">
                                                <h4>Name</h4>
                                            </div>
                                            <div class="table-header-item em-list text-center">
                                                <h4>Email/Phone</h4>
                                            </div>
                                            <div class="table-header-item em-list text-center">
                                                <h4>Department/Designation</h4>
                                            </div>
                                            <div class="table-header-item em-list text-center">
                                                <h4>Basic Salary</h4>
                                            </div>
                                        </div>
                                        <div class="table-body-wrapper">
                                                <div class="table-body-item-wrapper d-flex flex-wrap">
                                                    <div class="table-body-item em-list">
                                                        <h4>1</h4>
                                                    </div>
                                                    <div class="table-body-item em-list ">
                                                        <a href="#" class="em-profile-wrap d-flex align-items-center flex-wrap w-100">
                                                            <div class="em-pro-img-box">
                                                                <img src="" alt="">
                                                            </div>
                                                            <div class="em-pro-details-box">
                                                                <h5>Kawsar</h5>
                                                                <p class="em-id">ID: <span> #1000</span></p>

                                                            </div>
                                                        </a>
                                                    </div>

                                                    <div class="table-body-item em-list ">
                                                        <h4 class="text-center erp-t-email">kawsar4585@gmail.com</h4>
                                                        <h4 class="text-center erp-t-email">01714234585</h4>
                                                    </div>
                                                    <div class="table-body-item em-list ">
                                                        <h4 class="text-center erp-t-phone">Department</h4>
                                                        <h4 class="text-center erp-t-phone">Designation</h4>
                                                    </div>
                                                    <div class="table-body-item em-list ">
                                                        <h4 class="text-center erp-t-department">105000</h4>
                                                    </div>
                                                </div>

                                        </div>
                                    </div>
                                    <div class="erp-em-edu-step-add-wrapper text-center mt-3">
                                        <a href="javascript:void(0);" onclick="addEducation()" class="btn erp-add-btn "><i class="fa-solid fa-plus"></i> Add Education</a>
                                    </div>

                                </section>


                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>


    </div>

@endsection

@section('modals')

@endsection

@section('css')

@endsection

@section('css_plugins')
    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}">
@endsection

@section('js_plugins')
    <script src="{{ asset('assets/plugins/jquery-steps/jquery.steps.min.js') }}"></script>
    <!-- Datetimepicker JS -->
    <script src="{{asset('assets/js/moment.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap-datetimepicker.min.js')}}"></script>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            initializeDatepicker();
            initializeSelect()
        });

        function initializeDatepicker() {
            $('.datetimepicker').datetimepicker({
                //format: 'DD/MM/YYYY',
                format: 'YYYY-MM-DD',
                icons: {
                    up: "fa fa-angle-up",
                    down: "fa-solid fa-angle-down",
                    next: 'fa-solid fa-angle-right',
                    previous: 'fa-solid fa-angle-left'
                }
            });
        }

        function initializeSelect() {
            $('#addEducationWrapMain .select2').select2({
                minimumResultsForSearch: -1,
                width: '100%'
            });
        }

        function locationType(e) {
            if (e.value == 1){
                $('.location-hide-show').slideDown();
            }else{
                $('.location-hide-show').slideUp();
            }
        }

    </script>
    <script>
        (function($) {
            "use strict";

            // WIZARD 1
            $('#reg-employee').steps({
                headerTag: 'h3',
                bodyTag: 'section',
                autoFocus: true,
                titleTemplate: '<span class="number">#index#<\/span> <span class="title">#title#<\/span>',
                labels: {
                    current: "current step:",
                    pagination: "Pagination",
                    finish: "Submit",
                    next: "Next",
                    previous: "Previous",
                    loading: "Loading ..."
                },
                onStepChanging: function(event, currentIndex, newIndex) {
                    if (currentIndex < newIndex) {
                        // Step 1 form validation
                        if (currentIndex === 0) {
                            let form_valid = true;

                            let name = $('input[name="name"]').val();
                            let settings_salary_type_id = $('select[name="settings_salary_type_id"]').val();
                            let settings_overtime_type_id = $('select[name="settings_overtime_type_id"]').val();
                            let settings_absent_penalty_id = $('select[name="settings_absent_penalty_id"]').val();
                            let settings_late_penalty_id = $('select[name="settings_late_penalty_id"]').val();
                            let settings_office_time_type_id = $('select[name="settings_office_time_type_id"]').val();
                            let salary_generate_type = $('select[name="salary_generate_type"]').val();


                            // if (!name) {
                            //     $("input[name='name']").addClass("is-invalid");
                            //     $('.name_error').html('name is required').show();
                            //     form_valid = false;
                            // } else {
                            //     $("input[name='name']").removeClass("is-invalid");
                            //     $('.name_error').hide();
                            // }
                            //
                            // if (!settings_salary_type_id){
                            //     $("select[name='settings_salary_type_id']").addClass("is-invalid");
                            //     $('.settings_salary_type_id_error').html('salary type is required').show();
                            //     form_valid = false;
                            // }else {
                            //     $("select[name='settings_salary_type_id']").removeClass("is-invalid");
                            //     $('.settings_salary_type_id_error').hide();
                            // }
                            // if (!settings_overtime_type_id){
                            //     $("select[name='settings_overtime_type_id']").addClass("is-invalid");
                            //     $('.settings_overtime_type_id_error').html('overtime type is required').show();
                            //     form_valid = false;
                            // }else {
                            //     $("select[name='settings_overtime_type_id']").removeClass("is-invalid");
                            //     $('.settings_overtime_type_id_error').hide();
                            // }
                            //
                            // if (!settings_absent_penalty_id){
                            //     $("select[name='settings_absent_penalty_id']").addClass("is-invalid");
                            //     $('.settings_absent_penalty_id_error').html('absent penalty is required').show();
                            //     form_valid = false;
                            // }else {
                            //     $("select[name='settings_absent_penalty_id']").removeClass("is-invalid");
                            //     $('.settings_absent_penalty_id_error').hide();
                            // }
                            //
                            // if (!settings_late_penalty_id){
                            //     $("select[name='settings_late_penalty_id']").addClass("is-invalid");
                            //     $('.settings_late_penalty_id_error').html('late penalty is required').show();
                            //     form_valid = false;
                            // }else{
                            //     $("select[name='settings_late_penalty_id']").removeClass("is-invalid");
                            //     $('.settings_late_penalty_id_error').hide();
                            // }
                            //
                            // if (!settings_office_time_type_id){
                            //     $("select[name='settings_office_time_type_id']").addClass("is-invalid");
                            //     $('.settings_office_time_type_id_error').html('office time is required').show();
                            //     form_valid = false;
                            // }else {
                            //     $("select[name='settings_office_time_type_id']").removeClass("is-invalid");
                            //     $('.settings_office_time_type_id_error').hide();
                            // }
                            //
                            // if (!salary_generate_type){
                            //     $("select[name='salary_generate_type']").addClass("is-invalid");
                            //     $('.salary_generate_type_error').html('salary generate type is required').show();
                            //     form_valid = false;
                            // }else {
                            //     $("select[name='salary_generate_type']").removeClass("is-invalid");
                            //     $('.salary_generate_type_error').hide();
                            // }


                            return form_valid;
                        }
                        // Step 2 form validation
                        if (currentIndex === 1) {
                            return true;
                        }

                        return true;
                        // Always allow step back to the previous step even if the current step is not valid.
                    } else {
                        return true;
                    }
                },
                onFinished: function (event, currentIndex) {

                    event.preventDefault();
                    var formData = new FormData($('#employeeStoreForm')[0]);
                    $(".ie-span").text("").hide();
                    var url = $('#employeeStoreForm').attr('action');

                    formPost(url, formData, function (res){
                        if(res.status == 200){
                            showSuccessAlert('Success',res.message)
                            window.location.href = "{{ route('hr.employee') }}";
                        }else{
                            showErrorAlert('Error',res.message)
                        }
                    }, 'show_input_error');
                }
            });


        })(jQuery);
        $(document).ready(function () {

            $(".select-step").select2({
                closeOnSelect: true,
                containerCssClass: "select2-step-container",
                dropdownCssClass: "select2-step-dropdown",
                width: '100%'

            });
            $(".no-search-select-step").select2({
                closeOnSelect: true,
                containerCssClass: "select2-step-container",
                dropdownCssClass: "select2-step-dropdown",
                minimumResultsForSearch: -1,
                width: '100%'

            });
            $("#add-emergency-contact").click(function(){
                // Toggle the visibility of the div
                $("#erp-emergency-contact-main-wrap").toggle();
            });

            $('.erp-add-btn').click(function () {
                $('.add-eme-contact-box').slideToggle('slow');
            });

        });

        function validateEmail(email) {
            return String(email)
                .toLowerCase()
                .match(
                    /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                );
        }

    </script>
@endsection


