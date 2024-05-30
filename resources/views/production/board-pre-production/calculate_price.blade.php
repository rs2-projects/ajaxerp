@extends('layouts.layout')
@section('content')
    <div class="row justify-content-center" id="VueApp">
        <div class="col-md-12">
            <div class="erp-employee-list-wrapper purchase-order-in-main">
                <form action="{{route('production.board-pre-production..calculate-price.store', $pre_production->id)}}" id="calculatePriceFormSubmit" method="POST" @submit="checkValidation">
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
                                            <input type="number" name="vat_percent" id="vat_percent" class="form-control" value="12">
                                        </div>
                                    </div>
                                </div>
                                <div class="default-vat-set-box mb-3">
                                    <div class="rs-ecp-bottom-box-item">
                                        <div class="rs-ecp-std-item-title-box">
                                            <h4>Retail Percentage(%)</h4>
                                        </div>
                                        <div class="rs-ecp-std-item-input-box">
                                            <input type="number" name="vat_percent" id="vat_percent" class="form-control" value="12">
                                        </div>
                                    </div>
                                </div>
                                <div class="default-vat-set-box mb-3">
                                    <div class="rs-ecp-bottom-box-item">
                                        <div class="rs-ecp-std-item-title-box">
                                            <h4>Discount Percentage(%)</h4>
                                        </div>
                                        <div class="rs-ecp-std-item-input-box">
                                            <input type="number" name="vat_percent" id="vat_percent" class="form-control" value="12">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rs-ecp-single-wrap">
                                <input type="hidden" name="product_material_purchase_detail_id[]" value="{{$pre_production->id}}">
                                {{-- <input type="hidden" name="product_material_id[]" value="{{$data->productMaterial->id}}"> --}}
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
                                                        <span class="price_fob_php">0.00</span>
                                                    </div>
                                                </div>
                                                <div class="rs-ecp-std-r-left-top-item">
                                                    <div class="rs-ecp-std-r-left-top-title-box">
                                                        <h4>Retail Price</h4>
                                                    </div>
                                                    <div class="rs-ecp-std-r-left-top-content-box">
                                                        <span class="freight_cost">0.00</span>
                                                    </div>
                                                </div>
                                                <div class="rs-ecp-std-r-left-top-item">
                                                    <div class="rs-ecp-std-r-left-top-title-box">
                                                        <h4>Price (Ex. Vat)</h4>
                                                    </div>
                                                    <div class="rs-ecp-std-r-left-top-content-box">
                                                        <span class="taxes_import_duties">0.00</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="rs-ecp-std-r-left-bottom-wrap d-flex flex-wrap">
                                                <div class="rs-ecp-std-r-left-bottom-item">
                                                    <div class="rs-ecp-std-r-left-top-title-box">
                                                        <h4>Vat</h4>
                                                    </div>
                                                    <div class="rs-ecp-std-r-left-top-content-box">
                                                        <span class="transport_cost_to_warehouse">0.00</span>
                                                    </div>
                                                </div>
                                                <div class="rs-ecp-std-r-left-bottom-item">
                                                    <div class="rs-ecp-std-r-left-top-title-box">
                                                        <h4>Discount Wholesale</h4>
                                                    </div>
                                                    <div class="rs-ecp-std-r-left-top-content-box">
                                                        <span class="unloading_cost">0.00</span>
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
                                            <input type="number" step="0.01" min="0" name="exchange_rate[]" class="form-control exchange_rate" required>
                                        </div>
                                    </div>
                                    <div class="rs-ecp-bottom-box-item">
                                        <div class="rs-ecp-std-item-title-box">
                                            <h4>Machine Cost</h4>
                                        </div>
                                        <div class="rs-ecp-std-item-input-box">
                                            <input type="number" step="0.01" min="0" name="price_usd[]" class="form-control price_usd" required>
                                        </div>
                                    </div>
                                    <div class="rs-ecp-bottom-box-item">
                                        <div class="rs-ecp-std-item-title-box">
                                            <h4>Paper Up Cost</h4>
                                        </div>
                                        <div class="rs-ecp-std-item-input-box">
                                            <input type="number" name="cbm[]" step="0.01" min="0" class="form-control cbm" required>
                                        </div>
                                    </div>
                                    <div class="rs-ecp-bottom-box-item">
                                        <div class="rs-ecp-std-item-title-box">
                                            <h4>Plate Up Cost </h4>
                                        </div>
                                        <div class="rs-ecp-std-item-input-box">
                                            <input type="number" step="0.01" min="0" name="total_pieces_per_container[]" class="form-control total_pieces_per_container" required>
                                        </div>
                                    </div>
                                    <div class="rs-ecp-bottom-box-item">
                                        <div class="rs-ecp-std-item-title-box">
                                            <h4>Paper Down Cost</h4>
                                        </div>
                                        <div class="rs-ecp-std-item-input-box">
                                            <input type="number" step="0.01" min="0" name="freight_cost_usd[]" class="form-control freight_cost_usd" required>
                                        </div>
                                    </div>
                                    <div class="rs-ecp-bottom-box-item">
                                        <div class="rs-ecp-std-item-title-box">
                                            <h4>Plate Down Cost</h4>
                                        </div>
                                        <div class="rs-ecp-std-item-input-box">
                                            <input type="number" step="0.01" min="0"  name="exchange_rate_after_import[]" class="form-control exchange_rate_after_import" required>
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
        
        function calculatePriceFormSubmit(){
            var self = $("#calculatePriceFormSubmit");
            var formData = new FormData($(self)[0]);
            var url = $(self).attr('action');

            formPost(url, formData, function (res) {
                if(res.status == 200){
                    showSuccessAlert('Success',res.message)
                    setTimeout(function () {
                        window.location.href = "{{route('procurement.product-material-purchase.index')}}";
                    }, 1000);
                }else{
                    showErrorAlert('Error',res.message)
                }
            }, 'show_input_error');
        }
    </script>
@endsection
