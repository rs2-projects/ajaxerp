@extends('production-staff.layouts.layout')
@section('content')
<div id="VueApp">
    <!-- Start::row-1 -->
    <div class="row">
        <div class="erp-employee-list-wrapper">
            <div class="new-production-wrapper bg-card attd-table">
                <div class="product-general-info-box d-flex flex-wrap pd-box">
                    <input type="hidden" id="pre_production_id" value="{{$pre_production->id}}">
                    <div class="pgib-item flex-32 pd-item">
                        <div class="input-block erp-step-input-block mb-0">
                            <label class="col-form-label">Order Details</label>
                            <h4>{{$pre_production->order_details}}</h4>
                        </div>
                    </div>
                    <div class="pgib-item flex-32 pd-item">
                        <div class="input-block erp-step-input-block mb-0">
                            <label class="col-form-label">Product(Finished Product) Selection</label>
                            <h4>{{$pre_production->finishedGoods->name}}</h4>
                        </div>
                    </div>
                    <div class="pgib-item flex-32 pd-item">
                        <div class="input-block erp-step-input-block mb-0">
                            <label class="col-form-label">Estimated Output QTY </label>
                            <h4>{{$pre_production->estimated_production_qty}}</h4>
                        </div>
                    </div>


                    <div class="pgib-item flex-100 pd-item">
                        <div class="input-block erp-step-input-block mb-0">
                            <label class="col-form-label">Description</label>
                            <p>{{$pre_production->description ?? 'N/A'}}</p>
                        </div>
                    </div>
                </div>
                <div class="pd-table-box">
                    <div v-if="deliveries.length > 0">
                        <div class="pd-table-box-item-wrapper" v-for="(deliverData, deliverIndex) in deliveries" :key="deliverIndex">
                            <form action="{{route('production-staff.production.production.receive.store', $pre_production->id)}}"
                                :id="'deliverStoreForm'+deliverData.delivery.id" method="post"
                                @submit="checkValidation($event, deliverIndex)">
                                @csrf
                                <input type="hidden" name="type" :value="deliverData.type">
                                <input type="hidden" name="pre_production_id" :value="deliverData.delivery.pre_production_id">
                                <input type="hidden" name="pre_production_material_delivery_id" :value="deliverData.delivery.id">
                                {{-- <input type="hidden" id="pre_production_material_delivery_id" name="pre_production_id" value="{{$pre_production->id}}">  --}}
                                <div class="pd-table-box-item">
                                    <div class="pd-deliver-date-box ">
                                        <div v-if="deliverData.type == 'other'" class="align-center d-flex justify-content-between">
                                            <span>
                                                Material Delivery: <span class="bold">@{{ formatDate(deliverData.delivery.delivery_date) }}</span>
                                            </span>
                                            <a :href="deliverData.barcodeDetailsLink" target="_blank" class="btn btn-primary btn-sm">Print QR code</a>
                                        </div>
                                        <div v-if="deliverData.type == 'board'" class="align-center d-flex justify-content-between">
                                            <span>
                                                Board Delivery: <span class="bold">@{{ formatDate(deliverData.delivery.delivery_date) }}</span>
                                            </span>
                                            <a :href="deliverData.barcodeDetailsLink" target="_blank" class="btn btn-primary btn-sm">Print QR code</a>
                                        </div>
                                    </div>
                                    <div class="my-attendance-report-wrapper">
                                        <div class="big-table">
                                            <div class="de-table-wrapper">
                                                <div class="table-responsive">
                                                    <table class="table mb-0 erp-table">
                                                        <thead class="erp-thead">
                                                            <tr class="erp-tr">
                                                                <th class="erp-th">Category </th>
                                                                <th class="erp-th text-center">Item Name </th>
                                                                <th class="erp-th text-center">Qty </th>
                                                                <th class="erp-th text-center">Delivery Qty</th>
                                                                <th class="erp-th text-center">Received Qty</th>
                                                                <th class="text-center erp-th">Pending Receive</th>
                                                                <th class="text-center erp-th">QR Code</th>
                                                                <th class="text-center erp-th">Items Received</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="erp-tbody">
                                                            <tr class="erp-tbody-tr" v-for="(detailsData, detailsIndex) in deliverData.delivery_details" :key="detailsIndex">
                                                                
                                                                <td class="erp-tbody-td text-start">
                                                                    <input type="hidden" name="pre_production_material_delivery_details_id[]" :value="detailsData.id">
                                                                    <h4 class="text-start d-table-title" v-if="deliverData.type == 'other'">@{{detailsData.material.category.name}}</h4>
                                                                    <h4 class="text-start d-table-title" v-if="deliverData.type == 'board'">@{{detailsData.board.category.name}}</h4>
                                                                </td>
                                                                <td class="erp-tbody-td text-center">
                                                                    <h4 class="text-center d-table-title" v-if="deliverData.type == 'other'">@{{detailsData.material.product.name}}</h4>
                                                                    <h4 class="text-center d-table-title" v-if="deliverData.type == 'board'">@{{detailsData.board.product.name}}</h4>
                                                                </td>
                                                                <td class="erp-tbody-td text-center">
                                                                    <h4 class="text-center d-table-title">@{{detailsData.total_quantity}}</h4>
                                                                </td>
                                                                <td class="erp-tbody-td text-center">
                                                                    <h4 class="text-center d-table-title">@{{detailsData.quantity}}</h4>
                                                                </td>
                                                                <td class="erp-tbody-td text-center">
                                                                    <h4 class="text-center d-table-title">@{{detailsData.received_qty}}</h4>
                                                                </td>
                                                                <td class="erp-tbody-td text-center">
                                                                    <div class="pd-recived-product-wrapper">
                                                                        <div class="pre-counter">
                                                                            <span>@{{detailsData.quantity - detailsData.received_qty}}</span>
                                                                        </div>
                                                                        <div class="pd-recived-product-scrol-box">
                                                                            <div v-for="(item, itemIndex) in detailsData.pending_items" :key="itemIndex" class="pd-recived-product-item d-flex align-items-center gap-2" v-if="deliverData.type == 'other'">
                                                                                <p>
                                                                                    @{{ item.purchase_details.material_purchase.batch_number }}
                                                                                </p>
                                                                                <p>
                                                                                    <strong>@{{ item.quantity - item.received_qty }}</strong>
                                                                                </p>
                                                                            </div>
                                                                            <div v-for="(item, itemIndex) in detailsData.pending_items" :key="itemIndex" class="pd-recived-product-item d-flex align-items-center gap-2" v-if="deliverData.type == 'board'">
                                                                                <p>
                                                                                    @{{ item.production.pre_production_batch_no }}
                                                                                </p>
                                                                                <p>
                                                                                    <strong>@{{ item.quantity }}</strong>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="erp-tbody-td text-center">
                                                                    {{-- if quantity-received_qtn > 0 show this --}}
                                                                    <div v-if="detailsData.received_qty === detailsData.quantity">
                                                                        <h4 class="text-center d-table-title approved-status">Received</h4>
                                                                    </div>
                                                                    <div class="pd-input-box" v-else>
                                                                        <button type="button" v-on:click="openReceiveModal(deliverIndex, detailsIndex)" class="btn btn-primary btn-sm">Receive</button>
                                                                    </div>
                                                                    {{-- otherwise show fully received text --}}
                                                                </td>

                                                                <td class="erp-tbody-td text-center">
                                                                    <div class="pd-recived-product-wrapper">
                                                                        <div class="pre-counter">@{{ sumOfReceiveItem(deliverIndex, detailsIndex) }}</div>
                                                                        <div class="pd-recived-product-scrol-box">
                                                                            <div
                                                                                class="pd-recived-product-item d-flex align-items-center gap-2" v-if="deliverData.type == 'other'"
                                                                                v-for="(receiveItem, receiveItemIndex) in detailsData.receive_items"
                                                                                :key="receiveItemIndex"
                                                                            >
                                                                                <input type="hidden" :name="'selected_qty['+deliverIndex+'][]'" :value="receiveItem.selected_qty">
                                                                                <input type="hidden" :name="'delivery_items['+deliverIndex+'][]'" :value="receiveItem.id">
                                                                                <p>
                                                                                    @{{ receiveItem.purchase_details.material_purchase.batch_number }}
                                                                                </p>
                                                                                <p>
                                                                                    @{{ receiveItem.selected_qty }}
                                                                                </p>
                                                                                <div class="pd-recived-product-c-item">
                                                                                    <a href="#" @click.prevent="removeBarcode(deliverIndex, detailsIndex)"><i class="fa-solid fa-xmark"></i></a>
                                                                                </div>
                                                                            </div>
                                                                            <div
                                                                                class="pd-recived-product-item d-flex align-items-center gap-2" v-if="deliverData.type == 'board'"
                                                                                v-for="(receiveItem, receiveItemIndex) in detailsData.receive_items"
                                                                                :key="receiveItemIndex"
                                                                            >
                                                                                <input type="hidden" :name="'selected_qty['+deliverIndex+'][]'" :value="receiveItem.selected_qty">
                                                                                <input type="hidden" :name="'delivery_items['+deliverIndex+'][]'" :value="receiveItem.id">
                                                                                <p>
                                                                                    @{{ receiveItem.production.pre_production_batch_no }}
                                                                                </p>
                                                                                <p>
                                                                                    @{{ receiveItem.selected_qty }}
                                                                                </p>
                                                                                <div class="pd-recived-product-c-item">
                                                                                    <a href="#" @click.prevent="removeBarcode(deliverIndex, detailsIndex)"><i class="fa-solid fa-xmark"></i></a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="production-instrucion-output-selection-wrapper my-2 p-2 text-center">
                                    <button v-if="deliverData.delivery.received_status != 1" class=" erp-search-btn text-center" type="submit">Receive</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div v-else> No Data Found </div>
                </div>
            </div>
        </div>
    </div>
    <!--End::row-1 -->


    <!-- Receive Modal -->
    <div class="modal fade" id="receiveModal" tabindex="-1" aria-labelledby="receiveModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="receiveModalLabel">Receive Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" v-if="selected_delviery_index != null">
                    <h4 >Remaining Receive Quantity: @{{ remainingReceiveQty(selected_delviery_index,selected_delviery_details_index) }}</h4>
                    <table class="table table-bordered table-striped table-hover" v-if="deliveries[selected_delviery_index].type == 'other'">
                        <thead>
                            <tr>
                                <th>Purchase ID</th>
                                <th>Batch</th>
                                <th>Available Qty</th>
                                <th>Qty</th>
                            </tr>
                        </thead>
                        <tbody >
                            <tr v-for="(pendingItem, index) in deliveries[selected_delviery_index].delivery_details[selected_delviery_details_index].pending_items">
                                <td>@{{ pendingItem.purchase_details.material_purchase.purchase_id }}</td>
                                <td>@{{ pendingItem.purchase_details.material_purchase.batch_number }}</td>
                                <td class="text-center">@{{ pendingItem.quantity - pendingItem.received_qty }}</td>
                                <td>
                                    <input type="text" class="form-control" placeholder="Enter Qty" v-model="pendingItem.selected_qty" :max="pendingItem.quantity - pendingItem.received_qty">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered table-striped table-hover" v-else>
                        <thead>
                            <tr>
                                <th>Production ID</th>
                                <th>Batch</th>
                                <th>Available Qty</th>
                                <th>Qty</th>
                            </tr>
                        </thead>
                        <tbody >
                            <tr v-for="(pendingItem, index) in deliveries[selected_delviery_index].delivery_details[selected_delviery_details_index].pending_items">
                                <td>@{{ pendingItem.production.pre_production_no }}</td>
                                <td>@{{ pendingItem.production.pre_production_batch_no }}</td>
                                <td class="text-center">@{{ pendingItem.quantity - pendingItem.received_qty }}</td>
                                <td>
                                    <input type="text" class="form-control" placeholder="Enter Qty" v-model="pendingItem.selected_qty" :max="pendingItem.quantity - pendingItem.received_qty">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" v-on:click="selectReceiveItem()">Receive</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Scan Modal -->
    <div class="modal fade" id="scanModal" tabindex="-1" aria-labelledby="scanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scanModalLabel">Scan Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" v-if="selected_delviery_index != null">
                    <div class="form-group">
                        <label class="mb-2" for="scanning_qrcode">Scan QrCode</label>
                        <input type="text" class="form-control" id="scanning_qrcode" v-model="scanning_qrcode" placeholder="Scan QrCode">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" v-on:click="scanItem()">Check</button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('modals')

@endsection

@section('css')
    <style>
        .erp-table-status.pre-delivered-s .action-icon {
            background: #37b34a;
        }
    </style>
@endsection

@section('css_plugins')

@endsection

@section('js_plugins')
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('#scanModal').modal().on('shown.bs.modal', function() {
                $('#scanning_qrcode').focus()
            });
        });
        var { createApp } = Vue;
            var vueApp = createApp({
                data() {
                    return {
                        deliveries: [],
                        selected_delviery_index:null,
                        selected_delviery_details_index:null,
                        scanning_qrcode: '',
                    };
                },
                methods: {
                    handleBarcodeScan(event, deliverId, detailsId, deliverIndex, detailsIndex) {
                        if (event.key === 'Enter') {
                            const barcodeValue = event.target.value;
                            const delivery_type = this.deliveries[deliverIndex].type;
                            if(barcodeValue !=''){
                                const id = document.getElementById('pre_production_id').value;
                                let url = `{{ route('production-staff.production.production.check-barcode', ':id') }}`;
                                url = url.replace(':id', id);

                                let data = {
                                    barcode: barcodeValue,
                                    delivery_id: deliverId,
                                    delivery_details_id: detailsId,
                                    type: delivery_type
                                }

                                axios.get(url, { params: data })
                                .then(response => {
                                    event.target.value = '';
                                    if(response.data.is_valid_code == 1){
                                        if(response.data.code_quantity > 0 && response.data.code_quantity > this.deliveries[deliverIndex].delivery_details[detailsIndex].barcodeCounts){
                                            this.deliveries[deliverIndex].delivery_details[detailsIndex].scannedBarcodes.push(response.data.code);
                                            this.deliveries[deliverIndex].delivery_details[detailsIndex].barcodeCounts++;
                                        }else{
                                            showErrorAlert('Error', 'Received quantity can\'t be larger than delivered quantity');
                                        }
                                    }else{
                                        showErrorAlert('Error', 'Invalid Barcode');
                                    }
                                })
                                .catch(error => {
                                    event.target.value = '';
                                    showErrorAlert('Error', 'Invalid Barcode');
                                    console.log(error);
                                });
                            }
                        }
                    },
                    removeBarcode(deliverIndex,detailsIndex,barcodeIndex) {
                        this.deliveries[deliverIndex].delivery_details[detailsIndex].scannedBarcodes.splice(barcodeIndex, 1);
                        this.deliveries[deliverIndex].delivery_details[detailsIndex].barcodeCounts--;
                    },

                    getMaterials() {
                        let id = document.getElementById('pre_production_id').value;
                        let url = "{{ route('production-staff.production.production.get-delivery-details', ':id') }}";
                        url = url.replace(':id', id);

                        axios.get(url)
                        .then(response => {
                            let baseLink = "{{ route('production-staff.production.production.receive.barcode-details', '#id') }}"
                            this.deliveries = response.data.deliveries.map(delivery_data => {
                                let details_data = [];
                                delivery_data.barcodeDetailsLink = baseLink.replace('#id', delivery_data.delivery.id);
                                if(delivery_data.type == 'other'){
                                    details_data = delivery_data?.delivery.delivery_details;
                                    delivery_data.barcodeDetailsLink = delivery_data.barcodeDetailsLink + '?type=other';
                                }else{
                                    details_data = delivery_data?.delivery.board_delivery_details;
                                    delivery_data.barcodeDetailsLink = delivery_data.barcodeDetailsLink + '?type=board';
                                }
                                
                                return {
                                    ...delivery_data,
                                    delivery_details: details_data.map(detail => {
                                        return {
                                            ...detail,
                                            scannedBarcodes: [],
                                            barcodeCounts: 0,
                                            receive_items: [],
                                        };
                                    })
                                };
                            });
                        })
                        .catch(error => {
                            console.error('Error fetching delivery details:', error);
                        });
                    },

                    checkValidation(e, deliveryIndex) {
                        e.preventDefault();
                        const delivery = this.deliveries[deliveryIndex];
                        if (delivery.delivery_details.every(detail => detail.receive_items.length === 0)) {
                            showErrorAlert('Oops!', 'Please add received items!');
                        } else {
                            receiveStoreForm(delivery.delivery.id, deliveryIndex);
                        }
                    },

                    clearScaneedCodes(deliveryIndex) {
                        this.deliveries[deliveryIndex].delivery_details.forEach(detail => {
                            detail.scannedBarcodes = [];
                            detail.barcodeCounts = 0;
                        });
                    },
                    formatDate(dateString) {
                        const options = { year: 'numeric', month: 'short', day: '2-digit' };
                        return new Date(dateString).toLocaleDateString('en-US', options);
                    },

                    // updateReceivedQty(deliveryIndex) {
                    //     const delivery = this.deliveries[deliveryIndex];
                    //     delivery.delivery_details.forEach(detail => {
                    //         detail.received_qty += detail.barcodeCounts;
                    //     });
                    //     // this.deliveries[deliverIndex].delivery_details[detailsIndex].pending_items.splice(0, 1);
                    // }

                    updateDeliveries(response){
                        this.deliveries = response.map(delivery_data => {
                            let details_data = [];
                            if(delivery_data.type == 'other'){
                                details_data = delivery_data?.delivery.delivery_details;
                            }else{
                                details_data = delivery_data?.delivery.board_delivery_details;
                            }
                            return {
                                ...delivery_data,
                                delivery_details: details_data.map(detail => {
                                    return {
                                        ...detail,
                                        scannedBarcodes: [],
                                        barcodeCounts: 0,
                                    };
                                })
                            };
                        });
                    },

                    openReceiveModal(deliverIndex, detailsIndex){
                        let delivery_details = this.deliveries[deliverIndex].delivery_details[detailsIndex];
                        if(delivery_details.received_status == '1'){
                            showErrorAlert('Error', 'All items are received');
                        }else{
                            this.selected_delviery_index = deliverIndex;
                            this.selected_delviery_details_index = detailsIndex;
                            $('#scanModal').modal('show');
                        }
                    },

                    selectReceiveItem() {
                        let delivery = this.deliveries[this.selected_delviery_index];
                        let delivery_details = this.deliveries[this.selected_delviery_index].delivery_details[this.selected_delviery_details_index];
                        let total_selected_qty = 0;
                        let receive_items = [];
                        if(delivery.type == 'other'){
                            for(let i=0; i<delivery_details.pending_items.length; i++) {
                                let pendingItem = delivery_details.pending_items[i];
                                if(pendingItem.selected_qty == undefined){
                                    pendingItem.selected_qty = 0;
                                }
                                if(pendingItem.selected_qty > (pendingItem.quantity - pendingItem.received_qty)){
                                    showErrorAlert('Error', 'Items Exceeding Delivered Quantity');
                                    return false;
                                }
                                total_selected_qty += parseInt(pendingItem.selected_qty);
                                if(pendingItem.selected_qty > 0){
                                    receive_items.push(pendingItem);
                                }
                            }
                        } else {
                            for(let i=0; i<delivery_details.pending_items.length; i++) {
                                let pendingItem = delivery_details.pending_items[i];
                                if(pendingItem.selected_qty == undefined){
                                    pendingItem.selected_qty = 0;
                                }
                                if(pendingItem.selected_qty > (pendingItem.quantity - pendingItem.received_qty)){
                                    showErrorAlert('Error', 'Items Exceeding Delivered Quantity');
                                    return false;
                                }
                                total_selected_qty += parseInt(pendingItem.selected_qty);
                                if(pendingItem.selected_qty > 0){
                                    receive_items.push(pendingItem);
                                }
                            }

                        }
                        
                        if(total_selected_qty > this.remainingReceiveQty(this.selected_delviery_index, this.selected_delviery_details_index)){
                            showErrorAlert('Error', 'Items Exceeding Delivered Quantity.');
                        }else{
                            // material.material.delivered_qty += total_selected_qty;
                            delivery_details.receive_items = receive_items;
                            this.selected_delviery_index = null;
                            this.selected_delviery_details_index = null;
                            $('#receiveModal').modal('hide');
                        }
                    },

                    remainingReceiveQty(deliveryIndex, detailsIndex){
                        let delivery = this.deliveries[deliveryIndex].delivery_details[detailsIndex];
                        return delivery.quantity - delivery.received_qty;
                    },

                    sumOfReceiveItem(deliveryIndex, detailsIndex){
                        let delivery = this.deliveries[deliveryIndex].delivery_details[detailsIndex];
                        let total = 0;
                        delivery.receive_items.forEach(item => {
                            total += parseInt(item.selected_qty);
                        });
                        return total;
                    },

                    scanItem() {
                        let delivery = this.deliveries[this.selected_delviery_index];
                        let delivery_details = delivery.delivery_details[this.selected_delviery_details_index];
                        let barcodeValue = this.scanning_qrcode;

                        if(delivery.type == 'other') {
                            if (delivery_details.material.product.code == barcodeValue) {
                                $("#scanModal").modal('hide');
                                $("#receiveModal").modal('show');
                                this.scanning_qrcode = '';
                            } else {
                                showErrorAlert('Error', 'Invalid Item');
                                this.scanning_qrcode = '';
                            }
                        } else {
                            if (delivery_details.board.product.code == barcodeValue) {
                                $("#scanModal").modal('hide');
                                $("#receiveModal").modal('show');
                                this.scanning_qrcode = '';
                            } else {
                                showErrorAlert('Error', 'Invalid Item');
                                this.scanning_qrcode = '';
                            }
                        }
                    }

                },
                mounted() {
                    this.getMaterials();
                }
            }).mount('#VueApp');

            function receiveStoreForm(deliveryID, deliveryIndex){
                var self = $("#deliverStoreForm" + deliveryID);
                var formData = new FormData($(self)[0]);
                var url = $(self).attr('action');

                /*formPost(url, formData, function (res) {
                    if(res.status == 200){
                        showSuccessAlert('Success',res.message);
                        // console.log(res.deliveries);
                        // vueApp.updateReceivedQty(deliveryIndex);
                        vueApp.clearScaneedCodes(deliveryIndex);
                        vueApp.updateDeliveries(res.deliveries);
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');*/
                formPost(url, formData, 'redirect', 'show_input_error');
            }
    </script>
@endsection


