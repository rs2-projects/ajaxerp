<div class="">
    <table class="table mb-0 erp-table">
        <thead class="erp-thead">
            <tr class="erp-tr">
                <th class="erp-th">SL</th>
                <th class="erp-th">Name</th>
                <th class="erp-th text-center">Available QTY </th>
                <th class="erp-th text-center">Action </th>
            </tr>
        </thead>
        <tbody class="erp-tbody">
            @forelse($items as $item)
                <tr class="erp-tbody-tr">
                    <td class="erp-tbody-td">
                        <h4 class="d-table-title">{{ $items->firstItem() + $loop->iteration - 1 }}</h4>
                    </td>
                    <td class="erp-tbody-td text-start">
                        {{ $item->name }}
                    </td>
                    <td class="erp-tbody-td text-center">
                        <h4 class="text-center d-table-title" >{{ $item->available_qty ?? 0 }}</h4>
                    </td>
                    <td class="text-center erp-tbody-td">
                        <a href="javascript:void(0)" class="last-cal-status-btn" onclick="reuseItemDetails({{ $item->id }})">Check Status</a>
                    </td>
                </tr>
            @empty
                <tr class="erp-tbody-tr">
                    <td class="erp-tbody-td text-center text-primary" colspan="7">
                        Data not found..!
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $items->links('vendor.pagination.common_ajax_pagination') }}
