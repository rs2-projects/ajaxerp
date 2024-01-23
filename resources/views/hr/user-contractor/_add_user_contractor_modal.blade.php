<!-- Add Resignation Modal -->
<div id="add_user_contractor_modal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header erp-modal-header">
                <h5 class="modal-title">Add Contractor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body erp-modal-body">
                <form action="{{ route('hr.user-contractor.store') }}" id="userContractorStoreForm" method="post">
                    @csrf
                    <div class="erp-modal-body-content  d-flex flex-wrap gap-2">
                        <div class="input-block mb-2 flex-48">
                            <label class="col-form-label">Contact Person <span class="text-danger">*</span></label>
                            <input type="text" name="name" required class="form-control">
                        </div>
                        <div class="input-block mb-2 flex-48">
                            <label class="col-form-label">Email <span class="text-danger">*</span></label>

                            <input type="email" name="email" required class="form-control">

                        </div>

                        <div class="input-block mb-2 flex-48">
                            <label class="col-form-label">Phone <span class="text-danger">*</span></label>

                            <input type="text" name="phone" required class="form-control">

                        </div>


                        <div class="input-block mb-2 flex-48" >
                            <label class="col-form-label">Phone 2</label>

                                <input type="text" name="phone2"  class="form-control">

                        </div>

                        <div class="input-block mb-2 flex-48">
                            <label class="col-form-label">Company Name</label>

                                <input type="text" name="company_name" class="form-control">

                        </div>
                        <div class="input-block mb-2 flex-48">
                            <label class="col-form-label">Company Address </label>

                                <input type="text" name="company_address"  class="form-control">

                        </div>
                        <div class="input-block mb-2 flex-48">
                            <label class="col-form-label">Contract Value <span class="text-danger">*</span></label>

                                <input type="number"  step="any" name="contract_value" required class="form-control">

                        </div>

                        <div class="input-block mb-2 flex-48">
                            <label class="col-form-label">Image </label>
                            <input class="form-control " name="image" type="file" >
                        </div>

                        <div class="erp-em-reg-step-item flex-100">
                            <div class="input-block erp-step-input-block ">
                                <label class="col-form-label">Employees:</label>
                                <select class="select select-step" multiple name="employee_id[]" id="employee_id">
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="erp-em-reg-step-item flex-100 pt-3">
                            <div class="erp-emergency-contact-main-wrap d-flex flex-wrap justify-content-center gap-3" id="emergencyContactWrapMain">

                            </div>
                            <div class="e-add-contact flex-100 pb-3 pt-3 text-center">
                                <a href="javascript:void(0);" class="btn erp-add-btn " onclick="addEmergencyContact()"><i class="fa-solid fa-plus"></i> Add Emergency Contact</a>
                            </div>
                        </div>

                        <div class="submit-section mt-2">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add Resignation Modal -->
