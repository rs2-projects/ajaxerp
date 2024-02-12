@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
   <div class="row">
        <div class="erp-add-employee-wrapper mb-3">
            <div class="erp-add-employee">
                <a href="{{route('procurement.user.asset-purchase-request.create')}}" class="btn add-btn erp-add-employee ms-2" ><i class="fa-solid fa-plus"></i> New Purchase Request</a>
                <a href="#" class="btn add-btn erp-add-employee ms-2" ><i class="fa-regular fa-file-excel"></i> Export To Excel</a>
                <a href="#" class="btn add-btn erp-add-employee ms-2" ><i class="fa-regular fa-file-pdf"></i> Generate PDF</a>
            </div>
        </div>
        <div class="erp-employee-list-wrapper">
            <div class="erp-main-filter-wrapper bg-card attd-table">
                <div class="my-attendance-box-item flex-100 ">
                    <div class="my-attendance-report-wrapper">
                        <div class="erp-header-main-wrap d-flex justify-content-end align-items-center mb-4">
                        
                            <div class="erp-filter-box d-flex align-items-center justify-content-end flex-70">
                                
                                <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-end flex-100">
                                    <div class="erp-filter-item">
                                        <h6 class="me-2">Search By: </h6>
                                    </div>
                                    <div class="erp-filter-item flex-25"> 
                                        <div class=" form-focus select-focus custom-form-focus">
                                            <input type="text" class="form-control search-product-in" placeholder="Purchase Order">
                                        
                                        </div>
                                    </div>
                                    <div class="erp-filter-item flex-25"> 
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
                                    <div class="erp-filter-item flex-25"> 
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
                    
                        <div class="erp-leave-tab-wrapper">
                            <ul class="nav nav-tabs erp-nav-tabs justify-content-center status_type" id="myTab" role="tablist">
                                <li class="nav-item erp-nav-item" role="presentation">
                                    <button class="nav-link active erp-nav-link" data="all_requests" id="all-purchase-tab" data-bs-toggle="tab" data-bs-target="#all-purchase" type="button" role="tab" aria-controls="home" aria-selected="true">All Purchase Request</button>
                                </li>
                                <li class="nav-item erp-nav-item" role="presentation">
                                    <button class="nav-link erp-nav-link" data="new_requests" id="new-purchase-tab" data-bs-toggle="tab" data-bs-target="#new-purchase" type="button" role="tab" aria-controls="profile" aria-selected="false">New P.R</button>
                                </li>
                                <li class="nav-item erp-nav-item" role="presentation">
                                    <button class="nav-link erp-nav-link" data="pending_requests" id="process-purchase-tab" data-bs-toggle="tab" data-bs-target="#process-purchase" type="button" role="tab" aria-controls="contact" aria-selected="false">Pending P.R</button>
                                </li>
                                <li class="nav-item erp-nav-item" role="presentation">
                                    <button class="nav-link erp-nav-link" data="approved_requests" id="deliver-purchase-tab" data-bs-toggle="tab" data-bs-target="#deliver-purchase" type="button" role="tab" aria-controls="contact" aria-selected="false">Approved P.R</button>
                                </li>
                                <li class="nav-item erp-nav-item" role="presentation">
                                    <button class="nav-link erp-nav-link" data="declined_requests" id="revised-purchase-tab" data-bs-toggle="tab" data-bs-target="#revised-purchase" type="button" role="tab" aria-controls="contact" aria-selected="false">Declined P.R</button>
                                </li>
                                
                                </ul>

                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="all-purchase-tab">
                                        <div class="my-attendance-report-wrapper">
                                            <div class="big-table pt-4">
                                                <div class="de-table-wrapper" id="ajax-data-load">
    
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
    </div>
    <!--End::row-1 -->

    
@endsection

@section('modals')
   
@endsection

@section('css')
    <style> 
        .delete-btn-box.bank-info-remove {
            top: 10px;
        }
        .edit-img-src{
            margin-left: 5px;
            border-radius: 5px;
        }
    </style>
@endsection

@section('css_plugins')

@endsection

@section('js_plugins')

@endsection

@section('js')
    <script>
        var filterData = {
            keyword_filtered: '',
            status_filtered: 'all_requests'
        };
        $(document).ready(function() {
            getData();

            filterData.keyword_filtered = $("#keyword_filtered").val()
            $("#keyword_filtered").on('input', function () {
                filterData.keyword_filtered = $(this).val();
            }); 

            $('.status_type li').on('click', function () {
                filterData.status_filtered = $('.status_type .active').attr('data');
                console.log(filterData);
                getData();
            });
        });

        function getData(){
            getPaginatedListData("{{ route('procurement.user.asset-purchase-request.filtered') }}", "#ajax-data-load", filterData);
        }

        function getPaginatedData(button) {
            getPaginatedListData($(button).attr('data-href'), "#ajax-data-load", filterData);
        }
    </script>
@endsection


