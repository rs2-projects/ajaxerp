@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        <div class="col-md-12">
            <div class="new-purchase-wrapper">
                <form action="{{ route('procurement.user.asset-purchase-request.store') }}" id="purchaseRequestStoreForm" method="POST">
                    @csrf
                    <div class="row justify-content-center gap-4">
                        <div class="col-md-12">
                            <div class="purchase-table-box-wrapper bg-card attd-table">
                                <div class="my-attendance-report-wrapper">
                                    <div class="big-table">
                                        <div class="de-table-wrapper">
                                            <div class="purchase-request-title-box mb-2">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <label class="col-form-label">Title <span class="text-red">*</span></label>
                                                    <input class="form-control" name="title" id="purchase_title" type="text" placeholder="Enter a Title Here" required="">
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

                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="add-more-assets-box">
                                                <a href="javascript:void(0);" class="po-add-product-btn flex-100 justify-content-center" data-bs-toggle="modal" data-bs-target="#addPurchaseRequestModal"><span class="me-2"><i class="fa-solid fa-plus"></i></span> Add Item</a>
                                            </div>
                                            <div class="production-instrucion-output-selection-wrapper">
                                                <div class="input-block erp-step-input-block mb-0">
                                                    <label class="col-form-label">Note</span></label>
                                                    <textarea rows="2" name="note" id="purchase_note" class="form-control"></textarea>
                                                </div>	
                                            </div>
                                        </div>
                                    </div>

                                
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="nw-warehouse-add-btn-2 text-center">
                                {{-- <a href="javascript:void(0);" type="submit" id="generatePuchaseRequest" class=" erp-search-btn text-center"></a> --}}
                                <button class="erp-search-btn text-center" type="submit">Generate Purchase Request</button>
                            </div>
                        </div>
                    </div>
                </form>
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
        const assetUrl = "{{ asset('assets/img/attachment.png') }}";

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
            $('.file_attachment').val('');
        }

        function addPurchaseRequestBtn() {
            const category_id = $('#category').val();
            const product_id = $('#product').val();
            const qty = $('#item_qty').val();
            const description = $('#item_desc').val();

            if (!category_id || !product_id || !qty) {
                console.log('Please fill up the required fields');
                showErrorAlert('Error', 'Please fill up the required fields');
                return;
            }

            if ($(`#purchaseRequestTableBody tr[data-category-id="${category_id}"][data-product-id="${product_id}"]`).length > 0) {
                showErrorAlert('Error', 'Same product is already added.');
                return;
            }

            const category_name = $('#category option:selected').text();
            const product_name = $('#product option:selected').text();

            const newRow = `
                <tr class="erp-tbody-tr" data-category-id="${category_id}" data-product-id="${product_id}" data-qty="${qty}" data-description="${description}">
                    <input type="hidden" name="asset_product_category_id[]" value="${category_id}">
                    <input type="hidden" name="asset_product_id[]" value="${product_id}">
                    <input type="hidden" name="qty[]" value="${qty}">
                    <input type="hidden" name="description[]" value="${description}">
                    <td class="erp-tbody-td text-start">${category_name}</td>
                    <td class="erp-tbody-td text-center">${product_name}</td>
                    <td class="erp-tbody-td text-center">${qty}</td>
                    <td class="erp-tbody-td text-center">${description}</td>
                    <td class="erp-tbody-td text-center">
                        <input name="image[]" class="form-control file_attachment" type="file">
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

        $(document).ready(function() {
            $("#purchaseRequestStoreForm").on("submit", function(e) {
                var self = this;
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                console.log(formData);
                var url = $(this).attr('action');

                formPost(url, formData, function (res){
                    if(res.status == 200){
                        $(self)[0].reset();
                        $('#purchaseRequestTableBody').empty();
                        showSuccessAlert('Success',res.message)
                        getData();
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');
            });
        });
        
    </script>
@endsection


