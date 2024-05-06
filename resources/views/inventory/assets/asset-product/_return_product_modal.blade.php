<!-- Add Category Modal -->
<div id="return_product_modal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="" id="returnProductStoreForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header erp-modal-header">
                    <h5 class="modal-title">Return Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body erp-modal-body">
                    <div class="erp-modal-body-content">
                         <input type="hidden" name="asset_product_id" id="return_id" value="">
                        <div class="input-block mb-2">
                            <label class="col-form-label">Date <span class="text-danger">*</span></label>
                            <input class="form-control datetimepicker" type="text" name="return_date" value="{{ now()->format('Y-m-d') }}" required>
                            <span class="name_error ie-span"></span>
                        </div>

                        <div class="input-block  mb-2">
                            <label class="col-form-label">Return Type <span class="text-danger">*</span></label>
                            <select class="select select-step" name="return_type">
                                @foreach($return_types as $key=>$type)
                                    <option value="{{ $key }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-block  mb-3">
                            <label class="col-form-label">Reason <span class="text-danger">*</span></label>
                            <textarea cols="30" rows="3" class="form-control" name="return_reason" required></textarea>
                        </div>
                        <div class="submit-section mt-2">
                            <button class="btn btn-primary submit-btn" type="submit">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- /Add Department Modal -->
