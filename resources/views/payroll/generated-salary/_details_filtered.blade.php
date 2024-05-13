<div class="table-header-wrapper d-flex flex-wrap">
    <div class="table-header-item em-list">
        <h4>SL</h4>
    </div>
    <div class="table-header-item em-list text-start">
        <h4>Name</h4>
    </div>
    <div class="table-header-item em-list text-center">
        <h4>Net Basic</h4>
    </div>
    <div class="table-header-item em-list text-center">
        <h4>Net Payable</h4>
    </div>
    <div class="table-header-item em-list text-center">
        <h4>Absent Penalty</h4>
    </div>
    <div class="table-header-item em-list text-center">
        <h4>Late Penalty</h4>
    </div>
    <div class="table-header-item em-list text-center">
        <h4>OverTime</h4>
    </div>
    <div class="table-header-item em-list text-center">
        <h4>Action</h4>
    </div>
</div>
<div class="table-body-wrapper">
    @foreach($salaryDetails as $item)
        <div class="table-body-item-wrapper d-flex flex-wrap">
            <div class="table-body-item em-list">
                <h4>{{ $salaryDetails->firstItem() + $loop->iteration -1 }}</h4>
            </div>
            <div class="table-body-item em-list ">
                <a href="{{ route('hr.employee.details',$item->employee->id) }}" class="em-profile-wrap d-flex align-items-center flex-wrap w-100">
                    <div class="em-pro-img-box">
                        <img src="{{ $item->employee->show_image }}" alt="">
                    </div>
                    <div class="em-pro-details-box">
                        <h5>{{ $item->employee->full_name??'N/A' }}</h5>
                        <p class="em-id">ID: <span> #{{ $item->employee->employee_id??'N/A' }}</span></p>

                    </div>
                </a>
            </div>

            <div class="table-body-item em-list ">
                <h4 class="text-center erp-t-email">{{ getCurrencySymbol() }} {{ showAmount($item->net_basic_salary) }}</h4>
            </div>
            <div class="table-body-item em-list ">
                <h4 class="text-center erp-t-phone">{{ getCurrencySymbol() }} {{ showAmount($item->net_payable_salary) }}</h4>
            </div>
            <div class="table-body-item em-list ">
                <h4 class="text-center erp-t-department">{{ getCurrencySymbol() }} {{ showAmount($item->absent_day_amount) }}</h4>
            </div>
            <div class="table-body-item em-list ">
                <h4 class="text-center erp-t-designation">{{ getCurrencySymbol() }} {{ showAmount( $item->late_amount) }}</h4>
            </div>
            <div class="table-body-item em-list ">
                <h4 class="text-center erp-t-designation">{{ getCurrencySymbol() }} {{ showAmount( $item->total_over_time_amount) }}</h4>
            </div>
            <div class="table-body-item em-list">
                <div class="erp-action-t">
                    <div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                        <div class="dropdown-menu dropdown-menu-right">
                            @if(hasPermission('manage-salary'))
                                <a class="dropdown-item" onclick="editItem({{$item->id}})" href="javascript:void(0)"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                            @endif
                            <a class="dropdown-item" onclick="showItem({{$item->id}})" href="javascript:void(0)"><i class="fa-solid fa-eye m-r-5"></i> Show</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    @endforeach
</div>

{{ $salaryDetails->links('vendor.pagination.common_ajax_pagination')}}
