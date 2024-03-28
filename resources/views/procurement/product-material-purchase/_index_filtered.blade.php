<div class="">
    <table class="table mb-0 erp-table">
        <thead class="erp-thead">
        <tr class="erp-tr">
            <th class="erp-th">SL</th>
            <th class="erp-th">P.O No </th>
            <th class="erp-th text-center">Estimate Delivery Date </th>
            <th class="erp-th text-center">Supplier </th>
            <th class="erp-th text-center">Product </th>
            <th class="erp-th text-center">Total Amount </th>
            <th class="erp-th text-center">Due Amount </th>
            <th class="erp-th text-center">Payment Status </th>
            <th class="erp-th text-center">Investigation Status </th>
            @if(hasPermission( 'manage-product-material-purchase-orders'))
                <th class="text-end erp-th">Action</th>
            @endif
        </tr>
        </thead>
        <tbody class="erp-tbody">
            @forelse($purchase_orders as $purchase_order)
                <tr class="erp-tbody-tr">
                    <td class="erp-tbody-td">
                        <h4 class="d-table-title">{{ $purchase_orders->firstItem() + $loop->iteration -1 }}</h4>
                    </td>
                    <td class="erp-tbody-td text-start">
                        <h4 class="text-start d-table-title">
                            <a href="{{ route('procurement.product-material-purchase.details', $purchase_order->id) }}"><strong>{{ $purchase_order->purchase_id }}</strong></a>
                        </h4>
                        <small class="text-center d-table-title">{{ getFormattedDate($purchase_order->purchase_date, 'd M, Y') }}</small>
                        @if($purchase_order->purchase_status == $purchase_order::PURCHASE_STATUS_REVISED_OR_BACKED)
                            @if($purchase_order->is_revised == $purchase_order::IS_REVISED_YES && $purchase_order->is_backed == $purchase_order::IS_BACKED_YES)
                                <div class="back-order-status">
                                    <span>Has Backed</span>
                                </div>
                                <div class="revised-status">
                                    <span>Has Revised</span>
                                </div>
                            @elseif($purchase_order->is_revised == $purchase_order::IS_REVISED_YES)
                                <div class="revised-status">
                                    <span>Has Revised</span>
                                </div>
                            @elseif($purchase_order->is_backed == $purchase_order::IS_BACKED_YES)
                                <div class="back-order-status">
                                    <span>Has Backed</span>
                                </div>
                            @endif
                        @elseif($purchase_order->purchase_status == $purchase_order::PURCHASE_STATUS_NEW)
                            @if($purchase_order->purchase_create_type == $purchase_order::PURCHASE_CREATE_TYPE_REVISED)
                                <div class="revised-status">
                                    <span>Revised P.O</span>
                                </div>
                            @elseif($purchase_order->purchase_create_type == $purchase_order::PURCHASE_CREATE_TYPE_BACKED)
                                <div class="back-order-status">
                                    <span>Backed P.O</span>
                                </div>
                            @endif
                        @endif
                    </td>
                    <td class="erp-tbody-td text-center">
                        <h4 class="text-center d-table-title">{{ getFormattedDate($purchase_order->estimated_delivery_date, 'd M, Y') }}</h4>

                    </td>
                    <td class="erp-tbody-td">
                        <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100 justify-content-center">
                            <div class="em-pro-img-box">
                                <img src="{{ asset($purchase_order->supplier->show_image) }}" alt="">
                            </div>
                            <div class="em-pro-details-box">
                                <h5>{{ $purchase_order->supplier->business_name }}</h5>
                            </div>
                        </div>
                    </td>
                    <td class="erp-tbody-td text-center">
                        <h4 class="text-center d-table-title">{{ count($purchase_order->purchaseDetails) }}</h4>

                    </td>
                    <td class="erp-tbody-td text-center">
                        <h4 class="text-center d-table-title">{{ getCurrencySymbol() }}{{ $purchase_order->payable_amount }}</h4>

                    </td>
                    <td class="erp-tbody-td text-center">
                        <h4 class="text-center d-table-title">{{ getCurrencySymbol() }}{{ $purchase_order->due_amount }}</h4>

                    </td>
                    <td class="erp-tbody-td text-center">

                        <h4 class="text-center d-table-title {{strtolower($purchase_order::PAYMENT_STATUSES[$purchase_order->payment_status])}}-status">{{ $purchase_order::PAYMENT_STATUSES[$purchase_order->payment_status] }}</h4>
                    </td>
                    <td class="erp-tbody-td text-center">
                        @if($purchase_order->purchase_status == $purchase_order::PURCHASE_STATUS_NEW)
                            @if(hasPermission( 'product-material-purchase-order-payment' ))
                                <a href="javascript:void(0)" onclick="makePayment({{$purchase_order->id}})" class="make-payment-btn">Make Payment</a>
                            @endif
                        @elseif($purchase_order->purchase_status == $purchase_order::PURCHASE_STATUS_ON_PROCESS)
                            @if($purchase_order->payment_status == $purchase_order::PAYMENT_STATUS_PAID)
                                @if(hasPermission( 'manage-product-material-purchase-orders' ))
                                    <a href="{{ route('procurement.purchase-investigation.index',$purchase_order->id) }}" class="make-payment-btn">Investigation</a>
                                @endif
                            @else
                                @if(hasPermission( 'product-material-purchase-order-payment' ))
                                    <a href="javascript:void(0)" onclick="makePayment({{$purchase_order->id}})" class="make-payment-btn">Make Payment</a>
                                @endif
                            @endif
                        @elseif($purchase_order->purchase_status == $purchase_order::PURCHASE_STATUS_DELIVERED)
                            @if($purchase_order->payment_status == $purchase_order::PAYMENT_STATUS_PAID)
                                @if($purchase_order->has_missing == $purchase_order::HAS_MISSING_YES || $purchase_order->has_damage == $purchase_order::HAS_DAMAGE_YES)
                                    @if($purchase_order->has_missing == $purchase_order::HAS_MISSING_YES)
                                        <h4 class="text-center d-table-title missing-status">Missing</h4>
                                    @endif
                                    @if($purchase_order->has_damage == $purchase_order::HAS_DAMAGE_YES)
                                        <h4 class="text-center d-table-title damage-status">Damage</h4>
                                    @endif
                                @else
                                    <h4 class="text-center d-table-title perfect-status">Perfect</h4>
                                @endif
                            @else
                               N/A
                            @endif
                        @else
                            N/A
                        @endif
                    </td>

                    @if(hasPermission( 'manage-product-material-purchase-orders'))
                        <td class="text-end erp-tbody-td">
                            <div class="erp-action-t">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="printBarcodeData({{ $purchase_order->id }}, 'printer')" ><i class="fa-solid fa-print m-r-5"></i> Print Barcode (Printer)</a>
                                        <a class="dropdown-item"href="javascript:void(0)" onclick="printBarcodeData({{ $purchase_order->id }}, 'pdf')" ><i class="fa-solid fa-print m-r-5"></i> Print Barcode (PDF)</a>
                                            @if(
                                                ($purchase_order->purchase_status == $purchase_order::PURCHASE_STATUS_NEW) ||
                                                (($purchase_order->purchase_status == $purchase_order::PURCHASE_STATUS_DELIVERED) && ($purchase_order->has_missing == $purchase_order::HAS_MISSING_YES || $purchase_order->has_damage == $purchase_order::HAS_DAMAGE_YES)) ||
                                                (($purchase_order->purchase_status == $purchase_order::PURCHASE_STATUS_REVISED_OR_BACKED) && (($purchase_order->is_revised == $purchase_order::IS_REVISED_NO) || ($purchase_order->is_backed == $purchase_order::IS_BACKED_NO)))
                                            )
                                                @if($purchase_order->purchase_status == $purchase_order::PURCHASE_STATUS_NEW)
                                                    @if($purchase_order->payment_status != $purchase_order::PAYMENT_STATUS_PAID)
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="updateStatus(this, function () { getData() })" data-href="{{ route('procurement.product-material-purchase.change-status',[$purchase_order->id,1]) }}"><i class="fa-solid fa-circle-info m-r-5"></i>Make On Process</a>
                                                        @if($purchase_order->purchase_create_type == $purchase_order::PURCHASE_CREATE_TYPE_NEW)
                                                            <a class="dropdown-item" href="{{ route('procurement.product-material-purchase.create-revised-order',$purchase_order->id) }}"><i class="fa-solid fa-circle-info m-r-5"></i>  Create Revised P.O</a>
                                                            <a class="dropdown-item" href="{{ route('procurement.product-material-purchase.create-back-order',$purchase_order->id) }}"><i class="fa-solid fa-circle-info m-r-5"></i>  Create Back P.O</a>
                                                        @endif
                                                        <a class="dropdown-item" href="{{ route('procurement.product-material-purchase.edit',$purchase_order->id) }}"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                                    @endif
                                                    @if($purchase_order->payment_status == $purchase_order::PAYMENT_STATUS_UNPAID)
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="deleteAjax('{{ route('procurement.product-material-purchase.delete',$purchase_order->id) }}', 'reloadAjaxGetData') "><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
                                                    @endif
                                                @elseif($purchase_order->purchase_status == $purchase_order::PURCHASE_STATUS_DELIVERED)
                                                    @if($purchase_order->has_missing == $purchase_order::HAS_MISSING_YES || $purchase_order->has_damage == $purchase_order::HAS_DAMAGE_YES)
                                                        <a class="dropdown-item" href="{{ route('procurement.purchase-investigation.index',$purchase_order->id) }}"><i class="fa-solid fa-circle-info m-r-5"></i>  Received  (Damage / Missing)</a>
                                                    @endif
                                                @elseif($purchase_order->purchase_status == $purchase_order::PURCHASE_STATUS_REVISED_OR_BACKED)
                                                    @if($purchase_order->is_revised == $purchase_order::IS_REVISED_NO)
                                                        <a class="dropdown-item" href="{{ route('procurement.product-material-purchase.create-revised-order',$purchase_order->id) }}"><i class="fa-solid fa-circle-info m-r-5"></i>  Create Revised P.O</a>
                                                    @endif

                                                    @if($purchase_order->is_backed == $purchase_order::IS_BACKED_NO)
                                                        <a class="dropdown-item" href="{{ route('procurement.product-material-purchase.create-back-order',$purchase_order->id) }}"><i class="fa-solid fa-circle-info m-r-5"></i>  Create Back P.O</a>
                                                    @endif
                                                @endif
                                            @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                    @endif
                </tr>
            @empty
                <tr class="erp-tbody-tr">
                    <td class="erp-tbody-td text-center text-primary" colspan="10">
                        Data not found..!
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $purchase_orders->links('vendor.pagination.common_ajax_pagination') }}
