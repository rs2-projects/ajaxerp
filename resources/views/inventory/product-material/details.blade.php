@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="">
        <div class="erp-employee-list-wrapper product-material-details-page mb-4">
            <div class="erp-main-filter-wrapper bg-card attd-table">
                <div class="my-attendance-box-item flex-100 ">
                    <div class="wbi-item">
                        <h2>Product Info</h2>
                    </div>
                    <div class="product-material-details-wrapper">
                        <div class="pmdw-header">
                            <div class="img">
                                <img src="https://staging.ajaxtradingcorp.com/storage/inventory/product-material/17273314964757.webp" alt="Material Name">
                            </div>
                            <div class="info">
                                <h4 class="name">{{ $product->name }}</h4>
                                <p class="code">Code: <span>{{ $product->code }}</span></p>
                                <p class="category">Category: <span>{{ $product->category->name }}</span></p>
                                <p class="type">Type: <span>{{ $product::TYPES[$product->type] ?? '' }}</span></p>
                            </div>
                        </div>

                        <div class="pmdw-body">
                            <div class="pmdw-list-wrapper">
                                <div class="pmdwl-item">
                                    <div class="left">
                                        <p>
                                            Low Stock Warning :
                                            <span>{{ $product->low_stock_warning }}</span>
                                        </p>
                                    </div>
                                    <div class="right">
                                        <p>
                                            Low Stock At Least :
                                            <span>{{ $product->low_stock_at_least }}</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="pmdwl-item">
                                    <div class="left">
                                        <p>
                                            Tax :
                                            <span>{{ $product->tax?->name ?? 'N/A' }} ({{ $product->tax?->tax_rate ?? 0 }}%)</span>
                                        </p>
                                    </div>
                                    <div class="right">
                                        <p>
                                            Unit :
                                            <span>{{ $product::UNIT_TYPES[$product->unit_type] ?? '' }}</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="pmdwl-item">
                                    <div class="left">
                                        <p>
                                            Color :
                                            @if($product->color != '')
                                                <span>{{ $product->color }}</span>
                                                <span class="color-box" style="background-color: {{ $product->color }};"></span>
                                            @else
                                                <span>N/A </span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="right">
                                        <p>
                                            Working Temperature :
                                            <span>{{ $product->working_temperature }}</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="pmdwl-item">
                                    <div class="messurement-wrapper flex-100 d-flex flex-wrap justify-content-between">
                                        <div class="erp-filter-item flex-100">
                                            <h4 class="offcanvas-title-erp">Measurement</h4>
                                        </div>
                                        <div class="erp-filter-item flex-32">
                                            <div class="input-block mb-0 erp-step-input-block ">
                                                <label class="col-form-label">Length </label>
                                                <input type="text" class="form-control " value="{{ $product->length }}" name="length" disabled>
                                            </div>
                                        </div>
                                        <div class="erp-filter-item flex-32">
                                            <div class="input-block mb-0 erp-step-input-block ">
                                                <label class="col-form-label">Width </label>
                                                <input type="text" class="form-control " value="{{ $product->width }}" name="width" disabled>
                                            </div>
                                        </div>
                                        <div class="erp-filter-item flex-32">
                                            <div class="input-block mb-0 erp-step-input-block ">
                                                <label class="col-form-label">Thickness </label>
                                                <input type="text" class="form-control " value="{{ $product->thickness }}" name="thickness" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pmdwl-item">
                                    <div class="full">
                                        <p class="fs-5 mb-1">Remarks :</p>
                                        <p>
                                            <span>{{ $product->remarks }}</span>
                                        </p>
                                    </div>
                                </div>

                                <div class="pmdwl-item">
                                    <div class="full">
                                        <p class="fs-5 mb-1">Description :</p>
                                        <p>
                                            <span>
                                                {!! $product->description !!}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="new-warhouse-wrapper">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="warehouse-basic-info bg-card attd-table">
                        <div class="wbi-item">
                            <h2>Warehouse Info</h2>
                        </div>
                        <div class="wbi-item">
                            <div class="wpi-child-item-wrapper d-flex flex-wrap gap-2">
                                <div class="wpi-child-item flex-100">
                                    <h4 class="warehouse-details-title">{{ $product->warehouse?->name }}</h4>

                                </div>
                                <div class="wpi-child-item flex-100">
                                    <p class="warehouse-details-p">
                                        {{ $product->warehouse?->description }}
                                    </p>
                                </div>
                            </div>
                        </div>



                        <div class="wbi-item">
                            <div class="new-warehouse-main-wrapper">
                                @if(count($product->materialWarehouseSections) > 0)
                                    @foreach ($product->materialWarehouseSections as $section)
                                        <div class="new-warehouse-section-body d-flex flex-wrap gap-2 justify-content-between">
                                            <div class="new-wsb-item flex-40">
                                                <div class="input-block mb-0 erp-step-input-block">
                                                    <label class="col-form-label">Section {{ $loop->iteration }} <span class="text-danger">*</span></label>
                                                    <h4 class="warehouse-details-section-name">{{ $section?->warehouseSection?->name }}</h4>
                                                </div>
                                            </div>
                                            <div class="new-wsb-item flex-58">
                                                <div class="new-wsb-sub-item-wrapper ">
                                                    <div class="new-wsb-sub-item flex-100">
                                                        <h2>Subsection (Inventory Storage Rack)</h2>
                                                    </div>
                                                    <div class="new-wsb-sub-item">
                                                        <div class="new-wsb-table-header d-flex flex-wrap align-items-center">
                                                            <div class="new-wsb-table-item">
                                                                <h4>Sl</h4>
                                                            </div>
                                                            <div class="new-wsb-table-item">
                                                                <h4>Subsection</h4>
                                                            </div>
                                                        </div>
                                                        <div class="new-wsb-table-body">
                                                            @foreach ($section->productMaterialRacks as $rack)
                                                                <div class="new-wsb-table-body-item-wrap d-flex flex-wrap align-items-center">
                                                                    <div class="new-wsb-table-body-item">
                                                                        <h5>1</h5>
                                                                    </div>
                                                                    <div class="new-wsb-table-body-item">
                                                                        <div class="input-block mb-0 erp-step-input-block">
                                                                            <h4 class="warehouse-subsection-name">{{ $rack?->warehouseSectionRack?->name }}</h4>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach    
                                                        </div>                                                                                       
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                    </div>
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
        var filterData = {
            keyword_filtered: '',
            category_filtered: '',
            stock_filter: '',
            status_filtered: 'all',
        };
        $(document).ready(function() {
            getData();
            initSectionMultipleSelect();
            initRackMultipleSelect();
            filterData.keyword_filtered = $("#keyword_filtered").val()
            $("#keyword_filtered").on('input', function () {
                filterData.keyword_filtered = $(this).val();
            });

            filterData.category_filtered = $("#category_filtered").val()
            $("#category_filtered").on('change', function () {
                filterData.category_filtered = $(this).val();
            });

            filterData.stock_filter = $("#stock_filter").val()
            $("#stock_filter").on('change', function () {
                filterData.stock_filter = $(this).val();
            });

            $('.status_type li').on('click', function () {
                filterData.status_filtered = $('.status_type .active').attr('data');
                getData();
            });

            $("#productMaterialStoreForm").on('submit', function (e) {
                var self = this;
                e.preventDefault();
                var formData = new FormData($(self)[0]);
                $(".ie-span").text("").hide();
                var url = $(self).attr('action');

                formPost(url, formData, function (res) {
                    if(res.status == 200){
                        $("#addProductMaterial").modal('hide');
                        resetStoreForm();
                        showSuccessAlert('Success',res.message)
                        getData();
                        let total_product = parseInt($("#total_product").text());
                        $("#total_product").text(total_product+1);
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');
            });

            $("#addProductMaterialSubmitBtn").on('click', function () {
                validateCustomForm("#productMaterialStoreForm");
            });
        });

        function resetStoreForm() {
            $("#productMaterialStoreForm")[0].reset()
            $('.select').select2('destroy').val('').select2();
            $("#sections_id").multipleSelect('destroy');
            $("#sections_id").val('');
            initSectionMultipleSelect();
            $("#racks_id").multipleSelect('destroy');
            $("#racks_id").val('');
            initRackMultipleSelect();
        }

        function validateCustomForm(form) {
            var tab1Fields = $(form).find(':input[required]');
            tab1Fields.each(function() {
                if (!$(this).val()) {
                    let inputName = $(this).attr('name');
                    inputName = inputName.split('_').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
                    inputName = inputName.replace(" Id", '');
                    showInfoAlert(inputName,'required');
                }
            });

            let sections = $("#sections_id").val();
            if(sections.length < 1) {
                showInfoAlert('Sections','required');
            }

            let racks = $("#racks_id").val();
            if(racks.length < 1) {
                showInfoAlert('Racks','required');
            }

        }

        function getData(){
            getPaginatedListData("{{ route('inventory.product-material.filtered') }}", "#ajax-data-load", filterData);
        }

        function getPaginatedData(button) {
            getPaginatedListData($(button).attr('data-href'), "#ajax-data-load", filterData);
        }

        function changeWarehouse(select){
            let warehouse_id = $(select).val();
            let url = "{{ route('inventory.product-material.get-sections-by-warehouse') }}";
            ajaxGet(url, {warehouse_id:warehouse_id}, function (response) {
                if (response.status == 200) {
                    $("#sections_id").html(response.view);
                    initSectionMultipleSelect();
                } else {
                    toastr.error(response.message);
                }
            });

        }

        function changeSections(select){
            let section_ids = $(select).val();
            let url = "{{ route('inventory.product-material.get-racks-by-sections') }}";
            ajaxGet(url, {section_ids:section_ids}, function (response) {
                if (response.status == 200) {
                    $("#racks_id").html(response.view);
                    initRackMultipleSelect();
                } else {
                    toastr.error(response.message);
                }
            });
        }

        function changeProductType(select){
            let type = $(select).val();
            if(type != 0){
                $("#category_section").hide();
                $("#category_select").removeAttr('required');
                $("#category_select").val('');
            }else{
                $("#category_section").show();
                $("#category_select").attr('required', 'true');

            }
        }

        /*function editItem(id){
            let url = "{{route('inventory.product-material.edit', ':id')}}";
            url = url.replace(':id', id);
            ajaxGet(url, {}, function (response) {
                if (response.status == 200) {
                    $("#edit_product_material_modal_body").html(response.view);
                    $("#editProductMaterialModal").modal('show');
                } else {
                    toastr.error(response.message);
                }
            }, 'default');
        }*/

        function purchaseHistory(id){
            let url = "{{route('inventory.product-material.purchase-history', ':id')}}";
            url = url.replace(':id', id);
            ajaxGet(url, {}, function (response) {
                if (response.status == 200) {
                    $("#purchase_history_modal_body").html(response.view);
                    $("#purchaseHistoryModal").modal('show');
                } else {
                    toastr.error(response.message);
                }
            }, 'default');
        }

        function initSectionMultipleSelect(){
            $('#sections_id').multipleSelect({
                filter: true,
                placeholder: 'Select Sections',
                minimumCountSelected: 6,
                filterPlaceholder: 'Search Sections',
                selectAll: true,
                onOpen: function () {
                    $(".section-multiselect .ms-drop ul>li:first-child label").contents().filter(function() {
                        return this.nodeType === 3;
                    }).replaceWith("Select All Sections");
                },
            });
        }
        function initRackMultipleSelect(){
            $('#racks_id').multipleSelect({
                filter: true,
                placeholder: 'Select Subsections',
                minimumCountSelected: 6,
                filterPlaceholder: 'Search Racks',
                selectAll: true,
                onOpen: function () {
                    $(".racks-multiselect .ms-drop ul>li:first-child label").contents().filter(function() {
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


