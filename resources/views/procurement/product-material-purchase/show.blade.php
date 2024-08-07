@extends('layouts.layout')
@section('content')
<!-- Start::row-1 -->
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="erp-employee-list-wrapper purchase-order-in-main">
            <div class="erp-main-filter-wrapper bg-card attd-table">
                <div class="purchase-order-invoice-wrapper">
                    <div class="purchase-order-invoice-header-box ">
                        <div class="purchase-supplier-select-box d-flex justify-content-between align-items-center">

                            <div class="purchase-invoice-info-wrapper d-flex justify-content-between align-items-center flex-100">
                                <div class="purchase-invoice-info-box flex-48">
                                    <div class="title-bx">
                                        <h2>Bill To</h2>
                                    </div>
                                    <div class="invoice-info-bx">
                                        <div class="invoice-info d-flex align-items-center">
                                            <h4 class="mb-0">Supplier Name</h4>
                                            <p class="mb-0">{{ $purchase->supplier->business_name??'N/A' }}</p>
                                        </div>
                                        <div class="invoice-info d-flex align-items-center">
                                            <h4 class="mb-0">Contact Name</h4>
                                            <p class="mb-0">{{ $purchase->supplier->full_name??'N/A' }}</p>
                                        </div>
                                        <div class="invoice-info d-flex align-items-center">
                                            <h4 class="mb-0">Email</h4>
                                            <p class="mb-0">{{ $purchase->supplier->email ??'N/A'}}</p>
                                        </div>
                                        <div class="invoice-info d-flex align-items-center">
                                            <h4 class="mb-0">Phone</h4>
                                            <p class="mb-0">{{ $purchase->supplier->phone??'N/A' }}</p>
                                        </div>
                                        <div class="invoice-info d-flex align-items-start address-invoice">
                                            <h4 class="mb-0">Address</h4>
                                            <p class="mb-0">{{ $purchase->supplier->address??'N/A' }},{{ $purchase->supplier->city??'N/A'}}-{{ $purchase->supplier->zip_code??'N/A'}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="purchase-supplier-invoice-box flex-25">
                                    <div class="supplier-invoice-input-box">
                                        <div class="input-block erp-step-input-block mb-0 view-purchase-input ">
                                            <label class="col-form-label d-block">Order Status </label>
                                            <h5 class="custom-info-bg">Investigation </h5>
                                        </div>
                                    </div>
                                    <div class="supplier-invoice-input-box">
                                        <div class="input-block erp-step-input-block mb-0 view-purchase-input ">
                                            <label class="col-form-label d-block">Batch No. </label>
                                            <h4>{{ $purchase->batch_number??'N/A' }}</h4>
                                        </div>
                                    </div>
                                    <div class="supplier-invoice-input-box">
                                        <div class="input-block erp-step-input-block mb-0 view-purchase-input ">
                                            <label class="col-form-label d-block">Purchase Date </label>
                                            <h4>{{ getFormattedDate($purchase->purchase_date)??'N/A' }}</h4>
                                        </div>
                                    </div>
                                    <div class="supplier-invoice-input-box">
                                        <div class="input-block erp-step-input-block mb-0 view-purchase-input ">
                                            <label class="col-form-label d-block">Estimate Delivery Date </label>
                                            <h4>{{ getFormattedDate($purchase->estimated_delivery_date)??'N/A' }}</h4>
                                        </div>
                                    </div>

                                    <div class="supplier-invoice-input-box">
                                        <div class="input-block erp-step-input-block mb-0 view-purchase-input ">
                                            <label class="col-form-label d-block">Payment Status </label>
                                            <h5 class="custom-success-bg">
                                            @if($purchase->payment_status==0)
                                                    Unpaid
                                                @elseif($purchase->payment_status==1)
                                                Partial
                                                @else
                                                Paid
                                                @endif
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="purchase-order-invoice-body-box">
                        <div class="purchase-order-invoice-body-product-wrap">
                            <div class="purchase-order-product-header-wrapper d-flex flex-wrap align-items-center">
                                <div class="po-product-header-item">
                                    <h4>Name</h4>
                                </div>
                                <div class="po-product-header-item">
                                    <h4 class="text-center">Description</h4>
                                </div>
                                <div class="po-product-header-item">
                                    <h4 class="text-center">Warrenty</h4>
                                </div>
                                <div class="po-product-header-item">
                                    <h4 class="text-center">QTY</h4>
                                </div>
                                <div class="po-product-header-item">
                                    <h4 class="text-center">Price</h4>
                                </div>
                                <div class="po-product-header-item">
                                    <h4 class="text-center">Amount</h4>
                                </div>
                            </div>
                            <div class="purchase-order-product-body-wrapper">
                                <div class="po-order-product-body-inner-main-wrapper">
                                    @foreach($purchase->purchaseDetails as $item)
                                    <div class="po-order-product-body-inner-wrapper d-flex flex-wrap align-items-center">
                                        <div class="purchase-order-product-body-item">
                                            <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100">
                                                <div class="em-pro-img-box">
                                                    <img src="{{ $item->productMaterial->show_image }}" alt="">
                                                </div>
                                                <div class="em-pro-details-box po-product">
                                                    <h5>{{ $item->productMaterial->name }}</h5>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="purchase-order-product-body-item">
                                            <div class="purchase-order-product-body-item-inner">
                                                <div class="purchase-order-product-body-item-inner-content">
                                                    <div class="input-block mb-0 erp-step-input-block view-purchase-i-two">
                                                        <h4>{{ $item->productMaterial->description }}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="purchase-order-product-body-item">
                                            <div class="purchase-order-product-body-item-inner">
                                                <div class="purchase-order-product-body-item-inner-content">
                                                    <div class="input-block mb-0 erp-step-input-block view-purchase-i-two">
                                                        <h4></h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="purchase-order-product-body-item">
                                            <div class="purchase-order-product-body-item-inner">
                                                <div class="purchase-order-product-body-item-inner-content">
                                                    <div class="input-block mb-0 erp-step-input-block view-purchase-i-two">
                                                        <h4>{{ $item->qty }}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="purchase-order-product-body-item">
                                            <div class="purchase-order-product-body-item-inner">
                                                <div class="purchase-order-product-body-item-inner-content">
                                                    <div class="input-block mb-0 erp-step-input-block view-purchase-i-two">
                                                        <h4>{{getCurrencySymbol('usd')}} {{ $item->unit_price }}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="purchase-order-product-body-item">
                                            <div class="purchase-order-product-body-item-inner">
                                                <div class="purchase-order-product-body-item-inner-content position-relative">
                                                    <h4 class="text-end total-amount-product pe-2">{{getCurrencySymbol('usd')}} {{ $item->total_price }}</h4>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="purchase-order-product-body-vat-tax flex-100 view-purchase-tax-custom">
                                            <div class="purchase-order-product-body-item-inner po-vat-tax-item-wrapper d-flex align-items-center  justify-content-end">
                                                <div class="po-vat-tax-item">
                                                    <div class="input-block erp-step-input-block  mb-0 two d-flex align-items-center gap-3 view-purchase-i-two">
                                                        <label class="col-form-label">Vat </label>
                                                        <h4>{{ $item->tax?->name }} {{ $item->tax?->tax_rate }}%</h4>
                                                    </div>
                                                </div>
                                                <div class="po-vat-tax-item">
                                                    <div class="purchase-order-product-body-item-inner-content position-relative">
                                                        <h4 class="text-end total-amount-product pe-2">{{getCurrencySymbol('usd')}} {{ $item->tax_amount }}</h4>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>


                                <div class="po-order-prudct-grand-total-box">
                                    <div class="po-order-prudct-grand-total-inner">
                                        <div class="purchase-order-product-body-item-inner po-vat-tax-item-wrapper d-flex align-items-center  justify-content-end">
                                            <div class="po-vat-tax-item grand-total-item">
                                                <h3>Sub Total</h3>
                                            </div>
                                            <div class="po-vat-tax-item grand-total-item">
                                                <div class="purchase-order-product-body-item-inner-content position-relative">
                                                    <h4 class="text-end sub-total-amount pe-2">{{getCurrencySymbol('usd')}} {{ $purchase->subtotal_amount }}</h4>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="purchase-order-product-body-item-inner po-vat-tax-item-wrapper d-flex align-items-center  justify-content-end">
                                            <div class="po-vat-tax-item grand-total-item">
                                                <h3>Total Vat</h3>
                                            </div>
                                            <div class="po-vat-tax-item grand-total-item">
                                                <div class="purchase-order-product-body-item-inner-content position-relative">
                                                    <h4 class="text-end sub-total-amount pe-2">{{getCurrencySymbol('usd')}} {{ $purchase->total_vat_amount }}</h4>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="purchase-order-product-body-item-inner po-vat-tax-item-wrapper d-flex align-items-center  justify-content-end">
                                            <div class="po-vat-tax-item grand-total-item">
                                                <h3>Discount </h3>
                                            </div>
                                            <div class="po-vat-tax-item grand-total-item">
                                                <div class="purchase-order-product-body-item-inner-content position-relative">
                                                    <h4 class="text-end sub-total-amount pe-2"> {{ $purchase->discount_value }} %</h4>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="purchase-order-product-body-item-inner po-vat-tax-item-wrapper d-flex align-items-center  justify-content-end">
                                            <div class="po-vat-tax-item grand-total-item">
                                                <h2>Grand Total - </h2>
                                            </div>
                                            <div class="po-vat-tax-item grand-total-item">
                                                <div class="purchase-order-product-body-item-inner-content position-relative">
                                                    <h4 class="text-end total-amount-product pe-2">{{getCurrencySymbol('usd')}} {{ $purchase->payable_amount }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="po-order-product-note-terms-box">
                                    <div class="po-order-product-note-terms-inner">
                                        <div class="po-order-product-note-terms-item">
                                            <div class="input-block erp-step-input-block mb-0 view-purchase-p-5">
                                                <label class="col-form-label pt-0">Notes / Terms</label>
                                                <h4>{{ $purchase->notes }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="purchase-order-product-footer-wrapper">
                            <div class="purchase-order-product-footer-header">
                                <h2>Invoice Footer</h2>
                            </div>
                            <div class="purchase-order-product-footer-body">
                                <div class="purchase-order-product-footer-body-inner">
                                    <div class="purchase-order-product-footer-body-item">
                                        <div class="input-block erp-step-input-block mb-0 view-purchase-p-5">

                                            <h4>{{ $purchase->invoice_footer }}</h4>
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
@endsection

@section('modals')

@endsection

@section('css')

@endsection

@section('css_plugins')
    <link rel="stylesheet" href="{{ asset('assets') }}/css/external-css/pre-custom.css">
@endsection

@section('js_plugins')
@endsection

@section('js')
@endsection



