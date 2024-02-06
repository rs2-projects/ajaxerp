@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        <div class="erp-add-employee-wrapper mb-3">
            <div class="erp-add-employee">
                <a href="javascript:void(0)" class="btn add-btn erp-add-employee" data-bs-toggle="modal" data-bs-target="#addSupplierModal"><i class="fa-solid fa-plus"></i> New Suppliers</a>

            </div>
        </div>
        <div class="erp-employee-list-wrapper">
            <div class="erp-main-filter-wrapper bg-card attd-table">
                <div class="my-attendance-box-item flex-100 ">
                    <div class="my-attendance-report-wrapper">
                        <div class="erp-header-main-wrap d-flex justify-content-between align-items-center">
                            <div class="erp-filter-box d-flex align-items-center justify-content-start flex-100">
                                <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-start flex-100">
                                    <div class="erp-filter-item flex-7">
                                        <h6 class="me-2">Search By: </h6>
                                    </div>

                                    <div class="erp-filter-item flex-30">
                                        <div class="search-box table-search position-relative">
                                            <input class="form-control" type="text" id="keyword_filtered" placeholder="Name / Company">
                                            <button class="btn position-absolute search-btn" type="button" onclick="getData()"><i class="fa-solid fa-magnifying-glass"></i></button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="table-main-wrapper pt-4" id="ajax-data-load">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End::row-1 -->

    <div id="additionalBankInfo" style="display: none;">
        <div class="erp-deduction-wrapper position-relative mt-3 filter-row d-flex flex-wrap align-items-center justify-content-between">
            <div class="delete-btn-box bank-info-remove" id="removeAdditionalBankInfo">
                <a href="javascript:void(0);" class="delete-btn"><i class="fa-solid fa-trash-can"></i></a>
            </div>
            <div class="erp-filter-item flex-48"> 
                <div class="input-block mb-0 erp-step-input-block ">
                    <label class="col-form-label">Bank Name </label>
                        <input type="text" class="form-control " placeholder="">
                </div>
            </div>
            <div class="erp-filter-item flex-48"> 
                <div class="input-block mb-0 erp-step-input-block ">
                    <label class="col-form-label">Account Name </label>
                        <input type="text" class="form-control " placeholder="">
                </div>
            </div>
            <div class="erp-filter-item flex-48"> 
                <div class="input-block mb-0 erp-step-input-block ">
                    <label class="col-form-label">Branch Name </label>
                        <input type="text" class="form-control " placeholder="">
                </div>
            </div>
            <div class="erp-filter-item flex-48"> 
                <div class="input-block mb-0 erp-step-input-block ">
                    <label class="col-form-label">Routing Number </label>
                        <input type="text" class="form-control " placeholder="">
                </div>
            </div>
            <div class="erp-filter-item flex-48"> 
                <div class="input-block mb-0 erp-step-input-block ">
                    <label class="col-form-label">Swift Code </label>
                        <input type="text" class="form-control " placeholder="">
                </div>
            </div>
            <div class="erp-filter-item flex-48"> 
                <div class="input-block mb-0 erp-step-input-block ">
                    <label class="col-form-label">Note</label>
                        <input type="text" class="form-control " placeholder="">
                </div>
            </div>
        </div>
    </div>

    <div id="supplierOtherContact" style="display: none;">
        <div class="supplier-other-contact-parent erp-deduction-wrapper position-relative filter-row mt-3 d-flex flex-wrap align-items-center justify-content-between flex-100">
            <div class="delete-btn-box bank-info-remove" id="removeOtherContact">
                <a href="javascript:void(0);" class="delete-btn"><i class="fa-solid fa-trash-can"></i></a>
            </div>
            <div class="erp-filter-item flex-32"> 
                <div class="input-block mb-0 erp-step-input-block ">
                    <label class="col-form-label">Name <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control " placeholder="">
                </div>
            </div>
            <div class="erp-filter-item flex-32"> 
                <div class="input-block mb-0 erp-step-input-block ">
                    <label class="col-form-label">Email <span class="text-danger">*</span> </label>
                        <input type="email" class="form-control " placeholder="">
                </div>
            </div>
            <div class="erp-filter-item flex-32"> 
                <div class="input-block mb-0 erp-step-input-block ">
                    <label class="col-form-label">Phone <span class="text-danger">*</span> </label>
                    <input type="tel" class="form-control " placeholder="">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    @include('procurement.supplier._add_supplier_modal')
    @include('procurement.supplier._edit_supplier_modal')
@endsection

@section('css')
    <style> 
        .delete-btn-box.bank-info-remove {
            top: 10px;
        }
    </style>
@endsection

@section('css_plugins')

@endsection

@section('js_plugins')
    <script src="{{asset('assets')}}/plugins/multipleselect/multiple-select.js"></script>
    <script src="{{asset('assets')}}/plugins/multipleselect/multi-select.js"></script>
@endsection

@section('js')
    <script>
        var filterData = {
            keyword_filtered: ''
        };
        $(document).ready(function() {
            getData();

            $(".select-step").select2({
                closeOnSelect: true,
                containerCssClass: "select2-box-container",
                dropdownCssClass: "select2-box-dropdown",
                width: '100%'

            });
            $('.employee-multiselect').multipleSelect({
                filter: true,
                placeholder: 'Select Product',
                minimumCountSelected: 8,
                filterPlaceholder: 'Search Product',
                selectAll: true,
                onOpen: function () {
                    $(".employee-multiselect .ms-drop ul>li:first-child label").contents().filter(function() {
                        return this.nodeType === 3;
                    }).replaceWith("Select All Product");
                },
            });
            

            filterData.keyword_filtered = $("#keyword_filtered").val()
            $("#keyword_filtered").on('input', function () {
                filterData.keyword_filtered = $(this).val();
            });

            $("#supplierStoreForm").on('submit', function (e) {
                var self = this;
                e.preventDefault();
                var formData = new FormData($(self)[0]);
                $(".ie-span").text("").hide();
                var url = $(self).attr('action');

                formPost(url, formData, function (res) {
                    if(res.status == 200){
                        $("#addSupplierModal").modal('hide');
                        $(self)[0].reset();
                        showSuccessAlert('Success',res.message)
                        getData();
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');
            });

            $(document).on("submit", "#supplierUpdateForm", function(e) {
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                $(".ie-span").text("").hide();
                var url = $(this).attr('action');

                formPost(url, formData, function (res){
                    if(res.status == 200){
                        $("#editSupplierModal").modal('hide');
                        showSuccessAlert('Success',res.message)
                        getData();
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');
            });

        });

        function getData(){
            getPaginatedListData("{{ route('procurement.supplier.filtered') }}", "#ajax-data-load", filterData);
        }

        function getPaginatedData(button) {
            getPaginatedListData($(button).attr('data-href'), "#ajax-data-load", filterData);
        }

        function editItem(id){
            let url = "{{route('procurement.supplier.edit', ':id')}}";
            url = url.replace(':id', id);
            ajaxGet(url, {}, function (response) {
                if (response.status == 200) {
                    $("#edit_suuplier_modal_body").html(response.view);
                    $("#editSupplierModal").modal('show');
                } else {
                    toastr.error(response.message);
                }
            }, 'default');
        }

        function addAdditionalBankInfo(){
            var item = $('#additionalBankInfo').html();
            $('#additionalBankInfoContainer').append(item);
        }
        
        $(document).on("click", "#removeAdditionalBankInfo" , function (){
            $(this).closest('.erp-deduction-wrapper').remove();
        });

        function addOtherContacts(){
            var item = $('#supplierOtherContact').html();
            $('#supplierOtherContactContainer').append(item);
        }
        $(document).on("click", "#removeOtherContact" , function (){
            $(this).closest('.supplier-other-contact-parent').remove();
        });
        
    </script>
@endsection


