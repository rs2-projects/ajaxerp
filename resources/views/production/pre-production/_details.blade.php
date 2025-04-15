@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        <div class="erp-employee-list-wrapper">
            <div class="new-production-wrapper bg-card attd-table">
                <div class="product-general-info-box d-flex flex-wrap pd-box">
                    @if(hasPermission('manage-pre-productions'))
                        @if($pre_production->is_verified ==$pre_production::VERIFIED_NO || $pre_production->is_verified ==$pre_production::VERIFIED_REVISION)
                            <div class="erp-add-employee-wrapper mb-3 flex-100">
                                <div class="erp-add-employee">
                                    <a href="{{ route('production.pre-production.edit',$pre_production->id) }}" class="btn add-btn erp-add-employee"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                </div>
                            </div>
                        @endif
                    @endif
                    <div class="pgib-item flex-32 pd-item">
                        <div class="input-block erp-step-input-block mb-0">
                            <label class="col-form-label">Batch No</label>
                            <h4>{{$pre_production->pre_production_batch_no}}</h4>
                        </div>
                    </div>
                    <div class="pgib-item flex-32 pd-item">
                        <div class="input-block erp-step-input-block mb-0">
                            <label class="col-form-label">Date</label>
                            <h4>{{ !empty($pre_production->date) ? getFormattedDate($pre_production->date, 'd M, Y') : 'N/A' }}</h4>
                        </div>
                    </div>
                    <div class="pgib-item flex-32 pd-item">
                        <div class="input-block erp-step-input-block mb-0">
                            <label class="col-form-label">Order Details</label>
                            <h4>{{ !empty($pre_production->order_details) ? $pre_production->order_details : 'N/A' }}</h4>
                        </div>
                    </div>
                    <div class="pgib-item flex-32 pd-item">
                        <div class="input-block erp-step-input-block mb-0">
                            <label class="col-form-label">Product(Finished Product)</label>
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
                            <h4>{{$pre_production->description ?? 'N/A'}}</h4>
                        </div>
                    </div>
                </div>
                <div class="product-process-main-item-wrapper">
                    @foreach ($pre_production->process as $processKey=> $processData)
                        <div class="production-process-wrapper">
                            <div class="production-process-status-wrapper d-flex justify-content-between align-items-center">
                                <h4>Process {{ $processKey + 1 }}</h4>

                            </div>
                            <div class="production-machine-selection-wrapper d-flex flex-wrap p-de-box-wrapper">
                                <div class="pms-item flex-48">
                                    <div class="input-block erp-step-input-block mb-0 p-de-input-box">
                                        <label class="col-form-label">Machine </label>
                                        <h4 class="input-box-title">
                                            @foreach ($processData?->processMachines as $machineData)
                                                @if($machineData->machine?->name)
                                                    <span>{{$machineData->machine?->name}}</span>
                                                @endif
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
                                                    <label class="col-form-label">Material Category </label>
                                                    <h4 class="input-box-title">{{$processMaterial->category->name}}</h4>
                                                </div>
                                            </div>
                                            <div class="pms-item flex-32">
                                                <div class="input-block erp-step-input-block mb-0 pre-d-item-input-box">
                                                    <label class="col-form-label">Material</label>

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

                                    @foreach ($processData->board_materials as $processBoard)
                                        <div class="pms-item-wrapper d-flex flex-wrap align-items-end pre-d-item-wrapper">
                                            <div class="pms-item flex-32">
                                                <div class="input-block erp-step-input-block mb-0 pre-d-item-input-box">
                                                    <label class="col-form-label">Board Category </label>
                                                    <h4 class="input-box-title">{{$processBoard->category->name}}</h4>
                                                </div>
                                            </div>
                                            <div class="pms-item flex-32">
                                                <div class="input-block erp-step-input-block mb-0 pre-d-item-input-box">
                                                    <label class="col-form-label">Board </label>

                                                    <h4 class="input-box-title">{{$processBoard->product->name}}</h4>
                                                </div>
                                            </div>
                                            <div class="pms-item flex-10">
                                                <div class="input-block erp-step-input-block mb-0 pre-d-item-input-box">
                                                    <label class="col-form-label">QTY </label>
                                                    <h4 class="input-box-title">{{$processBoard->base_quantity}}</h4>
                                                </div>
                                            </div>
                                            @if($processBoard->extra_quantity)
                                                <div class="pms-item flex-1">
                                                    <div class="input-block erp-step-input-block mb-0 pre-d-item-input-box">
                                                        <i class="fa fa-plus"></i>
                                                    </div>
                                                </div>
                                                <div class="pms-item flex-10">
                                                    <div class="input-block erp-step-input-block mb-0 pre-d-item-input-box">
                                                        <label class="col-form-label"></label>
                                                        <h4 class="input-box-title">{{$processBoard->extra_quantity}}</h4>
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
                                                    <label class="col-form-label">Name </label>
                                                    <h4 class="input-box-title"> {{$outputData->name}}</h4>
                                                </div>
                                            </div>
                                            <div class="pms-item flex-15">
                                                <div class="input-block erp-step-input-block mb-0 pre-d-item-input-box-2">
                                                    <label class="col-form-label">QTY </label>
                                                    <h4 class="input-box-title">{{$outputData->quantity}}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="production-instrucion-output-selection-wrapper">
                                <div class="input-block erp-step-input-block mb-0 pre-d-item-input-box-3">
                                    <label class="col-form-label">Instruction</label>
                                    <h4 class="input-box-title">{{$processData->instruction}}</h4>
                                </div>
                            </div>

                        </div>
                    @endforeach
                    @if(hasPermission('verify-pre-productions'))
                        <div class="d-flex justify-content-center">
                            <div class="production-instrucion-output-selection-wrapper mt-3 p-2 text-center">
                                <button class=" erp-search-btn text-center"  @if($pre_production->is_verified !=$pre_production::VERIFIED_YES) id="verifiedBtn" onclick="preProductionUpdateStatus(this)" data-href="{{ route('production.pre-production.change-status',[$pre_production->id,1]) }}" @endif>
                                    @if($pre_production->is_verified==$pre_production::VERIFIED_YES) Verified @else Verify @endif
                                </button>
                            </div>
                            @if ($pre_production->is_verified !=$pre_production::VERIFIED_YES)
                                <div class="production-instrucion-output-selection-wrapper mt-3 p-2 text-center">
                                    @if($pre_production->is_verified ==$pre_production::VERIFIED_NO)
                                        <button class=" erp-search-btn text-center" id="revisionBtn" onclick="preProductionUpdateStatus(this)" data-href="{{ route('production.board-production.pending-verification.change-status',[$pre_production->id,2]) }}">
                                            Revision</button>
                                    @elseif($pre_production->is_verified ==$pre_production::VERIFIED_REVISION)
                                        <h4 class="erp-search-btn" id="revisionBtn">Revisioned</h4>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endif
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
        function preProductionUpdateStatus(button){
            let url = $(button).attr('data-href');
            
            Swal.fire({
                title: '',
                html: 'Are you sure to update status?',
                showDenyButton: true,
                confirmButtonText: 'Yes',
                denyButtonText: `No`,
            }).then((result) => {
                if (result.isConfirmed) {
                    ajaxGet(url, {}, function (response) {
                        if (response.status == 200) {
                            if(response[0].status == 1){
                            $("#revisionBtn").hide();
                                $("#verifiedBtn").html('Verified');
                                $("#verifiedBtn").prop('disabled',true);
                            }
                            if(response[0].status == 2){
                            $("#revisionBtn").prop('disabled',true);
                            $("#revisionBtn").html('Revisioned');
                            }
                            showSuccessAlert('Success',response.message)
                        } else {
                            toastr.error(response.message);
                        }
                    }, 'default');
                } else if (result.isDenied) {

                }
            })
        }
    </script>
@endsection


