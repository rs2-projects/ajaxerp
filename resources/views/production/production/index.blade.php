@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
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
                                            <input type="text" id="keyword_filtered" class="form-control search-product-in" placeholder="Product Search">
                                        </div>
                                    </div>
                                    <div class="erp-filter-item"> 
                                        <div class="erp-search-btn-wrap">
                                            <button class=" erp-search-btn" onclick="getData()">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <ul class="nav nav-tabs erp-nav-tabs justify-content-center status_type" id="myTab" role="tablist">
                            <li class="nav-item erp-nav-item" role="presentation">
                                <button class="nav-link active erp-nav-link" data="pre_production" id="all-purchase-tab" data-bs-toggle="tab" data-bs-target="#all-purchase" type="button" role="tab" aria-controls="home" aria-selected="true">Pre-Production</button>
                            </li>
                            <li class="nav-item erp-nav-item" role="presentation">
                                <button class="nav-link erp-nav-link" data="pending_for_receive" id="new-purchase-tab" data-bs-toggle="tab" data-bs-target="#new-purchase" type="button" role="tab" aria-controls="profile" aria-selected="false">Pending For Receive</button>
                            </li>
                            <li class="nav-item erp-nav-item" role="presentation">
                                <button class="nav-link erp-nav-link" data="on_process" id="process-purchase-tab" data-bs-toggle="tab" data-bs-target="#process-purchase" type="button" role="tab" aria-controls="contact" aria-selected="false">On-Process</button>
                            </li>
                            <li class="nav-item erp-nav-item" role="presentation">
                                <button class="nav-link erp-nav-link" data="completed" id="deliver-purchase-tab" data-bs-toggle="tab" data-bs-target="#deliver-purchase" type="button" role="tab" aria-controls="contact" aria-selected="false">Completed</button>
                            </li>
                        </ul>

                    
                        <div class="my-attendance-report-wrapper" id="ajax-data-load">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

    </div>
    <!--End::row-1 -->

    <!-- Design of Document modal -->
    <div id="designOfDocumentModal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header erp-modal-header">
                    <h5 class="modal-title">Design of Documents</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body erp-modal-body" id="desgin_of_document_modal_content">
                    
                </div>
            </div>
        </div>
    </div>
    <!-- status info modal -->
    <div id="check_in_status" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header erp-modal-header">
                    <h5 class="modal-title">Inventory Status Checking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body erp-modal-body">
                <div class="erp-modal-body-content">
                    
                        <div class="my-attendance-report-wrapper">
                            <div class="big-table">
                                <div class="de-table-wrapper">
                                    <div class="table-responsive">
                                        <table class="table mb-0 erp-table">
                                            <thead class="erp-thead">
                                                <tr class="erp-tr">
                                                    
                                                    <th class="erp-th">Category </th>
                                                    <th class="erp-th text-center">Item Name </th>
                                                    <th class="erp-th text-center">Qty </th>
                                                    <th class="text-center erp-th">Given</th>
                                                    <th class="text-center erp-th">Received</th>
                                                    
                                                    
                                                </tr>
                                            </thead>
                                            <tbody class="erp-tbody">
                                                <tr class="erp-tbody-tr">
                                                    <td class="erp-tbody-td text-start">
                                                        <h4 class="text-start d-table-title">Pin</h4>
                                                    </td>
                                                    <td class="erp-tbody-td text-center">
                                                        <h4 class="text-center d-table-title">8 m.m</h4>
                                                    </td>
                                                    <td class="erp-tbody-td text-center">
                                                        <h4 class="text-center d-table-title">10</h4>
                                                    </td>
                                                    
                                                
                                                    
                                                    <td class="erp-tbody-td text-center">
                                                        <h4 class="text-center d-table-title">1440</h4>
                                                    </td>
                                                    <td class="erp-tbody-td text-center">
                                                        <h4 class="text-center d-table-title">4410</h4>
                                                    </td>
                                                    
                                                </tr>
                                                <tr class="erp-tbody-tr">
                                                    <td class="erp-tbody-td text-start">
                                                        <h4 class="text-start d-table-title">Pin</h4>
                                                    </td>
                                                    <td class="erp-tbody-td text-center">
                                                        <h4 class="text-center d-table-title">10 m.m</h4>
                                                    </td>
                                                    <td class="erp-tbody-td text-center">
                                                        <h4 class="text-center d-table-title">10444</h4>
                                                    </td>
                                                    
                                                
                                                    
                                                    <td class="erp-tbody-td text-center">
                                                        <h4 class="text-center d-table-title">1440</h4>
                                                    </td>
                                                    <td class="erp-tbody-td text-center">
                                                        <h4 class="text-center d-table-title">4410</h4>
                                                    </td>
                                                    
                                                <tr class="erp-tbody-tr">
                                                    <td class="erp-tbody-td text-start">
                                                        <h4 class="text-start d-table-title">Glue</h4>
                                                    </td>
                                                    <td class="erp-tbody-td text-center">
                                                        <h4 class="text-center d-table-title">Master Glue</h4>
                                                    </td>
                                                    <td class="erp-tbody-td text-center">
                                                        <h4 class="text-center d-table-title">10444</h4>
                                                    </td>
                                                    
                                                
                                                    
                                                    <td class="erp-tbody-td text-center">
                                                        <h4 class="text-center d-table-title">1440</h4>
                                                    </td>
                                                    <td class="erp-tbody-td text-center">
                                                        <h4 class="text-center d-table-title">4410</h4>
                                                    </td>
                                                    
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modals')
    
@endsection

@section('css')
    <style>
        .erp-table-status.pre-delivered-s .action-icon {
            background: #37b34a;
        }
        .pd-table-box-item {
            margin-top: 24px;
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
            status_filtered: 'pre_production',
        };
        $(document).ready(function() {
            getData();
            filterData.keyword_filtered = $("#keyword_filtered").val()
            $("#keyword_filtered").on('input', function () {
                filterData.keyword_filtered = $(this).val();
            });

            $('.status_type li').on('click', function () {
                filterData.status_filtered = $('.status_type .active').attr('data');
                getData();
            });
        });

        function getData(){
            getPaginatedListData("{{ route('production.production.filtered') }}", "#ajax-data-load", filterData);
        }

        function getPaginatedData(button) {
            getPaginatedListData($(button).attr('data-href'), "#ajax-data-load", filterData);
        }

        function getDocunent(id){
            let url = "{{route('production.pre-production.get-design-document', ':id')}}";
            url = url.replace(':id', id);
            ajaxGet(url, {}, function (response) {
                if (response.status == 200) {
                    $("#desgin_of_document_modal_content").html(response.view);
                    $("#designOfDocumentModal").modal('show');
                } else {
                    toastr.error(response.message);
                }
            }, 'default');
        }
    </script>
@endsection


