
    <div class="big-table pt-4">
        <div class="de-table-wrapper">
            <div class="table-responsives">
                <table class="table mb-0 erp-table">
                    <thead class="erp-thead">
                        <tr class="erp-tr">
                            <th class="erp-th">SL</th>
                            <th class="erp-th">Item </th>
                            <th class="erp-th">Dispatch Code </th>
                            <th class="erp-th text-center">Dispatched QTY </th>
                            <th class="erp-th text-center">Received QTY </th>
                            <th class="erp-th text-center">Received At </th>
                            <th class="erp-th text-center">Action </th>
                        </tr>
                    </thead>
                    <tbody class="erp-tbody">
                        @forelse($dispatches as $data)
                            <tr class="erp-tbody-tr">
                                <td class="erp-tbody-td">
                                    <h4 class="d-table-title">{{ $dispatches->firstItem() + $loop->iteration - 1 }}</h4>
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
                                    <h4 class="text-center d-table-title">{{$data->dispatch_no}}</h4>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">{{$data->dispatched_qty}}</h4>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">{{$data->received_qty}}</h4>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">{{ getFormattedDate($data->received_at, 'd M, Y') }}</h4>
                                </td>
                                <td class="text-end erp-tbody-td">
                                    <div class="erp-action-t">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="{{ route('inventory.receive-product.receive', $data->id) }}"><i class="la la-deviantart m-r-5"></i> Receive Product</a>
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

    {{ $dispatches->links('vendor.pagination.common_ajax_pagination') }}
