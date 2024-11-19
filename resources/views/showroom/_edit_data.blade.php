<form action="{{ route('showroom.update', $item->id) }}" id="showroomUpdateForm" method="post">
    @csrf
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="erp-salary-tab-offcanvas">
                    <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-3 ">
                        <div class="erp-filter-item flex-100">
                            <div class="input-block mb-0 erp-step-input-block ">
                                <label class="col-form-label">Name <span class="text-red">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ $item->name }}" required>
                                <span class="name_error ie-span"></span>
                            </div>
                        </div>
                        <div class="erp-filter-item flex-100">
                            <div class="input-block mb-0 erp-step-input-block ">
                                <label class="col-form-label">Address </label>
                                <textarea name="address" rows="3" class="form-control" >{!! $item->address !!}</textarea>
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
</form>
