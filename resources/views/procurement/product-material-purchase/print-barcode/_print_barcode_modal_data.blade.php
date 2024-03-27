<form action="" id="printBarcodeModalForm" method="post">
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
                            <div class="d-flex">
                                <input type="checkbox" name="product_material_id[]" value="{{ $data->productMaterial->id }}" class="form-check-input" id="exampleCheck1">
                                <h4 class="text-center d-table-title">{{ $data->productMaterial->name }}</h4>
                            </div>
                        </td>
                        <td class="erp-tbody-td text-center">
                            <input class="form-control" name="name" value="" required type="text">
                        </td>
                    </tr>
                @endforeach
            </tbody>
            {{-- <div class="input-block mb-2">
                <label class="col-form-label">Machine Name <span class="text-danger">*</span></label>
                <input class="form-control" name="name" value="" required type="text">
            </div> --}}
        </table>
        <div class="submit-section mt-2">
            <button class="btn btn-primary submit-btn" type="submit">Save</button>
        </div>
    </div>
</form>
