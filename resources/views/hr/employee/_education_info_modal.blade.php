<!-- edit Profile Info Modal -->
<div id="education_info_modal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header erp-modal-header">
                <h5 class="modal-title">Update Education Info</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body erp-modal-body">
                <form action="{{ route('hr.employee.education-info.update',$employee->id) }}" id="educationInfoUpdateForm" method="post" enctype = "multipart/form-data">
                    @csrf
                    <div class="erp-modal-body-content">
                        <section class="erp-step-salary-wrapper">
                            <div class="erp-em-reg-step-wrapper" id="addEducationWrapMain">
                                @if(count($employee->userEducationInfo) > 0)
                                    @foreach($employee->userEducationInfo as $education)
                                        <input type="hidden" name="education_id[]" value="{{ $education->id }}"/>
                                        <div class="erp-em-edu-step-wrapper d-flex flex-wrap">
                                            <div class="erp-em-reg-step-item flex-48">
                                                <div class="input-block erp-step-input-block ">
                                                    <label class="col-form-label">Degree: </label>
                                                    <select class="select2 select-step" name="degree[]">
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
                                                <select class="select2 select-step" name="degree[]">
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
