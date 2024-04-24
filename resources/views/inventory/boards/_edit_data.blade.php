<form action="{{ route('inventory.boards.update', $finished_good->id) }}" id="boardUpdateForm" method="post">
    @csrf
    <div class="erp-modal-body-content">
        <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-3 ">
            <div class="erp-filter-item flex-48">
                <div class="input-block mb-0 erp-step-input-block ">
                    <label class="col-form-label">Product Name <span class="text-red">*</span> </label>
                    <input type="text" class="form-control" value="{{ $finished_good->name??'' }}" name="name" required>
                </div>
            </div>
            <div class="erp-filter-item flex-48">
                <div class="input-block mb-0 erp-step-input-block ">
                    <label class="col-form-label">Product Image </label>
                    <input type="file" class="form-control " name="image" accept="image/*">
                </div>
            </div>
            <div class="erp-filter-item flex-48">
                <div class="input-block mb-0 erp-step-input-block ">
                    <label class="col-form-label">Product Code <span class="text-red">*</span></label>
                    <input type="text" class="form-control" value="{{ $finished_good->code }}" name="code" required>
                </div>
            </div>
            <div class="erp-filter-item flex-48">
                <div class="input-block erp-step-input-block mb-0 two">
                    <label class="col-form-label">Category <span class="text-red">*</span> <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Product Category"><i class="fa-duotone fa-exclamation"></i></span></label>
                    <select class="select select-step" name="finished_good_category_id" required>
                        <option value="">Select Category</option>
                        @foreach($finished_good_categories as $category)
                            <option value="{{ $category->id }}" {{( $category->id == $finished_good->finished_goods_category_id) ? 'selected' : ''}}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="erp-filter-item flex-48">
                <div class="input-block erp-step-input-block mb-0 two">
                    <label class="col-form-label">Embossed Up</label>
                    <select class="select select-step" name="embossed_up">
                        <option value="">Select Embossed Up</option>
                        @foreach($board_embosseds as $data)
                            <option value="{{ $data->id }}" {{( $data->id == $finished_good->embossed_up) ? 'selected' : ''}}>{{ $data->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="erp-filter-item flex-48">
                <div class="input-block erp-step-input-block mb-0 two">
                    <label class="col-form-label">Color Up</label>
                    <select class="select select-step" name="color_up">
                        <option value="">Select Color Up</option>
                        @foreach($board_colors as $data)
                            <option value="{{ $data->id }}" {{( $data->id == $finished_good->color_up) ? 'selected' : ''}}>{{ $data->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="erp-filter-item flex-48">
                <div class="input-block erp-step-input-block mb-0 two">
                    <label class="col-form-label">Embossed Down</label>
                    <select class="select select-step" name="embossed_down">
                        <option value="">Select Embossed Down</option>
                        @foreach($board_embosseds as $data)
                            <option value="{{ $data->id }}" {{( $data->id == $finished_good->embossed_down) ? 'selected' : ''}}>{{ $data->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="erp-filter-item flex-48">
                <div class="input-block erp-step-input-block mb-0 two">
                    <label class="col-form-label">Color Down</label>
                    <select class="select select-step" name="color_down">
                        <option value="">Select Color Down</option>
                        @foreach($board_colors as $data)
                            <option value="{{ $data->id }}" {{( $data->id == $finished_good->color_down) ? 'selected' : ''}}>{{ $data->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="erp-filter-item flex-100">
                <div class="input-block mb-0 erp-step-input-block ">
                    <label class="col-form-label">Description </label>
                    <textarea class="form-control" rows="3" name="description">{{ $finished_good->description }}</textarea>
                </div>
            </div>

            <div class="submit-section mt-2">
                <button class="btn btn-primary submit-btn" type="submit">Save</button>
            </div>
        </div>
    </div>
</form>
