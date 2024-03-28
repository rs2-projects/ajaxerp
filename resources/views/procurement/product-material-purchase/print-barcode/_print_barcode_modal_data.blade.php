<form action="{{ route('procurement.product-material-purchase.print-barcode', $material->id) }}" target="_blank" id="printBarcodeModalForm" method="post" >
    @csrf
    <div class="erp-modal-body-content">
        <input type="hidden" name="type" value="{{$type}}">
        <table class="table mb-0 erp-table">
            <tbody class="erp-tbody">
                @foreach ($material->purchaseDetails as $key=>$data)
                    <tr>
                        <td class="erp-tbody-td">
                            <h4 class="d-table-title">{{ $key + 1 }}</h4>
                        </td>
                        <td class="erp-tbody-td text-center">
                            <div class="d-flex justify-content-center align-items-center">
                                <input class="purchase_details_checkbox" type="checkbox" name="purchase_details_id[{{$key}}]"  value="{{ $data->id }}" checked>
                                <h4 class="text-center d-table-title pl-3" style="padding-left: 5px;padding-top: 4px;">{{ $data->productMaterial->name }}</h4>
                            </div>
                        </td>
                        <td class="erp-tbody-td text-center">
                            <input class="form-control" name="qty[{{$key}}]" value="{{$data->qty}}" required type="number">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="submit-section mt-2">
            <button class="btn btn-primary submit-btn" type="submit">Generate Barcode</button>
        </div>
    </div>
</form>
