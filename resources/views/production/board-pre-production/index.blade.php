@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        {{-- @if(hasPermission('manage-finished-goods')) --}}
            <div class="erp-add-employee-wrapper mb-3">
                <div class="erp-add-employee">
                    <a href="{{route('production.board-pre-production.create')}}" class="btn add-btn erp-add-employee ms-2" ><i class="fa-solid fa-plus"></i> Create Board Pre-Production </a>
                </div>
            </div>
        {{-- @endif --}}
        <div class="erp-employee-list-wrapper">
            <div class="erp-main-filter-wrapper bg-card attd-table">
                <div class="my-attendance-box-item flex-100 ">
                    <div class="my-attendance-report-wrapper">
                        <div class="erp-header-main-wrap d-flex justify-content-between align-items-center">
                            <div class="erp-filter-box d-flex align-items-center justify-content-end flex-100">
                                <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-end flex-100">
                                    <div class="erp-filter-item">
                                        <h6 class="me-2">Search By: </h6>
                                    </div>
                                    <div class="erp-filter-item flex-25">
                                        <div class=" form-focus select-focus custom-form-focus">
                                            <input type="text" id="keyword_filtered" class="form-control search-product-in" placeholder="Board Pre Production">

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
    @include('production.board-pre-production._send_to_production_modal')
@endsection

@section('css')
    <style>
        .gap-bottom{
            margin-bottom: 20px !important;
        }
        .estimated-output-wrapper {
            padding: 10px 0px;
            border: 1px dashed #ddd;
            margin-bottom: 10px;
        }
        .output-icon{
            top: 40px;
            margin-left: 10px;
            font-weight: 700;
            font-size: 14px;
            color: #0168e9;
        }
        .output-icon2{
            top: 34px;
            margin-left: 10px;
            font-weight: 700;
            font-size: 21px;
            color: #0168e9;
        }
        .custom-color{
            color: #0168e9 !important;
        }
    </style>
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
            filterData.keyword_filtered = $("#keyword_filtered").val()
            $("#keyword_filtered").on('input', function () {
                filterData.keyword_filtered = $(this).val();
            });

            $(document).on("input", "#unit_input", function(e) {
                var unit = $('#unit_input').val();
                var quantity = parseInt($('.quantity-text').text());
                if(unit){
                    $('.unit-input-text').text(unit);
                    var output = unit * quantity;
                    $('.output-text').text(output);
                    $('.product-unit').text(unit);
                    
                    $('.product-total-qty').each(function() {
                        var productQty = parseInt($(this).closest('.erp-tbody-tr').find('.product-qty').text());
                        $(this).text(unit * productQty);
                    });
                }else{
                    $('.unit-input-text').text(0); 
                    $('.output-text').text(0);
                    $('.product-unit').text(0);
                    $('.product-total-qty').each(function() {
                        var productQty = parseInt($(this).closest('.erp-tbody-tr').find('.product-qty').text());
                        $(this).text(0);
                    });
                }
            });

            $(document).on("submit", "#sendToProductionStoreForm", function(e) {
                var self = this;
                e.preventDefault();
                var formData = new FormData($(self)[0]);
                $(".ie-span").text("").hide();
                var url = $(self).attr('action');

                formPost(url, formData, function (res) {
                    if(res.status == 200){
                        $("#sendToProductionModal").modal('hide');
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
            getPaginatedListData("{{ route('production.board-pre-production.filtered') }}", "#ajax-data-load", filterData);
        }

        function getPaginatedData(button) {
            getPaginatedListData($(button).attr('data-href'), "#ajax-data-load", filterData);
        }

        function sendToProduction(id){
            let url = "{{route('production.board-pre-production.get-production-details', ':id')}}";
            url = url.replace(':id', id);
            ajaxGet(url, {}, function (response) {
                if (response.status == 200) {
                    $("#edit_data_modal_body").html(response.view);
                    $("#sendToProductionModal").modal('show');
                } else {
                    toastr.error(response.message);
                }
            }, 'default');
        }

    </script>
@endsection


