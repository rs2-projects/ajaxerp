@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row justify-content-center" id="VueApp">
        <div class="col-md-12">
            <form class="mb-5" action="{{ route('sales.invoice.store') }}" id="invoiceStoreForm" method="post" @submit="checkValidation">
                @csrf
                <div class="erp-employee-list-wrapper purchase-order-in-main">
                    <div class="erp-main-filter-wrapper bg-card attd-table">
                        <div class="purchase-order-invoice-wrapper">
                            <div class="purchase-order-invoice-header-box ">
                                <div class="purchase-supplier-select-box d-flex justify-content-between align-items-center">
                                    <div class="purchase-add-supplier-box">
                                        <div class="supplier-icon-box">
                                            <img v-if="selected_customer===null" src="{{asset('assets/img/product/supplier.png')}}" alt="">
                                            <img v-else :src="selected_customer.show_image_full_url" alt="">
                                        </div>
                                        <div class="supplier-add-button-box text-center" onclick="showCustomerModal()">
                                            <a href="javascript:void(0)" v-if="selected_customer === null" class="as-btn">Add Customer</a>
                                            <a href="javascript:void(0)" v-else>Change Customer</a>
                                        </div>
                                    </div>
                                    <div class="purchase-invoice-info-wrapper d-flex justify-content-between align-items-center">
                                        <div class="purchase-invoice-info-box">
                                            <div class="title-bx">
                                                <h2>Bill To</h2>
                                            </div>
                                            <div class="invoice-info-bx" v-if="selected_customer !== null">
                                                <input type="hidden" name="customer_id" v-bind:value="selected_customer.id" id="selected_customer_id">
                                                <div class="invoice-info d-flex align-items-center">
                                                    <h4 class="mb-0">Customer Name</h4>
                                                    <p class="mb-0"> @{{ selected_customer.business_name  }} </p>
                                                </div>
                                                <div class="invoice-info d-flex align-items-center">
                                                    <h4 class="mb-0">Contact Name</h4>
                                                    <p class="mb-0">@{{ selected_customer.contact_full_name }} </p>
                                                </div>
                                                <div class="invoice-info d-flex align-items-center">
                                                    <h4 class="mb-0">Email</h4>
                                                    <p class="mb-0">@{{ selected_customer.email }} </p>
                                                </div>
                                                <div class="invoice-info d-flex align-items-center">
                                                    <h4 class="mb-0">Phone</h4>
                                                    <p class="mb-0">@{{ selected_customer.phone }} </p>
                                                </div>
                                                <div class="invoice-info d-flex align-items-start address-invoice">
                                                    <h4 class="mb-0">Address</h4>
                                                    <p class="mb-0">@{{ selected_customer.address }}</p>
                                                </div>
                                            </div>
                                            <div class="invoice-info-bx" v-else>
                                                <div class="invoice-info d-flex align-items-center">
                                                    <h4 class="mb-0">Customer Name</h4>
                                                    <p class="mb-0"> N/A </p>
                                                </div>
                                                <div class="invoice-info d-flex align-items-center">
                                                    <h4 class="mb-0">Contact Name</h4>
                                                    <p class="mb-0">N/A </p>
                                                </div>
                                                <div class="invoice-info d-flex align-items-center">
                                                    <h4 class="mb-0">Email</h4>
                                                    <p class="mb-0">N/A</p>
                                                </div>
                                                <div class="invoice-info d-flex align-items-center">
                                                    <h4 class="mb-0">Phone</h4>
                                                    <p class="mb-0">N/A </p>
                                                </div>
                                                <div class="invoice-info d-flex align-items-start address-invoice">
                                                    <h4 class="mb-0">Address</h4>
                                                    <p class="mb-0">N/A</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="purchase-supplier-invoice-box">
                                            <div class="supplier-invoice-input-box">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <label class="col-form-label">Store Order No. </label>
                                                    <div ><input class="form-control " required  name="order_no" type="text"></div>
                                                </div>
                                            </div>
                                            <div class="supplier-invoice-input-box">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <label class="col-form-label">Invoice Date </label>
                                                    <div class="cal-icon"><input class="form-control datetimepicker" value="{{ $invoice_date }}" name="invoice_date" type="text"></div>
                                                </div>
                                            </div>
                                            <div class="supplier-invoice-input-box">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <label class="col-form-label">Payment Date </label>
                                                    <div class="cal-icon"><input class="form-control datetimepicker"  value="{{ $payment_date }}" name="payment_date" type="text"></div>
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
                                            <h4 class="text-center">QTY</h4>
                                        </div>
                                        <div class="po-product-header-item sales-po-product-header-item">
                                            <h4 class="text-center">Price</h4>
                                        </div>
                                        <div class="po-product-header-item">
                                            <h4 class="text-center">Amount</h4>
                                        </div>
                                    </div>
                                    <div class="purchase-order-product-body-wrapper">
                                        <div class="po-order-product-body-inner-main-wrapper" v-for="(cartItem, cartItemIndex) in cartItems" :key="cartItemIndex">
                                            <div class="po-order-product-body-inner-wrapper d-flex flex-wrap align-items-center">
                                                <div class="purchase-order-product-body-item">
                                                    <input type="hidden" name="product_id[]" v-bind:value="cartItem.id">
                                                    <input type="hidden" name="item_type[]" v-bind:value="cartItem.item_type">
                                                    <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100">
                                                        <div class="em-pro-img-box">
                                                            <img :src="cartItem.show_image" alt="">
                                                        </div>
                                                        <div class="em-pro-details-box po-product">
                                                            <h5>@{{ cartItem.name }}</h5>
                                                        </div>
                                                    </div>


                                                </div>

                                                <div class="purchase-order-product-body-item">
                                                    <div class="purchase-order-product-body-item-inner">
                                                        <div class="purchase-order-product-body-item-inner-content">
                                                            <div class="input-block mb-0 erp-step-input-block ">
                                                                <textarea class="form-control auto-grow-input" name="description[]" v-model="cartItem.description" placeholder="Description"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="purchase-order-product-body-item">
                                                    <div class="purchase-order-product-body-item-inner">
                                                        <div class="purchase-order-product-body-item-inner-content">
                                                            <div class="input-block mb-0 erp-step-input-block ">
                                                                <input type="number" name="qty[]" min="1" v-model.number="cartItem.qty" v-on:input="updateQty(cartItemIndex)" required class="form-control text-center" placeholder="QTY">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="purchase-order-product-body-item sales-po-product-header-item">
                                                    <div class="purchase-order-product-body-item-inner">
                                                        <div class="purchase-order-product-body-item-inner-content">
                                                            <div class="input-block mb-0 erp-step-input-block ">
                                                                <input type="number" min="0" v-model="cartItem.price" name="price[]" v-on:input="updatePrice(cartItemIndex)" step="any" required class="form-control text-center" placeholder="Price">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="purchase-order-product-body-item">
                                                    <div class="purchase-order-product-body-item-inner">
                                                        <div class="purchase-order-product-body-item-inner-content position-relative">
                                                            <h4 class="text-center total-amount-product pe-2">
                                                            {{ getCurrencySymbol() }} <span class="amount-value">@{{ cartItem.spt_amount_wv }}</span>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="purchase-order-product-body-item sales-po-product-header-item-remove">
                                                    <div class="purchase-order-product-body-item-inner">
                                                        <div class="purchase-order-product-body-item-inner-content position-relative">
                                                            <div class="po-product-delete-icon-box">
                                                                <a href="javascript:void(0)" @click="removeItem(cartItemIndex)"><i class="fa fa-trash"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="purchase-order-product-body-mesurement flex-100">
                                                    <div class="purchase-order-product-body-mesurement-wrapper d-flex flex-wrap align-items-center">
                                                        
                                                        <div class="po-order-product-body-mesurement-item" v-if="cartItem.material_items != null">
                                                            <a href="javascript:void(0)" @click.prevent="itemDetails(cartItemIndex)" class="erp-search-btn text-center pp-add-more-btn pp-add-finished-board-btn" data-bs-toggle="modal" data-bs-target="#itemDetailsModal" ><i class="fa-solid fa-eye" style="font-size: 11px"></i> Items</a>
                                                        </div>
                                                        <div class="po-order-product-body-mesurement-item">
                                                            <h4>Type :</h4>
                                                            <p class="sales-cartItems-type-chip">@{{ getItemType(cartItem.item_type)  }}</p>
                                                        </div>
                                                        <div class="po-order-product-body-mesurement-item">
                                                            <h4>Product Code :</h4>
                                                            <p># @{{ cartItem.code  }}</p>
                                                        </div>
                                                        <div class="po-order-product-body-mesurement-item">
                                                            <h4>Unit :</h4>
                                                            <p>@{{ cartItem.unit_type }}</p>
                                                        </div>
                                                        <div class="po-order-product-body-mesurement-item">
                                                            <h4>Length :</h4>
                                                            <p>@{{ cartItem.length }}</p>
                                                        </div>
                                                        <div class="po-order-product-body-mesurement-item">
                                                            <h4>Width :</h4>
                                                            <p>@{{ cartItem.width }}</p>
                                                        </div>
                                                        <div class="po-order-product-body-mesurement-item">
                                                            <h4>Thickness :</h4>
                                                            <p>@{{ cartItem.thickness }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="purchase-order-product-body-vat-tax flex-100">
                                                    <div class="purchase-order-product-body-item-inner po-vat-tax-item-wrapper d-flex align-items-center  justify-content-end">
                                                        <div class="po-vat-tax-item">
                                                            <div class="input-block erp-step-input-block  mb-0 two d-flex align-items-center gap-3">
                                                                <label class="col-form-label">Vat </label>
                                                                <select class="select select-step" name="tax[]" onchange="taxChangeOutside(this)" v-bind:data-cartItemIndex="cartItemIndex">
                                                                    <option value="0" >Select Tax</option>
                                                                    <option v-for="stItem in system_tax_items" v-bind:value="stItem.id" :key="stItem.id" :selected="(cartItem.tax !== null) ? (cartItem.tax.id === stItem.id):false">
                                                                        @{{ stItem.name }} @{{ Number(stItem.tax_rate).toFixed(2) }}%
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="po-vat-tax-item">
                                                            <div class="purchase-order-product-body-item-inner-content position-relative">
                                                                <h4 class="text-end total-amount-product pe-2">
                                                                   {{getCurrencySymbol()}} <span class="vat-amount-value">@{{ cartItem.vat_amount }}</span>
                                                                </h4>
                                                                {{--<div class="po-product-delete-icon-box two">
                                                                    <a href="#"><i class="fa fa-times"></i></a>
                                                                </div>--}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="po-order-product-add-item text-center flex-wrap justify-content-center add_item_row_element_wrapper">
                                            {{-- <a href="javascript:void(0);" v-on:click="openSelectItemModal()" class="po-add-product-btn flex-100 justify-content-center"><span class="me-2"><i class="fa-solid fa-plus"></i></span> Add Product</a> --}}
                                            
                                            <div class="pms-item flex-100">
                                                <div class="add-more-m-box d-flex justify-content-center gap-2 align-items-center">
                                                    <a href="#" @click.prevent="openSelectItemModal('raw_materials')" class="erp-search-btn text-center pp-add-more-btn"><i class="la la-plus-circle"></i> Raw Material</a>
                                                    <a href="#" @click.prevent="openSelectItemModal('raw_boards')" class="erp-search-btn text-center pp-add-more-btn pp-add-board-btn"><i class="la la-plus-circle"></i> Board</a>
                                                    <a href="#" @click.prevent="openSelectItemModal('papers')" class="erp-search-btn text-center pp-add-more-btn pp-add-paper-btn"><i class="la la-plus-circle"></i> Paper</a>
                                                    <a href="#" @click.prevent="openSelectItemModal('finished_goods')" class="erp-search-btn text-center pp-add-more-btn pp-add-goods-btn"><i class="la la-plus-circle"></i> Finished Goods</a>
                                                    <a href="#" @click.prevent="openSelectItemModal('finished_boards')" class="erp-search-btn text-center pp-add-more-btn pp-add-finished-board-btn"><i class="la la-plus-circle"></i> Finished Board</a>
                                                    <a href="#" @click.prevent="openSelectItemModal('set_items')" class="erp-search-btn text-center pp-add-more-btn pp-add-set-item-btn"><i class="la la-plus-circle"></i> Set Item</a>
                                                </div>
                                            </div>

                                            <div class="searchable-input-wrapper flex-100" v-if="open_select_item">
                                                <div class="custom-searcable-input-wrap">
                                                    <input type="text" class="form-control" placeholder="Search Products" v-model="item_search" v-on:input="getSearchedItems()" >
                                                </div>
                                                <div class="search-product-item-wrapper custom-card-scroll" >
                                                    <div v-if="items.length > 0">
                                                        <div class="search-product-item" v-for="singleItem in items" :key="singleItem.id" @click="!['raw_materials', 'raw_boards', 'papers'].includes(current_item_type) && addItemToCart(singleItem)">
                                                            <div class="smi-left">
                                                                <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100 justify-content-start">
                                                                    <div class="em-pro-img-box">
                                                                        <img :src="singleItem.show_image" alt="">
                                                                    </div>
                                                                    <div class="em-pro-details-box po-product text-start">
                                                                        <h5>@{{ singleItem.name }}</h5>
                                                                    </div>
                                                                </div>
                                                                <div class="purchase-order-product-body-mesurement flex-100">
                                                                    <div class="purchase-order-product-body-mesurement-wrapper d-flex flex-wrap align-items-center">
                                                                        <div class="po-order-product-body-mesurement-item">
                                                                            <h4>Product Code :</h4>
                                                                            <p>#@{{ singleItem.code }}</p>
                                                                        </div>
                                                                        <div class="po-order-product-body-mesurement-item">
                                                                            <h4>Length :</h4>
                                                                            <p>@{{ singleItem.length }}</p>
                                                                        </div>
                                                                        <div class="po-order-product-body-mesurement-item">
                                                                            <h4>Width :</h4>
                                                                            <p>@{{ singleItem.width }}</p>
                                                                        </div>
                                                                        <div class="po-order-product-body-mesurement-item">
                                                                            <h4>Thickness :</h4>
                                                                            <p> @{{ singleItem.thickness }}</p>
                                                                        </div>
                                                                        <div class="po-order-product-body-mesurement-item" v-if="['raw_materials', 'raw_boards', 'papers'].includes(current_item_type)">
                                                                            <p> 
                                                                                <button type="button" class="btn btn-primary" @click="addItemToCart(singleItem, 'wholesale')">Add Wholesale</button>
                                                                            </p>
                                                                        </div>
                                                                        <div class="po-order-product-body-mesurement-item" @click="addItemToCart(singleItem, 'retail')" v-if="['raw_materials', 'raw_boards', 'papers'].includes(current_item_type)">
                                                                            <p> 
                                                                                <button type="button" class="btn btn-primary">Add Retail</button>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div v-else>
                                                        <div class="search-product-item" style="background: #ff727230;">
                                                            <div class="smi-left">
                                                                <h4>No Item Found.</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="po-order-prudct-grand-total-box">
                                            <div class="po-order-prudct-grand-total-inner">
                                                <div class="purchase-order-product-body-item-inner po-vat-tax-item-wrapper d-flex align-items-center  justify-content-end">
                                                    <div class="po-vat-tax-item grand-total-item">
                                                        <h3>Unloading Cost</h3>
                                                    </div>
                                                    <div class="po-vat-tax-item grand-total-item">
                                                        <div class="purchase-order-product-body-item-inner-content position-relative">
                                                            <input type="number" class="form-control text-end" v-model="unloading_cost" name="unloading_cost" required min="0">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="purchase-order-product-body-item-inner po-vat-tax-item-wrapper d-flex align-items-center  justify-content-end">
                                                    <div class="po-vat-tax-item grand-total-item">
                                                        <h3>Sub Total</h3>
                                                    </div>
                                                    <div class="po-vat-tax-item grand-total-item">
                                                        <div class="purchase-order-product-body-item-inner-content position-relative">
                                                            <h4 class="text-end sub-total-amount pe-2"> {{getCurrencySymbol()}}
                                                                <span class="subtotal-amount">@{{ cartSubTotalWithoutVatAmount }}</span>
                                                            </h4>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="purchase-order-product-body-item-inner po-vat-tax-item-wrapper d-flex align-items-center  justify-content-end">
                                                    <div class="po-vat-tax-item grand-total-item">
                                                        <h3>Total Vat</h3>
                                                    </div>
                                                    <div class="po-vat-tax-item grand-total-item">
                                                        <div class="purchase-order-product-body-item-inner-content position-relative">
                                                            <h4 class="text-end sub-total-amount pe-2">{{getCurrencySymbol()}}
                                                                <span class="subtotal-amount">@{{ cartTotalVatAmount }}</span>
                                                            </h4>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="purchase-order-product-body-item-inner po-vat-tax-item-wrapper d-flex align-items-center  justify-content-end">
                                                    <div class="po-vat-tax-item grand-total-item d-flex align-items-center gap-2 justify-content-end">
                                                        <h3 class="pe-0">Discount</h3>
                                                        <div class="invoice-switcher-box d-flex align-items-center gap-2">
                                                            <div class="invoice-switcher-item">
                                                                <div class="radio-inputs">
                                                                    <label for="discount-fixed" :class="{checked:(discount_type == 1)}">
                                                                        <input class="radio-input instagram" type="radio" id="discount-fixed" name="discount_type" value="1" style="display: none;"  v-model="discount_type" v-on:change="changeDiscountType" :checked="discount_type == 1" />
                                                                        <span class="radio-tile instagram">
                                                                            <span class="radio-icon"> {{getCurrencySymbol()}}</span>
                                                                       </span>
                                                                    </label>

                                                                    <label for="discount-percent" :class="{checked:(discount_type == 0)}">
                                                                        <input class="radio-input twitter" type="radio" id="discount-percent" name="discount_type" value="0" style="display: none;" v-model="discount_type" v-on:change="changeDiscountType" :checked="discount_type == 0" />
                                                                        <span class="radio-tile twitter">
                                                                            <span class="radio-icon">%</span>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="invoice-switcher-item">
                                                                <input type="number" step="0.01" v-model="discount_value" name="discount_value" class="form-control custom-switcher-value text-center" placeholder="0">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="po-vat-tax-item grand-total-item">
                                                        <div class="purchase-order-product-body-item-inner-content position-relative">
                                                            <h4 class="text-end sub-total-amount pe-2">
                                                                {{getCurrencySymbol()}} <span class="subtotal-amount"> @{{ discount_amount }}</span>
                                                            </h4>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="purchase-order-product-body-item-inner po-vat-tax-item-wrapper d-flex align-items-center  justify-content-end">
                                                    <div class="po-vat-tax-item grand-total-item">
                                                        <h2>Grand Total - </h2>
                                                    </div>
                                                    <div class="po-vat-tax-item grand-total-item">
                                                        <div class="purchase-order-product-body-item-inner-content position-relative">
                                                            <h4 class="text-end total-amount-product pe-2">
                                                                {{getCurrencySymbol()}}<span class="subtotal-amount">@{{ cartGrandTotalAmount }}</span>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="po-order-product-note-terms-box">
                                            <div class="po-order-product-note-terms-inner">
                                                <div class="po-order-product-note-terms-item">
                                                    <div class="input-block erp-step-input-block mb-0">
                                                        <label class="col-form-label pt-0">Notes / Terms</label>
                                                        <textarea class="form-control" name="notes" rows="2" placeholder="Enter notes or terms of service that you are visible to your customer"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="po-order-product-design-box-box">
                                            <div class="po-order-product-note-terms-inner">
                                                <div class="po-order-product-note-terms-item">
                                                    <div class="input-block erp-step-input-block mb-0">
                                                        <label class="col-form-label pt-0">Design Upload</label>
                                                        <input type="file" name="design[]" class="form-control" accept="image/*,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" multiple>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if(hasPermission('make-payment'))
                                            <div class="po-order-product-payment-status">
                                                <div class="po-order-product-payment-status-item">
                                                    <div class="checkbox-wrapper-35">
                                                        <input value="private" name="switch" id="payment_status_checkbox" type="checkbox" class="switch">
                                                        <label for="payment_status_checkbox">
                                                            <span class="switch-x-text">Payment Status </span>
                                                            <span class="switch-x-toggletext">
                                                                <span class="switch-x-unchecked"><span class="switch-x-hiddenlabel">Unchecked: </span>Unpaid</span>
                                                                <span class="switch-x-checked"><span class="switch-x-hiddenlabel">Checked: </span>Paid</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="po-order-product-payment-status-item" id="payment_status_details" style="display: none;">
                                                    <div class="payment-selection-wrapper d-flex flex-wrap justify-content-between">
                                                        <div class="payment-selection-item">
                                                            <div class="input-block erp-step-input-block  mb-0 two">
                                                                <label class="col-form-label">Payment Method <span class="text-danger"> *</span> </label>
                                                                <select class="select select-step" name="payment_method" id="payment_method">
                                                                    <option value="">Select Payment Method</option>
                                                                    @foreach($payment_methods as $key=>$payment_method)
                                                                        <option value="{{ $key }}">{{ $payment_method }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="payment-selection-item">
                                                            <div class="input-block erp-step-input-block mb-0">
                                                                <label class="col-form-label">Amount <span class="text-danger">*</span> </label>
                                                                <input type="number" step="any" class="form-control"  min="0.01" id="amount"  name="amount">
                                                            </div>
                                                        </div>
                                                        <div class="payment-selection-item">
                                                            <div class="input-block erp-step-input-block mb-0">
                                                                <label class="col-form-label">Payment Date <span class="text-danger">*</span> </label>
                                                                <div class="cal-icon">
                                                                    <input class="form-control datetimepicker"  value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" name="date" type="text" >
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="payment-selection-item">
                                                            <div class="input-block erp-step-input-block  mb-0 two">
                                                                <label class="col-form-label">Payment Account <span class="text-danger"> *</span> </label>
                                                                <select class="select select-step" name="account_id"  id="account_id">
                                                                    <option>Select Payment Account</option>
                                                                    @if(!empty($accounts_sub_categories))
                                                                        @foreach($accounts_sub_categories as $accounts_sub_category)
                                                                            @if(count($accounts_sub_category->accounts) > 0)
                                                                                <optgroup label="{{ $accounts_sub_category->name }}">
                                                                                    @foreach($accounts_sub_category->accounts as $account)
                                                                                        <option value="{{ $account->id }}" {{ ($account->is_default == $account::IS_DEFAULT_YES)?'selected':'' }}>{{ $account->name }}</option>
                                                                                    @endforeach
                                                                                </optgroup>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif

                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="erp-filter-item flex-100">
                                                            <div class="input-block erp-step-input-block mb-0">
                                                                <label class="col-form-label">Note </label>
                                                                <textarea class="form-control" name="note" rows="2"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="payment-selection-item flex-100">
                                                            <div class="input-block erp-step-input-block mb-0">
                                                                <label class="col-form-label">Upload Receipt <span class="text-danger">*</span> </label>
                                                                <input type="file" class="form-control" name="receipt[]" placeholder="Upload Receipt">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                </div>
                                <div class="purchase-order-product-footer-wrapper">
                                    <div class="purchase-order-product-footer-header">
                                        <h2>Invoice Footer</h2>
                                    </div>
                                    <div class="purchase-order-product-footer-body">
                                        <div class="purchase-order-product-footer-body-inner">
                                            <div class="purchase-order-product-footer-body-item">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <textarea class="form-control" name="invoice_footer" rows="2" placeholder="Just wanted to say thank you for your purchase. We are so lucky to have customers like you!"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="purchase-order-product-save-all-wrapper">
                                    <div class="purchase-save-all-btn-box">
                                        <button type="submit">Save Invoice</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Customer Modal -->
        <div id="addCustomerModal" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header erp-modal-header">
                        <h5 class="modal-title">Customer List</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body erp-modal-body">
                        <div class="erp-modal-body-content">
                            <div class="selected-loot-product d-flex align-items-center" v-if="selected_customer !==null">
                                <div class="slp-img-box me-2">
                                    <img :src="selected_customer.show_image_full_url" alt="">
                                </div>
                                <div class="slp-details-box">
                                    <h5>@{{ selected_customer.business_name }}</h5>
                                    <p class="supplier-person-name">@{{ selected_customer.contact_first_name }}</p>
                                </div>
                            </div>
                            <div class="sl-search-view">
                                <div class="sl-search-box">
                                    <div class="search-box position-relative">
                                        <input class="form-control" name="search_customer" v-model="customer_search" v-on:input="getCustomers()" type="text" placeholder="Search Customer Here...">
                                        <button class="btn position-absolute search-btn" type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
                                    </div>
                                </div>
                                <div class="sl-search-list-view custom-card-scroll-2">
                                    <a href="javascript:void(0)" class="sl-search-list-view-item d-flex align-items-center" v-for="(customer, customerIndex) in customers" :key="customer.id" @click="changeCustomer(customerIndex)">
                                        <div class="slp-img-box me-2">
                                            <img :src="customer.show_image_full_url" alt="">
                                        </div>
                                        <div class="slp-details-box">
                                            <h5>@{{ customer.business_name }}</h5>
                                            <p class="supplier-person-name">@{{ customer.contact_first_name }} @{{ customer.contact_last_name }}</p>
                                        </div>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Customer Modal -->

        {{-- item details modal --}}
        <div id="itemDetailsModal" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header erp-modal-header">
                        <h5 class="modal-title">Item Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body erp-modal-body pt-0">
                        <div class="erp-modal-body-content">
                            <table class="table mb-0 erp-table table-responsive">
                                <thead class="erp-thead">
                                    <tr class="erp-tr">
                                        <th class="erp-th">Sl.</th>
                                        <th class="erp-th">Name</th>
                                        <th class="erp-th">Quantity</th>
                                    </tr>
                                </thead>
                                <tbody class="erp-tbody">
                                        <tr class="erp-tbody-tr" v-for="(data, i) in item_details" :key="i">
                                            <td class="erp-tbody-td text-left">@{{ i+1 }}</td>
                                            <td class="erp-tbody-td text-left">@{{ data.name  }} (@{{data.code}})</td>
                                            <td class="erp-tbody-td text-left">@{{data.quantity}}</td>
                                        </tr>
                                </tbody>
                            </table>
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

        $(document).ready(function () {
            initializeDatepicker();
            $("#payment_status_checkbox").on('change', function() {
                if(this.checked) {
                    $("#payment_status_details").slideDown();
                    $("#amount").prop('required', true);
                    $("#account_id").prop('required', true);
                    $("#payment_method").prop('required', true);
                    initPaymentMethodSelect2()
                } else {
                    $("#payment_status_details").slideUp();
                    $("#amount").prop('required', false);
                    $("#account_id").prop('required', false);
                    $("#payment_method").prop('required', false);
                    initPaymentMethodSelect2()
                }
            });
        });

        function initPaymentMethodSelect2() {
            $("#payment_method").select2({
                minimumResultsForSearch: -1,
                width: '100%',
            });
        }

        function initTaxSelect2() {
            $('.select-step').select2({
                minimumResultsForSearch: -1,
                width: '100%',
            });
        }

        function showCustomerModal() {
            $("#addCustomerModal").modal('show');
            setTimeout(function () {
                $("#addCustomerModal input[name=search_customer]")[0].focus();
            },300);
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

        var { createApp } = Vue;

        var vueApp = createApp({
            data() {
                return {
                    allItems:[],
                    items: [],
                    item_details: [],
                    item_search: '',
                    current_item_type: '',
                    cartItems:[],
                    system_tax_items:[],
                    customers:[],
                    customer_search: '',
                    selected_customer:null,
                    open_select_item: false,
                    discount_type: 0,
                    discount_value: 0,
                    discount_amount: 0,
                    paying_amount: 0,
                    unloading_cost: 0
                }
            },
            computed: {
                cartSubTotalWithoutVatAmount() {
                    let cst_amount = 0;
                    if (this.cartItems.length > 0) {
                        for (let key in this.cartItems) {
                            let item = this.cartItems[key];
                            cst_amount += parseFloat(item.spt_amount_wv);
                        }
                    } else {
                        cst_amount = 0;
                    }
                    return cst_amount;
                },
                cartTotalVatAmount() {
                    let vat_amount = 0;
                    if (this.cartItems.length > 0) {
                        for (let key in this.cartItems) {
                            let item = this.cartItems[key];
                            vat_amount += parseFloat(item.vat_amount);
                        }
                    } else {
                        vat_amount = 0;
                    }
                    return vat_amount;
                },
                cartGrandTotalAmount() {
                    let total_amount = 0;
                    if (this.cartItems.length > 0) {
                        for (let key in this.cartItems) {
                            let item = this.cartItems[key];
                            // total_amount += parseFloat(item.vat_amount);
                            total_amount += parseFloat(item.spt_amount);
                        }
                    } else {
                        total_amount = 0;
                    }
                    this.discount_amount = 0;
                    if(this.discount_value != 0) {
                        if(this.discount_type == 0) {
                            //0=percentage
                            this.discount_amount = parseFloat(((total_amount * parseFloat(this.discount_value)) / 100).toFixed(6));
                        } else {
                            //fixed
                            this.discount_amount = parseFloat(this.discount_value).toFixed(6);
                        }
                    }
                    
                    total_amount = total_amount - parseFloat(this.discount_amount);
                    total_amount = total_amount + parseFloat(this.unloading_cost);
                    return parseFloat(total_amount.toFixed(6));
                },
            },
            methods: {
                openSelectItemModal(type) {
                    this.open_select_item = !this.open_select_item;
                    this.item_search = '';
                    this.current_item_type = type;
                    this.getItems(type);
                },

                checkValidation(e) {
                    e.preventDefault();
                    if (($("#selected_customer_id").val() === undefined) || ($("#selected_customer_id").val() == null) || ($("#selected_customer_id").val() == '')) {
                        showInfoAlert('Opps!', 'Please select a Customer!');
                    } else if(this.cartItems.length <= 0) {
                        showInfoAlert('Opps!', 'Please add at-least 1 Product!');
                    } else {
                        invoiceStoreFormSubmit();
                    }
                },
                // getSearchedItems() {
                //     axios
                //         .get('{{ route('sales.invoice.get-all-finished-goods') }}?q='+this.item_search)
                //         .then(response => (this.allItems = response.data));
                //     },

                getAllProducts() {
                    axios
                        .get('{{ route('sales.invoice.get-all-finished-goods') }}')
                        .then(response => {
                            this.allItems = response.data;
                        });
                    },
                getTaxItems() {
                    axios
                        .get('{{ route('sales.invoice.get-all-taxes') }}')
                        .then(response => (this.system_tax_items = response.data));
                },
                getCustomers() {
                    axios
                        .get('{{ route('sales.invoice.get-all-customer') }}?q=' + this.customer_search)
                        .then(response => (this.customers = response.data));
                },

                getItems(type){
                    if (this.allItems && this.allItems[type]) {
                        this.items = this.allItems[type];
                    } else {
                        this.items = [];
                    }
                },

                getSearchedItems() {
                    if (this.item_search.length > 0) {
                        if (this.allItems && this.allItems[this.current_item_type]) {
                            this.items = this.allItems[this.current_item_type].filter(item =>
                                item.name.toLowerCase().includes(this.item_search.toLowerCase())
                            );
                        }
                    } else {
                        this.getItems(this.current_item_type);
                    }
                },

                addItemToCart(item, priceType = 'default') {
                    console.log(item.srp)
                    // let exists = this.cartItems.findIndex(o => o.id === item.id);
                    let exists = this.cartItems.findIndex(o => o.id === item.id && o.item_type === item.item_type);

                    if (exists >= 0) {
                        this.incrementQty(exists);
                    } else {
                        item.qty = 1;
                        if(priceType == 'wholesale') {
                            item.price = formatNumber(parseFloat(item.wholesale_price));
                        } else if(priceType == 'retail') {
                            item.price = formatNumber(parseFloat(item.retail_price));
                        } else {
                            item.price = formatNumber(parseFloat(item.srp));
                        }
                        
                        item.spt_amount = 0;
                        item.spt_amount_wv = 0;
                        let ab = this.cartItems.push(item);
                        this.updateCartItemPrice(ab - 1);

                    }
                    setTimeout(function () {
                        initTaxSelect2();
                    }, 100);
                    this.open_select_item = !this.open_select_item;
                },

                itemDetails(index) {
                    if (this.cartItems[index] && this.cartItems[index].material_items) {
                        let items = this.cartItems[index].material_items;
                        this.item_details = items;
                    }else{
                        this.item_details = [];
                    }
                },

                getItemType(type){
                    return type.replace(/_/g, ' ')
                   .replace(/\b\w/g, char => char.toUpperCase());
                },

                incrementQty(index) {
                    this.cartItems[index].qty++;
                    this.updateCartItemPrice(index);
                },
                updateQty(index) {
                    let qty = this.cartItems[index].qty;
                    if(qty <= 0) {
                        this.cartItems[index].qty = 0;
                    } else {

                        this.cartItems[index].qty = parseInt(qty);
                    }
                    this.updateCartItemPrice(index);
                },
                decrementQty(index) {
                    if(this.cartItems[index].qty <= 1) {
                        this.cartItems[index].qty = 1;
                    } else {
                        this.cartItems[index].qty--;
                    }
                    this.updateCartItemPrice(index);
                },
                removeItem(index) {
                    this.cartItems.splice(index,1);
                },
                updatePrice(index) {
                    this.updateCartItemPrice(index);
                },
                
                updateCartItemPrice(index) {
                    let priceWithoutVat = parseFloat((this.cartItems[index].qty * this.cartItems[index].price).toFixed(6));
                    this.cartItems[index].spt_amount_wv = priceWithoutVat;

                    if(this.cartItems[index].tax == null) {
                        this.cartItems[index].vat_amount = 0;
                    } else {
                        let vatAmount = (this.cartItems[index].tax.tax_rate * priceWithoutVat) / 100;
                        this.cartItems[index].vat_amount = parseFloat(vatAmount.toFixed(6));
                    }
                    this.cartItems[index].spt_amount = parseFloat((priceWithoutVat + this.cartItems[index].vat_amount).toFixed(6));
                },

                changeDiscountType() {

                },
                changeCustomer(index) {
                    this.selected_customer = this.customers[index];
                    $("#addCustomerModal").modal('hide');
                },
                changeTax(cartItemIndex, new_tax_id) {
                    if(new_tax_id == 0) {
                        this.cartItems[cartItemIndex].tax = null;
                        this.updateCartItemPrice(cartItemIndex);
                    } else {
                        let taxIndex = this.system_tax_items.findIndex(o => o.id === parseInt(new_tax_id));
                        this.cartItems[cartItemIndex].tax = this.system_tax_items[taxIndex];
                        this.updateCartItemPrice(cartItemIndex);
                    }
                }
            },
            created() {
                //check user clicked outside of #add_item_row_element_wrapper
                document.addEventListener('click', function(event) {
                    var isClickInside = document.querySelector('.add_item_row_element_wrapper').contains(event.target);
                    if (!isClickInside) {
                        vueApp.open_select_item = false;
                    }
                });
            },
            mounted () {
                this.getAllProducts();
                this.getTaxItems();
                this.getCustomers();
            }

        }).mount('#VueApp');

        function taxChangeOutside(select) {
            let new_tax_id = $(select).val();
            let cartItemIndex = $(select).attr('data-cartItemIndex');
            vueApp.changeTax(cartItemIndex, new_tax_id);
        }

        function invoiceStoreFormSubmit(){

            var self = $("#invoiceStoreForm");
            var formData = new FormData($(self)[0]);
            $(".ie-span").text("").hide();
            var url = $(self).attr('action');

            formPost(url, formData, function (res) {
                if(res.status == 200){
                    showSuccessAlert('Success',res.message)
                    setTimeout(function () {
                        window.location.href = "{{route('sales.invoice.index')}}";
                    }, 1000);
                }else{
                    showErrorAlert('Error',res.message)
                }
            }, 'show_input_error');
        }

    </script>
@endsection


