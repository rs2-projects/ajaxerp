<form action="{{ route('accounting.chart-of-accounts.account-update',$coa_account->id) }}" id="cofAccountUpdateForm" method="post">
    @csrf
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
                                            <option value="{{ $coa_sub_category->id }}" {{ ($coa_sub_category->id == $coa_account->acc_coa_sub_category_id)?'selected':'' }}>{{ $coa_sub_category->name }}</option>
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
                    <input class="form-control " name="account_name" value="{{$coa_account->name}}" type="text" placeholder="" required>
                    <span class="account_name_error ie-span"></span>
                </div>
            </div>
            <div class="nprf-item flex-100 text-center" id="edit_details_btn">
                <a href="javascript:void(0)" onclick="showEditAccountDetails()" class="edit-c-of-acount-link">Edit account ID and description</a>
            </div>
            <div class="chart-of-account-edit-wrapper flex-wrap gap-2 flex-100" id="edit_details_section" style="display: none;">
                <div class="nprf-item flex-100">
                    <div class="input-block erp-step-input-block mb-0">
                        <label class="col-form-label">Account ID</label>
                        <input class="form-control " name="account_no" value="{{ $coa_account->account_no }}" type="text" placeholder="">
                    </div>
                </div>
                <div class="nprf-item flex-100">
                    <div class="input-block erp-step-input-block mb-0">
                        <label class="col-form-label">Description</label>
                        <textarea rows="2" class="form-control" name="description">{!! $coa_account->description !!}</textarea>
                    </div>
                </div>
            </div>

            <div class="nprf-item d-flex justify-content-center mt-3 gap-3 flex-100">
                <div class="nw-p-add-btn text-center d-inline-block">
                    <button class=" erp-search-btn text-center" type="submit"><i class="fa-regular fa-floppy-disk me-2"></i>Save</button>
                </div>

            </div>
        </div>
    </div>
</form>
