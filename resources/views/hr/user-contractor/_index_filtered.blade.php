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
            <th class="erp-th text-center">Notice Date </th>

            <th class="text-end erp-th">Action</th>
        </tr>
        </thead>
        <tbody class="erp-tbody">
        @foreach($userContractors as $userContractor)
            <tr class="erp-tbody-tr">
                <td class="erp-tbody-td">
                    <h4 class="d-table-title">{{ $userContractor->total() + $loop->iteration -1 }}</h4>
                </td>
                <td class="erp-tbody-td">
                    <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100">
                        <div class="em-pro-img-box">
                            <img src="{{ asset($userContractor->show_image) }}" alt="">
                        </div>
                        <div class="em-pro-details-box">
                            <h5>{{ $userContractor->name??'N/A' }}</h5>
                            <p class="em-id">Com: <span> #{{ $userContractor->company_name ?? 'N/A' }}</span></p>
                        </div>
                    </div>
                </td>
                <td class="erp-tbody-td text-center">
                    <h4 class="text-center d-table-title">{{ $userContractor->email??'N/A' }}</h4>
                </td>
                <td class="erp-tbody-td text-center">
                    <h4 class="text-center d-table-title">{{ $userContractor->phone??"N/A" }}</h4>

                </td>
                <td class="erp-tbody-td text-center">
                    <h4 class="text-center d-table-title">{{ $userContractor->contract_value??'N/A' }}</h4>

                </td>
                <td class="erp-tbody-td text-center">
                    <h4 class="text-center d-table-title">{{ $userContractor->phone2??'N/A' }}</h4>

                </td>
                <td class="erp-tbody-td text-center">
                    <h4 class="text-center d-table-title">{{ $userContractor->company_address??'N/A' }}</h4>
                </td>


                <td class="text-end erp-tbody-td">
                    <div class="erp-action-t">
                        <div class="dropdown dropdown-action">
                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                            <div class="dropdown-menu dropdown-menu-right">

                                <a class="dropdown-item" href="javascript:void(0)" onclick="editItem({{$userContractor->id}})"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                <a class="dropdown-item" href="javascript:void(0)" onclick="deleteAjax('{{ route('hr.user-contractor.delete',$userContractor->id) }}', 'reloadAjaxGetData')"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>

                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
{{ $userContractors->links('vendor.pagination.common_ajax_pagination') }}
