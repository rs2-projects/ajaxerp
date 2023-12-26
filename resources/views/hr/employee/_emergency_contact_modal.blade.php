<!-- edit Profile Info Modal -->
<div id="emergency_contact_modal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header erp-modal-header">
                <h5 class="modal-title">Update Emergency Contacts</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body erp-modal-body">
                <form action="{{ route('hr.employee.emergency-contact-info.update',$employee->id) }}" id="emergencyContactUpdateForm" method="post" enctype = "multipart/form-data">
                    @csrf
                    <div class="erp-modal-body-content">
                        <section class="erp-setep-personal-wrapper">
                            <div class="erp-em-reg-step-wrapper d-flex flex-wrap">
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
