<div class="">
    <table class="table mb-0 erp-table">
        <thead class="erp-thead">
            <tr class="erp-tr">
                <th class="erp-th">SL</th>
                <th class="erp-th">Product</th>
                <th class="erp-th text-center">Category </th>
                <th class="erp-th text-center">QTY </th>
            </tr>
        </thead>
        <tbody class="erp-tbody">
            @forelse($assets as $asset)
                <tr class="erp-tbody-tr">
                    <td class="erp-tbody-td">
                        <h4 class="d-table-title">{{ $assets->firstItem() + $loop->iteration - 1 }}</h4>
                    </td>
                    <td class="erp-tbody-td text-start">
                        <a href="#" class="em-profile-wrap d-flex align-items-center flex-wrap w-100">
                            <div class="em-pro-img-box">
                                <img src="{{ $asset->show_image }}" alt="">
                            </div>
                            <div class="em-pro-details-box">
                                <h5>{{ $asset->name }}</h5>
                            </div>
                        </a>
                    </td>
                    <td class="erp-tbody-td text-center">{{ $asset->category->name??'N/A' }}</td>
                    <td class="erp-tbody-td text-center">{{ $asset->total_purchased_qty??0 }}</td>
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
{{ $assets->links('vendor.pagination.common_ajax_pagination') }}
