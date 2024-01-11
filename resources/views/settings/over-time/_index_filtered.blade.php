<div class="">
    <table class="table mb-0 erp-table">
        <thead class="erp-thead">
        <tr class="erp-tr">
            <th class="erp-th">SL</th>
            <th class="erp-th">Title </th>
            <th class="erp-th text-center">Description </th>
            {{--<th class="erp-th text-center">Interval Time <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Point Four Epos Solutions"><i class="fa-duotone fa-exclamation"></i></span></th>--}}
            <th class="erp-th text-center">Salary Type </th>
            <th class="erp-th text-center">Hourly Rate </th>
            <th class="erp-th text-center">Special Hourly Rate </th>
            <th class="text-end erp-th">Action</th>
        </tr>
        </thead>
        <tbody class="erp-tbody">
        @foreach($over_time_types as $key=> $item)
            <tr class="erp-tbody-tr">
                <td class="erp-tbody-td">
                    <h4 class="d-table-title">{{$over_time_types->firstItem() + $loop->iteration -1}}</h4>
                </td>
                <td class="erp-tbody-td">
                    <h4 class="text-start d-table-title">{{$item->title??'N/A'}} </h4>
                </td>
                <td class="erp-tbody-td text-center">
                    <h4 class="text-center d-table-title">{!! $item->description??'N/A' !!}</h4>
                </td>
                {{--<td class="erp-tbody-td text-center">
                    <h4 class="text-center d-table-title">30 min</h4>

                </td>--}}
                <td class="erp-tbody-td text-center">
                    <h4 class="text-center d-table-title">{{$item->salary_type_text}}</h4>
                </td>
                <td class="erp-tbody-td text-center">
                    <h4 class="text-center d-table-title">{{$item->rate}}% of {{$item->salary_type_text}}</h4>
                </td>
                <td class="erp-tbody-td text-center">
                    <h4 class="text-center d-table-title">{{$item->special_rate}}% of {{$item->salary_type_text}}</h4>
                </td>
                <td class="text-end erp-tbody-td">
                    <div class="erp-action-t">
                        <div class="dropdown dropdown-action">
                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                            <div class="dropdown-menu dropdown-menu-right">

                                <a class="dropdown-item" href="javascript:void(0)" onclick="editItem({{$item->id}})"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                <a class="dropdown-item" onclick="deleteAjax('{{ route('settings.over-time-type.delete',$item->id) }}', function (res) { getData(); showSuccessAlert(res.message); })"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>

                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
{{ $over_time_types->links('vendor.pagination.common_ajax_pagination') }}
