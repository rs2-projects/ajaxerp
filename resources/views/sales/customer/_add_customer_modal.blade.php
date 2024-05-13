<!-- Add Category Modal -->
<div id="addCustomerModal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <form style="width:100%" action="{{ route('sales.customer.store') }}" id="customerStoreForm" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header erp-modal-header">
                    <h5 class="modal-title">Add New Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="erp-salary-tab-offcanvas">
                                <ul class="nav nav-tabs erp-nav-tabs justify-content-center" id="myTab" role="tablist">
                                    <li class="nav-item erp-nav-item" role="presentation">
                                        <button class="nav-link erp-nav-link active" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="home" aria-selected="true">Contact</button>
                                    </li>
                                    <li class="nav-item erp-nav-item" role="presentation">
                                        <button class="nav-link erp-nav-link" id="address-tab" data-bs-toggle="tab" data-bs-target="#address" type="button" role="tab" aria-controls="profile" aria-selected="false" tabindex="-1">Address</button>
                                    </li>
                                    <li class="nav-item erp-nav-item" role="presentation">
                                        <button class="nav-link erp-nav-link" id="bank-tab" data-bs-toggle="tab" data-bs-target="#bank" type="button" role="tab" aria-controls="profile" aria-selected="false" tabindex="-1">Bank</button>
                                    </li>
                                    <li class="nav-item erp-nav-item" role="presentation">
                                        <button class="nav-link erp-nav-link" id="more-tab" data-bs-toggle="tab" data-bs-target="#more" type="button" role="tab" aria-controls="profile" aria-selected="false" tabindex="-1">More</button>
                                    </li>

                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                        <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-3 ">

                                            <div class="erp-filter-item flex-48">
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">Business or Person <span class="text-red">*</span></label>
                                                    <input type="text" name="business_name" class="form-control" required>
                                                    <span class="business_name_error ie-span"></span>
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-48">
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">Upload Photo </label>
                                                    <input type="file" name="image" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-48">
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">Email(H.O) <span class="text-red">*</span></label>
                                                    <input type="email" name="email" class="form-control " required>
                                                    <span class="email_error ie-span"></span>
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-48">
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">Phone(H.O) <span class="text-red">*</span></label>
                                                    <input type="tel" name="phone" class="form-control " required>
                                                    <span class="phone_error ie-span"></span>
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-100 mt-3">
                                                <h4 class="offcanvas-title-erp">Contact Person</h4>
                                            </div>
                                            <div class="erp-filter-item flex-48">
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">First Name </label>
                                                    <input type="text" name="contact_first_name" class="form-control " >
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-48">
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">Last Name </label>
                                                    <input name="contact_last_name" type="text" class="form-control " >
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-100 mt-3">
                                                <h4 class="offcanvas-title-erp">Lead Time</h4>
                                            </div>
                                            <div class="erp-filter-item flex-100">
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">Lead Time Status </label>
                                                    <input name="lead_time_status" type="text" class="form-control " >
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane fade " id="address" role="tabpanel" aria-labelledby="address-tab">
                                        <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-3 ">
                                            <div class="erp-filter-item flex-100">
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">Address </label>
                                                    <input name="address" type="text" class="form-control " >
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-48">
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">City </label>
                                                    <input name="city" type="text" class="form-control " >
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-48">
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">Zip Code </label>
                                                    <input name="zip_code" type="text" class="form-control " >
                                                </div>
                                            </div>

                                            <div class="erp-filter-item flex-48">
                                                <div class="input-block erp-step-input-block mb-0 two">
                                                    <label class="col-form-label">Country <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Point Four Epos Solutions"><i class="fa-duotone fa-exclamation"></i></span></label>
                                                    <select class="select select-step country_id" onchange="getCountryWiseStates(this)" id="country_id" name="country_id">
                                                        <option value="">Select Country</option>
                                                        @foreach($countries as $country)
                                                            <option value="{{$country->id}}">{{$country->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-48">
                                                <div class="input-block erp-step-input-block mb-0 two">
                                                    <label class="col-form-label">State <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Point Four Epos Solutions"><i class="fa-duotone fa-exclamation"></i></span></label>
                                                    <select class="select select-step state_id" id="state_id" name="state_id">
                                                        <option value="">Select Province / State</option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane fade " id="bank" role="tabpanel" aria-labelledby="bank-tab">

                                        <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between ">
                                            <div class="erp-filter-item flex-100 position-relative">
                                                <h4 class="offcanvas-title-erp">Bank Information <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Point Four Epos Solutions"><i class="fa-duotone fa-exclamation"></i></span></h4>

                                            </div>

                                            <div class="additionalBankInfoContainer" id="additionalBankInfoContainer">
                                                <div class="erp-deduction-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between">
                                                    <div class="erp-filter-item flex-48">
                                                        <div class="input-block mb-0 erp-step-input-block ">
                                                            <label class="col-form-label">Bank Name </label>
                                                            <input name="bank_name[]" type="text" class="form-control" placeholder="" >
                                                        </div>
                                                    </div>
                                                    <div class="erp-filter-item flex-48">
                                                        <div class="input-block mb-0 erp-step-input-block ">
                                                            <label class="col-form-label">Account No </label>
                                                            <input name="account_no[]" type="text" class="form-control " placeholder="" >
                                                        </div>
                                                    </div>
                                                    <div class="erp-filter-item flex-48">
                                                        <div class="input-block mb-0 erp-step-input-block ">
                                                            <label class="col-form-label">Account Name </label>
                                                            <input name="account_name[]" type="text" class="form-control " placeholder="" >
                                                        </div>
                                                    </div>
                                                    <div class="erp-filter-item flex-48">
                                                        <div class="input-block mb-0 erp-step-input-block ">
                                                            <label class="col-form-label">Branch Name </label>
                                                            <input name="branch[]" type="text" class="form-control " placeholder="" >
                                                        </div>
                                                    </div>
                                                    <div class="erp-filter-item flex-48">
                                                        <div class="input-block mb-0 erp-step-input-block ">
                                                            <label class="col-form-label">Routing Number </label>
                                                            <input name="routing_number[]" type="text" class="form-control " placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="erp-filter-item flex-48">
                                                        <div class="input-block mb-0 erp-step-input-block ">
                                                            <label class="col-form-label">Swift Code </label>
                                                            <input name="swift_code[]" type="text" class="form-control " placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="erp-filter-item flex-48">
                                                        <div class="input-block mb-0 erp-step-input-block ">
                                                            <label class="col-form-label">Note</label>
                                                            <input name="notes[]" type="text" class="form-control " placeholder="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="add-more-row">
                                                <a href="javascript:void(0);" onclick="addAdditionalBankInfo()" class="add-tds ad-more-row-btn"><i class="fa-solid fa-plus"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade " id="more" role="tabpanel" aria-labelledby="more-tab">
                                        <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-3 ">
                                            <div class="erp-filter-item flex-48">
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">Fax </label>
                                                    <input name="fax" type="text" class="form-control " >
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-48">
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">Website </label>
                                                    <input name="website" type="text" class="form-control " >
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-48">
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">Notes </label>
                                                    <input name="customer_notes" type="text" class="form-control ">
                                                </div>
                                            </div>


                                        </div>
                                        <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between position-relative">
                                            <div class="erp-filter-item flex-100 position-relative">
                                                <h4 class="offcanvas-title-erp">Others Contact</h4>

                                            </div>

                                            <div class="customerOtherContactContainer" id="customerOtherContactContainer" class="w-100">
                                                <div class="erp-deduction-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between flex-100">
                                                    <div class="erp-filter-item flex-32">
                                                        <div class="input-block mb-0 erp-step-input-block ">
                                                            <label class="col-form-label">Name</label>
                                                            <input name="contact_name[]" type="text" class="form-control " placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="erp-filter-item flex-32">
                                                        <div class="input-block mb-0 erp-step-input-block ">
                                                            <label class="col-form-label">Email</label>
                                                            <input name="contact_email[]" type="email" class="form-control " placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="erp-filter-item flex-32">
                                                        <div class="input-block mb-0 erp-step-input-block ">
                                                            <label class="col-form-label">Phone</label>
                                                            <input name="contact_phone[]" type="tel" class="form-control " placeholder="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="add-more-row mt-4">
                                            <a href="javascript:void(0);" onclick="addOtherContacts()" class="add-tds ad-more-row-btn"><i class="fa-solid fa-plus"></i></a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-3 flex-100">

                                <div class="erp-filter-item flex-100 mt-4">
                                    <div class="erp-search-btn-wrap text-center">
                                        <button class=" erp-search-btn text-center" type="submit">Save</button>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
<!-- /Add Department Modal -->
