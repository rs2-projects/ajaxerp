<div class="modal-header erp-modal-header">
    <h5 class="modal-title">{{ $item->name }}'s Details</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body erp-modal-body">
    <div class="erp-modal-body-content">
        
        <div class="cls-view-wrapper">
            <div class="check-loot-status-view ">
                @if(count($itemDetails) > 0)
                    @foreach($itemDetails as $key => $itemDetail)
                        <div class="check-loot-status-item d-flex flex-wrap">
                            <div class="cls-serial">
                                <h4>{{ $key+1 }}</h4>
                            </div>
                            <div class="cls-details ">
                                <div class="cls-info-box d-flex justify-content-between align-items-center">
                                    <h5 class="cls-date">Date: <span class="ms-2">{{ getFormattedDate($itemDetail->updated_at, 'd M, Y') }}</span></h5>
                                    {{-- <h4 class="cls-po-no">P.O No. <span class="ms-2">{{ $history->materialPurchase->purchase_id??'N/A' }}</span></h4> --}}
                                </div>

                                <div class="cls-info-box d-flex justify-content-between align-items-center">
                                    <h5>Length: <span>{{ $itemDetail->length }}</span></h5>
                                    <h5>Width: <span>{{ $itemDetail->thickness }}</span></h5>
                                    <h5>Thickness: <span>{{ $itemDetail->width }}</span></h5>
                                </div>

                                <div class="cls-price-qty">
                                    <h4>Total Qty: <span>{{ $itemDetail->total_qty }}</span></h4>
                                    <h4>Available QTY: <span>{{ $itemDetail->available_qty }}</span></h4>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h4 class="text-danger text-center">No Data Found !</h4>
                @endif
            </div>
        </div>

    </div>
</div>
