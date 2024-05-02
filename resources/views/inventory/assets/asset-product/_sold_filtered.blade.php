

<div class="">
    <table class="table mb-0 erp-table">
        <thead class="erp-thead">
            <tr class="erp-tr">
                <th class="erp-th">SL</th>
                <th class="erp-th">Product Name </th>
                <th class="erp-th text-center">Category</th>
                <th class="erp-th text-center">Quantity</th>
                <th class="erp-th text-center">Description</th>
                <th class="erp-th text-center">Status</th>
                @if(hasPermission('manage-asset-product'))
                    <th class="erp-th text-center">Action </th>
                @endif
            </tr>
        </thead>
        <tbody class="erp-tbody">
            @forelse($products as $product)
                <tr class="erp-tbody-tr">
                    <td class="erp-tbody-td">
                        <h4 class="d-table-title">{{ $products->firstItem() + $loop->iteration - 1 }}</h4>
                    </td>
                    <td class="erp-tbody-td text-start">
                        <a href="#" class="em-profile-wrap d-flex align-items-center flex-wrap w-100">
                            <div class="em-pro-img-box">
                                <img src="{{ $product->show_image }}" alt="">
                            </div>
                            <div class="em-pro-details-box">
                                <h5>{{ $product->name }}</h5>
                                {{-- <p class="em-id">Code: <span> #{{ $product_material->code }}</span></p> --}}

                            </div>
                        </a>
                    </td>
                    <td class="erp-tbody-td text-center">{{ $product->category->name??'N/A' }}</td>
                    <td class="erp-tbody-td text-center">{{ $product->sold_qty??0 }}</td>
                    <td class="erp-tbody-td text-center">{{ getRealSubStr($product->description??'N/A', 60) }}</td>

                    <td class="erp-tbody-td text-center">
                        <div class="erp-action-t erp-table-status {{ ($product->status == $product::STATUS_ACTIVE) ? 'status-approved' : '' }}">
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-regular fa-circle-dot me-1"></i> <span>{{$product::STATUSES[$product->status]}}</span></a>
                                @if(hasPermission('manage-asset-product'))
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="updateStatus(this, function () { getData() })" data-href="{{ route('inventory.asset-product.change-status',[$product->id,1]) }}"><i class="fa-regular fa-circle-dot m-r-5 "></i> Active</a>
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="updateStatus(this, function () { getData() })" data-href="{{ route('inventory.asset-product.change-status',[$product->id,0]) }}"><i class="fa-regular fa-circle-dot m-r-5"></i> Inactive</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </td>
                    @if(hasPermission('manage-asset-product'))
                        <td class="text-end erp-tbody-td">
                            <div class="erp-action-t">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="editItem({{$product->id}})"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                        @if($product->total_purchased_qty == 0)
                                            <a class="dropdown-item" href="javascript:void(0)" onclick="deleteAjax('{{ route('inventory.asset-product.delete',$product->id) }}', 'reloadAjaxGetData') "><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                    @endif
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

{{ $products->links('vendor.pagination.common_ajax_pagination') }}

