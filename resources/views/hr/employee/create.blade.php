@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">

        <div class="erp-employee-list-wrapper">
            <form action="{{ route('hr.employee.store') }}" method="post" id="employeeStoreForm">
                @csrf
                <div class="erp-main-filter-wrapper d-flex justify-content-center ">
                    <div class="erp-add-em-step-wrapper bg-card flex-80">
                        <div class="erp-step-content-wrapper">
                            <div id="reg-employee">
                                <h3 class="d-none">General</h3>
                                <section class="erp-em-general-info">
                                    <div class="erp-em-reg-step-wrapper d-flex flex-wrap">

                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">First Name: <span class="text-red">*</span></label>
                                                <input class="form-control" name="first_name" required type="text" placeholder="First Name">
                                                <span class="first_name_error ie-span"></span>
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Last Name: <span class="text-red">*</span></label>
                                                <input class="form-control " name="last_name" required type="text" placeholder="First Name">
                                                <span class="last_name_error ie-span"></span>
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label" for="emailAddress">Email Address <span class="text-red">*</span></label>
                                                <input type="email" class="form-control is-invalid" name="email" id="emailAddress" placeholder="Enter email address" required="">
                                                {{--<div class="invalid-feedback emailAddress-error">Please provide a valid email.</div>--}}
                                                <span class="email_error ie-span"></span>
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label for="validationServer01" class="col-form-label">Phone Number <span class="text-red">*</span></label>
                                                <input type="tel" name="phone" class="form-control is-valid" id="validationServer01" placeholder="Enter phone number"  required="">
                                                <span class="phone_error ie-span"></span>
                                                {{--<div class="valid-feedback">Looks good!</div>--}}
                                            </div>
                                        </div>

                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Joining Date <span class="text-red">*</span></label>
                                                <div class="cal-icon"><input class="form-control datetimepicker" type="text" ></div>
                                            </div>
                                        </div>

                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Department <span class="text-danger">*</span></label>
                                                <select class="select select-step" name="department_id" id="department_id">
                                                    <option value="">Select Department</option>
                                                    <option>Web Development</option>
                                                    <option>IT Management</option>
                                                    <option>Marketing</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Designation <span class="text-danger">*</span></label>
                                                <select class="select select-step">
                                                    <option>Select Designation</option>
                                                    <option>Web Designer</option>
                                                    <option>Web Developer</option>
                                                    <option>Android Developer</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Password</label>
                                                <input class="form-control " type="password" required>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                                <h3 class="d-none">Personal</h3>
                                <section class="erp-setep-personal-wrapper">
                                    <div class="erp-em-reg-step-wrapper d-flex flex-wrap">
                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">NID No. </label>
                                                <input class="form-control " type="text" >
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Upload NID: </label>
                                                <input class="form-control " type="file" >
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-group-item flex-100 d-flex justify-content-center flex-wrap">
                                            <div class="erp-em-reg-step-item flex-31">
                                                <div class="input-block erp-step-input-block ">
                                                    <label class="col-form-label">Passport No. </label>
                                                    <input class="form-control " type="text" >
                                                </div>
                                            </div>
                                            <div class="erp-em-reg-step-item flex-31">
                                                <div class="input-block erp-step-input-block ">
                                                    <label class="col-form-label">Expire Date: </label>
                                                    <div class="cal-icon"><input class="form-control datetimepicker" type="text" ></div>
                                                </div>
                                            </div>
                                            <div class="erp-em-reg-step-item flex-31">
                                                <div class="input-block erp-step-input-block ">
                                                    <label class="col-form-label">Upload Passport: </label>
                                                    <input class="form-control " type="file" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-group-item flex-100 d-flex justify-content-center flex-wrap">
                                            <div class="erp-em-reg-step-item flex-31">
                                                <div class="input-block erp-step-input-block ">
                                                    <label class="col-form-label">Date Of Birth </label>
                                                    <div class="cal-icon"><input class="form-control datetimepicker" type="text" ></div>
                                                </div>
                                            </div>
                                            <div class="erp-em-reg-step-item flex-31">
                                                <div class="input-block erp-step-input-block ">
                                                    <label class="col-form-label">Gender: </label>
                                                    <select class="select no-search-select-step">
                                                        <option>Select Gender</option>
                                                        <option>Male</option>
                                                        <option>Female </option>

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="erp-em-reg-step-item flex-31">
                                                <div class="input-block erp-step-input-block ">
                                                    <label class="col-form-label">Religion: <span class="text-danger">*</span></label>
                                                    <select class="select no-search-select-step">
                                                        <option>Select Religion</option>
                                                        <option>Islam</option>
                                                        <option>Christianity </option>
                                                        <option>Hinduism</option>
                                                        <option>Buddhism</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Marital Status:</label>
                                                <select class="select no-search-select-step">
                                                    <option>Select Marital Status</option>
                                                    <option>Married</option>
                                                    <option>Unmarried </option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Marriage Date: </label>
                                                <div class="cal-icon"><input class="form-control datetimepicker" type="text" ></div>
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Present Address: </label>
                                                <textarea  class="form-control" cols="30" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Permanent Address: </label>
                                                <textarea  class="form-control" cols="30" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-100">

                                            <div class="e-add-contact flex-100 pb-3 pt-3 text-center">
                                                <a href="javascript:void(0);" class="btn erp-add-btn "><i class="fa-solid fa-plus"></i> Add Emergency Contact</a>
                                            </div>

                                            <div class="erp-emergency-contact-main-wrap d-flex flex-wrap justify-content-center ">
                                                <div class="erp-emergency-child-contact-wrap flex-wrap flex-48" style="display: none;">
                                                    <div class="erp-emergency-contact-item flex-100">
                                                        <div class="input-block erp-step-input-block ">
                                                            <label class="col-form-label">Name </label>
                                                            <input class="form-control " type="text" >
                                                        </div>
                                                    </div>
                                                    <div class="erp-emergency-contact-item flex-100">
                                                        <div class="input-block erp-step-input-block ">
                                                            <label class="col-form-label">Email </label>
                                                            <input class="form-control " type="text" >
                                                        </div>
                                                    </div>
                                                    <div class="erp-emergency-contact-item flex-100">
                                                        <div class="input-block erp-step-input-block ">
                                                            <label class="col-form-label">Phone </label>
                                                            <input class="form-control " type="text" >
                                                        </div>
                                                    </div>
                                                    <div class="erp-emergency-contact-item flex-100">
                                                        <div class="input-block erp-step-input-block ">
                                                            <label class="col-form-label">Relationship </label>
                                                            <input class="form-control " type="text" >
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </section>

                                <h3 class="d-none">Bank Info</h3>
                                <section class="erp-step-bank-info-wrapper">
                                    <div class="erp-em-reg-step-wrapper d-flex flex-wrap">

                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Bank Name: </label>
                                                <input class="form-control " type="text" placeholder="">
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Account Name: </label>
                                                <input class="form-control " type="text" placeholder="">
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Branch: </label>
                                                <input class="form-control " type="text" >
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Routing Number: </label>
                                                <input class="form-control " type="text" >
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Swift Code: </label>
                                                <input class="form-control " type="text" >
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Note: </label>
                                                <input class="form-control " type="text" >
                                            </div>
                                        </div>
                                    </div>
                                </section>

                                <h3 class="d-none">Education Info</h3>
                                <section class="erp-step-salary-wrapper">
                                    <div class="erp-em-reg-step-wrapper">
                                        <div class="erp-em-edu-step-wrapper d-flex flex-wrap">

                                            <div class="erp-em-reg-step-item flex-48">
                                                <div class="input-block erp-step-input-block ">
                                                    <label class="col-form-label">Degree: </label>
                                                    <select class="select select-step">
                                                        <option>Select Degree</option>
                                                        <option>SSC</option>
                                                        <option>HSC </option>
                                                        <option>Diploma </option>
                                                        <option>Honours </option>
                                                        <option>Associate Degree </option>
                                                        <option>Bachelor of Science </option>
                                                        <option>Master of Science </option>
                                                        <option>Other's </option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="erp-em-reg-step-item flex-48">
                                                <div class="input-block erp-step-input-block ">
                                                    <label class="col-form-label">Institute Number: </label>
                                                    <input class="form-control " type="text" placeholder="">
                                                </div>
                                            </div>
                                            <div class="erp-em-reg-step-item flex-48">
                                                <div class="input-block erp-step-input-block ">
                                                    <label class="col-form-label">Subject: </label>
                                                    <input class="form-control " type="text" >
                                                </div>
                                            </div>
                                            <div class="erp-em-reg-step-item flex-48">
                                                <div class="input-block erp-step-input-block ">
                                                    <label class="col-form-label">Grade: </label>
                                                    <input class="form-control " type="text" >
                                                </div>
                                            </div>
                                            <div class="erp-em-reg-step-item flex-48">
                                                <div class="input-block erp-step-input-block ">
                                                    <label class="col-form-label">Start : </label>
                                                    <div class="cal-icon"><input class="form-control datetimepicker" type="text" ></div>
                                                </div>
                                            </div>
                                            <div class="erp-em-reg-step-item flex-48">
                                                <div class="input-block erp-step-input-block ">
                                                    <label class="col-form-label">Ending: </label>
                                                    <div class="cal-icon"><input class="form-control datetimepicker" type="text" ></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="erp-em-edu-step-add-wrapper text-center">
                                            <a href="javascript:void(0);" class="btn erp-add-btn "><i class="fa-solid fa-plus"></i> Add Education</a>
                                        </div>
                                    </div>

                                </section>


                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
    <script src="{{ asset('assets/plugins/jquery-steps/jquery.steps.min.js') }}"></script>
@endsection

@section('js')
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

                            let email = $('#emailAddress').val();
                            if (!email) {
                                $("#emailAddress").addClass("is-invalid");
                                $('.emailAddress-error').show();
                                form_valid = false;
                            } else {
                                $("#emailAddress").removeClass("is-invalid");
                                $('.emailAddress-error').hide();
                            }

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


    </script>
@endsection


