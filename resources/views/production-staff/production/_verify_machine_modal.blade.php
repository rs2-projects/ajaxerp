<!-- Add Department Modal -->
<div id="verifyMachineModal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header erp-modal-header">
                <h5 class="modal-title">Verify Machine</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body erp-modal-body" id="verify_machine_modal_body">
                <form action="#" id="verifyMachineForm">
                    <div class="form-group">
                        <label class="mb-2" for="scanning_machine_code">Scan QrCode</label>
                        <input type="text" class="form-control" id="scanning_machine_code" placeholder="Scan QrCode">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" onclick="verifyMachine()" class="btn btn-primary">Check</button>
            </div>
        </div>
    </div>
</div>
<!-- /Add Department Modal -->
