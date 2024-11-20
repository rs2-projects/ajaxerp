<form action="{{ route('hr.employee.store-update-salary',$employee->id) }}" id="updateEmployeeSalaryForm" method="post" enctype = "multipart/form-data">
    @csrf
    <div class="erp-modal-body-content">
        <section class="erp-em-general-info">
            <div class="erp-em-reg-step-wrapper d-flex flex-wrap">
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
            <button class="btn btn-primary submit-btn" type="submit">Update</button>
        </div>
    </div>
</form>