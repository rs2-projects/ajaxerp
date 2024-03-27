@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        @if(hasPermission( 'manage-product-material-purchase-orders'))
            <div class="erp-add-employee-wrapper mb-3">
                <div class="erp-add-employee">
                    <a href="{{ route('procurement.product-material-purchase.create') }}" class="btn add-btn erp-add-employee ms-2" ><i class="fa-solid fa-plus"></i> New Purchase Order</a>
                </div>
            </div>
        @endif
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
                                            <input type="text" class="form-control search-product-in" id="keyword_filtered" placeholder="Purchase Order">

                                        </div>
                                    </div>
                                    <div class="erp-filter-item flex-25">
                                        <div class=" form-focus select-focus custom-form-focus">
                                            <input type="text" class="form-control search-product-in datetimepicker" id="start_date_filtered" placeholder="Start Date">

                                        </div>
                                    </div>
                                    <div class="erp-filter-item flex-25">
                                        <div class=" form-focus select-focus custom-form-focus">
                                            <input type="text" class="form-control search-product-in datetimepicker" id="end_date_filtered" placeholder="End Date">

                                        </div>
                                    </div>
                                    <div class="erp-filter-item">
                                        <div class="erp-search-btn-wrap">
                                            <button class="erp-search-btn" type="button" onclick="getData()">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="erp-leave-tab-wrapper">
                            <ul class="nav nav-tabs erp-nav-tabs justify-content-center status_type" id="myTab" role="tablist">
                                <li class="nav-item erp-nav-item" role="presentation">
                                    <button class="nav-link active erp-nav-link" data="all_purchase" id="all-purchase-tab" data-bs-toggle="tab" data-bs-target="#all-purchase" type="button" role="tab" aria-controls="home" aria-selected="true">All Purchase Order</button>
                                </li>
                                <li class="nav-item erp-nav-item" role="presentation">
                                    <button class="nav-link erp-nav-link" data="new_purchase" id="new-purchase-tab" data-bs-toggle="tab" data-bs-target="#new-purchase" type="button" role="tab" aria-controls="profile" aria-selected="false">New P.O</button>
                                </li>
                                <li class="nav-item erp-nav-item" role="presentation">
                                    <button class="nav-link erp-nav-link" data="on_process_purchase" id="process-purchase-tab" data-bs-toggle="tab" data-bs-target="#process-purchase" type="button" role="tab" aria-controls="contact" aria-selected="false">On Process P.O</button>
                                </li>
                                <li class="nav-item erp-nav-item" role="presentation">
                                    <button class="nav-link erp-nav-link" data="delivered_purchase" id="deliver-purchase-tab" data-bs-toggle="tab" data-bs-target="#deliver-purchase" type="button" role="tab" aria-controls="contact" aria-selected="false">Delivered P.O</button>
                                </li>
                                <li class="nav-item erp-nav-item" role="presentation">
                                    <button class="nav-link erp-nav-link" data="revised_purchase" id="revised-purchase-tab" data-bs-toggle="tab" data-bs-target="#revised-purchase" type="button" role="tab" aria-controls="contact" aria-selected="false">Revised P.O</button>
                                </li>
                                <li class="nav-item erp-nav-item" role="presentation">
                                    <button class="nav-link erp-nav-link" data="back_purchase" id="back-purchase-tab" data-bs-toggle="tab" data-bs-target="#back-purchase" type="button" role="tab" aria-controls="contact" aria-selected="false">Back P.O</button>
                                </li>
                                <li class="nav-item erp-nav-item" role="presentation">
                                    <button class="nav-link erp-nav-link" data="has_revised_purchase" id="has-revised-purchase-tab" data-bs-toggle="tab" data-bs-target="#has-revised-purchase" type="button" role="tab" aria-controls="contact" aria-selected="false">Has Revised P.O</button>
                                </li>
                                <li class="nav-item erp-nav-item" role="presentation">
                                    <button class="nav-link erp-nav-link" data="has_backed_purchase" id="has-backed-purchase-tab" data-bs-toggle="tab" data-bs-target="#has-backed-purchase" type="button" role="tab" aria-controls="contact" aria-selected="false">Has Backed P.O</button>
                                </li>
                            </ul>

                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="all-purchase-tab">
                                    <div class="my-attendance-report-wrapper">
                                        <div class="big-table pt-4">
                                            <div class="de-table-wrapper" id="ajax-data-load">

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
    <div id="receiptItemWrap" style="display: none;">
        <div class="multiple-receipt-item flex-100">
            <div class="input-block erp-step-input-block mb-0">
                <label class="col-form-label">Upload Receipt <span class="text-danger" onclick="removeReceipt(this)"><i class="fa fa-times-circle"></i></span></label>
                <input type="file" class="form-control" name="receipt[]" placeholder="Upload Receipt">
            </div>
        </div>
    </div>

@endsection

@section('modals')
    @include('common.modals._make_payment_modal')
    @include('procurement.product-material-purchase.print-barcode._print_barcode_modal')
@endsection

@section('css')

@endsection

@section('css_plugins')
    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}">
@endsection

@section('js_plugins')
    <!-- Datetimepicker JS -->
    <script src="{{asset('assets/js/moment.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap-datetimepicker.min.js')}}"></script>
@endsection

@section('js')
    <script>
        var filterData = {
            keyword_filtered: '',
            status_filtered: 'all_purchase',
            start_date_filtered: '',
            end_date_filtered: ''
        };
        $(document).ready(function() {
            getData();
            initializeDatepicker();

            filterData.keyword_filtered = $("#keyword_filtered").val()
            $("#keyword_filtered").on('input', function () {
                filterData.keyword_filtered = $(this).val();
            });

            $('.status_type li').on('click', function () {
                filterData.status_filtered = $('.status_type .active').attr('data');

                getData();
            });
            $('#start_date_filtered').on('dp.change', function(e){

                filterData.start_date_filtered = $(this).val();

            });

            $('#end_date_filtered').on('dp.change', function(e){
                filterData.end_date_filtered = $(this).val();
            });
            $(document).on("submit", "#makePaymentFormSubmit", function(e) {
                var self = this;
                e.preventDefault();
                var formData = new FormData($(self)[0]);
                $(".ie-span").text("").hide();
                var url = $(self).attr('action');

                formPost(url, formData, function (res) {
                    if(res.status == 200){
                        $("#make-payment-modal").modal('hide');
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
            getPaginatedListData("{{ route('procurement.product-material-purchase.filtered') }}", "#ajax-data-load", filterData);
        }

        function getPaginatedData(button) {
            getPaginatedListData($(button).attr('data-href'), "#ajax-data-load", filterData);
        }

        function makePayment(id){
            let url = "{{route('procurement.product-material-purchase.make-payment', ':id')}}";
            url = url.replace(':id', id);
            ajaxGet(url, {}, function (response) {
                if (response.status == 200) {
                    $("#make-payment-modal-data").html(response.view);
                    $("#make-payment-modal").modal('show');

                    initializeDatepicker();
                    initPaymentMethodSelect2();
                    initPaymentAccountSelect2();
                } else {
                    toastr.error(response.message);
                }
            }, 'default');
        }

        function addReceipt(){
            let receiptItemWrap = $("#receiptItemWrap").html();
            $("#receiptItemMain").append(receiptItemWrap);
        }

        function removeReceipt(element){
            $(element).closest('.multiple-receipt-item').remove();
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

        function initPaymentMethodSelect2() {
            $('.select-step.payment-method').select2({
                minimumResultsForSearch: -1,
                width: '100%',
            });
        }
        function initPaymentAccountSelect2() {
            $('.select-step.payment-account').select2({
                minimumResultsForSearch: -1,
                width: '100%',
            });
        }

        function printBarcodeData(id, type){
            console.log(id, type)
            let url = "{{ route('procurement.product-material-purchase.print-barcode', ['id' => ':id', 'type' => ':type']) }}";
            url = url.replace(':id', id);
            url = url.replace(':type', type);
            console.log(url)
            ajaxGet(url, {}, function (response) {
                if (response.status == 200) {
                    $("#print_barcode_modal_body").html(response.view);
                    $("#printBarcodeModal").modal('show');
                } else {
                    toastr.error(response.message);
                }
            }, 'default');
        }

    </script>
@endsection


