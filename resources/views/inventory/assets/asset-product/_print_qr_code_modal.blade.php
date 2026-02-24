<div class="modal fade" id="printQrCodeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Print QR Code</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close">x</button>
            </div>

            <form action="{{ route('inventory.asset-product.print-qr-code') }}" method="post" id="printQrCodeForm" target="_blank">
                @csrf
                <input type="hidden" name="item_id[0]" id="print_qr_item_id">

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="print_qr_product_name" readonly>
                    </div>

                    <div>
                        <label for="print_qr_qty" class="form-label">Print Qty</label>
                        <input class="form-control" id="print_qr_qty" name="qty[0]" type="number" min="1" required>
                    </div>
                </div>

                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Print</button>
                </div>
            </form>
        </div>
    </div>
</div>
