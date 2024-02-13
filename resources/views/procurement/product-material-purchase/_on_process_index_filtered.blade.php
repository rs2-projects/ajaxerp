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
                        <h4 class="text-start d-table-title"><strong>{{ $purchase_order->purchase_id }}</strong></h4>
                        <small class="text-center d-table-title">{{ getFormattedDate($purchase_order->purchase_date, 'd M, Y') }}</small>
                        @if($purchase_order->is_revised == $purchase_order::IS_REVISED_YES)
                            <div class="revised-status">
                                <span>Revised Order</span>
                            </div>
                        @elseif($purchase_order->is_backed == $purchase_order::IS_BACKED_YES)
                            <div class="back-order-status">
                                <span>Back Order</span>
                            </div>
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
                        @if($purchase_order->payment_status == $purchase_order::PAYMENT_STATUS_PAID)
                            <a href="{{ route('procurement.purchase-investigation.index',$purchase_order->id) }}" class="make-payment-btn">Investigation</a>
                        @else
                            <a href="javascript:void(0)" onclick="makePayment({{$purchase_order->id}})" class="make-payment-btn">Make Payment</a>
                        @endif
                    </td>


                    <td class="text-end erp-tbody-td">
                        <div class="erp-action-t">
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                {{--<div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_resignation"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>

                                </div>--}}
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $purchase_orders->links('vendor.pagination.common_ajax_pagination') }}
