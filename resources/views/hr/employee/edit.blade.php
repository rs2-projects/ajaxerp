@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">

        <div class="erp-employee-list-wrapper">
            <form action="{{ route('hr.employee.update',$employee->id) }}" method="post" id="employeeStoreForm">
                @csrf
                <div class="erp-main-filter-wrapper d-flex justify-content-center ">
                    <div class="erp-add-em-step-wrapper bg-card flex-100">
                        <div class="erp-step-content-wrapper">
                            <div id="reg-employee">
                                <h3 class="d-none">General</h3>
                                <section class="erp-em-general-info">
                                    <div class="erp-em-reg-step-wrapper d-flex flex-wrap">

                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">First Name: <span class="text-red">*</span></label>
                                                <input class="form-control" value="{{ $employee->first_name }}" name="first_name" required type="text" placeholder="First Name">
                                                <span class="first_name_error ie-span"></span>
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Last Name: <span class="text-red">*</span></label>
                                                <input class="form-control " value="{{ $employee->last_name }}" name="last_name" required type="text" placeholder="Last Name">
                                                <span class="last_name_error ie-span"></span>
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label" for="emailAddress">Email Address <span class="text-red">*</span></label>
                                                <input type="email" class="form-control" value="{{ $employee->email }}" name="email" id="emailAddress" placeholder="Enter email address" required="">
                                                {{--<div class="invalid-feedback emailAddress-error">Please provide a valid email.</div>--}}
                                                <span class="email_error ie-span"></span>
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label for="validationServer01" class="col-form-label">Phone Number <span class="text-red">*</span></label>
                                                <input type="tel" name="phone" class="form-control" value="{{ $employee->phone }}" id="validationServer01" placeholder="Enter phone number"  required="">
                                                <span class="phone_error ie-span"></span>
                                                {{--<div class="valid-feedback">Looks good!</div>--}}
                                            </div>
                                        </div>

                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Joining Date <span class="text-red">*</span></label>
                                                <div class="cal-icon">
                                                    <input class="form-control datetimepicker" value="{{ $employee->joining_date }}" name="joining_date" type="text" >
                                                    <span class="joining_date_error ie-span"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Department <span class="text-danger">*</span></label>
                                                <select class="select select-step" name="department_id" onchange="getDesignation(this)" id="department_id"  required>
                                                    <option value="">Select Department</option>
                                                    @foreach($departments as $key=>$department)
                                                        <option value="{{ $department->id }}" {{ ($department->id == $employee->department_id) ? 'selected' : '' }}>{{ $department->name }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="department_id_error ie-span"></span>

                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Designation <span class="text-danger">*</span></label>
                                                <select class="select select-step" name="designation_id" id="designation_id" required>
                                                    <option value="">Select Department First</option>
                                                    @foreach($designations as $key=>$designation)
                                                        <option value="{{ $designation->id }}" {{ ($designation->id == $employee->designation_id) ? 'selected' : '' }}>{{ $designation->name }}</option>

                                                    @endforeach
                                                </select>
                                                <span class="designation_id_error ie-span"></span>
                                            </div>
                                        </div>

                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Role <span class="text-danger">*</span></label>
                                                <select class="select select-step" name="role_id" id="role_id"  required>
                                                    <option value="">Select Role</option>
                                                    @foreach($roles as $key=>$role)
                                                        <option value="{{ $role->id }}" {{$role->id == $employee->role_id ? 'selected' : ''}}>{{ $role->title }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="role_id_error ie-span"></span>

                                            </div>
                                        </div>

                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <div class="checkbox">
                                                    <label class="col-form-label"><input type="checkbox" onclick="isContracted()" value="1" name="is_contracted" {{ ($employee->is_contracted == \App\Models\User::CONTRACTED_YES) ? 'checked' : '' }} class="me-1"> Is Contracted?  </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block is-contracted" style="display: {{ ($employee->is_contracted == \App\Models\User::CONTRACTED_NO) ? 'none' : ''  }}">
                                                <label class="col-form-label">Contractor <span class="text-danger">*</span></label>
                                                <select class="select select-step" name="contractor_id" id="contractor_id"  required>
                                                    <option value="">Select Contractor</option>
                                                    @foreach($contractors as $key=>$contractor)
                                                        <option value="{{ $contractor->id }}" {{ ($contractor->id == $employee->contractor_id) ? 'selected' : '' }}>{{ $contractor->name }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="contractor_id_error ie-span"></span>

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
                                                <input class="form-control " value="{{ $employee->nid_no }}" name="nid_no" type="text" >
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Upload NID: </label>
                                                <input class="form-control " name="nid_image" type="file" >
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-group-item flex-100 d-flex justify-content-center flex-wrap">
                                            <div class="erp-em-reg-step-item flex-31">
                                                <div class="input-block erp-step-input-block ">
                                                    <label class="col-form-label">Passport No. </label>
                                                    <input class="form-control " value="{{ $employee->passport_no }}" name="passport_no" type="text" >
                                                </div>
                                            </div>
                                            <div class="erp-em-reg-step-item flex-31">
                                                <div class="input-block erp-step-input-block ">
                                                    <label class="col-form-label">Expire Date: </label>
                                                    <div class="cal-icon"><input class="form-control datetimepicker" value="{{ $employee->passport_expiry_date }}" name="passport_expiry_date" type="text" ></div>
                                                </div>
                                            </div>
                                            <div class="erp-em-reg-step-item flex-31">
                                                <div class="input-block erp-step-input-block ">
                                                    <label class="col-form-label">Upload Passport: </label>
                                                    <input class="form-control " type="file" name="passport_image">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-group-item flex-100 d-flex justify-content-center flex-wrap">
                                            <div class="erp-em-reg-step-item flex-31">
                                                <div class="input-block erp-step-input-block ">
                                                    <label class="col-form-label">Date Of Birth </label>
                                                    <div class="cal-icon"><input class="form-control datetimepicker" value="{{ $employee->date_of_birth }}" name="date_of_birth" type="text" ></div>
                                                </div>
                                            </div>
                                            <div class="erp-em-reg-step-item flex-31">
                                                <div class="input-block erp-step-input-block ">
                                                    <label class="col-form-label">Gender: </label>
                                                    <select class="select no-search-select-step" name="gender">
                                                        <option value="">Select Gender</option>
                                                        <option value="0" {{ ($employee->gender == \App\Models\User::GENDER_MALE) ? 'selected' : '' }}>Male</option>
                                                        <option value="1" {{ ($employee->gender == \App\Models\User::GENDER_FEMALE) ? 'selected' : '' }}>Female </option>
                                                        <option value="2" {{ ($employee->gender == \App\Models\User::GENDER_OTHER) ? 'selected' : '' }}>Other</option>

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="erp-em-reg-step-item flex-31">
                                                <div class="input-block erp-step-input-block ">
                                                    <label class="col-form-label">Religion: </label>
                                                    <select class="select no-search-select-step" name="religion">
                                                        <option value="">Select Religion</option>
                                                        <option value="islam" {{ ($employee->religion == 'islam') ? 'selected' : '' }}>Islam</option>
                                                        <option value="christianity" {{ ($employee->religion == 'christianity') ? 'selected' : '' }}>Christianity </option>
                                                        <option value="hinduism" {{ ($employee->religion == 'hinduism') ? 'selected' : '' }}>Hinduism</option>
                                                        <option value="buddhism" {{ ($employee->religion == 'buddhism') ? 'selected' : '' }}>Buddhism</option>
                                                        <option value="others" {{ ($employee->religion == 'others') ? 'selected' : '' }}>Others</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Marital Status:</label>
                                                <select class="select no-search-select-step" name="marital_status">
                                                    <option value="">Select Marital Status</option>
                                                    <option value="0" {{ ($employee->marital_status == \App\Models\User::MARITAL_STATUS_SINGLE) ? 'selected' : '' }}>Unmarried </option>
                                                    <option value="1" {{ ($employee->marital_status == \App\Models\User::MARITAL_STATUS_MARRIED) ? 'selected' : '' }}>Married</option>
                                                    <option value="2" {{ ($employee->marital_status == \App\Models\User::MARITAL_STATUS_DIVORCED) ? 'selected' : '' }}>Divorced</option>
                                                    <option value="3" {{ ($employee->marital_status == \App\Models\User::MARITAL_STATUS_WIDOWED) ? 'selected' : '' }}>Widowed</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Marriage Date: </label>
                                                <div class="cal-icon"><input class="form-control datetimepicker" value="{{ $employee->marriage_date }}" name="marriage_date" type="text" ></div>
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Present Address: </label>
                                                <textarea  class="form-control" name="present_address" cols="30" rows="3">{!! $employee->present_address !!}</textarea>
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Permanent Address: </label>
                                                <textarea  class="form-control"  name="permanent_address" cols="30" rows="3">{!! $employee->permanent_address !!}</textarea>
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-100 pt-3">
                                            <div class="erp-emergency-contact-main-wrap d-flex flex-wrap justify-content-center gap-3" id="emergencyContactWrapMain">
                                                @if(count($employee->userEmergencyContacts) > 0)
                                                    @foreach($employee->userEmergencyContacts as $contact)
                                                        <input type="hidden" name="contact_id[]" value="{{ $contact->id }}">
                                                        <div class="erp-emergency-child-contact-wrap flex-wrap flex-48">
                                                            <div class="erp-emergency-contact-item flex-100">
                                                                <div class="input-block erp-step-input-block ">
                                                                    <label class="col-form-label">Name </label>
                                                                    <input class="form-control " value="{{ $contact->name }}" name="contact_name[]" required type="text" >
                                                                </div>
                                                            </div>
                                                            <div class="erp-emergency-contact-item flex-100">
                                                                <div class="input-block erp-step-input-block ">
                                                                    <label class="col-form-label">Email </label>
                                                                    <input class="form-control " value="{{ $contact->email }}" name="contact_email[]" type="text" >
                                                                </div>
                                                            </div>
                                                            <div class="erp-emergency-contact-item flex-100">
                                                                <div class="input-block erp-step-input-block ">
                                                                    <label class="col-form-label">Phone </label>
                                                                    <input class="form-control " value="{{ $contact->phone }}" name="contact_phone[]" type="text" >
                                                                </div>
                                                            </div>
                                                            <div class="erp-emergency-contact-item flex-100">
                                                                <div class="input-block erp-step-input-block ">
                                                                    <label class="col-form-label">Relationship </label>
                                                                    <input class="form-control " value="{{ $contact->relation }}" name="contact_relation[]" required type="text" >
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="e-add-contact flex-100 pb-3 pt-3 text-center">
                                                <a href="javascript:void(0);" class="btn erp-add-btn " onclick="addEmergencyContact()"><i class="fa-solid fa-plus"></i> Add Emergency Contact</a>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                                <h3 class="d-none">Bank Info</h3>
                                <section class="erp-step-bank-info-wrapper">
                                    @if(count($employee->userBankInfo) > 0)
                                        @foreach($employee->userBankInfo as $bank)
                                            <input type="hidden" name="bank_id[]" value="{{ $bank->id }}">
                                            <div class="erp-em-reg-step-wrapper d-flex flex-wrap">

                                                <div class="erp-em-reg-step-item flex-48">
                                                    <div class="input-block erp-step-input-block ">
                                                        <label class="col-form-label">Bank Name: </label>
                                                        <input class="form-control " value="{{ $bank->bank_name }}" name="bank_name[]" type="text" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="erp-em-reg-step-item flex-48">
                                                    <div class="input-block erp-step-input-block ">
                                                        <label class="col-form-label">Account Name: </label>
                                                        <input class="form-control " value="{{ $bank->account_name }}" name="account_name[]" type="text" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="erp-em-reg-step-item flex-48">
                                                    <div class="input-block erp-step-input-block ">
                                                        <label class="col-form-label">Account Number: </label>
                                                        <input class="form-control " value="{{ $bank->account_number }}" name="account_number[]" type="text" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="erp-em-reg-step-item flex-48">
                                                    <div class="input-block erp-step-input-block ">
                                                        <label class="col-form-label">Branch: </label>
                                                        <input class="form-control " value="{{ $bank->branch_name }}" name="branch_name[]" type="text" >
                                                    </div>
                                                </div>
                                                <div class="erp-em-reg-step-item flex-48">
                                                    <div class="input-block erp-step-input-block ">
                                                        <label class="col-form-label">Routing Number: </label>
                                                        <input class="form-control " value="{{ $bank->routing_number }}" name="routing_number[]" type="text" >
                                                    </div>
                                                </div>
                                                <div class="erp-em-reg-step-item flex-48">
                                                    <div class="input-block erp-step-input-block ">
                                                        <label class="col-form-label">Swift Code: </label>
                                                        <input class="form-control " value="{{ $bank->swift_code }}" name="swift_code[]" type="text" >
                                                    </div>
                                                </div>
                                                <div class="erp-em-reg-step-item flex-48">
                                                    <div class="input-block erp-step-input-block ">
                                                        <label class="col-form-label">Note: </label>
                                                        <input class="form-control " value="{{ $bank->note }}" name="note[]" type="text" >
                                                    </div>
                                                </div>
                                                <div class="erp-em-reg-step-item flex-48"></div>
                                            </div>
                                        @endforeach
                                    @endif
                                </section>

                                <h3 class="d-none">Education Info</h3>
                                <section class="erp-step-salary-wrapper">
                                    <div class="erp-em-reg-step-wrapper" id="addEducationWrapMain">
                                        @if(count($employee->userEducationInfo) > 0)
                                            @foreach($employee->userEducationInfo as $education)
                                                <input type="hidden" name="education_id[]" value="{{ $education->id }}"/>
                                                <div class="erp-em-edu-step-wrapper d-flex flex-wrap">
                                                    <div class="erp-em-reg-step-item flex-48">
                                                        <div class="input-block erp-step-input-block ">
                                                            <label class="col-form-label">Degree: </label>
                                                            <select class="select select-step" name="degree[]">
                                                                <option value="">Select Degree</option>
                                                                <option value="ssc" {{ ($education->degree == 'ssc') ? 'selected' : '' }}>SSC</option>
                                                                <option value="hsc" {{ ($education->degree == 'hsc') ? 'selected' : '' }}>HSC </option>
                                                                <option value="diploma" {{ ($education->degree == 'diploma') ? 'selected' : '' }}>Diploma </option>
                                                                <option value="honours" {{ ($education->degree == 'honours') ? 'selected' : '' }}>Honours </option>
                                                                <option value="associate_degree" {{ ($education->degree == 'associate_degree') ? 'selected' : '' }}>Associate Degree </option>
                                                                <option value="bachelor_of_science" {{ ($education->degree == 'bachelor_of_science') ? 'selected' : '' }}>Bachelor of Science </option>
                                                                <option value="master_of_science" {{ ($education->degree == 'master_of_science') ? 'selected' : '' }}>Master of Science </option>
                                                                <option value="others" {{ ($education->degree == 'others') ? 'selected' : '' }}>Other's </option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="erp-em-reg-step-item flex-48">
                                                        <div class="input-block erp-step-input-block ">
                                                            <label class="col-form-label">Institute Number: </label>
                                                            <input class="form-control " value="{{ $education->institute_name }}" name="institute_name[]" type="text" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="erp-em-reg-step-item flex-48">
                                                        <div class="input-block erp-step-input-block ">
                                                            <label class="col-form-label">Subject: </label>
                                                            <input class="form-control " value="{{ $education->subject }}" name="subject[]" type="text" >
                                                        </div>
                                                    </div>
                                                    <div class="erp-em-reg-step-item flex-48">
                                                        <div class="input-block erp-step-input-block ">
                                                            <label class="col-form-label">Grade: </label>
                                                            <input class="form-control " value="{{ $education->grade }}" name="grade[]" type="text" >
                                                        </div>
                                                    </div>
                                                    <div class="erp-em-reg-step-item flex-48">
                                                        <div class="input-block erp-step-input-block ">
                                                            <label class="col-form-label">Start : </label>
                                                            <div class="cal-icon"><input class="form-control datetimepicker" value="{{ $education->start_date }}" name="start_date[]" type="text" ></div>
                                                        </div>
                                                    </div>
                                                    <div class="erp-em-reg-step-item flex-48">
                                                        <div class="input-block erp-step-input-block ">
                                                            <label class="col-form-label">Ending: </label>
                                                            <div class="cal-icon"><input class="form-control datetimepicker" value="{{ $education->end_date }}" name="end_date[]" type="text" ></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="erp-em-edu-step-wrapper d-flex flex-wrap">
                                                <div class="erp-em-reg-step-item flex-48">
                                                    <div class="input-block erp-step-input-block ">
                                                        <label class="col-form-label">Degree: </label>
                                                        <select class="select select-step" name="degree[]">
                                                            <option value="">Select Degree</option>
                                                            <option value="ssc">SSC</option>
                                                            <option value="hsc">HSC </option>
                                                            <option value="diploma">Diploma </option>
                                                            <option value="honours">Honours </option>
                                                            <option value="associate_degree">Associate Degree </option>
                                                            <option value="bachelor_of_science">Bachelor of Science </option>
                                                            <option value="master_of_science">Master of Science </option>
                                                            <option value="others">Other's </option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="erp-em-reg-step-item flex-48">
                                                    <div class="input-block erp-step-input-block ">
                                                        <label class="col-form-label">Institute Number: </label>
                                                        <input class="form-control " name="institute_name[]" type="text" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="erp-em-reg-step-item flex-48">
                                                    <div class="input-block erp-step-input-block ">
                                                        <label class="col-form-label">Subject: </label>
                                                        <input class="form-control " name="subject[]" type="text" >
                                                    </div>
                                                </div>
                                                <div class="erp-em-reg-step-item flex-48">
                                                    <div class="input-block erp-step-input-block ">
                                                        <label class="col-form-label">Grade: </label>
                                                        <input class="form-control " name="grade[]" type="text" >
                                                    </div>
                                                </div>
                                                <div class="erp-em-reg-step-item flex-48">
                                                    <div class="input-block erp-step-input-block ">
                                                        <label class="col-form-label">Start : </label>
                                                        <div class="cal-icon"><input class="form-control datetimepicker" name="start_date[]" type="text" ></div>
                                                    </div>
                                                </div>
                                                <div class="erp-em-reg-step-item flex-48">
                                                    <div class="input-block erp-step-input-block ">
                                                        <label class="col-form-label">Ending: </label>
                                                        <div class="cal-icon"><input class="form-control datetimepicker" name="end_date[]" type="text" ></div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
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
    <!--End::row-1 -->
    <div id="emergencyContactWrap" style="display: none;">
        <div class="erp-emergency-child-contact-wrap flex-wrap flex-48">
            <div class="erp-emergency-contact-item flex-100">
                <div class="input-block erp-step-input-block ">
                    <label class="col-form-label">Name </label>
                    <input class="form-control " name="contact_name[]" required type="text" >
                </div>
            </div>
            <div class="erp-emergency-contact-item flex-100">
                <div class="input-block erp-step-input-block ">
                    <label class="col-form-label">Email </label>
                    <input class="form-control " name="contact_email[]" type="text" >
                </div>
            </div>
            <div class="erp-emergency-contact-item flex-100">
                <div class="input-block erp-step-input-block ">
                    <label class="col-form-label">Phone </label>
                    <input class="form-control " name="contact_phone[]" type="text" >
                </div>
            </div>
            <div class="erp-emergency-contact-item flex-100">
                <div class="input-block erp-step-input-block ">
                    <label class="col-form-label">Relationship </label>
                    <input class="form-control " name="contact_relation[]" required type="text" >
                </div>
            </div>
        </div>
    </div>

    {{--add education--}}
    <div id="addEducationWrap" style="display: none;">
        <div class="erp-em-edu-step-wrapper d-flex flex-wrap">

            <div class="erp-em-reg-step-item flex-48">
                <div class="input-block erp-step-input-block ">
                    <label class="col-form-label">Degree: </label>
                    <select class="select2" name="degree[]">
                        <option value="">Select Degree</option>
                        <option value="ssc">SSC</option>
                        <option value="hsc">HSC </option>
                        <option value="diploma">Diploma </option>
                        <option value="honusrs">Honours </option>
                        <option value="associate_degree">Associate Degree </option>
                        <option value="bachelor_of_science">Bachelor of Science </option>
                        <option value="master_of_science">Master of Science </option>
                        <option value="others">Other's </option>

                    </select>
                </div>
            </div>
            <div class="erp-em-reg-step-item flex-48">
                <div class="input-block erp-step-input-block ">
                    <label class="col-form-label">Institute Number: </label>
                    <input class="form-control " name="institute_name[]" type="text" placeholder="">
                </div>
            </div>
            <div class="erp-em-reg-step-item flex-48">
                <div class="input-block erp-step-input-block ">
                    <label class="col-form-label">Subject: </label>
                    <input class="form-control " name="subject[]" type="text" >
                </div>
            </div>
            <div class="erp-em-reg-step-item flex-48">
                <div class="input-block erp-step-input-block ">
                    <label class="col-form-label">Grade: </label>
                    <input class="form-control " name="grade[]" type="text" >
                </div>
            </div>
            <div class="erp-em-reg-step-item flex-48">
                <div class="input-block erp-step-input-block ">
                    <label class="col-form-label">Start : </label>
                    <div class="cal-icon"><input class="form-control datetimepicker" name="start_date[]" type="text" ></div>
                </div>
            </div>
            <div class="erp-em-reg-step-item flex-48">
                <div class="input-block erp-step-input-block ">
                    <label class="col-form-label">Ending: </label>
                    <div class="cal-icon"><input class="form-control datetimepicker" name="end_date[]" type="text" ></div>
                </div>
            </div>
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
        });
        function getDesignation(select) {
            var department_id = $(select).val();
            let url = "{{ route('ajax.get-designation-by-department') }}";
            ajaxGet(url, {department_id:department_id}, function (response) {
                if (response.status == 200) {
                    $("#designation_id").html(response.view);
                } else {
                    toastr.error(response.message);
                }
            });
        }
        function addEmergencyContact(){
            var item = $('#emergencyContactWrap').html();

            $('#emergencyContactWrapMain').append(item);
        }
        function addEducation(){
            var item = $('#addEducationWrap').html();

            $('#addEducationWrapMain').append(item);
            initializeSelect()
        }
        function initializeSelect() {
            $('#addEducationWrapMain .select2').select2({
                minimumResultsForSearch: -1,
                width: '100%'
            });
        }
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

        function isContracted() {
            if($('input[name="is_contracted"]').is(':checked')){
                $('.is-contracted').show();
            }else{
                $('.is-contracted').hide();
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
                            let email = $('input[name="email"]').val();
                            let first_name = $('input[name="first_name"]').val();
                            let last_name = $('input[name="last_name"]').val();
                            let phone = $('input[name="phone"]').val();
                            let joining_date = $('input[name="joining_date"]').val();
                            let department_id = $('select[name="department_id"]').val();
                            let designation_id = $('select[name="designation_id"]').val();
                            let role_id = $('select[name="role_id"]').val();
                            let is_contracted = $('input[name="is_contracted"]').is(':checked');
                            let contractor_id = $('select[name="contractor_id"]').val();
                            if (!email) {
                                $("input[name='email']").addClass("is-invalid");
                                $('.email_error').html('Email is required!').show();
                                form_valid = false;
                            } else if(!validateEmail(email)) {
                                $("input[name='email']").addClass("is-invalid");
                                $('.email_error').html('Please enter a valid email!').show();
                                form_valid = false;
                            } else {
                                $("input[name='email']").removeClass("is-invalid");
                                $('.email_error').hide();
                            }

                            if (!first_name) {
                                $("input[name='first_name']").addClass("is-invalid");
                                $('.first_name_error').html('First name is required').show();
                                form_valid = false;
                            } else {
                                $("input[name='first_name']").removeClass("is-invalid");
                                $('.first_name_error').hide();
                            }
                            if (!last_name) {
                                $("input[name='last_name']").addClass("is-invalid");
                                $('.last_name_error').html('Last name is required').show();
                                form_valid = false;
                            } else {
                                $("input[name='last_name']").removeClass("is-invalid");
                                $('.last_name_error').hide();
                            }
                            if (!phone) {
                                $("input[name='phone']").addClass("is-invalid");
                                $('.phone_error').html('Phone is required').show();
                                form_valid = false;
                            } else {
                                $("input[name='phone']").removeClass("is-invalid");
                                $('.phone_error').hide();
                            }
                            if (!joining_date) {
                                $("input[name='joining_date']").addClass("is-invalid");
                                $('.joining_date_error').html('Joining Date is required').show();
                                form_valid = false;
                            } else {
                                $("input[name='joining_date']").removeClass("is-invalid");
                                $('.joining_date_error').hide();
                            }
                            if (!department_id) {
                                $("select[name='department_id']").addClass("is-invalid");
                                $('.department_id_error').html('Department is required').show();
                                form_valid = false;
                            } else {
                                $("select[name='department_id']").removeClass("is-invalid");
                                $('.department_id_error').hide();
                            }
                            if (!designation_id) {
                                $("select[name='designation_id']").addClass("is-invalid");
                                $('.designation_id_error').html('Designation is required').show();
                                form_valid = false;
                            } else {
                                $("select[name='designation_id']").removeClass("is-invalid");
                                $('.designation_id_error').hide();
                            }

                            if (!role_id) {
                                $("select[name='role_id']").addClass("is-invalid");
                                $('.role_id_error').html('Role is required').show();
                                form_valid = false;
                            } else {
                                $("select[name='role_id']").removeClass("is-invalid");
                                $('.role_id_error').hide();
                            }

                            if (is_contracted) {
                                if (!contractor_id) {
                                    $("select[name='contractor_id']").addClass("is-invalid");
                                    $('.contractor_id_error').html('Contractor is required').show();
                                    form_valid = false;
                                } else {
                                    $("select[name='contractor_id']").removeClass("is-invalid");
                                    $('.contractor_id_error').hide();
                                }
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


