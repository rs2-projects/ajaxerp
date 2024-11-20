

<div class="">
    <table class="table mb-0 erp-table">
        <thead class="erp-thead">
            <tr class="erp-tr">
                <th class="erp-th">SL</th>
                <th class="erp-th">Machine Name </th>
                <th class="erp-th text-center">Model</th>
                <th class="erp-th text-center">Color</th>
                <th class="erp-th text-center">Production Cost</th>
                <th class="erp-th text-center">Description</th>
                @if(hasPermission('manage-machines'))
                    <th class="erp-th text-center">Action </th>
                @endif
            </tr>
        </thead>
        <tbody class="erp-tbody">
            @forelse($machines as $machine)
                <tr class="erp-tbody-tr">
                    <td class="erp-tbody-td">
                        <h4 class="d-table-title">{{ $machines->firstItem() + $loop->iteration - 1 }}</h4>
                    </td>
                    <td class="erp-tbody-td text-start">
                        <a href="#" class="em-profile-wrap d-flex align-items-center flex-wrap w-100">
                            <div class="em-pro-img-box">
                                <img src="{{ $machine->show_image }}" alt="">
                            </div>
                            <div class="em-pro-details-box">
                                <h5>{{ $machine->name }}</h5>
                            </div>
                        </a>
                    </td>
                    <td class="erp-tbody-td text-center">{{ $machine->model??'N/A' }}</td>
                    <td class="erp-tbody-td text-center">{{ $machine->color??'N/A' }}</td>
                    <td class="erp-tbody-td text-center">{{ formatNumber($machine->production_cost??'0') }}</td>
                    <td class="erp-tbody-td text-center">{{ $machine->description??'N/A' }}</td>
                    @if(hasPermission('manage-machines'))
                        <td class="text-end erp-tbody-td">
                            <div class="erp-action-t">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="editItem({{$machine->id}})"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="deleteAjax('{{ route('production.machine.delete',$machine->id) }}', 'reloadAjaxGetData') "><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
                                        <a class="dropdown-item" href="{{ route('production.machine.print-qrcode', $machine->id) }}" target="_blank"><i class="fa-solid fa-print m-r-5"></i> Print QrCode (PDF)</a>
                                </div>
                                </div>
                            </div>
                        </td>
                    @endif
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

{{ $machines->links('vendor.pagination.common_ajax_pagination') }}

