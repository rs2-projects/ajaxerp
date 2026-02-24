@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        @if(hasPermission('manage-asset-product'))
            <div class="erp-add-employee-wrapper mb-3">
                <div class="erp-add-employee">
                    <a href="javascript:void(0)" class="btn add-btn erp-add-employee" data-bs-toggle="modal" data-bs-target="#addProductModal"><i class="fa-solid fa-plus"></i> Add Product</a>

                </div>
            </div>
        @endif
        <div class="erp-employee-list-wrapper">
            <div class="erp-main-filter-wrapper bg-card attd-table">
                <div class="my-attendance-box-item flex-100 ">
                    <div class="my-attendance-report-wrapper">
                        <div class="erp-header-main-wrap mb-4 d-flex justify-content-between align-items-center">
                            <div class="erp-box-header">
                                {{-- <h4>Total Product : {{$product_count}}</h4> --}}
                            </div>
                            <div class="erp-filter-box d-flex align-items-center justify-content-end flex-70">
                                <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-end flex-100">
                                    <div class="erp-filter-item">
                                        <h6 class="me-2">Search By: </h6>
                                    </div>
                                    <div class="erp-filter-item flex-25">
                                        <div class=" form-focus select-focus custom-form-focus">
                                            <input type="text" class="form-control search-product-in"
                                                placeholder="Product Name" id="keyword_filtered">

                                        </div>
                                    </div>
                                    <div class="erp-filter-item flex-20">
                                        <div class=" form-focus select-focus custom-form-focus">
                                            <select class="select floating select2-box" id="category_id">
                                                <option value="">Select Category</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="erp-filter-item">
                                        <div class="erp-search-btn-wrap">
                                            <button class=" erp-search-btn" onclick="getData()">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <ul class="nav nav-tabs erp-nav-tabs justify-content-center status_type" id="myTab" role="tablist">
                            <li class="nav-item erp-nav-item" role="presentation">
                                <button class="nav-link active erp-nav-link" data="all" id="all-purchase-tab" data-bs-toggle="tab" data-bs-target="#all-purchase" type="button" role="tab" aria-controls="home" aria-selected="true">All</button>
                            </li>
                            <li class="nav-item erp-nav-item" role="presentation">
                                <button class="nav-link erp-nav-link" data="available" id="all-purchase-tab" data-bs-toggle="tab" data-bs-target="#all-purchase" type="button" role="tab" aria-controls="home" aria-selected="false">Available</button>
                            </li>
                            <li class="nav-item erp-nav-item" role="presentation">
                                <button class="nav-link erp-nav-link" data="assigned" id="new-purchase-tab" data-bs-toggle="tab" data-bs-target="#new-purchase" type="button" role="tab" aria-controls="profile" aria-selected="false">Assigned</button>
                            </li>
                            <li class="nav-item erp-nav-item" role="presentation">
                                <button class="nav-link erp-nav-link" data="maintenance" id="all-purchase-tab" data-bs-toggle="tab" data-bs-target="#all-purchase" type="button" role="tab" aria-controls="home" aria-selected="false">In Maintenance</button>
                            </li>
                            <li class="nav-item erp-nav-item" role="presentation">
                                <button class="nav-link erp-nav-link" data="sold" id="all-purchase-tab" data-bs-toggle="tab" data-bs-target="#all-purchase" type="button" role="tab" aria-controls="home" aria-selected="false">Sold</button>
                            </li>
                            <li class="nav-item erp-nav-item" role="presentation">
                                <button class="nav-link erp-nav-link" data="disposed" id="all-purchase-tab" data-bs-toggle="tab" data-bs-target="#all-purchase" type="button" role="tab" aria-controls="home" aria-selected="false">Disposed</button>
                            </li>
                        </ul>

                        <div class="table-main-wrapper pt-4" id="ajax-data-load">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End::row-1 -->
@endsection

@section('modals')
    @include('inventory.assets.asset-product._add_product_modal')
    @include('inventory.assets.asset-product._edit_product_modal')
    @include('inventory.assets.asset-product._assign_product_modal')
    @include('inventory.assets.asset-product._maintenance_product_modal')
    @include('inventory.assets.asset-product._sell_product_modal')
    @include('inventory.assets.asset-product._disposed_product_modal')
    @include('inventory.assets.asset-product._assign_details_modal')
    @include('inventory.assets.asset-product._asset_product_details_modal')
    @include('inventory.assets.asset-product._return_product_modal')
    @include('inventory.assets.asset-product._repair_product_modal')
    @include('inventory.assets.asset-product._print_qr_code_modal')
@endsection

@section('css')
    <style>
        .edit-img-src{
            margin-left: 5px;
            border-radius: 5px;
        }
    </style>
@endsection

@section('css_plugins')
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}">
@endsection

@section('js_plugins')
    <script src="{{asset('assets/js/moment.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap-datetimepicker.min.js')}}"></script>
@endsection

@section('js')
    <script>
        var filterData = {
            keyword_filtered: '',
            category_id : '',
            status_filtered: 'all',
        };
        $(document).ready(function() {
            initializeDatepicker();
            getData();
            
            filterData.keyword_filtered = $("#keyword_filtered").val();
            filterData.category_id = $("#category_id").val();
            $("#keyword_filtered").on('input', function () {
                filterData.keyword_filtered = $(this).val();
            });

            $("#category_id").on('change', function (){
                filterData.category_id = $(this).val();
            });
            
            $('.status_type li').on('click', function () {
                filterData.status_filtered = $('.status_type .active').attr('data');
                getData();
            });

            $("#productStoreForm").on('submit', function (e) {
                var self = this;
                e.preventDefault();
                var formData = new FormData($(self)[0]);
                $(".ie-span").text("").hide();
                var url = $(self).attr('action');

                formPost(url, formData, function (res) {
                    if(res.status == 200){
                        $("#addProductModal").modal('hide');
                        $(self)[0].reset();
                        showSuccessAlert('Success',res.message)
                        getData();
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');
            });

            $(document).on("submit", "#productUpdateForm", function(e) {
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                $(".ie-span").text("").hide();
                var url = $(this).attr('action');

                formPost(url, formData, function (res){
                    if(res.status == 200){
                        $("#editProductModal").modal('hide');
                        showSuccessAlert('Success',res.message)
                        getData();
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');
            });

            // assign
            $(document).on("submit", "#assignProductStoreForm", function(e) {
                e.preventDefault();
                var self = this;
                var formData = new FormData($(this)[0]);
                $(".ie-span").text("").hide();
                let id = $("#assign_id").val();
                let url = "{{route('inventory.asset-product.assign-asset-product', ':id')}}";
                url = url.replace(':id', id);
                formPost(url, formData, function (res){
                    if(res.status == 200){
                        $("#assign_product_modal").modal('hide');
                        $("#assign_id").val("");
                        $(self)[0].reset();
                        $('#department_id').trigger('change');
                        $('#designation_id').trigger('change');
                        $('#employee_id').trigger('change');
                        showSuccessAlert('Success',res.message)
                        getData();
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');
            });

            // maintenance
            $(document).on("submit", "#maintenanceProductStoreForm", function(e) {
                e.preventDefault();
                var self = this;
                var formData = new FormData($(this)[0]);
                $(".ie-span").text("").hide();
                let id = $("#maintenance_id").val();
                let url = "{{route('inventory.asset-product.maintenance-asset-product', ':id')}}";
                url = url.replace(':id', id);
                formPost(url, formData, function (res){
                    if(res.status == 200){
                        $("#maintenance_product_modal").modal('hide');
                        $(self)[0].reset();
                        showSuccessAlert('Success',res.message)
                        getData();
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');
            });

            // sell
            $('#sell_qty, #unit_sell_price').on('input', function() {
                var qty = parseFloat($('#sell_qty').val());
                var unitPrice = parseFloat($('#unit_sell_price').val());
                if(qty && unitPrice){
                    var totalPrice = qty * unitPrice;
                    $('#total_sell_price').val(totalPrice.toFixed(2));
                }else{
                    $('#total_sell_price').val(0);
                }
            });

            $(document).on("submit", "#sellProductStoreForm", function(e) {
                e.preventDefault();
                var self = this;
                var formData = new FormData($(this)[0]);
                $(".ie-span").text("").hide();
                let id = $("#sell_id").val();
                let url = "{{route('inventory.asset-product.sell-asset-product', ':id')}}";
                url = url.replace(':id', id);
                formPost(url, formData, function (res){
                    if(res.status == 200){
                        $("#sell_product_modal").modal('hide');
                        $(self)[0].reset();
                        $('#account_id').trigger('change');
                        $('#acc_cat_id').trigger('change');
                        showSuccessAlert('Success',res.message)
                        getData();
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');
            });

            $(document).on("submit", "#disposedProductStoreForm", function(e) {
                e.preventDefault();
                var self = this;
                var formData = new FormData($(this)[0]);
                $(".ie-span").text("").hide();
                let id = $("#disposed_id").val();
                let url = "{{route('inventory.asset-product.disposed-asset-product', ':id')}}";
                url = url.replace(':id', id);
                formPost(url, formData, function (res){
                    if(res.status == 200){
                        $("#disposed_product_modal").modal('hide');
                        $(self)[0].reset();
                        showSuccessAlert('Success',res.message)
                        getData();
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');
            });

            // return
            $(document).on("submit", "#returnProductStoreForm", function(e) {
                e.preventDefault();
                var self = this;
                var formData = new FormData($(this)[0]);
                $(".ie-span").text("").hide();
                let id = $("#return_id").val();
                let url = "{{route('inventory.asset-product.return-asset-product', ':id')}}";
                url = url.replace(':id', id);
                formPost(url, formData, function (res){
                    if(res.status == 200){
                        $("#return_product_modal").modal('hide');
                        $(self)[0].reset();
                        showSuccessAlert('Success',res.message)
                        getData();
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');
            });

            // repair
            $(document).on("submit", "#repairProductStoreForm", function(e) {
                e.preventDefault();
                var self = this;
                var formData = new FormData($(this)[0]);
                $(".ie-span").text("").hide();
                let id = $("#repair_id").val();
                let url = "{{route('inventory.asset-product.repair-asset-product', ':id')}}";
                url = url.replace(':id', id);
                formPost(url, formData, function (res){
                    if(res.status == 200){
                        $("#repair_product_modal").modal('hide');
                        $(self)[0].reset();
                        showSuccessAlert('Success',res.message)
                        getData();
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');
            });

        });

        function getData(){
            getPaginatedListData("{{ route('inventory.asset-product.filtered') }}", "#ajax-data-load", filterData);
        }

        function getPaginatedData(button) {
            getPaginatedListData($(button).attr('data-href'), "#ajax-data-load", filterData);
        }

        function editItem(id){
            let url = "{{route('inventory.asset-product.edit', ':id')}}";
            url = url.replace(':id', id);
            ajaxGet(url, {}, function (response) {
                if (response.status == 200) {
                    $("#edit_product_modal_body").html(response.view);
                    $("#editProductModal").modal('show');
                    initializeSelect()
                } else {
                    toastr.error(response.message);
                }
            }, 'default');
        }

        function viewItem(id, type){
            let url = "{{route('inventory.asset-product.asset-details', ['id' => ':id', 'type' => ':type'])}}";
            url = url.replace(':id', id);
            url = url.replace(':type', type);
            ajaxGet(url, {}, function (response) {
                if (response.status == 200) {
                    $("#assign_details_modal_body").html(response.view);
                    $("#assign_details_modal").modal('show');
                } else {
                    toastr.error(response.message);
                }
            }, 'default');
        }

        function viewAssetProductDetails(id){
            let url = "{{route('inventory.asset-product.product-details', ':id')}}";
            url = url.replace(':id', id);
            ajaxGet(url, {}, function (response) {
                if (response.status == 200) {
                    $("#asset_product_details_modal_body").html(response.view);
                    $("#asset_product_details_modal").modal('show');
                } else {
                    toastr.error(response.message);
                }
            }, 'default');
        }

        function assignItem(id){
            $("#assign_product_modal").modal('show');
            $("#assign_id").val(id);
        }

        function maintenceItem(id){
            $("#maintenance_product_modal").modal('show');
            $("#maintenance_id").val(id);
        }

        function sellItem(id){
            $("#sell_product_modal").modal('show');
            $("#sell_id").val(id);
        }

        function disposeItem(id){
            $("#disposed_product_modal").modal('show');
            $("#disposed_id").val(id);
        }

        function returnItem(id){
            $("#return_product_modal").modal('show');
            $("#return_id").val(id);
        }

        function repairedItem(id){
            $("#repair_product_modal").modal('show');
            $("#repair_id").val(id);
        }

        function printQrCode(id, name, totalPurchasedQty){
            $("#print_qr_item_id").val(id);
            $("#print_qr_product_name").val(name);
            $("#print_qr_qty").val(totalPurchasedQty > 0 ? totalPurchasedQty : 1);
            $("#printQrCodeModal").modal('show');
        }

        function assignToMaintenanceItem(id, asset_id, type){
            if(type){
                let url = "{{route('inventory.asset-product.assigned-details', ':id')}}";
                url = url.replace(':id', id);
                ajaxGet(url, {}, function (response) {
                    if (response.status == 200) {
                        let data = response?.data?.assign_details;
                        $("#maintenance_product_modal").modal('show');
                        $("#maintenance_id").val(asset_id);
                        $("#asset_assign_id").val(id);
                        $("#maintenance_type").val(type);
                        $("#maintenance_date").val(data.date);
                        $("#maintenance_sl_no").val(data.sl_no);
                        $("#maintenance_model").val(data.model);
                        $("#maintenance_warranty_date").val(data.warranty);
                        $("#maintenance_reason").val(data.reason);
                        $("#maintenance_remarks").val(data.remarks);
                    } else {
                        toastr.error(response.message);
                    }
                }, 'default');
            }

        }

        $('#maintenance_product_modal').on('hidden.bs.modal', function (e) {
            var today = new Date();
            var formattedDate = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
            $("#maintenance_id").val("");
            $("#asset_assign_id").val("");
            $("#maintenance_type").val("");
            $("#maintenance_date").val(formattedDate);
            $("#maintenance_sl_no").val("");
            $("#maintenance_model").val("");
            $("#maintenance_warranty_date").val("");
            $("#maintenance_reason").val("");
            $("#maintenance_remarks").val("");
        });


        function getDesignation(select) {
            var department_id = $(select).val();
            let url = "{{ route('ajax.get-designation-by-department') }}";
            ajaxGet(url, {department_id:department_id}, function (response) {
                if (response.status == 200) {
                    $("#designation_id").html(response.view);
                } else {
                    toastr.error(response.message);
                }
            });
        }

        function getEmployee(select) {
            var designation_id = $(select).val();
            let url = "{{ route('ajax.get-employee-by-designation') }}";
            ajaxGet(url, {designation_id:designation_id}, function (response) {
                if (response.status == 200) {
                    $("#employee_id").html(response.view);
                } else {
                    toastr.error(response.message);
                }
            });
        }

        function initializeSelect() {
            $('.select2').select2({
                minimumResultsForSearch: -1,
                width: '100%'
            });
        }

        function initializeDatepicker() {
            $('.datetimepicker').datetimepicker({
                //format: 'DD/MM/YYYY',
                format: 'YYYY-MM-DD',
                icons: {
                    up: "fa fa-angle-up",
                    down: "fa-solid fa-angle-down",
                    next: 'fa-solid fa-angle-right',
                    previous: 'fa-solid fa-angle-left'
                }
            });
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var form = document.getElementById('printQrCodeForm');
            if (!form) {
                return;
            }

            form.addEventListener('submit', function() {
                var modalEl = document.getElementById('printQrCodeModal');
                var modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) {
                    modal.hide();
                }
            });
        });
    </script>
@endsection

