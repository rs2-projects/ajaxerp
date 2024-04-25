@extends('layouts.layout')
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
                    @foreach ($pre_production->process as $processKey=> $processData)
                        <div class="production-process-wrapper">
                            <div class="production-process-status-wrapper d-flex justify-content-between align-items-center">
                                <h4>Process {{ $processKey + 1 }}</h4>
                                @if($processData->process_status == $processData::PROCESS_STATUS_PENDING )
                                    @if(hasPermission('manage-processes'))
                                        <a href="javascript:void(0)" onclick="changeStatus('{{ route('production.production.update-process-status',[$pre_production->id,$processData->id,1]) }}')" class="start-process-btn">Start Process</a>
                                        {{-- <a href="{{ route('production.production.update-process-status',[$pre_production->id,$processData->id,1]) }}" class="start-process-btn">Start Process</a> --}}
                                    @endif
                                @elseif($processData->process_status == $processData::PROCESS_STATUS_PROCESSING)
                                    @if(hasPermission('manage-processes')) 
                                        <a href="javascript:void(0)" onclick="changeStatus('{{ route('production.production.update-process-status',[$pre_production->id,$processData->id,2]) }}')" class="complete-process-btn">Complete Process</a>
                                    @endif
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
                                               @if($machineData->machine?->name) <span>{{$machineData->machine?->name}}</span>@endif
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
                                                    <label class="col-form-label">Category Selection</label>
                                                    <h4 class="input-box-title">{{$processMaterial->category->name}}</h4>
                                                </div>
                                            </div>
                                            <div class="pms-item flex-32">
                                                <div class="input-block erp-step-input-block mb-0 pre-d-item-input-box">
                                                    <label class="col-form-label">Matarial Selection</label>
                                                
                                                    <h4 class="input-box-title">{{$processMaterial->product->name}}</h4>
                                                </div>
                                            </div>
                                            <div class="pms-item flex-15">
                                                <div class="input-block erp-step-input-block mb-0 pre-d-item-input-box">
                                                    <label class="col-form-label">QTY </label>
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
                                                    <label class="col-form-label">Name</label>
                                                    <h4 class="input-box-title"> {{$outputData->name}}</h4>
                                                </div>
                                            </div>
                                            <div class="pms-item flex-15">
                                                <div class="input-block erp-step-input-block mb-0 pre-d-item-input-box-2">
                                                    <label class="col-form-label">QTY</label>
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
    </script>
@endsection


