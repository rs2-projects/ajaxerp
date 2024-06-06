@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row justify-content-center" id="VueApp">
        <div class="col-md-12">
            <form class="mb-5" action="{{ route('inventory.product-material-set.update', $material_set->id) }}" id="productMaterialSetStoreForm" method="post" @submit="checkValidation">
                @csrf
                <div class="erp-employee-list-wrapper purchase-order-in-main">
                    <div class="erp-main-filter-wrapper bg-card attd-table">
                        <div class="purchase-order-invoice-wrapper">
                            <div class="purchase-order-invoice-header-box ">
                                <div class="purchase-supplier-select-box d-flex flex-100 justify-content-between align-items-center">
                                    <div class="d-flex flex-100 justify-content-between align-items-center">     
                                        <div class="product-general-info-box d-flex flex-wrap flex-100">
                                            <div class="pgib-item flex-30">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <label class="col-form-label">Name<span class="text-red">*</span></label>
                                                    <input class="form-control" name="name" value="{{$material_set->name}}" type="text" placeholder="" required="">
                                                </div>
                                            </div>
                                            <div class="pgib-item flex-30">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <label class="col-form-label">SRP Markup % <span class="text-red">*</span></label>
                                                    <input class="form-control" v-on:input="updateSrpMarkupOrWholesale()" v-model.number="srp_markup_percent" name="srp_markup_percent" type="number" min="0" required="">
                                                </div>
                                            </div>
                                            <div class="pgib-item flex-30">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <label class="col-form-label">Wholesale Discount %</label>
                                                    <input class="form-control" v-on:input="updateSrpMarkupOrWholesale()" v-model.number="wholesale_discount_percent" name="wholesale_discount_percent" type="number" min="0">
                                                </div>
                                            </div>
                                            <div class="pgib-item flex-20">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <label class="col-form-label">Cost</label>
                                                    <input class="form-control" v-model.number="cost" name="" type="text" readonly>
                                                </div>
                                            </div>
                                            <div class="pgib-item flex-20">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <label class="col-form-label">SRP </label>
                                                    <input class="form-control" v-model.number="srp" name="" readonly>
                                                </div>
                                            </div>
                                            <div class="pgib-item flex-20">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <label class="col-form-label">SRP With 20% Discount</label>
                                                    <input class="form-control" v-model.number="srp_with_discount" name="" type="text" readonly>
                                                </div>
                                            </div>
                                            <div class="pgib-item flex-20">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <label class="col-form-label">Wholesale</label>
                                                    <input class="form-control" v-model.number="wholesale" name="" type="text" readonly>
                                                </div>
                                            </div>
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
                                        <div class="po-order-product-body-inner-main-wrapper" v-for="(cartItem, cartItemIndex) in cartItems" :key="cartItem.id">
                                            <div class="po-order-product-body-inner-wrapper d-flex flex-wrap align-items-center">
                                                <div class="purchase-order-product-body-item product-material-set-item">
                                                    <input type="hidden" name="product_id[]" v-bind:value="cartItem.id">
                                                    <input type="hidden" name="product_material_set_item_id[]" v-bind:value="cartItem.product_material_set_item_id">
                                                    <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100">
                                                        <div class="em-pro-img-box">
                                                            <img :src="cartItem.show_image" alt="">
                                                        </div>
                                                        <div class="em-pro-details-box po-product">
                                                            <h5>@{{ cartItem.name }}</h5>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="purchase-order-product-body-item product-material-set-item">
                                                    <div class="purchase-order-product-body-item-inner">
                                                        <div class="purchase-order-product-body-item-inner-content">
                                                            <div class="input-block mb-0 erp-step-input-block ">
                                                                <input type="number" name="cost[]" min="1" v-model.number="cartItem.cost" v-on:input="updateCost(cartItemIndex)" required class="form-control text-center">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="purchase-order-product-body-item product-material-set-item">
                                                    <div class="purchase-order-product-body-item-inner">
                                                        <div class="purchase-order-product-body-item-inner-content">
                                                            <div class="input-block mb-0 erp-step-input-block ">
                                                                <input type="number" name="quantity[]" min="1" v-model.number="cartItem.qty" v-on:input="updateQty(cartItemIndex)" required class="form-control text-center" placeholder="QTY">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="purchase-order-product-body-item product-material-set-item">
                                                    <div class="purchase-order-product-body-item-inner">
                                                        <div class="purchase-order-product-body-item-inner-content">
                                                            <div class="input-block mb-0 erp-step-input-block ">
                                                                <input type="text" class="form-control text-center" name="" v-model="cartItem.item_srp" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="purchase-order-product-body-item product-material-set-item">
                                                    <div class="purchase-order-product-body-item-inner">
                                                        <div class="purchase-order-product-body-item-inner-content">
                                                            <div class="input-block mb-0 erp-step-input-block ">
                                                                <input type="text" class="form-control text-center" name="" v-model="cartItem.item_srp_with_discount" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="purchase-order-product-body-item product-material-set-item">
                                                    <div class="purchase-order-product-body-item-inner">
                                                        <div class="purchase-order-product-body-item-inner-content">
                                                            <div class="input-block mb-0 erp-step-input-block ">
                                                                <input type="text" class="form-control text-center" name="" v-model="cartItem.item_wholesale" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="purchase-order-product-body-item product-material-set-item">
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
                                    </div>

                                </div>
                                <div class="purchase-order-product-save-all-wrapper">
                                    <div class="purchase-save-all-btn-box">
                                        <button type="submit">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
        });

        $(document).ready(function () {
            let auto_grow_elements = $(".auto-grow-input");
            auto_grow_elements.each( function () {
                let element = this;
                element.style.height = "5px";
                element.style.height = (element.scrollHeight)+"px";
            });
        });
        $(document).on('input', '.auto-grow-input', function () {
            let element = this;
            element.style.height = "5px";
            element.style.height = (element.scrollHeight)+"px";
        });

        function initTaxSelect2() {
            $('.select-step').select2({
                minimumResultsForSearch: -1,
                width: '100%',
            });
        }

        function initializeDatepicker() {
            $('.datetimepicker').datetimepicker({
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
                    open_select_item: false,
                    cost: 0,
                    srp: 0,
                    srp_with_discount: 0,
                    wholesale: 0,
                    srp_markup_percent: 0,
                    wholesale_discount_percent: 0,
                    FIXED_PERCENT: 20

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
                checkValidation(e) {
                    e.preventDefault();
                    if(this.cartItems.length <= 0) {
                        showInfoAlert('Opps!', 'Please add at least 1 Product!');
                    } else {
                        productMaterialSetStoreFormSubmit();
                    }
                },
                getCartItems(){
                    const id = '{{ $material_set->id }}';
                    axios
                        .get(`{{ route('inventory.product-material-set.get-product-material-set-items', '') }}/${id}`)
                        .then(response => {
                            console.log(response.data.material_set)
                            this.cartItems = response.data.cartItems;
                            this.srp_markup_percent = response.data.material_set.srp_markup_percent;
                            this.wholesale_discount_percent = response.data.material_set.wholesale_discount_percent;
                            this.calculateProductMaterialSetCost();
                        })
                },

                getSearchedItems() {
                    axios
                        .get('{{ route('inventory.product-material-set.get-all-product-materials') }}?q='+this.item_search)
                        .then(response => (this.allItems = response.data.product_materials));
                },
                addItemToCart(item) {
                    let exists = this.cartItems.findIndex(o => o.id === item.id);
                    if (exists >= 0) {
                        this.incrementQty(exists);
                    } else {
                        item.product_material_set_item_id = "";
                        item.qty = 1;
                        item.cost = item.cost;
                        item.item_srp = 0;
                        item.item_srp_with_discount = 0;
                        item.item_wholesale = 0;
                        let cart = this.cartItems.push(item);
                        this.calculateCartItemCost(cart - 1);
                    }
                    this.open_select_item = !this.open_select_item;
                },

                updateSrpMarkupOrWholesale(){
                    let items = this.cartItems;
                    items.map((item, index) => {
                        this.calculateCartItemCost(index);
                    })
                },


                incrementQty(index) {
                    this.cartItems[index].qty++;
                    this.calculateCartItemCost(index);
                },

                updateCost(index){
                    let cost = this.cartItems[index].cost;
                    if(cost <= 0) {
                        this.cartItems[index].cost = 0;
                    } else {
                        this.cartItems[index].cost = parseInt(cost);
                    }
                    this.calculateCartItemCost(index); 
                },

                updateQty(index) {

                    console.log(this.cartItems[index])
                    let qty = this.cartItems[index].qty;
                    if(qty <= 0) {
                        this.cartItems[index].qty = 0;
                    } else {
                        this.cartItems[index].qty = parseInt(qty);
                    }
                    this.calculateCartItemCost(index);
                },

                calculateCartItemCost(index){
                    let item = this.cartItems[index];
                    let item_srp_with_discount = (item.cost * (this.srp_markup_percent / 100)) * item.qty;
                    let item_srp = item_srp_with_discount / (1 - (this.FIXED_PERCENT / 100));
                    let item_wholesale = item_srp_with_discount * (1 - (this.wholesale_discount_percent/100));
    
                    this.cartItems[index].item_srp = item_srp.toFixed(2);
                    this.cartItems[index].item_srp_with_discount = item_srp_with_discount.toFixed(2);
                    this.cartItems[index].item_wholesale = item_wholesale.toFixed(2);

                    this.calculateProductMaterialSetCost();
                },
                
                calculateProductMaterialSetCost() {
                    this.srp_with_discount = 0;
                    this.srp = 0;
                    this.wholesale = 0;
                    this.cost = 0;

                    if (this.cartItems.length > 0) {
                        this.cartItems.forEach((item) => {
                            this.cost += parseFloat(item.cost * item.qty);
                            this.srp_with_discount += parseFloat(item.item_srp_with_discount);
                            this.srp += parseFloat(item.item_srp);
                            this.wholesale += parseFloat(item.item_wholesale);
                        });

                        this.cost = this.cost.toFixed(2);
                        this.srp_with_discount = this.srp_with_discount.toFixed(2);
                        this.srp = this.srp.toFixed(2);
                        this.wholesale = this.wholesale.toFixed(2);
                    } else {
                        this.cost = "0.00";
                        this.srp_with_discount = "0.00";
                        this.srp = "0.00";
                        this.wholesale = "0.00";
                    }
                },

                removeItem(index) {
                    this.cartItems.splice(index,1);
                    this.calculateProductMaterialSetCost();
                },
            },
            mounted () {
                this.getSearchedItems();
                this.getCartItems();
            }

        }).mount('#VueApp');

        function productMaterialSetStoreFormSubmit(){

            var self = $("#productMaterialSetStoreForm");
            var formData = new FormData($(self)[0]);
            $(".ie-span").text("").hide();
            var url = $(self).attr('action');

            formPost(url, formData, function (res) {
                if(res.status == 200){
                    showSuccessAlert('Success',res.message)
                    setTimeout(function () {
                        window.location.href = "{{route('inventory.product-material-set.index')}}";
                    }, 1000);
                }else{
                    showErrorAlert('Error',res.message)
                }
            }, 'show_input_error');
        }

    </script>

@endsection
