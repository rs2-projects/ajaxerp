@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
   <div class="row">
        <div class="erp-add-employee-wrapper mb-3">
            <div class="erp-add-employee">
                <a href="{{route('procurement.user.asset-purchase-request.create')}}" class="btn add-btn erp-add-employee ms-2" ><i class="fa-solid fa-plus"></i> New Purchase Request</a>
                <a href="#" class="btn add-btn erp-add-employee ms-2" ><i class="fa-regular fa-file-excel"></i> Export To Excel</a>
                <a href="#" class="btn add-btn erp-add-employee ms-2" ><i class="fa-regular fa-file-pdf"></i> Generate PDF</a>
            </div>
        </div>
        <div class="erp-employee-list-wrapper">
            <div class="erp-main-filter-wrapper bg-card attd-table">
                <div class="my-attendance-box-item flex-100 ">
                    <div class="my-attendance-report-wrapper">
                        <div class="erp-header-main-wrap d-flex justify-content-end align-items-center mb-4">
                        
                            <div class="erp-filter-box d-flex align-items-center justify-content-end flex-70">
                                
                                <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-end flex-100">
                                    <div class="erp-filter-item">
                                        <h6 class="me-2">Search By: </h6>
                                    </div>
                                    <div class="erp-filter-item flex-25"> 
                                        <div class=" form-focus select-focus custom-form-focus">
                                            <input type="text" class="form-control search-product-in" placeholder="Purchase Order">
                                        
                                        </div>
                                    </div>
                                    <div class="erp-filter-item flex-25"> 
                                        <div class=" form-focus select-focus custom-form-focus">
                                            <select class="select floating select2-box"> 
                                                <option>Select Month</option>
                                                <option>January</option>
                                                <option>February</option>
                                                <option>March</option>
                                                <option>April</option>
                                                <option>May</option>
                                                <option>June</option>
                                                <option>July</option>
                                                <option>August</option>
                                                <option>September</option>
                                                <option>October</option>
                                                <option>November</option>
                                                <option>December</option>
                                            </select>
                                        
                                        </div>
                                    </div>
                                    <div class="erp-filter-item flex-25"> 
                                        <div class=" form-focus select-focus custom-form-focus">
                                            <select class="select floating select2-box"> 
                                                <option>Select Year</option>
                                                <option>2023</option>
                                                <option>2022</option>
                                                <option>2021</option>
                                                <option>Last Year</option>
                                                <option>Last Two Years</option>
                                            
                                            </select>
                                        
                                        </div>
                                    </div>
                                    <div class="erp-filter-item"> 
                                        <div class="erp-search-btn-wrap">
                                            <button class=" erp-search-btn">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="erp-leave-tab-wrapper">
                            <ul class="nav nav-tabs erp-nav-tabs justify-content-center" id="myTab" role="tablist">
                                <li class="nav-item erp-nav-item" role="presentation">
                                    <button class="nav-link active erp-nav-link" id="all-purchase-tab" data-bs-toggle="tab" data-bs-target="#all-purchase" type="button" role="tab" aria-controls="home" aria-selected="true">All Purchase Request</button>
                                </li>
                                <li class="nav-item erp-nav-item" role="presentation">
                                    <button class="nav-link erp-nav-link" id="new-purchase-tab" data-bs-toggle="tab" data-bs-target="#new-purchase" type="button" role="tab" aria-controls="profile" aria-selected="false">New P.R</button>
                                </li>
                                <li class="nav-item erp-nav-item" role="presentation">
                                    <button class="nav-link erp-nav-link" id="process-purchase-tab" data-bs-toggle="tab" data-bs-target="#process-purchase" type="button" role="tab" aria-controls="contact" aria-selected="false">Pending P.R</button>
                                </li>
                                <li class="nav-item erp-nav-item" role="presentation">
                                    <button class="nav-link erp-nav-link" id="deliver-purchase-tab" data-bs-toggle="tab" data-bs-target="#deliver-purchase" type="button" role="tab" aria-controls="contact" aria-selected="false">Approved P.R</button>
                                </li>
                                <li class="nav-item erp-nav-item" role="presentation">
                                    <button class="nav-link erp-nav-link" id="revised-purchase-tab" data-bs-toggle="tab" data-bs-target="#revised-purchase" type="button" role="tab" aria-controls="contact" aria-selected="false">Declined P.R</button>
                                </li>
                                
                                </ul>

                                {{-- tab contents from __index_filter --}}

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
    <style> 
        .delete-btn-box.bank-info-remove {
            top: 10px;
        }
        .edit-img-src{
            margin-left: 5px;
            border-radius: 5px;
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
            initMaterialProductMultipleSelect();
            initAssteProductMultipleSelect();
            
            $(".select-step").select2({
                closeOnSelect: true,
                containerCssClass: "select2-box-container",
                dropdownCssClass: "select2-box-dropdown",
                width: '100%'

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
                    initializeSelect();
                    initMaterialProductMultipleSelect();
                    initAssteProductMultipleSelect();
                } else {
                    toastr.error(response.message);
                }
            }, 'default');
        }

        function addAdditionalBankInfo(){
            var item = $('#additionalBankInfo').html();
            $('.additionalBankInfoContainer').append(item);
        }
        
        // $(document).on("click", "#removeAdditionalBankInfo" , function (){
        //     $(this).closest('.erp-deduction-wrapper').remove();
        // });
        function removeAdditionalBankInfo(element){
            $(element).closest('.erp-deduction-wrapper').remove();
        }

        function addOtherContacts(){
            var item = $('#supplierOtherContact').html();
            $('.supplierOtherContactContainer').append(item);
        }

        function removeOtherContact(element){
            $(element).closest('.supplier-other-contact-parent').remove();
        }

        function getCountryWiseStates(select){
            let country_id = $(select).val();
            let url = "{{ route('procurement.supplier.get-states-by-country') }}";
            ajaxGet(url, {country_id:country_id}, function (response) {
                if (response.status == 200) {
                    $(".state_id").html(response.view);
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

        function initAssteProductMultipleSelect(){
            $('.asset-multiselect').multipleSelect({
                filter: true,
                placeholder: 'Select Product',
                minimumCountSelected: 6,
                filterPlaceholder: 'Search Product',
                selectAll: true,
                onOpen: function () {
                    $(".asset-multiselect .ms-drop ul>li:first-child label").contents().filter(function() {
                        return this.nodeType === 3;
                    }).replaceWith("Select All Products");
                },
            });
        }
        function initMaterialProductMultipleSelect(){
            $('.material-multiselect').multipleSelect({
                filter: true,
                placeholder: 'Select Product',
                minimumCountSelected: 6,
                filterPlaceholder: 'Search Product',
                selectAll: true,
                onOpen: function () {
                    $(".material-multiselect .ms-drop ul>li:first-child label").contents().filter(function() {
                        return this.nodeType === 3;
                    }).replaceWith("Select All Products");
                },
            });
        }
        
    </script>
@endsection


