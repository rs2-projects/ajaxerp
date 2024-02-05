<!-- Add New Product Modal -->
<div id="addProductMaterial" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header erp-modal-header">
                <h5 class="modal-title">Add New Product Material</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body erp-modal-body">
                <div class="row">
                    <div class="col-md-12">

                        <div class="erp-salary-tab-offcanvas">
                            <ul class="nav nav-tabs erp-nav-tabs justify-content-center" id="myTab" role="tablist">
                                <li class="nav-item erp-nav-item" role="presentation">
                                    <button class="nav-link erp-nav-link active" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="home" aria-selected="true">Product Info</button>
                                </li>
                                <li class="nav-item erp-nav-item" role="presentation">
                                    <button class="nav-link erp-nav-link" id="address-tab" data-bs-toggle="tab" data-bs-target="#address" type="button" role="tab" aria-controls="profile" aria-selected="false" tabindex="-1">Materials Info</button>
                                </li>
                                <li class="nav-item erp-nav-item" role="presentation">
                                    <button class="nav-link erp-nav-link" id="warehouse-tab" data-bs-toggle="tab" data-bs-target="#warehouse" type="button" role="tab" aria-controls="profile" aria-selected="false" tabindex="-1">Warehouse Info</button>
                                </li>


                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                    <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-3 ">
                                        <div class="erp-filter-item flex-48">
                                            <div class="input-block mb-0 erp-step-input-block ">
                                                <label class="col-form-label">Product Name <span class="text-red">*</span> </label>
                                                <input type="text" class="form-control" name="name">
                                            </div>
                                        </div>
                                        <div class="erp-filter-item flex-48">
                                            <div class="input-block mb-0 erp-step-input-block ">
                                                <label class="col-form-label">Product Image <span class="text-red">*</span> </label>
                                                <input type="file" class="form-control " >
                                            </div>
                                        </div>
                                        <div class="erp-filter-item flex-48">
                                            <div class="input-block mb-0 erp-step-input-block ">
                                                <label class="col-form-label">Product Code </label>
                                                <input type="text" class="form-control " >
                                            </div>
                                        </div>
                                        <div class="erp-filter-item flex-48">
                                            <div class="input-block erp-step-input-block mb-0 two">
                                                <label class="col-form-label">Category <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Product Category"><i class="fa-duotone fa-exclamation"></i></span></label>
                                                <select class="select select-step" name="product_material_category_id" required>
                                                    <option value="">Select Category</option>
                                                    @foreach($material_categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="erp-filter-item flex-48">
                                            <div class="input-block mb-0 erp-step-input-block ">
                                                <label class="col-form-label">Low Stock Warning <span class="text-red">*</span></label>
                                                <input type="text" class="form-control " >
                                            </div>
                                        </div>
                                        <div class="erp-filter-item flex-48">
                                            <div class="input-block erp-step-input-block mb-0 two">
                                                <label class="col-form-label">Tax <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Product Tax"><i class="fa-duotone fa-exclamation"></i></span></label>
                                                <select class="select select-step" name="tax_id">
                                                    <option value="">Select Tax Value</option>
                                                    @foreach($vats as $vat)
                                                        <option value="{{ $vat->id }}">{{ $vat->tax_rate }}% {{ $vat->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="erp-filter-item flex-48">
                                            <div class="input-block mb-0 erp-step-input-block ">
                                                <label class="col-form-label">Low Stock At least <span class="text-red">*</span></label>
                                                <input type="text" class="form-control " >
                                            </div>
                                        </div>

                                        <div class="erp-filter-item flex-48">
                                            <div class="input-block erp-step-input-block mb-0 two">
                                                <label class="col-form-label">Unit <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Product Unit"><i class="fa-duotone fa-exclamation"></i></span></label>
                                                <select class="select select-step" name="unit_type" required>
                                                    <option value="">Select Unit</option>
                                                    @foreach($units as $key=>$unit)
                                                        <option value="{{ $key }}">{{ $unit }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="erp-filter-item flex-100">
                                            <div class="input-block mb-0 erp-step-input-block ">
                                                <label class="col-form-label">Description <span class="text-red">*</span></label>
                                                <textarea class="form-control" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane fade " id="address" role="tabpanel" aria-labelledby="address-tab">
                                    <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-3 ">
                                        <div class="erp-filter-item flex-48">
                                            <div class="input-block mb-0 erp-step-input-block ">
                                                <label class="col-form-label">Color </label>
                                                <input type="text" class="form-control " >
                                            </div>
                                        </div>
                                        <div class="erp-filter-item flex-48">
                                            <div class="input-block mb-0 erp-step-input-block ">
                                                <label class="col-form-label">Working Temperature </label>
                                                <input type="text" class="form-control " >
                                            </div>
                                        </div>
                                        <div class="messurement-wrapper flex-100 d-flex flex-wrap justify-content-between">
                                            <div class="erp-filter-item flex-100">
                                                <h4 class="offcanvas-title-erp">Measurement</h4>
                                            </div>
                                            <div class="erp-filter-item flex-32">
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">Length </label>
                                                    <input type="text" class="form-control " >
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-32">
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">Width </label>
                                                    <input type="text" class="form-control " >
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-32">
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">Thickness </label>
                                                    <input type="text" class="form-control " >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="erp-filter-item flex-100">
                                            <div class="input-block mb-0 erp-step-input-block ">
                                                <label class="col-form-label">Remarks </label>
                                                <input type="text" class="form-control " >
                                            </div>
                                        </div>


                                    </div>

                                </div>
                                <div class="tab-pane fade " id="warehouse" role="tabpanel" aria-labelledby="warehouse-tab">
                                    <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-3 ">
                                        <div class="erp-filter-item flex-100">
                                            <div class="input-block erp-step-input-block mb-0 two">
                                                <label class="col-form-label">Warehouse <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Product Category"><i class="fa-duotone fa-exclamation"></i></span></label>
                                                <select class="select select-step" >
                                                    <option>Select Warehouse</option>
                                                    <option>warehouse 01</option>
                                                    <option>warehouse 02</option>
                                                    <option>warehouse 03</option>


                                                </select>
                                            </div>
                                        </div>
                                        <div class="erp-filter-item flex-48">
                                            <div class="input-block erp-step-input-block mb-0">
                                                <label class="col-form-label">Select Section(Line) <span class="text-danger">*</span></label>
                                                <select class="employee-multiselect" multiple="multiple" >
                                                    <option>Line 1</option>
                                                    <option>Line 2</option>
                                                    <option>Line 3</option>
                                                    <option>Line 4</option>
                                                    <option>Line 5</option>
                                                    <option>Line 6</option>
                                                    <option>Line 7</option>
                                                    <option>Line 8</option>
                                                    <option>Line 9</option>
                                                    <option>Line 10</option>
                                                    <option>Line 11</option>
                                                    <option>Line 12</option>
                                                    <option>Line 13</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="erp-filter-item flex-48">
                                            <div class="input-block erp-step-input-block mb-0">
                                                <label class="col-form-label">Select Rack <span class="text-danger">*</span></label>
                                                <select class="employee-multiselect" multiple="multiple" >
                                                    <option>Rack 1</option>
                                                    <option>Rack 2</option>
                                                    <option>Rack 3</option>
                                                    <option>Rack 4</option>
                                                    <option>Rack 5</option>
                                                    <option>Rack 6</option>
                                                    <option>Rack 7</option>
                                                    <option>Rack 8</option>
                                                    <option>Rack 9</option>
                                                    <option>Rack 10</option>
                                                    <option>Rack 11</option>
                                                    <option>Rack 12</option>
                                                    <option>Rack 13</option>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="erp-filter-item flex-100">
                                            <div class="input-block mb-0 erp-step-input-block ">
                                                <label class="col-form-label">Comments </label>
                                                <input type="text" class="form-control " >
                                            </div>
                                        </div>


                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-3 flex-100">

                            <div class="erp-filter-item flex-100 mt-4">
                                <div class="erp-search-btn-wrap text-center">
                                    <button class=" erp-search-btn text-center">Save</button>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
<!-- /Add Product Material Modal -->
