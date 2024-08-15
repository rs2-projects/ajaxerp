

<div class="">
    <table class="table mb-0 erp-table">
        <thead class="erp-thead">
            <tr class="erp-tr">
                <th class="erp-th">SL</th>
                <th class="erp-th">Name </th>
                <th class="erp-th text-center">Cost</th>
                <th class="erp-th text-center">SRP Markup %</th>
                <th class="erp-th text-center">Wholesale Discount %</th>
                <th class="erp-th text-center">SRP</th>
                <th class="erp-th text-center">SRP With 20% Discount</th>
                <th class="erp-th text-center">Wholesale</th>
                <th class="erp-th text-center">Action </th>
            </tr>
        </thead>
        <tbody class="erp-tbody">
            @forelse($material_sets as $data)
                <tr class="erp-tbody-tr">
                    <td class="erp-tbody-td">
                        <h4 class="d-table-title">{{ $material_sets->firstItem() + $loop->iteration - 1 }}</h4>
                    </td>
                    <td class="erp-tbody-td text-center">{{ $data->name??'N/A' }}</td>
                    <td class="erp-tbody-td text-center">{{ formatNumber($data->rp_cost??0) }}</td>
                    <td class="erp-tbody-td text-center">{{ formatNumber($data->srp_markup_percent??0) }}</td>
                    <td class="erp-tbody-td text-center">{{ formatNumber($data->wholesale_discount_percent??'0') }}</td>
                    <td class="erp-tbody-td text-center">{{ formatNumber($data->rp_srp??0) }}</td>
                    <td class="erp-tbody-td text-center">{{ formatNumber($data->srp_with_discount??0) }}</td>
                    <td class="erp-tbody-td text-center">{{ formatNumber($data->wholesale??0) }}</td>
                    {{-- @if(hasPermission('manage-machines')) --}}
                        <td class="text-end erp-tbody-td">
                            <div class="erp-action-t">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{ route('inventory.product-material-set.edit',$data->id) }}"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                        <a class="dropdown-item" href="{{ route('inventory.product-material-set.details',$data->id) }}"><i class="fa-solid fa-eye m-r-5"></i> Details</a>
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="deleteAjax('{{ route('inventory.product-material-set.delete',$data->id) }}', 'reloadAjaxGetData') "><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
                                </div>
                                </div>
                            </div>
                        </td>
                    {{-- @endif --}}
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

{{ $material_sets->links('vendor.pagination.common_ajax_pagination') }}

