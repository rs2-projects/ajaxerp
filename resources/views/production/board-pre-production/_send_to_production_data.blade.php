<form action="{{ route('production.board-pre-production.send-to-production', $item->id) }}" id="sendToProductionStoreForm" method="POST">
    @csrf
    <div class="erp-modal-body-content">
        <div class="row p-0 gap-bottom">
            <div class="input-block mb-2">
                <label class="col-form-label">Batch No <span class="text-danger">*</span></label>
                <input class="form-control" name="pre_production_batch_no" required type="text">
                <span class="model_error ie-span"></span>
            </div>
            <div class="input-block">
                <label class="col-form-label">Unit <span class="text-danger">*</span></label>
                <input class="form-control" id="unit_input" name="unit" type="number" required>
            </div>
        </div>

        <div class="row estimated-output-wrapper m-0 gap-bottom">
            <label class="col-form-label estimated-output-title">Estimated Output Quantity</label>
            <div class="pms-item-wrapper d-flexflex-wrap align-items-end pre-d-item-wrapper">
                <div class="row mb-2">
                    <div class="pms-item col position-relative">
                        <div class="input-block erp-step-input-block mb-0 pre-d-item-input-box">
                            <label class="col-form-label custom-color">Unit</label>
                            <h4 class="input-box-title unit-input-text">0</h4>
                        </div>
                        <span class="position-absolute output-icon">X</span>
                    </div>
                    <div class="pms-item col position-relative">
                        <div class="input-block erp-step-input-block mb-0 pre-d-item-input-box">
                            <label class="col-form-label custom-color">Quantity</label>
                            <h4 class="input-box-title quantity-text">{{$item->estimated_quantity}}</h4>
                        </div>
                        <span class="position-absolute output-icon2">=</span>
                    </div>
                    <div class="pms-item col">
                        <div class="input-block erp-step-input-block mb-0 pre-d-item-input-box">
                            <label class="col-form-label custom-color">Output</label>
                            <h4 class="input-box-title output-text">0</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="send_to_pp_table" >
            <table class=" table mb-2 erp-table table-responsive mt-2">
                <thead class="erp-thead">
                    <tr class="erp-tr">
                        <th class="erp-th">Sl.</th>
                        <th class="erp-th">Product</th>
                        <th class="erp-th">Qty</th>
                        <th class="erp-th">Unit</th>
                        <th class="erp-th">Total Qty</th>
                    </tr>
                </thead>
                <tbody class="erp-tbody">
                    @php $i = 1; @endphp
                    @foreach ($item->board_materials as $product )
                        <tr class="erp-tbody-tr">
                            <td class="erp-tbody-td text-left">{{ $i++ }}</td>
                            <td class="erp-tbody-td text-left">{{ $product->product_material?->name }}</td>
                            <td class="erp-tbody-td text-left product-qty">{{ $product->quantity }}</td>
                            <td class="erp-tbody-td text-left product-unit">0</td>
                            <td class="erp-tbody-td text-left product-total-qty">0</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="submit-section mt-2">
            <button class="btn btn-primary submit-btn" type="submit">Send To Production</button>
        </div>
    </div>
</form>
