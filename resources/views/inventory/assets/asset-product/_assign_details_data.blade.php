<form action="{{ route('inventory.asset-product.update', $item->id) }}" id="productUpdateForm" method="post">
    @csrf
    <div class="erp-modal-body-content">
        <table class="table mb-0 erp-table">
            <thead class="erp-thead">
                <tr class="erp-tr">
                    <th class="erp-th">SL</th>
                    <th class="erp-th">Date </th>
                    <th class="erp-th text-center">Employee</th>
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
                @forelse($item->asset_product_assigns as $data)
                    <tr class="erp-tbody-tr">
                        <td class="erp-tbody-td">
                            <h4 class="d-table-title">{{ $i++}}</h4>
                        </td>
                        <td class="erp-tbody-td text-start">{{ getFormattedDate($data->date, 'd M, Y') }}</td>
                        <td class="erp-tbody-td text-start">{{ $data->employee?->first_name}} {{ $data->employee?->last_name}}</td>
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
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="returnItem({{$data->id}})"><i class="fa-solid fa-arrow-rotate-left m-r-5"></i> Return</a>
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="deleteAjax('{{ route('inventory.asset-product.delete',$data->id) }}', 'reloadAjaxGetData') "><i class="fa-solid fa-gears m-r-5"></i> Maintenance</a>
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
