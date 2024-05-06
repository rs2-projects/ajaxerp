@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        <div class="col-md-12">
            <div class="new-warhouse-wrapper">
                <div class="row justify-content-center">
                    <form action="{{ route('inventory.product-material.update',$product_material->id) }}" id="productMaterialUpdateForm" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="col-md-12">
                            <div class="erp-salary-tab-offcanvas">
                                <ul class="nav nav-tabs erp-nav-tabs justify-content-center" id="myTab" role="tablist">
                                    <li class="nav-item erp-nav-item" role="presentation">
                                        <button class="nav-link erp-nav-link active" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="home" aria-selected="true">Product Info</button>
                                    </li>
                                    <li class="nav-item erp-nav-item" role="presentation">
                                        <button class="nav-link erp-nav-link" id="address-tab" data-bs-toggle="tab" data-bs-target="#address" type="button" role="tab" aria-controls="profile" aria-selected="false" tabindex="-1">Materials Info</button>
                                    </li>
                                    <li class="nav-item erp-nav-item" role="presentation">
                                        <button class="nav-link erp-nav-link" id="warehouse-tab" data-bs-toggle="tab" data-bs-target="#warehouse" type="button" role="tab" aria-controls="profile" aria-selected="false" tabindex="-1">Warehouse Info</button>
                                    </li>


                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                        <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-3 ">
                                            <div class="erp-filter-item flex-48">
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">Product Name <span class="text-red">*</span> </label>
                                                    <input type="text" class="form-control" value="{{ $product_material->name??'' }}" name="name" required>
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-48">
                                                <div class="input-block erp-step-input-block mb-0 two">
                                                    <label class="col-form-label">Type <span class="text-red">*</span><span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Product Type"><i class="fa-duotone fa-exclamation"></i></span></label>
                                                    <select class="select select-step" name="type" required {{$product_material->countPurchaseDetails() > 0 ? 'disabled' : ''}}>
                                                        <option value="">Select Type</option>
                                                        @foreach($material_types as $key=>$type)
                                                            <option {{ ($key == $product_material->type) ? 'selected' : ''}} value="{{ $key }}">{{ $type }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if($product_material->countPurchaseDetails() > 0)
                                                        <small class="text-red">Can't change due to having purchase</small>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-100">
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">Product Image </label>
                                                    <input type="file" class="form-control " name="image" accept="image/*">
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-48">
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">Product Code <span class="text-red">*</span></label>
                                                    <input type="text" class="form-control " value="{{ $product_material->code }}" name="code" required>
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-48">
                                                <div class="input-block erp-step-input-block mb-0 two">
                                                    <label class="col-form-label">Category <span class="text-red">*</span> <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Product Category"><i class="fa-duotone fa-exclamation"></i></span></label>
                                                    <select class="select select-step" name="product_material_category_id" required>
                                                        <option value="">Select Category</option>
                                                        @foreach($material_categories as $category)
                                                            <option value="{{ $category->id }}" {{( $category->id == $product_material->product_material_category_id) ? 'selected' : ''}}>{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-48">
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">Low Stock Warning <span class="text-red">*</span></label>
                                                    <input type="number" class="form-control " value="{{ $product_material->low_stock_warning }}" name="low_stock_warning" required>
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-48">
                                                <div class="input-block erp-step-input-block mb-0 two">
                                                    <label class="col-form-label">Tax <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Product Tax"><i class="fa-duotone fa-exclamation"></i></span></label>
                                                    <select class="select select-step" name="tax_id">
                                                        <option value="">Select Tax Value</option>
                                                        @foreach($vats as $vat)
                                                            <option value="{{ $vat->id }}" {{ ($vat->id == $product_material->tax_id) ? 'selected' : '' }}>{{ $vat->tax_rate }}% {{ $vat->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-48">
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">Low Stock At least <span class="text-red">*</span></label>
                                                    <input type="number" class="form-control " value="{{ $product_material->low_stock_at_least }}" name="low_stock_at_least" required>
                                                </div>
                                            </div>

                                            <div class="erp-filter-item flex-48">
                                                <div class="input-block erp-step-input-block mb-0 two">
                                                    <label class="col-form-label">Unit <span class="text-red">*</span><span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Product Unit"><i class="fa-duotone fa-exclamation"></i></span></label>
                                                    <select class="select select-step" name="unit_type" required>
                                                        <option value="">Select Unit</option>
                                                        @foreach($units as $key=>$unit)
                                                            <option value="{{ $key }}" {{ ($key == $product_material->unit_type) ? 'selected' : '' }}>{{ $unit }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-100">
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">Description </label>
                                                    <textarea class="form-control" rows="3" name="description">{{ $product_material->description }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane fade " id="address" role="tabpanel" aria-labelledby="address-tab">
                                        <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center1 justify-content-between mb-3 ">
                                            <div class="erp-filter-item flex-48">
                                                <div class="input-block mb-0 erp-step-input-block  single-color-wrapper" style="display: {{ ($product_material->both_side_color == \App\Models\Products\ProductMaterial::BOTH_SIDE_COLOR_YES)?'none':'' }};" >
                                                    <label class="col-form-label">Color </label>
                                                    <input type="text" class="form-control " value="{{ $product_material->color }}" name="color">
                                                </div>
                                                <div class="row multiple-color-wrapper"  style="display: {{ ($product_material->both_side_color == \App\Models\Products\ProductMaterial::BOTH_SIDE_COLOR_NO)?'none':'' }};">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label class="col-form-label">Upside Color</label>
                                                            <input type="text" class="form-control " name="upside_color" value="{{ $product_material->color }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label class="col-form-label">Downside Color</label>
                                                            <input type="text" class="form-control " name="downside_color" value="{{ $product_material->downside_color }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <label>
                                                    Both Side Color? <input type="checkbox" onchange="changeBothSideColor(this, '#productMaterialUpdateForm')" {{ ($product_material->both_side_color == \App\Models\Products\ProductMaterial::BOTH_SIDE_COLOR_YES)?'checked':'' }} name="both_side_color" value="1">
                                                </label>
                                            </div>
                                            <div class="erp-filter-item flex-48">
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">Working Temperature </label>
                                                    <input type="text" class="form-control" value="{{ $product_material->working_temperature}}" name="working_temperature">
                                                </div>
                                            </div>
                                            <div class="messurement-wrapper flex-100 d-flex flex-wrap justify-content-between">
                                                <div class="erp-filter-item flex-100">
                                                    <h4 class="offcanvas-title-erp">Measurement</h4>
                                                </div>
                                                <div class="erp-filter-item flex-32">
                                                    <div class="input-block mb-0 erp-step-input-block ">
                                                        <label class="col-form-label">Length </label>
                                                        <input type="text" class="form-control " value="{{ $product_material->length }}" name="length">
                                                    </div>
                                                </div>
                                                <div class="erp-filter-item flex-32">
                                                    <div class="input-block mb-0 erp-step-input-block ">
                                                        <label class="col-form-label">Width </label>
                                                        <input type="text" class="form-control " value="{{ $product_material->width }}" name="width">
                                                    </div>
                                                </div>
                                                <div class="erp-filter-item flex-32">
                                                    <div class="input-block mb-0 erp-step-input-block ">
                                                        <label class="col-form-label">Thickness </label>
                                                        <input type="text" class="form-control " value="{{ $product_material->thickness }}" name="thickness">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-100">
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">Remarks </label>
                                                    <input type="text" class="form-control " value="{{ $product_material->remarks }}" name="remarks">
                                                </div>
                                            </div>


                                        </div>

                                    </div>
                                    <div class="tab-pane fade " id="warehouse" role="tabpanel" aria-labelledby="warehouse-tab">
                                        <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-3 ">
                                            <div class="erp-filter-item flex-100">
                                                <div class="input-block erp-step-input-block mb-0 two">
                                                    <label class="col-form-label">Warehouse <span class="text-red">*</span><span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Warehouse"><i class="fa-duotone fa-exclamation"></i></span></label>
                                                    <select class="select select-step" name="warehouse_id" id="warehouse_id" onchange="changeWarehouse(this)" required>
                                                        <option name="">Select Warehouse</option>
                                                        @foreach($warehouses as $warehouse)
                                                            <option value="{{ $warehouse->id }}" {{ ($product_material->warehouse_id == $warehouse->id) ? 'selected' : ''}}>{{ $warehouse->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-100">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <label class="col-form-label">Select Section(Line) <span class="text-danger">*</span></label>
                                                    <select class="section-multiselect sections" multiple="multiple" onchange="changeSections(this)" name="sections[]" id="sections_id" required>
                                                        @foreach($sections as $section)
                                                            <option value="{{ $section->id }}" {{ in_array($section->id, $product_material_sections) ? 'selected' : '' }}>{{ $section->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-100">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <label class="col-form-label">Select Subsection <span class="text-danger">*</span></label>
                                                    <select class="racks-multiselect racks" multiple="multiple" name="racks[]" id="racks_id" required>
                                                        @foreach($racks as $rack)
                                                            <option value="{{ $rack->id }}" {{ in_array($rack->id, $product_material_racks) ? 'selected' : '' }}>{{ $rack->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="erp-filter-item flex-100">
                                                <div class="input-block mb-0 erp-step-input-block ">
                                                    <label class="col-form-label">Comments </label>
                                                    <input type="text" class="form-control " value="{{ $product_material->comments }}" name="comments">
                                                </div>
                                            </div>


                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-3 flex-100">

                                <div class="erp-filter-item flex-100 mt-4">
                                    <div class="erp-search-btn-wrap text-center">
                                        <button class=" erp-search-btn text-center" id="editProductMaterialSubmitBtn" type="submit">Save</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
    <!--End::row-1 -->
@endsection

@section('modals')

@endsection

@section('css')

@endsection

@section('css_plugins')

@endsection

@section('js_plugins')
    <!-- MULTI SELECT JS-->
    <script src="{{asset('assets/plugins/multipleselect/multiple-select.js')}}"></script>
    <script src="{{asset('assets/plugins/multipleselect/multi-select.js')}}"></script>
@endsection

@section('js')
    <script>
        $(document).ready(function () {

            initSectionMultipleSelect();
            initRackMultipleSelect();

            $("#productMaterialUpdateForm").on('submit', function (e) {
                var self = this;
                e.preventDefault();
                var formData = new FormData($(self)[0]);
                $(".ie-span").text("").hide();
                var url = $(self).attr('action');

                formPost(url, formData, function (res) {
                    if (res.status == 200) {
                        showSuccessAlert('Success', res.message)
                        window.location.href = "{{ route('inventory.product-material.index') }}";
                    } else {
                        showErrorAlert('Error', res.message)
                    }
                }, 'show_input_error');
            });

            $("#editProductMaterialSubmitBtn").on('click', function () {
                validateCustomForm("#productMaterialStoreForm");
            });

        });

        function validateCustomForm(form) {
            var tab1Fields = $(form).find(':input[required]');
            tab1Fields.each(function () {
                if (!$(this).val()) {
                    let inputName = $(this).attr('name');
                    inputName = inputName.split('_').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
                    inputName = inputName.replace(" Id", '');
                    showInfoAlert(inputName, 'required');
                }
            });

            let sections = $("#sections_id").val();
            if (sections.length < 1) {
                showInfoAlert('Sections', 'required');
            }

            let racks = $("#racks_id").val();
            if (racks.length < 1) {
                showInfoAlert('Racks', 'required');

            }
        }

        function changeWarehouse(select) {
            let warehouse_id = $(select).val();
            let url = "{{ route('inventory.product-material.get-sections-by-warehouse') }}";
            ajaxGet(url, {warehouse_id: warehouse_id}, function (response) {
                if (response.status == 200) {
                    $("#sections_id").html(response.view);
                    initSectionMultipleSelect();
                } else {
                    toastr.error(response.message);
                }
            });

        }

        function changeSections(select) {

            let section_ids = $(select).val();
            let url = "{{ route('inventory.product-material.get-racks-by-sections') }}";
            ajaxGet(url, {section_ids: section_ids}, function (response) {
                if (response.status == 200) {
                    $("#racks_id").html(response.view);
                    initRackMultipleSelect();
                } else {
                    toastr.error(response.message);
                }
            });
        }

        function initSectionMultipleSelect() {
            $('#sections_id').multipleSelect({
                filter: true,
                placeholder: 'Select Sections',
                minimumCountSelected: 6,
                filterPlaceholder: 'Search Sections',
                selectAll: true,
                onOpen: function () {
                    $(".section-multiselect .ms-drop ul>li:first-child label").contents().filter(function () {
                        return this.nodeType === 3;
                    }).replaceWith("Select All Sections");
                },
            });
        }

        function initRackMultipleSelect() {
            $('#racks_id').multipleSelect({
                filter: true,
                placeholder: 'Select Subsection',
                minimumCountSelected: 6,
                filterPlaceholder: 'Search Racks',
                selectAll: true,
                onOpen: function () {
                    $(".racks-multiselect .ms-drop ul>li:first-child label").contents().filter(function () {
                        return this.nodeType === 3;
                    }).replaceWith("Select All Subsections");
                },
            });
        }

        function changeBothSideColor(checkbox, parent_element) {
            if($(checkbox).is(':checked')) {
                $(parent_element + ' .single-color-wrapper').slideUp();
                $(parent_element + ' .multiple-color-wrapper').slideDown();
            } else {
                $(parent_element + ' .single-color-wrapper').slideDown();
                $(parent_element + ' .multiple-color-wrapper').slideUp();
            }
        }
    </script>
@endsection


