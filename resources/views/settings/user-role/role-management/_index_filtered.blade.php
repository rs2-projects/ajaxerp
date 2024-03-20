
<div class="">
    <table class="table mb-0 erp-table">
        <thead class="erp-thead">
            <tr class="erp-tr">
                <th class="erp-th">SL</th>
                <th class="erp-th">Role </th>
                <th class="erp-th text-center">Description</th>
                <th class="erp-th text-center">Is Default</th>
                <th class="erp-th text-center">Status</th>
                <th class="erp-th text-center">Action </th>
            </tr>
        </thead>
        <tbody class="erp-tbody">
            @forelse($roles as $role)
                <tr class="erp-tbody-tr">
                    <td class="erp-tbody-td">
                        <h4 class="d-table-title">{{ $roles->firstItem() + $loop->iteration - 1 }}</h4>
                    </td>
                    <td class="erp-tbody-td text-center">{{ $role->title??'N/A' }}</td>
                    <td class="erp-tbody-td text-center">{{ $role->description??'N/A' }}</td>
                    <td class="erp-tbody-td text-center">{{ $role->is_default == $role::IS_DEFAULT_YES ? 'Yes': 'No' }}</td>

                    <td class="erp-tbody-td text-center">
                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                            <input type="checkbox" id="p-{{ $roles->firstItem() + $loop->iteration - 1 }}" class="check"
                                {{ $role->is_default == $role::IS_DEFAULT_YES ? 'checked' : '' }}
                                data-role-id="{{ $role->id }}" onchange="statusUpdate(this)"
                                {{ $role->is_default == $role::IS_DEFAULT_YES ? 'disabled' : '' }}>
                            <label for="p-{{ $roles->firstItem() + $loop->iteration - 1 }}" class="checktoggle">checkbox</label>
                        </div>
                    </td>

                    <td class="text-end erp-tbody-td">
                        <div class="erp-action-t">
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="{{ route('settings.role-permission.index',$role->id) }}" ><i class="la la-lock m-r-5"></i> Set Permission</a>
                                    <a class="dropdown-item" href="javascript:void(0)" onclick="editItem({{$role->id}})"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                    @if($role->is_default == $role::IS_DEFAULT_NO)
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="deleteAjax('{{ route('settings.role-management.delete',$role->id) }}', 'reloadAjaxGetData') "><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
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

{{ $roles->links('vendor.pagination.common_ajax_pagination') }}

