<!-- edit Profile Info Modal -->
<div id="experience_info_modal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header erp-modal-header">
                <h5 class="modal-title">Update Experience Info</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body erp-modal-body">
                <form action="{{ route('hr.employee.experience-info.update',$employee->id) }}" id="experienceInfoUpdateForm" method="post" enctype = "multipart/form-data">
                    @csrf
                    <div class="erp-modal-body-content">
                        <section class="erp-step-salary-wrapper">
                            <div class="erp-em-reg-step-wrapper" id="addExperienceWrapMain">
                                @if(count($employee->userExperienceInfo) > 0)
                                    @foreach($employee->userExperienceInfo as $experience)
                                        <input type="hidden" name="experience_id[]" value="{{ $experience->id }}"/>
                                        <div class="erp-em-edu-step-wrapper d-flex flex-wrap">
                                            <div class="erp-em-reg-step-item flex-48">
                                                <div class="input-block erp-step-input-block ">
                                                    <label class="col-form-label">Company name: </label>
                                                    <input class="form-control " value="{{ $experience->company_name }}" name="company_name[]" type="text" placeholder="">
                                                </div>
                                            </div>
                                            <div class="erp-em-reg-step-item flex-48">
                                                <div class="input-block erp-step-input-block ">
                                                    <label class="col-form-label">Position: </label>
                                                    <input class="form-control " value="{{ $experience->designation }}" name="designation[]" type="text" >
                                                </div>
                                            </div>
                                            <div class="erp-em-reg-step-item flex-48">
                                                <div class="input-block erp-step-input-block ">
                                                    <label class="col-form-label">Start : </label>
                                                    <div class="cal-icon"><input class="form-control datetimepicker" value="{{ $experience->start_date }}" name="start_date[]" type="text" ></div>
                                                </div>
                                            </div>
                                            <div class="erp-em-reg-step-item flex-48">
                                                <div class="input-block erp-step-input-block ">
                                                    <label class="col-form-label">Ending: </label>
                                                    <div class="cal-icon"><input class="form-control datetimepicker" value="{{ $experience->end_date }}" name="end_date[]" type="text" ></div>
                                                </div>
                                            </div>
                                            <div class="erp-em-reg-step-item flex-100">
                                                <div class="input-block erp-step-input-block ">
                                                    <label class="col-form-label">Description: </label>
                                                    <textarea name="description[]" class="form-control" rows="3">{{ $experience->description }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else

                                    <div class="erp-em-edu-step-wrapper d-flex flex-wrap">
                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Company name: </label>
                                                <input class="form-control "  name="company_name[]" type="text" placeholder="">
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Position: </label>
                                                <input class="form-control " name="designation[]" type="text" > 
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
                                                <div class="cal-icon">
                                                    <input class="form-control datetimepicker"  name="end_date[]" type="text" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-100">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Description: </label>
                                                <textarea name="description[]" class="form-control" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="erp-em-edu-step-add-wrapper text-center mt-3">
                                <a href="javascript:void(0);" onclick="addExperienceInfo()" class="btn erp-add-btn "><i class="fa-solid fa-plus"></i> Add Experience</a>
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
