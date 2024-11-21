<div class="table-responsive">
    <table class="table mb-0 erp-table auto-col-table">
        <thead class="erp-thead">
            <tr class="erp-tr">
                <th class="erp-th">SL</th>
                <th class="erp-th">Code</th>
                <th class="erp-th">Raw Board</th>
                <th class="erp-th text-center">Plate Up </th>
                <th class="erp-th text-center">Paper Up </th>
                <th class="erp-th text-center">Plate Down </th>
                <th class="erp-th text-center">Paper Down </th>
                <th class="erp-th text-center">Machine </th>
                {{-- <th class="erp-th text-center">Production Staff </th> --}}
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
                        <a href="{{ route('production.board-pre-production.get-production-details', $data->id) }}" class="em-profile-wrap d-flex align-items-center flex-wrap w-100">
                            {{-- <div class="em-pro-img-box">
                                <img src="{{ $data->finishedGoods?->show_image }}" alt="">
                            </div> --}}
                            <div class="em-pro-details-box">
                                <h5>{{$data->finishedGoods?->name}}</h5>
                                <p class="em-id">P.P. No: <span> #{{$data->pre_production_no?? 'N/A'}}</span></p>
                            </div>
                        </a>
                    </td>
                    <td class="erp-tbody-td text-center" title="{{ $data->raw_board?->product_material?->name??'N/A' }}">{{ getRealSubStr($data->raw_board?->product_material?->name??'N/A', 18) }}</td>
                    <td class="erp-tbody-td text-center">{{ $data->finishedGoods?->embossed_ups?->name??'N/A' }}</td>
                    <td class="erp-tbody-td text-center">{{ $data->paper_up?->product_material?->name??'N/A' }}</td>
                    <td class="erp-tbody-td text-center">{{ $data->finishedGoods?->embossed_downs?->name??'N/A' }}</td>
                    <td class="erp-tbody-td text-center">{{ $data->paper_down?->product_material?->name??'N/A' }}</td>
                    <td class="erp-tbody-td text-center">{{ $data->machine?->name??'N/A' }}</td>
                    {{-- <td class="erp-tbody-td text-center">{{ !empty($data->staff->title) ? $data->staff->title : 'N/A'}}</td> --}}
                    {{-- @if(hasPermission('manage-finished-goods')) --}}
                        <td class="text-end erp-tbody-td">
                            <div class="erp-action-t">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="sendToProduction({{$data->id}})"><i class="la la-hand-o-right m-r-5"></i> Send to Production</a>
                                        <a class="dropdown-item" href="{{route('production.board-pre-production.calculate-price', $data->id)}}" ><i class="la la-calculator m-r-5"></i>Calculate Price</a>
                                        <a class="dropdown-item" href="{{ route('production.board-pre-production.get-production-details', $data->id) }}" ><i class="fa-solid fa-eye m-r-5"></i> View Details</a>
                                        <a class="dropdown-item" href="{{ route('production.board-pre-production.edit',$data->id) }}"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="deleteAjax('{{ route('production.board-pre-production.delete',$data->id) }}', 'reloadAjaxGetData') "><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
                                        
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
