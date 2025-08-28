<div class="">
    <table class="table mb-0 erp-table">
        <thead class="erp-thead">
            <tr class="erp-tr">
                <th class="erp-th">SL</th>
                <th class="erp-th">Product</th>
                <th class="erp-th text-center">QTY </th>
                <th class="erp-th text-center">Wholesale Price </th>
                <th class="erp-th text-center">Retail Price </th>
            </tr>
        </thead>
        <tbody class="erp-tbody">
            @forelse($product_materials as $product_material)
                <tr class="erp-tbody-tr">
                    <td class="erp-tbody-td">
                        <h4 class="d-table-title">{{ $product_materials->firstItem() + $loop->iteration - 1 }}</h4>
                    </td>
                    <td class="erp-tbody-td text-start">
                        <a href="{{ route('inventory.product-material.details', $product_material->id) }}" class="em-profile-wrap d-flex align-items-center flex-wrap w-100">
                            <div class="product-qrcode-img-box">
                                <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(50)->generate($product_material->code)) !!} " alt="QrCode">
                            </div>
                            <div class="em-pro-details-box">
                                <h5>{{ $product_material->name }}</h5>
                                <p class="em-id">Code: <span> #{{ $product_material->code }}</span></p>

                            </div>
                        </a>
                    </td>
                    <td class="erp-tbody-td text-center">
                        <h4 class="text-center d-table-title" >{{ $product_material->available_qty??0 }}</h4>
                    </td>

                    <td class="erp-tbody-td text-center">
                        <h4 class="text-center d-table-title" >{{ getCurrencySymbol() }}{{ formatNumber($product_material->wholesale_price??0) }}</h4>
                    </td>

                    <td class="erp-tbody-td text-center">
                        <h4 class="text-center d-table-title" >{{ getCurrencySymbol() }}{{ formatNumber($product_material->retail_price??0) }}</h4>
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
{{ $product_materials->links('vendor.pagination.common_ajax_pagination') }}
