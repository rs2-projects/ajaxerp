<div class="">
    <table class="table mb-0 erp-table">
        <thead class="erp-thead">
            <tr class="erp-tr">
                <th class="erp-th">SL</th>
                <th class="erp-th">Items</th>
                <th class="erp-th text-center">Estimated Quantity </th>
                <th class="erp-th text-center">Machine </th>
                <th class="erp-th text-center">Production Staff </th>
                <th class="erp-th text-center">Note </th>
                {{-- @if(hasPermission( 'manage-finished-goods')) --}}
                    <th class="erp-th text-center">Action </th>
                {{-- @endif --}}
            </tr>
        </thead>
        <tbody class="erp-tbody">
            @forelse($pre_productions as $data)
                <tr class="erp-tbody-tr">
                    <td class="erp-tbody-td">
                        <h4 class="d-table-title">{{ $pre_productions->firstItem() + $loop->iteration - 1 }}</h4>
                    </td>
                    <td class="erp-tbody-td text-start">
                        <a href="#" class="em-profile-wrap d-flex align-items-center flex-wrap w-100">
                            <div class="em-pro-img-box">
                                <img src="{{ $data->finishedGoods?->show_image }}" alt="">
                            </div>
                            <div class="em-pro-details-box">
                                <h5>{{$data->finishedGoods?->name}}</h5>
                                <p class="em-id">Code: <span> #{{$data->pre_production_no?? 'N/A'}}</span></p>
                            </div>
                        </a>
                    </td>
                    <td class="erp-tbody-td text-center">{{$data->estimated_quantity??'N/A'}}</td>
                    <td class="erp-tbody-td text-center">{{ $data->machine?->name??'N/A' }}</td>
                    <td class="erp-tbody-td text-center">
                        @if ($data->staff)
                            {{ $data->staff->title . ' (' . $data->staff->user_name . ')' }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td class="erp-tbody-td text-center">{{ $data->note??'N/A' }}</td>
                    {{-- @if(hasPermission('manage-finished-goods')) --}}
                        <td class="text-end erp-tbody-td">
                            <div class="erp-action-t">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">

                                        <a class="dropdown-item" href="{{ route('production.board-pre-production.edit',$data->id) }}" onclick="editItem({{$data->id}})" ><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="deleteAjax('{{ route('production.board-pre-production.delete',$data->id) }}', 'reloadAjaxGetData') "><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="sendToProduction({{$data->id}})"><i class="la la-hand-o-right m-r-5"></i> Send to Production</a>
                                    </div>
                                </div>
                            </div>
                        </td>
                    {{-- @endif --}}
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
{{ $pre_productions->links('vendor.pagination.common_ajax_pagination') }}
