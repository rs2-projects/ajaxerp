<div id="purchaseRequestDetailsModal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header erp-modal-header">
                <h5 class="modal-title">Purchase Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body erp-modal-body">
                <div class="my-attendance-report-wrapper">
                    <div class="big-table">
                        <div class="de-table-wrapper">
                            <div class="table-responsive">
                                <table class="table mb-0 erp-table">
                                    <thead class="erp-thead">
                                        <tr class="erp-tr">
                                            
                                            <th class="erp-th">Category </th>
                                            <th class="erp-th text-center">Item </th>
                                            <th class="erp-th text-center">Qty </th>
                                            
                                            <th class="text-center erp-th">Attachment</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody class="erp-tbody">
                                        
                                        <tr class="erp-tbody-tr">
                                            <td class="erp-tbody-td text-start">
                                                <h4 class="text-start d-table-title">Office Supplies</h4>
                                            </td>
                                            <td class="erp-tbody-td text-center">
                                                <h4 class="text-center d-table-title">Drill Machine</h4>
                                            </td>
                                            <td class="erp-tbody-td text-center">
                                                <h4 class="text-center d-table-title">10</h4>
                                            </td>
                                        
                                            <td class="erp-tbody-td text-center">
                                    
                                                <a href="#" class="text-center d-table-title attachement-file-box">
                                                    <img src="assets/img/attachment.png" alt=""> Attachment
                                                </a>
                                            </td>
                                        
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                
                    
                </div>
                <div class="d-purchase-order-action-wrapper">
                    <div class="d-purchase-order-action-btn d-flex justify-content-center align-items-center">
                        <a href="#" class="dpoa-btn req-info-btn">Request For Info</a>
                        <a href="#" class="dpoa-btn appr">Approved</a>
                        <a href="javascript:void(0)" onclick="deleteAjax('{{ route('procurement.admin.asset-purchase-request.delete',$pr->id) }}', 'reloadAjaxGetData') " class="dpoa-btn re">Decline</a>
                    </div>
                    <div class="d-purchase-req-wrapper text-center justify-content-center flex-wrap" style="display: none;">
                        <div class="dpreq-item flex-100">
                            <div class="input-block erp-step-input-block ">
                                <label class="col-form-label">Request Message <span class="text-danger">*</span></label>
                                <textarea rows="3" class="form-control"></textarea>
                            </div>
                            
                        </div>
                        <div class="dpreq-item flex-100">
                            <div class="input-block erp-step-input-block mb-0">
                                <div class="nw-p-add-btn text-center d-inline-block">
                                    <button class=" erp-search-btn text-center"><i class="fa-regular fa-paper-plane me-2"></i>Send</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>