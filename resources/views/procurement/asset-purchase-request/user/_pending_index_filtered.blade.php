<div class="">
    <table class="table mb-0 erp-table">
        <thead class="erp-thead">
        <tr class="erp-tr">
            <th class="erp-th">SL</th>
            <th class="erp-th">Purchase Request # </th>
            <th class="erp-th text-center">Title </th>
            <th class="erp-th text-center">Remarks </th>
            <th class="erp-th text-center">Status </th>
            <th class="text-center erp-th">Requested Info</th>
        </tr>
        </thead>
        <tbody class="erp-tbody">
            @foreach($pending_requests as $pr)
                <tr class="erp-tbody-tr">
                    <td class="erp-tbody-td">
                        <h4 class="d-table-title">{{ $pending_requests->firstItem() + $loop->iteration -1 }}</h4>
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
                    <td class="text-center erp-tbody-td">
                        @if($pr->request_status == $pr::REQUEST_STATUS_ADDITIONAL_INFO)
                        <a href="" class="text-center d-table-title add-more-status">Add More Info</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $pending_requests->links('vendor.pagination.common_ajax_pagination') }}
