<!-- Add Department Modal -->
<div id="scanRawMaterialModal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header erp-modal-header">
                <h5 class="modal-title">Scan Raw Materials</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="pd-table-box">
                <div v-if="deliveries.length > 0">
                    <div class="pd-table-box-item-wrapper" v-for="(deliverData, deliverIndex) in deliveries" :key="deliverIndex">
                        <form action="{{route('production-staff.production.production.scan.store', $pre_production->id)}}" 
                            :id="'deliverStoreForm'+deliverData.delivery.id" method="post" 
                            @submit="checkValidation($event, deliverIndex)">
                            @csrf
                            <input type="hidden" name="type" :value="deliverData.type">
                            <input type="hidden" name="pre_production_id" :value="deliverData.delivery.pre_production_id">
                            <input type="hidden" name="pre_production_material_delivery_id" :value="deliverData.delivery.id"> 
                            <div class="pd-table-box-item">
                                <div class="pd-deliver-date-box">
                                    <p v-if="deliverData.type == 'other'">Material Delivery: <span>@{{ formatDate(deliverData.delivery.delivery_date) }}</span></p>
                                        <p v-if="deliverData.type == 'board'">Board Delivery: <span>@{{ formatDate(deliverData.delivery.delivery_date) }}</span></p>
                                </div>
                                <div class="my-attendance-report-wrapper">
                                    <div class="big-table">
                                        <div class="de-table-wrapper">
                                            <div class="table-responsive">
                                                <table class="table mb-0 erp-table">
                                                    <thead class="erp-thead">
                                                        <tr class="erp-tr">
                                                            <th class="erp-th text-center">Item </th>
                                                            <th class="erp-th text-center">Qty </th>
                                                            <th class="erp-th text-center">Received Qty</th>
                                                            <th class="erp-th text-center">Scanned Qty</th>
                                                            <th class="text-center erp-th">Pending Scan</th>
                                                            <th class="text-center erp-th">QR Code</th>
                                                            <th class="text-center erp-th">Items Scanned</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="erp-tbody">
                                                        <tr class="erp-tbody-tr" v-for="(detailsData, detailsIndex) in deliverData.delivery_details" :key="detailsIndex">
                                                            <td class="erp-tbody-td text-start">
                                                                <input type="hidden" name="pre_production_material_delivery_details_id[]" :value="detailsData.id">
                                                                
                                                                <h4 class="text-start d-table-title" v-if="deliverData.type == 'other'">@{{detailsData.material.product.name}}</h4>
                                                                <h4 class="text-start d-table-title" v-if="deliverData.type == 'board'">@{{detailsData.board.product.name}}</h4>
                                                                <h4 class="text-start d-table-title scan-material-category" v-if="deliverData.type == 'other'">@{{detailsData.material.category.name}}</h4>
                                                                <h4 class="text-start d-table-title scan-material-category" v-if="deliverData.type == 'board'">@{{detailsData.board.category.name}}</h4>
                                                            </td>
                                                            <td class="erp-tbody-td text-center">
                                                                <h4 class="text-center d-table-title">@{{detailsData.total_quantity}}</h4>
                                                            </td>
                                                            <td class="erp-tbody-td text-center">
                                                                <h4 class="text-center d-table-title">@{{detailsData.received_qty}}</h4>
                                                            </td>
                                                            <td class="erp-tbody-td text-center">
                                                                <h4 class="text-center d-table-title">@{{detailsData.scanned_qty}}</h4>
                                                            </td>
                                                            <td class="erp-tbody-td text-center">
                                                                <div class="pd-recived-product-wrapper">
                                                                    <div class="pre-counter">
                                                                        <span>@{{detailsData.pending_scans?.length}}</span>
                                                                    </div>
                                                                    <div class="pd-recived-product-scrol-box">
                                                                        <div v-for="(item, itemIndex) in detailsData.pending_scans" :key="itemIndex" class="pd-recived-product-item d-flex align-items-center gap-2" v-if="deliverData.type == 'other'">
                                                                            <p>
                                                                                @{{ item.purchase_details.material_purchase.batch_number }}
                                                                            </p>
                                                                            <p>
                                                                                <strong>@{{ item.received_qty - item.scanned_qty }}</strong>
                                                                            </p>
                                                                        </div>
                                                                        {{-- <div v-for="(item, itemIndex) in detailsData.pending_items" :key="itemIndex" class="pd-recived-product-item d-flex align-items-center gap-2" v-if="deliverData.type == 'board'">
                                                                            <p>
                                                                                @{{ item.production.pre_production_batch_no }}
                                                                            </p>
                                                                            <p>
                                                                                <strong>@{{ item.quantity }}</strong>
                                                                            </p>
                                                                        </div> --}}
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="erp-tbody-td text-center">
                                                                {{-- if quantity-received_qtn > 0 show this --}}
                                                                <div v-if="detailsData.scanned_qty === detailsData.quantity">
                                                                    <h4 class="text-center d-table-title approved-status">Scanned</h4>
                                                                </div>
                                                                <div class="pd-input-box" v-else>
                                                                    {{-- <input
                                                                        class="form-control text-center bar-code-input"
                                                                        type="text"
                                                                        placeholder="Scan QR / Bar Code"
                                                                        @keydown.enter.prevent="handleBarcodeScan($event, deliverData.delivery.id, detailsData.id, deliverIndex, detailsIndex)"
                                                                        /> --}}
                                                                        <button type="button" v-on:click="openScanModal(deliverIndex, detailsIndex)" class="btn btn-primary btn-sm">Scan</button>
                                                                </div>
                                                                {{-- otherwise show fully received text --}}
                                                            </td>

                                                            <td class="erp-tbody-td text-center">
                                                                <div class="pd-recived-product-wrapper">
                                                                    <div class="pre-counter">@{{ detailsData.barcodeCounts }}</div>
                                                                    <div class="pd-recived-product-scrol-box">
                                                                    <div
                                                                        class="pd-recived-product-item d-flex align-items-center gap-2"
                                                                        v-for="(selectedItem, selectedItemIndex) in detailsData.scan_items" :key="selectedItemIndex" 
                                                                        v-if="deliverData.type == 'other'"
                                                                    >
                                                                        <input type="hidden" :name="'selected_qty['+deliverIndex+'][]'" :value="selectedItem.selected_qty">
                                                                        <input type="hidden" :name="'delivery_items['+deliverIndex+'][]'" :value="selectedItem.id">
                                                                        <p>
                                                                            @{{ selectedItem.purchase_details.material_purchase.batch_number }}
                                                                        </p>
                                                                        <p>
                                                                            @{{ selectedItem.selected_qty }}
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
                                <button v-if="deliverData.delivery.scan_status != 1" class=" erp-search-btn text-center" type="submit">Scan</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div v-else> No Data Found </div>
            </div>
        </div>
    </div>
</div>
<!-- /Add Department Modal -->
