

<div class="">
    <table class="table mb-0 erp-table">
        <thead class="erp-thead">
            <tr class="erp-tr">
                <th class="erp-th">SL</th>
                <th class="erp-th">Name</th>
                <th class="erp-th text-center">Color Code</th>
                <th class="erp-th text-center">Action </th>
            </tr>
        </thead>
        <tbody class="erp-tbody">
            @forelse($board_colors as $data)
                <tr class="erp-tbody-tr">
                    <td class="erp-tbody-td">
                        <h4 class="d-table-title">{{ $board_colors->firstItem() + $loop->iteration - 1 }}</h4>
                    </td>
                    <td class="erp-tbody-td text-center">{{ $data->name??'N/A' }}</td>
                    <td class="erp-tbody-td text-center">{{ $data->color_code??'N/A' }}</td>
                    <td class="text-end erp-tbody-td">
                        <div class="erp-action-t">
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="javascript:void(0)" onclick="editItem({{$data->id}})"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                    <a class="dropdown-item" href="javascript:void(0)" onclick="deleteAjax('{{ route('settings.board-color.delete',$data->id) }}', 'reloadAjaxGetData') "><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
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

{{ $board_colors->links('vendor.pagination.common_ajax_pagination') }}

