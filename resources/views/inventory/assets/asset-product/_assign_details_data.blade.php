<form action="{{ route('inventory.asset-product.update', $item->id) }}" id="productUpdateForm" method="post">
    @csrf
    <div class="erp-modal-body-content">
        <table class="table mb-0 erp-table">
            <thead class="erp-thead">
                <tr class="erp-tr">
                    <th class="erp-th">SL</th>
                    <th class="erp-th">Date </th>
                    @if($type == 'assigned')
                        <th class="erp-th text-center">Employee</th>
                    @endif
                    <th class="erp-th text-center">Sl No</th>
                    <th class="erp-th text-center">Model</th>
                    {{-- <th class="erp-th text-center">QTY</th>
                    <th class="erp-th text-center">Unit Price</th> --}}
                    <th class="erp-th text-center">Remarks</th>
                    {{-- <th class="erp-th text-center">Reason</th> --}}
                    <th class="erp-th text-center">Warranty</th>
                    <th class="erp-th text-center">Action</th>
                </tr>
            </thead>
            <tbody class="erp-tbody">
                @php $i=1 @endphp
                @forelse($details as $data)
                    <tr class="erp-tbody-tr">
                        <td class="erp-tbody-td">
                            <h4 class="d-table-title">{{ $i++}}</h4>
                        </td>
                        <td class="erp-tbody-td text-start">{{ getFormattedDate($data->date, 'd M, Y') }}</td>
                        @if($type == 'assigned')    
                            <td class="erp-tbody-td text-start">{{ $data->employee?->first_name}} {{ $data->employee?->last_name}}</td>
                        @endif
                        <td class="erp-tbody-td text-start">{{ $data->sl_no??'N/A' }}</td>
                        <td class="erp-tbody-td text-start">{{ $data->model??'N/A' }}</td>
                        {{-- <td class="erp-tbody-td text-start">{{ $data->qty??0 }}</td>
                        <td class="erp-tbody-td text-start">{{ $data->unit_price??0 }}</td> --}}
                        <td class="erp-tbody-td text-start">{{ getRealSubStr($data->remarks??'N/A', 60) }}</td>
                        {{-- <td class="erp-tbody-td text-start">{{ getRealSubStr($data->reason??'N/A', 60) }}</td> --}}
                        <td class="erp-tbody-td text-start">{{ getFormattedDate($data->warranty, 'd M, Y') }}</td>
                        <td class="text-end erp-tbody-td">
                            <div class="erp-action-t">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        @if($type == "assigned")    
                                            <a class="dropdown-item" href="javascript:void(0)" onclick="returnItem({{$data->id}})"><i class="fa-solid fa-arrow-rotate-left m-r-5"></i> Return</a>
                                            <a class="dropdown-item" href="javascript:void(0)" onclick="assignToMaintenanceItem({{$data->id}}, {{$data->asset_product_id}}, 'from_assign')"><i class="fa-solid fa-gears m-r-5"></i> Maintenance</a>
                                        @elseif($type == "maintenance")
                                            <a class="dropdown-item" href="javascript:void(0)" onclick="repairedItem({{$data->id}})"><i class="fa-solid fa-screwdriver-wrench m-r-5"></i> Repaired</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr class="erp-tbody-tr">
                        <td class="erp-tbody-td text-center text-primary" colspan="6">
                            No data found...!
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</form>
