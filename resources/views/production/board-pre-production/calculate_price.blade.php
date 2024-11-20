@extends('layouts.layout')
@section('content')
    <div class="row justify-content-center" id="VueApp">
        <div class="col-md-12">
            <div class="erp-employee-list-wrapper purchase-order-in-main">
                <form action="{{route('production.board-pre-production.calculate-price.store', $pre_production->id)}}" id="calculatePriceFormSubmit" method="POST" @submit="checkValidation">
                    @csrf
                    <div class="erp-main-filter-wrapper bg-card attd-table">
                        <div class="rs-erp-calculated-price-wrapper">
                            <div class="d-flex">
                                <div class="default-vat-set-box mb-3">
                                    <div class="rs-ecp-bottom-box-item">
                                        <div class="rs-ecp-std-item-title-box">
                                            <h4>Vat Value(%)</h4>
                                        </div>
                                        <div class="rs-ecp-std-item-input-box">
                                            <input type="number" name="vat_percent" id="vat_percent" class="form-control" step="0.01" value="12">
                                        </div>
                                    </div>
                                </div>
                                <div class="default-vat-set-box mb-3">
                                    <div class="rs-ecp-bottom-box-item">
                                        <div class="rs-ecp-std-item-title-box">
                                            <h4>Retail Percentage(%)</h4>
                                        </div>
                                        <div class="rs-ecp-std-item-input-box">
                                            <input type="number" name="retail_percent" id="retail_percent" class="form-control" step="0.01" value="60">
                                        </div>
                                    </div>
                                </div>
                                <div class="default-vat-set-box mb-3">
                                    <div class="rs-ecp-bottom-box-item">
                                        <div class="rs-ecp-std-item-title-box">
                                            <h4>Discount Percentage(%)</h4>
                                        </div>
                                        <div class="rs-ecp-std-item-input-box">
                                            <input type="number" name="discount_percent" id="discount_percent" class="form-control" step="0.01" value="24">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rs-ecp-single-wrap">
                                <input type="hidden" name="product_material_id" value="{{$pre_production->raw_board->product_material_id}}">
                                <div class="rs-ecp-single-top-box d-flex flex-wrap">
                                    <div class="rs-ecp-stb-left-wrap d-flex flex-wrap">
                                        <div class="rs-ecp-std-left-item">
                                            <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100 pt-3">
                                                <div class="em-pro-img-box">
                                                    <img src="{{$pre_production->raw_board->product_material->show_image}}" alt="">
                                                </div>
                                                <div class="em-pro-details-box">
                                                    <h5>{{$pre_production->raw_board->product_material->name}}</h5>
                                                    <p class="em-id">Code: <span> {{$pre_production->raw_board->product_material->code? '#'.$pre_production->raw_board->product_material->code : 'N/A'}}</span></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="rs-ecp-std-left-item flex-100">
                                            <div class="p-dec-box-wrap">
                                                <div class="p-dec-title">
                                                    <h4>Note</h4>
                                                </div>
                                                <div class="p-dec-box">
                                                    <p>{{!empty($pre_production->note) ? $pre_production->note : 'N/A'}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="rs-ecp-stb-right-wrap d-flex flex-wrap justify-content-between">
                                        <div class="rs-ecp-std-r-left board-pp-calc-price-wrapper">
                                            <div class="rs-ecp-std-r-left-top-wrap d-flex flex-wrap">
                                                <div class="rs-ecp-std-r-left-top-item">
                                                    <div class="rs-ecp-std-r-left-top-title-box">
                                                        <h4>Total Production Cost (Ex. Vat)</h4>
                                                    </div>
                                                    <div class="rs-ecp-std-r-left-top-content-box">
                                                        <span id="total_production_cost">0.00</span>
                                                    </div>
                                                </div>
                                                <div class="rs-ecp-std-r-left-top-item">
                                                    <div class="rs-ecp-std-r-left-top-title-box">
                                                        <h4>Retail Price</h4>
                                                    </div>
                                                    <div class="rs-ecp-std-r-left-top-content-box">
                                                        <span id="retail_price">0.00</span>
                                                    </div>
                                                </div>
                                                <div class="rs-ecp-std-r-left-top-item">
                                                    <div class="rs-ecp-std-r-left-top-title-box">
                                                        <h4>Price (Ex. Vat)</h4>
                                                    </div>
                                                    <div class="rs-ecp-std-r-left-top-content-box">
                                                        <span id="price_ex_vat">0.00</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="rs-ecp-std-r-left-bottom-wrap d-flex flex-wrap">
                                                <div class="rs-ecp-std-r-left-bottom-item">
                                                    <div class="rs-ecp-std-r-left-top-title-box">
                                                        <h4>Vat</h4>
                                                    </div>
                                                    <div class="rs-ecp-std-r-left-top-content-box">
                                                        <span id="vat_amt">0.00</span>
                                                    </div>
                                                </div>
                                                <div class="rs-ecp-std-r-left-bottom-item">
                                                    <div class="rs-ecp-std-r-left-top-title-box">
                                                        <h4>Discount Wholesale</h4>
                                                    </div>
                                                    <div class="rs-ecp-std-r-left-top-content-box">
                                                        <span id="discount_price">0.00</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-ecp-bottom-box d-flex flex-wrap board-pp-calc-price-input-wrapper">
                                    <div class="rs-ecp-bottom-box-item">
                                        <div class="rs-ecp-std-item-title-box">
                                            <h4>Landed Cost (Ex. Vat)</h4>
                                        </div>
                                        <div class="rs-ecp-std-item-input-box">
                                            <input type="number" value="{{$raw_board_cost}}" step="any" min="0" id="landed_cost_excluding_vat" name="landed_cost_excluding_vat" class="form-control cost_input" required>
                                        </div>
                                    </div>
                                    <div class="rs-ecp-bottom-box-item">
                                        <div class="rs-ecp-std-item-title-box">
                                            <h4>Machine Cost</h4>
                                        </div>
                                        <div class="rs-ecp-std-item-input-box">
                                            <input type="number" value="{{ formatNumber($pre_production->machine?->production_cost) }}" step="any" min="0" id="machine_cost" name="machine_cost" class="form-control cost_input" required>
                                        </div>
                                    </div>
                                    <div class="rs-ecp-bottom-box-item">
                                        <div class="rs-ecp-std-item-title-box">
                                            <h4>Paper Up Cost</h4>
                                        </div>
                                        <div class="rs-ecp-std-item-input-box">
                                            <input type="number" value="{{ formatNumber($paper_up_cost) }}" id="paper_up_cost" name="paper_up_cost" step="any" min="0" class="form-control cost_input" required>
                                        </div>
                                    </div>
                                    <div class="rs-ecp-bottom-box-item">
                                        <div class="rs-ecp-std-item-title-box">
                                            <h4>Plate Up Cost </h4>
                                        </div>
                                        <div class="rs-ecp-std-item-input-box">
                                            <input type="number" value="{{ formatNumber($pre_production->finishedGoods?->embossed_ups?->production_cost) }}" step="any" min="0" id="plate_up_cost" name="plate_up_cost" class="form-control cost_input" required>
                                        </div>
                                    </div>
                                    <div class="rs-ecp-bottom-box-item">
                                        <div class="rs-ecp-std-item-title-box">
                                            <h4>Paper Down Cost</h4>
                                        </div>
                                        <div class="rs-ecp-std-item-input-box">
                                            <input type="number" value="{{ formatNumber($paper_down_cost) }}" step="any" min="0" id="paper_down_cost" name="paper_down_cost" class="form-control cost_input" required>
                                        </div>
                                    </div>
                                    <div class="rs-ecp-bottom-box-item">
                                        <div class="rs-ecp-std-item-title-box">
                                            <h4>Plate Down Cost</h4>
                                        </div>
                                        <div class="rs-ecp-std-item-input-box">
                                            <input type="number" value="{{ formatNumber($pre_production->finishedGoods?->embossed_downs?->production_cost) }}" step="any" min="0" id="plate_down_cost"  name="plate_down_cost" class="form-control cost_input" required>
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
            calculateTotalProductionCost();
            calculateRetailPrice();
            calculateVatAmt();
            calculateDiscountPrice();

            $("#vat_percent").on("input", function() {
                calculateVatAmt();
            });

            $("#retail_percent").on("input", function() {
                calculateRetailPrice();
                calculateVatAmt();
                calculateDiscountPrice();
            });

            $("#discount_percent").on("input", function() {
                calculateDiscountPrice();
            });

            $(".cost_input").on("input", function() {
                calculateTotalProductionCost();
                calculateRetailPrice();
                calculateVatAmt();
                calculateDiscountPrice();
            });
        })

        function calculateTotalProductionCost() {
            function parseInput(value) {
                return parseFloat(value) || 0;
            }

            const landed_cost_excluding_vat = parseInput($("#landed_cost_excluding_vat").val());
            const machine_cost = parseInput($("#machine_cost").val());
            const paper_up_cost = parseInput($("#paper_up_cost").val());
            const plate_up_cost = parseInput($("#plate_up_cost").val());
            const paper_down_cost = parseInput($("#paper_down_cost").val());
            const plate_down_cost = parseInput($("#plate_down_cost").val());

            const total_production_cost = landed_cost_excluding_vat + machine_cost + paper_up_cost + plate_up_cost + paper_down_cost + plate_down_cost;

            $("#total_production_cost").text(formatNumber(parseFloat(total_production_cost)));
        }


        function calculateRetailPrice(){
            const total_production_cost = parseFloat($("#total_production_cost").text());
            const retail_percent = $("#retail_percent").val();
            if(total_production_cost != "" && retail_percent != ""){
                const retail_price = total_production_cost + (total_production_cost / 100) * parseFloat(retail_percent);
                $("#retail_price").text(formatNumber(parseFloat(retail_price)));
            }else{
                $("#retail_price").text(formatNumber(parseFloat(total_production_cost)));
            }
        }

        function calculateVatAmt(){
            const retail_price = parseFloat($("#retail_price").text());
            const vat_percent = $("#vat_percent").val();
            if(retail_price != "" && vat_percent != ""){
                const price_ex_vat = retail_price - (retail_price / 100) * parseFloat(vat_percent)
                const price_ex_vat_amt = formatNumber(parseFloat(price_ex_vat));
                const vat = retail_price - parseFloat(price_ex_vat_amt);
                const vat_amt = formatNumber(parseFloat(vat));
                $("#price_ex_vat").text(price_ex_vat_amt);
                $("#vat_amt").text(vat_amt);
            }else{
                $("#price_ex_vat").text(formatNumber(parseFloat(retail_price)));
                $("#vat_amt").text(0);
            }
        }

        function calculateDiscountPrice(){
            const retail_price = parseFloat($("#retail_price").text());
            const discount_percent = $("#discount_percent").val();
            if(retail_price != "" && discount_percent != ""){
                const discount_price = retail_price - (retail_price / 100) * parseFloat(discount_percent);
                $("#discount_price").text(formatNumber(parseFloat(discount_price)));
            }else{
                $("#discount_price").text(formatNumber(parseFloat(retail_price)));
            }
        }

        $("#calculatePriceFormSubmit").on('submit', function (e){
            e.preventDefault();
            var self = $("#calculatePriceFormSubmit");
            var formData = new FormData($(self)[0]);
            var url = $(self).attr('action');

            formPost(url, formData, function (res) {
                if(res.status == 200){
                    showSuccessAlert('Success',res.message)
                    setTimeout(function () {
                        window.location.href = "{{route('production.board-pre-production.index')}}";
                    }, 1000);
                }else{
                    showErrorAlert('Error',res.message)
                }
            }, 'show_input_error');
        })
    </script>
@endsection
