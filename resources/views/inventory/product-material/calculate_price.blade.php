@extends('layouts.layout')
@section('content')
    <div class="row justify-content-center" id="VueApp">
        <div class="col-md-12">
            <div class="erp-employee-list-wrapper purchase-order-in-main">
                <form action="{{route('inventory.product-material.calculate-price.store', $material->id)}}" id="calculatePriceFormSubmit" method="POST" @submit="checkValidation">
                    @csrf
                    <div class="erp-main-filter-wrapper bg-card attd-table">
                        <div class="rs-erp-calculated-price-wrapper">
                            <div class="rs-ecp-single-wrap">
                                <div class="rs-ecp-single-top-box d-flex flex-wrap">
                                    <div class="rs-ecp-stb-left-wrap d-flex flex-wrap">
                                        <div class="rs-ecp-std-left-item">
                                            <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100 pt-3">
                                                <div class="em-pro-img-box">
                                                    <img src="{{$material->show_image}}" alt="">
                                                </div>
                                                <div class="em-pro-details-box">
                                                    <h5>{{$material->name}}</h5>
                                                    <p class="em-id">Code: <span> {{$material->code? '#'.$material->code : 'N/A'}}</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="rs-ecp-stb-right-wrap d-flex flex-wrap justify-content-between">
                                        <div class="rs-ecp-std-r-left board-pp-calc-price-wrapper">
                                            <div class="rs-ecp-std-r-left-top-wrap d-flex flex-wrap">
                                                <div class="rs-ecp-std-r-left-top-item">
                                                    <div class="rs-ecp-std-r-left-top-title-box">
                                                        <h4>Retail Price</h4>
                                                    </div>
                                                    <div class="rs-ecp-std-r-left-top-content-box">
                                                        <span id="retail_price">0.00</span>
                                                    </div>
                                                </div>
                                                {{-- <div class="rs-ecp-std-r-left-top-item">
                                                    <div class="rs-ecp-std-r-left-top-title-box">
                                                        <h4>SRP With 20% Discount</h4>
                                                    </div>
                                                    <div class="rs-ecp-std-r-left-top-content-box">
                                                        <span id="srp_with_discount">0.00</span>
                                                    </div>
                                                </div> --}}
                                                <div class="rs-ecp-std-r-left-top-item">
                                                    <div class="rs-ecp-std-r-left-top-title-box">
                                                        <h4>Wholesale Price</h4>
                                                    </div>
                                                    <div class="rs-ecp-std-r-left-top-content-box">
                                                        <span id="wholesale_price">0.00</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-ecp-bottom-box d-flex flex-wrap board-pp-calc-price-input-wrapper">
                                    <div class="rs-ecp-bottom-box-item">
                                        <div class="rs-ecp-std-item-title-box">
                                            <h4>Landed Cost</h4>
                                        </div>
                                        <div class="rs-ecp-std-item-input-box">
                                            <input type="number" value="{{ formatNumber($material->wholesale_landed_cost) }}" step="any" min="0" id="wholesale_landed_cost" name="wholesale_landed_cost" class="form-control" oninput="calculateTotalPrice()" required>
                                        </div>
                                    </div>
                                    <div class="rs-ecp-bottom-box-item">
                                        <div class="rs-ecp-std-item-title-box">
                                            <h4>Wholesale Multiplier</h4>
                                        </div>
                                        <div class="rs-ecp-std-item-input-box">
                                            <input type="number" value="{{ formatNumber($material->wholesale_multiplier) }}" step="0.01" min="0" id="wholesale_multiplier" name="wholesale_multiplier" class="form-control" oninput="calculateTotalPrice()" required>
                                        </div>
                                    </div>
                                    <div class="rs-ecp-bottom-box-item">
                                        <div class="rs-ecp-std-item-title-box">
                                            <h4>Retail Multiplier</h4>
                                        </div>
                                        <div class="rs-ecp-std-item-input-box">
                                            <input type="number" value="{{ formatNumber($material->retail_multiplier) }}" id="retail_multiplier" name="retail_multiplier" step="0.01" min="0" class="form-control" oninput="calculateTotalPrice()" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nw-warehouse-add-btn-2 text-center mt-4">
                        <button type="submit" class=" erp-search-btn text-center">Calculate Now</button>
                    </div>
                </form>
            </div>
        </div>


    </div>

@endsection

@section('modals')
@endsection

@section('css')

@endsection

@section('css_plugins')
@endsection

@section('js_plugins')
@endsection

@section('js')

    <script>
        $(document).ready(function() {
            calculateTotalPrice();
        })
        /*$(document).ready(function() {
            calculateSrpWithDiscount();
            calculateWholesalePrice();

            $("#rp_cost").on("input", function() {
                calculateSrpWithDiscount();
                calculateWholesalePrice();
            });

            $("#srp_markup_percent").on("input", function() {
                calculateSrpWithDiscount();
                calculateWholesalePrice();
            });

            $("#wholesale_discount_percent").on("input", function() {
                calculateSrpWithDiscount();
                calculateWholesalePrice();
            });
        })

        function calculateSrpWithDiscount() {
            const FIXED_PERCENT = 20;
            function parseInput(value) {
                return parseFloat(value) || 0;
            }

            const rp_cost = parseInput($("#rp_cost").val());
            const srp_markup_percent = parseInput($("#srp_markup_percent").val());

            const srp_with_discount = rp_cost * (srp_markup_percent / 100);
            const srp = srp_with_discount / (1 - (FIXED_PERCENT / 100));

            $("#rp_srp").text(formatNumber(parseFloat(srp)));
            $("#srp_with_discount").text(formatNumber(parseFloat(srp_with_discount)));
        }

        function calculateWholesalePrice(){
            const srp_with_discount = parseFloat($("#srp_with_discount").text());
            let wholesale_discount_percent = parseFloat($("#wholesale_discount_percent").val());
            if(isNaN(wholesale_discount_percent)){
                wholesale_discount_percent = 0;
            }
            if(srp_with_discount != "" && wholesale_discount_percent != ""){
                const wholesale = srp_with_discount * (1 - (wholesale_discount_percent/100));
                $("#wholesale").text(formatNumber(parseFloat(wholesale)));
            }else{
                $("#wholesale").text(formatNumber(parseFloat(srp_with_discount)));
            }
        }*/

        function calculateTotalPrice() {
            let landed_cost = parseFloat($("#wholesale_landed_cost").val());
            let wholesale_multiplier = parseFloat($("#wholesale_multiplier").val());
            let retail_multiplier = parseFloat($("#retail_multiplier").val());

            if(isNaN(landed_cost)){
                landed_cost = 0;
            }
            if(isNaN(wholesale_multiplier)){
                wholesale_multiplier = 0;
            }
            if(isNaN(retail_multiplier)){
                retail_multiplier = 0;
            }

            let wholesale_price = landed_cost * wholesale_multiplier;
            let retail_price = wholesale_price * retail_multiplier;

            $("#wholesale_price").text(formatNumber(parseFloat(wholesale_price)));
            $("#retail_price").text(formatNumber(parseFloat(retail_price)));
        }

        $("#calculatePriceFormSubmit").on('submit', function (e){
            e.preventDefault();
            var self = $("#calculatePriceFormSubmit");
            var formData = new FormData($(self)[0]);
            var url = $(self).attr('action');

            let cost = $("#rp_cost").val();
            let srp_markup_percent = $("#srp_markup_percent").val();

            if(cost == "" || cost == 0){
                showErrorAlert('Error','Please enter RP cost');
                return false;
            }

            if(srp_markup_percent == "" || srp_markup_percent == 0){
                showErrorAlert('Error','Please enter SRP markup percent');
                return false;
            }

            formPost(url, formData, function (res) {
                if(res.status == 200){
                    showSuccessAlert('Success',res.message)
                    setTimeout(function () {
                        window.location.href = "{{route('inventory.product-material.index')}}";
                    }, 1000);
                }else{
                    showErrorAlert('Error',res.message)
                }
            }, 'show_input_error');
        })
    </script>
@endsection
