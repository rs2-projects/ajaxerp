<!-- Add Category Modal -->
<div id="addSupplierModal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <form style="width:100%" action="{{ route('inventory.asset-product.store') }}" id="productStoreForm" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header erp-modal-header">
                    <h5 class="modal-title">Add New Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{-- <div class="modal-body erp-modal-body">
                    <div class="erp-modal-body-content">
                        <div class="input-block mb-2">
                            <label class="col-form-label">Product Name <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="name">
                            <span class="name_error ie-span"></span>
                        </div>
                        <div class="input-block mb-2">
                            <label class="col-form-label">Category <span class="text-danger">*</span></label>
                            
                            </select>
                            <span class="asset_product_category_id_error ie-span"></span>
                        </div>
                        <div class="input-block mb-2">
                            <label class="col-form-label">Product Image</label>
                            <input type="file" class="form-control " name="image" accept="image/*">
                        </div>

                        <div class="input-block mb-3">
                            <label class="col-form-label">Description </label>
                            <textarea cols="30" rows="3" class="form-control" name="description"></textarea>
                        </div>
                        <div class="submit-section mt-2">
                            <button class="btn btn-primary submit-btn" type="submit">Save</button>
                        </div>
                    </div>
                </div> --}}
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
                                      <button class="nav-link erp-nav-link" id="product-tab" data-bs-toggle="tab" data-bs-target="#product" type="button" role="tab" aria-controls="profile" aria-selected="false" tabindex="-1">Product</button>
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
                                                        <input type="text" class="form-control " >
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-48"> 
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">Upload Photo </label>
                                                        <input type="file" class="form-control " >
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-48"> 
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">Email(H.O) <span class="text-red">*</span></label>
                                                        <input type="email" class="form-control " >
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-48"> 
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">Phone(H.O) <span class="text-red">*</span></label>
                                                        <input type="tel" class="form-control " >
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-100 mt-3"> 
                                                <h4 class="offcanvas-title-erp">Contact Person</h4>
                                            </div>
                                            <div class="erp-filter-item flex-48"> 
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">First Name </label>
                                                        <input type="text" class="form-control " >
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-48"> 
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">Last Name </label>
                                                        <input type="text" class="form-control " >
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-100 mt-3"> 
                                                <h4 class="offcanvas-title-erp">Lead Time</h4>
                                            </div>
                                            <div class="erp-filter-item flex-100"> 
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">Lead Time Status </label>
                                                        <input type="text" class="form-control " >
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="tab-pane fade " id="address" role="tabpanel" aria-labelledby="address-tab">
                                        <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-3 ">
                                            <div class="erp-filter-item flex-100"> 
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">Address </label>
                                                        <input type="text" class="form-control " >
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-48"> 
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">City </label>
                                                        <input type="text" class="form-control " >
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-48"> 
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">Zip Code </label>
                                                        <input type="text" class="form-control " >
                                                </div>
                                            </div>
                                        
                                            <div class="erp-filter-item flex-48"> 
                                                <div class="input-block erp-step-input-block mb-0 two">
                                                    <label class="col-form-label">Country <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Point Four Epos Solutions"><i class="fa-duotone fa-exclamation"></i></span></label>
                                                    <select class="select select-step" >
                                                        <option>Select Country</option>
                                                        <option>Bangladesh</option>
                                                        <option>India</option>
                                                        <option>Pakistan</option>
                                                        <option>USA</option>
                                                        <option>UK</option>
                                                        <option>Canada</option>
                                                        <option>China</option>
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-48"> 
                                                <div class="input-block erp-step-input-block mb-0 two">
                                                    <label class="col-form-label">State <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Point Four Epos Solutions"><i class="fa-duotone fa-exclamation"></i></span></label>
                                                    <select class="select select-step" >
                                                        <option>Select Province / State</option>
                                                        <option>Dhaka</option>
                                                        <option>Chittagong</option>
                                                        <option>Khulna</option>
                                                        <option>Rajshahi</option>
                                                        <option>Rangpur</option>
                                                        <option>Sylhet</option>

                                                        
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

                                            <div id="additionalBankInfoContainer">
                                                <div class="erp-deduction-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between">
                                                    <div class="erp-filter-item flex-48"> 
                                                        <div class="input-block mb-0 erp-step-input-block ">
                                                            <label class="col-form-label">Bank Name </label>
                                                                <input type="text" class="form-control " placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="erp-filter-item flex-48"> 
                                                        <div class="input-block mb-0 erp-step-input-block ">
                                                            <label class="col-form-label">Account Name </label>
                                                                <input type="text" class="form-control " placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="erp-filter-item flex-48"> 
                                                        <div class="input-block mb-0 erp-step-input-block ">
                                                            <label class="col-form-label">Branch Name </label>
                                                                <input type="text" class="form-control " placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="erp-filter-item flex-48"> 
                                                        <div class="input-block mb-0 erp-step-input-block ">
                                                            <label class="col-form-label">Routing Number </label>
                                                                <input type="text" class="form-control " placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="erp-filter-item flex-48"> 
                                                        <div class="input-block mb-0 erp-step-input-block ">
                                                            <label class="col-form-label">Swift Code </label>
                                                                <input type="text" class="form-control " placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="erp-filter-item flex-48"> 
                                                        <div class="input-block mb-0 erp-step-input-block ">
                                                            <label class="col-form-label">Note</label>
                                                                <input type="text" class="form-control " placeholder="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="add-more-row">
                                                <a href="javascript:void(0);" onclick="addAdditionalBankInfo()" class="add-tds ad-more-row-btn"><i class="fa-solid fa-plus"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade " id="product" role="tabpanel" aria-labelledby="product-tab">
                                        <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-3 ">
                                            <div class="erp-filter-item flex-100"> 
                                                <div class="input-block erp-step-input-block mb-2">
                                                    <label class="col-form-label">Material Product <span class="text-danger">*</span></label>
                                                    <select class="employee-multiselect" multiple="multiple" >
                                                        <option>Marker</option>
                                                        <option>Pen</option>
                                                        <option>Pencil</option>
                                                        <option>Eraser</option>
                                                        <option>Sharpner</option>
                                                        <option>Scale</option>
                                                        <option>Stapler</option>
                                                        <option>Stapler Pin</option>
                                                        <option>Stapler Remover</option>
                                                        <option>Scissor</option>
                                                        <option>Glue</option>
                                                        <option>Calculator</option>
                                                        <option>Highlighter</option>
                                                        <option>File</option>
                                                        <option>Folder</option>
                                                        <option>Clip</option>
                                                        <option>Pin</option>
                                                        <option>Pin Cushion</option>
                                                        <option>Push Pin</option>
                                                        
                                                    </select>
                                                </div>

                                                <div class="input-block erp-step-input-block mb-2">
                                                    <label class="col-form-label">Asset Product <span class="text-danger">*</span></label>
                                                    <select class="employee-multiselect" multiple="multiple" >
                                                        <option>Marker</option>
                                                        <option>Pen</option>
                                                        <option>Pencil</option>
                                                        <option>Eraser</option>
                                                        <option>Sharpner</option>
                                                        <option>Scale</option>
                                                        <option>Stapler</option>
                                                        <option>Stapler Pin</option>
                                                        <option>Stapler Remover</option>
                                                        <option>Scissor</option>
                                                        <option>Glue</option>
                                                        <option>Calculator</option>
                                                        <option>Highlighter</option>
                                                        <option>File</option>
                                                        <option>Folder</option>
                                                        <option>Clip</option>
                                                        <option>Pin</option>
                                                        <option>Pin Cushion</option>
                                                        <option>Push Pin</option>
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="tab-pane fade " id="more" role="tabpanel" aria-labelledby="more-tab">
                                        <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-3 ">
                                            
                                            <div class="erp-filter-item flex-48"> 
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">Account No </label>
                                                        <input type="text" class="form-control " >
                                                
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-48"> 
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">Fax </label>
                                                        <input type="text" class="form-control " >
                                                
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-48"> 
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">Website </label>
                                                        <input type="text" class="form-control " >
                                                
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-48"> 
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">Notes </label>
                                                        <input type="text" class="form-control ">
                                                
                                                </div>
                                            </div>
                                        
                                            
                                        </div>
                                        <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between position-relative">
                                            <div class="erp-filter-item flex-100 position-relative"> 
                                                <h4 class="offcanvas-title-erp">Others Contact</h4>
                                                
                                            </div>

                                            <div id="supplierOtherContactContainer" class="w-100">
                                                <div class="erp-deduction-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between flex-100">
                                                    <div class="erp-filter-item flex-32"> 
                                                        <div class="input-block mb-0 erp-step-input-block ">
                                                            <label class="col-form-label">Name <span class="text-danger">*</span> </label>
                                                                <input type="text" class="form-control " placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="erp-filter-item flex-32"> 
                                                        <div class="input-block mb-0 erp-step-input-block ">
                                                            <label class="col-form-label">Email <span class="text-danger">*</span> </label>
                                                                <input type="email" class="form-control " placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="erp-filter-item flex-32"> 
                                                        <div class="input-block mb-0 erp-step-input-block ">
                                                            <label class="col-form-label">Phone <span class="text-danger">*</span> </label>
                                                            <input type="tel" class="form-control " placeholder="">
                                                        </div>
                                                    </div>
                                                    {{-- <div class="erp-filter-item flex-32"> 
                                                        <div class="delete-btn-box">
                                                            <a href="#" class="delete-btn"><i class="fa-solid fa-trash-can"></i></a>
                                                        </div>
                                                    </div> --}}
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
