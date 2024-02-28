
    <div class="big-table pt-4">
        <div class="de-table-wrapper">
            <div class="table-responsive">
                <table class="table mb-0 erp-table">
                    <thead class="erp-thead">
                        <tr class="erp-tr">
                            <th class="erp-th">SL</th>
                            <th class="erp-th">Items </th>
                            <th class="erp-th text-center">Design Of Document <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Product Design"><i class="fa-duotone fa-exclamation"></i></span></th>
                            <th class="erp-th text-center">Process <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Production Process"><i class="fa-duotone fa-exclamation"></i></span> </th>
                            <th class="erp-th text-center">Raw Materials </th>
                            <th class="erp-th text-center">Estimated QTY </th>
                            <th class="erp-th text-center">Delivery Status</th>
                            <th class="erp-th text-center">Instruction </th>
                            <th class="erp-th text-center">Action </th>
                        </tr>
                    </thead>
                    <tbody class="erp-tbody">
                        @foreach($pre_productions as $data)
                            <tr class="erp-tbody-tr">
                                <td class="erp-tbody-td">
                                    <h4 class="d-table-title">{{ $pre_productions->firstItem() + $loop->iteration - 1 }}</h4>
                                </td>
                                <td class="erp-tbody-td text-start">
                                    <a href="#" class="em-profile-wrap d-flex align-items-center flex-wrap w-100">
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
                                    <a href="#" class="document-view-status-btn" data-bs-toggle="modal" data-bs-target="#check_status">
                                    <img src="{{ asset('assets/img/product/documents.png') }}" alt="" class="document-img-box"><small>View</small>
                                    </a>
                                </td>
                                
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">{{count($data->process)}}</h4>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">{{count($data->material)}}</h4>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">{{$data->estimated_production_qty}}</h4>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <div class="erp-action-t erp-table-status pre-{{ strtolower($data::DELIVERIES[$data->delivery_status]) }}-s">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle pending" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-regular fa-circle-dot me-1"></i> <span>
                                                {{ $data::DELIVERIES[$data->delivery_status] }}</span></a>
                                            <!-- <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" ><i class="fa-regular fa-circle-dot m-r-5"></i> Pending</a>
                                                <a class="dropdown-item" href="#" ><i class="fa-regular fa-circle-dot m-r-5 "></i> Partial</a>
                                                <a class="dropdown-item" href="#" ><i class="fa-regular fa-circle-dot m-r-5"></i> Delivered</a>
                                            </div> -->
                                        </div>
                                    </div>
                                </td>
                                <td class="erp-tbody-td text-center pre-description-box-td">
                                    <p class="text-center d-table-title pre-description-box">{{$data->description}}</p>
                                </td>
                                <td class="text-end erp-tbody-td">
                                    <div class="erp-action-t">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="{{ route('inventory.material-request.deliver', $data->id) }}"><i class="la la-hand-o-right m-r-5"></i> Deliver</a>
                                                <a class="dropdown-item" href="" ><i class="la la-deviantart m-r-5"></i> View Delivery Details</a>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{ $pre_productions->links('vendor.pagination.common_ajax_pagination') }}