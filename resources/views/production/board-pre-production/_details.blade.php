@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">	
        <div class="erp-employee-list-wrapper">
            <div class="new-production-wrapper bg-card attd-table">
                <div class="product-general-info-box d-flex flex-wrap pd-box">
                    <div class="erp-add-employee-wrapper mb-3 flex-100">
                        <div class="erp-add-employee">
                            <a href="{{ route('production.board-pre-production.edit',$item->id) }}" class="btn add-btn erp-add-employee"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                        </div>
                    </div>
                    <div class="pgib-item flex-32 pd-item">
                        <div class="input-block erp-step-input-block mb-0">
                            <label class="col-form-label">Product (Finished Product)</label>
                            <h4>{{$item->finishedGoods->name}}</h4>
                        </div>
                    </div>
                    <div class="pgib-item flex-32 pd-item">
                        <div class="input-block erp-step-input-block mb-0">
                            <label class="col-form-label">Estimated Output QTY </label>
                            <h4>{{$item->estimated_quantity}}</h4>
                        </div>
                    </div>
                    <div class="pgib-item flex-32 pd-item">
                        <div class="input-block erp-step-input-block mb-0">
                            <label class="col-form-label">Production Staff</label>
                            <h4>
                                {{ !empty($item->staff->title) ?  $item->staff->title . ' (' . $item->staff->user_name . ')' : 'N/A'}}
                            </h4>
                        </div>
                    </div>
                    <div class="pgib-item flex-32 pd-item">
                        <div class="input-block erp-step-input-block mb-0">
                            <label class="col-form-label">Machine </label>
                            <h4>{{ $item->machine?->name??'N/A' }}</h4>
                        </div>
                    </div>
                    <div class="pgib-item flex-100 pd-item">
                        <div class="input-block erp-step-input-block mb-0">
                            <label class="col-form-label">Note</label>
                            <h4>{{ !empty($item->note)? $item->note : 'N/A'}}</h4>
                        </div>
                    </div>
                </div>
                <div class="product-process-main-item-wrapper">
                        <div class="production-process-wrapper">
                            <div class="production-process-status-wrapper d-flex justify-content-between align-items-center">
                                <h4>Material</h4>
                            </div>
                            <div class="production-matarial-selection-wrappers">
                                <div class="pms-item-main-wrapper">
                                    @foreach ($item->board_materials as $product)
                                        <div class="pms-item-wrapper d-flex flex-wrap align-items-end pre-d-item-wrapper">
                                            <div class="pms-item flex-15">
                                                <div class="input-block erp-step-input-block mb-0 pre-d-item-input-box">
                                                    <label class="col-form-label">Type </label>
                                                    <h4 class="input-box-title">{{$product::TYPES[$product->type]}}</h4>
                                                </div>
                                            </div>
                                            <div class="pms-item flex-32">
                                                <div class="input-block erp-step-input-block mb-0 pre-d-item-input-box">
                                                    <label class="col-form-label">Category</label>
                                                    <h4 class="input-box-title">{{ $product->product_category?->name }}</h4>
                                                </div>
                                            </div>
                                            <div class="pms-item flex-32">
                                                <div class="input-block erp-step-input-block mb-0 pre-d-item-input-box">
                                                    <label class="col-form-label">Matarial</label>
                                                
                                                    <h4 class="input-box-title">{{ $product->product_material?->name }}</h4>
                                                </div>
                                            </div>
                                            <div class="pms-item flex-10">
                                                <div class="input-block erp-step-input-block mb-0 pre-d-item-input-box">
                                                    <label class="col-form-label">QTY </label>
                                                    <h4 class="input-box-title">{{ $product->quantity }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
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
                            setTimeout(function () {
                                location.reload();
                            }, 100);
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


