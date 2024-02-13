<div class="">
    <table class="table mb-0 erp-table">
        <thead class="erp-thead">
        <tr class="erp-tr">
            <th class="erp-th">SL</th>
            <th class="erp-th">Purchase Request # </th>
            <th class="erp-th text-center">Title </th>
            <th class="erp-th text-center">Remarks </th>
            <th class="erp-th text-center">Status </th>
            <th class="text-end erp-th">Action</th>
        </tr>
        </thead>
        <tbody class="erp-tbody">
            @foreach($new_requests as $pr)
                <tr class="erp-tbody-tr">
                    <td class="erp-tbody-td">
                        <h4 class="d-table-title">{{ $new_requests->firstItem() + $loop->iteration -1 }}</h4>
                    </td>
                    <td class="erp-tbody-td text-start">
                        <h4 class="text-start d-table-title"><strong>{{ $pr->purchase_request_id }}</strong></h4>
                        <small class="text-center d-table-title">{{ getFormattedDate($pr->created_at, 'd M, Y') }}</small> 
                    </td>
                    <td class="erp-tbody-td text-center">
                        <h4 class="text-center d-table-title">{{ $pr->title }}</h4>
                    </td>
                    <td class="erp-tbody-td text-center">
                        <h4 class="text-center d-table-title">{{ $pr->description }}</h4>
                    </td>
                    <td class="erp-tbody-td text-center">

                        <h4 class="text-center d-table-title {{strtolower($pr::REQUEST_STATUSES[$pr->request_status])}}-status">{{ $pr::REQUEST_STATUSES[$pr->request_status] }}</h4>
                    </td>

                    <td class="text-end erp-tbody-td">
                        <div class="erp-action-t">
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="getRequestDetails({{$pr->id}})"><i class="fa-solid fa-circle-info m-r-5"></i> View Details</a>
                                    {{-- <a class="dropdown-item" href="{{ route('procurement.admin.asset-purchase-request.edit',$pr->id) }}"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a> --}}
                                    <a class="dropdown-item" href="javascript:void(0)" onclick="deleteAjax('{{ route('procurement.admin.asset-purchase-request.delete',$pr->id) }}', 'reloadAjaxGetData') "><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $new_requests->links('vendor.pagination.common_ajax_pagination') }}
