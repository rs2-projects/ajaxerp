<ul class="nav nav-tabs erp-nav-tabs justify-content-center" id="myTab" role="tablist">
    <li class="nav-item erp-nav-item" role="presentation">
        <button class="nav-link active erp-nav-link" id="all-purchase-tab" data-bs-toggle="tab" data-bs-target="#all-purchase" type="button" role="tab" aria-controls="home" aria-selected="true">All Purchase Order</button>
    </li>
    <li class="nav-item erp-nav-item" role="presentation">
        <button class="nav-link erp-nav-link" id="new-purchase-tab" data-bs-toggle="tab" data-bs-target="#new-purchase" type="button" role="tab" aria-controls="profile" aria-selected="false">New P.O</button>
    </li>
    <li class="nav-item erp-nav-item" role="presentation">
        <button class="nav-link erp-nav-link" id="process-purchase-tab" data-bs-toggle="tab" data-bs-target="#process-purchase" type="button" role="tab" aria-controls="contact" aria-selected="false">On Process P.O</button>
    </li>
    <li class="nav-item erp-nav-item" role="presentation">
        <button class="nav-link erp-nav-link" id="deliver-purchase-tab" data-bs-toggle="tab" data-bs-target="#deliver-purchase" type="button" role="tab" aria-controls="contact" aria-selected="false">Delivered P.O</button>
    </li>
    <li class="nav-item erp-nav-item" role="presentation">
        <button class="nav-link erp-nav-link" id="revised-purchase-tab" data-bs-toggle="tab" data-bs-target="#revised-purchase" type="button" role="tab" aria-controls="contact" aria-selected="false">Revised P.O</button>
    </li>
    <li class="nav-item erp-nav-item" role="presentation">
        <button class="nav-link erp-nav-link" id="back-purchase-tab" data-bs-toggle="tab" data-bs-target="#back-purchase" type="button" role="tab" aria-controls="contact" aria-selected="false">Back P.O</button>
    </li>
</ul>

<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="all-purchase" role="tabpanel" aria-labelledby="all-purchase-tab">
        <div class="my-attendance-report-wrapper">
            <div class="big-table pt-4">
                <div class="de-table-wrapper">
                    <div class="table-responsive">
                        <table class="table mb-0 erp-table">
                            <thead class="erp-thead">
                            <tr class="erp-tr">
                                <th class="erp-th">SL</th>
                                <th class="erp-th">P.O No </th>
                                <th class="erp-th text-center">Estimate Delivery Date </th>
                                <th class="erp-th text-center">Supplier </th>
                                <th class="erp-th text-center">Product </th>
                                <th class="erp-th text-center">Total Amount </th>
                                <th class="erp-th text-center">Due Amount </th>
                                <th class="erp-th text-center">Payment Status </th>
                                <th class="erp-th text-center">Record Payment </th>
                                <th class="text-end erp-th">Action</th>
                            </tr>
                            </thead>
                            <tbody class="erp-tbody">
                            <tr class="erp-tbody-tr">
                                <td class="erp-tbody-td">
                                    <h4 class="d-table-title">1</h4>
                                </td>
                                <td class="erp-tbody-td text-start">
                                    <h4 class="text-start d-table-title"><strong>PO -</strong> <span>10010032</span></h4>
                                    <small class="text-center d-table-title">1 Nov, 2023</small>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">1 Nov, 2023</h4>

                                </td>
                                <td class="erp-tbody-td">
                                    <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100 justify-content-center">
                                        <div class="em-pro-img-box">
                                            <img src="assets/img/profiles/office-building.png" alt="">
                                        </div>
                                        <div class="em-pro-details-box">
                                            <h5>Jamuna Group</h5>
                                        </div>
                                    </div>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">5</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$3223232</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$45343</h4>

                                </td>
                                <td class="erp-tbody-td text-center">

                                    <h4 class="text-center d-table-title unpaid-status">Unpaid</h4>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <a href="#" class="make-payment-btn" data-bs-toggle="modal" data-bs-target="#make-payment">Make Payment</a>
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
                                <td class="erp-tbody-td text-start">
                                    <h4 class="text-start d-table-title"><strong>PO -</strong> <span>10010032</span></h4>
                                    <small class="text-center d-table-title">1 Nov, 2023</small>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">1 Nov, 2023</h4>

                                </td>
                                <td class="erp-tbody-td">
                                    <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100 justify-content-center">
                                        <div class="em-pro-img-box">
                                            <img src="assets/img/profiles/office-building.png" alt="">
                                        </div>
                                        <div class="em-pro-details-box">
                                            <h5>Jamuna Group</h5>
                                        </div>
                                    </div>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">5</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$3223232</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$45343</h4>

                                </td>
                                <td class="erp-tbody-td text-center">

                                    <h4 class="text-center d-table-title patial-status">Partial</h4>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <a href="#" class="make-payment-btn" data-bs-toggle="modal" data-bs-target="#make-payment">Make Payment</a>
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
                                <td class="erp-tbody-td text-start">
                                    <h4 class="text-start d-table-title"><strong>PO -</strong> <span>10010032</span></h4>
                                    <small class="text-center d-table-title">1 Nov, 2023</small>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">1 Nov, 2023</h4>

                                </td>
                                <td class="erp-tbody-td">
                                    <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100 justify-content-center">
                                        <div class="em-pro-img-box">
                                            <img src="assets/img/profiles/office-building.png" alt="">
                                        </div>
                                        <div class="em-pro-details-box">
                                            <h5>Jamuna Group</h5>
                                        </div>
                                    </div>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">5</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$3223232</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$45343</h4>

                                </td>
                                <td class="erp-tbody-td text-center">

                                    <h4 class="text-center d-table-title unpaid-status">Unpaid</h4>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <a href="#" class="make-payment-btn" data-bs-toggle="modal" data-bs-target="#make-payment">Make Payment</a>
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
                                <td class="erp-tbody-td text-start">
                                    <h4 class="text-start d-table-title"><strong>RPO -</strong> <span>10010032</span></h4>
                                    <small class="text-center d-table-title">1 Nov, 2023</small>
                                    <div class="revised-status">
                                        <span>Revised Order</span>
                                    </div>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">1 Nov, 2023</h4>

                                </td>
                                <td class="erp-tbody-td">
                                    <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100 justify-content-center">
                                        <div class="em-pro-img-box">
                                            <img src="assets/img/profiles/office-building.png" alt="">
                                        </div>
                                        <div class="em-pro-details-box">
                                            <h5>Jamuna Group</h5>
                                        </div>
                                    </div>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">5</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$3223232</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$45343</h4>

                                </td>
                                <td class="erp-tbody-td text-center">

                                    <h4 class="text-center d-table-title unpaid-status">Unpaid</h4>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title pending-status">Pending</h4>
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
                                    <h4 class="d-table-title">5</h4>
                                </td>
                                <td class="erp-tbody-td text-start">
                                    <h4 class="text-start d-table-title"><strong>BPO -</strong> <span>10010032</span></h4>
                                    <small class="text-center d-table-title">1 Nov, 2023</small>
                                    <div class="back-order-status">
                                        <span>Back Order</span>
                                    </div>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">1 Nov, 2023</h4>

                                </td>
                                <td class="erp-tbody-td">
                                    <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100 justify-content-center">
                                        <div class="em-pro-img-box">
                                            <img src="assets/img/profiles/office-building.png" alt="">
                                        </div>
                                        <div class="em-pro-details-box">
                                            <h5>Jamuna Group</h5>
                                        </div>
                                    </div>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">5</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$3223232</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$45343</h4>

                                </td>
                                <td class="erp-tbody-td text-center">

                                    <h4 class="text-center d-table-title paid-status">Paid</h4>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title complete-status">Complete</h4>
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
                                    <h4 class="d-table-title">6</h4>
                                </td>
                                <td class="erp-tbody-td text-start">
                                    <h4 class="text-start d-table-title"><strong>PO -</strong> <span>10010032</span></h4>
                                    <small class="text-center d-table-title">1 Nov, 2023</small>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">1 Nov, 2023</h4>

                                </td>
                                <td class="erp-tbody-td">
                                    <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100 justify-content-center">
                                        <div class="em-pro-img-box">
                                            <img src="assets/img/profiles/office-building.png" alt="">
                                        </div>
                                        <div class="em-pro-details-box">
                                            <h5>Jamuna Group</h5>
                                        </div>
                                    </div>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">5</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$3223232</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$45343</h4>

                                </td>
                                <td class="erp-tbody-td text-center">

                                    <h4 class="text-center d-table-title paid-status">Paid</h4>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title complete-status">Complete</h4>
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
    <div class="tab-pane fade" id="new-purchase" role="tabpanel" aria-labelledby="new-purchase-tab">
        <div class="my-attendance-report-wrapper">
            <div class="big-table pt-4">
                <div class="de-table-wrapper">
                    <div class="table-responsive">
                        <table class="table mb-0 erp-table">
                            <thead class="erp-thead">
                            <tr class="erp-tr">
                                <th class="erp-th">SL</th>
                                <th class="erp-th">P.O No </th>
                                <th class="erp-th text-center">Estimate Delivery Date </th>
                                <th class="erp-th text-center">Supplier </th>
                                <th class="erp-th text-center">Product </th>
                                <th class="erp-th text-center">Total Amount </th>
                                <th class="erp-th text-center">Due Amount </th>
                                <th class="erp-th text-center">Payment Status </th>
                                <th class="erp-th text-center">Record Payment </th>
                                <th class="text-end erp-th">Action</th>
                            </tr>
                            </thead>
                            <tbody class="erp-tbody">
                            <tr class="erp-tbody-tr">
                                <td class="erp-tbody-td">
                                    <h4 class="d-table-title">1</h4>
                                </td>
                                <td class="erp-tbody-td text-start">
                                    <h4 class="text-start d-table-title"><strong>PO -</strong> <span>10010032</span></h4>
                                    <small class="text-center d-table-title">1 Nov, 2023</small>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">1 Nov, 2023</h4>

                                </td>
                                <td class="erp-tbody-td">
                                    <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100 justify-content-center">
                                        <div class="em-pro-img-box">
                                            <img src="assets/img/profiles/office-building.png" alt="">
                                        </div>
                                        <div class="em-pro-details-box">
                                            <h5>Jamuna Group</h5>
                                        </div>
                                    </div>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">5</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$3223232</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$45343</h4>

                                </td>
                                <td class="erp-tbody-td text-center">

                                    <h4 class="text-center d-table-title unpaid-status">Unpaid</h4>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <a href="#" class="make-payment-btn" data-bs-toggle="modal" data-bs-target="#make-payment">Make Payment</a>
                                </td>


                                <td class="text-end erp-tbody-td">
                                    <div class="erp-action-t">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" ><i class="fa-solid fa-circle-info m-r-5"></i> Create Revised P.O</a>
                                                <a class="dropdown-item" href="#" ><i class="fa-solid fa-circle-info m-r-5"></i> Create Back P.O</a>
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
                                <td class="erp-tbody-td text-start">
                                    <h4 class="text-start d-table-title"><strong>PO -</strong> <span>10010032</span></h4>
                                    <small class="text-center d-table-title">1 Nov, 2023</small>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">1 Nov, 2023</h4>

                                </td>
                                <td class="erp-tbody-td">
                                    <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100 justify-content-center">
                                        <div class="em-pro-img-box">
                                            <img src="assets/img/profiles/office-building.png" alt="">
                                        </div>
                                        <div class="em-pro-details-box">
                                            <h5>Jamuna Group</h5>
                                        </div>
                                    </div>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">5</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$3223232</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$45343</h4>

                                </td>
                                <td class="erp-tbody-td text-center">

                                    <h4 class="text-center d-table-title unpaid-status">Unpaid</h4>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <a href="#" class="make-payment-btn" data-bs-toggle="modal" data-bs-target="#make-payment">Make Payment</a>
                                </td>


                                <td class="text-end erp-tbody-td">
                                    <div class="erp-action-t">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" ><i class="fa-solid fa-circle-info m-r-5"></i> Create Revised P.O</a>
                                                <a class="dropdown-item" href="#" ><i class="fa-solid fa-circle-info m-r-5"></i> Create Back P.O</a>
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
                                <td class="erp-tbody-td text-start">
                                    <h4 class="text-start d-table-title"><strong>PO -</strong> <span>10010032</span></h4>
                                    <small class="text-center d-table-title">1 Nov, 2023</small>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">1 Nov, 2023</h4>

                                </td>
                                <td class="erp-tbody-td">
                                    <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100 justify-content-center">
                                        <div class="em-pro-img-box">
                                            <img src="assets/img/profiles/office-building.png" alt="">
                                        </div>
                                        <div class="em-pro-details-box">
                                            <h5>Jamuna Group</h5>
                                        </div>
                                    </div>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">5</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$3223232</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$45343</h4>

                                </td>
                                <td class="erp-tbody-td text-center">

                                    <h4 class="text-center d-table-title unpaid-status">Unpaid</h4>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <a href="#" class="make-payment-btn" data-bs-toggle="modal" data-bs-target="#make-payment">Make Payment</a>
                                </td>

                                <td class="text-end erp-tbody-td">
                                    <div class="erp-action-t">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" ><i class="fa-solid fa-circle-info m-r-5"></i> Create Revised P.O</a>
                                                <a class="dropdown-item" href="#" ><i class="fa-solid fa-circle-info m-r-5"></i> Create Back P.O</a>
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
                                <td class="erp-tbody-td text-start">
                                    <h4 class="text-start d-table-title"><strong>PO -</strong> <span>10010032</span></h4>
                                    <small class="text-center d-table-title">1 Nov, 2023</small>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">1 Nov, 2023</h4>

                                </td>
                                <td class="erp-tbody-td">
                                    <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100 justify-content-center">
                                        <div class="em-pro-img-box">
                                            <img src="assets/img/profiles/office-building.png" alt="">
                                        </div>
                                        <div class="em-pro-details-box">
                                            <h5>Jamuna Group</h5>
                                        </div>
                                    </div>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">5</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$3223232</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$45343</h4>

                                </td>
                                <td class="erp-tbody-td text-center">

                                    <h4 class="text-center d-table-title unpaid-status">unpaid</h4>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <a href="#" class="make-payment-btn" data-bs-toggle="modal" data-bs-target="#make-payment">Make Payment</a>
                                </td>


                                <td class="text-end erp-tbody-td">
                                    <div class="erp-action-t">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" ><i class="fa-solid fa-circle-info m-r-5"></i> Create Revised P.O</a>
                                                <a class="dropdown-item" href="#" ><i class="fa-solid fa-circle-info m-r-5"></i> Create Back P.O</a>
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
    <div class="tab-pane fade" id="process-purchase" role="tabpanel" aria-labelledby="process-purchase-tab">
        <div class="my-attendance-report-wrapper">
            <div class="big-table pt-4">
                <div class="de-table-wrapper">
                    <div class="table-responsive">
                        <table class="table mb-0 erp-table">
                            <thead class="erp-thead">
                            <tr class="erp-tr">
                                <th class="erp-th">SL</th>
                                <th class="erp-th">P.O No </th>
                                <th class="erp-th text-center">Estimate Delivery Date </th>
                                <th class="erp-th text-center">Supplier </th>
                                <th class="erp-th text-center">Product </th>
                                <th class="erp-th text-center">Total Amount </th>
                                <th class="erp-th text-center">Due Amount </th>
                                <th class="erp-th text-center">Payment Status </th>
                                <th class="erp-th text-center">Record Payment </th>
                                <th class="text-end erp-th">Action</th>
                            </tr>
                            </thead>
                            <tbody class="erp-tbody">
                            <tr class="erp-tbody-tr">
                                <td class="erp-tbody-td">
                                    <h4 class="d-table-title">1</h4>
                                </td>
                                <td class="erp-tbody-td text-start">
                                    <h4 class="text-start d-table-title"><strong>PO -</strong> <span>10010032</span></h4>
                                    <small class="text-center d-table-title">1 Nov, 2023</small>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">1 Nov, 2023</h4>

                                </td>
                                <td class="erp-tbody-td">
                                    <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100 justify-content-center">
                                        <div class="em-pro-img-box">
                                            <img src="assets/img/profiles/office-building.png" alt="">
                                        </div>
                                        <div class="em-pro-details-box">
                                            <h5>Jamuna Group</h5>
                                        </div>
                                    </div>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">5</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$3223232</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$45343</h4>

                                </td>
                                <td class="erp-tbody-td text-center">

                                    <h4 class="text-center d-table-title paid-status">Paid</h4>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <a href="investigation.html" class="make-payment-btn">Investigation</a>
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
                                <td class="erp-tbody-td text-start">
                                    <h4 class="text-start d-table-title"><strong>PO -</strong> <span>10010032</span></h4>
                                    <small class="text-center d-table-title">1 Nov, 2023</small>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">1 Nov, 2023</h4>

                                </td>
                                <td class="erp-tbody-td">
                                    <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100 justify-content-center">
                                        <div class="em-pro-img-box">
                                            <img src="assets/img/profiles/office-building.png" alt="">
                                        </div>
                                        <div class="em-pro-details-box">
                                            <h5>Jamuna Group</h5>
                                        </div>
                                    </div>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">5</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$3223232</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$45343</h4>

                                </td>
                                <td class="erp-tbody-td text-center">

                                    <h4 class="text-center d-table-title patial-status">Partial</h4>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">N/A</h4>
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
                                <td class="erp-tbody-td text-start">
                                    <h4 class="text-start d-table-title"><strong>PO -</strong> <span>10010032</span></h4>
                                    <small class="text-center d-table-title">1 Nov, 2023</small>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">1 Nov, 2023</h4>

                                </td>
                                <td class="erp-tbody-td">
                                    <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100 justify-content-center">
                                        <div class="em-pro-img-box">
                                            <img src="assets/img/profiles/office-building.png" alt="">
                                        </div>
                                        <div class="em-pro-details-box">
                                            <h5>Jamuna Group</h5>
                                        </div>
                                    </div>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">5</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$3223232</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$45343</h4>

                                </td>
                                <td class="erp-tbody-td text-center">

                                    <h4 class="text-center d-table-title paid-status">Paid</h4>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <a href="investigation.html" class="make-payment-btn">Investigation</a>
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
                                <td class="erp-tbody-td text-start">
                                    <h4 class="text-start d-table-title"><strong>PO -</strong> <span>10010032</span></h4>
                                    <small class="text-center d-table-title">1 Nov, 2023</small>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">1 Nov, 2023</h4>

                                </td>
                                <td class="erp-tbody-td">
                                    <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100 justify-content-center">
                                        <div class="em-pro-img-box">
                                            <img src="assets/img/profiles/office-building.png" alt="">
                                        </div>
                                        <div class="em-pro-details-box">
                                            <h5>Jamuna Group</h5>
                                        </div>
                                    </div>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">5</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$3223232</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$45343</h4>

                                </td>
                                <td class="erp-tbody-td text-center">

                                    <h4 class="text-center d-table-title paid-status">Paid</h4>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <a href="investigation.html" class="make-payment-btn">Investigation</a>
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
    <div class="tab-pane fade" id="deliver-purchase" role="tabpanel" aria-labelledby="deliver-purchase-tab">
        <div class="my-attendance-report-wrapper">
            <div class="big-table pt-4">
                <div class="de-table-wrapper">
                    <div class="table-responsive">
                        <table class="table mb-0 erp-table">
                            <thead class="erp-thead">
                            <tr class="erp-tr">
                                <th class="erp-th">SL</th>
                                <th class="erp-th">P.O No </th>
                                <th class="erp-th text-center">Supplier </th>
                                <th class="erp-th text-center">Product </th>
                                <th class="erp-th text-center">Total Amount </th>
                                <th class="erp-th text-center">Due Amount </th>
                                <th class="erp-th text-center">Investigation Status </th>
                                <th class="erp-th text-center">Payment Status </th>
                                <th class="text-end erp-th">Action</th>
                            </tr>
                            </thead>
                            <tbody class="erp-tbody">
                            <tr class="erp-tbody-tr">
                                <td class="erp-tbody-td">
                                    <h4 class="d-table-title">1</h4>
                                </td>
                                <td class="erp-tbody-td text-start">
                                    <h4 class="text-start d-table-title"><strong>PO -</strong> <span>10010032</span></h4>
                                    <small class="text-center d-table-title">1 Nov, 2023</small>
                                </td>

                                <td class="erp-tbody-td">
                                    <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100 justify-content-center">
                                        <div class="em-pro-img-box">
                                            <img src="assets/img/profiles/office-building.png" alt="">
                                        </div>
                                        <div class="em-pro-details-box">
                                            <h5>Jamuna Group</h5>
                                        </div>
                                    </div>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">5</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$3223232</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$45343</h4>

                                </td>
                                <td class="erp-tbody-td text-center">

                                    <h4 class="text-center d-table-title missing-status">Missing</h4>
                                    <h4 class="text-center d-table-title damage-status">Damage</h4>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title pending-status">Pending</h4>
                                </td>


                                <td class="text-end erp-tbody-td">
                                    <div class="erp-action-t">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="investigation.html" ><i class="fa-solid fa-circle-info m-r-5"></i> Received  (Damage / Missing)</a>
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
                                <td class="erp-tbody-td text-start">
                                    <h4 class="text-start d-table-title"><strong>PO -</strong> <span>10010032</span></h4>
                                    <small class="text-center d-table-title">1 Nov, 2023</small>
                                </td>

                                <td class="erp-tbody-td">
                                    <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100 justify-content-center">
                                        <div class="em-pro-img-box">
                                            <img src="assets/img/profiles/office-building.png" alt="">
                                        </div>
                                        <div class="em-pro-details-box">
                                            <h5>Jamuna Group</h5>
                                        </div>
                                    </div>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">5</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$3223232</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$45343</h4>

                                </td>
                                <td class="erp-tbody-td text-center">

                                    <h4 class="text-center d-table-title damage-status">Damage Issue</h4>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title pending-status">Pending</h4>
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
                                <td class="erp-tbody-td text-start">
                                    <h4 class="text-start d-table-title"><strong>PO -</strong> <span>10010032</span></h4>
                                    <small class="text-center d-table-title">1 Nov, 2023</small>
                                </td>

                                <td class="erp-tbody-td">
                                    <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100 justify-content-center">
                                        <div class="em-pro-img-box">
                                            <img src="assets/img/profiles/office-building.png" alt="">
                                        </div>
                                        <div class="em-pro-details-box">
                                            <h5>Jamuna Group</h5>
                                        </div>
                                    </div>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">5</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$3223232</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$45343</h4>

                                </td>
                                <td class="erp-tbody-td text-center">

                                    <h4 class="text-center d-table-title perfect-status">Perfect</h4>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title complete-status">Complete</h4>
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
                                <td class="erp-tbody-td text-start">
                                    <h4 class="text-start d-table-title"><strong>PO -</strong> <span>10010032</span></h4>
                                    <small class="text-center d-table-title">1 Nov, 2023</small>
                                </td>

                                <td class="erp-tbody-td">
                                    <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100 justify-content-center">
                                        <div class="em-pro-img-box">
                                            <img src="assets/img/profiles/office-building.png" alt="">
                                        </div>
                                        <div class="em-pro-details-box">
                                            <h5>Jamuna Group</h5>
                                        </div>
                                    </div>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">5</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$3223232</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$45343</h4>

                                </td>
                                <td class="erp-tbody-td text-center">

                                    <h4 class="text-center d-table-title perfect-status">Perfect</h4>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title complete-status">Complete</h4>

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
    <div class="tab-pane fade" id="revised-purchase" role="tabpanel" aria-labelledby="revised-purchase-tab">
        <div class="my-attendance-report-wrapper">
            <div class="big-table pt-4">
                <div class="de-table-wrapper">
                    <div class="table-responsive">
                        <table class="table mb-0 erp-table">
                            <thead class="erp-thead">
                            <tr class="erp-tr">
                                <th class="erp-th">SL</th>
                                <th class="erp-th">RPO No </th>
                                <th class="erp-th text-center">Estimate Delivery Date </th>
                                <th class="erp-th text-center">Supplier </th>
                                <th class="erp-th text-center">Product </th>
                                <th class="erp-th text-center">Total Amount </th>
                                <th class="erp-th text-center">Due Amount </th>
                                <th class="erp-th text-center">Payment Status </th>
                                <th class="erp-th text-center">Record Payment </th>
                                <th class="text-end erp-th">Action</th>
                            </tr>
                            </thead>
                            <tbody class="erp-tbody">
                            <tr class="erp-tbody-tr">
                                <td class="erp-tbody-td">
                                    <h4 class="d-table-title">1</h4>
                                </td>
                                <td class="erp-tbody-td text-start">
                                    <h4 class="text-start d-table-title"><strong>RPO -</strong> <span>10010032</span></h4>
                                    <small class="text-center d-table-title">1 Nov, 2023</small>
                                    <div class="revised-status">
                                        <span class="revised-status-text">Revised Order</span>
                                    </div>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">1 Nov, 2023</h4>

                                </td>
                                <td class="erp-tbody-td">
                                    <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100 justify-content-center">
                                        <div class="em-pro-img-box">
                                            <img src="assets/img/profiles/office-building.png" alt="">
                                        </div>
                                        <div class="em-pro-details-box">
                                            <h5>Jamuna Group</h5>
                                        </div>
                                    </div>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">5</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$3223232</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$45343</h4>

                                </td>
                                <td class="erp-tbody-td text-center">

                                    <h4 class="text-center d-table-title unpaid-status">Unpaid</h4>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <a href="#" class="make-payment-btn" data-bs-toggle="modal" data-bs-target="#make-payment">Make Payment</a>
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
                                <td class="erp-tbody-td text-start">
                                    <h4 class="text-start d-table-title"><strong>RPO1 -</strong> <span>10010032</span></h4>
                                    <small class="text-center d-table-title">1 Nov, 2023</small>
                                    <div class="revised-status">
                                        <span class="revised-status-text">Revised Order</span>
                                    </div>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">1 Nov, 2023</h4>

                                </td>
                                <td class="erp-tbody-td">
                                    <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100 justify-content-center">
                                        <div class="em-pro-img-box">
                                            <img src="assets/img/profiles/office-building.png" alt="">
                                        </div>
                                        <div class="em-pro-details-box">
                                            <h5>Jamuna Group</h5>
                                        </div>
                                    </div>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">5</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$3223232</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$45343</h4>

                                </td>
                                <td class="erp-tbody-td text-center">

                                    <h4 class="text-center d-table-title unpaid-status">Unpaid</h4>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <a href="#" class="make-payment-btn" data-bs-toggle="modal" data-bs-target="#make-payment">Make Payment</a>
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
                                <td class="erp-tbody-td text-start">
                                    <h4 class="text-start d-table-title"><strong>RPO -</strong> <span>10010032</span></h4>
                                    <small class="text-center d-table-title">1 Nov, 2023</small>
                                    <div class="revised-status">
                                        <span class="revised-status-text">Revised Order</span>
                                    </div>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">1 Nov, 2023</h4>

                                </td>
                                <td class="erp-tbody-td">
                                    <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100 justify-content-center">
                                        <div class="em-pro-img-box">
                                            <img src="assets/img/profiles/office-building.png" alt="">
                                        </div>
                                        <div class="em-pro-details-box">
                                            <h5>Jamuna Group</h5>
                                        </div>
                                    </div>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">5</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$3223232</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$45343</h4>

                                </td>
                                <td class="erp-tbody-td text-center">

                                    <h4 class="text-center d-table-title unpaid-status">Unpaid</h4>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <a href="#" class="make-payment-btn" data-bs-toggle="modal" data-bs-target="#make-payment">Make Payment</a>
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
                                <td class="erp-tbody-td text-start">
                                    <h4 class="text-start d-table-title"><strong>RPO -</strong> <span>10010032</span></h4>
                                    <small class="text-center d-table-title">1 Nov, 2023</small>
                                    <div class="revised-status">
                                        <span class="revised-status-text">Revised Order</span>
                                    </div>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">1 Nov, 2023</h4>

                                </td>
                                <td class="erp-tbody-td">
                                    <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100 justify-content-center">
                                        <div class="em-pro-img-box">
                                            <img src="assets/img/profiles/office-building.png" alt="">
                                        </div>
                                        <div class="em-pro-details-box">
                                            <h5>Jamuna Group</h5>
                                        </div>
                                    </div>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">5</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$3223232</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$45343</h4>

                                </td>
                                <td class="erp-tbody-td text-center">

                                    <h4 class="text-center d-table-title unpaid-status">unpaid</h4>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <a href="#" class="make-payment-btn" data-bs-toggle="modal" data-bs-target="#make-payment">Make Payment</a>
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
    <div class="tab-pane fade" id="back-purchase" role="tabpanel" aria-labelledby="back-purchase-tab">
        <div class="my-attendance-report-wrapper">
            <div class="big-table pt-4">
                <div class="de-table-wrapper">
                    <div class="table-responsive">
                        <table class="table mb-0 erp-table">
                            <thead class="erp-thead">
                            <tr class="erp-tr">
                                <th class="erp-th">SL</th>
                                <th class="erp-th">BPO No </th>
                                <th class="erp-th text-center">Estimate Delivery Date </th>
                                <th class="erp-th text-center">Supplier </th>
                                <th class="erp-th text-center">Product </th>
                                <th class="erp-th text-center">Total Amount </th>
                                <th class="erp-th text-center">Due Amount </th>
                                <th class="erp-th text-center">Payment Status </th>
                                <th class="erp-th text-center">Record Payment </th>
                                <th class="text-end erp-th">Action</th>
                            </tr>
                            </thead>
                            <tbody class="erp-tbody">
                            <tr class="erp-tbody-tr">
                                <td class="erp-tbody-td">
                                    <h4 class="d-table-title">1</h4>
                                </td>
                                <td class="erp-tbody-td text-start">
                                    <h4 class="text-start d-table-title"><strong>BPO -</strong> <span>10010032</span></h4>
                                    <small class="text-center d-table-title">1 Nov, 2023</small>
                                    <div class="back-order-status">
                                        <span>Back Order</span>
                                    </div>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">1 Nov, 2023</h4>

                                </td>
                                <td class="erp-tbody-td">
                                    <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100 justify-content-center">
                                        <div class="em-pro-img-box">
                                            <img src="assets/img/profiles/office-building.png" alt="">
                                        </div>
                                        <div class="em-pro-details-box">
                                            <h5>Jamuna Group</h5>
                                        </div>
                                    </div>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">5</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$3223232</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$45343</h4>

                                </td>
                                <td class="erp-tbody-td text-center">

                                    <h4 class="text-center d-table-title unpaid-status">Unpaid</h4>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <a href="#" class="make-payment-btn">Make Payment</a>
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
                                <td class="erp-tbody-td text-start">
                                    <h4 class="text-start d-table-title"><strong>BPO1 -</strong> <span>10010032</span></h4>
                                    <small class="text-center d-table-title">1 Nov, 2023</small>
                                    <div class="back-order-status">
                                        <span>Back Order</span>
                                    </div>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">1 Nov, 2023</h4>

                                </td>
                                <td class="erp-tbody-td">
                                    <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100 justify-content-center">
                                        <div class="em-pro-img-box">
                                            <img src="assets/img/profiles/office-building.png" alt="">
                                        </div>
                                        <div class="em-pro-details-box">
                                            <h5>Jamuna Group</h5>
                                        </div>
                                    </div>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">5</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$3223232</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$45343</h4>

                                </td>
                                <td class="erp-tbody-td text-center">

                                    <h4 class="text-center d-table-title patial-status">Partial</h4>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <a href="#" class="make-payment-btn">Make Payment</a>
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
                                <td class="erp-tbody-td text-start">
                                    <h4 class="text-start d-table-title"><strong>BPO -</strong> <span>10010032</span></h4>
                                    <small class="text-center d-table-title">1 Nov, 2023</small>
                                    <div class="back-order-status">
                                        <span>Back Order</span>
                                    </div>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">1 Nov, 2023</h4>

                                </td>
                                <td class="erp-tbody-td">
                                    <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100 justify-content-center">
                                        <div class="em-pro-img-box">
                                            <img src="assets/img/profiles/office-building.png" alt="">
                                        </div>
                                        <div class="em-pro-details-box">
                                            <h5>Jamuna Group</h5>
                                        </div>
                                    </div>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">5</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$3223232</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$45343</h4>

                                </td>
                                <td class="erp-tbody-td text-center">

                                    <h4 class="text-center d-table-title unpaid-status">Unpaid</h4>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <a href="#" class="make-payment-btn">Make Payment</a>
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
                                <td class="erp-tbody-td text-start">
                                    <h4 class="text-start d-table-title"><strong>BPO -</strong> <span>10010032</span></h4>
                                    <small class="text-center d-table-title">1 Nov, 2023</small>
                                    <div class="back-order-status">
                                        <span>Back Order</span>
                                    </div>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">1 Nov, 2023</h4>

                                </td>
                                <td class="erp-tbody-td">
                                    <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100 justify-content-center">
                                        <div class="em-pro-img-box">
                                            <img src="assets/img/profiles/office-building.png" alt="">
                                        </div>
                                        <div class="em-pro-details-box">
                                            <h5>Jamuna Group</h5>
                                        </div>
                                    </div>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">5</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$3223232</h4>

                                </td>
                                <td class="erp-tbody-td text-center">
                                    <h4 class="text-center d-table-title">$45343</h4>

                                </td>
                                <td class="erp-tbody-td text-center">

                                    <h4 class="text-center d-table-title paid-status">Paid</h4>
                                </td>
                                <td class="erp-tbody-td text-center">
                                    <a href="#" class="make-payment-btn">Make Payment</a>
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
