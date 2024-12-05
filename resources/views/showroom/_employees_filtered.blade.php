
<div class="">
    <table class="table mb-0 erp-table">
        <thead class="erp-thead">
            <tr class="erp-tr">
                <th class="erp-th">SL</th>
                <th class="erp-th">Name </th>
                <th class="erp-th text-center">Email</th>
                <th class="erp-th text-center">Phone</th>
                <th class="erp-th text-center">Department</th>
                <th class="erp-th text-center">Designation</th>
                @if(hasPermission('manage-showroom'))
                    <th class="erp-th text-center">Action </th>
                @endif
            </tr>
        </thead>
        <tbody class="erp-tbody">
            @forelse($employees as $employee)
                <tr class="erp-tbody-tr">
                    <td class="erp-tbody-td">
                        <h4 class="d-table-title">{{ $employees->firstItem() + $loop->iteration - 1 }}</h4>
                    </td>
                    <td class="erp-tbody-td">
                        <a href="{{ route('hr.employee.details', $employee->id) }}" target="_blank" class="em-profile-wrap d-flex align-items-center flex-wrap w-100">
                            <div class="em-pro-img-box">
                                <img src="{{ $employee->show_image }}" alt="">
                            </div>
                            <div class="em-pro-details-box">
                                <h5>{{ $employee->full_name }}</h5>
                                <p class="em-id">ID: <span> # {{ $employee->employee_id }}</span></p>
                            </div>
                        </a>
                    </td>
                    <td class="erp-tbody-td text-center">{{ $employee->email }}</td>
                    <td class="erp-tbody-td text-center">{{ $employee->phone }}</td>
                    <td class="erp-tbody-td text-center">{{ $employee->department->name ?? '' }}</td>
                    <td class="erp-tbody-td text-center">{{ $employee->designation->name ?? '' }}</td>
                    @if(hasPermission('manage-showroom'))
                        <td class="text-center erp-tbody-td">
                            <div class="erp-action-t">
                                <a class="text-danger" href="javascript:void(0)" 
                                    onclick="deleteAjax('{{ route('showroom.showroom-employees.remove',['id' => $employee->showroom_id, 'employee_id' => $employee->id]) }}', 'reloadAjaxGetData') ">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    @endif
                </tr>
            @empty
                <tr class="erp-tbody-tr">
                    <td class="erp-tbody-td text-primary text-center  " colspan="7">
                        No data found..!
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $employees->links('vendor.pagination.common_ajax_pagination') }}

