
<div class="big-table pt-4">
    <div class="de-table-wrapper">
        <h4>Product Requisition</h4>
        <div class="table-responsives">
            <table class="table mb-0 erp-table">
                <thead class="erp-thead">
                    <tr class="erp-tr">
                        <th class="erp-th">SL</th>
                        <th class="erp-th">Requisition No </th>
                        <th class="erp-th text-center">Description </th>
                        <th class="erp-th text-center">Delvery Status</th>
                        <th class="erp-th text-center">Receive Status</th>
                        <th class="erp-th text-center">Action </th>
                    </tr>
                </thead>
                <tbody class="erp-tbody">
                    @forelse($requisitions as $data)
                        <tr class="erp-tbody-tr">
                            <td class="erp-tbody-td">
                                <h4 class="d-table-title">{{ $requisitions->firstItem() + $loop->iteration - 1 }}</h4>
                            </td>
                            <td class="erp-tbody-td text-start">
                                <a href="{{ route('inventory.material-request.product-requisition.deliver', $data->id) }}" class="em-profile-wrap d-flex align-items-center flex-wrap w-100">
                                    
                                    <div class="em-pro-details-box">
                                        <h5>#{{ $data->requisition_no }}</h5>
                                    </div>
                                </a>
                            </td>
                            <td class="erp-tbody-td text-center">
                                <h4 class="text-center d-table-title">{{ $data->description ?? '-' }}</h4>
                            </td>
                            <td class="erp-tbody-td text-center">
                                <span class="delivery-status status-{{ strToClassName($data::DELIVERY_STATUSES[$data->delivery_status] ?? '') }}">
                                    {{ $data::DELIVERY_STATUSES[$data->delivery_status] ?? '' }}
                                </span>
                            </td>
                            <td class="erp-tbody-td text-center">
                                <span class="delivery-status status-{{ strToClassName($data::RECEIVED_STATUSES[$data->received_status] ?? '') }}">
                                    {{ $data::RECEIVED_STATUSES[$data->received_status] ?? '' }}
                                </span>
                            </td>
                            <td class="text-end erp-tbody-td">
                                <div class="erp-action-t">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="{{ route('inventory.material-request.product-requisition.deliver', $data->id) }}" ><i class="la la-hand-o-right m-r-5"></i> Deliver</a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="erp-tbody-tr">
                            <td class="erp-tbody-td text-center text-primary" colspan="8">
                                No data found...!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{ $requisitions->links('vendor.pagination.common_ajax_pagination') }}
