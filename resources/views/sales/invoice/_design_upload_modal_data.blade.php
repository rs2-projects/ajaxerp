<form action="{{ route('sales.invoice.design_upload') }}" id="designUploadFormSubmit" method="post" enctype="multipart/form-data">
    @csrf
    <div class="erp-modal-body-content ">
        <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-3 ">
            <div class="erp-filter-item flex-100">
                <div class="multiple-receipt-box d-flex flex-wrap position-relative">
                    <div class="multiple-receipt-item flex-100">
                        <div class="input-block erp-step-input-block mb-0">
                            <label class="col-form-label">Upload Design <span class="text-danger"> </span></label>
                            <input type="file" class="form-control" name="design[]" placeholder="Upload Design" accept="image/*,application/pdf,.xls,.xlsx,.csv,.doc,.docx" multiple>
                            @if(!empty($designs) && count($designs) > 0)
                                <div class="mt-2 d-flex flex-wrap">
                                    @foreach($designs as $index => $design)
                                        @php
                                            $designPath = $design->design ?? '';
                                            $designExt = strtolower(pathinfo($designPath, PATHINFO_EXTENSION));
                                            $isDesignImage = in_array($designExt, ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp', 'bmp']);
                                            $designLabel = 'Design' . ($index + 1) . ($designExt ? ('.' . $designExt) : '');
                                        @endphp

                                        <a href="{{ $design->show_image }}" target="_blank" class="d-inline-block me-2 mb-2">
                                            @if($isDesignImage)
                                                <img src="{{ $design->show_image }}" alt="Design File" style="max-width: 120px; border: 1px solid #ddd; padding: 2px;">
                                            @else
                                                <div class="text-center" style="width: 120px;">
                                                    <img src="{{ asset('/') }}assets/img/product/documents.png" alt="file">
                                                    {{-- <div>{{ $designLabel }}</div> --}}
                                                </div>
                                            @endif
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    @php
                        $deliveryPath = $invoice->delivery_receipt_img ?? '';
                        $deliveryUrl = $deliveryPath ? asset($deliveryPath) : '';
                        $deliveryExt = strtolower(pathinfo($deliveryPath, PATHINFO_EXTENSION));
                        $isDeliveryImage = in_array($deliveryExt, ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp', 'bmp']);
                    @endphp

                    <div class="multiple-receipt-item flex-100 mt-3">
                        <div class="input-block erp-step-input-block mb-0">
                            <label class="col-form-label">Upload Delivery Receipt</label>
                            <input type="file" class="form-control" name="delivery_receipt_img" accept="image/*,application/pdf,.xls,.xlsx,.csv,.doc,.docx">
                            @if($deliveryUrl)
                                <div class="mt-2">
                                    @if($isDeliveryImage)
                                        <img src="{{ $deliveryUrl }}" alt="Delivery Receipt" style="max-width: 120px;border: 1px solid #ddd; padding: 2px;">
                                    @else
                                        <a href="{{ $deliveryUrl }}" target="_blank" class="d-inline-block text-center" style="width: 120px;">
                                            <img src="{{ asset('/') }}assets/img/product/documents.png" alt="file" style="max-width: 60px;">
                                            <div>View Delivery Receipt File</div>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    @php
                        $gatepassPath = $invoice->gatepass_img ?? '';
                        $gatepassUrl = $gatepassPath ? asset($gatepassPath) : '';
                        $gatepassExt = strtolower(pathinfo($gatepassPath, PATHINFO_EXTENSION));
                        $isGatepassImage = in_array($gatepassExt, ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp', 'bmp']);
                    @endphp

                    <div class="multiple-receipt-item flex-100 mt-3">
                        <div class="input-block erp-step-input-block mb-0">
                            <label class="col-form-label">Upload Gatepass</label>
                            <input type="file" class="form-control" name="gatepass_img" accept="image/*,application/pdf,.xls,.xlsx,.csv,.doc,.docx">
                            @if($gatepassUrl)
                                <div class="mt-2">
                                    @if($isGatepassImage)
                                        <img src="{{ $gatepassUrl }}" alt="Gatepass" style="max-width: 120px; border: 1px solid #ddd; padding: 2px;">
                                    @else
                                        <a href="{{ $gatepassUrl }}" target="_blank" class="d-inline-block text-center" style="width: 120px;">
                                            <img src="{{ asset('/') }}assets/img/product/documents.png" alt="file" style="max-width: 60px;">
                                            <div>View Gatepass File</div>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
            <input type="hidden" class="form-control" name="invoice_id" value="{{ $invoice->id }}" placeholder="Upload Design">

        </div>

        <div class="submit-section mt-2">
            <button class="btn btn-primary submit-btn" type="submit">Save</button>
        </div>
    </div>
</form>
