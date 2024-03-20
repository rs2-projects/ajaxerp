<div class="selected-loot-product d-flex align-items-center">
    <div class="slp-details-box">
        <h5>Invoice No: {{ $invoice->invoice_no }}</h5>
        <p class="em-id">{{ getFormattedDate($invoice->invoice_date) }}</p>
    </div>
</div>
<div class="modal-do-document-wrapper mt-3">
    <div class="modal-do-document d-flex flex-wrap">
        @forelse($designs as $design)
        <div class="modal-do-document-item">
            <a href="{{ $design->show_image }}" target="_blank" class="modal-do-document-item-img">
                <img src="{{ asset('/')}}assets/img/product/documents.png" alt="file">
                <h5>{{ $design->design_name }}</h5>
            </a>
        </div>
        @empty
               <p class="text-primary">No data found..!</p>
        @endforelse
    </div>

</div>
