<div class="">
    <table class="table mb-0 erp-table">
        <thead class="erp-thead">
        <tr class="erp-tr">
            <th class="erp-th">SL</th>
            <th class="erp-th">Quotation No. </th>
            <th class="erp-th text-center">Customer </th>
            <th class="erp-th text-center">Project Name </th>
            <th class="erp-th text-center">Ref No </th>
            <th class="erp-th text-center">Date </th>
            <th class="erp-th text-center">Amount </th>
            <th class="erp-th text-center">Status </th>
            @if(hasPermission('deliver-items','manage-invoices'))
                <th class="text-end erp-th">Action</th>
            @endif
        </tr>
        </thead>
        <tbody class="erp-tbody">
        @forelse($quotations as $quotation)
        <tr class="erp-tbody-tr">
            <td class="erp-tbody-td">
                <h4 class="d-table-title">{{ $loop->iteration }}</h4>
            </td>
            <td class="erp-tbody-td text-start">
                <h4 class="text-start d-table-title"><strong>Quotation No -</strong> <span>{{ $quotation->quotation_no }}</span></h4>
                <small class="text-center d-table-title">{{ getFormattedDate($quotation->created_at) }}</small>
            </td>
            <td class="erp-tbody-td">
                <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100 justify-content-center">
                    <div class="em-pro-img-box">
                        <img src="{{ $quotation->customer->show_image }}" alt="">
                    </div>
                    <div class="em-pro-details-box">
                        <h5>{{ $quotation->customer->business_name }}</h5>
                    </div>
                </div>
            </td>
            <td class="erp-tbody-td text-center">
                <p>{{ $quotation->project_name }}</p>
            </td>
            <td class="erp-tbody-td text-center">
                <p>{{ $quotation->ref_no }}</p>
            </td>
            <td class="erp-tbody-td text-center">
                <p>{{ $quotation->quotation_date }}</p>
            </td>
            <td class="erp-tbody-td text-center">
                <h4 class="text-center d-table-title"><span class="in-t-amount-text">Total - </span>{{ getCurrencySymbol().formatNumber($quotation->payable_amount) }}</h4>
            </td>
            <td class="erp-tbody-td text-center">
                <h4 class="text-center d-table-title {{formatNstrToClassNameumber($quotation::QUOTATION_STATUSES[$quotation->quotation_status])}}-status">{{ $quotation::QUOTATION_STATUSES[$quotation->quotation_status] }}</h4>
            </td>
            @if(hasPermission('deliver-items','manage-invoices'))
                <td class="text-end erp-tbody-td">
                    <div class="erp-action-t">
                        <div class="dropdown dropdown-action">
                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="{{ route('sales.quotation.convert-to-invoice',$quotation->id) }}"><i class="fa-solid fa-plus m-r-5"></i> Create Invoice</a>
                                <a class="dropdown-item" href="{{ route('sales.quotation.edit',$quotation->id) }}"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                {{-- <a class="dropdown-item" href="javascript:void(0)" onclick="deleteAjax('{{ route('sales.quotation.delete',$quotation->id) }}', 'reloadAjaxGetData') "><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a> --}}
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


{{ $quotations->links('vendor.pagination.common_ajax_pagination') }}
