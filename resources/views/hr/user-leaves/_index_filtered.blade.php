<table class="table mb-0 erp-table">
    <thead class="erp-thead">
        <tr class="erp-tr">
            <th class="erp-th">SL</th>
            <th class="erp-th">Employee </th>
            <th class="erp-th text-center">Date To Date </th>
            <th class="erp-th text-center">Reason </th>
            <th class="erp-th text-center">Status </th>
            <th class="erp-th text-center">Approved By </th>


            <th class="text-end erp-th">Action</th>
        </tr>
    </thead>
    <tbody class="erp-tbody">
    @foreach($userLeaves as $userLeave)
        <tr class="erp-tbody-tr">
            <td class="erp-tbody-td">
                <h4 class="d-table-title">{{ $userLeaves->total() + $loop->iteration - 1 }}</h4>
            </td>
            <td class="erp-tbody-td">
                <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100">
                    <div class="em-pro-img-box">
                        <img src="{{ asset($userLeave->user->show_image) }}" alt="">
                    </div>
                    <div class="em-pro-details-box">
                        <h5>{{ $userLeave->user->full_name??'' }}</h5>
                        <p class="em-id">ID: <span> #{{ $userLeave->user->employee_id ?? '' }}</span></p>

                    </div>
                </div>
            </td>
            <td class="erp-tbody-td text-center">
                <h4 class="text-center d-table-title">{{ getFormattedDate($userLeave->approve_start_date,'d M, Y') }} to {{ getFormattedDate($userLeave->approve_end_date,'d M, Y') }}</h4>
                <small class="text-center d-table-title">({{ $userLeave->approved_number_of_days }} Days)</small>

            </td>
            <td class="erp-tbody-td text-center">
                <h4 class="text-center d-table-title">{{ $userLeave->reason??'N/A' }}</h4>

            </td>
            <td class="erp-tbody-td text-center">

                <div class="erp-action-t erp-table-status status-{{strtolower($userLeave->leave_status_label)}}">
                    <div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-regular fa-circle-dot me-1"></i> <span>{{ $userLeave->leave_status_label }}</span></a>
                    </div>
                </div>
            </td>
            <td class="erp-tbody-td text-center">
                <h4 class="text-center d-table-title">{{ ($userLeave->accepted_by) ? $userLeave->approvedBy->full_name : 'Not yet' }}</h4>
            </td>


            <td class="text-end erp-tbody-td">
                <div class="erp-action-t">
                    <div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                        <div class="dropdown-menu dropdown-menu-right">

                            <a class="dropdown-item" href="javascript:void(0)" onclick="editItem({{$userLeave->id}})"><i class="fa-solid fa-pencil m-r-5"></i> Details</a>
                            <a class="dropdown-item" href="javascript:void(0)" onclick="deleteAjax('{{ route('hr.user-leaves.delete',$userLeave->id) }}', 'reloadAjaxGetData') "><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>

                        </div>
                    </div>
                </div>
            </td>
        </tr>
    @endforeach
        {{--<tr class="erp-tbody-tr">
            <td class="erp-tbody-td">
                <h4 class="d-table-title">2</h4>
            </td>
            <td class="erp-tbody-td">
                <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100">
                    <div class="em-pro-img-box">
                        <img src="assets/img/profiles/man.png" alt="">
                    </div>
                    <div class="em-pro-details-box">
                        <h5>Md Mainul Islam Gazi</h5>
                        <p class="em-id">ID: <span> #45454</span></p>

                    </div>
                </div>
            </td>
            <td class="erp-tbody-td text-center">
                <h4 class="text-center d-table-title">5 Nov to 8 November, 2023</h4>
                <small class="text-center d-table-title">(3 Days)</small>

            </td>
            <td class="erp-tbody-td text-center">
                <h4 class="text-center d-table-title">Sick</h4>

            </td>
            <td class="erp-tbody-td text-center">

                <div class="erp-action-t erp-table-status status-rejected">
                    <div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-regular fa-circle-dot me-1"></i> <span>Rejected</span></a>
                        <div class="dropdown-menu dropdown-menu-right">

                            <a class="dropdown-item" href="#" ><i class="fa-regular fa-circle-dot m-r-5 "></i> Approve</a>
                            <a class="dropdown-item" href="#" ><i class="fa-regular fa-circle-dot m-r-5"></i> Pending</a>
                            <a class="dropdown-item" href="#" ><i class="fa-regular fa-circle-dot m-r-5"></i> Reject</a>

                        </div>
                    </div>
                </div>
            </td>
            <td class="erp-tbody-td text-center">
                <h4 class="text-center d-table-title">Moshiur Rahman</h4>
            </td>


            <td class="text-end erp-tbody-td">
                <div class="erp-action-t">
                    <div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                        <div class="dropdown-menu dropdown-menu-right">

                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_employee"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_resignation"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>

                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr class="erp-tbody-tr">
            <td class="erp-tbody-td">
                <h4 class="d-table-title">3</h4>
            </td>
            <td class="erp-tbody-td">
                <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100">
                    <div class="em-pro-img-box">
                        <img src="assets/img/profiles/man.png" alt="">
                    </div>
                    <div class="em-pro-details-box">
                        <h5>Md Mainul Islam Gazi</h5>
                        <p class="em-id">ID: <span> #45454</span></p>

                    </div>
                </div>
            </td>
            <td class="erp-tbody-td text-center">
                <h4 class="text-center d-table-title">1 Nov to 5 November, 2023</h4>
                <small class="text-center d-table-title">(5 Days)</small>

            </td>
            <td class="erp-tbody-td text-center">
                <h4 class="text-center d-table-title">Sick</h4>

            </td>
            <td class="erp-tbody-td text-center">

                <div class="erp-action-t erp-table-status status-approved">
                    <div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-regular fa-circle-dot me-1"></i> <span>Approved</span></a>
                        <div class="dropdown-menu dropdown-menu-right">

                            <a class="dropdown-item" href="#" ><i class="fa-regular fa-circle-dot m-r-5 "></i> Approve</a>
                            <a class="dropdown-item" href="#" ><i class="fa-regular fa-circle-dot m-r-5"></i> Pending</a>
                            <a class="dropdown-item" href="#" ><i class="fa-regular fa-circle-dot m-r-5"></i> Reject</a>

                        </div>
                    </div>
                </div>
            </td>
            <td class="erp-tbody-td text-center">
                <h4 class="text-center d-table-title">Moshiur Rahman</h4>
            </td>


            <td class="text-end erp-tbody-td">
                <div class="erp-action-t">
                    <div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                        <div class="dropdown-menu dropdown-menu-right">

                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_employee"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_resignation"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>

                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr class="erp-tbody-tr">
            <td class="erp-tbody-td">
                <h4 class="d-table-title">4</h4>
            </td>
            <td class="erp-tbody-td">
                <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100">
                    <div class="em-pro-img-box">
                        <img src="assets/img/profiles/man.png" alt="">
                    </div>
                    <div class="em-pro-details-box">
                        <h5>Md Mainul Islam Gazi</h5>
                        <p class="em-id">ID: <span> #45454</span></p>

                    </div>
                </div>
            </td>
            <td class="erp-tbody-td text-center">
                <h4 class="text-center d-table-title">1 Nov to 5 November, 2023</h4>
                <small class="text-center d-table-title">(5 Days)</small>

            </td>
            <td class="erp-tbody-td text-center">
                <h4 class="text-center d-table-title">Sick</h4>

            </td>
            <td class="erp-tbody-td text-center">

                <div class="erp-action-t erp-table-status status-approved">
                    <div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-regular fa-circle-dot me-1"></i> <span>Approved</span></a>
                        <div class="dropdown-menu dropdown-menu-right">

                            <a class="dropdown-item" href="#" ><i class="fa-regular fa-circle-dot m-r-5 "></i> Approve</a>
                            <a class="dropdown-item" href="#" ><i class="fa-regular fa-circle-dot m-r-5"></i> Pending</a>
                            <a class="dropdown-item" href="#" ><i class="fa-regular fa-circle-dot m-r-5"></i> Reject</a>

                        </div>
                    </div>
                </div>
            </td>
            <td class="erp-tbody-td text-center">
                <h4 class="text-center d-table-title">Moshiur Rahman</h4>
            </td>


            <td class="text-end erp-tbody-td">
                <div class="erp-action-t">
                    <div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                        <div class="dropdown-menu dropdown-menu-right">

                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_employee"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_resignation"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>

                        </div>
                    </div>
                </div>
            </td>
        </tr>--}}
    </tbody>
</table>

{{ $userLeaves->links('vendor.pagination.common_ajax_pagination') }}
