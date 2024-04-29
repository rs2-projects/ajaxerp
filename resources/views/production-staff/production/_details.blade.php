@extends('production-staff.layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        <div class="erp-employee-list-wrapper">
            <div class="new-production-wrapper bg-card attd-table">
                <div class="product-general-info-box d-flex flex-wrap pd-box">
                    <div class="pgib-item flex-32 pd-item">
                        <div class="input-block erp-step-input-block mb-0">
                            <label class="col-form-label">Order Details</label>
                            <h4>{{$pre_production->order_details}}</h4>
                        </div>
                    </div>
                    <div class="pgib-item flex-32 pd-item">
                        <div class="input-block erp-step-input-block mb-0">
                            <label class="col-form-label">Product(Finished Product) </label>
                            <h4>{{$pre_production->finishedGoods->name}}</h4>
                        </div>
                    </div>
                    <div class="pgib-item flex-32 pd-item">
                        <div class="input-block erp-step-input-block mb-0">
                            <label class="col-form-label">Estimated Output QTY </label>
                            <h4>{{$pre_production->estimated_production_qty}}</h4>
                        </div>
                    </div>

                    @if ($pre_production->type==1)
                        <div class="pgib-item flex-32 pd-item">
                            <div class="input-block erp-step-input-block mb-0">
                                <label class="col-form-label">Production Staff</label>
                                <h4>
                                    @if ($board_process->process_staff)
                                        {{ $board_process->process_staff->title . ' (' . $board_process->process_staff->user_name . ')' }}
                                    @else
                                        N/A
                                    @endif
                                </h4>
                            </div>
                        </div>
                        <div class="pgib-item flex-32 pd-item">
                            <div class="input-block erp-step-input-block mb-0">
                                <label class="col-form-label">Machine </label>
                                <h4>{{$p_machine->machine?->name ?? 'N/A'}}</h4>
                            </div>
                        </div>
                    @endif

                    <div class="pgib-item flex-100 pd-item">
                        <div class="input-block erp-step-input-block mb-0">
                            <label class="col-form-label">Description</label>
                            <p>{{$pre_production->description ?? 'N/A'}}</p>
                        </div>
                    </div>
                </div>
                <div class="product-process-main-item-wrapper">
                    @foreach ($pre_production->pstaff_process as $processKey=> $processData)
                        <div class="production-process-wrapper">
                            <div class="production-process-status-wrapper d-flex justify-content-between align-items-center">
                                @if ($pre_production->type==0)
                                    <h4>Process {{ $processKey + 1 }}</h4>
                                @else
                                    <h4>Material</h4>
                                @endif
                                <div>
                                    <a href="javascript:void(0)" class="">Scan Raw Materials</a>
                                    @if($processData->process_status == $processData::PROCESS_STATUS_PENDING )
                                        <a href="javascript:void(0)" onclick="changeStatus('{{ route('production-staff.production.production.update-process-status',[$pre_production->id,$processData->id,1]) }}')" class="start-process-btn">Start Process</a>
                                    @elseif($processData->process_status == $processData::PROCESS_STATUS_PROCESSING)
                                        <a href="javascript:void(0)" pre_production_id="{{$pre_production->id}}" process_id="{{ $processData->id }}" onclick="showVerifyOutputModal('{{ $pre_production->id }}', '{{ $processData->id }}', this)" class="complete-process-btn">Quality Control</a>
                                    @else
                                        <p class="rs-pre-completed-process">Completed Process</p>
                                    @endif
                                </div>
                            </div>
                            @if ($pre_production->type==0)
                                <div class="production-machine-selection-wrapper d-flex flex-wrap p-de-box-wrapper">
                                    <div class="pms-item flex-48">
                                        <div class="input-block erp-step-input-block mb-0 p-de-input-box">
                                            <label class="col-form-label">Machine Selection </label>
                                            <h4 class="input-box-title">
                                                @foreach ($processData?->processMachines as $machineData)
                                                    <span>{{$machineData->machine->name}}</span>
                                                @endforeach
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="pms-item flex-48">
                                        <div class="input-block erp-step-input-block mb-0 p-de-input-box">
                                            <label class="col-form-label">Previous Process </label>
                                            <h4 class="input-box-title-2">
                                                @if($processData->previousProcess->count() > 0)
                                                    @foreach ($processData->previousProcess as $previousKey => $previousProcess)
                                                        <span>Process {{$previousKey + 1}}</span>
                                                    @endforeach
                                                @else
                                                    <span>N/A</span>
                                                @endif
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="{{$pre_production->type== 0 ? 'production-matarial-selection-wrapper' : ''}}">
                                @if ($pre_production->type==0)<h4 class="process-child-title">Material</h4>@endif
                                <div class="pms-item-main-wrapper">
                                    @foreach ($processData->materials as $processMaterial)
                                        <div class="pms-item-wrapper d-flex flex-wrap align-items-end pre-d-item-wrapper">
                                            <div class="pms-item flex-32">
                                                <div class="input-block erp-step-input-block mb-0 pre-d-item-input-box">
                                                    <label class="col-form-label">Category Selection </label>
                                                    <h4 class="input-box-title">{{$processMaterial->category->name}}</h4>
                                                </div>
                                            </div>
                                            <div class="pms-item flex-32">
                                                <div class="input-block erp-step-input-block mb-0 pre-d-item-input-box">
                                                    <label class="col-form-label">Matarial Selection </label>

                                                    <h4 class="input-box-title">{{$processMaterial->product->name}}</h4>
                                                </div>
                                            </div>
                                            <div class="pms-item flex-10">
                                                <div class="input-block erp-step-input-block mb-0 pre-d-item-input-box">
                                                    <label class="col-form-label">QTY</label>
                                                    <h4 class="input-box-title">{{$processMaterial->base_quantity}}</h4>
                                                </div>
                                            </div>
                                            @if($processMaterial->extra_quantity)
                                                <div class="pms-item flex-1">
                                                    <div class="input-block erp-step-input-block mb-0 pre-d-item-input-box">
                                                        <i class="fa fa-plus"></i>
                                                    </div>
                                                </div>
                                                <div class="pms-item flex-10">
                                                    <div class="input-block erp-step-input-block mb-0 pre-d-item-input-box">
                                                        <label class="col-form-label"></label>
                                                        <h4 class="input-box-title">{{$processMaterial->extra_quantity}}</h4>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="production-estimate-output-selection-wrapper">
                                <h4 class="process-child-title">Estimated Output</h4>
                                <div class="pms-item-main-wrapper">
                                    @foreach ($processData->estimated_output as $outputData)
                                        <div class="pms-item-wrapper d-flex flex-wrap align-items-end">
                                            <div class="pms-item flex-60">
                                                <div class="input-block erp-step-input-block mb-0 pre-d-item-input-box-2">
                                                    <label class="col-form-label">Name <span class="text-danger">*</span></label>
                                                    <h4 class="input-box-title"> {{$outputData->name}}</h4>
                                                </div>
                                            </div>
                                            <div class="pms-item flex-15">
                                                <div class="input-block erp-step-input-block mb-0 pre-d-item-input-box-2">
                                                    <label class="col-form-label">QTY <span class="text-danger">*</span></label>
                                                    <h4 class="input-box-title">{{$outputData->quantity}}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @if ($pre_production->type==0)
                                <div class="production-instrucion-output-selection-wrapper">
                                    <div class="input-block erp-step-input-block mb-0 pre-d-item-input-box-3">
                                        <label class="col-form-label">Instruction<span class="text-danger">*</span></label>
                                        <h4 class="input-box-title">{{$processData->instruction}}</h4>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!--End::row-1 -->
</div>

{{-- add mutiple material template --}}
    <div id="newMaterialRow" style="display: none">
        <div class="material-item-parent pms-item-wrapper d-flex flex-wrap align-items-end">
            <div class="pms-item flex-32">
                <div class="input-block erp-step-input-block mb-0">
                    <label class="col-form-label">Category Selection </label>
                    <select class="select1 select-step1" name="product_material_category_id[]" onchange="getMaterial(this)">
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
    @include('production-staff.production._verify_output_modal')
    @include('production-staff.production._re_requisiton_modal')
@endsection

@section('css')
    <style>
        .erp-table-status.pre-delivered-s .action-icon {
            background: #37b34a;
        }
        .complete-process-btn{
            border: none;
            border-radius: 5px;
            font-size: 12px;
            font-weight: 700;
            background: #16b0ae;
            color: #fff;
            padding: 5px 20px;
        }
        .qc-btn {
            padding: 3px 10px;
            background: #ddd;
            font-size: 12px;
            font-weight: 700;
            border-radius: 5px;
            margin-right: 10px;
        }
        .qc-btn:last-child{
            margin-right: 0;
        }
        .qc-btn.qc-perfect {
            background: #55ce63;
            color: #fff !important;
        }
        .qc-btn.qc-damage {
            background: red;
            color: #fff !important;
        }
        tr.erp-tbody-tr.perfect-qc-tr {
            background: #e6ffd7 !important;
        }
        tr.erp-tbody-tr.damage-qc-tr {
            background: #ff2b2b1a !important;
        }
        .qc-btn-all {
            padding: 3px 10px;
            background: #0d6efd;
            font-size: 12px;
            color: #fff;
            border-radius: 5px;
            font-weight: 700;
        }
        .qc-btn-all:hover {
            background: #55ce63;
        }
        .qc-quantity-wraper {
            padding: 10px;
            border: 1px dashed  #ddd;
            margin-bottom: 10px;
        }
        .qc-quantity-wraper h4 {
            margin-bottom: 0;
            font-size: 14px;
            font-weight: 500;
            background: #f1f1f1a6;
            padding: 5px 10px;
            color: #0c0c0c;
            border-radius: 2px;
        }
        .qc-quantity-wraper h4 span {
            font-weight: 700;
        }
        .qc-quantity-wraper h4.perfect-h4 {
            color: #0aa31b;
        }
        .qc-quantity-wraper h4.damage-h4 {
            color: #f00;
        }
        .qc-header {
            margin-bottom: 10px;
        }
        .qc-header .re-btn {
            background: #a500fd;
            padding: 5px 20px;
            color: #fff;
            font-weight: 700;
            border-radius: 5px;
            font-size: 14px;
        }
 </style>
@endsection

@section('css_plugins')

@endsection

@section('js_plugins')

@endsection

@section('js')
    <script>
        // $(document).ready(function() {
        //     $(".select-step").select2({
        //         closeOnSelect: true,
        //         containerCssClass: "select2-box-container",
        //         dropdownCssClass: "select2-box-dropdown",
        //         width: '100%'

        //     });
        // });

        function changeStatus(uri) {
           console.log(uri);
            Swal.fire({
                title: '',
                html: 'Are you sure to update process status?',
                showDenyButton: true,
                confirmButtonText: 'Yes',
                denyButtonText: `No`,
            }).then((result) => {
                if (result.isConfirmed) {
                    ajaxGet(
                        uri,
                        {},
                        function (response) {
                          if (response.status == 200){
                            toastr.success(response.message);
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                          }else{
                            toastr.error(response.message);
                          }
                        }
                    );
                } else if (result.isDenied) {

                }
            })
        }

        let currentProcessBtn = '';

        function showVerifyOutputModal(id, process_id, process_btn){
            currentProcessBtn = process_btn;
            let url = "{{route('production-staff.production.production.verify-output-data', ['id' => ':id', 'process_id' => ':process_id'])}}";
            url = url.replace(':id', id);
            url = url.replace(':process_id', process_id);
            ajaxGet(url, {}, function (response) {
                if (response.status == 200) {
                    $("#verify_output_modal_body").html(response.view);
                    $("#verifyOutputModal").modal('show');
                } else {
                    toastr.error(response.message);
                }
            }, 'default');
        }

        function verifyOutput(uri, btn, type) {
            Swal.fire({
                title: '',
                html: 'Are you sure to verify this output?',
                showDenyButton: true,
                confirmButtonText: 'Yes',
                denyButtonText: `No`,
            }).then((result) => {
                if (result.isConfirmed) {
                    ajaxGet(
                        uri,
                        {},
                        function (response) {
                          if (response.status == 200){
                            console.log(response);
                            toastr.success(response.message);
                            if(response[0].process_status == 2){
                                currentProcessBtn.removeAttribute('onclick');
                                currentProcessBtn.classList.remove('complete-process-btn');
                                currentProcessBtn.classList.add('rs-pre-completed-process');
                                currentProcessBtn.textContent = 'Completed Process';

                            }
                            if(type == 'perfect' ){
                                btn.closest('tr').classList.add('perfect-qc-tr');
                                btn.classList.remove('qc-perfect');
                                btn.removeAttribute('onclick');

                                const btnWrap = btn.closest('.qc-btn-wrap');
                                const damageBtn = btnWrap.querySelector('.qc-damage');
                                damageBtn.classList.remove('qc-damage');
                                damageBtn.removeAttribute('onclick');

                                const quantityWrapper = btn.closest('.pms-item-main-wrapper');
                                const perfectCount = quantityWrapper.querySelector('.perfect-count');
                                perfectCount.textContent = parseInt(perfectCount.textContent) + 1;

                            }else if(type == 'damage'){
                                btn.closest('tr').classList.add('damage-qc-tr');
                                btn.classList.remove('qc-damage');
                                btn.removeAttribute('onclick');

                                const btnWrap = btn.closest('.qc-btn-wrap');
                                const perfectBtn = btnWrap.querySelector('.qc-perfect');
                                perfectBtn.classList.remove('qc-perfect');
                                perfectBtn.removeAttribute('onclick');

                                const quantityWrapper = btn.closest('.pms-item-main-wrapper');
                                const damageCount = quantityWrapper.querySelector('.damage-count');
                                damageCount.textContent = parseInt(damageCount.textContent) + 1;
                            }else if(type == 'perfect-all'){
                                btn.removeAttribute('onclick');
                                btn.classList.add('qc-btn');
                                btn.classList.remove('qc-btn-all', 'qc-perfect-all');
                                const sectionButtons = btn.closest('.pms-item-main-wrapper').querySelectorAll('.qc-btn');
                                sectionButtons.forEach(function (button) {
                                    button.closest('tr').classList.add('perfect-qc-tr');
                                    button.classList.remove('qc-perfect', 'qc-damage');
                                    button.removeAttribute('onclick');
                                });

                                const quantityWrapper = btn.closest('.pms-item-main-wrapper');
                                const perfectCount = quantityWrapper.querySelector('.perfect-count');
                                perfectCount.textContent = btn.getAttribute('qty')
                            }
                          }else{
                            toastr.error(response.message);
                          }
                        }
                    );
                } else if (result.isDenied) {
                    // checkbox.checked = false;
                }
            })
        }

        function showReRequisitionModal(){
            $("#verifyOutputModal").modal('hide');
            $("#reRequisitionModal").modal('show');
            let process_id = currentProcessBtn.getAttribute('process_id');
            let pre_production_id = currentProcessBtn.getAttribute('pre_production_id');
            $("#process_id").val(process_id);
            $("#pre_production_id").val(pre_production_id);
        }

        function getMaterial(select){
            let category_id = $(select).val();
            var materialSelect = $(select).closest('.pms-item-wrapper').find('.material-product');
            console.log(materialSelect);

            let url = "{{ route('production-staff.production.production.get-material-by-category') }}";
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

        $("#reRequisitionStoreForm").on('submit', function (e) {
            var self = this;
            e.preventDefault();
            var formData = new FormData($(self)[0]);
            $(".ie-span").text("").hide();
            var url = $(self).attr('action');
            console.log(url);
            formPost(url, formData, function (res) {
                if(res.status == 200){
                    $("#reRequisitionModal").modal('hide');
                    $(self)[0].reset();
                    showSuccessAlert('Success',res.message);
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                }else{
                    showErrorAlert('Error',res.message)
                }
            }, 'show_input_error');
        });
    </script>
@endsection


