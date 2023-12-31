<div class="table-header-wrapper d-flex flex-wrap">
    <div class="table-header-item">
        <h4>SL</h4>
    </div>
    <div class="table-header-item dep-list text-start">
        <h4>Name</h4>
    </div>
    <div class="table-header-item dep-list text-center">
        <h4>Description</h4>
    </div>
    <div class="table-header-item dep-list text-end pe-2">
        <h4>Action</h4>
    </div>
</div>

<div class="table-body-wrapper">
    @foreach($settingsSalarySets as $key=>$item)
        <div class="table-body-item-wrapper d-flex flex-wrap">
            <div class="table-body-item dep-list">
                <h4>{{ $settingsSalarySets->total() + $loop->iteration - 1 }}</h4>
            </div>
            <div class="table-body-item dep-list ">
                <h4 class="text-start erp-t-email">{{ $item->name??'N/A' }}</h4>
            </div>

            <div class="table-body-item dep-list ">
                <h4 class="text-center erp-t-email"> {!! $item->description ?? 'N/A' !!} </h4>
            </div>
            <div class="table-body-item dep-list pe-2 justify-content-end">
                <div class="erp-action-t">
                    <div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="javascript:void(0)" onclick="editItem({{$item->id}})"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                            <a class="dropdown-item" href="{{ route('hr.salary-set.set-employees',$item->id) }}" ><i class="fa-solid fa-pencil m-r-5"></i> Set Employees</a>
                            <a class="dropdown-item" href="javascript:void(0)" onclick="setLeaveTypes({{$item->id}})"><i class="fa-solid fa-pencil m-r-5"></i> Set Leave Types</a>
                            <a class="dropdown-item" href="javascript:void(0)" onclick="SetAttendance({{$item->id}})"><i class="fa-solid fa-pencil m-r-5"></i> Set Attendance</a>
                            <a class="dropdown-item" href="javascript:void(0)" onclick="deleteAjax('{{ route('hr.salary-set.delete',$item->id) }}', 'reloadAjaxGetData')"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
{{ $settingsSalarySets->links('vendor.pagination.common_ajax_pagination') }}
