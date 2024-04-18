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
                            <label class="col-form-label">Product(Finished Product) Selection</label>
                            <h4>{{$pre_production->finishedGoods->name}}</h4>
                        </div>
                    </div>
                    <div class="pgib-item flex-32 pd-item">
                        <div class="input-block erp-step-input-block mb-0">
                            <label class="col-form-label">Estimated Output QTY </label>
                            <h4>{{$pre_production->estimated_production_qty}}</h4>
                        </div>
                    </div>
                    
                    
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
                                <h4>Process {{ $processKey + 1 }}</h4>
                                @if($processData->process_status == $processData::PROCESS_STATUS_PENDING )
                                    {{-- @if(hasPermission('manage-processes')) --}}
                                        <a href="javascript:void(0)" onclick="changeStatus('{{ route('production-staff.production.production.update-process-status',[$pre_production->id,$processData->id,1]) }}')" class="start-process-btn">Start Process</a>
                                    {{-- @endif --}}
                                @elseif($processData->process_status == $processData::PROCESS_STATUS_PROCESSING)
                                    {{-- @if(hasPermission('manage-processes'))  --}}
                                        <a href="javascript:void(0)" onclick="showVerifyOutputModal('{{ $pre_production->id }}', '{{ $processData->id }}')" class="complete-process-btn">Quality Control</a>
                                    {{-- @endif --}}
                                @else
                                    <p class="rs-pre-completed-process">Completed Process</p>
                                @endif
                            </div>
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
                            <div class="production-matarial-selection-wrapper">
                                <h4 class="process-child-title">Matarial</h4>
                                <div class="pms-item-main-wrapper">
                                    @foreach ($processData->materials as $processMaterial)
                                        <div class="pms-item-wrapper d-flex flex-wrap align-items-end pre-d-item-wrapper">
                                            <div class="pms-item flex-32">
                                                <div class="input-block erp-step-input-block mb-0 pre-d-item-input-box">
                                                    <label class="col-form-label">Category Selection <span class="text-danger">*</span></label>
                                                    <h4 class="input-box-title">{{$processMaterial->category->name}}</h4>
                                                </div>
                                            </div>
                                            <div class="pms-item flex-32">
                                                <div class="input-block erp-step-input-block mb-0 pre-d-item-input-box">
                                                    <label class="col-form-label">Matarial Selection <span class="text-danger">*</span></label>
                                                
                                                    <h4 class="input-box-title">{{$processMaterial->product->name}}</h4>
                                                </div>
                                            </div>
                                            <div class="pms-item flex-15">
                                                <div class="input-block erp-step-input-block mb-0 pre-d-item-input-box">
                                                    <label class="col-form-label">QTY <span class="text-danger">*</span></label>
                                                    <h4 class="input-box-title">{{$processMaterial->quantity}}</h4>
                                                </div>
                                            </div>
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
                            <div class="production-instrucion-output-selection-wrapper">
                                <div class="input-block erp-step-input-block mb-0 pre-d-item-input-box-3">
                                    <label class="col-form-label">Instruction<span class="text-danger">*</span></label>
                                    <h4 class="input-box-title">{{$processData->instruction}}</h4>
                                </div>	
                            </div>
                            
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!--End::row-1 -->

</div>
@endsection

@section('modals')
    @include('production-staff.production._verify_output_modal')
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

        function showVerifyOutputModal(id, process_id){
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

        function verifyOutput(uri, checkbox) {
            console.log(uri);
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
                            $("#verifyOutputModal").modal('hide');
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
                    checkbox.checked = false;
                }
            })
        }
    </script>
@endsection


