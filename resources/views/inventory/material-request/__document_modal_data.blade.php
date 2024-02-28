
<div class="erp-modal-body-content">
    <div class="selected-loot-product d-flex align-items-center">
        <div class="slp-img-box me-2">
            <img src="{{ $item->finishedGoods->show_image }}" alt="">
        </div>
        <div class="slp-details-box">
            <h5>{{$item->finishedGoods->name}}</h5>
            <p class="em-id">Code: <span> #{{$item->finishedGoods->code?? 'N/A'}}</span></p>
        </div>
    </div>
    <div class="modal-do-document-wrapper mt-3">
        <div class="modal-do-document d-flex flex-wrap">
            <div class="modal-do-document-item">
                <a href="{{ asset($item->design_of_documents) }}" target="_blank" class="modal-do-document-item-img">
                    <img src="{{ asset('assets/img/product/documents.png') }}" alt="">
                    <h5>View</h5>
                </a>
            </div>
        </div>
    </div>
</div>