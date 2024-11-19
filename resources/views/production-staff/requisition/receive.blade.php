@extends('production-staff.layouts.layout')
@section('content')
<div id="VueApp">
    <!-- Start::row-1 -->
    <div class="row">
        <input type="hidden" id="requisition_id" name="requisition_id" value="{{ $requisition->id }}">
        <div class="erp-employee-list-wrapper">
            <div class="new-production-wrapper bg-card attd-table">
                <div class="product-general-info-box d-flex flex-wrap pd-box">
                    <div class="pgib-item flex-32 pd-item">
                        <div class="input-block erp-step-input-block mb-0">
                            <label class="col-form-label">Requisition No</label>
                            <h4>#{{ $requisition->requisition_no }}</h4>
                        </div>
                    </div>
                    <div class="pgib-item flex-32 pd-item">
                        <div class="input-block erp-step-input-block mb-0">
                            <label class="col-form-label">Date</label>
                            <h4>{{ !empty($requisition->created_at) ? getFormattedDate($requisition->created_at, 'd M, Y') : 'N/A' }}</h4>
                        </div>
                    </div>
                    <div class="pgib-item flex-32 pd-items">
                    </div>
                    <div class="pgib-item flex-100 pd-item">
                        <div class="input-block erp-step-input-block mb-0">
                            <label class="col-form-label">Description</label>
                            <p>{{ $requisition->description ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
                <div class="pd-table-box">
                    <div class="pd-table-box-item-wrapper" v-for="(delivery, deliveryIndex) in deliveries" :key="deliveryIndex">
                        <form action="{{ route('production-staff.requisition.receive.store', $requisition->id) }}"
                            :id="'deliverStoreForm'+delivery.id" method="post"
                            @submit="checkValidation($event, deliveryIndex)" class="mb-5">
                            @csrf
                            <div class="pd-table-box-item">
                                <div class="pd-deliver-date-box">
                                    <input type="hidden" name="delivery_id" :value="delivery.id">
                                    <p>Material Delivery: <span class="bold">@{{ formatDate(delivery.delivery_date) }}</span></p>
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
                                                            <th class="erp-th text-center">Delivered Qty </th>
                                                            <th class="erp-th text-center">Received Qty </th>
                                                            <th class="text-center erp-th">Pending Received</th>
                                                            <th class="text-center erp-th">Qr Code</th>
                                                            <th class="text-center erp-th">Item Received</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="erp-tbody">
                                                        <tr class="erp-tbody-tr" v-for="(details, detailsIndex) in delivery.delivery_details" :key="detailsIndex">
                                                            <td class="erp-tbody-td text-start">
                                                                <input type="hidden" :name="'delivery_details_id['+ detailsIndex + ']'" :value="details.id">
                                                                <h4 class="text-start d-table-title">@{{ details.product.category.name }}</h4>
                                                            </td>
                                                            <td class="erp-tbody-td text-center">
                                                                <h4 class="text-center d-table-title">@{{ details.product.name }}</h4>
                                                            </td>
                                                            <td class="erp-tbody-td text-center">
                                                                <h4 class="text-center d-table-title">@{{ details.delivered_qty }}</h4>
                                                            </td>
                                                            <td class="erp-tbody-td text-center">
                                                                <h4 class="text-center d-table-title">@{{ details.received_qty }}</h4>
                                                            </td>
                                                            <td class="erp-tbody-td text-center">
                                                                <div class="pd-recived-product-wrapper">
                                                                    {{-- <div class="pre-counter">
                                                                        <span>4</span>
                                                                    </div> --}}
                                                                    <div class="pd-recived-product-scrol-box">
                                                                        <div class="pd-recived-product-item d-flex align-items-center gap-2" v-for="(item, itemIndex) in details.pending_items" :key="itemIndex">
                                                                            <p>
                                                                                @{{ item.purchase_detail.material_purchase.batch_number }}
                                                                            </p>
                                                                            <p>
                                                                                @{{ item.delivered_qty - item.received_qty }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="erp-tbody-td text-center">
                                                                <div v-if="details.received_qty === details.delivered_qty">
                                                                    <h4 class="text-center d-table-title approved-status">Received</h4>
                                                                </div>
                                                                <div class="pd-input-box" v-else>
                                                                    <button type="button" v-on:click="openReceiveModal(deliveryIndex, detailsIndex)" class="btn btn-primary btn-sm">Receive</button>
                                                                </div>
                                                            </td>

                                                            <td class="erp-tbody-td text-center">
                                                                <div class="pd-recived-product-wrapper">
                                                                    {{-- <div class="pre-counter">10</div> --}}
                                                                    <div class="pd-recived-product-scrol-box">
                                                                        <div class="pd-recived-product-item d-flex align-items-center gap-2" v-for="(receiveItem, receiveItemIndex) in details.receive_items" :key="receiveItemIndex">
                                                                            <p>
                                                                                <input type="hidden" :name="'purchase_detail_id['+ detailsIndex + '][]'" :value="receiveItem.purchase_detail.id">
                                                                                <input type="hidden" :name="'selected_qty['+ detailsIndex + '][]'" :value="receiveItem.selected_qty">
                                                                                <input type="hidden" :name="'delivery_item_id['+ detailsIndex + '][]'" :value="receiveItem.id">
                                                                                @{{ receiveItem.purchase_detail.material_purchase.batch_number }}
                                                                            </p>
                                                                            <p>
                                                                                @{{ receiveItem.selected_qty }}
                                                                            </p>
                                                                            <div class="pd-recived-product-c-item">
                                                                                <a href="javascript:void(0)" @click.prevent="removeSelectedItem(deliveryIndex, detailsIndex, receiveItemIndex)"><i class="fa-solid fa-xmark"></i></a>
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
                                <button v-if="delivery.received_status != 1" class=" erp-search-btn text-center" type="submit">Receive</button>
                            </div>
                        </form>
                    </div>
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
                    <table class="table table-bordered table-striped table-hover">
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
                                <td>@{{ pendingItem.purchase_detail.material_purchase.purchase_id }}</td>
                                <td>@{{ pendingItem.purchase_detail.material_purchase.batch_number }}</td>
                                <td class="text-center">@{{ pendingItem.delivered_qty - pendingItem.received_qty }}</td>
                                <td>
                                    <input type="text" class="form-control" placeholder="Enter Qty" v-model="pendingItem.selected_qty" :max="pendingItem.delivered_qty - pendingItem.received_qty">
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
                    <form action="" @submit="scanQrCodeForm">
                        <div class="form-group">
                            <label class="mb-2" for="scanning_qrcode">Scan QrCode</label>
                            <input type="text" class="form-control" id="scanning_qrcode" v-model="scanning_qrcode" placeholder="Scan QrCode">
                        </div>
                    </form>
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
                removeSelectedItem(deliverIndex,detailsIndex,receiveItemIndex) {
                    this.deliveries[deliverIndex].delivery_details[detailsIndex].receive_items.splice(receiveItemIndex, 1);
                },

                getDeliveryData() {
                    let id = document.getElementById('requisition_id').value;
                    let url = "{{ route('production-staff.requisition.delivery-data', ':id') }}";
                    url = url.replace(':id', id);

                    axios.get(url)
                        .then(response => {
                            this.deliveries = response.data.deliveries.map(delivery_data => {
                                return {
                                    ...delivery_data,
                                    delivery_details: delivery_data.details.map(detail => {
                                        return {
                                            ...detail,
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
                        receiveStoreForm(delivery.id, deliveryIndex);
                    }
                },

                // clearScaneedCodes(deliveryIndex) {
                //     this.deliveries[deliveryIndex].delivery_details.forEach(detail => {
                //         detail.scannedBarcodes = [];
                //         detail.barcodeCounts = 0;
                //     });
                // },
                
                formatDate(dateString) {
                    const options = { year: 'numeric', month: 'short', day: '2-digit' };
                    return new Date(dateString).toLocaleDateString('en-US', options);
                },

                // updateDeliveries(response){
                //     this.deliveries = response.map(delivery_data => {
                //         let details_data = [];
                //         if(delivery_data.type == 'other'){
                //             details_data = delivery_data?.delivery.delivery_details;
                //         }else{
                //             details_data = delivery_data?.delivery.board_delivery_details;
                //         }
                //         return {
                //             ...delivery_data,
                //             delivery_details: details_data.map(detail => {
                //                 return {
                //                     ...detail,
                //                     scannedBarcodes: [],
                //                     barcodeCounts: 0,
                //                 };
                //             })
                //         };
                //     });
                // },

                openReceiveModal(deliverIndex, detailsIndex){
                    let delivery_details = this.deliveries[deliverIndex].delivery_details[detailsIndex];
                    if(delivery_details.received_status == '1'){
                        showErrorAlert('Error', 'All items are received');
                    }else{
                        this.selected_delviery_index = deliverIndex;
                        this.selected_delviery_details_index = detailsIndex;
                        $("#receiveModal").modal('show');
                        // $('#scanModal').modal('show');
                    }
                },

                selectReceiveItem() {
                    let delivery = this.deliveries[this.selected_delviery_index];
                    let delivery_details = this.deliveries[this.selected_delviery_index].delivery_details[this.selected_delviery_details_index];
                    let total_selected_qty = 0;
                    let receive_items = [];
                
                    for(let i=0; i<delivery_details.pending_items.length; i++) {
                        let pendingItem = delivery_details.pending_items[i];
                        if(pendingItem.selected_qty == undefined){
                            pendingItem.selected_qty = 0;
                        }
                        if(pendingItem.selected_qty > (pendingItem.delivered_qty - pendingItem.received_qty)){
                            showErrorAlert('Error', 'Items Exceeding Delivered Quantity');
                            return false;
                        }
                        total_selected_qty += parseInt(pendingItem.selected_qty);
                        if(pendingItem.selected_qty > 0){
                            receive_items.push(pendingItem);
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
                    return delivery.delivered_qty - delivery.received_qty;
                },

                // sumOfReceiveItem(deliveryIndex, detailsIndex){
                //     let delivery = this.deliveries[deliveryIndex].delivery_details[detailsIndex];
                //     let total = 0;
                //     delivery.receive_items.forEach(item => {
                //         total += parseInt(item.selected_qty);
                //     });
                //     return total;
                // },

                scanItem() {
                    let delivery = this.deliveries[this.selected_delviery_index];
                    let delivery_details = delivery.delivery_details[this.selected_delviery_details_index];
                    let barcodeValue = this.scanning_qrcode;

                    if (delivery_details.product.code == barcodeValue) {
                        $("#scanModal").modal('hide');
                        $("#receiveModal").modal('show');
                        this.scanning_qrcode = '';
                    } else {
                        showErrorAlert('Error', 'Invalid Item');
                        this.scanning_qrcode = '';
                    }
                
                },
                scanQrCodeForm(e) {
                    e.preventDefault();
                    this.scanItem();
                }

            },
            mounted() {
                this.getDeliveryData();
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


