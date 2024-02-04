<!-- Add a  account Modal -->
<div id="addAccountModal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered " role="document">
        <form action="{{ route('accounting.chart-of-accounts.account-store') }}" id="cofAccountStoreForm" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header erp-modal-header">
                    <h5 class="modal-title">Add an Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body erp-modal-body p-0">
                    <div class="warehouse-basic-info bg-card ">

                        <div class="new-purchase-request-form-wrapper mt-1 d-flex flex-wrap gap-2">
                            <div class="nprf-item flex-100">
                                <div class="input-block erp-step-input-block mb-0">
                                    <label class="col-form-label">Account Type  <span class="text-danger">*</span></label>
                                    <select class="select select-step" required name="acc_coa_sub_category_id" id="acc_coa_sub_category_id">
                                        @if(!empty($coa_categories))
                                            @foreach($coa_categories as $coa_category)
                                                @if(!empty($coa_category->subcategories))
                                                    <optgroup label="{{ $coa_category->name }}">
                                                        @foreach($coa_category->subcategories as $coa_sub_category)
                                                            <option value="{{ $coa_sub_category->id }}">{{ $coa_sub_category->name }}</option>
                                                        @endforeach
                                                    </optgroup>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="acc_coa_sub_category_id_error ie-span"></span>
                                </div>
                            </div>
                            <div class="nprf-item flex-100">
                                <div class="input-block erp-step-input-block mb-0">
                                    <label class="col-form-label">Account Name <span class="text-red">*</span></label>
                                    <input class="form-control " name="account_name" type="text" placeholder="" required>
                                    <span class="account_name_error ie-span"></span>
                                </div>
                            </div>
                            <div class="nprf-item flex-100">
                                <div class="input-block erp-step-input-block mb-0">
                                    <label class="col-form-label">Account ID </label>
                                    <input class="form-control " name="account_no" type="text" placeholder="" >
                                </div>
                            </div>

                            <div class="nprf-item flex-100">
                                <div class="input-block erp-step-input-block mb-0">
                                    <label class="col-form-label">Description</label>
                                    <textarea rows="2" name="description" class="form-control"></textarea>
                                </div>
                            </div>

                            <div class="nprf-item d-flex justify-content-center mt-3 gap-3 flex-100">
                                <div class="nw-p-add-btn text-center d-inline-block">
                                    <button class="erp-search-btn text-center" type="submit"><i class="fa-regular fa-floppy-disk me-2"></i>Save</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
