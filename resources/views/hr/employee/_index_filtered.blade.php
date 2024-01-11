<div class="table-header-wrapper d-flex flex-wrap">
    <div class="table-header-item em-list">
        <h4>SL</h4>
    </div>
    <div class="table-header-item em-list text-start">
        <h4>Name</h4>
    </div>
    <div class="table-header-item em-list text-center">
        <h4>Email</h4>
    </div>
    <div class="table-header-item em-list text-center">
        <h4>Phone</h4>
    </div>
    <div class="table-header-item em-list text-center">
        <h4>Department</h4>
    </div>
    <div class="table-header-item em-list text-center">
        <h4>Designation</h4>
    </div>
    <div class="table-header-item em-list text-center">
        <h4>Login</h4>
    </div>
    <div class="table-header-item em-list text-center">
        <h4>Action</h4>
    </div>
</div>
<div class="table-body-wrapper">
    @foreach($employees as $item)
        <div class="table-body-item-wrapper d-flex flex-wrap">
            <div class="table-body-item em-list">
                <h4>{{ $employees->firstItem() + $loop->iteration -1 }}</h4>
            </div>
            <div class="table-body-item em-list ">
                <a href="{{ route('hr.employee.details',$item->id) }}" class="em-profile-wrap d-flex align-items-center flex-wrap w-100">
                    <div class="em-pro-img-box">
                        <img src="{{ $item->show_image }}" alt="">
                    </div>
                    <div class="em-pro-details-box">
                        <h5>{{ $item->full_name??'N/A' }}</h5>
                        <p class="em-id">ID: <span> #{{ $item->employee_id??'N/A' }}</span></p>

                    </div>
                </a>
            </div>

            <div class="table-body-item em-list ">
                <h4 class="text-center erp-t-email">{{ $item->email??'N/A' }}</h4>
            </div>
            <div class="table-body-item em-list ">
                <h4 class="text-center erp-t-phone">{{ $item->phone??'N/A' }}</h4>
            </div>
            <div class="table-body-item em-list ">
                <h4 class="text-center erp-t-department">{{ $item->department->name??'N/A' }}</h4>
            </div>
            <div class="table-body-item em-list ">
                <h4 class="text-center erp-t-designation">{{ $item->designation->name??'N/A' }}</h4>
            </div>
            <div class="table-body-item em-list ">
                <div class="erp-table-login">
                    <a href="#">Login</a>
                </div>
            </div>
            <div class="table-body-item em-list">
                <div class="erp-action-t">
                    <div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ route('hr.employee.details', $item->id) }}"><i class="la la-puzzle-piece m-r-5"></i> Details</a>
                            <a class="dropdown-item" href="{{ route('hr.employee.edit',$item->id) }}"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                            <a class="dropdown-item" href="javascript:void(0)" onclick="deleteAjax('{{ route('hr.employee.delete',$item->id) }}', 'reloadAjaxGetData')"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
                            <a class="dropdown-item" href="#"><i class="la la-crosshairs m-r-5"></i> Attendance</a>
                            <a class="dropdown-item" href="#"><i class="la la-question m-r-5"></i> Leave</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    @endforeach
</div>

{{ $employees->links('vendor.pagination.common_ajax_pagination')}}
