
    <div class="big-table pt-4">
        <div class="de-table-wrapper">
            <div class="table-responsive">
                <table class="table mb-0 erp-table">
                    <thead class="erp-thead">
                        <tr class="erp-tr">
                            <th class="erp-th">SL</th>
                            <th class="erp-th">Items </th>
                            <th class="erp-th text-center">Design Of Document <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Product Design"><i class="fa-duotone fa-exclamation"></i></span></th>
                            <th class="erp-th text-center">Received Raw Materials</th>
                            <th class="erp-th text-center">Estimated QTY </th>
                            <th class="erp-th text-center">QTY Dispatched </th>
                            <th class="erp-th text-center">Status </th>
                            <th class="erp-th text-center">Action </th>
                        </tr>
                    </thead>
                    <tbody class="erp-tbody">
                        @forelse($pre_productions as $data)
                            <tr class="erp-tbody-tr">
                                <td class="erp-tbody-td">
                                    <h4 class="d-table-title">{{ $pre_productions->firstItem() + $loop->iteration - 1 }}</h4>
                                </td>
                                <td class="erp-tbody-td text-start">
                                    <a href="{{ route('production-staff.production.production.details', $data->id) }}" class="em-profile-wrap d-flex align-items-center flex-wrap w-100">
                                        <div class="em-pro-img-box">
                                            <img src="{{ $data->finishedGoods->show_image }}" alt="">
                                        </div>
                                        <div class="em-pro-details-box">
                                            <h5>{{$data->finishedGoods->name}}</h5>
                                            <p class="em-id">Code: <span> #{{$data->finishedGoods->code?? 'N/A'}}</span></p>
                                        </div>
                                    </a>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    @if($data->design_of_documents)
                                        <a href="javascript:void(0)" onclick="getDocunent({{$data->id}})" class="document-view-status-btn" data-bs-toggle="modal" data-bs-target="#check_status">
                                            <img src="{{ asset('assets/img/product/documents.png') }}" alt="" class="document-img-box"><small>View</small>
                                        </a>
                                    @else N/A
                                    @endif
                                </td>
                                <td class="erp-tbody-td text-center">
                                    {{-- {{ $data->production_material->sum('received_qty') }} / {{ $data->production_material->sum('quantity') }} --}}
                                    {{ $data->production_material->sum('received_qty') + $data->board_material->sum('received_qty') }} / {{ ($data->production_material->sum('quantity') + $data->board_material->sum('quantity')) ?? 0 }}
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">{{$data->estimated_production_qty}}</h4>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">{{ $data->dispatched_qty }} / {{$data->estimated_production_qty}}</h4>
                                </td>
                                <td class="erp-tbody-td text-center pre-description-box-td">
                                    <p class="text-center d-table-title pre-description-box">
                                        {{ $data->showStatus() }}
                                    </p>
                                </td>
                                <td class="text-end erp-tbody-td">
                                    <div class="erp-action-t">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                {{-- <a class="dropdown-item" href="{{ route('production.production.receive', $data->id) }}"><i class="la la-deviantart m-r-5"></i> Receive Product</a> --}}
                                                <a class="dropdown-item" href="{{ route('production-staff.production.production.details', $data->id) }}" ><i class="la la-hand-o-right m-r-5"></i> View Details</a>

                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="erp-tbody-tr">
                                <td class="erp-tbody-td text-center text-primary" colspan="8">
                                    No data found...!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{ $pre_productions->links('vendor.pagination.common_ajax_pagination') }}
