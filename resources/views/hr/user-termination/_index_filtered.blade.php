<div class="">
    <table class="table mb-0 erp-table">
        <thead class="erp-thead">
        <tr class="erp-tr">
            <th class="erp-th">SL</th>
            <th class="erp-th">Termination Employee </th>
            <th class="erp-th text-center">Department </th>
            <th class="erp-th text-center">Designation </th>
            <th class="erp-th text-center">Termination Type </th>
            <th class="erp-th text-center">Reason </th>
            <th class="erp-th text-center">Termination Date </th>
            <th class="text-end erp-th">Action</th>
        </tr>
        </thead>
        <tbody class="erp-tbody">
        @foreach($userTerminations as $userTermination)
            <tr class="erp-tbody-tr">
                <td class="erp-tbody-td">
                    <h4 class="d-table-title">{{ $userTerminations->firstItem() + $loop->iteration -1 }}</h4>
                </td>
                <td class="erp-tbody-td">
                    <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100">
                        <div class="em-pro-img-box">
                            <img src="{{ asset($userTermination->user->show_image) }}" alt="">
                        </div>
                        <div class="em-pro-details-box">
                            <h5>{{ $userTermination->user->full_name??'N/A' }}</h5>
                            <p class="em-id">ID: <span> #{{ $userTermination->user->employee_id ?? 'N/A' }}</span></p>

                        </div>
                    </div>
                </td>
                <td class="erp-tbody-td text-center">
                    <h4 class="text-center d-table-title">{{ $userTermination->user->department->name??'N/A' }}</h4>
                </td>
                <td class="erp-tbody-td text-center">
                    <h4 class="text-center d-table-title">{{ $userTermination->user->designation->name??"N/A" }}</h4>

                </td>
                <td class="erp-tbody-td text-center">
                    <h4 class="text-center d-table-title">{{ $userTermination->settingsTerminationType->name??'N/A' }}</h4>

                </td>
                <td class="erp-tbody-td text-center">
                    <h4 class="text-center d-table-title">{{ $userTermination->reason??'N/A' }}</h4>

                </td>
                <td class="erp-tbody-td text-center">
                    <h4 class="text-center d-table-title">{{ getFormattedDate($userTermination->termination_date,'d M, Y') }}</h4>
                </td>


                <td class="text-end erp-tbody-td">
                    @if(hasPermission('manage-employee-termination'))
                        <div class="erp-action-t">
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                <div class="dropdown-menu dropdown-menu-right">

                                    <a class="dropdown-item" href="javascript:void(0)" onclick="editItem({{$userTermination->id}})"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                    <a class="dropdown-item" href="javascript:void(0)" onclick="deleteAjax('{{ route('hr.user-termination.delete',$userTermination->id) }}', 'reloadAjaxGetData')"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>

                                </div>
                            </div>
                        </div>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
{{ $userTerminations->links('vendor.pagination.common_ajax_pagination') }}
