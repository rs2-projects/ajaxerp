@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row justify-content-center" id="VueApp">
        <div class="col-md-12">
            <div class="erp-employee-list-wrapper purchase-order-in-main">
                <div class="erp-main-filter-wrapper bg-card attd-table">
                    <div class="purchase-order-invoice-wrapper">
                        <div class="purchase-order-invoice-header-box ">
                            <div class="purchase-supplier-select-box d-flex justify-content-between align-items-center">
                                <div class="purchase-add-supplier-box">
                                    <div class="supplier-icon-box">
                                        <img src="assets/img/product/supplier.png" alt="">
                                    </div>
                                    <div class="supplier-add-button-box">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#check_status">Change Supplier</a>
                                    </div>
                                </div>
                                <div class="purchase-invoice-info-wrapper d-flex justify-content-between align-items-center">
                                    <div class="purchase-invoice-info-box">
                                        <div class="title-bx">
                                            <h2>Bill To</h2>
                                        </div>
                                        <div class="invoice-info-bx">
                                            <div class="invoice-info d-flex align-items-center">
                                                <h4 class="mb-0">Supplier Name</h4>
                                                <p class="mb-0">meghna group of industries </p>
                                            </div>
                                            <div class="invoice-info d-flex align-items-center">
                                                <h4 class="mb-0">Contact Name</h4>
                                                <p class="mb-0">Md Mainul Islam Gazi </p>
                                            </div>
                                            <div class="invoice-info d-flex align-items-center">
                                                <h4 class="mb-0">Email</h4>
                                                <p class="mb-0">mainual12@gmail.com </p>
                                            </div>
                                            <div class="invoice-info d-flex align-items-center">
                                                <h4 class="mb-0">Phone</h4>
                                                <p class="mb-0">N/A </p>
                                            </div>
                                            <div class="invoice-info d-flex align-items-start address-invoice">
                                                <h4 class="mb-0">Address</h4>
                                                <p class="mb-0">House-1, Road-2, Metro Housing, Dhaka - 1207 , Bangladesh </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="purchase-supplier-invoice-box">
                                        <div class="supplier-invoice-input-box">
                                            <div class="input-block erp-step-input-block mb-0">
                                                <label class="col-form-label">Batch No. </label>
                                                <div ><input class="form-control " type="text"></div>
                                            </div>
                                        </div>
                                        <div class="supplier-invoice-input-box">
                                            <div class="input-block erp-step-input-block mb-0">
                                                <label class="col-form-label">Purchase Date </label>
                                                <div class="cal-icon"><input class="form-control datetimepicker" type="text"></div>
                                            </div>
                                        </div>
                                        <div class="supplier-invoice-input-box">
                                            <div class="input-block erp-step-input-block mb-0">
                                                <label class="col-form-label">Estimate Delivery Date </label>
                                                <div class="cal-icon"><input class="form-control datetimepicker" type="text"></div>
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
                                    <div class="po-order-product-body-inner-main-wrapper">
                                        <div class="po-order-product-body-inner-wrapper d-flex flex-wrap align-items-center">
                                            <div class="purchase-order-product-body-item">
                                                <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100">
                                                    <div class="em-pro-img-box">
                                                        <img src="assets/img/product/product.png" alt="">
                                                    </div>
                                                    <div class="em-pro-details-box po-product">
                                                        <h5>Garments Raw Matarial</h5>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="purchase-order-product-body-item">
                                                <div class="purchase-order-product-body-item-inner">
                                                    <div class="purchase-order-product-body-item-inner-content">
                                                        <div class="input-block mb-0 erp-step-input-block ">
                                                            <textarea class="form-control auto-grow-input" placeholder="Description"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="purchase-order-product-body-item">
                                                <div class="purchase-order-product-body-item-inner">
                                                    <div class="purchase-order-product-body-item-inner-content">
                                                        <div class="input-block mb-0 erp-step-input-block ">
                                                            <input type="text" class="form-control text-center" placeholder="Color">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="purchase-order-product-body-item">
                                                <div class="purchase-order-product-body-item-inner">
                                                    <div class="purchase-order-product-body-item-inner-content">
                                                        <div class="input-block mb-0 erp-step-input-block ">
                                                            <input type="text" class="form-control text-center" placeholder="QTY">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="purchase-order-product-body-item">
                                                <div class="purchase-order-product-body-item-inner">
                                                    <div class="purchase-order-product-body-item-inner-content">
                                                        <div class="input-block mb-0 erp-step-input-block ">
                                                            <input type="text" class="form-control text-center" placeholder="Price">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="purchase-order-product-body-item">
                                                <div class="purchase-order-product-body-item-inner">
                                                    <div class="purchase-order-product-body-item-inner-content position-relative">
                                                        <h4 class="text-end total-amount-product pe-2">$ 10554544540</h4>
                                                        <div class="po-product-delete-icon-box">
                                                            <a href="#"><i class="fa fa-trash"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="purchase-order-product-body-mesurement flex-100">
                                                <div class="purchase-order-product-body-mesurement-wrapper d-flex flex-wrap align-items-center">
                                                    <div class="po-order-product-body-mesurement-item">
                                                        <h4>Product Code :</h4>
                                                        <p>#10013</p>
                                                    </div>
                                                    <div class="po-order-product-body-mesurement-item">
                                                        <h4>Unit :</h4>
                                                        <p>Pcs</p>
                                                    </div>
                                                    <div class="po-order-product-body-mesurement-item">
                                                        <h4>Length :</h4>
                                                        <p>573 ft</p>
                                                    </div>
                                                    <div class="po-order-product-body-mesurement-item">
                                                        <h4>Width :</h4>
                                                        <p>573 m</p>
                                                    </div>
                                                    <div class="po-order-product-body-mesurement-item">
                                                        <h4>Thickness :</h4>
                                                        <p>3 cm</p>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="purchase-order-product-body-vat-tax flex-100">
                                                <div class="purchase-order-product-body-item-inner po-vat-tax-item-wrapper d-flex align-items-center  justify-content-end">
                                                    <div class="po-vat-tax-item">
                                                        <div class="input-block erp-step-input-block  mb-0 two d-flex align-items-center gap-3">
                                                            <label class="col-form-label">Vat </label>
                                                            <select class="select select-step" >
                                                                <option>Select Tax</option>
                                                                <option>Govt Vat 10.00%</option>
                                                                <option>Govt Vat 20.84%</option>
                                                                <option>Govt Vat 30.33%</option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="po-vat-tax-item">
                                                        <div class="purchase-order-product-body-item-inner-content position-relative">
                                                            <h4 class="text-end total-amount-product pe-2">$ 5933</h4>
                                                            <div class="po-product-delete-icon-box two">
                                                                <a href="#"><i class="fa fa-times"></i></a>
                                                            </div>
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
                                                <input type="text" class="form-control" placeholder="Search Products">
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
                                                        <h4 class="text-end sub-total-amount pe-2">$ 45332</h4>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="purchase-order-product-body-item-inner po-vat-tax-item-wrapper d-flex align-items-center  justify-content-end">
                                                <div class="po-vat-tax-item grand-total-item">
                                                    <h3>Total Vat</h3>
                                                </div>
                                                <div class="po-vat-tax-item grand-total-item">
                                                    <div class="purchase-order-product-body-item-inner-content position-relative">
                                                        <h4 class="text-end sub-total-amount pe-2">$ 0</h4>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="purchase-order-product-body-item-inner po-vat-tax-item-wrapper d-flex align-items-center  justify-content-end">
                                                <div class="po-vat-tax-item grand-total-item d-flex align-items-center gap-2 justify-content-end">
                                                    <h3 class="pe-0">Discount</h3>
                                                    <div class="invoice-switcher-box d-flex align-items-center gap-2">
                                                        <div class="invoice-switcher-item">
                                                            <div class="radio-inputs">
                                                                <label>
                                                                    <input class="radio-input instagram" type="radio" name="engine" />
                                                                    <span class="radio-tile instagram">
																						<span class="radio-icon"> $</span>
																					  </span>
                                                                </label>

                                                                <label>
                                                                    <input class="radio-input twitter" type="radio" name="engine" />
                                                                    <span class="radio-tile twitter">
																						<span class="radio-icon">%</span>
																					  </span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="invoice-switcher-item">
                                                            <input type="number" class="form-control custom-switcher-value text-center" placeholder="0">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="po-vat-tax-item grand-total-item">
                                                    <div class="purchase-order-product-body-item-inner-content position-relative">
                                                        <h4 class="text-end sub-total-amount pe-2">$ 0</h4>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="purchase-order-product-body-item-inner po-vat-tax-item-wrapper d-flex align-items-center  justify-content-end">
                                                <div class="po-vat-tax-item grand-total-item">
                                                    <h2>Grand Total - </h2>
                                                </div>
                                                <div class="po-vat-tax-item grand-total-item">
                                                    <div class="purchase-order-product-body-item-inner-content position-relative">
                                                        <h4 class="text-end total-amount-product pe-2">$ 59,444433</h4>
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
                                                    <textarea class="form-control" rows="2" placeholder="Enter notes or terms of service that you are visible to your customer"></textarea>
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
                                                <textarea class="form-control" rows="2" placeholder="Just wanted to say thank you for your purchase. We are so lucky to have customers like you!"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="purchase-order-product-save-all-wrapper">
                                <div class="purchase-save-all-btn-box">
                                    <a href="#">Save Invoice</a>
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
                return {
                    allItems:[],
                    item_search: '',
                    cartItems:[],
                    open_select_item: false,
                }
            },
            computed: {

            },
            methods: {
                openSelectItemModal() {
                    this.open_select_item = !this.open_select_item;
                    this.item_search = '';
                    this.getSearchedItems();
                },
                getSearchedItems() {
                    axios
                        .get('{{ route('procurement.product-material-purchase.get-all-product-materials') }}?q='+this.item_search)
                        .then(response => (this.allItems = response.data.product_materials));
                },

                addItemToCart(item) {
                    this.open_select_item = !this.open_select_item;
                },
            },
            mounted () {
                this.getSearchedItems();
            }

        }).mount('#VueApp');
    </script>
@endsection


