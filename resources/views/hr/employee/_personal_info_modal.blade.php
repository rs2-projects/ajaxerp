<!-- edit Profile Info Modal -->
<div id="personal_info_modal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header erp-modal-header">
                <h5 class="modal-title">Update Personal Info</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body erp-modal-body">
                <form action="{{ route('hr.employee.personal-info.update',$employee->id) }}" id="personalInfoUpdateForm" method="post" enctype = "multipart/form-data">
                    @csrf
                    <div class="erp-modal-body-content">
                        <section class="erp-setep-personal-wrapper">
                            <div class="erp-em-reg-step-wrapper d-flex flex-wrap">
                                <div class="erp-em-reg-step-item flex-48">
                                    <div class="input-block erp-step-input-block ">
                                        <label class="col-form-label">Government ID: </label>
                                        <input class="form-control " value="{{ $employee->nid_no }}" name="nid_no" type="text" >
                                    </div>
                                </div>
                                <div class="erp-em-reg-step-item flex-48">
                                    <div class="input-block erp-step-input-block ">
                                        <label class="col-form-label">Upload Government ID: </label>
                                        <input class="form-control " name="nid_image" type="file" accept="image/*">
                                    </div>
                                </div>
                                <div class="erp-em-reg-step-item flex-48">
                                    <div class="input-block erp-step-input-block ">
                                        <label class="col-form-label">TIN Number: </label>
                                        <input class="form-control " value="{{ $employee->tin_number }}" name="tin_number" type="text" >
                                    </div>
                                </div>
                                <div class="erp-em-reg-step-item flex-48">
                                    <div class="input-block erp-step-input-block ">
                                        <label class="col-form-label">SSS Number: </label>
                                        <input class="form-control " value="{{ $employee->sss_number }}" name="sss_number" type="text" >
                                    </div>
                                </div>
                                <div class="erp-em-reg-step-item flex-48">
                                    <div class="input-block erp-step-input-block ">
                                        <label class="col-form-label">PHIC: </label>
                                        <input class="form-control " value="{{ $employee->phic }}" name="phic" type="text" >
                                    </div>
                                </div>
                                <div class="erp-em-reg-step-item flex-48">
                                    <div class="input-block erp-step-input-block ">
                                        <label class="col-form-label">Pag-Ibig: </label>
                                        <input class="form-control " value="{{ $employee->pag_ibig }}" name="pag_ibig" type="text" >
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
                                            <input class="form-control " type="file" name="passport_image" accept="image/*">
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
                                            <label class="col-form-label">Religion: <span class="text-danger">*</span></label>
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
                                        <textarea  class="form-control" name="permanent_address" cols="30" rows="3">{!! $employee->permanent_address !!}</textarea>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <div class="submit-section mt-2">
                            <button class="btn btn-primary submit-btn" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add designation Modal -->
