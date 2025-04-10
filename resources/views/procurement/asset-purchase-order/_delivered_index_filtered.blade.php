<div class="">
    <table class="table mb-0 erp-table">
        <thead class="erp-thead">
        <tr class="erp-tr">
            <th class="erp-th">SL</th>
            <th class="erp-th">P.O No </th>
            <th class="erp-th text-center">Delivery Date </th>
            <th class="erp-th text-center">Supplier </th>
            <th class="erp-th text-center">Product </th>
            <th class="erp-th text-center">Total Amount </th>
            <th class="erp-th text-center">Due Amount </th>
            <th class="erp-th text-center">Investigation Status </th>
            <th class="erp-th text-center">Payment Status </th>
            @if(hasPermission( 'manage-asset-product-purchase-orders'))
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
                        <h4 class="text-center d-table-title">{{ getCurrencySymbol() }}{{ formatNumber($purchase_order->payable_amount) }}</h4>

                    </td>
                    <td class="erp-tbody-td text-center">
                        <h4 class="text-center d-table-title">{{ getCurrencySymbol() }}{{ formatNumber($purchase_order->due_amount) }}</h4>

                    </td>
                    <td class="erp-tbody-td text-center">
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
                    </td>
                    <td class="erp-tbody-td text-center">
                        <h4 class="text-center d-table-title {{strtolower($purchase_order::PAYMENT_STATUSES[$purchase_order->payment_status])}}-status">
                            {{ $purchase_order::PAYMENT_STATUSES[$purchase_order->payment_status] }}
                        </h4>
                    </td>
                    @if(hasPermission( 'manage-asset-product-purchase-orders'))
                        <td class="text-end erp-tbody-td">
                            @if($purchase_order->has_missing == $purchase_order::HAS_MISSING_YES || $purchase_order->has_damage == $purchase_order::HAS_DAMAGE_YES)
                                <div class="erp-action-t">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="{{ route('procurement.asset-purchase-order.investigate',$purchase_order->id) }}"><i class="fa-solid fa-circle-info m-r-5"></i>  Received  (Damage / Missing)</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
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
