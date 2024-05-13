<div id="addPurchaseRequestModal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content">
            <div class="modal-header erp-modal-header">
                <h5 class="modal-title">Add Asset Products</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body erp-modal-body p-0">
                <div class="warehouse-basic-info bg-card ">
                    <div class="wbi-item">
                        {{-- <h2>Purchase Request #{{$request_id}}</h2> --}}
                    </div>
                    <div class="new-purchase-request-form-wrapper mt-3 d-flex flex-wrap gap-2">
                        <div class="nprf-item flex-100">
                            <div class="input-block erp-step-input-block ">
                                <label class="col-form-label">Category <span class="text-danger">*</span></label>
                                <select class="select select-step category" id="category" name="" onchange="categoryChangeHandler(this)" required>
                                    <option value="">Select Category</option>
                                        @foreach ($asset_categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    
                                </select>
                                <span id="category_error"></span>
                            </div>
                        </div>
                        <div class="nprf-item flex-75">
                            <div class="input-block erp-step-input-block ">
                                <label class="col-form-label">Item <span class="text-danger">*</span></label>
                                <select class="select select-step product_id" id="product" required>
                                    <option value="">Select Item</option>
                                </select>
                            </div>
                        </div>
                        <div class="nprf-item flex-23">
                            <div class="input-block erp-step-input-block ">
                                <label class="col-form-label">QTY <span class="text-red">*</span></label>
                                <input class="form-control item_qty" id="item_qty" type="text" placeholder="" required>
                            </div>
                        </div>
                        <div class="nprf-item flex-100">
                            <div class="input-block erp-step-input-block ">
                                <label class="col-form-label">Description</label>
                                <textarea rows="1" id="item_desc" class="form-control item_desc"></textarea>
                            </div>
                        </div>
                        {{-- <div class="nprf-item flex-100">
                            <div class="input-block erp-step-input-block ">
                                <label class="col-form-label">File Attachment</label>
                                <input class="form-control file_attachment" id="fileInput" type="file" placeholder="">
                            </div>
                        </div> --}}
                        <div class="nprf-item d-flex justify-content-center mt-3 gap-3 flex-100">
                            <div class="nw-p-add-btn text-center d-inline-block">
                                <button class=" erp-search-btn text-center" onclick="addPurchaseRequestBtn()"><i class="fa-regular fa-floppy-disk me-2"></i>Save</button>
                            </div>
                            <div class="nw-p-add-btn text-center d-inline-block rbtn">
                                <button class=" erp-search-btn text-center"><i class="fa-solid fa-trash me-2"></i>Remove</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>