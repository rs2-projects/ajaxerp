@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row justify-content-center" id="VueApp">
        <div class="col-md-12">
            <form class="mb-5" action="{{ route('sales.quotation.store') }}" id="invoiceStoreForm" method="post" @submit="checkValidation">
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
                                                    <label class="col-form-label">REF NO. </label>
                                                    <div ><input class="form-control " required  name="ref_no" type="text"></div>
                                                </div>
                                            </div>
                                            <div class="supplier-invoice-input-box">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <label class="col-form-label">Date </label>
                                                    <div class="cal-icon"><input class="form-control datetimepicker" value="{{ $quotation_date }}" name="quotation_date" type="text"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="purchase-order-invoice-top-box">
                                <div class="poitb-item">
                                    <div class="poitb-header">
                                        <h4 class="title">Project Name</h4>
                                    </div>
                                    <div class="poitb-body">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="project_name" placeholder="Enter Project Name" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="poitb-item">
                                    <div class="poitb-header">
                                        <h4 class="title">Description - Scope of Work</h4>
                                    </div>
                                    <div class="poitb-body">
                                        <div class="form-group">
                                            <textarea class="form-control" name="project_description" rows="3" placeholder="Enter Description" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="poitb-item">
                                    <div class="poitb-header">
                                        <h4 class="title">Gallery</h4>
                                    </div>
                                    <div class="poitb-body">
                                        <div class="gallery-wrapper row " id="gallery-wrapper">
                                            <div class="gw-item col-12 col-sm-6 col-md-4 p-1 mb-1">
                                                <input type="file" name="gallery[]" class="dropify">
                                            </div>
                                        </div>
                                        <div class="text-center mt-3">
                                            <button type="button" class="btn btn-info btn-sm" onclick="addNewImage()">
                                                <strong>
                                                    <span class="me-1"><i class="fa fa-plus"></i></span>
                                                    Add New Image
                                                </strong>
                                            </button>
                                        </div>
                                    </div>
                                </div> --}}
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
                                                    <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100" v-if="cartItem.item_type != 'custom_item'">
                                                        <input type="hidden" name="item_name[]">
                                                        <div class="em-pro-img-box">
                                                            <img :src="cartItem.show_image" alt="">
                                                        </div>
                                                        <div class="em-pro-details-box po-product">
                                                            <h5>@{{ cartItem.name }}</h5>
                                                        </div>
                                                    </div>
                                                    <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100" v-else>
                                                        <div class="em-pro-details-box po-product">
                                                            <input type="text" name="item_name[]" class="form-control" placeholder="Item Name" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="purchase-order-product-body-item">
                                                    <div class="purchase-order-product-body-item-inner">
                                                        <div class="purchase-order-product-body-item-inner-content">
                                                            <div class="input-block mb-0 erp-step-input-block ">
                                                                <textarea class="d-none" name="description[]" v-model="cartItem.description"></textarea>
                                                                <button type="button" class="btn btn-outline-primary btn-sm py-0 px-2" @click.prevent="openItemDescriptionEditor(cartItemIndex)">
                                                                    <i class="fa-solid fa-pen-to-square"></i> Add Description
                                                                </button>
                                                                <small v-if="cartItem.description && cartItem.description.trim() !== ''" class="text-success d-block mt-1">Description added</small>
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
                                                <div class="purchase-order-product-body-mesurement flex-100" v-if="cartItem.item_type != 'custom_item'">
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
                                                    <a href="#" @click.prevent="addCustomItem()" class="erp-search-btn text-center pp-add-more-btn"><i class="la la-plus-circle"></i> Custom Item</a>
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
                                                        <label class="col-form-label pt-0">Payment Method and Terms</label>
                                                        <div class="payment-method-info">
                                                            <p class="pmi-line">
                                                                <span class="title">Bank </span>
                                                                <span class="value"><span class="me-1">:</span> UnionBank</span>
                                                            </p>
                                                            <p class="pmi-line">
                                                                <span class="title">Bank Name </span>
                                                                <span class="value"><span class="me-1">:</span> AJAX TRADING CORP.</span>
                                                            </p>
                                                            <p class="pmi-line">
                                                                <span class="title">Account No </span>
                                                                <span class="value"><span class="me-1">:</span> 0023 4001 3295</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="po-order-product-note-terms-box">
                                            <div class="po-content-box-wrapper">
                                                <div class="po-content-input-box  ">
                                                    
                                                    <div class="first-child">
                                                        Unloading and installation
                                                    </div> 
                                                    <div class="second-child">PhP</div> 
                                                    <div class="third-child">
                                                        <input type="number" min="0" name="unloading_cost" v-model="unloading_cost" required>
                                                    </div>
                                                </div>
                                                <div class="po-content-input-box has-border">
                                                    <div class="first-child">
                                                        <input class="small-size" type="number" v-model="down_payment_percent" name="down_payment_percent" min="0" max="100" required><p>% Down payment
                                                    </div> 
                                                    <div class="second-child">PhP</div> 
                                                    <div class="third-child">
                                                        @{{ downPaymentAmount }}
                                                    </div>
                                                </div>

                                                <div class="po-content-input-box  ">
                                                    
                                                    <div class="first-child">
                                                        Total 1st Down payment:
                                                    </div> 
                                                    <div class="second-child">PhP</div> 
                                                    <div class="third-child">
                                                        @{{ firstDownPaymentAmount }}
                                                    </div>
                                                </div>
                                                <div class="po-content-input-box  ">
                                                    
                                                    <div class="first-child">
                                                        <span>@{{ remainingPaymentPercent }}</span>% Upon Completion
                                                    </div> 
                                                    <div class="second-child">PhP</div> 
                                                    <div class="third-child">
                                                        @{{ remainingPaymentAmount }}
                                                    </div>
                                                </div>
                                                
                                            </div>
                                          
                                        </div>
                                        
                                        {{-- <div class="po-order-product-payment-status">
                                            <div class="po-order-product-note-terms-inner">
                                                <div class="po-order-product-note-terms-item">
                                                    <div class="input-block erp-step-input-block mb-0">
                                                        <label class="col-form-label pt-0">Terms and Conditions</label>
                                                        <textarea class="form-control" name="notes" rows="2" placeholder="Enter Terms and Conditions of service that you are visible to your customer">The above mentioned prices are subject to change as per price fluctuation of raw materials used and the accessories required.</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                        <div class="po-order-product-payment-status">
                                            <div class="po-order-product-note-terms-inner">
                                                <div class="po-order-product-note-terms-item">
                                                    <div class="input-block erp-step-input-block mb-0" id="quotation-notes-editor-wrapper">
                                                        <label class="col-form-label pt-0">Terms and Conditions</label>
                                                        <textarea class="form-control" id="quotation-notes-editor" name="notes" rows="6" placeholder="Enter Terms and Conditions of service that you are visible to your customer">The above mentioned prices are subject to change as per price fluctuation of raw materials used and the accessories required.</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                
                                <div class="purchase-order-product-save-all-wrapper">
                                    <div class="purchase-save-all-btn-box">
                                        <button type="submit">Save Quotation</button>
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
        {{-- item description modal --}}
        <div id="itemDescriptionModal" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header erp-modal-header">
                        <h5 class="modal-title">Item Description</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body erp-modal-body">
                        <div class="erp-modal-body-content">
                            <textarea id="item-description-editor"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary btn-sm" @click="saveItemDescriptionEditor">Save Description</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!--End::row-1 -->

    <div class="d-none">
        <div id="hidden-image-input">
            <div class="gw-item col-12 col-sm-6 col-md-4 p-1 mb-1">
                <input type="file" name="gallery[]" class="dropify">
                <button onclick="removeImage(this)" type="button" class="remove-gw-item-btn"><i class="fa fa-times"></i></button>
            </div>
        </div>
    </div>
@endsection

@section('modals')

@endsection

@section('css')
    <style>
        #quotation-notes-editor-wrapper .tox-tinymce {
            min-height: 260px;
        }
        #quotation-notes-editor-wrapper .tox .tox-statusbar {
            border-top: 1px solid #e5e5e5;
        }
        #itemDescriptionModal .tox-tinymce {
            min-height: 420px;
        }
    </style>
@endsection

@section('css_plugins')
    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"/>
@endsection

@section('js_plugins')
    <!-- Datetimepicker JS -->
    <script src="{{asset('assets/js/moment.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tinymce@7.9.1/tinymce.min.js" referrerpolicy="origin"></script>
@endsection

@section('js')
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <script>
        let quotationNotesEditor = null;
        let itemDescriptionEditor = null;
        let itemDescriptionEditorOpenIndex = null;

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

            $('.gallery-wrapper .dropify').dropify();
            initQuotationNotesEditor();
            initItemDescriptionEditor();

            $("#itemDescriptionModal").on('hidden.bs.modal', function() {
                itemDescriptionEditorOpenIndex = null;
                if (typeof vueApp !== 'undefined' && vueApp) {
                    vueApp.activeDescriptionItemIndex = null;
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

        function addNewImage() {
            let hiddenImageInput = $("#hidden-image-input").html();
            $("#gallery-wrapper").append(hiddenImageInput);
            $('.gallery-wrapper .dropify').dropify();
        }
        function removeImage(button) {
            $(button).parent().remove();
        }

        function initQuotationNotesEditor() {
            const editorElement = document.querySelector('#quotation-notes-editor');
            if (!editorElement || typeof tinymce === 'undefined') {
                return;
            }

            tinymce.remove('#quotation-notes-editor');
            tinymce.init({
                selector: '#quotation-notes-editor',
                license_key: 'gpl',
                height: 300,
                promotion: false,
                branding: false,
                statusbar: false,
                menubar: 'edit view format table',
                plugins: 'table lists advlist autoresize',
                toolbar: 'undo redo | blocks styles | bold italic underline | alignleft aligncenter alignright | bullist numlist | uploadimageonly table',
                object_resizing: 'img',
                automatic_uploads: true,
                relative_urls: false,
                remove_script_host: false,
                convert_urls: false,
                setup: function (editor) {
                    editor.ui.registry.addButton('uploadimageonly', {
                        icon: 'image',
                        tooltip: 'Upload image',
                        onAction: function () {
                            openImageUploaderForEditor(editor);
                        }
                    });
                },
                style_formats: [
                    {
                        title: 'Image Full Width',
                        selector: 'img',
                        styles: { width: '100%', display: 'block', margin: '0 0 8px 0' }
                    },
                    {
                        title: 'Image Half Width',
                        selector: 'img',
                        styles: { width: '49%', display: 'inline-block', margin: '0 1% 8px 0', verticalAlign: 'top' }
                    },
                    {
                        title: 'Image One Third',
                        selector: 'img',
                        styles: { width: '32%', display: 'inline-block', margin: '0 1% 8px 0', verticalAlign: 'top' }
                    }
                ],
                content_style: 'img { max-width: 100%; height: auto; vertical-align: top; } figure.image { margin: 0; }',
                images_upload_handler: tinyMceImageUploadHandler
            }).then((editors) => {
                quotationNotesEditor = editors && editors.length ? editors[0] : null;
            }).catch((error) => {
                console.error('TinyMCE init failed:', error);
            });
        }

        function initItemDescriptionEditor() {
            if (typeof tinymce === 'undefined') {
                return;
            }

            tinymce.remove('#item-description-editor');
            tinymce.init({
                selector: '#item-description-editor',
                license_key: 'gpl',
                height: 420,
                promotion: false,
                branding: false,
                statusbar: false,
                menubar: 'edit view format table',
                plugins: 'table lists advlist autoresize',
                toolbar: 'undo redo | uploadimageonly table | blocks styles | bold italic underline | alignleft aligncenter alignright | bullist numlist',
                object_resizing: 'img',
                automatic_uploads: true,
                relative_urls: false,
                remove_script_host: false,
                convert_urls: false,
                setup: function (editor) {
                    editor.ui.registry.addButton('uploadimageonly', {
                        icon: 'image',
                        tooltip: 'Upload image',
                        onAction: function () {
                            openImageUploaderForEditor(editor);
                        }
                    });
                },
                style_formats: [
                    {
                        title: 'Image Full Width',
                        selector: 'img',
                        styles: { width: '100%', display: 'block', margin: '0 0 8px 0' }
                    },
                    {
                        title: 'Image Half Width',
                        selector: 'img',
                        styles: { width: '49%', display: 'inline-block', margin: '0 1% 8px 0', verticalAlign: 'top' }
                    },
                    {
                        title: 'Image One Third',
                        selector: 'img',
                        styles: { width: '32%', display: 'inline-block', margin: '0 1% 8px 0', verticalAlign: 'top' }
                    }
                ],
                content_style: 'img { max-width: 100%; height: auto; vertical-align: top; } figure.image { margin: 0; }',
                images_upload_handler: tinyMceImageUploadHandler
            }).then((editors) => {
                itemDescriptionEditor = editors && editors.length ? editors[0] : null;
            }).catch((error) => {
                console.error('Item description editor init failed:', error);
            });
        }

        function getCsrfToken() {
            let csrfToken = '';
            const csrfMeta = document.querySelector('meta[name="csrf-token"]');
            if (csrfMeta) {
                csrfToken = csrfMeta.getAttribute('content') || '';
            }
            return csrfToken;
        }

        function uploadImageFileToServer(file, fileName, progressCallback) {
            return new Promise((resolve, reject) => {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', "{{ route('sales.quotation.notes-image-upload') }}");
                xhr.setRequestHeader('X-CSRF-TOKEN', getCsrfToken());

                xhr.upload.onprogress = (e) => {
                    if (e.lengthComputable && typeof progressCallback === 'function') {
                        progressCallback((e.loaded / e.total) * 100);
                    }
                };

                xhr.onload = () => {
                    if (xhr.status < 200 || xhr.status >= 300) {
                        reject('Image upload failed: HTTP ' + xhr.status);
                        return;
                    }

                    let json = {};
                    try {
                        json = JSON.parse(xhr.responseText);
                    } catch (e) {
                        reject('Invalid upload response');
                        return;
                    }

                    if (!json || (!json.location && !json.url)) {
                        reject('Invalid upload response format');
                        return;
                    }

                    resolve(json.location || json.url);
                };

                xhr.onerror = () => reject('Image upload failed due to a network error.');

                const formData = new FormData();
                formData.append('file', file, fileName || 'image.png');
                xhr.send(formData);
            });
        }

        function openImageUploaderForEditor(editor) {
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = 'image/*';
            input.onchange = async function () {
                if (!input.files || !input.files[0]) {
                    return;
                }

                try {
                    const file = input.files[0];
                    const imageUrl = await uploadImageFileToServer(file, file.name);
                    editor.insertContent('<img src="' + imageUrl + '" alt="">');
                } catch (error) {
                    console.error(error);
                    showErrorAlert('Error', 'Image upload failed. Please try again.');
                }
            };
            input.click();
        }

        function tinyMceImageUploadHandler(blobInfo, progress) {
            return uploadImageFileToServer(blobInfo.blob(), blobInfo.filename(), progress);
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
                    unloading_cost: 0,
                    down_payment_percent: 0,
                    activeDescriptionItemIndex: null,

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
                            this.discount_amount = parseFloat(((total_amount * this.discount_value) / 100).toFixed(6));
                        } else {
                            //fixed
                            this.discount_amount = parseFloat(this.discount_value.toFixed(6));
                        }
                    }
                    total_amount = total_amount - this.discount_amount;
                    return parseFloat(total_amount.toFixed(6));
                },
                downPaymentAmount() {
                    if(this.down_payment_percent > 100) {
                        this.down_payment_percent = 100;
                    } else if(this.down_payment_percent < 0) {
                        this.down_payment_percent = 0;
                    }
                    let total_amount = this.cartGrandTotalAmount;
                    let down_payment = 0;
                    if(this.down_payment_percent != 0) {
                        down_payment = parseFloat(((total_amount * this.down_payment_percent) / 100).toFixed(6));
                    }
                    return down_payment;
                },
                firstDownPaymentAmount() {
                    return this.downPaymentAmount + this.unloading_cost;
                },
                remainingPaymentPercent() {
                    return 100 - this.down_payment_percent;
                },
                remainingPaymentAmount() {
                    return (parseFloat(this.cartGrandTotalAmount) + this.unloading_cost) - this.firstDownPaymentAmount;
                }
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
                        // showInfoAlert('Info!', 'We are working on it!');
                        // return false;
                        quotationStoreFormSubmit();
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

                addCustomItem() {
                    let customItem = {
                        id: 0,
                        name: '',
                        code: '',
                        item_type: 'custom_item',
                        description: '',
                        qty: 1,
                        price: 0,
                        spt_amount: 0,
                        spt_amount_wv: 0,
                        tax: null,
                        show_image: '{{asset('assets/img/placeholder.jpg')}}',
                        unit_type: '',
                        length: 0,
                        width: 0,
                        thickness: 0,
                    };

                    let ab = this.cartItems.push(customItem);
                    this.updateCartItemPrice(ab - 1);
                    setTimeout(function () {
                        initTaxSelect2();
                    }, 100);
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
                },
                openItemDescriptionEditor(index) {
                    this.activeDescriptionItemIndex = index;
                    itemDescriptionEditorOpenIndex = index;
                    $("#itemDescriptionModal").modal('show');

                    setTimeout(() => {
                        let currentDescription = '';
                        if (this.cartItems[index] && this.cartItems[index].description) {
                            currentDescription = this.cartItems[index].description;
                        }
                        if (itemDescriptionEditor) {
                            itemDescriptionEditor.setContent(currentDescription);
                            itemDescriptionEditor.focus();
                        } else {
                            $("#item-description-editor").val(currentDescription);
                        }
                    }, 200);
                },
                saveItemDescriptionEditor() {
                    if (itemDescriptionEditorOpenIndex === null || itemDescriptionEditorOpenIndex < 0) {
                        $("#itemDescriptionModal").modal('hide');
                        return;
                    }

                    let htmlContent = '';
                    if (itemDescriptionEditor) {
                        htmlContent = itemDescriptionEditor.getContent();
                    } else {
                        htmlContent = $("#item-description-editor").val() || '';
                    }

                    this.cartItems[itemDescriptionEditorOpenIndex].description = htmlContent;
                    $("#itemDescriptionModal").modal('hide');
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

        function quotationStoreFormSubmit(){
            if (typeof tinymce !== 'undefined') {
                tinymce.triggerSave();
            }

            var self = $("#invoiceStoreForm");
            var formData = new FormData($(self)[0]);
            $(".ie-span").text("").hide();
            var url = $(self).attr('action');

            formPost(url, formData, function (res) {
                if(res.status == 200){
                    showSuccessAlert('Success',res.message)
                    setTimeout(function () {
                        window.location.href = "{{route('sales.quotation.index')}}";
                    }, 1000);
                }else{
                    showErrorAlert('Error',res.message)
                }
            }, 'show_input_error');
        }

    </script>
@endsection
