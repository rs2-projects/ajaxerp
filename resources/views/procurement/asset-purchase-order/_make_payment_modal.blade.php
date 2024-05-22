<form action="{{ route('procurement.asset-purchase-order.make-payment-submit',$purchase->id) }}" id="makePaymentFormSubmit" method="post" enctype="multipart/form-data">
    @csrf
    <div class="modal-content">
        <div class="modal-header erp-modal-header">
            <h5 class="modal-title">Record Payment</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body erp-modal-body">
            <div class="erp-modal-body-content ">
                <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-3 ">
                    <div class="erp-filter-item flex-48">
                        <div class="input-block erp-step-input-block mb-0 two">
                            <label class="col-form-label">Mode Of Payment <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Payment Accounts"><i class="fa-duotone fa-exclamation"></i></span></label>
                            <select class="select select-step payment-method" name="payment_method">
                                @foreach($payment_methods as $key=>$payment_method)
                                    <option value="{{ $key }}">{{ $payment_method }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="erp-filter-item flex-48">
                        <div class="input-block erp-step-input-block mb-0 two">
                            <label class="col-form-label">Payment Account <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Payment Accounts"><i class="fa-duotone fa-exclamation"></i></span></label>
                            <select class="select select-step payment-account" name="account_id" required>
                                <option value="">Select Payment Account</option>

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
                        </div>
                    </div>
                    <input class="form-control" value="{{$purchase->currency_type}}" name="currency_type" type="hidden" >
                    @if($purchase->currency_type == $purchase::CURRENCY_TYPE_USD)
                        <div class="erp-filter-item flex-48" style="margin-top: -20px">
                            <div class="input-block erp-step-input-block mb-0">
                                <label class="col-form-label">PHP Rate</label>
                                <input class="form-control" readonly value="{{$purchase->php_rate}}" id="php_rate" name="php_rate" type="text" >
                            </div>
                        </div>
                    @endif
                    @if ($purchase->currency_type == $purchase::CURRENCY_TYPE_PHP)
                        <input class="form-control" value="{{$purchase->php_rate}}" id="php_rate" name="php_rate" type="hidden" >
                    @endif
                    <div class="erp-filter-item flex-48">
                        <div class="input-block erp-step-input-block mb-0">
                            <label class="col-form-label">Amount {{($purchase->currency_type == $purchase::CURRENCY_TYPE_USD) ? '(USD)' : '(PHP)'}}<span class="text-danger">*</span></label>
                            <input type="number" step="any" class="form-control" required min="0.01" max="{{ $purchase->due_amount }}" value="{{ $purchase->due_amount }}" name="amount" id="amount">
                            @if($purchase->currency_type == $purchase::CURRENCY_TYPE_USD)    
                                <small id="php_amount">PHP Amount: <span id="php_amount_val">{{$purchase->php_rate * $purchase->due_amount}}</span></small>
                            @endif
                        </div>
                    </div>
                    <div class="erp-filter-item {{($purchase->currency_type == $purchase::CURRENCY_TYPE_USD) ? 'flex-100' : 'flex-48'}}">
                        <div class="input-block erp-step-input-block mb-0">
                            <label class="col-form-label">Date <span class="text-danger">*</span></label>
                            <div class="cal-icon">
                                <input class="form-control datetimepicker" required value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" name="date" type="text" >
                            </div>
                        </div>
                    </div>

                    <div class="erp-filter-item flex-100">
                        <div class="input-block erp-step-input-block mb-0">
                            <label class="col-form-label">Note </label>
                            <textarea class="form-control" name="note" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="erp-filter-item flex-100">
                        <div class="multiple-receipt-box d-flex flex-wrap position-relative" id="receiptItemMain">
                            <div class="multiple-receipt-item flex-100">
                                <div class="input-block erp-step-input-block mb-0">
                                    <label class="col-form-label">Upload Receipt <span class="text-danger"> </span></label>
                                    <input type="file" class="form-control" name="receipt[]" placeholder="Upload Receipt">
                                </div>
                            </div>
                            <div class="add-row flex-100 ">
                                <a href="javascript:void(0)" onclick="addReceipt()" class="add-tds ad-more-row-btn"><i class="fa-solid fa-plus"></i></a>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="submit-section mt-2">
                    <button class="btn btn-primary submit-btn" type="submit">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
