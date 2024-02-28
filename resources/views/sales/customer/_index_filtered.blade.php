
<div class="">
    <table class="table mb-0 erp-table">
        <thead class="erp-thead">
            <tr class="erp-tr">
                <th class="erp-th">SL</th>
                <th class="erp-th">Customer </th>
                <th class="erp-th text-center">Email(HO)</th>
                <th class="erp-th text-center">Phone(HO)</th>
                <th class="erp-th text-center">Total Bill</th>
                <th class="erp-th text-center">Due</th>
                <th class="erp-th text-center">Lead Time</th>

                    <th class="erp-th text-center">Action </th>

            </tr>
        </thead>
        <tbody class="erp-tbody">
            @foreach($customers as $customer)
                <tr class="erp-tbody-tr">
                    <td class="erp-tbody-td">
                        <h4 class="d-table-title">{{ $customers->firstItem() + $loop->iteration - 1 }}</h4>
                    </td>
                    <td class="erp-tbody-td text-start">
                        <a href="#" class="em-profile-wrap d-flex align-items-center flex-wrap w-100">
                            <div class="em-pro-img-box">
                                <img src="{{ $customer->show_image }}" alt="">
                            </div>
                            <div class="em-pro-details-box">
                                <h5>{{ $customer->business_name }}</h5>
                            </div>
                        </a>
                    </td>
                    <td class="erp-tbody-td text-center">{{ $customer->email??'N/A' }}</td>
                    <td class="erp-tbody-td text-center">{{ $customer->phone??'N/A' }}</td>
                    <td class="erp-tbody-td text-center">0</td>
                    <td class="erp-tbody-td text-center">{{getCurrencySymbol()}} 0</td>
                    <td class="erp-tbody-td text-center">{{$customer->lead_time_status}}</td>

                        <td class="text-end erp-tbody-td">
                            <div class="erp-action-t">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">

                                        <a class="dropdown-item" href="javascript:void(0)" onclick="editItem({{$customer->id}})"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                    <a class="dropdown-item" href="javascript:void(0)" onclick="deleteAjax('{{ route('sales.customer.delete',$customer->id) }}', 'reloadAjaxGetData') "><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>

                                    </div>
                                </div>
                            </div>
                        </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{ $customers->links('vendor.pagination.common_ajax_pagination') }}

