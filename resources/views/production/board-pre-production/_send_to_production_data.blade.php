<form action="{{ route('production.board-pre-production.send-to-production', $item->id) }}" id="machineUpdateForm" method="post">
    @csrf
    <div class="erp-modal-body-content">
        <div class="input-block mb-2">
            <label class="col-form-label">Batch No <span class="text-danger">*</span></label>
            <input class="form-control" name="pre_production_batch_no" required type="text">
            <span class="model_error ie-span"></span>
        </div>
        <div class="input-block unit-bottom">
            <label class="col-form-label">Unit <span class="text-danger">*</span></label>
            <input class="form-control" name="unit" type="text" required>
        </div>

        <div class="estimated-output-wrapper">
            <label class="col-form-label">Estimated Output Quantity</label>
            <textarea class="form-control" name="remarks" rows="3"></textarea>
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
                            <td class="erp-tbody-td text-left">{{ $product->quantity }}</td>
                            <td class="erp-tbody-td text-left">{{ $product->unit }}</td>
                            <td class="erp-tbody-td text-left">{{ $product->quantity }}</td>
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
