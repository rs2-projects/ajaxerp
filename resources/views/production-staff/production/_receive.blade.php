@extends('production-staff.layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row" id="VueApp">
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
                                            <a :href="deliverData.barcodeDetailsLink" target="_blank" class="btn btn-primary btn-sm">Print Barcode</a>
                                        </div>
                                        <div v-if="deliverData.type == 'board'" class="align-center d-flex justify-content-between">
                                            <span>
                                                Board Delivery: <span class="bold">@{{ formatDate(deliverData.delivery.delivery_date) }}</span>
                                            </span>
                                            <a :href="deliverData.barcodeDetailsLink" target="_blank" class="btn btn-primary">Print Barcode</a>
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
                                                                <input type="hidden" name="pre_production_material_delivery_details_id[]" :value="detailsData.id">
                                                                <td class="erp-tbody-td text-start">
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
                                                                            <span>@{{detailsData.pending_items.length}}</span>
                                                                        </div>
                                                                        <div class="pd-recived-product-scrol-box">
                                                                            <div v-for="(item, itemIndex) in detailsData.pending_items" :key="itemIndex" class="pd-recived-product-item d-flex align-items-center gap-2">
                                                                                <div class="pd-recived-product-c-item">
                                                                                    <p class="mb-0">@{{item.barcode}}</p>
                                                                                </div>
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
                                                                        <input
                                                                            class="form-control text-center bar-code-input"
                                                                            type="text"
                                                                            placeholder="Scan QR / Bar Code"
                                                                            @keydown.enter.prevent="handleBarcodeScan($event, deliverData.delivery.id, detailsData.id, deliverIndex, detailsIndex)"
                                                                            />
                                                                    </div>
                                                                    {{-- otherwise show fully received text --}}
                                                                </td>

                                                                <td class="erp-tbody-td text-center">
                                                                    <div class="pd-recived-product-wrapper">
                                                                        <div class="pre-counter">@{{ detailsData.barcodeCounts }}</div>
                                                                        <div class="pd-recived-product-scrol-box">
                                                                        <div
                                                                            class="pd-recived-product-item d-flex align-items-center gap-2"
                                                                            v-for="(barCode, barCodeIndex) in detailsData.scannedBarcodes"
                                                                            :key="barCodeIndex"
                                                                        >
                                                                            <div class="pd-recived-product-c-item">
                                                                                <input type="hidden" :name="'code['+detailsIndex+'][]'" :value="barCode"/>
                                                                                <p class="mb-0">@{{ barCode }}</p>
                                                                            </div>
                                                                            <div class="pd-recived-product-c-item">
                                                                                <a href="#" @click.prevent="removeBarcode(deliverIndex, detailsIndex, barCodeIndex)"><i class="fa-solid fa-xmark"></i></a>
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
        var { createApp } = Vue;
            var vueApp = createApp({
                data() {
                    return {
                        deliveries: [],
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
                                if(delivery_data.type == 'other'){
                                    details_data = delivery_data?.delivery.delivery_details;
                                }else{
                                    details_data = delivery_data?.delivery.board_delivery_details;
                                }
                                delivery_data.barcodeDetailsLink = baseLink.replace('#id', delivery_data.delivery.id);
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
                        })
                        .catch(error => {
                            console.error('Error fetching delivery details:', error);
                        });
                    },

                    checkValidation(e, deliveryIndex) {
                        e.preventDefault();
                        const delivery = this.deliveries[deliveryIndex];
                        if (delivery.delivery_details.every(detail => detail.barcodeCounts === 0)) {
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


