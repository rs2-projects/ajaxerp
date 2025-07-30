<div class="modal fade" id="scanModal" tabindex="-1" aria-labelledby="scanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Scan QR Code</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" v-if="selected_item">
                <!-- Normal Item -->
                <div v-if="selected_item.item_type != 5">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>QR Code</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="white-space: normal;width: 50%;">@{{ selected_item.item_name }}</td>
                                <td>
                                    <span class="badge bg-success" v-if="selected_item.is_scanned">Matched</span>
                                    <input v-else class="form-control" v-model="scannedCode"
                                           @keydown.enter.prevent="verifyScanCode(selected_item.id, scannedCode)"
                                           placeholder="Scan / type code & press enter">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Set Item -->
                <div v-else>
                    <h4>Set Name: @{{ selected_item.item_name }}</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>QR Code</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(child, i) in selected_item.set_items" :key="child.id">
                                <td style="white-space: normal;width: 50%;">@{{ child.name }}</td>
                                <td>
                                    <span class="badge bg-success" v-if="child.is_scanned">Matched</span>
                                    <input v-else class="form-control" v-model="child.scannedCode"
                                           @keydown.enter.prevent="verifyScanCode(selected_item.id, child.scannedCode, child.id)"
                                           placeholder="Scan or type code & press enter">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="closeScanModal">Close</button>
            </div>
        </div>
    </div>
</div>
