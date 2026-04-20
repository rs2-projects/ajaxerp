@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        <div class="erp-employee-list-wrapper">
            <div class="new-production-wrapper bg-card attd-table">
                <div class="product-general-info-box d-flex flex-wrap pd-box">
                    @if(hasPermission('deliver-requested-materials'))
                        @if($pre_production->delivery_status != $pre_production::DELIVERY_STATUS_DELIVERED)
                            <div class="erp-add-employee-wrapper mb-3 flex-100">
                                <div class="erp-add-employee">
                                    <a href="{{ route('inventory.material-request.deliver', $pre_production->id) }}" class="btn add-btn erp-add-employee"><i class="la la-hand-o-right m-r-5"></i> Deliver</a>
                                </div>
                            </div>
                        @endif
                    @endif
                    
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
                            <p>{{$pre_production->description ?? 'N/A'}}</p>
                        </div>
                    </div>
                </div>
                <div class="pd-table-box">
                    <div class="pd-table-box-item-wrapper">
                        @if($deliveries->count() > 0 || $board_deliveries->count() > 0)
                            @foreach ($deliveries as $data )
                                <div class="pd-table-box-item">
                                    <div class="pd-deliver-date-box">
                                        <p>Material Delivery: <span>{{ getFormattedDate($data->delivery_date, 'd M, Y') }}</span></p>
                                    </div>
                                    <div class="my-attendance-report-wrapper">
                                        <div class="big-table">
                                            <div class="de-table-wrapper">
                                                <div class="table-responsive">
                                                    <table class="table mb-0 erp-table">
                                                        <thead class="erp-thead">
                                                            <tr class="erp-tr">
                                                                <th class="erp-th">Category </th>
                                                                <th class="erp-th text-center">Item Name </th>
                                                                <th class="erp-th text-center">Requested Qty </th>
                                                                <th class="erp-th text-center">Delivered Qty </th>
                                                                {{-- <th class="text-center erp-th">Item Delivered</th> --}}
                                                                <th class="text-center erp-th">Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="erp-tbody">
                                                            @foreach ($data->delivery_details as $details)
                                                                <tr class="erp-tbody-tr">
                                                                    <td class="erp-tbody-td text-start">
                                                                        <h4 class="text-start d-table-title">{{$details->material->category->name}}</h4>
                                                                    </td>
                                                                    <td class="erp-tbody-td text-center">
                                                                        <h4 class="text-center d-table-title">{{$details->material->product->name}}</h4>
                                                                    </td>
                                                                    <td class="erp-tbody-td text-center">
                                                                        <h4 class="text-center d-table-title">{{$details->material->quantity}}</h4>
                                                                    </td>
                                                                    <td class="erp-tbody-td text-center">
                                                                        <h4 class="text-center d-table-title">{{$details->quantity}}</h4>
                                                                    </td>
                                                                    {{-- <td class="erp-tbody-td text-center">
                                                                        <div class="pd-recived-product-wrapper">
                                                                            <div class="pre-counter">
                                                                                <span>{{$details->quantity}}</span>
                                                                            </div>
                                                                            <div class="pd-recived-product-scrol-box">
                                                                                @foreach ($details->items as $item)
                                                                                    <div class="pd-recived-product-item d-flex  align-items-center gap-2">
                                                                                        <div class="pd-recived-product-c-item">
                                                                                            <p class="mb-0">{{$item->barcode}}</p>
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                    </td> --}}
                                                                    <td class="erp-tbody-td text-center">
                                                                        <div class="pd-st-box {{strtolower($details::RECEIVEDS[$details->received_status])}}"><p>{{ $details::RECEIVEDS[$details->received_status] }}</p></div>
                                                                    </td>
                                                                    
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            @foreach ($board_deliveries as $data )
                                <div class="pd-table-box-item">
                                    <div class="pd-deliver-date-box">
                                        <p>Board Delivery: <span>{{ getFormattedDate($data->delivery_date, 'd M, Y') }}</span></p>
                                    </div>
                                    <div class="my-attendance-report-wrapper">
                                        <div class="big-table">
                                            <div class="de-table-wrapper">
                                                <div class="table-responsive">
                                                    <table class="table mb-0 erp-table">
                                                        <thead class="erp-thead">
                                                            <tr class="erp-tr">
                                                                <th class="erp-th">Category </th>
                                                                <th class="erp-th text-center">Item Name </th>
                                                                <th class="erp-th text-center">Requested Qty </th>
                                                                <th class="erp-th text-center">Delivered Qty </th>
                                                                {{-- <th class="text-center erp-th">Item Delivered</th> --}}
                                                                <th class="text-center erp-th">Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="erp-tbody">
                                                            @foreach ($data->board_delivery_details as $details)
                                                                <tr class="erp-tbody-tr">
                                                                    <td class="erp-tbody-td text-start">
                                                                        <h4 class="text-start d-table-title">{{$details->board->category->name}}</h4>
                                                                    </td>
                                                                    <td class="erp-tbody-td text-center">
                                                                        <h4 class="text-center d-table-title">{{$details->board->product->name}}</h4>
                                                                    </td>
                                                                    <td class="erp-tbody-td text-center">
                                                                        <h4 class="text-center d-table-title">{{$details->board->quantity}}</h4>
                                                                    </td>
                                                                    <td class="erp-tbody-td text-center">
                                                                        <h4 class="text-center d-table-title">{{$details->quantity}}</h4>
                                                                    </td>
                                                                    {{-- <td class="erp-tbody-td text-center">
                                                                        <div class="pd-recived-product-wrapper">
                                                                            <div class="pre-counter">
                                                                                <span>{{$details->quantity}}</span>
                                                                            </div>
                                                                            <div class="pd-recived-product-scrol-box">
                                                                                @foreach ($details->items as $item)
                                                                                    <div class="pd-recived-product-item d-flex  align-items-center gap-2">
                                                                                        <div class="pd-recived-product-c-item">
                                                                                            <p class="mb-0">{{$item->barcode}}</p>
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                    </td> --}}
                                                                    <td class="erp-tbody-td text-center">
                                                                        <div class="pd-st-box {{strtolower($details::RECEIVEDS[$details->received_status])}}"><p>{{ $details::RECEIVEDS[$details->received_status] }}</p></div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <tr class="erp-tbody-tr">
                                <td class="erp-tbody-td text-center text-primary" colspan="6">
                                    No data found
                                </td>
                            </tr>
                        @endif
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
    </style>
@endsection

@section('css_plugins')

@endsection

@section('js_plugins')

@endsection

@section('js')
    <script>
        
    </script>
@endsection


