<div class="big-table pt-4">
    <div class="de-table-wrapper">
        <div class="">
            <table class="table mb-0 erp-table">
                <thead class="erp-thead">
                <tr class="erp-tr">
                    <th class="erp-th">SL</th>
                    <th class="erp-th text-center">Date </th>
                    <th class="erp-th text-center">Description </th>
                    <th class="erp-th text-center">Account  </th>
                    <th class="erp-th text-center">Category </th>
                    <th class="erp-th text-center">Amount </th>
                    @if(hasPermission('verify-transactions'))
                        <th class="erp-th text-center">Verification </th>
                    @endif
                    @if(hasPermission('manage-transactions'))
                        <th class="erp-th text-center">Action </th>
                    @endif
                </tr>
                </thead>
                <tbody class="erp-tbody">
                @forelse($transactions as $transaction)
                    <tr class="erp-tbody-tr">
                        <td class="erp-tbody-td">
                            <h4 class="d-table-title">{{ $loop->iteration }}</h4>
                        </td>
                        <td class="erp-tbody-td text-center">
                            <h4 class="text-center d-table-title">{{ getFormattedDate($transaction->transaction_date) }}</h4>
                            @if($transaction->reference_type == \App\Models\Accounting\Transaction::REFERENCE_TYPE_INCOME)
                                <h4 class="text-center d-table-title cofa-status-income">Income</h4>
                            @elseif($transaction->reference_type == \App\Models\Accounting\Transaction::REFERENCE_TYPE_EXPENSE)
                                <h4 class="text-center d-table-title cofa-status-expense">Expense</h4>
                            @else
                                <h4 class="text-center d-table-title cofa-status-transfer">{{ \App\Models\Accounting\Transaction::REFERENCE_TYPES[$transaction->reference_type] ?? '' }}</h4>
                            @endif
                        </td>
                        <td class="erp-tbody-td text-center" style="width: 25%;word-break: break-word; white-space: normal;">
                            @if($transaction->reference_type == \App\Models\Accounting\Transaction::REFERENCE_TYPE_INVOICE_PAYMENT)
                                <h4 class="text-center d-table-title">
                                    {{ $transaction->reference_description }}
                                </h4>
                            @elseif($transaction->reference_type == \App\Models\Accounting\Transaction::REFERENCE_TYPE_RETURN_INVOICE_PAYMENT)
                                <h4 class="text-center d-table-title">
                                    {{ $transaction->reference_description }}
                                </h4>
                            @elseif($transaction->reference_type == \App\Models\Accounting\Transaction::REFERENCE_TYPE_ASSET_PRODUCT_PURCHASE_PAYMENT)
                                <h4 class="text-center d-table-title">
                                    {{ $transaction->reference_description }}
                                </h4>
                            @elseif($transaction->reference_type == \App\Models\Accounting\Transaction::REFERENCE_TYPE_PRODUCT_MATERIAL_PURCHASE_PAYMENT)
                                <h4 class="text-center d-table-title">
                                    {{ $transaction->reference_description }}
                                </h4>
                            @elseif($transaction->reference_type == \App\Models\Accounting\Transaction::REFERENCE_TYPE_TRANSFER)
                                <h4 class="text-center d-table-title">
                                    {{ $transaction->reference_description }}
                                </h4>
                            @else
                                <p title="{{ $transaction->description }}">{{ getRealSubStr($transaction->description, 30) }}</p>
                            @endif
                            <h4 class="text-center d-table-title"></h4>
                        </td>

                        <td class="erp-tbody-td text-center">
                            <h4 class="text-center d-table-title">{{ $transaction->account->name }}</h4>
                        </td>
                        <td class="erp-tbody-td text-center">
                            <h4 class="text-center d-table-title">{{ $transaction->category->name }}</h4>
                        </td>
                        <td class="erp-tbody-td text-center">
                            <h4 class="text-center d-table-title">{{ getCurrencySymbol() }} {{ formatNumber($transaction->total_amount) }}</h4>
                        </td>

                        @if(hasPermission('verify-transactions'))
                            <td class="erp-tbody-td text-center">
                                <div class="checkbox-wrapper">
                                    <input id="terms-checkbox-{{ $loop->iteration }}" onchange="reviewTransaction(this, {{ $transaction->id }})" name="checkbox" type="checkbox" value="1" {{ ($transaction->is_reviewed == \App\Models\Accounting\Transaction::IS_REVIEWED_YES)?'checked':'' }}>
                                    <label class="terms-label" for="terms-checkbox-{{ $loop->iteration }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 200 200" class="checkbox-svg">
                                            <mask fill="white" id="path-1-inside-1_476_5-37">
                                                <rect height="200" width="200"></rect>
                                            </mask>
                                            <rect mask="url(#path-1-inside-1_476_5-37)" stroke-width="40" class="checkbox-box" height="200" width="200"></rect>
                                            <path stroke-width="15" d="M52 111.018L76.9867 136L149 64" class="checkbox-tick"></path>
                                        </svg>
                                        <span class="label-text">Check</span>
                                    </label>
                                </div>
                            </td>
                        @endif

                        @if(hasPermission('manage-transactions'))
                            <td class="text-end erp-tbody-td">
                                <div class="erp-action-t">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            {{-- @if($transaction->reference_type == \App\Models\Accounting\Transaction::REFERENCE_TYPE_EXPENSE)
                                                <a class="dropdown-item" href="javascript:void(0)" onclick="editExpense({{ $transaction->id }})"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                                <a class="dropdown-item" href="javascript:void(0)" onclick="deleteExpense({{ $transaction->id }})"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
                                            @else
                                                <a class="dropdown-item" href="javascript:void(0)" onclick="showInfoAlert('','Not Implemented Yet!')"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                                <a class="dropdown-item" href="javascript:void(0)" onclick="showInfoAlert('','Not Implemented Yet!')"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
                                            @endif --}}

                                            @php
                                                $delete_message = 'Are you sure to delete this transaction?';

                                                if ($transaction->reference_type == \App\Models\Accounting\Transaction::REFERENCE_TYPE_PRODUCT_MATERIAL_PURCHASE_PAYMENT) {
                                                    $status = $transaction->materialPurchasePayment?->materialPurchase?->purchase_status;

                                                    if ($status == \App\Models\Procurements\ProductMaterialPurchase::PURCHASE_STATUS_DELIVERED) {
                                                        $delete_message = 'Deleting this transaction will reset the purchase state from Delivered to On Process, also the purchase quantity will be deducted from the inventory. Are you sure to delete this transaction?';
                                                    } elseif ($status == \App\Models\Procurements\ProductMaterialPurchase::PURCHASE_STATUS_ON_PROCESS) {
                                                        $delete_message = 'Deleting this transaction may change the purchase status from On Process to New. Are you sure to delete this transaction?';
                                                    } else {
                                                        $delete_message = 'Are you sure to delete this product material purchase payment transaction?';
                                                    }
                                                }
                                            @endphp

                                            @if($transaction->reference_type == \App\Models\Accounting\Transaction::REFERENCE_TYPE_EXPENSE)
                                                <a class="dropdown-item" href="javascript:void(0)" onclick="editExpense({{ $transaction->id }})"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                            @endif
                                            <a class="dropdown-item" href="javascript:void(0)" onclick="deleteTransaction({{ $transaction->id }}, '{{ $transaction->reference_type }}', {!! json_encode($delete_message) !!})"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
                                            
                                        </div>
                                    </div>
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No Data Found !</td>
                    </tr>
                @endforelse


                </tbody>
            </table>
        </div>
    </div>
</div>


{{ $transactions->links('vendor.pagination.common_ajax_pagination') }}
