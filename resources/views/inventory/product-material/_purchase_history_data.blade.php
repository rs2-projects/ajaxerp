<div class="modal-header erp-modal-header">
    <h5 class="modal-title">Material Details</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body erp-modal-body">
    <div class="erp-modal-body-content">
        <div class="selected-loot-product d-flex align-items-center">
            <div class="slp-img-box me-2">
                <img src="{{ asset($productMaterial->show_image) }}" alt="">
            </div>
            <div class="slp-details-box">
                <h5>{{ $productMaterial->name??'N/A' }}</h5>
                <p class="em-id">Code: <span> #{{ $productMaterial->code??'N/A' }}</span></p>
            </div>
        </div>
        <div class="cls-view-wrapper">
            <div class="check-loot-status-view ">
                @if(count($purchase_history) > 0)
                    @foreach($purchase_history as $key => $history)
                        <div class="check-loot-status-item d-flex flex-wrap">
                            <div class="cls-serial">
                                <h4>{{ $key+1 }}</h4>
                            </div>
                            <div class="cls-details ">
                                <div class="cls-info-box d-flex justify-content-between align-items-center">
                                    <h5 class="cls-date">Date: <span class="ms-2">{{ getFormattedDate($history->materialPurchase->purchase_date, 'd M, Y') }}</span></h5>
                                    <h4 class="cls-po-no">P.O No. <span class="ms-2">{{ $history->materialPurchase->purchase_id??'N/A' }}</span></h4>
                                </div>


                                <div class="cls-price-qty">
                                    <h4>Final Price: <span>{{ getCurrencySymbol() }} {{ showAmount($history->final_price) }}</span></h4>
                                    <h4>QTY: <span>{{ $history->qty }}</span></h4>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h4 class="text-danger text-center">Purchase Data Empty !</h4>
                @endif
            </div>
        </div>

    </div>
</div>
