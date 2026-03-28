<div class="selected-loot-product d-flex align-items-center">
    <div class="slp-details-box">
        <h5>Invoice No: {{ $invoice->invoice_no }}</h5>
        <p class="em-id">{{ getFormattedDate($invoice->invoice_date) }}</p>
    </div>
</div>
<div class="modal-do-document-wrapper mt-3">
    <div class="modal-do-document d-flex flex-wrap">
        @php
            $hasDesigns = !empty($designs) && count($designs) > 0;
            $hasDeliveryReceipt = !empty($invoice->delivery_receipt_img);
            $hasGatepass = !empty($invoice->gatepass_img);
            $hasAnyFile = $hasDesigns || $hasDeliveryReceipt || $hasGatepass;
        @endphp

        @if($hasDesigns)
            @php
                $designCount = count($designs);
            @endphp
            @foreach($designs as $index => $design)
                <div class="modal-do-document-item">
                    <a href="{{ $design->show_image }}" target="_blank" class="modal-do-document-item-img">
                        <img src="{{ asset('/')}}assets/img/product/documents.png" alt="file">
                        <h5>{{ $designCount == 1 ? 'Design File' : 'Design' . ($index + 1) . ' File' }}</h5>
                    </a>
                </div>
            @endforeach
        @endif

        @if($hasDeliveryReceipt)
            <div class="modal-do-document-item">
                <a href="{{ asset($invoice->delivery_receipt_img) }}" target="_blank" class="modal-do-document-item-img">
                    <img src="{{ asset('/')}}assets/img/product/documents.png" alt="file">
                    <h5>Delivery Receipt</h5>
                </a>
            </div>
        @endif

        @if($hasGatepass)
            <div class="modal-do-document-item">
                <a href="{{ asset($invoice->gatepass_img) }}" target="_blank" class="modal-do-document-item-img">
                    <img src="{{ asset('/')}}assets/img/product/documents.png" alt="file">
                    <h5>Gatepass</h5>
                </a>
            </div>
        @endif

        @if(!$hasAnyFile)
            <p class="text-primary">No data found..!</p>
        @endif
    </div>

</div>
