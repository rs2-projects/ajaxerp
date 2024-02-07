@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        <div class="col-md-12">
            <div class="new-purchase-wrapper">
                <div class="row justify-content-center gap-4">
                    <div class="col-md-12">
                        <div class="purchase-table-box-wrapper bg-card attd-table">
                            <div class="my-attendance-report-wrapper">
                                <div class="big-table">
                                    <div class="de-table-wrapper">
                                        <div class="purchase-request-title-box mb-2">
                                            <div class="input-block erp-step-input-block mb-0">
                                                <label class="col-form-label">Title <span class="text-red">*</span></label>
                                                <input class="form-control " type="text" placeholder="Enter a Title Here" required="">
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table mb-0 erp-table">
                                                <thead class="erp-thead">
                                                    <tr class="erp-tr">
                                                        <th class="erp-th">Category </th>
                                                        <th class="erp-th text-center">Item </th>
                                                        <th class="erp-th text-center">Qty </th>
                                                        <th class="erp-th text-center">Remarks </th>
                                                        <th class="text-center erp-th">Attachment</th>
                                                        <th class="text-end erp-th">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="erp-tbody" id="purchaseRequestTableBody">
                                                    {{-- <tr class="erp-tbody-tr">
                                                        <td class="erp-tbody-td text-start">
                                                            <h4 class="text-start d-table-title">Office Supplies</h4>
                                                        </td>
                                                        <td class="erp-tbody-td text-center">
                                                            <h4 class="text-center d-table-title">Drill Machine</h4>
                                                        </td>
                                                        <td class="erp-tbody-td text-center">
                                                            <h4 class="text-center d-table-title">10</h4>
                                                        </td>
                                                        <td class="erp-tbody-td text-center remarks-pr-box-td">
                                                            <h4 class="text-center d-table-title remarks-pr-box">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Placeat sit esse facilis doloremque ratione reprehenderit.</h4>
                                                        </td>
                                                    
                                                        <td class="erp-tbody-td text-center">
                                                
                                                            <a href="#" class="text-center d-table-title attachement-file-box">
                                                                <img src="assets/img/attachment.png" alt=""> Attachment
                                                            </a>
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
                                                    </tr> --}}
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="add-more-assets-box">
                                            <a href="javascript:void(0);" class="po-add-product-btn flex-100 justify-content-center" data-bs-toggle="modal" data-bs-target="#addPurchaseRequestModal"><span class="me-2"><i class="fa-solid fa-plus"></i></span> Add Item</a>
                                        </div>
                                        <div class="production-instrucion-output-selection-wrapper">
                                            <div class="input-block erp-step-input-block mb-0">
                                                <label class="col-form-label">Note<span class="text-danger">*</span></label>
                                                <textarea rows="2" class="form-control"></textarea>
                                            </div>	
                                        </div>
                                    </div>
                                </div>

                            
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="nw-warehouse-add-btn-2 text-center">
                            <a href="purchase-request.html" class=" erp-search-btn text-center">Generate Purchase Request</a>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
    </div>
    <!--End::row-1 -->

    
@endsection

@section('modals')
    @include('procurement.asset-purchase-request.user._add_purchase_request_modal')
@endsection

@section('css')
    <style> 
        .add-more-assets-box {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            margin-bottom: 10px;
        }
    </style>
@endsection

@section('css_plugins')

@endsection

@section('js_plugins')
    <script src="{{asset('assets')}}/plugins/multipleselect/multiple-select.js"></script>
    <script src="{{asset('assets')}}/plugins/multipleselect/multi-select.js"></script>
@endsection

@section('js')
    <script>
        function categoryChangeHandler(select){
            let category_id = $(select).val();
            let url = "{{route('procurement.asset-purchase-request.products-by-category')}}";
            ajaxGet(url, {category_id:category_id}, function (response) {
                if (response.status == 200) {
                    $(".product_id").html(response.view);
                } else {
                    toastr.error(response.message);
                }
            });
        }

        function resetRequestModal(){
            $('#category').val('');
            $('#product').val('');
            $('#item_qty').val('');
            $('#item_desc').val('');
            $('#category').prop('selectedIndex', 0).trigger('change');
            $('#product').prop('selectedIndex', 0).trigger('change');
        }

        function addPurchaseRequestBtn() {
            let category_id = $('#category').val();
            let product_id = $('#product').val();
            let qty = $('#item_qty').val();
            let description = $('#item_desc').val();

            if (category_id === '' || product_id === '' || qty === '') {
                console.log('Please fill up the required fields');
                return;
            }

            let existingRow = $('#purchaseRequestTableBody').find(`tr[data-category-id="${category_id}"][data-product-id="${product_id}"]`);
            if (existingRow.length > 0) {
                console.log('Duplicate row found for category_id: ' + category_id + ' and product_id: ' + product_id);
                return;
            }

            let category_name = $('#category option:selected').text();
            let product_name = $('#product option:selected').text();

            let newRow = `<tr class="erp-tbody-tr" data-category-id="${category_id}" data-product-id="${product_id}">
                <td class="erp-tbody-td text-start">${category_name}</td>
                <td class="erp-tbody-td text-center">${product_name}</td>
                <td class="erp-tbody-td text-center">${qty}</td>
                <td class="erp-tbody-td text-center">${description}</td>
                <td class="erp-tbody-td text-center">
                    <a href="#" class="text-center d-table-title attachement-file-box">
                        <img src="assets/img/attachment.png" alt=""> Attachment
                    </a>
                </td>
                <td class="text-end erp-tbody-td">
                    <div class="erp-action-t">
                        <div class="dropdown dropdown-action">
                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_employee"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                <a class="dropdown-item delete-row" href="#" data-bs-toggle="modal" data-bs-target="#delete_resignation"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>`;

            $('#purchaseRequestTableBody').append(newRow);
            resetRequestModal();
            $("#addPurchaseRequestModal").modal('hide');
        }

        $(document).on('click', '.delete-row', function() {
            $(this).closest('tr').remove();
        });




        
    </script>
@endsection


