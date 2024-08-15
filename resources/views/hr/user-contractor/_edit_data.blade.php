<form action="{{ route('hr.user-contractor.update',$item->id) }}" id="userContractorUpdateForm" method="post">
    @csrf
    <div class="erp-modal-body-content  d-flex flex-wrap gap-2">
        <div class="input-block mb-2 flex-48">
            <label class="col-form-label">Name <span class="text-danger">*</span></label>
            <input type="text" name="name" value="{{ $item->name }}" required class="form-control">
        </div>
        <div class="input-block mb-2 flex-48">
            <label class="col-form-label">Email <span class="text-danger">*</span></label>

            <input type="email" name="email" value="{{ $item->email }}" required class="form-control">

        </div>

        <div class="input-block mb-2 flex-48">
            <label class="col-form-label">Phone <span class="text-danger">*</span></label>

            <input type="text" name="phone" required value="{{ $item->phone }}" class="form-control">

        </div>


        <div class="input-block mb-2 flex-48" >
            <label class="col-form-label">Phone 2</label>

            <input type="text" name="phone2" value="{{ $item->phone2 }}" class="form-control">

        </div>

        <div class="input-block mb-2 flex-48">
            <label class="col-form-label">Company Name </label>

            <input type="text" name="company_name" value="{{ $item->company_name }}" class="form-control">

        </div>
        <div class="input-block mb-2 flex-48">
            <label class="col-form-label">Company Address </label>

            <input type="text" name="company_address" value="{{ $item->company_address }}" class="form-control">

        </div>
        <div class="input-block mb-2 flex-48">
            <label class="col-form-label">Contract Value <span class="text-danger">*</span></label>

            <input type="number"  step="any" value="{{ formatNumber($item->contract_value) }}" name="contract_value" required class="form-control">

        </div>

        <div class="input-block mb-2 flex-48">
            <label class="col-form-label">Image </label>
            <input class="form-control " name="image" type="file" >
        </div>

        <div class="erp-em-reg-step-item flex-100">
            <div class="input-block erp-step-input-block ">
                <label class="col-form-label">Employees:</label>
                <select class="select select-step select2" multiple name="employee_id[]" id="employee_id">
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}" {{ in_array($employee->id,$selected_employee_ids) ? 'selected' : '' }}>{{ $employee->full_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="erp-em-reg-step-item flex-100 pt-3">
            <div class="erp-emergency-contact-main-wrap d-flex flex-wrap justify-content-center gap-3" id="emergencyContactWrapMainEdit">
                @if(count($item->emergencyContacts) > 0)
                    @foreach($item->emergencyContacts as $emergencyContact)
                        <input type="hidden" name="contact_id[]" value="{{ $emergencyContact->id }}">
                        <div class="erp-emergency-child-contact-wrap flex-wrap flex-48">
                            <div class="erp-emergency-contact-item flex-100">
                                <div class="input-block erp-step-input-block ">
                                    <label class="col-form-label">Name </label>
                                    <input class="form-control " value="{{ $emergencyContact->name }}" name="contact_name[]" required type="text" >
                                </div>
                            </div>
                            <div class="erp-emergency-contact-item flex-100">
                                <div class="input-block erp-step-input-block ">
                                    <label class="col-form-label">Email </label>
                                    <input class="form-control " value="{{ $emergencyContact->email }}" name="contact_email[]" type="text" >
                                </div>
                            </div>
                            <div class="erp-emergency-contact-item flex-100">
                                <div class="input-block erp-step-input-block ">
                                    <label class="col-form-label">Phone </label>
                                    <input class="form-control " value="{{ $emergencyContact->phone }}" name="contact_phone[]" type="text" >
                                </div>
                            </div>
                            <div class="erp-emergency-contact-item flex-100">
                                <div class="input-block erp-step-input-block ">
                                    <label class="col-form-label">Relationship </label>
                                    <input class="form-control " value="{{ $emergencyContact->relationship }}" name="contact_relation[]" required type="text" >
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="e-add-contact flex-100 pb-3 pt-3 text-center">
                <a href="javascript:void(0);" class="btn erp-add-btn " onclick="addEmergencyContactEdit()"><i class="fa-solid fa-plus"></i> Add Emergency Contact</a>
            </div>
        </div>

        <div class="submit-section mt-2">
            <button class="btn btn-primary submit-btn">Submit</button>
        </div>
    </div>
</form>
