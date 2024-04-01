

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
                <th class="erp-th text-center">Action</th>
            </tr>
        </thead>
        <tbody class="erp-tbody">
            @forelse($employees as $item)
                <tr class="erp-tbody-tr">
                    <td class="erp-tbody-td">
                        <h4 class="d-table-title">{{ $employees->firstItem() + $loop->iteration - 1 }}</h4>
                    </td>
                    <td class="erp-tbody-td text-start">
                        <a href="{{ route('hr.employee.details',$item->id) }}" class="em-profile-wrap d-flex align-items-center flex-wrap w-100">
                            <div class="em-pro-img-box">
                                <img src="{{ $item->show_image }}" alt="">
                            </div>
                            <div class="em-pro-details-box">
                                <h5>{{ $item->full_name??'N/A' }}</h5>
                                <p class="em-id">ID: <span> #{{ $item->employee_id??'N/A' }}</span></p>
        
                            </div>
                        </a>
                    </td>
                    <td class="erp-tbody-td text-center">{{ $item->email??'N/A' }}</td>
                    <td class="erp-tbody-td text-center">{{ $item->phone??'N/A' }}</td>
                    <td class="erp-tbody-td text-center">{{ $item->department->name??'N/A' }}</td>
                    <td class="erp-tbody-td text-center">{{ $item->designation->name??'N/A' }}</td>

                    <td class="text-end erp-tbody-td">
                        <div class="erp-action-t">
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="{{ route('hr.employee.details', $item->id) }}"><i class="la la-puzzle-piece m-r-5"></i> Details</a>
                                    @if(hasPermission('manage-employees'))
                                        <a class="dropdown-item" href="{{ route('hr.employee.edit',$item->id) }}"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="editRole({{$item->id}})"><i class="fa-regular fa-circle-user m-r-5"></i> Change Role</a>
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="deleteAjax('{{ route('hr.employee.delete',$item->id) }}', 'reloadAjaxGetData')"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
                                        <a class="dropdown-item" href="#"><i class="la la-crosshairs m-r-5"></i> Attendance</a>
                                        <a class="dropdown-item" href="#"><i class="la la-question m-r-5"></i> Leave</a>
                                    @endif
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

{{ $employees->links('vendor.pagination.common_ajax_pagination') }}

