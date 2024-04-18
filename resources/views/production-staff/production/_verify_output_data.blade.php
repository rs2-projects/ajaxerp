<div id="verifyOutput">
    <div class="erp-modal-body-content">
        <div class="qc-header text-end">
            <a href="#" class="re-btn">Re-Requisition</a>
        </div>
        @foreach ($estimated_outputs as $data)
            <div class="pms-item-main-wrapper">
                <div class="qc-quantity-wraper d-flex justify-content-center align-items-center gap-2">
                    <h4 class="perfect-h4">Perfect: <span>100</span></h4>
                    <h4 class="damage-h4">Damage: <span>100</span></h4>
                </div>
                <table class="table mb-0 erp-table table-responsive">
                    <thead class="erp-thead">
                        <tr class="erp-tr">
                            <th class="erp-th">Sl.</td>
                            <th class="erp-th">Name</td>
                            <th class="erp-th">
                                <a href="#" class="qc-btn-all qc-perfect-all" ><span class="me-1"><i class="fa-solid fa-check"></i></span> Perfect All</a>
                            </td>
                        </tr>
                    </thead>
                    <tbody class="erp-tbody">
                        @for ($i = 1; $i <= $data->quantity; $i++ )
                            <tr class="erp-tbody-tr">
                                <td class="erp-tbody-td text-left">{{ $i }}</td>
                                <td class="erp-tbody-td text-left"><span title="{{ $data->name }}">{{ $data->name }}</span></td>
                                <td class="erp-tbody-td text-left">
                                    <div class="qc-btn-wrap">
                                        <a href="#" class="qc-btn qc-perfect" >Perfect </a>
                                        <a href="#" class="qc-btn qc-damage" >Damage </a>
                                    </div>
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        @endforeach
        {{-- <div class="submit-section mt-2">
            <button class="btn btn-primary submit-btn" type="submit">Verify</button>
        </div> --}}
    </div>
</div>
