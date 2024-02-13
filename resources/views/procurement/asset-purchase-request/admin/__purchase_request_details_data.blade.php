<div class="my-attendance-report-wrapper">
    <div class="big-table">
        <div class="de-table-wrapper">
            <div class="table-responsive">
                <table class="table mb-0 erp-table">
                    <thead class="erp-thead">
                        <tr class="erp-tr">
                            <th class="erp-th">Category </th>
                            <th class="erp-th text-center">Item </th>
                            <th class="erp-th text-center">Qty </th>
                            <th class="erp-th text-center">Remarks </th>
                            <th class="text-center erp-th">Attachment</th>
                        </tr>
                    </thead>
                    <tbody class="erp-tbody">
                        @if($request_details)
                            @foreach ($request_details->purchase_request_details as $item)
                                <tr class="erp-tbody-tr">
                                    <td class="erp-tbody-td text-start">
                                        <h4 class="text-start d-table-title">{{$item->asset_category->name}}</h4>
                                    </td>
                                    <td class="erp-tbody-td text-center">
                                        <h4 class="text-center d-table-title">{{$item->asset_product->name}}</h4>
                                    </td>
                                    <td class="erp-tbody-td text-center">
                                        <h4 class="text-center d-table-title">{{$item->qty}}</h4>
                                    </td>
                                    <td class="erp-tbody-td text-center">
                                        <h4 class="text-center d-table-title">{{$item->description}}</h4>
                                    </td>
                                    <td class="erp-tbody-td text-center">
                                        <a href="{{ $item->show_image }}" target="_blank" class="text-center d-table-title attachement-file-box">
                                            <img src="{{asset('assets/img/attachment.png')}}" alt=""> {{$item->file ? 'Attachment' : 'No Attachment'}}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="d-purchase-order-action-wrapper">
    <div class="d-purchase-order-action-btn d-flex justify-content-center align-items-center">
        <a href="javascript:void(0)" class="dpoa-btn req-info-btn">Request For Info</a>
        <a href="javascript:void(0)" onclick="approvePurchaseRequest('{{ route('procurement.admin.asset-purchase-request.approve',$request_details->id) }}', 'reloadAjaxGetData') " class="dpoa-btn appr">Approved</a>
        <a href="javascript:void(0)" onclick="declinePuchaseRequest('{{ route('procurement.admin.asset-purchase-request.decline',$request_details->id) }}', 'reloadAjaxGetData')" class="dpoa-btn re">Decline</a>
    </div>
    <div class="d-purchase-req-wrapper text-center justify-content-center flex-wrap" style="display: none;">
        <form action="{{ route('procurement.admin.asset-purchase-request.request-details.store', $request_details->id) }}" id="requestMoreInfoStoreForm" method="post">
            @csrf
            <input type="hidden" name="request_id" value="{{ $request_details->id }}">
            <div class="dpreq-item flex-100">
                <div class="input-block erp-step-input-block ">
                    <label class="col-form-label">Request Message <span class="text-danger">*</span></label>
                    <textarea name="additional_info" rows="3" class="form-control"></textarea>
                </div>
                
            </div>
            <div class="dpreq-item flex-100">
                <div class="input-block erp-step-input-block mb-0">
                    <div class="nw-p-add-btn text-center d-inline-block">
                        <button type="submit" class=" erp-search-btn text-center"><i class="fa-regular fa-paper-plane me-2"></i>Send</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>