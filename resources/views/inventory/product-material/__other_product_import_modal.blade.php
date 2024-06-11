<!-- Add New Product Modal -->
<div id="otherProductImportModal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('inventory.product-material.import-others') }}" id="otherProductImportForm" enctype="multipart/form-data" method="post">
                @csrf
                <div class="modal-header erp-modal-header">
                    <h5 class="modal-title">Import Other Products</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body erp-modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-end">
                                <a href="{{ asset('demo-files/demo-other-products.xlsx') }}" class="text-primary"><i class="fa-solid fa-download"></i> Download Demo File</a>
                            </div>
                           <div class="form-group">
                               <label for="product_file" class="mb-1">Import File</label>
                               <input type="file" class="form-control" name="product_file" accept=".xlsx,.xls,.csv" id="product_file" required>
                           </div>
                            <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-3 flex-100">

                                <div class="erp-filter-item flex-100 mt-4">
                                    <div class="erp-search-btn-wrap text-center">
                                        <button class=" erp-search-btn text-center" id="otherProductImportSubmitBtn" type="submit">Import</button>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Add Product Material Modal -->
