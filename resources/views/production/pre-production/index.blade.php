@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        <div class="erp-add-employee-wrapper mb-3">
            <div class="erp-add-employee">
                <a href="{{route('production.pre-production.create')}}" class="btn add-btn erp-add-employee ms-2" ><i class="fa-solid fa-plus"></i> Create Pre-Production </a>
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
                                            <input type="text" class="form-control search-product-in" placeholder="Product Search">
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
                    
                        <div class="my-attendance-report-wrapper">
                            <div class="big-table pt-4">
                                <div class="de-table-wrapper">
                                    <div class="table-responsive">
                                        <table class="table mb-0 erp-table">
                                            <thead class="erp-thead">
                                                <tr class="erp-tr">
                                                    <th class="erp-th">SL</th>
                                                    <th class="erp-th">Items </th>
                                                    <th class="erp-th text-center">Design Of Document <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Product Design"><i class="fa-duotone fa-exclamation"></i></span></th>
                                                    <th class="erp-th text-center">Process <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Production Process"><i class="fa-duotone fa-exclamation"></i></span> </th>
                                                    <th class="erp-th text-center">Raw Materials </th>
                                                    <th class="erp-th text-center">Estimated QTY </th>
                                                    <th class="erp-th text-center">Inventory</th>
                                                    <th class="erp-th text-center">Verification </th>
                                                    <th class="erp-th text-center">Instruction </th>
                                                
                                                    <th class="erp-th text-center">Action </th>
                                                
                                            
                                                
                                                </tr>
                                            </thead>
                                            <tbody class="erp-tbody">
                                                <tr class="erp-tbody-tr">
                                                    <td class="erp-tbody-td">
                                                        <h4 class="d-table-title">1</h4>
                                                    </td>
                                                    <td class="erp-tbody-td text-start">
                                                        <a href="#" class="em-profile-wrap d-flex align-items-center flex-wrap w-100">
                                                            <div class="em-pro-img-box">
                                                                <img src="assets/img/product/product.png" alt="">
                                                            </div>
                                                            <div class="em-pro-details-box">
                                                                <h5>Product Name</h5>
                                                                <p class="em-id">Code: <span> #45454</span></p>
                                                                
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td class="erp-tbody-td text-center">
                                                        <a href="#" class="document-view-status-btn" data-bs-toggle="modal" data-bs-target="#check_status">
                                                            <img src="assets/img/product/documents.png" alt="" class="document-img-box"><small>View</small>
                                                        </a>
                                                    </td>
                                                    
                                                    <td class="erp-tbody-td text-center">
                                                        <h4 class="text-center d-table-title">5</h4>
                                                    </td>
                                                    <td class="erp-tbody-td text-center">
                                                        <h4 class="text-center d-table-title">12</h4>
                                                    </td>
                                                    <td class="erp-tbody-td text-center">
                                                        <h4 class="text-center d-table-title">14442</h4>
                                                    </td>
                                                    <td class="erp-tbody-td text-center">
                                                        <a href="#" class="last-cal-status-btn" data-bs-toggle="modal" data-bs-target="#check_in_status">Check Info</a>
                                                    </td>
                                                    
                                                    <td class="erp-tbody-td text-center">
                                                        <div class="checkbox-wrapper">
                                                            <input id="terms-checkbox-37" name="checkbox" type="checkbox">
                                                            <label class="terms-label" for="terms-checkbox-37">
                                                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 200 200" class="checkbox-svg">
                                                                <mask fill="white" id="path-1-inside-1_476_5-37">
                                                                  <rect height="200" width="200"></rect>
                                                                </mask>
                                                                <rect mask="url(#path-1-inside-1_476_5-37)" stroke-width="40" class="checkbox-box" height="200" width="200"></rect>
                                                                <path stroke-width="15" d="M52 111.018L76.9867 136L149 64" class="checkbox-tick"></path>
                                                              </svg>
                                                              <span class="label-text">Check</span>
                                                            </label>
                                                          </div>
                                                          

                                                    </td>
                                                    <td class="erp-tbody-td text-center pre-description-box-td">
                                                        <p class="text-center d-table-title pre-description-box">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nisi hic voluptas assumenda aspernatur modi provident quo eveniet, ullam iste tenetur, eos ex reiciendis, perspiciatis quos illo mollitia sed dignissimos nam?</p>
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
                                                        <a href="#" class="em-profile-wrap d-flex align-items-center flex-wrap w-100">
                                                            <div class="em-pro-img-box">
                                                                <img src="assets/img/product/product.png" alt="">
                                                            </div>
                                                            <div class="em-pro-details-box">
                                                                <h5>Product Name</h5>
                                                                <p class="em-id">Code: <span> #45454</span></p>
                                                                
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td class="erp-tbody-td text-center">
                                                        <a href="#" class="document-view-status-btn" data-bs-toggle="modal" data-bs-target="#check_status">
                                                            <img src="assets/img/product/documents.png" alt="" class="document-img-box"><small>View</small>
                                                        </a>
                                                    </td>
                                                    
                                                    <td class="erp-tbody-td text-center">
                                                        <h4 class="text-center d-table-title">5</h4>
                                                    </td>
                                                    <td class="erp-tbody-td text-center">
                                                        <h4 class="text-center d-table-title">12</h4>
                                                    </td>
                                                    <td class="erp-tbody-td text-center">
                                                        <h4 class="text-center d-table-title">14442</h4>
                                                    </td>
                                                    <td class="erp-tbody-td text-center">
                                                        <a href="#" class="last-cal-status-btn" data-bs-toggle="modal" data-bs-target="#check_in_status">Check Info</a>
                                                    </td>
                                                    <td class="erp-tbody-td text-center">
                                                        <div class="checkbox-wrapper">
                                                            <input id="terms-checkbox-38" name="checkbox" type="checkbox">
                                                            <label class="terms-label" for="terms-checkbox-38">
                                                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 200 200" class="checkbox-svg">
                                                                <mask fill="white" id="path-1-inside-1_476_5-37">
                                                                  <rect height="200" width="200"></rect>
                                                                </mask>
                                                                <rect mask="url(#path-1-inside-1_476_5-37)" stroke-width="40" class="checkbox-box" height="200" width="200"></rect>
                                                                <path stroke-width="15" d="M52 111.018L76.9867 136L149 64" class="checkbox-tick"></path>
                                                              </svg>
                                                              <span class="label-text">Check</span>
                                                            </label>
                                                          </div>
                                                          

                                                    </td>
                                                    <td class="erp-tbody-td text-center pre-description-box-td">
                                                        <p href="#" class="text-center d-table-title pre-description-box">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nisi hic voluptas assumenda aspernatur modi provident quo eveniet, ullam iste tenetur, eos ex reiciendis, perspiciatis quos illo mollitia sed dignissimos nam?</p>
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
                                                        <a href="#" class="em-profile-wrap d-flex align-items-center flex-wrap w-100">
                                                            <div class="em-pro-img-box">
                                                                <img src="assets/img/product/product.png" alt="">
                                                            </div>
                                                            <div class="em-pro-details-box">
                                                                <h5>Product Name</h5>
                                                                <p class="em-id">Code: <span> #45454</span></p>
                                                                
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td class="erp-tbody-td text-center">
                                                        <a href="#" class="document-view-status-btn" data-bs-toggle="modal" data-bs-target="#check_status">
                                                            <img src="assets/img/product/documents.png" alt="" class="document-img-box"><small>View</small>
                                                        </a>
                                                    </td>
                                                    
                                                    <td class="erp-tbody-td text-center">
                                                        <h4 class="text-center d-table-title">5</h4>
                                                    </td>
                                                    <td class="erp-tbody-td text-center">
                                                        <h4 class="text-center d-table-title">12</h4>
                                                    </td>
                                                    <td class="erp-tbody-td text-center">
                                                        <h4 class="text-center d-table-title">14442</h4>
                                                    </td>
                                                    <td class="erp-tbody-td text-center">
                                                        <a href="#" class="last-cal-status-btn" data-bs-toggle="modal" data-bs-target="#check_in_status">Check Info</a>
                                                    </td>
                                                    <td class="erp-tbody-td text-center">
                                                        <div class="checkbox-wrapper">
                                                            <input id="terms-checkbox-39" name="checkbox" type="checkbox">
                                                            <label class="terms-label" for="terms-checkbox-39">
                                                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 200 200" class="checkbox-svg">
                                                                <mask fill="white" id="path-1-inside-1_476_5-37">
                                                                  <rect height="200" width="200"></rect>
                                                                </mask>
                                                                <rect mask="url(#path-1-inside-1_476_5-37)" stroke-width="40" class="checkbox-box" height="200" width="200"></rect>
                                                                <path stroke-width="15" d="M52 111.018L76.9867 136L149 64" class="checkbox-tick"></path>
                                                              </svg>
                                                              <span class="label-text">Check</span>
                                                            </label>
                                                          </div>
                                                          

                                                    </td>
                                                    <td class="erp-tbody-td text-center pre-description-box-td">
                                                        <p href="#" class="text-center d-table-title pre-description-box">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nisi hic voluptas assumenda aspernatur modi provident quo eveniet, ullam iste tenetur, eos ex reiciendis, perspiciatis quos illo mollitia sed dignissimos nam?</p>
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
    <!--End::row-1 -->
@endsection

@section('modals')
    
@endsection

@section('css')

@endsection

@section('css_plugins')

@endsection

@section('js_plugins')

@endsection

@section('js')
    <script>
        // var filterData = {
        //     keyword_filtered: ''
        // };
        // $(document).ready(function() {
        //     getData();

        //     filterData.keyword_filtered = $("#keyword_filtered").val()
        //     $("#keyword_filtered").on('input', function () {
        //         filterData.keyword_filtered = $(this).val();
        //     });

        //     $("#machineStoreForm").on('submit', function (e) {
        //         var self = this;
        //         e.preventDefault();
        //         var formData = new FormData($(self)[0]);
        //         $(".ie-span").text("").hide();
        //         var url = $(self).attr('action');

        //         formPost(url, formData, function (res) {
        //             if(res.status == 200){
        //                 $("#addMachineModal").modal('hide');
        //                 $(self)[0].reset();
        //                 showSuccessAlert('Success',res.message)
        //                 getData();
        //             }else{
        //                 showErrorAlert('Error',res.message)
        //             }
        //         }, 'show_input_error');
        //     });

        //     $(document).on("submit", "#machineUpdateForm", function(e) {
        //         e.preventDefault();
        //         var formData = new FormData($(this)[0]);
        //         $(".ie-span").text("").hide();
        //         var url = $(this).attr('action');

        //         formPost(url, formData, function (res){
        //             if(res.status == 200){
        //                 $("#editMachineModal").modal('hide');
        //                 showSuccessAlert('Success',res.message)
        //                 getData();
        //             }else{
        //                 showErrorAlert('Error',res.message)
        //             }
        //         }, 'show_input_error');
        //     });

        // });

        // function getData(){
        //     getPaginatedListData("{{ route('production.machine.filtered') }}", "#ajax-data-load", filterData);
        // }

        // function getPaginatedData(button) {
        //     getPaginatedListData($(button).attr('data-href'), "#ajax-data-load", filterData);
        // }

        // function editItem(id){
        //     let url = "{{route('production.machine.edit', ':id')}}";
        //     url = url.replace(':id', id);
        //     ajaxGet(url, {}, function (response) {
        //         if (response.status == 200) {
        //             $("#edit_data_modal_body").html(response.view);
        //             $("#editMachineModal").modal('show');
        //         } else {
        //             toastr.error(response.message);
        //         }
        //     }, 'default');
        // }

    </script>
@endsection


