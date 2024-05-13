<!-- Add Category Modal -->
<div id="sell_product_modal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <form action="" id="sellProductStoreForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header erp-modal-header">
                    <h5 class="modal-title">Sell Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body erp-modal-body">
                    <div class="erp-modal-body-content">
                        <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-start justify-content-between mb-3 ">
                            <input type="hidden" name="asset_product_id" id="sell_id" value="">
                            <div class="input-block flex-48 mb-2">
                                <label class="col-form-label">Date <span class="text-danger">*</span></label>
                                <input class="form-control datetimepicker" type="text" name="date" value="{{ now()->format('Y-m-d') }}" required>
                                <span class="name_error ie-span"></span>
                            </div>
                            <div class="input-block flex-48 mb-2">
                                <label class="col-form-label">Account <span class="text-danger">*</span></label>
                                <select class="select floating select2-box" name="account_id" id="account_id" required>
                                    <option value="">Select Account</option>
                                    @if(!empty($accounts_sub_categories))
                                        @foreach($accounts_sub_categories as $accounts_sub_category)
                                            @if(count($accounts_sub_category->accounts) > 0)
                                                <optgroup label="{{ $accounts_sub_category->name }}">
                                                    @foreach($accounts_sub_category->accounts as $account)
                                                        <option value="{{ $account->id }}" {{ ($account->is_default == $account::IS_DEFAULT_YES)?'selected':'' }}>{{ $account->name }}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                                <span class="asset_product_category_id_error ie-span"></span>
                            </div>
                            <div class="input-block flex-48 mb-2">
                                <label class="col-form-label">Category <span class="text-danger">*</span></label>
                                <select class="select select-step" name="category_id" id="acc_cat_id" required>
                                    <option value="">Select Category</option>
                                    @foreach($ppe_sub_category->accounts as $account)
                                        <option value="{{ $account->id }}" {{ ($account->is_default == $account::IS_DEFAULT_YES)?'selected':'' }}>{{ $account->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="input-block flex-48 mb-2">
                                <label class="col-form-label">Qty <span class="text-danger">*</span></label>
                                <input class="form-control" id="sell_qty" name="qty" type="number" min="1" required >
                            </div>

                            <div class="input-block flex-48 mb-2">
                                <label class="col-form-label">Unit Price <span class="text-danger">*</span></label>
                                <input class="form-control" id="unit_sell_price" name="unit_price" type="number" min="1" required >
                            </div>

                            <div class="input-block flex-48 mb-2">
                                <label class="col-form-label">Total Price</label>
                                <input class="form-control" type="text" id="total_sell_price" name="total_price" value="0" readonly>
                                <span class="name_error ie-span"></span>
                            </div>

                            <div class="input-block flex-48 mb-3">
                                <label class="col-form-label">Note <span class="text-danger">*</span></label>
                                <textarea cols="30" rows="3" class="form-control" name="remarks" required></textarea>
                            </div>

                            <div class="input-block flex-48 mb-2">
                                <label class="col-form-label">Attachment</label>
                                <input class="form-control" type="file" name="attachment[]" multiple>
                                <span class="name_error ie-span"></span>
                            </div>
                            <div class="submit-section mt-2">
                                <button class="btn btn-primary submit-btn" type="submit">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- /Add Department Modal -->
