<!-- edit Profile Info Modal -->
<div id="profile_info_modal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header erp-modal-header">
                <h5 class="modal-title">Update Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body erp-modal-body">
                <form action="{{ route('hr.employee.profile-info.update',$employee->id) }}" id="profileInfoUpdateForm" method="post" enctype = "multipart/form-data">
                    @csrf
                    <div class="erp-modal-body-content">
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
                                        <input class="form-control " value="{{ $employee->last_name }}" name="last_name" required type="text" placeholder="First Name">
                                        <span class="last_name_error ie-span"></span>
                                    </div>
                                </div>
                                <div class="erp-em-reg-step-item flex-48">
                                    <div class="input-block erp-step-input-block ">
                                        <label class="col-form-label" for="emailAddress">Email Address <span class="text-red">*</span></label>
                                        <input type="email" class="form-control " value="{{ $employee->email }}" name="email" id="emailAddress" placeholder="Enter email address" required="">
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
                                        <label class="col-form-label">Upload Profile Image: </label>
                                        <input class="form-control " name="image" type="file" accept="image/*">
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
