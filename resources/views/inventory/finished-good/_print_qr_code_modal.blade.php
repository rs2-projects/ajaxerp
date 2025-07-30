<div class="modal fade" id="printQrCodeModal" tabindex="-1" aria-labelledby="scanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Print QR Code</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close">x</button>
            </div>

            <form action="{{ route('inventory.finished-good.print-qr-code') }}" method="post" id="printQrCodeForm" target="_blank">
                @csrf
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 20px;" class="text-center p-1">
                                        <input type="checkbox" disabled>
                                    </th>
                                    <th class="p-1" style="width: 50%;">Name</th>
                                    <th class="p-1" style="width: 30%;">QR Code Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($finished_goods as $index => $finished_good)
                                    <tr class="align-middle">
                                        <td class="text-center p-1">
                                            <input type="checkbox" name="item_id[{{ $index }}]" value="{{ $finished_good->id }}">
                                        </td>
                                        <td class="p-1" style="white-space: normal;">{{ $finished_good->name }}</td>
                                        <td class="p-1">
                                            <input class="form-control form-control-sm" name="qty[{{ $index }}]" placeholder="Enter Qty" type="text" style="height: 30px;">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
