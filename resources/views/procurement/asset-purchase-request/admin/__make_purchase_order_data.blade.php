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
                            <th class="text-center erp-th">Attachment</th>
                            <th class="erp-th text-center">Check </th>
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
                                        <a href="{{ $item->show_image }}" target="_blank" class="text-center d-table-title attachement-file-box">
                                            <img src="{{asset('assets/img/attachment.png')}}" alt=""> {{$item->file ? 'Attachment' : 'No Attachment'}}
                                        </a>
                                    </td>
                                    <td class="erp-tbody-td text-center">
                                        <label class="col-form-label">
                                            <input type="checkbox" name="checkbox"> 
                                        </label>
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
    <div class="d-purchase-order-action-btn pb-0 d-flex justify-content-center align-items-center">
        <a href="javascript:void(0)" class="dpoa-btn appr">Purchase Selected Products</a>
    </div>
</div>