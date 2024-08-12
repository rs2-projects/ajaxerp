<form action="{{ route('hr.employee.store-demotion',$employee->id) }}" id="demoteEmployeeForm" method="post" enctype = "multipart/form-data">
    @csrf
    <div class="erp-modal-body-content">
        <section class="erp-em-general-info">
            <div class="erp-em-reg-step-wrapper d-flex flex-wrap">

                
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
                        <label class="col-form-label">Basic Salary: <span class="text-red">*</span></label>
                        <input class="form-control" value="{{ formatNumber($basic_salary) }}" name="basic_salary" required type="text" placeholder="Enter Basic Salary">
                        <span class="basic_salary_error ie-span"></span>
                    </div>
                </div>

                <div class="erp-em-reg-step-item flex-48">
                    
                </div>

            </div>
        </section>
        <div class="submit-section mt-2">
            <button class="btn btn-primary submit-btn" type="submit">Submit</button>
        </div>
    </div>
</form>