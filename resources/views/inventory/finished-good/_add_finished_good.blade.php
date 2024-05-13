<!-- Add New Finished Good Modal -->
<div id="addProductMaterial" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('inventory.finished-good.store') }}" id="finishedGoodsStoreForm" enctype="multipart/form-data" method="post">
                @csrf
                <div class="modal-header erp-modal-header">
                    <h5 class="modal-title">Add New Finished Good</h5>
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
                                        <button class="nav-link erp-nav-link" id="address-tab" data-bs-toggle="tab" data-bs-target="#address" type="button" role="tab" aria-controls="profile" aria-selected="false" tabindex="-1">Goods Info</button>
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
                                                    <input type="text" class="form-control" name="name" required>
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-48">
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">Product Image </label>
                                                    <input type="file" class="form-control " name="image" accept="image/*">
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-48">
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">Product Code <span class="text-red">*</span></label>
                                                    <input type="text" class="form-control " name="code" required>
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-48">
                                                <div class="input-block erp-step-input-block mb-0 two">
                                                    <label class="col-form-label">Category <span class="text-red">*</span> <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Product Category"><i class="fa-duotone fa-exclamation"></i></span></label>
                                                    <select class="select select-step" name="finished_good_category_id" required>
                                                        <option value="">Select Category</option>
                                                        @foreach($finished_good_categories as $category)
                                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-100">
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">Description </label>
                                                    <textarea class="form-control" rows="3" name="description"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane fade " id="address" role="tabpanel" aria-labelledby="address-tab">
                                        <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-3 ">
                                            <div class="erp-filter-item flex-100">
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">Working Temperature </label>
                                                    <input type="text" class="form-control" name="working_temperature">
                                                </div>
                                            </div>
                                            <div class="messurement-wrapper flex-100 d-flex flex-wrap justify-content-between">
                                                <div class="erp-filter-item flex-100">
                                                    <h4 class="offcanvas-title-erp">Measurement</h4>
                                                </div>
                                                <div class="erp-filter-item flex-32">
                                                    <div class="input-block mb-0 erp-step-input-block ">
                                                        <label class="col-form-label">Length </label>
                                                        <input type="text" class="form-control " name="length">
                                                    </div>
                                                </div>
                                                <div class="erp-filter-item flex-32">
                                                    <div class="input-block mb-0 erp-step-input-block ">
                                                        <label class="col-form-label">Width </label>
                                                        <input type="text" class="form-control " name="width">
                                                    </div>
                                                </div>
                                                <div class="erp-filter-item flex-32">
                                                    <div class="input-block mb-0 erp-step-input-block ">
                                                        <label class="col-form-label">Thickness </label>
                                                        <input type="text" class="form-control " name="thickness">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-100">
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">Remarks </label>
                                                    <input type="text" class="form-control " name="remarks">
                                                </div>
                                            </div>


                                        </div>

                                    </div>
                                    <div class="tab-pane fade " id="warehouse" role="tabpanel" aria-labelledby="warehouse-tab">
                                        <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-3 ">
                                            <div class="erp-filter-item flex-100">
                                                <div class="input-block erp-step-input-block mb-0 two">
                                                    <label class="col-form-label">Warehouse <span class="text-red">*</span><span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Warehouse"><i class="fa-duotone fa-exclamation"></i></span></label>
                                                    <select class="select select-step" name="warehouse_id" id="warehouse_id" onchange="changeWarehouse(this)" required>
                                                        <option name="">Select Warehouse</option>
                                                        @foreach($warehouses as $warehouse)
                                                            <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-48">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <label class="col-form-label">Select Section(Line) <span class="text-danger">*</span></label>
                                                    <select class="section-multiselect sections" multiple="multiple" onchange="changeSections(this)" name="sections[]" id="sections_id" required>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-48">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <label class="col-form-label">Select Rack <span class="text-danger">*</span></label>
                                                    <select class="racks-multiselect racks" multiple="multiple" name="racks[]" id="racks_id" required>

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="erp-filter-item flex-100">
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">Comments </label>
                                                    <input type="text" class="form-control " name="comments">
                                                </div>
                                            </div>


                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-3 flex-100">

                                <div class="erp-filter-item flex-100 mt-4">
                                    <div class="erp-search-btn-wrap text-center">
                                        <button class=" erp-search-btn text-center" id="addFinishedGoodsBtn" type="submit">Save</button>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Add Finished Good Modal -->
