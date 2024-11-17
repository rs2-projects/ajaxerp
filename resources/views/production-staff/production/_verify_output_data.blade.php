<div id="verifyOutput">
    <div class="erp-modal-body-content">
        <div class="qc-header text-end">
            <a href="javascript:void(0)" onclick="showReRequisitionModal()" class="re-btn">Re-Requisition</a>
        </div>
        @foreach ($estimated_outputs as $data)
            @if($data->pending_qty > 0)
                <div class="pms-item-main-wrapper">
                    <div class="qc-quantity-wraper d-flex justify-content-center align-items-center gap-2">
                        <h4 class="perfect-h4">Perfect: <span class="perfect-count">{{$data->verified_qty ?? 0}}</span></h4>
                        <h4 class="damage-h4">Damage: <span class="damage-count">{{$data->damage_qty ?? 0}}</span></h4>
                    </div>
                    <table class="table mb-0 erp-table table-responsive">
                        <thead class="erp-thead">
                            <tr class="erp-tr">
                                <th class="erp-th">Sl.</th>
                                <th class="erp-th">Name</th>
                                <th class="erp-th">
                                    <a href="javascript:void(0)" qty={{$data->quantity}} class="qc-btn-all qc-perfect-all" onclick="verifyOutput('{{ route('production-staff.production.production.verify-output.update', [$data->id, 3]) }}' , this, 'perfect-all')"><span class="me-1"><i class="fa-solid fa-check"></i></span> Perfect All</a>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="erp-tbody">
                            @for ($i = 1; $i <= $data->pending_qty; $i++ )
                                <tr class="erp-tbody-tr">
                                    <td class="erp-tbody-td text-left">{{ $i }}</td>
                                    <td class="erp-tbody-td text-left"><span title="{{ $data->name }}">
                                        {{ strlen($data->name) > 20 ? substr($data->name, 0, 25) . '...' : $data->name }}
                                    </span></td>
                                    <td class="erp-tbody-td text-left">
                                        <div class="qc-btn-wrap">
                                            <a href="javascript:void(0)" class="qc-btn qc-perfect" onclick="verifyOutput('{{ route('production-staff.production.production.verify-output.update', [$data->id, 1]) }}' , this, 'perfect')">Perfect </a>
                                            {{-- <a href="javascript:void(0)" class="qc-btn qc-damage"  onclick="verifyOutput('{{ route('production-staff.production.production.verify-output.update', [$data->id, 2]) }}' , this, 'damage')">Damage </a> --}}
                                            <a href="javascript:void(0)" class="qc-btn qc-damage"  onclick="damageOutput(this,{{ $data->id }})">Damage </a>
                                        </div>
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            @endif
        @endforeach
        {{-- <div class="submit-section mt-2">
            <button class="btn btn-primary submit-btn" type="submit">Verify</button>
        </div> --}}
    </div>
</div>
