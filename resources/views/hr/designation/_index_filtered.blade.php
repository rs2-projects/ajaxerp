<div class="table-header-wrapper d-flex flex-wrap flex-100">
    <div class="table-header-item flex-10">
        <h4>SL</h4>
    </div>
    <div class="table-header-item flex-20 text-start">
        <h4>Department</h4>
    </div>
    <div class="table-header-item flex-30 text-start">
        <h4>Name</h4>
    </div>
    <div class="table-header-item flex-30 text-center">
        <h4>Description</h4>
    </div>
    <div class="table-header-item flex-10 text-end pe-2">
        <h4>Action</h4>
    </div>
</div>

<div class="table-body-wrapper">
    @forelse($designations as $key=>$item)
        <div class="table-body-item-wrapper d-flex flex-wrap">
            <div class="table-body-item flex-10">
                <h4>{{ $designations->firstItem() + $loop->iteration - 1 }}</h4>
            </div>
            <div class="table-body-item flex-20 ">
                <h4 class="text-start erp-t-email">{{ $item->department->name??'N/A' }}</h4>
            </div>
            <div class="table-body-item flex-30 ">
                <h4 class="text-start erp-t-email">{{ $item->name??'N/A' }}</h4>
            </div>

            <div class="table-body-item flex-30 ">
                <h4 class="text-center erp-t-email"> {!! $item->description ?? 'N/A' !!} </h4>
            </div>
            <div class="table-body-item flex-10 pe-2 justify-content-end">
                @if(hasPermission('manage-designations'))
                    <div class="erp-action-t">
                        <div class="dropdown dropdown-action">
                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="javascript:void(0)" onclick="editItem({{$item->id}})"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                <a class="dropdown-item" href="javascript:void(0)" onclick="deleteAjax('{{ route('hr.designation.delete',$item->id) }}', 'reloadAjaxGetData')"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @empty
        <div class="table-body-item-wrapper">
            <div class="table-body-item text-center d-block text-primary">
               No Data Found..!
            </div>
        </div>
    @endforelse
</div>
{{ $designations->links('vendor.pagination.common_ajax_pagination') }}
