<div class="erp-modal-body-content">
    <div class="row g-3 mb-4 align-items-center">
        <div class="col-lg-8">
            <div class="d-flex align-items-start gap-3">
                <img src="{{ $item->show_image }}" alt="{{ $item->name }}" style="width: 68px; height: 68px; object-fit: cover; border-radius: 8px;">
                <div>
                    <h5 class="mb-1">{{ $item->name }}</h5>
                    <p class="mb-1"><strong>Code:</strong> {{ $item->code ?? 'N/A' }}</p>
                    <p class="mb-0"><strong>Category:</strong> {{ $item->category->name ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="text-center d-flex flex-column justify-content-center align-items-center">
                @if($item->code)
                    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(120)->generate($item->code)) !!}" alt="QR Code" style="max-width: 120px; width: 100%; height: auto;">
                    <p class="mb-0 mt-1 small">{{ $item->code }}</p>
                @else
                    <p class="mb-0 text-muted">No QR code available</p>
                @endif
            </div>
        </div>
    </div>

    <h5 class="mb-3">Movement History</h5>
    <div class="table-responsive">
        <table class="table mb-0 erp-table">
            <thead class="erp-thead">
                <tr class="erp-tr">
                    <th class="erp-th">Date</th>
                    <th class="erp-th">Assigned Person</th>
                    <th class="erp-th">Item Description</th>
                    <th class="erp-th text-center">Qty</th>
                    <th class="erp-th text-center">Returned</th>
                    <th class="erp-th">Reason/Remarks</th>
                </tr>
            </thead>
            <tbody class="erp-tbody">
                @forelse($details as $data)
                    <tr class="erp-tbody-tr">
                        <td class="erp-tbody-td align-top">
                            <div>{{ $data->date ? getFormattedDate($data->date, 'd M, Y') : 'N/A' }}</div>
                            <div class="mt-1">
                                @if($data->assign_status == \App\Models\Products\AssetProductAssign::ASSIGN_STATUS_ASSIGNED)
                                    <span class="badge bg-primary">Assigned</span>
                                @elseif($data->assign_status == \App\Models\Products\AssetProductAssign::ASSIGN_STATUS_MAINTENANCE)
                                    <span class="badge bg-info">Maintenance</span>
                                @endif
                            </div>
                        </td>
                        <td class="erp-tbody-td align-top">
                            @if($data->employee?->full_name)
                                {{ $data->employee?->full_name ?? 'N/A' }}<br>
                            @endif
                            @if($data->employee?->designation?->name)
                                {{ $data->employee?->designation?->name ?? 'N/A' }}<br>
                            @endif
                            @if($data->employee?->department?->name)
                                {{ $data->employee?->department?->name ?? 'N/A' }}
                            @endif
                        </td>
                        <td class="erp-tbody-td align-top">
                            @if($data->sl_no)
                                SL No: {{ $data->sl_no ?? 'N/A' }}<br>
                            @endif
                            @if($data->model)
                                Model: {{ $data->model ?? 'N/A' }}
                            @endif
                        </td>
                        <td class="erp-tbody-td text-center align-top">{{ $data->qty ?? 1 }}</td>
                        <td class="erp-tbody-td text-center align-top">
                            @if(!empty($data->return_date) || !empty($data->return_type) || !empty($data->return_reason) || !empty($data->repair_date) || !empty($data->repaired_by) || !empty($data->repair_note) || !empty($data->repaired_at))
                                <span title="Returned">&#10003;</span>
                            @else
                                -
                            @endif
                        </td>
                        <td class="erp-tbody-td align-top">
                            @if($data->return_reason || $data->repair_note)
                                @if($data->return_reason)
                                    Reason: {{ $data->return_reason ?? 'N/A' }}<br>
                                @elseif($data->repair_note)
                                    Repair Note: {{ $data->repair_note ?? 'N/A' }}<br>
                                @endif
                            @endif
                            @if($data->remarks)
                                Remarks: {{ $data->remarks ?? 'N/A' }}
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr class="erp-tbody-tr">
                        <td class="erp-tbody-td text-center text-primary" colspan="6">No movement history found...!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
