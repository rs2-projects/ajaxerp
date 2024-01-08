<div class="">
    <table class="table mb-0 erp-table">
        <thead class="erp-thead">
        <tr class="erp-tr">
            <th class="erp-th">SL</th>
            <th class="erp-th">Title </th>
            <th class="erp-th text-center">Description </th>
            <th class="erp-th text-center">Date Range </th>
            <th class="erp-th text-center">Days </th>
            <th class="text-end erp-th">Action</th>
        </tr>
        </thead>
        <tbody class="erp-tbody">
            @foreach($holidays as $key=> $item)
                <tr class="erp-tbody-tr">
                    <td class="erp-tbody-td">
                        <h4 class="d-table-title">{{ $holidays->firstItem() + $loop->iteration - 1}}</h4>
                    </td>
                    <td class="erp-tbody-td">
                        <h4 class="text-start d-table-title">{{$item->title??'N/A'}}</h4>
                    </td>
                    <td class="erp-tbody-td text-center">
                        <h4 class="text-center d-table-title">{{$item->description??'N/A'}}</h4>
                    </td>
                    <td class="erp-tbody-td text-center">
                        <h4 class="text-center d-table-title"> {{ \App\Helpers\DateTimeHelpers::getDateFormat($item->start_date, 'd M,Y') }} to {{ \App\Helpers\DateTimeHelpers::getDateFormat($item->end_date, 'd M,Y') }}</h4>

                    </td>
                    <td class="erp-tbody-td text-center">
                        <h4 class="text-center d-table-title"> {{ \Carbon\Carbon::make($item->start_date)->diffInDays(\Carbon\Carbon::make($item->end_date)) + 1 }} Days</h4>
                    </td>
                    <td class="text-end erp-tbody-td">
                        <div class="erp-action-t">
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                <div class="dropdown-menu dropdown-menu-right">

                                    <a class="dropdown-item" href="javascript:void(0)" onclick="editItem({{$item->id}})"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                    <a class="dropdown-item" href="javascript:void(0)" onclick="deleteAjax('{{ route('settings.holidays.delete',$item->id) }}', function (res) { getData(); showSuccessAlert(res.message); })"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>

                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{ $holidays->links('vendor.pagination.common_ajax_pagination') }}
