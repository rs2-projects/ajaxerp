@extends('layouts.layout')
@section('content')

    <!-- Container-fluid starts-->
    <div class="container-fluid default-dashboard">
        <div class="row">
            <div class="col-xl-4 col-xl-100 box-col-12 ps-4 pe-4 left-background">
                <div class="row bg-light p-3 pt-4 pb-4 align-items-start">
                    <div class="col-12 col-xl-50 box-col-6">
                        <div class="card welcome-card">
                            <div class="card-body">
                                <div class="d-flex flex-wrap">
                                    <div class="flex-grow-1 col-md-6 col-12 custom-p-1200 mb-3">
                                        <h1>Hello, Ramirez</h1>
                                        <p>Welcome back! Let's start from where you left.</p><a class="btn"
                                                                                                href="#">View Profile</a>
                                    </div>
                                    <div class="flex-shrink-0 col-md-6 col-12 custom-p-1200"> <img
                                            src="{{ asset('assets/img/welcome1.png') }}" alt=""></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card sales">
                            <div class="card-header card-no-border pb-0">
                                <div class="header-top d-flex justify-content-between align-items-center">
                                    <h4>Raw Material Stock</h4>
                                    <div class="dropdown icon-dropdown rs-icon-dropdown">
                                        <button class="btn dropdown-toggle" id="userdropdown2" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false"><i class="la la-ellipsis-v
										"></i></button>
                                        <div class="dropdown-menu dropdown-menu-end"
                                             aria-labelledby="userdropdown2"><a class="dropdown-item"
                                                                                href="#">Weekly</a><a class="dropdown-item"
                                                                                                      href="#">Monthly</a><a class="dropdown-item"
                                                                                                                             href="#">Yearly</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="sales-chart"></div>
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-2"><span class="bg-primary"></span></div>
                                    <div class="flex-grow-1 me-2">
                                        <h5>Enough Stock</h5>
                                    </div>
                                    <div class="flex-shrink-0 me-2"><span class="bg-orange-primary"></span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5>Low Stock</h5>
                                    </div>
                                    <div class="flex-shrink-0 me-2"><span class="bg-red-primary"></span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5>Danger Limit</h5>
                                    </div>
                                </div>
                                <p>Keep up info updated to increase the number of ionteractions</p>
                                <button class="btn">See more</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label class="custom-sa-title two">Procurement</label>
                    </div>
                    <div class="col-12 box-col-6">
                        <div class="row procurement-dash ">
                            <div class="col-md-12">
                                <label class="custom-sa-title three">Purchase Order (Production Marerial)</label>
                            </div>
                            <div class="col-xxl-6 col-sm-12 ">
                                <div class="card since mb-3">
                                    <div class="card-body">
                                        <div class="customer-card d-flex b-l-primary border-2">
                                            <div class="ms-3">
                                                <h3 class="mt-1">New Purchase Order</h3>
                                                <h5 class="mt-1">143</h5>
                                            </div>
                                            <div class="dashboard-user bg-light-primary">
                                                <span><i class="la la-share-alt"></i></span>
                                            </div>
                                        </div>
                                        <div class="customer mt-2">
														<span class="me-1">
															<i class="la la-long-arrow-up"></i>
														</span>
                                            <span class="font-success me-2">+ 4.6%</span><span>Since last
															Week</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-sm-12 ">
                                <div class="card since mb-3">
                                    <div class="card-body money">
                                        <div class="customer-card d-flex b-l-secondary border-2">
                                            <div class="ms-3">
                                                <h3 class="mt-1">On-Process</h3>
                                                <h5 class="mt-1">6534</h5>
                                            </div>
                                            <div class="dashboard-user bg-light-secondary">
                                                <span><i class="la la-money"></i></span>

                                            </div>
                                        </div>
                                        <div class="customer mt-2"><span class="me-1">
															<i class="la la-long-arrow-up"></i></span><span
                                                class="font-success me-2">+ 3.10%</span><span>Since last Week</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="custom-sa-title three">Purchase Requests (Assets)</label>
                            </div>
                            <div class="col-xxl-6 col-sm-12 ">
                                <div class="card since mb-3">
                                    <div class="card-body">
                                        <div class="customer-card d-flex b-l-primary border-2">
                                            <div class="ms-3">
                                                <h3 class="mt-1">New Purchase Request</h3>
                                                <h5 class="mt-1">143</h5>
                                            </div>
                                            <div class="dashboard-user bg-light-primary">
                                                <span><i class="la la-share-alt"></i></span>
                                            </div>
                                        </div>
                                        <div class="customer mt-2">
														<span class="me-1">
															<i class="la la-long-arrow-up"></i>
														</span>
                                            <span class="font-success me-2">+ 4.6%</span><span>Since last
															Week</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-sm-12 ">
                                <div class="card since mb-3">
                                    <div class="card-body invoice-profit">
                                        <div class="customer-card d-flex b-l-success border-2">
                                            <div class="ms-3">
                                                <h3 class="mt-1">Info Submitted</h3>
                                                <h5 class="mt-1">14</h5>

                                            </div>
                                            <div class="dashboard-user bg-light-success"><span><i class="la la-file-pdf-o"></i></span>
                                            </div>
                                        </div>
                                        <div class="customer mt-2"><span class="me-1">
															<i class="la la-long-arrow-down"></i></span><span class="font-success me-2">+ 6.3%</span><span>Since last Week</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="custom-sa-title three">Purchase Order (Assets)</label>
                            </div>
                            <div class="col-xxl-6 col-sm-12">
                                <div class="card since mb-0">
                                    <div class="card-body">
                                        <div class="customer-card d-flex b-l-primary border-2">
                                            <div class="ms-3">
                                                <h3 class="mt-1">New Purchase Order</h3>
                                                <h5 class="mt-1">143</h5>
                                            </div>
                                            <div class="dashboard-user bg-light-primary">
                                                <span><i class="la la-share-alt"></i></span>
                                            </div>
                                        </div>
                                        <div class="customer mt-2">
														<span class="me-1">
															<i class="la la-long-arrow-up"></i>
														</span>
                                            <span class="font-success me-2">+ 4.6%</span><span>Since last
															Week</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-sm-12">
                                <div class="card since mb-0">
                                    <div class="card-body money">
                                        <div class="customer-card d-flex b-l-secondary border-2">
                                            <div class="ms-3">
                                                <h3 class="mt-1">On-Process</h3>
                                                <h5 class="mt-1">6534</h5>
                                            </div>
                                            <div class="dashboard-user bg-light-secondary">
                                                <span><i class="la la-money"></i></span>

                                            </div>
                                        </div>
                                        <div class="customer mt-2"><span class="me-1">
															<i class="la la-long-arrow-up"></i></span><span
                                                class="font-success me-2">+ 3.10%</span><span>Since last Week</span>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>

                    </div>



                </div>
            </div>
            <div class="col-xl-8 col-xl-100 box-col-12">
                <div class="row">
                    <div class="col-xxl-4 col-sm-4 order-xxl-0 order-sm-1 ">
                        <div class="card order-overview">
                            <div class="card-header pb-0">
                                <div class="header-top d-flex justify-content-between align-items-center">
                                    <h4>Invoice</h4>
                                    <div class="dropdown icon-dropdown rs-icon-dropdown">
                                        <button class="btn dropdown-toggle" id="userdropdown2" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false"><i class="la la-ellipsis-v
										  "></i></button>
                                        <div class="dropdown-menu dropdown-menu-end"
                                             aria-labelledby="userdropdown2"><a class="dropdown-item"
                                                                                href="#">Weekly</a><a class="dropdown-item"
                                                                                                      href="#">Monthly</a><a class="dropdown-item"
                                                                                                                             href="#">Yearly</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="total-revenue">
                                    <div class="invoice-chart">
                                        <h5 class="me-2">₱ 0.00</h5>
                                        <p>Total 0 Invoices</p>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-primary" role="progressbar"
                                             style="width: 50%" aria-valuenow="10" aria-valuemin="0"
                                             aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="total-revenue">
                                    <div class="invoice-chart total-collection-invoice">
                                        <h5 class="me-2">₱ 0.00</h5>
                                        <p>Total Collection From 0 Invoices</p>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-info" role="progressbar"
                                             style="width: 70%" aria-valuenow="10" aria-valuemin="0"
                                             aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="alhisab-overdue-footer text-end d-flex justify-content-end al-custom-vendor-item-wrapper">
                                    <a href="#" class="view-all-link expense-breakdown-card-href">View All</a>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-8 col-sm-8 order-xxl-1 order-sm-2 ">
                        <div class="card sales overview">
                            <div class="card-header card-no-border pb-0">
                                <div class="header-top d-flex justify-content-between align-items-center">
                                    <h4>Revenue</h4>
                                    <div class="dropdown icon-dropdown rs-icon-dropdown">
                                        <button class="btn dropdown-toggle" id="userdropdown2" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false"><i class="la la-ellipsis-v
										"></i></button>
                                        <div class="dropdown-menu dropdown-menu-end"
                                             aria-labelledby="userdropdown2"><a class="dropdown-item"
                                                                                href="#">Weekly</a><a class="dropdown-item"
                                                                                                      href="#">Monthly</a><a class="dropdown-item"
                                                                                                                             href="#">Yearly</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="sales-chart">

                                    <div id="chart-widget7"></div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-sm-6 order-xxl-2 order-sm-3 ">
                        <div class="card categories-chart">
                            <div class="card-header pb-0">
                                <div class="header-top d-flex justify-content-between align-items-center">
                                    <h4>Expense Breakdown</h4>
                                    <div class="dropdown icon-dropdown rs-icon-dropdown">
                                        <button class="btn dropdown-toggle" id="userdropdown2" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false"><i class="la la-ellipsis-v
										  "></i></button>
                                        <div class="dropdown-menu dropdown-menu-end"
                                             aria-labelledby="userdropdown2"><a class="dropdown-item"
                                                                                href="#">Weekly</a><a class="dropdown-item"
                                                                                                      href="#">Monthly</a><a class="dropdown-item"
                                                                                                                             href="#">Yearly</a></div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-xxl-6 col-sm-12 p-0">
                                        <div id="Categories-chart"></div>
                                    </div>
                                    <div class="col-xxl-6 col-sm-12 categories-sales">
                                        <div class="d-flex gap-2">
                                            <div class="flex-shrink-0"><span class="l-bg-primary"> </span></div>
                                            <div class="flex-grow-1">
                                                <h6>Income</h6>
                                            </div>
                                            <h5>$21,654</h5>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <div class="flex-shrink-0"><span class="b-bg-secondary"> </span></div>
                                            <div class="flex-grow-1">
                                                <h6>Visitors</h6>
                                            </div>
                                            <h5>$62,842</h5>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <div class="flex-shrink-0"><span class="e-bg-danger"> </span></div>
                                            <div class="flex-grow-1">
                                                <h6>Expense</h6>
                                            </div>
                                            <h5>$37,210</h5>
                                        </div>
                                        <div class="d-flex gap-2 justify-content-end">

                                            <div class="flex-grow-o">
                                                <a href="#" class="a-view-all-link">View All</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="total-earn">
                                    <h2>$3,512,201</h2>
                                    <h6>Total Earned</h6>
                                </div>
                                <div class="earned" id="Earned-chart"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-8 col-sm-12 order-xxl-3 order-sm-5 ">
                        <div class="card leads">
                            <div class="card-header card-no-border pb-0">
                                <div class="header-top d-flex justify-content-between">
                                    <h4>Cash Flow </h4>
                                    <div class="dropdown icon-dropdown rs-icon-dropdown">
                                        <button class="btn dropdown-toggle" id="userdropdown2" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="la la-ellipsis-v
													"></i></button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userdropdown2"><a class="dropdown-item" href="#">Weekly</a><a class="dropdown-item" href="#">Monthly</a><a class="dropdown-item" href="#">Yearly</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">

                                <div id="area-spaline"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-sm-6 order-xxl-4 order-sm-4 ">
                        <div class="card">
                            <div class="card-header card-no-border pb-0">
                                <div class="header-top d-flex justify-content-between">
                                    <h4>CASH & BANK</h4>
                                    <div class="dropdown icon-dropdown rs-icon-dropdown">
                                        <button class="btn dropdown-toggle" id="userdropdown2"
                                                type="button" data-bs-toggle="dropdown"
                                                aria-expanded="false"><i class="la la-ellipsis-v"></i></button>
                                        <div class="dropdown-menu dropdown-menu-end"
                                             aria-labelledby="userdropdown2"><a
                                                class="dropdown-item" href="#">Weekly</a><a
                                                class="dropdown-item" href="#">Monthly</a><a
                                                class="dropdown-item" href="#">Yearly</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body active-task">
                                <div class="er-cashbank-body er-scrollbar" id="cash-and-bank-data">
                                    <div class="al-cashbank-item-wrapper">
                                        <h4>Cash on Hand</h4>
                                        <p>Account Balance: <strong>৳ -1,628,873.55</strong></p>
                                        <span>Last Transactions Mar 20, 2024</span>
                                    </div>

                                    <div class="al-cashbank-item-wrapper">
                                        <h4>Knitting</h4>
                                        <p>Account Balance: <strong>৳ 890,500.00</strong></p>
                                        <span>Last Transactions Oct 24, 2023</span>
                                    </div>

                                    <div class="al-cashbank-item-wrapper">
                                        <h4>Dutch Bangla Bank Ltd</h4>
                                        <p>Account Balance: <strong>৳ 566,750.00</strong></p>
                                        <span>Last Transactions Mar 20, 2024</span>
                                    </div>
                                </div>
                                <div class="alhisab-overdue-footer text-end mt-2">
                                    <a href="#" class="view-all-link">View All</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-8 col-sm-12 order-xl-5 order-sm-6 ">
                        <div class="card">
                            <div class="card-header card-no-border pb-0">
                                <div class="header-top d-flex justify-content-between align-items-center">
                                    <h4>Recent Order</h4>
                                    <div class="dropdown icon-dropdown rs-icon-dropdown">
                                        <button class="btn dropdown-toggle" id="userdropdown2" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false"><i class="la la-ellipsis-v
										"></i></button>
                                        <div class="dropdown-menu dropdown-menu-end"
                                             aria-labelledby="userdropdown2"><a class="dropdown-item"
                                                                                href="#">Weekly</a><a class="dropdown-item"
                                                                                                      href="#">Monthly</a><a class="dropdown-item"
                                                                                                                             href="#">Yearly</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0 recent">
                                <div class="table-responsive custom-scrollbar">
                                    <table class="table display" id="resent-order" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th class="ps-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                           value="">
                                                    <label class="form-check-label"></label>
                                                </div>
                                            </th>
                                            <th>Customers name</th>
                                            <th>Order Date</th>
                                            <th>Items Name</th>
                                            <th>Price</th>
                                            <th class="text-center">Status </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                           value="">
                                                    <label class="form-check-label"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex">

                                                    <div class="flex-grow-1 ms-2"><a href="#">
                                                            <h6>Elle Amberson</h6><span>#Gh3649K</span>
                                                        </a></div>
                                                </div>
                                            </td>
                                            <td>
                                                <h6>15 Nov, 2022</h6><span>02:45 PM</span>
                                            </td>
                                            <td>Wood Chair</td>
                                            <td>$152</td>
                                            <td class="text-center">
                                                <span class="badge rs-badge">Paid</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                           value="">
                                                    <label class="form-check-label"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex">

                                                    <div class="flex-grow-1 ms-2"><a href="#">
                                                            <h6>Anna Catmire</h6><span>#A5647KB</span>
                                                        </a></div>
                                                </div>
                                            </td>
                                            <td>
                                                <h6>25 Nov, 2022</h6><span>01:24 PM</span>
                                            </td>
                                            <td>Men Sneakers</td>
                                            <td>$652</td>
                                            <td class="text-center">
                                                <span class="badge rs-badge">Pending</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                           value="">
                                                    <label class="form-check-label"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex">

                                                    <div class="flex-grow-1 ms-2"><a href="#">
                                                            <h6>Laura Dagson</h6><span>#KO093M</span>
                                                        </a></div>
                                                </div>
                                            </td>
                                            <td>
                                                <h6>26 Nov, 2022</h6><span>12:34 PM</span>
                                            </td>
                                            <td>Tree Stylish </td>
                                            <td>$256</td>
                                            <td class="text-center">
                                                <span class="badge rs-badge">Paid</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                           value="">
                                                    <label class="form-check-label"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex">

                                                    <div class="flex-grow-1 ms-2"><a href="#">
                                                            <h6>Rachel Green</h6><span>#KMG403</span>
                                                        </a></div>
                                                </div>
                                            </td>
                                            <td>
                                                <h6>28 Nov, 2022</h6><span>10:27 PM</span>
                                            </td>
                                            <td>Mi Watch</td>
                                            <td>$659</td>
                                            <td class="text-center">
                                                <span class="badge rs-badge">Overdue</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                           value="">
                                                    <label class="form-check-label"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex">

                                                    <div class="flex-grow-1 ms-2"><a href="#">
                                                            <h6>Rachel Green</h6><span>#KMG403</span>
                                                        </a></div>
                                                </div>
                                            </td>
                                            <td>
                                                <h6>28 Nov, 2022</h6><span>10:27 PM</span>
                                            </td>
                                            <td>Mi Watch</td>
                                            <td>$659</td>
                                            <td class="text-center">
                                                <span class="badge rs-badge">Overdue</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                           value="">
                                                    <label class="form-check-label"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex">

                                                    <div class="flex-grow-1 ms-2"><a href="#">
                                                            <h6>Rachel Green</h6><span>#KMG403</span>
                                                        </a></div>
                                                </div>
                                            </td>
                                            <td>
                                                <h6>28 Nov, 2022</h6><span>10:27 PM</span>
                                            </td>
                                            <td>Mi Watch</td>
                                            <td>$659</td>
                                            <td class="text-center">
                                                <span class="badge rs-badge">Overdue</span>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-12 col-sm-12 order-last ">
                        <label class="custom-sa-title">Production </label>
                    </div>
                    <div class="col-xxl-4 col-sm-6 order-last ">
                        <div class="card since">
                            <div class="card-body money">
                                <div class="customer-card d-flex b-l-secondary border-2">
                                    <div class="ms-3">
                                        <h3 class="mt-1">Queue</h3>
                                        <h5 class="mt-1">6534</h5>
                                    </div>
                                    <div class="dashboard-user bg-light-secondary">
                                        <span><i class="la la-cubes"></i></span>

                                    </div>
                                </div>
                                <div class="customer mt-2"><span class="me-1">
													<i class="la la-long-arrow-up"></i></span><span
                                        class="font-success me-2">+ 3.10%</span><span>Since last Week</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-sm-6 order-last ">
                        <div class="card since">
                            <div class="card-body money">
                                <div class="customer-card d-flex b-l-secondary border-2">
                                    <div class="ms-3">
                                        <h3 class="mt-1">On-Process</h3>
                                        <h5 class="mt-1">6534</h5>
                                    </div>
                                    <div class="dashboard-user bg-light-secondary">
                                        <span><i class="la la-cubes"></i></span>

                                    </div>
                                </div>
                                <div class="customer mt-2"><span class="me-1">
													<i class="la la-long-arrow-up"></i></span><span
                                        class="font-success me-2">+ 3.10%</span><span>Since last Week</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-sm-6 order-last ">
                        <div class="card since">
                            <div class="card-body money">
                                <div class="customer-card d-flex b-l-secondary border-2">
                                    <div class="ms-3">
                                        <h3 class="mt-1">Completed</h3>
                                        <h5 class="mt-1">6534</h5>
                                    </div>
                                    <div class="dashboard-user bg-light-secondary">
                                        <span><i class="la la-cubes"></i></span>

                                    </div>
                                </div>
                                <div class="customer mt-2"><span class="me-1">
													<i class="la la-long-arrow-up"></i></span><span
                                        class="font-success me-2">+ 3.10%</span><span>Since last Week</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection


@section('css_plugins')
    <link rel="stylesheet" href="{{ asset('assets/css/external-css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/external-css/superadmin.css') }}">
@endsection

@section('js_plugins')
    <!-- Apex Chart -->
    <script src="{{ asset('assets') }}/plugins/chart/apex-chart/apex-chart.js"></script>
    <script src="{{ asset('assets') }}/plugins/chart/apex-chart/moment.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/chart/apex-chart/stock-prices.js"></script>


    <script src="{{ asset('assets') }}/js/default.js"></script>
    <script src="{{ asset('assets') }}/js/chart-widget.js"></script>
    <script src="{{ asset('assets') }}/plugins/chart/apex-chart/chart-custom.js"></script>


@endsection
