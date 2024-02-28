<div class="">
    <table class="table mb-0 erp-table">
        <thead class="erp-thead">
            <tr class="erp-tr">
                <th class="erp-th">SL</th>
                <th class="erp-th">Product Name & Code </th>
                <th class="erp-th text-center">Total QTY </th>
                <th class="erp-th text-center">Last Calculated Price </th>
                <th class="erp-th text-center">Status </th>
                <th class="erp-th text-center">Location </th>
                @if(hasPermission( 'manage-product-material'))
                    <th class="erp-th text-center">Action </th>
                @endif
            </tr>
        </thead>
        <tbody class="erp-tbody">
            @foreach($product_materials as $product_material)
                <tr class="erp-tbody-tr">
                    <td class="erp-tbody-td">
                        <h4 class="d-table-title">{{ $product_materials->firstItem() + $loop->iteration - 1 }}</h4>
                    </td>
                    <td class="erp-tbody-td text-start">
                        <a href="#" class="em-profile-wrap d-flex align-items-center flex-wrap w-100">
                            <div class="em-pro-img-box">
                                <img src="{{ $product_material->show_image }}" alt="">
                            </div>
                            <div class="em-pro-details-box">
                                <h5>{{ $product_material->name }}</h5>
                                <p class="em-id">Code: <span> #{{ $product_material->code }}</span></p>

                            </div>
                        </a>
                    </td>
                    <td class="erp-tbody-td text-center">
                        <a href="javascript:void(0)" class="text-center d-table-title" >{{ $product_material->available_qty??0 }}</a>
                    </td>

                    <td class="erp-tbody-td text-center">
                        <a href="javascript:void(0)" class="last-cal-status-btn" onclick="purchaseHistory({{$product_material->id}})">Check Status</a>
                    </td>

                    <td class="erp-tbody-td text-center">
                        <div class="erp-action-t erp-table-status {{ ($product_material->status == $product_material::STATUS_ACTIVE) ? 'status-approved' : '' }}">
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-regular fa-circle-dot me-1"></i> <span>{{ $product_material::STATUSES[$product_material->status] }}</span></a>
                                @if(hasPermission( 'manage-product-material'))
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="updateStatus(this, function () { getData() })" data-href="{{ route('inventory.product-material.change-status',[$product_material->id,1]) }}" ><i class="fa-regular fa-circle-dot m-r-5 "></i> Active</a>
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="updateStatus(this, function () { getData() })" data-href="{{ route('inventory.product-material.change-status',[$product_material->id,0]) }}" ><i class="fa-regular fa-circle-dot m-r-5"></i> Inactive</a>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </td>
                    <td class="erp-tbody-td text-start warahouse-section">
                        @if(count($product_material->materialWarehouseSections) > 0)
                            @foreach($product_material->materialWarehouseSections as $warehouseSection)
                                <h4 class="text-start d-table-title">
                                    {{ $warehouseSection->warehouseSection->name??'N/A' }} (<span>
                                        @if(count($warehouseSection->productMaterialRacks) > 0)
                                            @foreach($warehouseSection->productMaterialRacks as $rackKey=>$rack)
                                                @if($rackKey == 2)
                                                    ...
                                                    @break
                                                @endif
                                                {{ $rack->warehouseSectionRack->name??''}}
                                                    @if(!$loop->last)
                                                        <span class="text-red">,</span>
                                                    @endif
                                            @endforeach
                                        @endif
                                    </span>)
                                </h4>
                            @endforeach
                        @endif
                    </td>
                    @if(hasPermission( 'manage-product-material'))
                        <td class="text-end erp-tbody-td">
                            <div class="erp-action-t">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">

                                        <a class="dropdown-item" href="{{ route('inventory.product-material.edit',$product_material->id) }}" ><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="deleteAjax('{{ route('inventory.product-material.delete',$product_material->id) }}', 'reloadAjaxGetData') "><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>

                                    </div>
                                </div>
                            </div>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $product_materials->links('vendor.pagination.common_ajax_pagination') }}
