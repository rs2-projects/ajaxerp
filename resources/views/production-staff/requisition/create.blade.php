@extends('production-staff.layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row" id="VueApp">
		<div class="erp-employee-list-wrapper">
			<div class="new-production-wrapper bg-card attd-table">
				<form action="{{route('production-staff.requisition.store')}}" id="requisitionForm" method="post">
					@csrf
					
					<div class="pd-table-box">
						<div class="my-attendance-report-wrapper">
							<h4 class="process-child-title">Material</h4>
                            <div>
                                <div class="pms-item-main-wrapper materialWraper">
                                    <div class="material-item-parent pms-item-wrapper d-flex flex-wrap align-items-end">
                                        <input type="hidden" name="material_type[]" value="other" />
                                        <div class="pms-item flex-32">
                                            <div class="input-block erp-step-input-block mb-0">
                                                <label class="col-form-label">Category Selection </label>
                                                <select class="select select-step" name="product_material_category_id[]" type="other" onchange="getMaterial(this)" required>
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
                                                <select name="product_material_id[]" class="select select-step material-product" required>
                                                    <option value="">Select Material</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="pms-item flex-15">
                                            <div class="input-block erp-step-input-block mb-0">
                                                <label class="col-form-label">QTY </label>
                                                <input name="quantity[]" class="form-control" type="number" min="1" placeholder="" required>
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
                                        <a href="javascript:void(0)" class="erp-search-btn text-center pp-add-more-btn" onclick="addMaterialSection('other')"><i class="la la-plus-circle"></i> Add Item</a>
                                        {{-- <a href="javascript:void(0)" onclick="addMaterialSection('board')" class="erp-search-btn text-center pp-add-more-btn pp-add-board-btn"><i class="la la-plus-circle"></i> Board</a> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section mt-5">
                                <button class="btn btn-primary submit-btn" type="submit">Save</button>
                            </div>
						</div>
					</div>
					
				</form>
			</div>
		</div>

	</div>
    <!--End::row-1 -->
</div>

<div id="newMaterialRow" style="display: none">
    <div class="material-item-parent pms-item-wrapper d-flex flex-wrap align-items-end">
        <input type="hidden" name="material_type[]" value="other" />
        <div class="pms-item flex-32">
            <div class="input-block erp-step-input-block mb-0">
                <label class="col-form-label"> Material Category </label>
                <select class="select1 select-step1" name="product_material_category_id[]" type="other" onchange="getMaterial(this)" required>
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="pms-item flex-32">
            <div class="input-block erp-step-input-block mb-0">
                <label class="col-form-label">Material </label>
                <select name="product_material_id[]" class="select1 select-step1 material-product material-product2" required>
                    <option value="">Select Material</option>
                </select>
            </div>
        </div>
        <div class="pms-item flex-15">
            <div class="input-block erp-step-input-block mb-0">
                <label class="col-form-label">QTY </label>
                <input name="quantity[]" class="form-control" type="number" placeholder="" min="1" required>
            </div>
        </div>
        <div class="pms-item flex-10">
            <div class="add-more-m-box d-flex justify-content-center gap-2 align-items-center">
                {{-- <a href="javascript:void(0)" class="add-more-m-btn" onclick="addMaterialSection()"><i class="la la-plus-circle"></i></a> --}}
                <a href="javascript:void(0)" onclick="removeMaterialSection(this)" class="add-more-m-btn remove-item"><i class="la la-times-circle"></i></a>
            </div>
        </div>
    </div>
</div>

<div id="newBoardRow" style="display: none">
    <div class="material-item-parent pms-item-wrapper d-flex flex-wrap align-items-end">
        <input type="hidden" name="material_type[]" value="board" />
        <div class="pms-item flex-32">
            <div class="input-block erp-step-input-block mb-0">
                <label class="col-form-label"> Board Category </label>
                <select class="select1 select-step1" name="product_material_category_id[]" type="board" onchange="getMaterial(this)" required>
                    <option value="">Select Category</option>
                    @foreach ($finished_categoris as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="pms-item flex-32">
            <div class="input-block erp-step-input-block mb-0">
                <label class="col-form-label">Board </label>
                <select name="product_material_id[]" class="select1 select-step1 material-product material-product2" required>
                    <option value="">Select Board</option>
                </select>
            </div>
        </div>
        <div class="pms-item flex-15">
            <div class="input-block erp-step-input-block mb-0">
                <label class="col-form-label">QTY </label>
                <input name="quantity[]" class="form-control" type="number" placeholder="" min="1" required>
            </div>
        </div>
        <div class="pms-item flex-10">
            <div class="add-more-m-box d-flex justify-content-center gap-2 align-items-center">
                {{-- <a href="javascript:void(0)" class="add-more-m-btn" onclick="addMaterialSection()"><i class="la la-plus-circle"></i></a> --}}
                <a href="javascript:void(0)" onclick="removeMaterialSection(this)" class="add-more-m-btn remove-item"><i class="la la-times-circle"></i></a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modals')

@endsection

@section('css')

@endsection

@section('css_plugins')

@endsection

@section('js_plugins')
	<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
	<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
@endsection

@section('js')
<script>
	$(document).ready(function () {
		$("#requisitionForm").on('submit', function (e) {
            var self = this;
            e.preventDefault();
            var formData = new FormData($(self)[0]);
            $(".ie-span").text("").hide();
            var url = $(self).attr('action');

            formPost(url, formData, 'redirect', 'show_input_error');
        });
	});
    var { createApp } = Vue;
    var vueApp = createApp({
        data() {
            return {
                
            };
        },
        methods: {
            
        },
        mounted() {
            
        }
    }).mount('#VueApp');

    function getMaterial(select){
        let material_type = $(select).attr('type');
        console.log(material_type)
        let category_id = $(select).val();
        var materialSelect = $(select).closest('.pms-item-wrapper').find('.material-product');

        let url = "{{ route('production-staff.production.production.get-material-by-category') }}";
        if(category_id > 0){
            ajaxGet(url, {category_id:category_id, type: material_type}, function (response) {
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

    function addMaterialSection(add_type){
        let item = '';
        if(add_type == 'other'){
            item = $('#newMaterialRow').html();
        }else{
            item = $('#newBoardRow').html();
        }
        $('.materialWraper').append(item);

        $(".materialWraper .select-step1").select2({
            closeOnSelect: true,
            containerCssClass: "select2-box-container",
            dropdownCssClass: "select2-box-dropdown",
            width: '100%'

        });
    }

    function removeMaterialSection(element){
        $(element).closest('.material-item-parent').remove();
    }
</script>


@endsection


