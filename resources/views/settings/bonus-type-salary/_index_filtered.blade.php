<div class="">
    <table class="table mb-0 erp-table">
        <thead class="erp-thead">
            <tr class="erp-tr">
                <th class="erp-th">SL</th>
                <th class="erp-th">Bonus </th>
                <th class="erp-th text-center">Salary </th>
                <th class="erp-th text-center">Salary Type</th>
                <th class="erp-th text-center">Type</th>
                <th class="erp-th text-center">Rate</th>
                <th class="erp-th text-center">Status </th>
                <th class="text-end erp-th">Action</th>
            </tr>
        </thead>
        <tbody class="erp-tbody">
            @forelse($bonusTypesSalary as $key=> $item)
                <tr class="erp-tbody-tr">
                    <td class="erp-tbody-td">
                        <h4 class="d-table-title">{{ $bonusTypesSalary->firstItem() + $loop->iteration - 1}}</h4>
                    </td>
                    <td class="erp-tbody-td">
                        <h4 class="text-start d-table-title">{{$item->bonusType->title??'N/A'}}</h4>
                    </td>
                    <td class="erp-tbody-td">
                        <h4 class="text-center d-table-title">{{ $item->salaryType->title??'N/A' }}</h4>
                    </td>
                    <td class="erp-tbody-td">
                        <h4 class="text-center d-table-title">{{$item->salary_type_text}}</h4>
                    </td>
                    <td class="erp-tbody-td">
                        <h4 class="text-center d-table-title">{{$item->rate_type_text}}</h4>
                    </td>
                    <td class="erp-tbody-td">
                        <h4 class="text-center d-table-title">{{ formatNumber($item->rate)}}</h4>
                    </td>

                    <td class="erp-tbody-td text-center">
                        <div class="erp-action-t erp-table-status {{ ($item->status == \App\Models\SettingsBonusTypeSalaryBonus::STATUS_ACTIVE) ? 'status-approved' : '' }}">
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-regular fa-circle-dot me-1"></i> <span>{{ $item->status_text }}</span></a>
                                <div class="dropdown-menu dropdown-menu-right">

                                    <a class="dropdown-item" href="javascript:void(0)" onclick="updateStatus(this, function () { getData() })" data-href="{{ route('settings.bonus-type-salary.change-status',[$item->id,1]) }}" ><i class="fa-regular fa-circle-dot m-r-5 "></i> Active</a>
                                    <a class="dropdown-item" href="javascript:void(0)" onclick="updateStatus(this, function () { getData() })" data-href="{{ route('settings.bonus-type-salary.change-status',[$item->id,0]) }}" ><i class="fa-regular fa-circle-dot m-r-5"></i> Inactive</a>


                                </div>
                            </div>
                        </div>

                    </td>

                    <td class="text-end erp-tbody-td">
                        <div class="erp-action-t">
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                <div class="dropdown-menu dropdown-menu-right">

                                    <a class="dropdown-item" href="javascript:void(0)" onclick="editItem({{$item->id}})"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                    <a class="dropdown-item" href="javascript:void(0)" onclick="deleteAjax('{{ route('settings.bonus-type-salary.delete',$item->id) }}', function (res) { getData(); showSuccessAlert(res.message); })"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>

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

{{ $bonusTypesSalary->links('vendor.pagination.common_ajax_pagination') }}

