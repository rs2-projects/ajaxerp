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
                                <h4 class="name">18MM PLYWOOD (1MM MDF + 16MM PLYWOOD + 1MM MDF) (E1)</h4>
                                <p class="code">Code: <span>BK.4118</span></p>
                                <p class="category">Category: <span>KITCHEN ITEMS</span></p>
                                <p class="type">Type: <span>Others</span></p>
                            </div>
                        </div>

                        <div class="pmdw-body">
                            <div class="pmdw-list-wrapper">
                                <div class="pmdwl-item">
                                    <div class="left">
                                        <p>
                                            Low Stock Warning :
                                            <span>50</span>
                                        </p>
                                    </div>
                                    <div class="right">
                                        <p>
                                            Low Stock At Least :
                                            <span>50</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="pmdwl-item">
                                    <div class="left">
                                        <p>
                                            Tax :
                                            <span>Govt Tax (50%)</span>
                                        </p>
                                    </div>
                                    <div class="right">
                                        <p>
                                            Unit :
                                            <span>METERS</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="pmdwl-item">
                                    <div class="left">
                                        <p>
                                            Color :
                                            <span>pink </span>
                                            <span class="color-box" style="background-color: pink;"></span>
                                        </p>
                                    </div>
                                    <div class="right">
                                        <p>
                                            Working Temperature :
                                            <span>100 Deg</span>
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
                                                <input type="text" class="form-control " value="50CM" name="length" disabled>
                                            </div>
                                        </div>
                                        <div class="erp-filter-item flex-32">
                                            <div class="input-block mb-0 erp-step-input-block ">
                                                <label class="col-form-label">Width </label>
                                                <input type="text" class="form-control " value="50CM" name="width" disabled>
                                            </div>
                                        </div>
                                        <div class="erp-filter-item flex-32">
                                            <div class="input-block mb-0 erp-step-input-block ">
                                                <label class="col-form-label">Thickness </label>
                                                <input type="text" class="form-control " value="5CM" name="thickness" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pmdwl-item">
                                    <div class="full">
                                        <p class="fs-5 mb-1">Remarks :</p>
                                        <p>
                                            <span>Lorem ipsum dolor sit amet consectetur, adipisicing elit.</span>
                                        </p>
                                    </div>
                                </div>

                                <div class="pmdwl-item">
                                    <div class="full">
                                        <p class="fs-5 mb-1">Description :</p>
                                        <p>
                                            <span>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Consequuntur debitis fugiat iste quas, commodi, officiis placeat vero quo molestias atque at. Quae odio sunt voluptates consequatur in officiis deleniti pariatur.</span>
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
                                    <h4 class="warehouse-details-title">Main Warehouse</h4>

                                </div>
                                <div class="wpi-child-item flex-100">
                                    <p class="warehouse-details-p">
                                        Warehouse 1 (Unloading Area)
                                    </p>
                                </div>
                            </div>
                        </div>



                        <div class="wbi-item">
                            <div class="new-warehouse-main-wrapper">
                                                                                                                    <div class="new-warehouse-section-body d-flex flex-wrap gap-2 justify-content-between">
                                            <div class="new-wsb-item flex-40">
                                                <div class="input-block mb-0 erp-step-input-block">
                                                    <label class="col-form-label">Section 1 <span class="text-danger">*</span></label>
                                                    <h4 class="warehouse-details-section-name">Line 1</h4>
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
                                                                                                                                                                                                        <div class="new-wsb-table-body-item-wrap d-flex flex-wrap align-items-center">
                                                                        <div class="new-wsb-table-body-item">
                                                                            <h5>1</h5>
                                                                        </div>
                                                                        <div class="new-wsb-table-body-item">
                                                                            <div class="input-block mb-0 erp-step-input-block">
                                                                                <h4 class="warehouse-subsection-name">Shelves 1</h4>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                                                                                        <div class="new-wsb-table-body-item-wrap d-flex flex-wrap align-items-center">
                                                                        <div class="new-wsb-table-body-item">
                                                                            <h5>2</h5>
                                                                        </div>
                                                                        <div class="new-wsb-table-body-item">
                                                                            <div class="input-block mb-0 erp-step-input-block">
                                                                                <h4 class="warehouse-subsection-name">Shelves</h4>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                                                                                                                                            </div>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                                                                <div class="new-warehouse-section-body d-flex flex-wrap gap-2 justify-content-between">
                                            <div class="new-wsb-item flex-40">
                                                <div class="input-block mb-0 erp-step-input-block">
                                                    <label class="col-form-label">Section 2 <span class="text-danger">*</span></label>
                                                    <h4 class="warehouse-details-section-name">Line 2</h4>
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
                                                                                                                                                                                                        <div class="new-wsb-table-body-item-wrap d-flex flex-wrap align-items-center">
                                                                        <div class="new-wsb-table-body-item">
                                                                            <h5>1</h5>
                                                                        </div>
                                                                        <div class="new-wsb-table-body-item">
                                                                            <div class="input-block mb-0 erp-step-input-block">
                                                                                <h4 class="warehouse-subsection-name">Shelves 1</h4>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                                                                                        <div class="new-wsb-table-body-item-wrap d-flex flex-wrap align-items-center">
                                                                        <div class="new-wsb-table-body-item">
                                                                            <h5>2</h5>
                                                                        </div>
                                                                        <div class="new-wsb-table-body-item">
                                                                            <div class="input-block mb-0 erp-step-input-block">
                                                                                <h4 class="warehouse-subsection-name">Shelves 2</h4>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                                                                                                                                            </div>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                                                        
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


