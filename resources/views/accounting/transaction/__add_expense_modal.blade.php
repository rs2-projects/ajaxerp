<!-- Add expense Modal -->
<div id="cofa_expense" class="modal custom-modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header erp-modal-header">
                <h5 class="modal-title">Add Expense</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body erp-modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('accounting.transaction.expense.store') }}" method="post" id="expenseStoreForm">
                            @csrf
                            <div class="erp-salary-tab-offcanvas">
                                <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-3 ">
                                    <div class="erp-filter-item flex-48">
                                        <div class="input-block erp-step-input-block mb-0">
                                            <label class="col-form-label"> Date <span class="text-red">*</span></label>
                                            <div class="cal-icon"><input class="form-control datetimepicker" name="date" required type="text"></div>
                                            <span class="date_error ie-span"></span>
                                        </div>
                                    </div>
                                    <div class="erp-filter-item flex-48">
                                        <div class="input-block erp-step-input-block mb-0 two">
                                            <label class="col-form-label">Account <span class="text-red">*</span></label>
                                            <select class="select select-step" name="account" required>
                                                @if(!empty($account_sub_categories))
                                                    @foreach($account_sub_categories as $account_sub_category)
                                                        @if(count($account_sub_category->accounts) > 0)
                                                            <optgroup label="{{ $account_sub_category->name }}">
                                                                @foreach($account_sub_category->accounts as $account)
                                                                    <option value="{{ $account->id }}" {{ ($account->is_default == 1)?'selected':'' }}>{{ $account->name }}</option>
                                                                @endforeach
                                                            </optgroup>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                            <span class="account_error ie-span"></span>
                                        </div>
                                    </div>
                                    <div class="erp-filter-item flex-48">
                                        <div class="input-block erp-step-input-block mb-0 two">
                                            <label class="col-form-label">Category <span class="text-red">*</span></label>
                                            <select class="select select-step" name="category" required>
                                                @if(!empty($expense_sub_categories))
                                                    @foreach($expense_sub_categories as $expense_sub_category)
                                                        @if(count($expense_sub_category->accounts) > 0)
                                                            <optgroup label="{{ $expense_sub_category->name }}">
                                                                @foreach($expense_sub_category->accounts as $expense_account)
                                                                    <option value="{{ $expense_account->id }}" {{ ($expense_account->is_default == 1)?'selected':'' }}>{{ $expense_account->name }}</option>
                                                                @endforeach
                                                            </optgroup>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                            <span class="category_error ie-span"></span>
                                        </div>
                                    </div>
                                    <div class="erp-filter-item flex-48">
                                        <div class="input-block mb-0 erp-step-input-block ">
                                            <label class="col-form-label">Amount <span class="text-red">*</span></label>
                                            <input type="text" class="form-control" name="amount" required min="1" placeholder="Enter Amount">
                                            <span class="amount_error ie-span"></span>
                                        </div>
                                    </div>
                                    <div class="erp-filter-item flex-48">
                                        <div class="input-block erp-step-input-block mb-0 two">
                                            <label class="col-form-label">Tax <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Product Tax"><i class="fa-duotone fa-exclamation"></i></span></label>
                                            <select class="select select-step" name="vat_tax">
                                                <option value="">Select Tax Value</option>
                                                @if(!empty($vat_taxes))
                                                    @foreach($vat_taxes as $vat_tax)
                                                        <option value="{{ $vat_tax->id }}" >{{ $vat_tax->name }} ( {{ $vat_tax->tax_rate }}% )</option>
                                                    @endforeach
                                                @endif
                                                <span class="vat_tax_error ie-span"></span>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="erp-filter-item flex-48">
                                        <div class="input-block mb-0 erp-step-input-block ">
                                            <label class="col-form-label">Upload Receipt <span class="text-red">*</span> </label>
                                            <input type="file" class="form-control " name="receipts[]" multiple>
                                            <span class="receipts_error ie-span"></span>
                                        </div>
                                    </div>


                                    <div class="erp-filter-item flex-100">
                                        <div class="input-block mb-0 erp-step-input-block ">
                                            <label class="col-form-label">Description <span class="text-red">*</span></label>
                                            <textarea class="form-control" rows="3" name="description"></textarea>
                                            <span class="description_error ie-span"></span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-3 flex-100">

                                <div class="erp-filter-item flex-100 mt-4">
                                    <div class="erp-search-btn-wrap text-center">
                                        <button type="submit" class="erp-search-btn text-center">Save Expense</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
<!-- /Add expense Modal -->
