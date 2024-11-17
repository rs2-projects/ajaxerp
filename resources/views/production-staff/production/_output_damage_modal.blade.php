<!-- Output Damage Modal -->
<div id="outputDamageModal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header erp-modal-header">
                <h5 class="modal-title">Damage Output?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body erp-modal-body" id="output_damage_modal_body">
                <form action="" method="GET" id="outputDamageForm">
                </form>

                <div class="row">
                    <div class="col-md-6">
                        <button type="button" class="btn btn-primary btn-block" onclick="openReuse()">Re-Use</button>
                        {{-- <input type="button" name="damage_type" value="Reuse" class="btn btn-primary btn-block"> --}}
                    </div>
                    <div class="col-md-6">
                        {{-- <input type="button" name="damage_type" value="Damage" class="btn btn-danger btn-block"> --}}
                        <button type="button" class="btn btn-danger btn-block" onclick="submitDamageOutput('dispose')">Dispose</button>
                    </div>
                </div>

                <div class="reuseDetails" id="reuseDetails" style="display: none;">
                    <h4>Re-Use Details:</h4>
                    <div class="row">
                        <div class="col-md-4 mt-2">
                            <label for="reuse_length" class="form-label">Length</label>
                            <input type="text" name="reuse_length" id="reuse_length" class="form-control">
                        </div>
                        <div class="col-md-4 mt-2">
                            <label for="reuse_width" class="form-label">Width</label>
                            <input type="text" name="reuse_width" id="reuse_width" class="form-control">
                        </div>
                        <div class="col-md-4 mt-2">
                            <label for="reuse_thickness" class="form-label">Thickness</label>
                            <input type="text" name="reuse_thickness" id="reuse_thickness" class="form-control">
                        </div>
                        <div class="col-md-12 text-center mt-4">
                            <button type="button" class="btn btn-primary" onclick="submitDamageOutput('reuse')">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Output Damage Modal -->
