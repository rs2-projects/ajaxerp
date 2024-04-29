

<div class="">
    <table class="table mb-0 erp-table">
        <thead class="erp-thead">
            <tr class="erp-tr">
                <th class="erp-th">SL</th>
                <th class="erp-th">Title</th>
                <th class="erp-th text-center">User Name</th>
                <th class="erp-th text-center">Status</th>
                <th class="erp-th text-center">Action </th>
            </tr>
        </thead>
        <tbody class="erp-tbody">
            @forelse($staffs as $data)
                <tr class="erp-tbody-tr">
                    <td class="erp-tbody-td">
                        <h4 class="d-table-title">{{ $staffs->firstItem() + $loop->iteration - 1 }}</h4>
                    </td>
                    <td class="erp-tbody-td text-center">{{ $data->title??'N/A' }}</td>
                    <td class="erp-tbody-td text-center">{{ $data->user_name??'N/A' }}</td>
                    <td class="erp-tbody-td text-center">
                        <div class="erp-action-t erp-table-status {{ ($data->status == $data::STATUS_ACTIVE) ? 'status-approved' : '' }}">
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-regular fa-circle-dot me-1"></i> <span>{{$data::STATUSES[$data->status]}}</span></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="javascript:void(0)" onclick="updateStatus(this, function () { getData() })" data-href="{{ route('production.production-staff.change-status',[$data->id,1]) }}"><i class="fa-regular fa-circle-dot m-r-5 "></i> Active</a>
                                    <a class="dropdown-item" href="javascript:void(0)" onclick="updateStatus(this, function () { getData() })" data-href="{{ route('production.production-staff.change-status',[$data->id,0]) }}"><i class="fa-regular fa-circle-dot m-r-5"></i> Inactive</a>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="text-end erp-tbody-td">
                        <div class="erp-action-t">
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="javascript:void(0)" onclick="editItem({{$data->id}})"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                    <a class="dropdown-item" href="javascript:void(0)" onclick="deleteAjax('{{ route('production.production-staff.delete',$data->id) }}', 'reloadAjaxGetData') "><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr class="erp-tbody-tr">
                    <td class="erp-tbody-td text-center text-primary" colspan="6">
                        No data found...!
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $staffs->links('vendor.pagination.common_ajax_pagination') }}

