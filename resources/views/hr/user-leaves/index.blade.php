@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        <div class="erp-add-employee-wrapper mb-3">
            <div class="erp-add-employee">
                @if(hasUserPermission(\App\Models\User::TYPE_ADMIN))
                    <a href="javascript:void(0)" class="btn add-btn erp-add-employee ms-2" data-bs-toggle="modal" data-bs-target="#add_user_leave"><i class="fa-solid fa-plus"></i> Add Leave</a>
                @else
                    <a href="javascript:void(0)" class="btn add-btn erp-add-employee" data-bs-toggle="modal" data-bs-target="#add_resignation"><i class="fa-solid fa-plus"></i> Request for Leave</a>
                @endif

            </div>
        </div>
        <div class="erp-employee-list-wrapper">
            <div class="erp-main-filter-wrapper bg-card attd-table">
                <div class="my-attendance-box-item flex-100 ">
                    <div class="erp-leave-tab-wrapper">
                        <ul class="nav nav-tabs erp-nav-tabs justify-content-center" id="myTab" role="tablist">
                            <li class="nav-item erp-nav-item" role="presentation">
                                <button class="nav-link active erp-nav-link" id="all-leave-tab" data-bs-toggle="tab" data-bs-target="#all-leave" type="button" role="tab" aria-controls="home" aria-selected="true">All</button>
                            </li>
                            <li class="nav-item erp-nav-item" role="presentation">
                                <button class="nav-link erp-nav-link" id="pending-leave-tab" data-bs-toggle="tab" data-bs-target="#pending-leave" type="button" role="tab" aria-controls="profile" aria-selected="false">Pending</button>
                            </li>
                            <li class="nav-item erp-nav-item" role="presentation">
                                <button class="nav-link erp-nav-link" id="approved-leave-tab" data-bs-toggle="tab" data-bs-target="#approved-leave" type="button" role="tab" aria-controls="contact" aria-selected="false">Approved</button>
                            </li>
                            <li class="nav-item erp-nav-item" role="presentation">
                                <button class="nav-link erp-nav-link" id="rejected-leave-tab" data-bs-toggle="tab" data-bs-target="#rejected-leave" type="button" role="tab" aria-controls="contact" aria-selected="false">Rejected</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="all-leave" role="tabpanel" aria-labelledby="all-leave-tab">
                                <div class="my-attendance-report-wrapper">
                                    <div class="erp-header-main-wrap d-flex justify-content-between align-items-center">
                                        <div class="erp-box-header">
                                            <h4>All Leave History </h4>
                                        </div>
                                        <div class="erp-filter-box d-flex align-items-center justify-content-end">

                                            <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-end">
                                                <div class="erp-filter-item">
                                                    <h6 class="me-2">Search By: </h6>
                                                </div>
                                                <div class="erp-filter-item">
                                                    <div class=" form-focus select-focus custom-form-focus">
                                                        <select class="select floating select2-box">
                                                            <option>Select Month</option>
                                                            <option>January</option>
                                                            <option>February</option>
                                                            <option>March</option>
                                                            <option>April</option>
                                                            <option>May</option>
                                                            <option>June</option>
                                                            <option>July</option>
                                                            <option>August</option>
                                                            <option>September</option>
                                                            <option>October</option>
                                                            <option>November</option>
                                                            <option>December</option>
                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="erp-filter-item">
                                                    <div class=" form-focus select-focus custom-form-focus">
                                                        <select class="select floating select2-box">
                                                            <option>Select Year</option>
                                                            <option>2023</option>
                                                            <option>2022</option>
                                                            <option>2021</option>
                                                            <option>Last Year</option>
                                                            <option>Last Two Years</option>

                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="erp-filter-item">
                                                    <div class="erp-search-btn-wrap">
                                                        <button class=" erp-search-btn">Search</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="big-table pt-4">
                                        <div class="de-table-wrapper">
                                            <div class="" id="ajax-data-load">

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="tab-pane fade" id="pending-leave" role="tabpanel" aria-labelledby="pending-leave-tab">
                                <div class="my-attendance-report-wrapper">
                                    <div class="erp-header-main-wrap d-flex justify-content-between align-items-center">
                                        <div class="erp-box-header">
                                            <h4>Pending Leave History </h4>
                                        </div>
                                        <div class="erp-filter-box d-flex align-items-center justify-content-end">

                                            <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-end">
                                                <div class="erp-filter-item">
                                                    <h6 class="me-2">Search By: </h6>
                                                </div>
                                                <div class="erp-filter-item">
                                                    <div class=" form-focus select-focus custom-form-focus">
                                                        <select class="select floating select2-box">
                                                            <option>Select Month</option>
                                                            <option>January</option>
                                                            <option>February</option>
                                                            <option>March</option>
                                                            <option>April</option>
                                                            <option>May</option>
                                                            <option>June</option>
                                                            <option>July</option>
                                                            <option>August</option>
                                                            <option>September</option>
                                                            <option>October</option>
                                                            <option>November</option>
                                                            <option>December</option>
                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="erp-filter-item">
                                                    <div class=" form-focus select-focus custom-form-focus">
                                                        <select class="select floating select2-box">
                                                            <option>Select Year</option>
                                                            <option>2023</option>
                                                            <option>2022</option>
                                                            <option>2021</option>
                                                            <option>Last Year</option>
                                                            <option>Last Two Years</option>

                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="erp-filter-item">
                                                    <div class="erp-search-btn-wrap">
                                                        <button class=" erp-search-btn">Search</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="big-table pt-4">
                                        <div class="de-table-wrapper">
                                            <div class="table-responsive">
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
                                                    <tr class="erp-tbody-tr">
                                                        <td class="erp-tbody-td">
                                                            <h4 class="d-table-title">1</h4>
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

                                                            <div class="erp-action-t erp-table-status">
                                                                <div class="dropdown dropdown-action">
                                                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-regular fa-circle-dot me-1"></i> <span>Pending</span></a>
                                                                    <div class="dropdown-menu dropdown-menu-right">

                                                                        <a class="dropdown-item" href="#" ><i class="fa-regular fa-circle-dot m-r-5 "></i> Approve</a>
                                                                        <a class="dropdown-item" href="#" ><i class="fa-regular fa-circle-dot m-r-5"></i> Pending</a>
                                                                        <a class="dropdown-item" href="#" ><i class="fa-regular fa-circle-dot m-r-5"></i> Reject</a>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="erp-tbody-td text-center">
                                                            <h4 class="text-center d-table-title">Not Yet</h4>
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

                                                            <div class="erp-action-t erp-table-status">
                                                                <div class="dropdown dropdown-action">
                                                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-regular fa-circle-dot me-1"></i> <span>Pending</span></a>
                                                                    <div class="dropdown-menu dropdown-menu-right">

                                                                        <a class="dropdown-item" href="#" ><i class="fa-regular fa-circle-dot m-r-5 "></i> Approve</a>
                                                                        <a class="dropdown-item" href="#" ><i class="fa-regular fa-circle-dot m-r-5"></i> Pending</a>
                                                                        <a class="dropdown-item" href="#" ><i class="fa-regular fa-circle-dot m-r-5"></i> Reject</a>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="erp-tbody-td text-center">
                                                            <h4 class="text-center d-table-title">Not Yet</h4>
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

                                                            <div class="erp-action-t erp-table-status ">
                                                                <div class="dropdown dropdown-action">
                                                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-regular fa-circle-dot me-1"></i> <span>Pending</span></a>
                                                                    <div class="dropdown-menu dropdown-menu-right">

                                                                        <a class="dropdown-item" href="#" ><i class="fa-regular fa-circle-dot m-r-5 "></i> Approve</a>
                                                                        <a class="dropdown-item" href="#" ><i class="fa-regular fa-circle-dot m-r-5"></i> Pending</a>
                                                                        <a class="dropdown-item" href="#" ><i class="fa-regular fa-circle-dot m-r-5"></i> Reject</a>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="erp-tbody-td text-center">
                                                            <h4 class="text-center d-table-title">Not Yet</h4>
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

                                                            <div class="erp-action-t erp-table-status ">
                                                                <div class="dropdown dropdown-action">
                                                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-regular fa-circle-dot me-1"></i> <span>Pending</span></a>
                                                                    <div class="dropdown-menu dropdown-menu-right">

                                                                        <a class="dropdown-item" href="#" ><i class="fa-regular fa-circle-dot m-r-5 "></i> Approve</a>
                                                                        <a class="dropdown-item" href="#" ><i class="fa-regular fa-circle-dot m-r-5"></i> Pending</a>
                                                                        <a class="dropdown-item" href="#" ><i class="fa-regular fa-circle-dot m-r-5"></i> Reject</a>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="erp-tbody-td text-center">
                                                            <h4 class="text-center d-table-title">Not Yet</h4>
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
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="erp-pagination-wrapper d-flex justify-content-between align-items-center">
                                        <div class="erp-pagi-item">
                                            <div class="showing-date-box">
                                                <p>Showing 1 to 7 of 7 entries
                                                </p>
                                            </div>
                                        </div>
                                        <div class="erp-pagi-item">
                                            <ul class="pagination">
                                                <li class="page-item disabled">
                                                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                                                </li>
                                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                                <li class="page-item active">
                                                    <a class="page-link" href="#">2 <span class="visually-hidden">(current)</span></a>
                                                </li>
                                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                                <li class="page-item">
                                                    <a class="page-link" href="#">Next</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="tab-pane fade" id="approved-leave" role="tabpanel" aria-labelledby="approved-leave-tab">
                                <div class="my-attendance-report-wrapper">
                                    <div class="erp-header-main-wrap d-flex justify-content-between align-items-center">
                                        <div class="erp-box-header">
                                            <h4>Approved Leave History </h4>
                                        </div>
                                        <div class="erp-filter-box d-flex align-items-center justify-content-end">

                                            <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-end">
                                                <div class="erp-filter-item">
                                                    <h6 class="me-2">Search By: </h6>
                                                </div>
                                                <div class="erp-filter-item">
                                                    <div class=" form-focus select-focus custom-form-focus">
                                                        <select class="select floating select2-box">
                                                            <option>Select Month</option>
                                                            <option>January</option>
                                                            <option>February</option>
                                                            <option>March</option>
                                                            <option>April</option>
                                                            <option>May</option>
                                                            <option>June</option>
                                                            <option>July</option>
                                                            <option>August</option>
                                                            <option>September</option>
                                                            <option>October</option>
                                                            <option>November</option>
                                                            <option>December</option>
                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="erp-filter-item">
                                                    <div class=" form-focus select-focus custom-form-focus">
                                                        <select class="select floating select2-box">
                                                            <option>Select Year</option>
                                                            <option>2023</option>
                                                            <option>2022</option>
                                                            <option>2021</option>
                                                            <option>Last Year</option>
                                                            <option>Last Two Years</option>

                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="erp-filter-item">
                                                    <div class="erp-search-btn-wrap">
                                                        <button class=" erp-search-btn">Search</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="big-table pt-4">
                                        <div class="de-table-wrapper">
                                            <div class="table-responsive">
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
                                                    <tr class="erp-tbody-tr">
                                                        <td class="erp-tbody-td">
                                                            <h4 class="d-table-title">1</h4>
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
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="erp-pagination-wrapper d-flex justify-content-between align-items-center">
                                        <div class="erp-pagi-item">
                                            <div class="showing-date-box">
                                                <p>Showing 1 to 7 of 7 entries
                                                </p>
                                            </div>
                                        </div>
                                        <div class="erp-pagi-item">
                                            <ul class="pagination">
                                                <li class="page-item disabled">
                                                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                                                </li>
                                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                                <li class="page-item active">
                                                    <a class="page-link" href="#">2 <span class="visually-hidden">(current)</span></a>
                                                </li>
                                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                                <li class="page-item">
                                                    <a class="page-link" href="#">Next</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="tab-pane fade" id="rejected-leave" role="tabpanel" aria-labelledby="rejected-leave-tab">
                                <div class="my-attendance-report-wrapper">
                                    <div class="erp-header-main-wrap d-flex justify-content-between align-items-center">
                                        <div class="erp-box-header">
                                            <h4>Rejected Leave History </h4>
                                        </div>
                                        <div class="erp-filter-box d-flex align-items-center justify-content-end">

                                            <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-end">
                                                <div class="erp-filter-item">
                                                    <h6 class="me-2">Search By: </h6>
                                                </div>
                                                <div class="erp-filter-item">
                                                    <div class=" form-focus select-focus custom-form-focus">
                                                        <select class="select floating select2-box">
                                                            <option>Select Month</option>
                                                            <option>January</option>
                                                            <option>February</option>
                                                            <option>March</option>
                                                            <option>April</option>
                                                            <option>May</option>
                                                            <option>June</option>
                                                            <option>July</option>
                                                            <option>August</option>
                                                            <option>September</option>
                                                            <option>October</option>
                                                            <option>November</option>
                                                            <option>December</option>
                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="erp-filter-item">
                                                    <div class=" form-focus select-focus custom-form-focus">
                                                        <select class="select floating select2-box">
                                                            <option>Select Year</option>
                                                            <option>2023</option>
                                                            <option>2022</option>
                                                            <option>2021</option>
                                                            <option>Last Year</option>
                                                            <option>Last Two Years</option>

                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="erp-filter-item">
                                                    <div class="erp-search-btn-wrap">
                                                        <button class=" erp-search-btn">Search</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="big-table pt-4">
                                        <div class="de-table-wrapper">
                                            <div class="table-responsive">
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
                                                    <tr class="erp-tbody-tr">
                                                        <td class="erp-tbody-td">
                                                            <h4 class="d-table-title">1</h4>
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
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="erp-pagination-wrapper d-flex justify-content-between align-items-center">
                                        <div class="erp-pagi-item">
                                            <div class="showing-date-box">
                                                <p>Showing 1 to 7 of 7 entries
                                                </p>
                                            </div>
                                        </div>
                                        <div class="erp-pagi-item">
                                            <ul class="pagination">
                                                <li class="page-item disabled">
                                                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                                                </li>
                                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                                <li class="page-item active">
                                                    <a class="page-link" href="#">2 <span class="visually-hidden">(current)</span></a>
                                                </li>
                                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                                <li class="page-item">
                                                    <a class="page-link" href="#">Next</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </div>


    </div>
    <!--End::row-1 -->
@endsection

@section('modals')
    @include('hr.user-leaves._add_user_leave_modal')
@endsection

@section('css')

@endsection

@section('css_plugins')
    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}">
@endsection

@section('js_plugins')
    <!-- Datetimepicker JS -->
    <script src="{{asset('assets/js/moment.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap-datetimepicker.min.js')}}"></script>
@endsection

@section('js')
    <script>
        var filterData = {
            keyword_filtered: ''
        };
        $(document).ready(function(){
            getData();
            initializeDatepicker();

            filterData.keyword_filtered = $("#keyword_filtered").val()
            $("#keyword_filtered").on('input', function () {
                filterData.keyword_filtered = $(this).val();
            });

            $("#userLeavesStoreForm").on('submit', function (e) {
                var self = this;
                e.preventDefault();
                var formData = new FormData($(self)[0]);
                $(".ie-span").text("").hide();
                var url = $(self).attr('action');
                formPost(url, formData, function (res) {
                    if(res.status == 200){
                        $("#add_user_leave").modal('hide');
                        $(self)[0].reset();
                        // user and leave tregger change
                        $("#user_id").trigger('change');
                        $("#settings_leave_type_id").trigger('change');
                        showSuccessAlert('Success',res.message)
                        getData();
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');
            });

            $(document).on("submit", "#departmentUpdateForm", function(e) {
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                $(".ie-span").text("").hide();
                var url = $(this).attr('action');

                formPost(url, formData, function (res){
                    if(res.status == 200){
                        $("#edit_department_modal").modal('hide');
                        showSuccessAlert('Success',res.message)
                        getData();
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');
            });

        });

        function getData(){
            getPaginatedListData("{{ route('hr.user-leaves.filtered') }}", "#ajax-data-load", filterData);
        }

        function getPaginatedData(button) {
            getPaginatedListData($(button).attr('data-href'), "#ajax-data-load", filterData);
        }

        function editItem(id){
            let url = "{{route('hr.user-leaves.edit', ':id')}}";
            url = url.replace(':id', id);
            ajaxGet(url, {}, function (response) {
                if (response.status == 200) {
                    $("#edit_user_leave_modal_body").html(response.view);
                    $("#edit_user_leave_modal").modal('show');
                } else {
                    toastr.error(response.message);
                }
            }, 'default');
        }

        function initializeDatepicker() {
            $('.datetimepicker').datetimepicker({
                //format: 'DD/MM/YYYY',
                format: 'YYYY-MM-DD',
                icons: {
                    up: "fa fa-angle-up",
                    down: "fa-solid fa-angle-down",
                    next: 'fa-solid fa-angle-right',
                    previous: 'fa-solid fa-angle-left'
                }
            });
        }

        $(document).ready(function () {
            $('#start_date').on('dp.change', function(e){
                updateNumberOfDays();
            });
            $('#end_date').on('dp.change', function(e){
                updateNumberOfDays();
            });
        });

        function updateNumberOfDays() {
           let startDate = $('#start_date').val();//2024-01-02
            let endDate = $('#end_date').val();//2024-01-04

            if(!startDate || !endDate) {
                $("#number_of_days").val(0);
                return false;
            }

            // Convert date strings to Date objects
            let startDateTime = new Date(startDate).getTime();
            let endDateTime = new Date(endDate).getTime();

            if(startDate > endDate) {
                $('#end_date').val('');
                $("#number_of_days").val(0);
                showInfoAlert('Oops!', 'End date can\'t be less then start date!');
                return false;
            }

            // Calculate the time difference in milliseconds
            let timeDifference = endDateTime - startDateTime;

            // Convert milliseconds to days
            let daysDifference = timeDifference / (1000 * 60 * 60 * 24);
            daysDifference += 1;
            $("#number_of_days").val(daysDifference);
        }

        function employeeChange(value){

            let user_id = $(value).val();
            let url = "{{ route('ajax.get-leave-type-by-user') }}"

            ajaxGet(url, {user_id: user_id}, function (response) {
                if (response.status == 200) {
                    $("#settings_leave_type_id").html(response.view);
                } else {
                    toastr.error(response.message);
                    // trigger change leave type
                    $("#settings_leave_type_id").html('<option value="">Select Leave Type</option>');
                    $("#settings_leave_type_id").trigger('change');
                }
            }, 'default');
        }

        function LeaveTypeChnage(value){
            let leave_type_id = $(value).val();
            let user_id = $("#user_id").val();
            let url = "{{ route('ajax.get-user-total-leave-by-leave-type') }}"

            ajaxGet(url, {leave_type_id: leave_type_id,user_id:user_id}, function (response) {
                if (response.status == 200) {
                    $("#remaining_leave").val(response.data.remaining_leaves);

                } else {
                    toastr.error(response.message);
                }
            }, 'default');
        }

    </script>

@endsection


