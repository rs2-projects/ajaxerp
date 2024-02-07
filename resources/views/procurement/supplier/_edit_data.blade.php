<form action="{{ route('procurement.supplier.update', $item->id) }}" id="supplierUpdateForm" method="post">
    @csrf
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="erp-salary-tab-offcanvas">
                    <ul class="nav nav-tabs erp-nav-tabs justify-content-center" id="myTab" role="tablist">
                        <li class="nav-item erp-nav-item" role="presentation">
                          <button class="nav-link erp-nav-link active" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact2" type="button" role="tab" aria-controls="home" aria-selected="true">Contact</button>
                        </li>
                        <li class="nav-item erp-nav-item" role="presentation">
                          <button class="nav-link erp-nav-link" id="address-tab" data-bs-toggle="tab" data-bs-target="#address2" type="button" role="tab" aria-controls="profile" aria-selected="false" tabindex="-1">Address</button>
                        </li>
                        <li class="nav-item erp-nav-item" role="presentation">
                          <button class="nav-link erp-nav-link" id="bank-tab" data-bs-toggle="tab" data-bs-target="#bank2" type="button" role="tab" aria-controls="profile" aria-selected="false" tabindex="-1">Bank</button>
                        </li>
                        <li class="nav-item erp-nav-item" role="presentation">
                          <button class="nav-link erp-nav-link" id="product-tab" data-bs-toggle="tab" data-bs-target="#product2" type="button" role="tab" aria-controls="profile" aria-selected="false" tabindex="-1">Product</button>
                        </li>
                        <li class="nav-item erp-nav-item" role="presentation">
                          <button class="nav-link erp-nav-link" id="more-tab" data-bs-toggle="tab" data-bs-target="#more2" type="button" role="tab" aria-controls="profile" aria-selected="false" tabindex="-1">More</button>
                        </li>
                    
                      </ul>
                      <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="contact2" role="tabpanel" aria-labelledby="contact-tab">
                            <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-3 ">
                                
                                <div class="erp-filter-item flex-48"> 
                                    <div class="input-block mb-0 erp-step-input-block ">
                                        <label class="col-form-label">Business or Person <span class="text-red">*</span></label>
                                        <input value="{{$item->business_name}}" type="text" name="business_name" class="form-control" required>
                                        <span class="business_name_error ie-span"></span>
                                    </div>
                                </div>
                                <div class="erp-filter-item flex-48"> 
                                    <div class="input-block mb-0 erp-step-input-block ">
                                        <label class="col-form-label">Upload Photo </label>
                                        <div class="d-flex">
                                            <input type="file" name="image" class="form-control" >
                                            <img class="edit-img-src" src="{{ $item->show_image }}" width="30">
                                        </div>
                                    </div>
                                </div>
                                <div class="erp-filter-item flex-48"> 
                                    <div class="input-block mb-0 erp-step-input-block ">
                                        <label class="col-form-label">Email(H.O) <span class="text-red">*</span></label>
                                        <input value="{{$item->email}}" type="email" name="email" class="form-control " required>
                                        <span class="email_error ie-span"></span>
                                    </div>
                                </div>
                                <div class="erp-filter-item flex-48"> 
                                    <div class="input-block mb-0 erp-step-input-block ">
                                        <label class="col-form-label">Phone(H.O) <span class="text-red">*</span></label>
                                        <input value="{{$item->phone}}" type="tel" name="phone" class="form-control " required>
                                        <span class="phone_error ie-span"></span>
                                    </div>
                                </div>
                                <div class="erp-filter-item flex-100 mt-3"> 
                                    <h4 class="offcanvas-title-erp">Contact Person</h4>
                                </div>
                                <div class="erp-filter-item flex-48"> 
                                    <div class="input-block mb-0 erp-step-input-block ">
                                        <label class="col-form-label">First Name </label>
                                        <input value="{{$item->contact_first_name}}" type="text" name="contact_first_name" class="form-control " >
                                    </div>
                                </div>
                                <div class="erp-filter-item flex-48"> 
                                    <div class="input-block mb-0 erp-step-input-block ">
                                        <label class="col-form-label">Last Name </label>
                                        <input value="{{$item->contact_last_name}}" name="contact_last_name" type="text" class="form-control " >
                                    </div>
                                </div>
                                <div class="erp-filter-item flex-100 mt-3"> 
                                    <h4 class="offcanvas-title-erp">Lead Time</h4>
                                </div>
                                <div class="erp-filter-item flex-100"> 
                                    <div class="input-block mb-0 erp-step-input-block ">
                                        <label class="col-form-label">Lead Time Status </label>
                                        <input value="{{$item->lead_time_status}}" name="lead_time_status" type="text" class="form-control " >
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="tab-pane fade " id="address2" role="tabpanel" aria-labelledby="address-tab">
                            <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-3 ">
                                <div class="erp-filter-item flex-100"> 
                                    <div class="input-block mb-0 erp-step-input-block ">
                                        <label class="col-form-label">Address </label>
                                        <input value="{{$item->address}}" name="address" type="text" class="form-control " >
                                    </div>
                                </div>
                                <div class="erp-filter-item flex-48"> 
                                    <div class="input-block mb-0 erp-step-input-block ">
                                        <label class="col-form-label">City </label>
                                        <input value="{{$item->city}}" name="city" type="text" class="form-control " >
                                    </div>
                                </div>
                                <div class="erp-filter-item flex-48"> 
                                    <div class="input-block mb-0 erp-step-input-block ">
                                        <label class="col-form-label">Zip Code </label>
                                        <input value="{{$item->zip_code}}" name="zip_code" type="text" class="form-control " >
                                    </div>
                                </div>
                            
                                <div class="erp-filter-item flex-48"> 
                                    <div class="input-block erp-step-input-block mb-0 two">
                                        <label class="col-form-label">Country <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Point Four Epos Solutions"><i class="fa-duotone fa-exclamation"></i></span></label>
                                        <select class="select select-step select2 select-box country_id" onchange="getCountryWiseStates(this)" id="country_id" name="country_id">
                                            <option value="">Select Country</option>
                                            @foreach($countries as $country)
                                                <option {{$item->id == $country->id? 'selected' : ''}} value="{{$country->id}}">{{$country->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="erp-filter-item flex-48"> 
                                    <div class="input-block erp-step-input-block mb-0 two">
                                        <label class="col-form-label">State <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Point Four Epos Solutions"><i class="fa-duotone fa-exclamation"></i></span></label>
                                        <select class="select select-step select2 select-box state_id" id="state_id" name="state_id">
                                            <option value="">Select Province / State</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="tab-pane fade " id="bank2" role="tabpanel" aria-labelledby="bank-tab">
                            
                            <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between ">
                                <div class="erp-filter-item flex-100 position-relative"> 
                                    <h4 class="offcanvas-title-erp">Bank Information <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Point Four Epos Solutions"><i class="fa-duotone fa-exclamation"></i></span></h4>
                                    
                                </div>

                                <div class="additionalBankInfoContainer" id="additionalBankInfoContainer">
                                    @if(count($item->supplierBanks) > 0)
                                        @php $iteration = 0 @endphp
                                        @foreach($item->supplierBanks as $supplier_bank)
                                            <div class="erp-deduction-wrapper position-relative filter-row mb-3 d-flex flex-wrap align-items-center justify-content-between">
                                                @if($iteration > 0)   
                                                    <div class="delete-btn-box bank-info-remove" onclick="removeAdditionalBankInfo(this)" id="removeAdditionalBankInfo">
                                                        <a href="javascript:void(0);" class="delete-btn"><i class="fa-solid fa-trash-can"></i></a>
                                                    </div>
                                                @endif
                                                <input type="hidden" name="bank_info_id[]" value="{{ $supplier_bank->id }}">
                                                <div class="erp-filter-item flex-48"> 
                                                    <div class="input-block mb-0 erp-step-input-block ">
                                                        <label class="col-form-label">Bank Name </label>
                                                        <input value="{{$supplier_bank->bank_name}}" name="bank_name[]" type="text" class="form-control" placeholder="" required>
                                                    </div>
                                                </div>
                                                <div class="erp-filter-item flex-48"> 
                                                    <div class="input-block mb-0 erp-step-input-block ">
                                                        <label class="col-form-label">Account No </label>
                                                        <input value="{{$supplier_bank->account_no}}" name="account_no[]" type="text" class="form-control " placeholder="" required>
                                                    </div>
                                                </div>
                                                <div class="erp-filter-item flex-48"> 
                                                    <div class="input-block mb-0 erp-step-input-block ">
                                                        <label class="col-form-label">Account Name </label>
                                                        <input value="{{$supplier_bank->account_name}}" name="account_name[]" type="text" class="form-control " placeholder="" required>
                                                    </div>
                                                </div>
                                                <div class="erp-filter-item flex-48"> 
                                                    <div class="input-block mb-0 erp-step-input-block ">
                                                        <label class="col-form-label">Branch Name </label>
                                                        <input value="{{$supplier_bank->branch}}" name="branch[]" type="text" class="form-control " placeholder="" >
                                                    </div>
                                                </div>
                                                <div class="erp-filter-item flex-48"> 
                                                    <div class="input-block mb-0 erp-step-input-block ">
                                                        <label class="col-form-label">Routing Number </label>
                                                        <input value="{{$supplier_bank->routing_number}}" name="routing_number[]" type="text" class="form-control " placeholder="">
                                                    </div>
                                                </div>
                                                <div class="erp-filter-item flex-48"> 
                                                    <div class="input-block mb-0 erp-step-input-block ">
                                                        <label class="col-form-label">Swift Code </label>
                                                        <input value="{{$supplier_bank->swift_code}}" name="swift_code[]" type="text" class="form-control " placeholder="">
                                                    </div>
                                                </div>
                                                <div class="erp-filter-item flex-48"> 
                                                    <div class="input-block mb-0 erp-step-input-block ">
                                                        <label class="col-form-label">Note</label>
                                                        <input value="{{$supplier_bank->notes}}" name="notes[]" type="text" class="form-control " placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                            @php $iteration++ @endphp
                                        @endforeach
                                    @else
                                        <div class="erp-deduction-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between">
                                            <div class="erp-filter-item flex-48"> 
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">Bank Name </label>
                                                    <input name="bank_name[]" type="text" class="form-control" placeholder="" required>
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-48"> 
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">Account No </label>
                                                    <input name="account_no[]" type="text" class="form-control " placeholder="" required>
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-48"> 
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">Account Name </label>
                                                    <input name="account_name[]" type="text" class="form-control " placeholder="" required>
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
                                    @endif
                                </div>

                                <div class="add-more-row">
                                    <a href="javascript:void(0);" onclick="addAdditionalBankInfo()" class="add-tds ad-more-row-btn"><i class="fa-solid fa-plus"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade " id="product2" role="tabpanel" aria-labelledby="product-tab">
                            <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-3 ">
                                <div class="erp-filter-item flex-100"> 
                                    <div class="input-block erp-step-input-block mb-2">
                                        <label class="col-form-label">Material Product</label>
                                        <select class="material-multiselect" name="material_products[]" multiple="multiple" >
                                            @foreach($material_products as $material)
                                                <option {{ $item->supplierMaterials->contains('product_material_id', $material->id) ? 'selected' : '' }} 
                                                    value="{{ $material->id }}">{{ $material->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="input-block erp-step-input-block mb-2">
                                        <label class="col-form-label">Asset Product</label>
                                        <select class="asset-multiselect" name="asset_products[]" multiple="multiple" >
                                            @foreach($asset_products as $asset)
                                                <option {{ $item->supplierAssets->contains('asset_product_id', $asset->id) ? 'selected' : '' }}
                                                    value="{{$asset->id}}">{{$asset->name}}</option>
                                            @endforeach
                                            
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="tab-pane fade " id="more2" role="tabpanel" aria-labelledby="more-tab">
                            <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-3 ">
                                <div class="erp-filter-item flex-48"> 
                                    <div class="input-block mb-0 erp-step-input-block ">
                                        <label class="col-form-label">Fax </label>
                                        <input value="{{$item->fax}}" name="fax" type="text" class="form-control " >
                                    </div>
                                </div>
                                <div class="erp-filter-item flex-48"> 
                                    <div class="input-block mb-0 erp-step-input-block ">
                                        <label class="col-form-label">Website </label>
                                        <input value="{{$item->website}}" name="website" type="text" class="form-control " >
                                    </div>
                                </div>
                                <div class="erp-filter-item flex-48"> 
                                    <div class="input-block mb-0 erp-step-input-block ">
                                        <label class="col-form-label">Notes </label>
                                        <input value="{{$item->notes}}" name="supplier_notes" type="text" class="form-control ">
                                    </div>
                                </div>
                            
                                
                            </div>
                            <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between position-relative">
                                <div class="erp-filter-item flex-100 position-relative"> 
                                    <h4 class="offcanvas-title-erp">Others Contact</h4>
                                    
                                </div>

                                <div class="supplierOtherContactContainer" id="supplierOtherContactContainer" class="w-100">
                                    @if(count($item->supplierContacts) > 0)
                                        @php $iteration = 0 @endphp
                                        @foreach($item->supplierContacts as $supplier_contact)   
                                            <div class="supplier-other-contact-parent erp-deduction-wrapper mb-3 position-relative filter-row d-flex flex-wrap align-items-center justify-content-between flex-100">
                                                @if($iteration > 0)   
                                                    <div class="delete-btn-box bank-info-remove" onclick="removeOtherContact(this)">
                                                        <a href="javascript:void(0);" class="delete-btn"><i class="fa-solid fa-trash-can"></i></a>
                                                    </div>
                                                @endif
                                                <input type="hidden" name="supplier_contact_id[]" value="{{ $supplier_contact->id }}">
                                                <div class="erp-filter-item flex-32"> 
                                                    <div class="input-block mb-0 erp-step-input-block ">
                                                        <label class="col-form-label">Name</label>
                                                        <input value="{{$supplier_contact->name}}" name="contact_name[]" type="text" class="form-control " placeholder="">
                                                    </div>
                                                </div>
                                                <div class="erp-filter-item flex-32"> 
                                                    <div class="input-block mb-0 erp-step-input-block ">
                                                        <label class="col-form-label">Email</label>
                                                        <input value="{{$supplier_contact->email}}" name="contact_email[]" type="email" class="form-control " placeholder="">
                                                    </div>
                                                </div>
                                                <div class="erp-filter-item flex-32"> 
                                                    <div class="input-block mb-0 erp-step-input-block ">
                                                        <label class="col-form-label">Phone</label>
                                                        <input value="{{$supplier_contact->phone}}" name="contact_phone[]" type="tel" class="form-control " placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                            @php $iteration++ @endphp
                                        @endforeach
                                    @else
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
                                    @endif
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
</form>
