@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        <div class="erp-employee-list-wrapper">
            <div class="new-production-wrapper bg-card attd-table">
                <form action="{{route('production.board-pre-production.store')}}" id="preProductionStoreForm" method="POST">
                    @csrf
                    <div class="product-selection-info-box d-flex flex-wrap" style="padding-right: 0px">
                        <div class="row w-100">
                            <div class="col-md-8">
                                <div class="input-block erp-step-input-block mb-2 two">
                                    <label class="col-form-label">Product<small> (Finished Product)</small> <span class="text-red">*</span></label>
                                    <select class="select select-step" name="finished_goods_id" required="">
                                        <option>Select Product</option>
                                        @foreach ($finished_products as $f_product)
                                            <option value="{{$f_product->id}}">{{$f_product->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-block erp-step-input-block mb-2">
                                    <label class="col-form-label">Estimated Output QTY <span class="text-red">*</span></label>
                                    <input class="form-control" name="estimated_quantity" type="number" placeholder="" required="">
                                </div>
                            </div>
                        </div>
                        <div class="row w-100">
                            <div class="col-md-6">
                                <div class="input-block erp-step-input-block mb-0">
                                    <label class="col-form-label">Production Staff <span class="text-danger">*</span></label>
                                    <select class="select select-step select2" name="staff_id" required>
                                        <option>Select Production Staff</option>
                                        @foreach ($staffs as $staff)
                                            <option value="{{$staff->id}}">{{$staff->user_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-block erp-step-input-block mb-0">
                                    <label class="col-form-label">Machine Selection <span class="text-danger">*</span></label>
                                    <select class="select select-step select2" name="machine_id">
                                        @foreach ($machines as $machine)
                                            <option value="{{$machine->id}}">{{$machine->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row w-100">
                            <div class="col-12">
                                <label class="col-form-label">Note</label>
                                <textarea rows="1"  name="note" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="production-process-wrapper process-wrapper">
                            <h4 class="process-child-title">Material</h4>
                            <div class="materialWraper pms-item-main-wrapper">
                                <div class=" pms-item-wrapper d-flex flex-wrap align-items-end">
                                    <div class="pms-item flex-32">
                                        <div class="input-block erp-step-input-block mb-0">
                                            <label class="col-form-label">Category Selection </label>
                                            <select class="select select-step" name="product_material_category_id[]" onchange="getMaterial(this)">
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
                                            <input name="quantity[]" class="form-control " type="number" placeholder="">
                                        </div>
                                    </div>
                                    <div class="pms-item flex-10">
                                        <div class="add-more-m-box d-flex justify-content-center gap-2 align-items-center">
                                            <a href="javascript:void(0)" class="add-more-m-btn" onclick="addMaterialSection()"><i class="la la-plus-circle"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="production-instrucion-output-selection-wrapper mt-3 p-2 text-center">
                        <button class=" erp-search-btn text-center">Save Production</button>
                    </div>
                <form>
            </div>
        </div>
    </div>

    {{-- add mutiple material template --}}
    <div id="newMaterialRow" style="display: none">
        <div class="material-item-parent pms-item-wrapper d-flex flex-wrap align-items-end">
            <div class="pms-item flex-32">
                <div class="input-block erp-step-input-block mb-0">
                    <label class="col-form-label">Category Selection </label>
                    <select class="select1 select-step1 select21" name="product_material_category_id[]" onchange="getMaterial(this)">
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
                    <select name="product_material_id[]" class="select1 select-step1 material-product material-product2" >
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
            <div class="pms-item flex-10">
                <div class="add-more-m-box d-flex justify-content-center gap-2 align-items-center">
                    <a href="javascript:void(0)" class="add-more-m-btn" onclick="addMaterialSection()"><i class="la la-plus-circle"></i></a>
                    <a href="javascript:void(0)" onclick="removeMaterialSection(this)" class="add-more-m-btn remove-item"><i class="la la-times-circle"></i></a>
                </div>
            </div>
        </div>
    </div>
    
@endsection

@section('modals')

@endsection

@section('css')
    <style>
        .remove-process-btn{
            margin-top: 0;
            border-radius: 0px 0px 50px 50px;
            padding: 5px 30px;
            border: 2px dashed rgb(233 49 49);
            background-color: #ffe3e3;
            border-top: none;
            font-size: 12px;
            font-weight: 700;
            font-weight: 800;
        }
        .prod-p-staff{
            width: 48%;
        }
    </style>
@endsection

@section('css_plugins')

@endsection

@section('js_plugins')
    <script src="{{asset('assets')}}/plugins/multipleselect/multiple-select.js"></script>
    <script src="{{asset('assets')}}/plugins/multipleselect/multi-select.js"></script>

    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // initSelect2();
            $("#preProductionStoreForm").on('submit', function (e) {
                var self = this;
                e.preventDefault();
                var formData = new FormData($(self)[0]);
                $(".ie-span").text("").hide();
                var url = $(self).attr('action');

                formPost(url, formData, function (res) {
                    if(res.status == 200){
                        showSuccessAlert('Success',res.message)
                        setTimeout(function () {
                           window.location.href = "{{route('production.board-pre-production.index')}}";
                        }, 1000);
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');

            });
        });

        function getMaterial(select){
            let category_id = $(select).val();
            var materialSelect = $(select).closest('.pms-item-wrapper').find('.material-product');
            console.log(materialSelect);

            let url = "{{ route('production.board-pre-production.get-material-products') }}";
            if(category_id > 0){
                ajaxGet(url, {category_id:category_id}, function (response) {
                    if (response.status == 200) {
                        materialSelect.html(response.view);
                    } else {
                        materialSelect.html('');
                        toastr.error(response.message);
                    }
                });
            } else {
                materialSelect.html('');
                return;
            }
        }

        function addMaterialSection(){
            var item = $('#newMaterialRow').html();
            $('.materialWraper').append(item);
            initSelect2();
        }

        function removeMaterialSection(element){
            $(element).closest('.material-item-parent').remove();
        }

        function initSelect2() {
            $('.process-wrapper .select-step1').select2({
                minimumResultsForSearch: -1,
                width: '100%',
            });
        }
    </script>
@endsection


