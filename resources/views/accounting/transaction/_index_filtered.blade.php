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
                    <th class="erp-th text-center">Verification </th>
                    <th class="erp-th text-center">Action </th>
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
                            @endif
                        </td>
                        <td class="erp-tbody-td text-center">
                            @if($transaction->reference_type == \App\Models\Accounting\Transaction::REFERENCE_TYPE_INVOICE_PAYMENT)
                                <h4 class="text-center d-table-title">
                                    {{ $transaction->reference_description }}
                                </h4>
                            @elseif($transaction->reference_type == 'return_invoice_payment')
                                <h4 class="text-center d-table-title">
                                    {{ $transaction->reference_description }}
                                </h4>
                            @elseif($transaction->reference_type == 'purchase_payment')
                                <h4 class="text-center d-table-title">
                                    {{ $transaction->reference_description }}
                                </h4>
                            @elseif($transaction->reference_type == 'transfer')
                                <p>
                                    {{ $transaction->reference_description }}
                                </p>
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
                            <h4 class="text-center d-table-title">{{ getCurrencySymbol() }} {{ $transaction->total_amount }}</h4>
                        </td>


                        <td class="erp-tbody-td text-center">
                            <div class="checkbox-wrapper">
                                <input id="terms-checkbox-{{ $loop->iteration }}" name="checkbox" type="checkbox" value="1" {{ ($transaction->is_reviewed == \App\Models\Accounting\Transaction::IS_REVIEWED_YES)?'checked':'' }}>
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


                        <td class="text-end erp-tbody-td">
                            <div class="erp-action-t">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">

                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_employee"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_resignation"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>

                                    </div>
                                </div>
                            </div>
                        </td>
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
