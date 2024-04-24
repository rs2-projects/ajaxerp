<div class="">
    <table class="table mb-0 erp-table">
        <thead class="erp-thead">
            <tr class="erp-tr">
                <th class="erp-th">SL</th>
                <th class="erp-th">Product Name & Code </th>
                <th class="erp-th">Category </th>
                <th class="erp-th text-center">Embossed Up </th>
                <th class="erp-th text-center">Color Up </th>
                <th class="erp-th text-center">Embossed Down </th>
                <th class="erp-th text-center">Color Down </th>
                {{-- @if(hasPermission( 'manage-finished-goods')) --}}
                    <th class="erp-th text-center">Action </th>
                {{-- @endif --}}
            </tr>
        </thead>
        <tbody class="erp-tbody">
            @forelse($boards as $data)
                <tr class="erp-tbody-tr">
                    <td class="erp-tbody-td">
                        <h4 class="d-table-title">{{ $boards->firstItem() + $loop->iteration - 1 }}</h4>
                    </td>
                    <td class="erp-tbody-td text-start">
                        <a href="#" class="em-profile-wrap d-flex align-items-center flex-wrap w-100">
                            <div class="em-pro-img-box">
                                <img src="{{ $data->show_image }}" alt="">
                            </div>
                            <div class="em-pro-details-box">
                                <h5>{{ $data->name }}</h5>
                                <p class="em-id">Code: <span> #{{ $data->code }}</span></p>

                            </div>
                        </a>
                    </td>
                    <td class="erp-tbody-td text-center">{{$data->finishedGoodsCategory?->name??'N/A'}}</td>
                    <td class="erp-tbody-td text-center">{{ $data->embossed_ups?->name??'N/A' }}</td>
                    <td class="erp-tbody-td text-center">{{ $data->color_ups?->name??'N/A' }}</td>
                    <td class="erp-tbody-td text-center">{{ $data->embossed_downs?->name??'N/A' }}</td>
                    <td class="erp-tbody-td text-center">{{ $data->color_downs?->name??'N/A' }}</td>
                    @if(hasPermission('manage-finished-goods'))
                        <td class="text-end erp-tbody-td">
                            <div class="erp-action-t">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">

                                        <a class="dropdown-item" href="javascript:void(0)" onclick="editItem({{$data->id}})" ><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="deleteAjax('{{ route('inventory.finished-good.delete',$data->id) }}', 'reloadAjaxGetData') "><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>

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
{{ $boards->links('vendor.pagination.common_ajax_pagination') }}
