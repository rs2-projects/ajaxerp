<div class="table-header-wrapper d-flex flex-wrap">
    <div class="table-header-item em-list flex-10">
        <h4>Date</h4>
    </div>
    <div class="table-header-item em-list text-center flex-20">
        <h4>Total To Pay</h4>
    </div>
    <div class="table-header-item em-list text-center flex-20">
        <h4>Salary Period</h4>
    </div>
    <div class="table-header-item em-list text-center flex-20">
        <h4>Generated Status</h4>
    </div>
    <div class="table-header-item em-list text-center flex-20">
        <h4>Generated At</h4>
    </div>
    <div class="table-header-item em-list text-center flex-10">
        <h4>Action</h4>
    </div>
</div>
@if(count($salaries) > 0)
    <div class="table-body-wrapper">
        @foreach($salaries as $key=>$item)
            <div class="table-body-item-wrapper d-flex flex-wrap">
                <div class="table-body-item dep-list flex-10">
                    <h4 class="text-start erp-t-email">
                        <a href="{{ route('payroll.generated-salary.details',$item->id) }}">{{ getFormattedDate($item->salary_date,'d M, Y') }}</a>
                    </h4>
                </div>

                <div class="table-body-item dep-list flex-20">
                    <h4 class="text-center erp-t-email">{{ getCurrencySymbol() }} {{ showAmount($item->total_amount_to_pay) }}</h4>
                </div>

                <div class="table-body-item dep-list flex-20">
                    <h4 class="text-center erp-t-email">{{ $item::SALARY_PERIODS[$item->salary_period] }}</h4>
                </div>

                <div class="table-body-item dep-list flex-20">
                    <h4 class="text-center erp-t-email">{{ $item::GENERATION_STATUSES[$item->generation_status] }}</h4>
                </div>
                <div class="table-body-item dep-list flex-20">
                    <h4 class="text-center erp-t-email">{{ getFormattedDateTime($item->generated_at) }}</h4>
                </div>
                <div class="table-body-item dep-list pe-2 justify-content-end flex-10">
                    <div class="erp-action-t">
                        <div class="dropdown dropdown-action">
                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="{{ route('payroll.generated-salary.details',$item->id) }}"><i class="fa-solid fa-eye m-r-5"></i> Details</a>
                                {{--<a class="dropdown-item" href="javascript:void(0)" onclick="deleteAjax('{{ route('hr.department.delete',$item->id) }}', 'reloadAjaxGetData') "><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{ $salaries->links('vendor.pagination.common_ajax_pagination') }}
@else
    <div class="table-body-wrapper">
        <div class="table-body-item-wrapper d-flex justify-content-center">
        <span class="text-danger text-center">
            No Data Available
        </span>
        </div>
    </div>
@endif

