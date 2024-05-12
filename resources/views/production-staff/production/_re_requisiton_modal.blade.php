<!-- Add Department Modal -->
<div id="reRequisitionModal" class="modal custom-modal fade modal-lg" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="{{route('production-staff.production.production.re-recuisition.store') }}" id="reRequisitionStoreForm" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header erp-modal-header">
                    <h5 class="modal-title">Re-Requisition</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body erp-modal-body">
                    <h4 class="process-child-title">Material</h4>
                    <input type="hidden" name="pre_production_id" id="pre_production_id"/>
                    <input type="hidden" name="process_id" id="process_id"/>
                    <div>
                        <div class="pms-item-main-wrapper materialWraper">
                            <div class="material-item-parent pms-item-wrapper d-flex flex-wrap align-items-end">
                                <input type="hidden" name="material_type[]" value="other" />
                                <div class="pms-item flex-32">
                                    <div class="input-block erp-step-input-block mb-0">
                                        <label class="col-form-label">Category Selection </label>
                                        <select class="select select-step" name="product_material_category_id[]" type="other" onchange="getMaterial(this)">
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="pms-item flex-32">
                                    <div class="input-block erp-step-input-block mb-0">
                                        <label class="col-form-label">Material Selection </label>
                                        <select name="product_material_id[]" class="select select-step material-product" >
                                            <option value="">Select Material</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="pms-item flex-15">
                                    <div class="input-block erp-step-input-block mb-0">
                                        <label class="col-form-label">QTY </label>
                                        <input name="quantity[]" class="form-control" type="number" placeholder="">
                                    </div>
                                </div>
                                {{-- <div class="pms-item flex-10">
                                    <div class="add-more-m-box d-flex justify-content-center gap-2 align-items-center">
                                        <a href="javascript:void(0)" class="add-more-m-btn" onclick="addMaterialSection()"><i class="la la-plus-circle"></i></a>
                                    </div>
                                </div> --}}
                            </div>
                        </div>

                        <div class="pms-item flex-100">
                            <div class="add-more-m-box d-flex justify-content-center gap-2 align-items-center">
                                <a href="#" class="erp-search-btn text-center pp-add-more-btn" onclick="addMaterialSection('other')"><i class="la la-plus-circle"></i> Other</a>
                                <a href="#" onclick="addMaterialSection('board')" class="erp-search-btn text-center pp-add-more-btn pp-add-board-btn"><i class="la la-plus-circle"></i> Board</a>
                            </div>
                        </div>
                    </div>
                    <div class="submit-section mt-2">
                        <button class="btn btn-primary submit-btn" type="submit">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- /Add Department Modal -->
