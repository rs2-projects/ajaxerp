
<div class="">
    <table class="table mb-0 erp-table auto-col-table">
        <thead class="erp-thead">
            <tr class="erp-tr">
                <th class="erp-th">SL</th>
                <th class="erp-th">Name </th>
                <th class="erp-th text-center">Address</th>
                <th class="erp-th text-center">Employees</th>
                @if(hasPermission('manage-showroom'))
                    <th class="erp-th text-center">Action </th>
                @endif
            </tr>
        </thead>
        <tbody class="erp-tbody">
            @forelse($items as $item)
                <tr class="erp-tbody-tr">
                    <td class="erp-tbody-td">
                        <h4 class="d-table-title">{{ $items->firstItem() + $loop->iteration - 1 }}</h4>
                    </td>
                    <td class="erp-tbody-td">{{ $item->name }}</td>
                    <td class="erp-tbody-td text-center">{{ $item->address ?? '-' }}</td>
                    <td class="erp-tbody-td text-center">
                        <a href="{{ route('showroom.showroom-employees.index', $item->id) }}" class="showroom-employees-btn">Employees</a>
                    </td>
                    @if(hasPermission('manage-showroom'))
                        <td class="text-end erp-tbody-td">
                            <div class="erp-action-t">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="editItem({{$item->id}})"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="deleteAjax('{{ route('showroom.delete',$item->id) }}', 'reloadAjaxGetData') "><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
                                    </div>
                                </div>
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

{{ $items->links('vendor.pagination.common_ajax_pagination') }}

