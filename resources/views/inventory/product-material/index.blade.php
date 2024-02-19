@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        @if(hasPermission( 'manage-product-material'))
            <div class="erp-add-employee-wrapper mb-3">
                <div class="erp-add-employee">
                    <a href="javascript:void(0)" class="btn add-btn erp-add-employee ms-2" data-bs-toggle="modal" data-bs-target="#addProductMaterial"><i class="fa-solid fa-plus"></i> New Product</a>
                </div>
            </div>
        @endif
        <div class="erp-employee-list-wrapper">
            <div class="erp-main-filter-wrapper bg-card attd-table">
                <div class="my-attendance-box-item flex-100 ">
                    <div class="my-attendance-report-wrapper">
                        <div class="erp-header-main-wrap d-flex justify-content-between align-items-center">
                            <div class="erp-box-header">
                                <h4>Total Product : <span class="total-material-product" id="total_product">{{ $total_product }}</span> </h4>
                            </div>
                            <div class="erp-filter-box d-flex align-items-center justify-content-end flex-70">

                                <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-end flex-100">
                                    <div class="erp-filter-item">
                                        <h6 class="me-2">Search By: </h6>
                                    </div>
                                    <div class="erp-filter-item flex-25">
                                        <div class=" form-focus select-focus custom-form-focus">
                                            <input type="text" id="keyword_filtered" class="form-control search-product-in" placeholder="Product Name / Code">

                                        </div>
                                    </div>
                                    <div class="erp-filter-item flex-20">
                                        <div class=" form-focus select-focus custom-form-focus">
                                            <select class="select floating select2-box" id="category_filtered">
                                                <option value="">Select Category</option>
                                                @foreach($material_categories as $material_category)
                                                    <option value="{{ $material_category->id }}"> {{ $material_category->name }} </option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                    <div class="erp-filter-item">
                                        <div class="erp-search-btn-wrap">
                                            <button class=" erp-search-btn" type="button" onclick="getData()">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="big-table pt-4">
                            <div class="de-table-wrapper" id="ajax-data-load">

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
    @include('inventory.product-material._add_product_material')
    @include('inventory.product-material._edit_product_material')
    @include('inventory.product-material._purchase_history_modal')
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
            category_filtered: ''
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

            $("#productMaterialStoreForm").on('submit', function (e) {
                var self = this;
                e.preventDefault();
                var formData = new FormData($(self)[0]);
                $(".ie-span").text("").hide();
                var url = $(self).attr('action');

                formPost(url, formData, function (res) {
                    if(res.status == 200){
                        $("#addProductMaterial").modal('hide');
                        $(self)[0].reset();
                        showSuccessAlert('Success',res.message)
                        getData();
                        let total_product = parseInt($("#total_product").text());
                        $("#total_product").text(total_product+1);
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');
            });



        });

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
                placeholder: 'Select Racks',
                minimumCountSelected: 6,
                filterPlaceholder: 'Search Racks',
                selectAll: true,
                onOpen: function () {
                    $(".racks-multiselect .ms-drop ul>li:first-child label").contents().filter(function() {
                        return this.nodeType === 3;
                    }).replaceWith("Select All Racks");
                },
            });
        }

    </script>
@endsection


