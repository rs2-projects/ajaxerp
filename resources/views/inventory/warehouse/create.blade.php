@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        <div class="col-md-12">
            <div class="new-warhouse-wrapper">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="warehouse-basic-info bg-card attd-table">
                            <div class="wbi-item">
                                <h2>Warehouse Basic Info</h2>
                            </div>
                            <div class="wbi-item">
                                <div class="wpi-child-item-wrapper d-flex gap-2">
                                    <div class="wpi-child-item flex-40">
                                        <div class="input-block mb-0 erp-step-input-block">
                                            <label class="col-form-label">Warehouse Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control ">
                                        </div>
                                    </div>
                                    <div class="wpi-child-item flex-60">
                                        <div class="input-block mb-0 erp-step-input-block">
                                            <label class="col-form-label">Description </label>
                                            <input type="text" name="description" class="form-control ">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="wbi-item">
                                <div class="new-warehouse-main-wrapper">
                                    <div class="new-warehouse-section-body d-flex flex-wrap gap-2 justify-content-between">
                                        <div class="new-wsb-item flex-40">
                                            <div class="input-block mb-0 erp-step-input-block">
                                                <label class="col-form-label">Section  <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control mb-2" name="section_name[]" placeholder="Section Name here">
                                                <a href="javascript:void(0)" class="remove-section-btn">Remove This Section</a>
                                            </div>
                                        </div>
                                        <div class="new-wsb-item flex-58">
                                            <div class="new-wsb-sub-item-wrapper ">
                                                <div class="new-wsb-sub-item flex-100">
                                                    <h2>Subsection (Inventory Storage Rack)</h2>
                                                </div>
                                                <div class="new-wsb-sub-item">
                                                    <div class="new-wsb-table-header d-flex flex-wrap align-items-center">
                                                        <div class="new-wsb-table-item">
                                                            <h4>Sl</h4>
                                                        </div>
                                                        <div class="new-wsb-table-item">
                                                            <h4>Subsection</h4>
                                                        </div>
                                                    </div>
                                                    <div class="new-wsb-table-body">
                                                        <div class="new-wsb-table-body-item-wrap d-flex flex-wrap align-items-center position-relative">
                                                            <div class="new-wsb-table-body-item">
                                                                <h5>1</h5>
                                                            </div>
                                                            <div class="new-wsb-table-body-item">
                                                                <div class="input-block mb-0 erp-step-input-block">
                                                                    <input type="text" name="subsection[][]" class="form-control " placeholder="subsection name here">
                                                                </div>
                                                                <a href="#" class="remove-subsection-btn"> <i class="fa fa-times-circle"></i> </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="new-wsb-sub-item flex-100">
                                                    <div class="new-subsection-btn position-relative">
                                                        <a href="javascript:void(0)" onclick="addSubsection(this)" class="add-tds ad-more-row-btn"><i class="fa-solid fa-plus"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="new-warehouse-section-body-add-btn text-center">
                                        <button class="add-section-wh-btn text-center" onclick="addSection(this)">Add Section</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <div class="nw-warehouse-add-btn text-center">
                            <button class=" erp-search-btn text-center">Save Warehouse</button>
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

    </script>
@endsection



