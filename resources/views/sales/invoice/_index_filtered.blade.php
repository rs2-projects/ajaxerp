<div class="table-responsive">
    <table class="table mb-0 erp-table">
        <thead class="erp-thead">
        <tr class="erp-tr">
            <th class="erp-th">SL</th>
            <th class="erp-th">Invouce No. </th>
            <th class="erp-th text-center">Customer </th>
            <th class="erp-th text-center">Design </th>
            <th class="erp-th text-center">Status </th>
            <th class="erp-th text-center">Amount </th>
            <th class="erp-th text-center">Payment Status </th>
            <th class="erp-th text-center">Record Payment </th>
            <th class="text-end erp-th">Action</th>
        </tr>
        </thead>
        <tbody class="erp-tbody">
        @foreach($invoices as $invoice)
        <tr class="erp-tbody-tr">
            <td class="erp-tbody-td">
                <h4 class="d-table-title">1</h4>
            </td>
            <td class="erp-tbody-td text-start">
                <h4 class="text-start d-table-title"><strong>Invoice No -</strong> <span>{{ $invoice->invoice_no }}</span></h4>
                <small class="text-center d-table-title">{{ $invoice->created_at }}</small>
            </td>
            <td class="erp-tbody-td">
                <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100 justify-content-center">
                    <div class="em-pro-img-box">
                        <img src="assets/img/profiles/office-building.png" alt="">
                    </div>
                    <div class="em-pro-details-box">
                        <h5>{{ $invoice->customer->name }}</h5>
                    </div>
                </div>
            </td>
            <td class="erp-tbody-td text-center">
                <a href="#" class="document-view-status-btn" data-bs-toggle="modal" data-bs-target="#check_status">
                    <img src="assets/img/product/documents.png" alt="" class="document-img-box"><small>View</small>
                </a>
            </td>

            <td class="erp-tbody-td text-center">
                <div class="design-upload-revael-box">
                    <button class="dur-btn">Submit To Production</button>
                </div>

            </td>
            <td class="erp-tbody-td text-center">
                <h4 class="text-center d-table-title"><span class="in-t-amount-text">Total - </span>$3223232</h4>
                <h4 class="text-center d-table-title"><span class="in-t-amount-text due-text">Due - </span>$45343</h4>

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

                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#design-upload"><i class="fa-solid fa-upload m-r-5"></i> Design Upload</a>
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_employee"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_resignation"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>

                        </div>
                    </div>
                </div>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>



{{ $invoices->links('vendor.pagination.common_ajax_pagination') }}
