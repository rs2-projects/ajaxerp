@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row justify-content-center" id="VueApp">
        <div class="col-md-12">
            <form class="mb-5" action="{{ route('procurement.product-material-purchase.store') }}" id="purchaseStoreForm" method="post" @submit="checkValidation">
                @csrf
                <div class="erp-employee-list-wrapper purchase-order-in-main">
                    <div class="erp-main-filter-wrapper bg-card attd-table">
                        <div class="purchase-order-invoice-wrapper">
                            <div class="purchase-order-invoice-header-box ">
                                <div class="purchase-supplier-select-box d-flex justify-content-between align-items-center">
                                    <div class="purchase-add-supplier-box">
                                        <div class="supplier-icon-box">
                                            <img src="{{asset('assets/img/product/supplier.png')}}" alt="">
                                        </div>
                                        <div class="supplier-add-button-box text-center" onclick="showSuppliersModal()">
                                            <a href="javascript:void(0)" v-if="selected_supplier === null" class="as-btn">Add Supplier</a>
                                            <a href="javascript:void(0)" v-else>Change Supplier</a>
                                        </div>
                                    </div>
                                    <div class="purchase-invoice-info-wrapper d-flex justify-content-between align-items-center">
                                        <div class="purchase-invoice-info-box">
                                            <div class="title-bx">
                                                <h2>Bill To</h2>
                                            </div>
                                            <div class="invoice-info-bx" v-if="selected_supplier !== null">
                                                <input type="hidden" name="supplier_id" v-bind:value="selected_supplier.id" id="selected_supplier_id">
                                                <div class="invoice-info d-flex align-items-center">
                                                    <h4 class="mb-0">Supplier Name</h4>
                                                    <p class="mb-0"> @{{ selected_supplier.business_name  }} </p>
                                                </div>
                                                <div class="invoice-info d-flex align-items-center">
                                                    <h4 class="mb-0">Contact Name</h4>
                                                    <p class="mb-0">@{{ selected_supplier.contact_full_name }} </p>
                                                </div>
                                                <div class="invoice-info d-flex align-items-center">
                                                    <h4 class="mb-0">Email</h4>
                                                    <p class="mb-0">@{{ selected_supplier.email }} </p>
                                                </div>
                                                <div class="invoice-info d-flex align-items-center">
                                                    <h4 class="mb-0">Phone</h4>
                                                    <p class="mb-0">@{{ selected_supplier.phone }} </p>
                                                </div>
                                                <div class="invoice-info d-flex align-items-start address-invoice">
                                                    <h4 class="mb-0">Address</h4>
                                                    <p class="mb-0">@{{ selected_supplier.address }}</p>
                                                </div>
                                            </div>
                                            <div class="invoice-info-bx" v-else>
                                                <div class="invoice-info d-flex align-items-center">
                                                    <h4 class="mb-0">Supplier Name</h4>
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
                                                    <label class="col-form-label">Batch No. </label>
                                                    <div ><input class="form-control " required  name="batch_number" type="text"></div>
                                                </div>
                                            </div>
                                            <div class="supplier-invoice-input-box">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <label class="col-form-label">Purchase Date </label>
                                                    <div class="cal-icon"><input class="form-control datetimepicker" value="{{ $purchaseDate }}" name="purchase_date" type="text"></div>
                                                </div>
                                            </div>
                                            <div class="supplier-invoice-input-box">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <label class="col-form-label">Estimate Delivery Date </label>
                                                    <div class="cal-icon"><input class="form-control datetimepicker"  value="{{ $estimatedDeliveryDate }}" name="estimated_delivery_date" type="text"></div>
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
                                            <h4 class="text-center">Color</h4>
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
                                        <div class="po-order-product-body-inner-main-wrapper" v-for="(cartItem, cartItemIndex) in cartItems" :key="cartItem.id">
                                            <div class="po-order-product-body-inner-wrapper d-flex flex-wrap align-items-center">
                                                <div class="purchase-order-product-body-item">
                                                    <input type="hidden" name="product_id[]" v-bind:value="cartItem.id">
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
                                                                <input type="text" class="form-control text-center" name="color[]" v-model="cartItem.color" placeholder="Color">
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
                                                <div class="purchase-order-product-body-item">
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
                                                            <h4 class="text-end total-amount-product pe-2">
                                                            {{ getCurrencySymbol() }} <span class="amount-value">@{{ cartItem.spt_amount_wv }}</span>
                                                            </h4>
                                                            <div class="po-product-delete-icon-box">
                                                                <a href="javascript:void(0)" @click="removeItem(cartItemIndex)"><i class="fa fa-trash"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="purchase-order-product-body-mesurement flex-100">
                                                    <div class="purchase-order-product-body-mesurement-wrapper d-flex flex-wrap align-items-center">
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
                                                                    <option v-for="(stItem, stItemIndex) in system_tax_items" v-bind:value="stItem.id" :key="stItem.id" :selected="(cartItem.tax !== null) ? (cartItem.tax.id === stItem.id):false">
                                                                        @{{ stItem.name }} @{{ stItem.tax_rate }}%
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

                                        <div class="po-order-product-add-item text-center flex-wrap justify-content-center">
                                            <a href="javascript:void(0);" v-on:click="openSelectItemModal()" class="po-add-product-btn flex-100 justify-content-center"><span class="me-2"><i class="fa-solid fa-plus"></i></span> Add Product</a>
                                            <div class="searchable-input-wrapper flex-100" v-if="open_select_item">
                                                <div class="custom-searcable-input-wrap">
                                                    <input type="text" class="form-control" placeholder="Search Products" v-model="item_search" v-on:input="getSearchedItems()" >
                                                </div>
                                                <div class="search-product-item-wrapper custom-card-scroll" >
                                                    <div class="search-product-item" v-for="singleItem in allItems" :key="singleItem.id" @click="addItemToCart(singleItem)">
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
                                                                        <h4>Unit :</h4>
                                                                        <p>@{{ singleItem.unit_type }}</p>
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
                                                                </div>

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
                                        <div class="po-order-product-payment-status d-none">
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
                                                            <select class="select select-step" >
                                                                <option>Select Payment Method</option>
                                                                <option>Bank Payment</option>
                                                                <option>Cash</option>
                                                                <option>Cheque</option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="payment-selection-item">
                                                        <div class="input-block erp-step-input-block mb-0">
                                                            <label class="col-form-label">Amount <span class="text-danger">*</span> </label>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="payment-selection-item">
                                                        <div class="input-block erp-step-input-block mb-0">
                                                            <label class="col-form-label">Payment Date <span class="text-danger">*</span> </label>
                                                            <div class="cal-icon"><input class="form-control datetimepicker" type="text"></div>
                                                        </div>
                                                    </div>
                                                    <div class="payment-selection-item">
                                                        <div class="input-block erp-step-input-block  mb-0 two">
                                                            <label class="col-form-label">Payment Account <span class="text-danger"> *</span> </label>
                                                            <select class="select select-step" >
                                                                <option>Select Payment Account</option>
                                                                <option>DBBL</option>
                                                                <option>DBBL Agent Banking</option>
                                                                <option>EBL Banking</option>

                                                            </select>
                                                        </div>
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

        <!-- Supplier Modal -->
        <div id="addSupplierModal" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header erp-modal-header">
                        <h5 class="modal-title">Supplier List</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body erp-modal-body">
                        <div class="erp-modal-body-content">
                            <div class="selected-loot-product d-flex align-items-center" v-if="selected_supplier !==null">
                                <div class="slp-img-box me-2">
                                    <img :src="selected_supplier.show_image_full_url" alt="">
                                </div>
                                <div class="slp-details-box">
                                    <h5>@{{ selected_supplier.business_name }}</h5>
                                    <p class="supplier-person-name">@{{ selected_supplier.contact_first_name }}</p>
                                </div>
                            </div>
                            <div class="sl-search-view">
                                <div class="sl-search-box">
                                    <div class="search-box position-relative">
                                        <input class="form-control" name="search_supplier" v-model="supplier_search" v-on:input="getSuppliers()" type="text" placeholder="Search Supplier Here...">
                                        <button class="btn position-absolute search-btn" type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
                                    </div>
                                </div>
                                <div class="sl-search-list-view custom-card-scroll-2">
                                    <a href="javascript:void(0)" class="sl-search-list-view-item d-flex align-items-center" v-for="(supplier, supplierIndex) in suppliers" :key="supplier.id" @click="changeSupplier(supplierIndex)">
                                        <div class="slp-img-box me-2">
                                            <img :src="supplier.show_image_full_url" alt="">
                                        </div>
                                        <div class="slp-details-box">
                                            <h5>@{{ supplier.business_name }}</h5>
                                            <p class="supplier-person-name">@{{ supplier.contact_first_name }} @{{ supplier.contact_last_name }}</p>
                                        </div>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Supplier Modal -->

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
        });

        function initTaxSelect2() {
            $('.select-step').select2({
                minimumResultsForSearch: -1,
                width: '100%',
            });
        }

        function showSuppliersModal() {
            $("#addSupplierModal").modal('show');
            setTimeout(function () {
                $("#addSupplierModal input[name=search_supplier]")[0].focus();
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
                    item_search: '',
                    cartItems:[],
                    system_tax_items:[],
                    suppliers:[],
                    supplier_search: '',
                    selected_supplier:null,
                    open_select_item: false,
                    discount_type: 0,
                    discount_value: 0,
                    discount_amount: 0,
                    paying_amount: 0,

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
                            this.discount_amount = (total_amount * this.discount_value) / 100;
                        } else {
                            //fixed
                            this.discount_amount = this.discount_value;
                        }
                    }
                    total_amount = total_amount - this.discount_amount;
                    return total_amount;
                },
            },
            methods: {
                openSelectItemModal() {
                    this.open_select_item = !this.open_select_item;
                    this.item_search = '';
                    this.getSearchedItems();
                },
                checkValidation(e) {
                    e.preventDefault();
                    if (($("#selected_supplier_id").val() === undefined) || ($("#selected_supplier_id").val() == null) || ($("#selected_supplier_id").val() == '')) {
                        showInfoAlert('Opps!', 'Please select a Supplier!');
                    } else if(this.cartItems.length <= 0) {
                        showInfoAlert('Opps!', 'Please add at-least 1 Product!');
                    } else {
                        purchaseStoreFormSubmit();
                    }
                },
                getSearchedItems() {
                    axios
                        .get('{{ route('procurement.product-material-purchase.get-all-product-materials') }}?q='+this.item_search)
                        .then(response => (this.allItems = response.data.product_materials));
                },
                getTaxItems() {
                    axios
                        .get('{{ route('procurement.product-material-purchase.get-all-taxes') }}')
                        .then(response => (this.system_tax_items = response.data));
                },
                getSuppliers() {
                    axios
                        .get('{{ route('procurement.product-material-purchase.get-all-suppliers') }}?q=' + this.supplier_search)
                        .then(response => (this.suppliers = response.data));
                },
                addItemToCart(item) {

                    let exists = this.cartItems.findIndex(o => o.id === item.id);
                    if (exists >= 0) {
                        // exists.qty++;
                        this.incrementQty(exists);
                    } else {
                        item.qty = 1;
                        item.price = 0;
                        item.spt_amount = 0;
                        item.spt_amount_wv = 0;
                        let ab = this.cartItems.push(item);
                        this.updateCartItemPrice(ab - 1);
                    }
                    setTimeout(function () {
                        initTaxSelect2();
                    }, 300);
                    this.open_select_item = !this.open_select_item;
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
                    let priceWithoutVat = this.cartItems[index].qty * this.cartItems[index].price;
                    this.cartItems[index].spt_amount_wv = priceWithoutVat;
                    if(this.cartItems[index].tax == null) {
                        this.cartItems[index].vat_amount = 0;
                    } else {
                        this.cartItems[index].vat_amount = ((this.cartItems[index].tax.tax_rate * priceWithoutVat) / 100);
                    }
                    this.cartItems[index].spt_amount = priceWithoutVat + this.cartItems[index].vat_amount;
                },

                changeDiscountType() {

                },
                changeSupplier(index) {
                    this.selected_supplier = this.suppliers[index];
                    $("#addSupplierModal").modal('hide');
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
            mounted () {
                this.getSearchedItems();
                this.getTaxItems();
                this.getSuppliers();
            }

        }).mount('#VueApp');

        function taxChangeOutside(select) {
            let new_tax_id = $(select).val();
            let cartItemIndex = $(select).attr('data-cartItemIndex');
            vueApp.changeTax(cartItemIndex, new_tax_id);
        }

        function purchaseStoreFormSubmit(){

            var self = $("#purchaseStoreForm");
            var formData = new FormData($(self)[0]);
            $(".ie-span").text("").hide();
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


