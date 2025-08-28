<div class="">
    <table class="table mb-0 erp-table">
        <thead class="erp-thead">
        <tr class="erp-tr">
            <th class="erp-th">SL</th>
            <th class="erp-th">Invouce No. </th>
            <th class="erp-th text-center">Customer </th>
            <th class="erp-th text-center">Payment Status </th>
            <th class="erp-th text-center">Invoice Status </th>
            <th class="text-end erp-th">Action</th>
        </tr>
        </thead>
        <tbody class="erp-tbody">
        @forelse($invoices as $invoice)
        <tr class="erp-tbody-tr">
            <td class="erp-tbody-td">
                <h4 class="d-table-title">{{ $loop->iteration }}</h4>
            </td>
            <td class="erp-tbody-td text-start">
                <h4 class="text-start d-table-title"><strong>Invoice No -</strong> <span>{{ $invoice->invoice_no }}</span></h4>
                <small class="text-center d-table-title">{{ getFormattedDate($invoice->created_at) }}</small>
            </td>
            <td class="erp-tbody-td">
                <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100 justify-content-center">
                    <div class="em-pro-img-box">
                        <img src="{{ $invoice->customer->show_image }}" alt="">
                    </div>
                    <div class="em-pro-details-box">
                        <h5>{{ $invoice->customer->business_name }}</h5>
                    </div>
                </div>
            </td>
            <td class="erp-tbody-td text-center">

                <h4 class="text-center d-table-title {{strtolower($invoice::PAYMENT_STATUSES[$invoice->payment_status])}}-status">{{ $invoice::PAYMENT_STATUSES[$invoice->payment_status] }}</h4>
            </td>
            <td class="erp-tbody-td text-center">
                <h4 class="text-center d-table-title {{strtolower($invoice::INVOICE_STATUSES[$invoice->invoice_status])}}-status">{{ $invoice::INVOICE_STATUSES[$invoice->invoice_status] }}</h4>
            </td>
            @if(hasPermission('deliver-items','manage-invoices'))
                <td class="text-end erp-tbody-td">
                    <div class="erp-action-t">
                        <div class="dropdown dropdown-action">
                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                @if(hasPermission('deliver-items'))
                                    @if($invoice->invoice_status == $invoice::INVOICE_STATUS_PENDING || $invoice->invoice_status == $invoice::INVOICE_STATUS_PROCESSING)
                                        <a class="dropdown-item" href="{{ route('inventory.dispatch-invoice-items.deliver',$invoice->id) }}"><i class="la la-hand-o-right m-r-5"></i> Deliver</a>
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
                <td class="erp-tbody-td text-center text-primary" colspan="9">
                    Data not found..!
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

@include('sales.invoice._design_modal')

{{ $invoices->links('vendor.pagination.common_ajax_pagination') }}
