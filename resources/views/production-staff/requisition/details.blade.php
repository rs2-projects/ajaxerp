@extends('production-staff.layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        <div class="erp-employee-list-wrapper">
            <div class="new-production-wrapper bg-card attd-table">
                <div class="product-general-info-box d-flex flex-wrap pd-box">
                   
                    @if($requisition->hasPendingReceived())
                        <div class="erp-add-employee-wrapper mb-3 flex-100">
                            <div class="erp-add-employee">
                                <a href="{{ route('inventory.material-request.deliver', $requisition->id) }}" class="btn add-btn erp-add-employee"><i class="la la-hand-o-right m-r-5"></i> Receive</a>
                            </div>
                        </div>
                    @endif
                    
                    <div class="pgib-item flex-32 pd-item">
                        <div class="input-block erp-step-input-block mb-0">
                            <label class="col-form-label">Requisition No</label>
                            <h4>#{{ $requisition->requisition_no }}</h4>
                        </div>
                    </div>
                    <div class="pgib-item flex-32 pd-item">
                        <div class="input-block erp-step-input-block mb-0">
                            <label class="col-form-label">Date</label>
                            <h4>{{ !empty($requisition->created_at) ? getFormattedDate($requisition->created_at, 'd M, Y') : 'N/A' }}</h4>
                        </div>
                    </div>
                    <div class="pgib-item flex-32 pd-items">
                    </div>
                    <div class="pgib-item flex-100 pd-item">
                        <div class="input-block erp-step-input-block mb-0">
                            <label class="col-form-label">Description</label>
                            <p>{{ $requisition->description ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
                <div class="pd-table-box">
                    <div class="pd-table-box-item-wrapper">
                        <div class="pd-table-box-item">
                            <div class="my-attendance-report-wrapper">
                                <div class="big-table">
                                    <div class="de-table-wrapper">
                                        <div class="table-responsive">
                                            <table class="table mb-0 erp-table">
                                                <thead class="erp-thead">
                                                    <tr class="erp-tr">
                                                        <th class="erp-th">Category </th>
                                                        <th class="erp-th text-center">Item Name </th>
                                                        <th class="erp-th text-center">Qty </th>
                                                        <th class="erp-th text-center">Delivered Qty </th>
                                                        <th class="text-center erp-th">Received Qty</th>
                                                        <th class="text-center erp-th">Received Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="erp-tbody">
                                                    @if($requisition->details->count() > 0)
                                                        @foreach ($requisition->details as $details )
                                                            <tr class="erp-tbody-tr">
                                                                <td class="erp-tbody-td text-start">
                                                                    <h4 class="text-start d-table-title">{{ $details->product->category->name }}</h4>
                                                                </td>
                                                                <td class="erp-tbody-td text-center">
                                                                    <h4 class="text-center d-table-title">{{ $details->product->name }}</h4>
                                                                </td>
                                                                <td class="erp-tbody-td text-center">
                                                                    <h4 class="text-center d-table-title">{{ $details->qty }}</h4>
                                                                </td>
                                                                <td class="erp-tbody-td text-center">
                                                                    <h4 class="text-center d-table-title">{{ $details->delivered_qty }}</h4>
                                                                </td>
                                                                <td class="erp-tbody-td text-center">
                                                                    <h4 class="text-center d-table-title">{{ $details->received_qty }}</h4>
                                                                </td>
                                                                <td class="erp-tbody-td text-center">
                                                                    <span class="delivery-status status-{{ strToClassName($details::RECEIVED_STATUSES[$details->received_status] ?? '') }}">
                                                                        {{ $details::RECEIVED_STATUSES[$details->received_status] ?? '' }}
                                                                    </span>
                                                                </td>
                                                                
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr class="erp-tbody-tr">
                                                            <td class="erp-tbody-td text-center text-primary" colspan="6">
                                                                No data found
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
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


