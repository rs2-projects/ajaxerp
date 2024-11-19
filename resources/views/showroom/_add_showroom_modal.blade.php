<!-- Add Showroom Modal -->
<div id="addShowroomModal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <form style="width:100%" action="{{ route('showroom.store') }}" id="showroomStoreForm" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header erp-modal-header">
                    <h5 class="modal-title">Add New Showroom</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="erp-salary-tab-offcanvas">
                                <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-3 ">
                                    <div class="erp-filter-item flex-100">
                                        <div class="input-block mb-0 erp-step-input-block ">
                                            <label class="col-form-label">Name <span class="text-red">*</span></label>
                                            <input type="text" name="name" class="form-control" required>
                                            <span class="name_error ie-span"></span>
                                        </div>
                                    </div>
                                    <div class="erp-filter-item flex-100">
                                        <div class="input-block mb-0 erp-step-input-block ">
                                            <label class="col-form-label">Address </label>
                                            <textarea name="address" rows="3" class="form-control" ></textarea>
                                            <span class="address_error ie-span"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-3 flex-100">
                                <div class="erp-filter-item flex-100 mt-4">
                                    <div class="erp-search-btn-wrap text-center">
                                        <button class=" erp-search-btn text-center" type="submit">Save</button>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
<!-- /Add Showroom Modal -->
