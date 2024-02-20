<div class="">
    <table class="table mb-0 erp-table">
        <thead class="erp-thead">
            <tr class="erp-tr">
                <th class="erp-th">SL</th>
                <th class="erp-th">Resigning Employee </th>
                <th class="erp-th text-center">Department </th>
                <th class="erp-th text-center">Designation </th>
                <th class="erp-th text-center">Reason </th>
                <th class="erp-th text-center">Notice Date </th>
                <th class="erp-th text-center">Resignation Date </th>
                <th class="erp-th text-center">Status </th>
                @if(hasPermission('manage-employee-resignation'))
                    <th class="text-end erp-th">Action</th>
                @endif
            </tr>
        </thead>
        <tbody class="erp-tbody">
            @foreach($userResignations as $item)
                <tr class="erp-tbody-tr">
                    <td class="erp-tbody-td">
                        <h4 class="d-table-title">1</h4>
                    </td>
                    <td class="erp-tbody-td">
                        <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100">
                            <div class="em-pro-img-box">
                                <img src="{{ $item->user->show_image }}" alt="">
                            </div>
                            <div class="em-pro-details-box">
                                <h5>{{ $item->user->full_name??'N/A' }}</h5>
                                <p class="em-id">ID: <span> #{{ $item->user->employee_id??'N/A' }}</span></p>

                            </div>
                        </div>
                    </td>
                    <td class="erp-tbody-td text-center">
                        <h4 class="text-center d-table-title">{{ $item->user->department->name??'N/A' }}</h4>
                    </td>
                    <td class="erp-tbody-td text-center">
                        <h4 class="text-center d-table-title">{{ $item->user->designation->name??'N/A' }}</h4>

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
                        <div class="erp-action-t erp-table-status {{'status-'.strtolower($item->resignation_status_text)}}">
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-regular fa-circle-dot me-1"></i> <span>{{ $item->resignation_status_text }}</span></a>
                                {{--<div class="dropdown-menu dropdown-menu-right">

                                    <a class="dropdown-item" href="#" ><i class="fa-regular fa-circle-dot m-r-5 "></i> Approve</a>
                                    <a class="dropdown-item" href="#" ><i class="fa-regular fa-circle-dot m-r-5"></i> Pending</a>

                                </div>--}}
                            </div>
                        </div>
                    </td>
                    @if(hasPermission('manage-employee-resignation'))
                        <td class="text-end erp-tbody-td">
                            <div class="erp-action-t">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="editItem({{$item->id}})"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="updateStatus(this, function () { getData() })" data-href="{{ route('hr.user-resignation.change-status',[$item->id,1]) }}"><i class="fa-solid fa-check m-r-5"></i> Approve</a>
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="rejectItem({{$item->id}})"><i class="fa-solid fa-ban m-r-5"></i> Reject</a>
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="deleteAjax('{{ route('hr.user-resignation.delete',$item->id) }}', 'reloadAjaxGetData')"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>

                                    </div>
                                </div>
                            </div>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $userResignations->links('vendor.pagination.common_ajax_pagination') }}
