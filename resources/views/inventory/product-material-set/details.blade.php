@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="mb-5">
                @csrf
                <div class="erp-employee-list-wrapper purchase-order-in-main">
                    <div class="erp-main-filter-wrapper bg-card attd-table">
                        <div class="purchase-order-invoice-wrapper">
                            <div class="purchase-order-invoice-header-box ">
                                <div class="product-general-info-box d-flex flex-wrap pd-box">
                                    <div class="pgib-item flex-32 pd-item">
                                        <div class="input-block erp-step-input-block mb-0">
                                            <label class="col-form-label">Name</label>
                                            <h4>{{ $material_set->name }}</h4>
                                        </div>
                                    </div>
                                    <div class="pgib-item flex-32 pd-item">
                                        <div class="input-block erp-step-input-block mb-0">
                                            <label class="col-form-label">SRP Markup %</label>
                                            <h4>{{ formatNumber($material_set->srp_markup_percent) }}%</h4>
                                        </div>
                                    </div>
                                    <div class="pgib-item flex-32 pd-item">
                                        <div class="input-block erp-step-input-block mb-0">
                                            <label class="col-form-label">Wholesale Discount % </label>
                                            <h4>{{ formatNumber($material_set->wholesale_discount_percent) }}%</h4>
                                        </div>
                                    </div>
                                    <div class="pgib-item flex-32 pd-item">
                                        <div class="input-block erp-step-input-block mb-0">
                                            <label class="col-form-label">Cost</label>
                                            <h4>{{ getCurrencySymbol() }}{{ formatNumber($material_set->rp_cost) }}</h4>
                                        </div>
                                    </div>
                                    <div class="pgib-item flex-32 pd-item">
                                        <div class="input-block erp-step-input-block mb-0">
                                            <label class="col-form-label">SRP </label>
                                            <h4>{{ getCurrencySymbol() }}{{ formatNumber($material_set->rp_srp) }}</h4>
                                        </div>
                                    </div>
                                    <div class="pgib-item flex-32 pd-item">
                                        <div class="input-block erp-step-input-block mb-0">
                                            <label class="col-form-label">SRP With 20% Discount</label>
                                            <h4>{{ getCurrencySymbol() }}{{ formatNumber($material_set->srp_with_discount) }}</h4>
                                        </div>
                                    </div>
                                    <div class="pgib-item flex-32 pd-item">
                                        <div class="input-block erp-step-input-block mb-0">
                                            <label class="col-form-label">Wholesale </label>
                                            <h4>{{ getCurrencySymbol() }}{{ formatNumber($material_set->wholesale) }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="purchase-order-invoice-body-box">
                                <div class="purchase-order-invoice-body-product-wrap">
                                    <div class="purchase-order-product-header-wrapper d-flex flex-wrap align-items-center">
                                        <div class="po-product-header-item product-material-set-item">
                                            <h4>Items</h4>
                                        </div>
                                        <div class="po-product-header-item product-material-set-item">
                                            <h4 class="text-center">Cost</h4>
                                        </div>
                                        <div class="po-product-header-item product-material-set-item">
                                            <h4 class="text-center">QTY</h4>
                                        </div>
                                        <div class="po-product-header-item product-material-set-item">
                                            <h4 class="text-center">SRP</h4>
                                        </div>
                                        <div class="po-product-header-item product-material-set-item">
                                            <h4 class="text-center">SRP With 20% Discount</h4>
                                        </div>
                                        <div class="po-product-header-item product-material-set-item">
                                            <h4 class="text-center">Wholesale</h4>
                                        </div>
                                    </div>
                                    <div class="purchase-order-product-body-wrapper">
                                        @foreach ($material_set->set_items as $data)
                                            <div class="po-order-product-body-inner-main-wrapper" >
                                                <div class="po-order-product-body-inner-wrapper d-flex flex-wrap align-items-center">
                                                    <div class="purchase-order-product-body-item product-material-set-item">
                                                        <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100">
                                                            <div class="em-pro-img-box">
                                                                <img src="{{$data->productMaterial?->show_image}}" alt="">
                                                            </div>
                                                            <div class="em-pro-details-box po-product">
                                                                <h5>{{ $data->productMaterial?->name }}</h5>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="purchase-order-product-body-item product-material-set-item">
                                                        <div class="purchase-order-product-body-item-inner">
                                                            <div class="purchase-order-product-body-item-inner-content">
                                                                <div class="pd-item">
                                                                    <h4>{{ getCurrencySymbol() }}{{ formatNumber($data->rp_cost) }}</h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="purchase-order-product-body-item product-material-set-item">
                                                        <div class="purchase-order-product-body-item-inner">
                                                            <div class="purchase-order-product-body-item-inner-content">
                                                                <div class="pd-item">
                                                                    <h4>{{ getCurrencySymbol() }}{{ $data->quantity }}</h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="purchase-order-product-body-item product-material-set-item">
                                                        <div class="purchase-order-product-body-item-inner">
                                                            <div class="purchase-order-product-body-item-inner-content">
                                                                <div class="pd-item">
                                                                    <h4>{{ getCurrencySymbol() }}{{ formatNumber($data->rp_srp) }}</h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="purchase-order-product-body-item product-material-set-item">
                                                        <div class="purchase-order-product-body-item-inner">
                                                            <div class="purchase-order-product-body-item-inner-content">
                                                                <div class="pd-item">
                                                                    <h4>{{ getCurrencySymbol() }}{{ formatNumber($data->srp_with_discount) }}</h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="purchase-order-product-body-item product-material-set-item">
                                                        <div class="purchase-order-product-body-item-inner">
                                                            <div class="purchase-order-product-body-item-inner-content">
                                                                <div class="pd-item">
                                                                    <h4>{{ getCurrencySymbol() }}{{ formatNumber($data->wholesale) }}</h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="purchase-order-product-body-mesurement flex-100">
                                                        <div class="purchase-order-product-body-mesurement-wrapper d-flex flex-wrap align-items-center">
                                                            <div class="po-order-product-body-mesurement-item">
                                                                <h4>Product Code :</h4>
                                                                <p># {{ $data->productMaterial?->code }}</p>
                                                            </div>
                                                            <div class="po-order-product-body-mesurement-item">
                                                                <h4>Unit :</h4>
                                                                <p>{{ $data->productMaterial?->unit_type }}</p>
                                                            </div>
                                                            <div class="po-order-product-body-mesurement-item">
                                                                <h4>Length :</h4>
                                                                <p>{{ $data->productMaterial?->length }}</p>
                                                            </div>
                                                            <div class="po-order-product-body-mesurement-item">
                                                                <h4>Width :</h4>
                                                                <p>{{ $data->productMaterial?->width }}</p>
                                                            </div>
                                                            <div class="po-order-product-body-mesurement-item">
                                                                <h4>Thickness :</h4>
                                                                <p>{{ $data->productMaterial?->thickness }}</p>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
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
@endsection

@section('modals')

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
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <script>
    </script>

@endsection
