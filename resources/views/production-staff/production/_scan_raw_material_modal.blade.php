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
                        <form v-if="deliverData?.delivery_details?.length > 0" action="{{route('production-staff.production.production.scan.store', $pre_production->id)}}" 
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
                                                            <th class="text-center erp-th">QR Code</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="erp-tbody">
                                                        <tr class="erp-tbody-tr" v-for="(detailsData, detailsIndex) in deliverData.delivery_details" :key="detailsIndex">
                                                            <td class="erp-tbody-td text-start">
                                                                <input type="hidden" v-if="detailsData?.is_scanned === 1" name="pre_production_material_delivery_details_id[]" :value="detailsData.id">
                                                                
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
                                                                <div v-if="detailsData.scanned_qty === detailsData.received_qty">
                                                                    <h4 class="text-center d-table-title approved-status">Scanned</h4>
                                                                </div>
                                                                <div v-else>
                                                                    <div v-if="detailsData?.is_scanned === 1">
                                                                        <h4 class="text-center d-table-title pending-status">Matched</h4>
                                                                    </div>
                                                                    
                                                                    <div v-else>
                                                                        <input
                                                                            class="form-control text-center bar-code-input"
                                                                            type="text"
                                                                            placeholder="Click & Scan QR Code"
                                                                            @keydown.enter.prevent="handleBarcodeScan($event, deliverData.delivery.id, detailsData.id, deliverIndex, detailsIndex)"
                                                                        />
                                                                    </div>
                                                                </div>

                                                                {{-- <div class="pd-input-box" v-else>
                                                                    <input
                                                                        class="form-control text-center bar-code-input"
                                                                        type="text"
                                                                        placeholder="Click & Scan QR Code"
                                                                        @keydown.enter.prevent="handleBarcodeScan($event, deliverData.delivery.id, detailsData.id, deliverIndex, detailsIndex, detailsData.material.product.id)"
                                                                        />
                                                                </div> --}}
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
                <div v-else> No item has been sent yet. </div>
            </div>
        </div>
    </div>
</div>
<!-- /Add Department Modal -->
