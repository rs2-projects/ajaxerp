@extends('layouts.layout')
@section('content')
  <!-- Start::row-1 -->
  <div class="row">
    <div class="erp-employee-list-wrapper">
        <div class="erp-main-filter-wrapper bg-card attd-table">
            <div class="my-attendance-box-item flex-100 ">
                <div class="my-attendance-report-wrapper">
                    <div class="my-attendance-report-wrapper" id="ajax-data-load">
                        <div class="big-table pt-4">
                            <div class="de-table-wrapper">
                                <div class="table-responsives">
                                    <table class="table mb-0 erp-table">
                                        <thead class="erp-thead">
                                            <tr class="erp-tr">
                                                <th class="erp-th">SL</th>
                                                <th class="erp-th">Material Name </th>
                                                <th class="erp-th text-center">Purchase Order</th>
                                                <th class="erp-th text-center">Barcode</th>
                                                <th class="erp-th text-center">Picked At</th>
                                                <th class="erp-th text-center">Action </th>
                                            </tr>
                                        </thead>
                                        <tbody class="erp-tbody">
                                            @forelse($items as $data)
                                                <tr class="erp-tbody-tr">
                                                    <td class="erp-tbody-td">
                                                        <h4 class="d-table-title">{{ $loop->iteration }}</h4>
                                                    </td>
                                                    <td class="erp-tbody-td text-start">
                                                        <a href="#" class="em-profile-wrap d-flex align-items-center flex-wrap w-100">
                                                            <div class="em-pro-details-box">
                                                                <h5>{{$data->productMaterial->name}}</h5>
                                                                <p class="em-id">Code: <span> #{{$data->productMaterial->code?? 'N/A'}}</span></p>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td class="erp-tbody-td text-center">
                                                        <a href="{{ route('procurement.product-material-purchase.details', $data->productMaterialPurchaseDetails->product_material_purchase_id) }}" target="_blank" class="em-profile-wrap d-flex align-items-center flex-wrap w-100">
                                                            <div class="em-pro-details-box">
                                                                <h5>{{ $data->productMaterialPurchaseDetails->materialPurchase->purchase_id }}</h5>
                                                                <p class="em-id">Batch: <span> #{{$data->productMaterialPurchaseDetails->materialPurchase->batch_number?? 'N/A'}}</span></p>
                                                            </div>
                                                        </a>
                                                    </td>

                                                    <td class="erp-tbody-td text-center">
                                                        <h4 class="text-center d-table-title">{{ $data->productMaterialPurchaseDetails->barcode }}</h4>
                                                    </td>
                                                    <td class="erp-tbody-td text-center">
                                                        <h4 class="text-center d-table-title">{{ getFormattedDate($data->picked_at) }}</h4>
                                                    </td>
                                                    
                                                    <td class="text-end erp-tbody-td">
                                                        <div class="erp-action-t">
                                                            <div class="dropdown dropdown-action">
                                                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr class="erp-tbody-tr">
                                                    <td class="erp-tbody-td text-center text-primary" colspan="9">
                                                        Data not found..!
                                                    </td>
                                                </tr>
                                            @endforelse
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
<!--End::row-1 -->


</div>
@endsection

@section('modals')
    
@endsection

@section('css')
    <style>
        
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


