<div class="selected-loot-product d-flex align-items-center">
    <div class="slp-details-box">
        <h5>Invoice No: {{ $invoice->invoice_no }}</h5>
        <p class="em-id">{{ getFormattedDate($invoice->invoice_date) }}</p>
    </div>
</div>
<div class="modal-do-document-wrapper mt-3">
    <div class="modal-do-document d-flex flex-wrap">
        @foreach($designs as $design)
        <div class="modal-do-document-item">
            <a href="{{ $design->show_image }}" target="_blank" class="modal-do-document-item-img">
                <img src="{{ $design->show_image }}" alt="">
                <h5>View</h5>
            </a>
        </div>
        @endforeach
    </div>

</div>
