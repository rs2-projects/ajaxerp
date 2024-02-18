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
            <th class="erp-th text-center">Record Payment </th>
            <th class="text-end erp-th">Action</th>
        </tr>
        </thead>
        <tbody class="erp-tbody">
            @foreach($purchase_orders as $purchase_order)
                <tr class="erp-tbody-tr">
                    <td class="erp-tbody-td">
                        <h4 class="d-table-title">{{ $purchase_orders->firstItem() + $loop->iteration -1 }}</h4>
                    </td>
                    <td class="erp-tbody-td text-start">
                        <h4 class="text-start d-table-title"><strong>{{ $purchase_order->purchase_order_id }}</strong></h4>
                        <small class="text-center d-table-title">{{ getFormattedDate($purchase_order->purchase_date, 'd M, Y') }}</small>
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
                        @if($purchase_order->payment_status != $purchase_order::PAYMENT_STATUS_PAID)
                            <a href="javascript:void(0)" onclick="makePayment({{$purchase_order->id}})" class="make-payment-btn">Make Payment</a>
                        @endif
                    </td>
                    <td class="text-end erp-tbody-td">
                        <div class="erp-action-t">
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="javascript:void(0)" onclick="updateStatus(this, function () { getData() })" data-href="{{ route('procurement.asset-purchase-order.change-status',[$purchase_order->id,1]) }}"><i class="fa-solid fa-circle-info m-r-5"></i>Make On Process</a>
                                    @if($purchase_order->payment_status != $purchase_order::PAYMENT_STATUS_PAID)    
                                        <a class="dropdown-item" href="{{ route('procurement.asset-purchase-order.edit',$purchase_order->id) }}"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                    @endif
                                    @if($purchase_order->payment_status == $purchase_order::PAYMENT_STATUS_UNPAID)
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="declinePuchaseRequest('{{ route('procurement.asset-purchase-order.cancel',$purchase_order->id) }}', 'reloadAjaxGetData') "><i class="fa-solid fa-ban m-r-5"></i> Cancel</a>
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="deleteAjax('{{ route('procurement.asset-purchase-order.delete',$purchase_order->id) }}', 'reloadAjaxGetData') "><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $purchase_orders->links('vendor.pagination.common_ajax_pagination') }}
