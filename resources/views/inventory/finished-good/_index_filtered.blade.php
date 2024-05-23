<div class="">
    <table class="table mb-0 erp-table">
        <thead class="erp-thead">
            <tr class="erp-tr">
                <th class="erp-th">SL</th>
                <th class="erp-th">Product Name & Code </th>
                <th class="erp-th text-center">Total QTY </th>
                {{-- <th class="erp-th text-center">Last Calculated Price </th> --}}
                <th class="erp-th text-center">Status </th>
                <th class="erp-th text-center">Location </th>
                @if(hasPermission( 'manage-finished-goods'))
                    <th class="erp-th text-center">Action </th>
                @endif
            </tr>
        </thead>
        <tbody class="erp-tbody">
            @forelse($finished_goods as $finished_good)
                <tr class="erp-tbody-tr">
                    <td class="erp-tbody-td">
                        <h4 class="d-table-title">{{ $finished_goods->firstItem() + $loop->iteration - 1 }}</h4>
                    </td>
                    <td class="erp-tbody-td text-start">
                        <a href="#" class="em-profile-wrap d-flex align-items-center flex-wrap w-100">
                            <div class="em-pro-img-box">
                                <img src="{{ $finished_good->show_image }}" alt="">
                            </div>
                            <div class="em-pro-details-box">
                                <h5>{{ $finished_good->name }}</h5>
                                <p class="em-id">Code: <span> #{{ $finished_good->code }}</span></p>

                            </div>
                        </a>
                    </td>
                    <td class="erp-tbody-td text-center">
                        <a href="javascript:void(0)" class="text-center d-table-title" >{{ $finished_good->available_qty??0 }}</a>
                    </td>

                    {{-- <td class="erp-tbody-td text-center">
                        <a href="javascript:void(0)" class="last-cal-status-btn" onclick="purchaseHistory({{$finished_good->id}})">Check Status</a>
                    </td> --}}

                    <td class="erp-tbody-td text-center">
                        <div class="erp-action-t erp-table-status {{ ($finished_good->status == $finished_good::STATUS_ACTIVE) ? 'status-approved' : '' }}">
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-regular fa-circle-dot me-1"></i> <span>{{ $finished_good::STATUSES[$finished_good->status] }}</span></a>

                                    @if(hasPermission( 'manage-finished-goods'))
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="javascript:void(0)" onclick="updateStatus(this, function () { getData() })" data-href="{{ route('inventory.finished-good.change-status',[$finished_good->id,1]) }}" ><i class="fa-regular fa-circle-dot m-r-5 "></i> Active</a>
                                            <a class="dropdown-item" href="javascript:void(0)" onclick="updateStatus(this, function () { getData() })" data-href="{{ route('inventory.finished-good.change-status',[$finished_good->id,0]) }}" ><i class="fa-regular fa-circle-dot m-r-5"></i> Inactive</a>
                                        </div>
                                    @endif
                            </div>
                        </div>
                    </td>
                    <td class="erp-tbody-td text-start warahouse-section">
                        @if(count($finished_good->finishedGoodWarehouseSections) > 0)
                            @foreach($finished_good->finishedGoodWarehouseSections as $warehouseSection)
                                <h4 class="text-start d-table-title">
                                    {{ $warehouseSection->warehouseSection->name??'N/A' }} (<span>
                                        @if(count($warehouseSection->finishedGoodRacks) > 0)
                                            @foreach($warehouseSection->finishedGoodRacks as $rackKey=>$rack)
                                                @if($rackKey == 2)
                                                    ...
                                                    @break
                                                @endif
                                            @if($rackKey > 0)<span class="text-red">,</span> @endif
                                                {{ $rack->warehouseSectionRack->name??''}}
                                            @endforeach
                                        @endif
                                    </span>)
                                </h4>
                            @endforeach
                        @endif
                    </td>
                    @if(hasPermission('manage-finished-goods'))
                        <td class="text-end erp-tbody-td">
                            <div class="erp-action-t">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">

                                        <a class="dropdown-item" href="{{ route('inventory.finished-good.edit',$finished_good->id) }}" ><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="deleteAjax('{{ route('inventory.finished-good.delete',$finished_good->id) }}', 'reloadAjaxGetData') "><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>

                                    </div>
                                </div>
                            </div>
                        </td>
                    @endif
                </tr>
                @empty
                <tr class="erp-tbody-tr">
                    <td class="erp-tbody-td text-center text-primary" colspan="7">
                        No data found...!
                    </td>
                </tr>
                @endforelse
        </tbody>
    </table>
</div>
{{ $finished_goods->links('vendor.pagination.common_ajax_pagination') }}
