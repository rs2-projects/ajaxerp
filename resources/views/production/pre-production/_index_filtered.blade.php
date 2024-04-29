
    <div class="big-table pt-4">
        <div class="de-table-wrapper">
            <div class="table-responsives">
                <table class="table mb-0 erp-table">
                    <thead class="erp-thead">
                        <tr class="erp-tr">
                            <th class="erp-th">SL</th>
                            <th class="erp-th">Items </th>
                            <th class="erp-th text-center">Design Of Document <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Product Design"><i class="fa-duotone fa-exclamation"></i></span></th>
                            <th class="erp-th text-center">Process <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Production Process"><i class="fa-duotone fa-exclamation"></i></span> </th>
                            <th class="erp-th text-center">Raw Materials </th>
                            <th class="erp-th text-center">Estimated QTY </th>
                            {{-- <th class="erp-th text-center">Inventory</th> --}}
                            <th class="erp-th text-center">Status </th>
                            <th class="erp-th text-center">Instruction </th>
                            @if(hasPermission('manage-pre-productions'))
                                <th class="erp-th text-center">Action </th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="erp-tbody">
                        @forelse($pre_productions as $data)
                            <tr class="erp-tbody-tr">
                                <td class="erp-tbody-td">
                                    <h4 class="d-table-title">{{ $pre_productions->firstItem() + $loop->iteration - 1 }}</h4>
                                </td>
                                <td class="erp-tbody-td text-start">
                                    <a href="{{ route('production.pre-production.details', $data->id ?? '') }}" class="em-profile-wrap d-flex align-items-center flex-wrap w-100">
                                        <div class="em-pro-img-box">
                                            <img src="{{ $data->finishedGoods->show_image }}" alt="">
                                        </div>
                                        <div class="em-pro-details-box">
                                            <h5>{{$data->finishedGoods->name}}</h5>
                                            <p class="em-id">Code: <span> #{{$data->finishedGoods->code?? 'N/A'}}</span></p>
                                            <p class="pp-batch-num">Batch No: <span> {{$data->pre_production_batch_no ?? 'N/A'}}</span></p>
                                        </div>
                                    </a>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    @if($data->design_of_documents)
                                        <a href="javascript:void(0)" onclick="getDocument({{$data->id}})" class="document-view-status-btn" data-bs-toggle="modal" data-bs-target="#check_status">
                                            <img src="{{ asset('assets/img/product/documents.png') }}" alt="" class="document-img-box"><small>View</small>
                                        </a>
                                    @else N/A
                                    @endif
                                </td>

                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">{{count($data->process)}}</h4>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">{{count($data->production_material)}}</h4>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">{{$data->estimated_production_qty}}</h4>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    {{-- <div class="checkbox-wrapper">
                                        <input {{$data->is_verified ==$data::VERIFIED_YES? 'checked disabled': '' }}  id="terms-checkbox-{{$data->id}}" name="checkbox" onclick="updateStatus(this, function () { getData() })" data-href="{{ route('production.pre-production.change-status',[$data->id,1]) }}" type="checkbox">
                                        <label class="terms-label" for="terms-checkbox-{{$data->id}}">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 200 200" class="checkbox-svg">
                                            <mask fill="white" id="path-1-inside-1_476_5-37">
                                                <rect height="200" width="200"></rect>
                                            </mask>
                                            <rect mask="url(#path-1-inside-1_476_5-37)" stroke-width="40" class="checkbox-box" height="200" width="200"></rect>
                                            <path stroke-width="15" d="M52 111.018L76.9867 136L149 64" class="checkbox-tick"></path>
                                            </svg>
                                            <span class="label-text">{{$data->is_verified ==$data::VERIFIED_YES? 'Verified': 'Verify' }}</span>
                                        </label>
                                    </div> --}}
                                    <h4 class="text-center d-table-title  {{ ($data->is_verified == $data::VERIFIED_YES) ? 'perfect-status' : (($data->is_verified == $data::VERIFIED_NO) ? 'unpaid-status' : 'partial-status') }}">{{$data::VERIFIEDS[$data->is_verified]}}</h4>

                                </td>
                                <td class="erp-tbody-td text-center pre-description-box-td">
                                    <p class="text-center d-table-title pre-description-box">{{$data->description}}</p>
                                </td>
                                @if(hasPermission('manage-pre-productions'))
                                    <td class="text-end erp-tbody-td">
                                        @if($data->is_verified ==$data::VERIFIED_NO || $data->is_verified ==$data::VERIFIED_REVISION)
                                            <div class="erp-action-t">
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="{{ route('production.pre-production.edit',$data->id) }}"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="deleteAjax('{{ route('production.pre-production.delete',$data->id) }}', 'reloadAjaxGetData') "><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>

                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr class="erp-tbody-tr">
                                <td class="erp-tbody-td text-center text-primary" colspan="10">
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
