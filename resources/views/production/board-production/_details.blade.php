@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">	
        <div class="erp-employee-list-wrapper">
            <div class="new-production-wrapper bg-card attd-table">
                <div class="product-general-info-box d-flex flex-wrap pd-box">
                    <div class="pgib-item flex-32 pd-item">
                        <div class="input-block erp-step-input-block mb-0">
                            <label class="col-form-label">Batch No</label>
                            <h4>{{$pre_production->pre_production_batch_no}}</h4>
                        </div>
                    </div>
                    <div class="pgib-item flex-32 pd-item">
                        <div class="input-block erp-step-input-block mb-0">
                            <label class="col-form-label">Product (Finished Product)</label>
                            <h4>{{$pre_production->finishedGoods->name}}</h4>
                        </div>
                    </div>
                    <div class="pgib-item flex-32 pd-item">
                        <div class="input-block erp-step-input-block mb-0">
                            <label class="col-form-label">Estimated Output QTY </label>
                            <h4>{{$pre_production->estimated_production_qty}}</h4>
                        </div>
                    </div>
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
                    <div class="pgib-item flex-100 pd-item">
                        <div class="input-block erp-step-input-block mb-0">
                            <label class="col-form-label">Note</label>
                            <h4>{{ !empty($pre_production->notes) ? $pre_production->notes : 'N/A'}}</h4>
                        </div>
                    </div>
                </div>
                <div class="product-process-main-item-wrapper">
                    @foreach ($pre_production->process as $processKey=> $processData)
                        <div class="production-process-wrapper">
                            <div class="production-process-status-wrapper d-flex justify-content-between align-items-center">
                                <h4>Material</h4>
                                @if($processData->process_status == $processData::PROCESS_STATUS_PENDING )
                                    {{-- @if(hasPermission('manage-processes'))
                                        <a href="javascript:void(0)" onclick="changeStatus('{{ route('production.board-production.update-process-status',[$pre_production->id,$processData->id,1]) }}')" class="start-process-btn">Start Process</a>
                                    @endif --}}
                                    <p class="start-process-btn">Pending</p>
                                @elseif($processData->process_status == $processData::PROCESS_STATUS_PROCESSING)
                                    {{-- @if(hasPermission('manage-processes')) 
                                        <a href="javascript:void(0)" onclick="changeStatus('{{ route('production.board-production.update-process-status',[$pre_production->id,$processData->id,2]) }}')" class="complete-process-btn">Complete Process</a>
                                    @endif --}}
                                    <p class="complete-process-btn">Processing</p>
                                @else
                                <p class="rs-pre-completed-process">Completed Process</p>
                                @endif
                            </div>
                            <div class="production-matarial-selection-wrappers">
                                <div class="pms-item-main-wrapper">
                                    @foreach ($processData->materials as $processMaterial)
                                        <div class="pms-item-wrapper d-flex flex-wrap align-items-end pre-d-item-wrapper">
                                            <div class="pms-item flex-32">
                                                <div class="input-block erp-step-input-block mb-0 pre-d-item-input-box">
                                                    <label class="col-form-label">Category</label>
                                                    <h4 class="input-box-title">{{$processMaterial->category->name}}</h4>
                                                </div>
                                            </div>
                                            <div class="pms-item flex-32">
                                                <div class="input-block erp-step-input-block mb-0 pre-d-item-input-box">
                                                    <label class="col-form-label">Matarial</label>
                                                
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


