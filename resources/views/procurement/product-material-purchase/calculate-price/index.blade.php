@extends('layouts.layout')
@section('content')
    <div class="row justify-content-center" id="VueApp">
        <div class="col-md-12">
            <div class="erp-employee-list-wrapper purchase-order-in-main">
                <form action="{{route('procurement.purchase-order.calulate-price.store', $purchase->id)}}" id="calculatePriceFormSubmit" method="POST" @submit="checkValidation">
                    @csrf
                    <div class="erp-main-filter-wrapper bg-card attd-table">
                        <div class="rs-erp-calculated-price-wrapper">
                            <div class="default-vat-set-box mb-3">
                                <div class="rs-ecp-bottom-box-item">
                                    <div class="rs-ecp-std-item-title-box">
                                        <h4>Set Vat Value(%)</h4>
                                    </div>
                                    <div class="rs-ecp-std-item-input-box">
                                        <input type="number" name="vat_percent" @input="setVatValueHandler($event)" id="vat_percent" class="form-control" value="12">
                                    </div>
                                </div>
                            </div>
                            @foreach ($purchase->purchaseDetails as $data)
                                <div class="rs-ecp-single-wrap">
                                    <input type="hidden" name="product_material_purchase_detail_id[]" value="{{$data->id}}">
                                    <input type="hidden" name="product_material_id[]" value="{{$data->productMaterial->id}}">
                                    <div class="rs-ecp-single-top-box d-flex flex-wrap">
                                        <div class="rs-ecp-stb-left-wrap d-flex flex-wrap">
                                            <div class="rs-ecp-std-left-item">
                                                <div class="rs-ecp-std-item-title-box">
                                                    <h4>Name</h4>
                                                </div>
                                                <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100">
                                                    <div class="em-pro-img-box">
                                                        <img src="{{$data->productMaterial->show_image}}" alt="">
                                                    </div>
                                                    <div class="em-pro-details-box">
                                                        <h5>{{$data->productMaterial->name}}</h5>
                                                        <p class="em-id">Code: <span> {{$data->productMaterial->code? '#'.$data->productMaterial->code : 'N/A'}}</span></p>   
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="rs-ecp-std-left-item">
                                                <div class="rs-ecp-std-item-title-box">
                                                    <h4>QTY</h4>
                                                </div>
                                                <div class="rs-ecp-std-item-content-box">
                                                    <input type="hidden" name="qty[]" value="{{$data->qty}}">
                                                    <span class="qty">{{$data->qty}}</span>
                                                </div>
                                            </div>
                                            <div class="rs-ecp-std-left-item">
                                                <div class="rs-ecp-std-item-title-box">
                                                    <h4>Price</h4>
                                                </div>
                                                <div class="rs-ecp-std-item-content-box">
                                                    <input type="hidden" name="price[]" value="{{$data->unit_price}}">
                                                   {{ getCurrencySymbol() }}<span class="unit_price">{{$data->unit_price}}</span>
                                                </div>
                                            </div>
                                            <div class="rs-ecp-std-left-item flex-100">
                                                <div class="p-dec-box-wrap">
                                                    <div class="p-dec-title">
                                                        <h4>Description</h4>
                                                    </div>
                                                    <div class="p-dec-box">
                                                        <p>{{$data->description??'N/A'}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="rs-ecp-stb-right-wrap d-flex flex-wrap justify-content-between">
                                            <div class="rs-ecp-std-r-left">
                                                <div class="rs-ecp-std-r-left-top-wrap d-flex flex-wrap">
                                                    <div class="rs-ecp-std-r-left-top-item">
                                                        <div class="rs-ecp-std-r-left-top-title-box">
                                                            <h4>Price FOB PHP</h4>
                                                        </div>
                                                        <div class="rs-ecp-std-r-left-top-content-box">
                                                            <span class="price_fob_php">0.00</span>
                                                        </div>
                                                    </div>
                                                    <div class="rs-ecp-std-r-left-top-item">
                                                        <div class="rs-ecp-std-r-left-top-title-box">
                                                            <h4>Freight Cost</h4>
                                                        </div>
                                                        <div class="rs-ecp-std-r-left-top-content-box">
                                                            <span class="freight_cost">0.00</span>
                                                        </div>
                                                    </div>
                                                    <div class="rs-ecp-std-r-left-top-item">
                                                        <div class="rs-ecp-std-r-left-top-title-box">
                                                            <h4>Taxes Import <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Product Category" data-bs-original-title="TAXES IMPORT DUTIES"><i class="fa-duotone fa-exclamation"></i></span></h4>
                                                        </div>
                                                        <div class="rs-ecp-std-r-left-top-content-box">
                                                            <span class="taxes_import_duties">0.00</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="rs-ecp-std-r-left-bottom-wrap d-flex flex-wrap">
                                                    <div class="rs-ecp-std-r-left-bottom-item">
                                                        <div class="rs-ecp-std-r-left-top-title-box">
                                                            <h4>Transport Cost to Warehouse</h4>
                                                        </div>
                                                        <div class="rs-ecp-std-r-left-top-content-box">
                                                            <span class="transport_cost_to_warehouse">0.00</span>
                                                        </div>
                                                    </div>
                                                    <div class="rs-ecp-std-r-left-bottom-item">
                                                        <div class="rs-ecp-std-r-left-top-title-box">
                                                            <h4>Unloading Cost</h4>
                                                        </div>
                                                        <div class="rs-ecp-std-r-left-top-content-box">
                                                            <span class="unloading_cost">0.00</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="rs-ecp-std-r-right">
                                                <div class="rs-ecp-std-r-right-top-wrap d-flex flex-wrap">
                                                    <div class="rs-ecp-std-r-right-top-item">
                                                        <div class="rs-ecp-std-r-left-top-title-box">
                                                            <h4>Price Excluding VAT</h4>
                                                        </div>
                                                        <div class="rs-ecp-std-r-left-top-content-box">
                                                            <span class="price_excluding_vat">0.00</span>
                                                        </div>
                                                    </div>
                                                    <div class="rs-ecp-std-r-right-top-item">
                                                        <div class="rs-ecp-std-r-left-top-title-box">
                                                            <h4>VAT</h4>
                                                        </div>
                                                        <div class="rs-ecp-std-r-left-top-content-box">
                                                            <span class="vat_amount">0.00</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="rs-ecp-std-r-right-bottom-wrap">
                                                    <div class="rs-ecp-std-r-right-bottom-item">
                                                        <div class="rs-ecp-std-r-left-top-title-box">
                                                            <h4>Final Price</h4>
                                                        </div>
                                                        <div class="rs-ecp-std-r-left-top-content-box">
                                                            <span class="final_price">0.00</span>
                                                        </div>
                                                    </div>
                                                    <div class="rs-ecp-std-r-right-bottom-item">
                                                        <div class="rs-ecp-std-r-left-top-title-box">
                                                            <h4>Total Final Price</h4>
                                                        </div>
                                                        <div class="rs-ecp-std-r-left-top-content-box">
                                                            <span class="total_final_price">0.00</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="rs-ecp-bottom-box d-flex flex-wrap">
                                        <div class="rs-ecp-bottom-box-item">
                                            <div class="rs-ecp-std-item-title-box">
                                                <h4>Exchange Rate</h4>
                                            </div>
                                            <div class="rs-ecp-std-item-input-box">
                                                <input type="number" @input="exchangeRateHandler($event)" name="exchange_rate[]" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="rs-ecp-bottom-box-item">
                                            <div class="rs-ecp-std-item-title-box">
                                                <h4>CBM</h4>
                                            </div>
                                            <div class="rs-ecp-std-item-input-box">
                                                <input type="number" name="cbm[]" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="rs-ecp-bottom-box-item">
                                            <div class="rs-ecp-std-item-title-box">
                                                <h4>Total Pieces per Container </h4>
                                            </div>
                                            <div class="rs-ecp-std-item-input-box">
                                                <input type="number" @input="totalPcPerContainerHandler($event)" name="total_pieces_per_container[]" class="form-control total_pieces_per_container" required>
                                            </div>
                                        </div>
                                        <div class="rs-ecp-bottom-box-item">
                                            <div class="rs-ecp-std-item-title-box">
                                                <h4>Freight Cost USD</h4>
                                            </div>
                                            <div class="rs-ecp-std-item-input-box">
                                                <input type="number" @input="freightCostUsdHandler($event)" name="freight_cost_usd[]" class="form-control freight_cost_usd" required>
                                            </div>
                                        </div>
                                        <div class="rs-ecp-bottom-box-item">
                                            <div class="rs-ecp-std-item-title-box">
                                                <h4>Exchange Rate  <span>After Import</span></h4>
                                            </div>
                                            <div class="rs-ecp-std-item-input-box">
                                                <input type="number" @input="exchangeRateAfterImportHandler($event)" name="exchange_rate_after_import[]" class="form-control exchange_rate_after_import" required>
                                            </div>
                                        </div>
                                        <div class="rs-ecp-bottom-box-item">
                                            <div class="rs-ecp-std-item-title-box">
                                                <h4>Total Taxes Import Duties MNL</h4>
                                            </div>
                                            <div class="rs-ecp-std-item-input-box">
                                                <input type="number" @input="totalTaxesImportDutiesHandler($event)" name="total_taxes_import_duties[]" class="form-control total_taxes_import_duties" required>
                                            </div>
                                        </div>
                                        <div class="rs-ecp-bottom-box-item">
                                            <div class="rs-ecp-std-item-title-box">
                                                <h4>Total Transport Cost to WH</h4>
                                            </div>
                                            <div class="rs-ecp-std-item-input-box">
                                                <input type="number" @input="totalTransportCostToWH($event)" name="total_transport_cost_to_wh[]" class="form-control total_transport_cost_to_wh" required>
                                            </div>
                                        </div>
                                        <div class="rs-ecp-bottom-box-item">
                                            <div class="rs-ecp-std-item-title-box">
                                                <h4>Total Unloading Cost</h4>
                                            </div>
                                            <div class="rs-ecp-std-item-input-box">
                                                <input type="number" @input="totalUnloadingCostHandler($event)" name="total_unloading_cost[]" class="form-control total_unloading_cost" required>
                                            </div>
                                        </div>
                                        <div class="rs-ecp-bottom-box-item">
                                            <div class="rs-ecp-std-item-title-box">
                                                <h4>Handling Cost</h4>
                                            </div>
                                            <div class="rs-ecp-std-item-input-box">
                                                <input type="number" @input="handlingCostHandler($event)" name="handling_cost[]" class="form-control handling_cost" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <script>
        var { createApp } = Vue;
        var vueApp = createApp({
            data() {
                
            },
            computed: {
                
            },
            methods: {
                exchangeRateHandler(event) {
                    const exchangeRate = event.target.value;
                    const priceElement = event.target.closest('.rs-ecp-single-wrap').querySelector('.unit_price');
                    const priceFOBPHPElement = event.target.closest('.rs-ecp-single-wrap').querySelector('.price_fob_php');

                    if (priceElement && priceFOBPHPElement) {
                        const price = parseFloat(priceElement.textContent);
                        const priceFOBPHP = exchangeRate * price;
                        priceFOBPHPElement.textContent = priceFOBPHP.toFixed(2); 
                    }
                    this.calculatePriceExcludingVat(event);
                },
                totalPcPerContainerHandler(event) {
                    this.calculateFreightCost(event);
                    this.calculateTaxesImportDuties(event);
                    this.calculateTransportCostToWH(event);
                    this.calculateUnloadingCost(event);
                    this.calculatePriceExcludingVat(event);
                },

                freightCostUsdHandler(event) {
                    this.calculateFreightCost(event);
                    this.calculatePriceExcludingVat(event);
                },

                exchangeRateAfterImportHandler(event) {
                    this.calculateFreightCost(event);
                    this.calculatePriceExcludingVat(event);
                },

                totalTaxesImportDutiesHandler(event){
                    this.calculateTaxesImportDuties(event);
                    this.calculatePriceExcludingVat(event);
                },

                totalTransportCostToWH(event){
                    this.calculateTransportCostToWH(event);
                    this.calculatePriceExcludingVat(event);
                },

                totalUnloadingCostHandler(event){
                    this.calculateUnloadingCost(event);
                    this.calculatePriceExcludingVat(event);
                },

                handlingCostHandler(event){
                    this.calculatePriceExcludingVat(event);
                },

                setVatValueHandler(event){
                    const vatPercentage = event.target.value;
                    this.calculateVat(vatPercentage);
                },

                calculateFreightCost(event) {
                    const parentElement = event.target.closest('.rs-ecp-single-wrap');
                    if (!parentElement) return;

                    const totalPcPerContainerInput = parentElement.querySelector('.total_pieces_per_container');
                    const freightCostUsdInput = parentElement.querySelector('.freight_cost_usd');
                    const exchangeRateAfterImportInput = parentElement.querySelector('.exchange_rate_after_import');
                    const freightCostElement = parentElement.querySelector('.freight_cost');

                    if (!totalPcPerContainerInput || !freightCostUsdInput || !exchangeRateAfterImportInput || !freightCostElement) return;

                    const totalPcPerContainer = parseFloat(totalPcPerContainerInput.value);
                    const freightCostUsd = parseFloat(freightCostUsdInput.value);
                    const exchangeRateAfterImport = parseFloat(exchangeRateAfterImportInput.value);

                    if (isNaN(totalPcPerContainer) || isNaN(freightCostUsd) || isNaN(exchangeRateAfterImport)) {
                        freightCostElement.textContent = 0;
                    } else {
                        const freightCost = (freightCostUsd / totalPcPerContainer) * exchangeRateAfterImport;
                        freightCostElement.textContent = freightCost.toFixed(2);
                    }
                },

                calculateTaxesImportDuties(event) {
                    const parentElement = event.target.closest('.rs-ecp-single-wrap');
                    if (!parentElement) return;

                    const totalPcPerContainerInput = parentElement.querySelector('.total_pieces_per_container');
                    const totalTaxesImportDutiesInput = parentElement.querySelector('.total_taxes_import_duties');
                    const taxesImportDutiesElement = parentElement.querySelector('.taxes_import_duties');

                    if (!totalPcPerContainerInput || !totalTaxesImportDutiesInput || !taxesImportDutiesElement) return;

                    const totalPcPerContainer = parseFloat(totalPcPerContainerInput.value);
                    const totalTaxesImportDuties = parseFloat(totalTaxesImportDutiesInput.value);

                    if (isNaN(totalPcPerContainer) || isNaN(totalTaxesImportDuties)) {
                        taxesImportDutiesElement.textContent = 0;
                    } else {
                        const taxesImportDuties = totalTaxesImportDuties / totalPcPerContainer;
                        taxesImportDutiesElement.textContent = taxesImportDuties.toFixed(2);
                    }
                },

                calculateTransportCostToWH(event) {
                    const parentElement = event.target.closest('.rs-ecp-single-wrap');
                    if (!parentElement) return;

                    const totalPcPerContainerInput = parentElement.querySelector('.total_pieces_per_container');
                    const totalTransportCostToWhInput = parentElement.querySelector('.total_transport_cost_to_wh');
                    const transportCostToWhElement = parentElement.querySelector('.transport_cost_to_warehouse');

                    if (!totalPcPerContainerInput || !totalTransportCostToWhInput || !transportCostToWhElement) return;

                    const totalPcPerContainer = parseFloat(totalPcPerContainerInput.value);
                    const totalTransportCostToWh = parseFloat(totalTransportCostToWhInput.value);

                    if (isNaN(totalPcPerContainer) || isNaN(totalTransportCostToWh)) {
                        transportCostToWhElement.textContent = 0;
                    } else {
                        const taxesImportDuties = totalTransportCostToWh / totalPcPerContainer;
                        transportCostToWhElement.textContent = taxesImportDuties.toFixed(2);
                    }
                },

                calculateUnloadingCost(event) {
                    const parentElement = event.target.closest('.rs-ecp-single-wrap');
                    if (!parentElement) return;

                    const totalPcPerContainerInput = parentElement.querySelector('.total_pieces_per_container');
                    const totalUnloadingCostInput = parentElement.querySelector('.total_unloading_cost');
                    const unloadingCostElement = parentElement.querySelector('.unloading_cost');

                    if (!totalPcPerContainerInput || !totalUnloadingCostInput || !unloadingCostElement) return;

                    const totalPcPerContainer = parseFloat(totalPcPerContainerInput.value);
                    const totalUnloadingCost = parseFloat(totalUnloadingCostInput.value);

                    if (isNaN(totalPcPerContainer) || isNaN(totalUnloadingCost)) {
                        unloadingCostElement.textContent = 0;
                    } else {
                        const unloadingCost = totalUnloadingCost / totalPcPerContainer;
                        unloadingCostElement.textContent = unloadingCost.toFixed(2);
                    }
                },

                calculatePriceExcludingVat(event) {
                    const parentElement = event.target.closest('.rs-ecp-single-wrap');
                    if (!parentElement) return;

                    const priceFOBElement = parentElement.querySelector('.price_fob_php');
                    const freightCostElement = parentElement.querySelector('.freight_cost');
                    const taxesImportDutiesElement = parentElement.querySelector('.taxes_import_duties');
                    const transportCostToWhElement = parentElement.querySelector('.transport_cost_to_warehouse');
                    const unloadingCostElement = parentElement.querySelector('.unloading_cost');
                    const handlingCostInput = parentElement.querySelector('.handling_cost');
                    const priceExcludingVat = parentElement.querySelector('.price_excluding_vat');

                    if (!priceFOBElement || !freightCostElement || !taxesImportDutiesElement || !transportCostToWhElement || !unloadingCostElement || !handlingCostInput || !priceExcludingVat) return;

                    const priceFOB = parseFloat(priceFOBElement.textContent);
                    const freightCost = parseFloat(freightCostElement.textContent);
                    const taxesImportDuties = parseFloat(taxesImportDutiesElement.textContent);
                    const transportCostToWh = parseFloat(transportCostToWhElement.textContent);
                    const unloadingCost = parseFloat(unloadingCostElement.textContent);
                    const handlingCost = parseFloat(handlingCostInput.value);

                    if (isNaN(priceFOB) || isNaN(freightCost) || isNaN(taxesImportDuties) || isNaN(transportCostToWh) || isNaN(unloadingCost) || isNaN(handlingCost)) {
                        priceExcludingVat.textContent = '0.00';
                    } else {
                        const finalPrice = (priceFOB + freightCost + taxesImportDuties + transportCostToWh + unloadingCost) * handlingCost;
                        priceExcludingVat.textContent = finalPrice.toFixed(2);
                    }

                    // Calculate and display the VAT amount based on calculated price
                    const vatPercentage = document.getElementById('vat_percent').value;
                    this.calculateVat(vatPercentage, parentElement);
                },

                calculateVat(vatPercent, parentElement) {
                    if (isNaN(vatPercent)) return;
                    if(parentElement){
                        const vatAmountElement = parentElement.querySelector('.vat_amount');
                        const priceExcludingVatElement = parentElement.querySelector('.price_excluding_vat');
                        const finalPriceElement = parentElement.querySelector('.final_price');
                        const totalFinalPriceElement = parentElement.querySelector('.total_final_price');
                        const qtyElement = parentElement.querySelector('.qty');

                        if (!vatAmountElement || !priceExcludingVatElement) return;
                        const priceExcludingVat = parseFloat(priceExcludingVatElement.textContent);
                        if (isNaN(priceExcludingVat)) {
                            vatAmountElement.textContent = '0.00';
                            finalPriceElement.textContent = '0.00';
                            totalFinalPriceElement.textContent = '0.00';
                            totalFinalPriceElement.textContent = '0.00';
                        } else{
                            const vatAmount = (priceExcludingVat * vatPercent) / 100;
                            vatAmountElement.textContent = vatAmount.toFixed(2);
                            const final_price_amt = (priceExcludingVat + vatAmount).toFixed(2);
                            finalPriceElement.textContent = final_price_amt;
                            totalFinalPriceElement.textContent = (final_price_amt * parseFloat(qtyElement.textContent)).toFixed(2);
                        } 
                    }else{
                        const items = document.querySelectorAll('.rs-ecp-single-wrap');
                        items.forEach(item => {
                            const priceExcludingVatElement = item.querySelector('.price_excluding_vat');
                            const vatAmountElement = item.querySelector('.vat_amount');
                            const finalPriceElement = item.querySelector('.final_price');
                            const totalFinalPriceElement = item.querySelector('.total_final_price');
                            const qtyElement = item.querySelector('.qty');

                            if (!priceExcludingVatElement || !vatAmountElement) return;
                            const priceExcludingVat = parseFloat(priceExcludingVatElement.textContent);

                            if (isNaN(priceExcludingVat)) {
                                vatAmountElement.textContent = '0.00';
                                finalPriceElement.textContent = '0.00';
                                totalFinalPriceElement.textContent = '0.00';
                                totalFinalPriceElement.textContent = '0.00';
                            } else{
                                const vatAmount = (priceExcludingVat * vatPercent) / 100;
                                vatAmountElement.textContent = vatAmount.toFixed(2);
                                const final_price_amt = (priceExcludingVat + vatAmount).toFixed(2);
                                finalPriceElement.textContent = final_price_amt;
                                totalFinalPriceElement.textContent = (final_price_amt * parseFloat(qtyElement.textContent)).toFixed(2);
                            }
                        });
                    }
                },

                checkValidation(e) {
                    e.preventDefault();
                    let allInputsFilled = true;
                    $('.rs-ecp-single-wrap').each(function(index, element) {
                        const inputs = $(element).find('input[type="text"]');
                        inputs.each(function() {
                            if ($(this).val() === '') {
                                allInputsFilled = false;
                                return false;
                            }
                        });
                    });

                    if (!allInputsFilled) {
                        showErrorAlert('Opps!', 'Please fill in all inputs!');
                    } else {
                        calculatePriceFormSubmit();
                    }
                },

                
            },
            mounted () {
            }

        }).mount('#VueApp');

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