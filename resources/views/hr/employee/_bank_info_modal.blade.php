<!-- edit Profile Info Modal -->
<div id="bank_info_modal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header erp-modal-header">
                <h5 class="modal-title">Update Bank Info</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body erp-modal-body">
                <form action="{{ route('hr.employee.bank-info.update',$employee->id) }}" id="bankInfoUpdateForm" method="post" enctype = "multipart/form-data">
                    @csrf
                    <div class="erp-modal-body-content">
                        <section class="erp-step-bank-info-wrapper">
                            <div class="erp-em-reg-step-wrapper" id="bankInfoWrapMain">
                                @if(count($employee->userBankInfo) > 0)
                                    @foreach($employee->userBankInfo as $bank)
                                        <input type="hidden" name="bank_id[]" value="{{ $bank->id }}">
                                        <div class="erp-em-edu-step-wrapper d-flex flex-wrap">

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
                                            <div class="erp-em-reg-step-item flex-48">
                                                <div class="input-block erp-step-input-block ">
                                                    <label class="col-form-label">E-Wallet (Gcash/Maya): </label>
                                                    <input class="form-control " value="{{ $bank->e_wallet }}" name="e_wallet[]" type="text" >
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="erp-em-edu-step-wrapper d-flex flex-wrap">
                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Bank Name: </label>
                                                <input class="form-control "  name="bank_name[]" type="text" placeholder="">
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Account Name: </label>
                                                <input class="form-control "  name="account_name[]" type="text" placeholder="">
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Account Number: </label>
                                                <input class="form-control "  name="account_number[]" type="text" placeholder="">
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Branch: </label>
                                                <input class="form-control "  name="branch_name[]" type="text" >
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Routing Number: </label>
                                                <input class="form-control "  name="routing_number[]" type="text" >
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Swift Code: </label>
                                                <input class="form-control " name="swift_code[]" type="text" >
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Note: </label>
                                                <input class="form-control " name="note[]" type="text" >
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="erp-em-edu-step-add-wrapper text-center mt-3">
                                <a href="javascript:void(0);" onclick="addBankInfo()" class="btn erp-add-btn "><i class="fa-solid fa-plus"></i> Add Bank Info</a>
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
