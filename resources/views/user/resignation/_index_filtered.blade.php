<div class="">
    <table class="table mb-0 erp-table">
        <thead class="erp-thead">
            <tr class="erp-tr">
                <th class="erp-th">SL</th>
                <th class="erp-th text-center">Reason </th>
                <th class="erp-th text-center">Notice Date </th>
                <th class="erp-th text-center">Resignation Date </th>
                <th class="erp-th text-center">Reject Reason </th>
                <th class="erp-th text-center">Rejected At </th>
                <th class="erp-th text-center">Status </th>
                <th class="text-end erp-th">Action</th>
            </tr>
        </thead>
        <tbody class="erp-tbody">
            @foreach($userResignations as $item)
                <tr class="erp-tbody-tr">
                    <td class="erp-tbody-td">
                        <h4 class="d-table-title">1</h4>
                    </td>
                    <td class="erp-tbody-td text-center">
                        <h4 class="text-center d-table-title">{{ $item->reason??'N/A' }}</h4>

                    </td>
                    <td class="erp-tbody-td text-center">
                        <h4 class="text-center d-table-title">{{ getFormattedDate($item->notice_date,'d M, Y') }}</h4>
                    </td>
                    <td class="erp-tbody-td text-center">
                        <h4 class="text-center d-table-title">{{ getFormattedDate($item->resignation_date,'d M, Y') }}</h4>
                    </td>
                    <td class="erp-tbody-td text-center">
                        <h4 class="text-center d-table-title">{{ $item->reject_reason??'' }}</h4>
                    </td>
                    <td class="erp-tbody-td text-center">
                        <h4 class="text-center d-table-title">{{getFormattedDate($item->rejected_at) }}</h4>

                    </td>
                    <td class="erp-tbody-td text-center">
                        <div class="erp-action-t erp-table-status {{'status-'.strtolower($item->resignation_status_text)}}">
                            <div class="dropdown dropdown-action">
                                <a href="javascript:void(0)" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-regular fa-circle-dot me-1"></i> <span>{{ $item->resignation_status_text }}</span></a>
                            </div>
                        </div>
                    </td>
                    <td class="text-end erp-tbody-td">
                        <div class="erp-action-t">
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    @if($item->resignation_status == $item::RESIGNATION_STATUS_PENDING)
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="editItem({{$item->id}})"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="deleteAjax('{{ route('user.resignation.delete',$item->id) }}', 'reloadAjaxGetData')"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
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
{{ $userResignations->links('vendor.pagination.common_ajax_pagination') }}
