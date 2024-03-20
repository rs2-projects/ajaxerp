@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        @if(hasPermission('manage-invoices'))
            <div class="erp-add-employee-wrapper mb-3">
                <div class="erp-add-employee">
                    <a href="{{ route('sales.invoice.create') }}" class="btn add-btn erp-add-employee ms-2" ><i class="fa-solid fa-plus"></i> Create Invoice</a>
                </div>
            </div>
        @endif
        <div class="erp-employee-list-wrapper">
            <div class="erp-main-filter-wrapper bg-card attd-table">
                <div class="my-attendance-box-item flex-100 ">
                    <div class="my-attendance-report-wrapper">
                        <div class="erp-header-main-wrap d-flex justify-content-end align-items-center mb-4">

                            <div class="erp-filter-box d-flex align-items-center justify-content-end flex-100">

                                <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-end flex-100">
                                    <div class="erp-filter-item">
                                        <h6 class="me-2">Search By: </h6>
                                    </div>
                                    <div class="erp-filter-item flex-15">
                                        <div class=" form-focus select-focus custom-form-focus">
                                            <input type="text" class="form-control search-product-in" name="invoice_id"  id="invoice_id" placeholder="Invoice ID">

                                        </div>
                                    </div>
                                    <div class="erp-filter-item flex-15">
                                        <div class=" form-focus select-focus custom-form-focus">
                                            <select class="select floating select2-box" id="status_filter">
                                                <option value="">Select Invoice Status</option>
                                                <option value="{{ App\Models\Sales\Invoice::INVOICE_STATUS_PENDING }}">{{ App\Models\Sales\Invoice::INVOICE_STATUSES[App\Models\Sales\Invoice::INVOICE_STATUS_PENDING] }}</option>
                                                <option value="{{ App\Models\Sales\Invoice::INVOICE_STATUS_PROCESSING }}">{{ App\Models\Sales\Invoice::INVOICE_STATUSES[App\Models\Sales\Invoice::INVOICE_STATUS_PROCESSING] }}</option>
                                                <option value="{{ App\Models\Sales\Invoice::INVOICE_STATUS_DELIVERED }}">{{ App\Models\Sales\Invoice::INVOICE_STATUSES[App\Models\Sales\Invoice::INVOICE_STATUS_DELIVERED] }}</option>
                                                {{--@foreach($statuses as $key=>$status)
                                                    <option value="{{ $key }}" >
                                                        {{ ucfirst($status) }}
                                                    </option>
                                                @endforeach--}}
                                            </select>

                                        </div>
                                    </div>
                                    <div class="erp-filter-item flex-15 ">
                                        <div class=" form-focus select-focus custom-form-focus">
                                            <input type="text" class="form-control search-product-in datetimepicker" id="start_date_filtered" placeholder="Start Date">

                                        </div>
                                    </div>
                                    <div class="erp-filter-item flex-15 ">
                                        <div class=" form-focus select-focus custom-form-focus">
                                            <input type="text" class="form-control search-product-in datetimepicker" id="end_date_filtered" placeholder="End Date">

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
    @include('sales.invoice._design_upload_modal')
@endsection
@section('css')
    <style>
        .delivered-status{
            display: inline-block;
            background: linear-gradient(to right, #55ce63 0, #37b34a 100%) !important;
            color: #fff !important;
            padding: 5px 20px;
            border-radius: 100px;
            line-height: 1;
        }
        .cancelled-status{
            display: inline-block;
            background: #ff0000;
            color: #fff !important;
            padding: 5px 20px;
            border-radius: 100px;
            line-height: 1;
        }
    </style>
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
            invoice_id: '',
            status_filter: '',
            start_date_filtered:'',
            end_date_filtered:'',
        };
        $(document).ready(function() {
            getData();
            initializeDatepicker()
            filterData.invoice_id = $("#invoice_id").val()
            $("#invoice_id").on('input', function () {
                filterData.invoice_id = $(this).val();
            });
            filterData.status_filter = $("#status_filter").val()
            $("#status_filter").on('input', function () {
                filterData.status_filter = $(this).val();
            });

            $('#start_date_filtered').on('dp.change', function(e){

                filterData.start_date_filtered = $(this).val();

            });

            $('#end_date_filtered').on('dp.change', function(e){
                filterData.end_date_filtered = $(this).val();
            });

        });
        //Upload design modal show
        function showDesignUploadModal(id){
            $("#design_upload_modal").find('input[name="invoice_id"]').val(id);
            $("#design_upload_modal").modal('show');
        }
        //Design Upload form submit
        $(document).on("submit", "#designUploadFormSubmit", function(e) {
            var self = this;
            e.preventDefault();
            var formData = new FormData($(self)[0]);
            $(".ie-span").text("").hide();
            var url = $(self).attr('action');

            formPost(url, formData, function (res) {

                if(res.status == 200){
                    $("#design_upload_modal").modal('hide');
                    $(self)[0].reset();
                    showSuccessAlert('Success',res.message)
                    getData();
                }else{
                    showErrorAlert('Error',res.message)
                }
            }, 'show_input_error');
        });
        //show design modal
        function showDesign(id) {
            let url = "{{ route('sales.invoice.design', ':id') }}"
            url = url.replace(':id', id);
            ajaxGet(url, {}, function (response) {
                if (response.status == 200) {
                    $("#design_modal_body").html(response.view);
                    $("#design_modal").modal('show');
                } else {
                    toastr.error(response.message);
                }
            }, 'default');
        }
        //get filtered data
        function getData(){

            getPaginatedListData("{{ route('sales.invoice.filtered') }}", "#ajax-data-load", filterData);
        }
        //get paginated data
        function getPaginatedData(button) {
            getPaginatedListData($(button).attr('data-href'), "#ajax-data-load", filterData);
        }
        //make payment form submit
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
        //make payment
        function makePayment(id){
            let url = "{{route('sales.invoice.make-payment', ':id')}}";
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
        //datepicker initialize
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
        //add receipt
        function addReceipt(){
            let receiptItemWrap = $("#receiptItemWrap").html();
            $("#receiptItemMain").append(receiptItemWrap);
        }
        //remove receipt
        function removeReceipt(element){
            $(element).closest('.multiple-receipt-item').remove();
        }
        //init payment method select2
        function initPaymentMethodSelect2() {
            $('.select-step.payment-method').select2({
                minimumResultsForSearch: -1,
                width: '100%',
            });
        }
        //init payment account select2
        function initPaymentAccountSelect2() {
            $('.select-step.payment-account').select2({
                minimumResultsForSearch: -1,
                width: '100%',
            });
        }

    </script>
@endsection
