@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        <form action="{{ route('procurement.purchase-investigation.update',$purchase->id) }}" id="investigationUpdateForm" method="post" enctype="multipart/form-data">
            @csrf
            <div class="erp-employee-list-wrapper">
                <div class="erp-main-filter-wrapper bg-card attd-table">
                    <div class="my-attendance-box-item flex-100 ">
                        <div class="my-attendance-report-wrapper">
                            <div class="big-table pt-4">
                                <div class="de-table-wrapper">
                                    <div class="table-responsive">
                                        <table class="table mb-0 erp-table">
                                            <thead class="erp-thead">
                                            <tr class="erp-tr">
                                                <th class="erp-th">SL</th>
                                                <th class="erp-th">Product Name </th>
                                                <th class="erp-th text-center">Description </th>
                                                <th class="erp-th text-center">Qty </th>
                                                <th class="erp-th text-center">Perfect </th>
                                                <th class="erp-th text-center">Issue </th>

                                            </tr>
                                            </thead>
                                            <tbody class="erp-tbody">
                                            @if($purchase->purchaseDetails->count() > 0)
                                                @foreach($purchase->purchaseDetails as $key=>$purchaseDetail)
                                                    <tr class="erp-tbody-tr">
                                                        <td class="erp-tbody-td">
                                                            <input type="hidden" name="purchase_detail_id[]" value="{{ $purchaseDetail->id }}">
                                                            <h4 class="d-table-title">{{$key+1}}</h4>
                                                        </td>
                                                        <td class="erp-tbody-td text-start">
                                                            <a href="javascript:void(0)" class="em-profile-wrap d-flex align-items-center flex-wrap w-100">
                                                                <div class="em-pro-img-box">
                                                                    <img src="{{ asset($purchaseDetail->productMaterial->show_image) }}" alt="">
                                                                </div>
                                                                <div class="em-pro-details-box">
                                                                    <h5>{{ $purchaseDetail->productMaterial->name??'N/A' }}</h5>
                                                                    <p class="em-id">Code: <span> #{{ $purchaseDetail->productMaterial->code??'N/A' }}</span></p>

                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td class="erp-tbody-td text-center erp-body-description">
                                                            <p class="text-center d-table-text mb-0">{{ getSubStr($purchaseDetail->description??'N/A') }}</p>
                                                        </td>
                                                        <td class="erp-tbody-td text-center">
                                                            <h4 class="text-center d-table-title">{{ $purchaseDetail->qty??0 }}</h4>
                                                        </td>
                                                        <td class="erp-tbody-td text-center">
                                                            <label class="col-form-label">
                                                                <input type="checkbox" name="is_perfect[{{ $key }}]" class="is_perfect" {{ ($purchaseDetail->is_perfect == $purchaseDetail::IS_PERFECT_YES) ? 'checked' : '' }} value="1"> <span class="ms-1">All Perfect</span>
                                                            </label>
                                                        </td>
                                                        <td class="erp-tbody-td text-center">
                                                            <div class="issue-box-wrapper">
                                                                <div class="issue-box-item">
                                                                    <div class="issue-box-child-wrap d-flex align-items-center justify-content-end">
                                                                        <div class="issue-box-child-item">
                                                                            <label class="col-form-label">
                                                                                <input type="checkbox" name="has_damage[{{ $key }}]" class="has_damage" {{ ($purchaseDetail->has_damage == $purchaseDetail::HAS_DAMAGE_YES) ? 'checked' : '' }} value="1"> <span class="ms-1">Damage</span>
                                                                            </label>
                                                                        </div>
                                                                        <div class="issue-box-child-item">
                                                                            <div class="input-block mb-0 erp-step-input-block issue-form-box position-relative">
                                                                                <label class="col-form-label">Qty </label>
                                                                                <input type="number" class="form-control damage_qty" min="0" max="{{ $purchaseDetail->qty }}" name="damage_qty[]" value="{{ $purchaseDetail->damage_qty }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="issue-box-child-item">
                                                                            <div class="input-block mb-0 erp-step-input-block issue-form-box-3 position-relative">
                                                                                <label class="col-form-label">Remarks </label>
                                                                                <input type="text" class="form-control " name="damage_remarks[]" value="{{ $purchaseDetail->damage_remarks }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="issue-box-child-item">
                                                                            <div class="input-block mb-0 erp-step-input-block issue-form-box-2 position-relative">

                                                                                <input type="file" class="form-control " multiple name="file_type_damage[{{ $key }}][]">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="issue-box-item">
                                                                    <div class="issue-box-child-wrap d-flex align-items-center justify-content-end">
                                                                        <div class="issue-box-child-item">
                                                                            <label class="col-form-label">
                                                                                <input type="checkbox" name="has_missing[{{ $key }}]" class="has_missing" {{ ($purchaseDetail->has_missing == $purchaseDetail::HAS_MISSING_YES) ? 'checked' : '' }} value="1"> <span class="ms-1">Missing</span>
                                                                            </label>
                                                                        </div>
                                                                        <div class="issue-box-child-item">
                                                                            <div class="input-block mb-0 erp-step-input-block issue-form-box position-relative">
                                                                                <label class="col-form-label">Qty </label>
                                                                                <input type="number" class="form-control missing_qty" min="0" max="{{ $purchaseDetail->qty }}"  name="missing_qty[]" value="{{ $purchaseDetail->missing_qty }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="issue-box-child-item">
                                                                            <div class="input-block mb-0 erp-step-input-block issue-form-box-3 position-relative">
                                                                                <label class="col-form-label">Remarks </label>
                                                                                <input type="text" class="form-control " name="missing_remarks[]" value="{{ $purchaseDetail->missing_remarks }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="issue-box-child-item">
                                                                            <div class="input-block mb-0 erp-step-input-block issue-form-box-2 position-relative">

                                                                                <input type="file" class="form-control " multiple name="file_type_missing[{{ $key }}][]">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif

                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                            </div>
                            <div class="erp-filter-box d-flex align-items-center justify-content-center flex-100 pt-4">

                                <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-center flex-100">

                                    <div class="erp-filter-item">
                                        <div class="erp-search-btn-wrap">
                                            <button class="erp-search-btn" type="submit">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--End::row-1 -->
@endsection

@section('modals')

@endsection

@section('css')

@endsection

@section('css_plugins')

@endsection

@section('js_plugins')

@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $(document).on('change', '.is_perfect', function () {
                if ($(this).is(':checked')) {
                    $(this).closest('tr').find('.has_damage').prop('checked', false)
                    $(this).closest('tr').find('.has_missing').prop('checked', false);

                    $(this).closest('tr').find('.damage_qty').val(0);
                    $(this).closest('tr').find('.damage_qty').removeAttr('required');
                    $(this).closest('tr').find('.damage_qty').attr('min', 0);

                    $(this).closest('tr').find('.missing_qty').val(0);
                    $(this).closest('tr').find('.missing_qty').removeAttr('required');
                    $(this).closest('tr').find('.missing_qty').attr('min', 0);

                }
            });
            $(document).on('change', '.has_damage', function () {
                if ($(this).is(':checked')) {
                    $(this).closest('tr').find('.is_perfect').prop('checked', false);

                    $(this).closest('tr').find('.damage_qty').attr('required', 'required');
                    $(this).closest('tr').find('.damage_qty').attr('min', 1);


                }
            });
            $(document).on('change', '.has_missing', function () {
                if ($(this).is(':checked')) {
                    $(this).closest('tr').find('.is_perfect').prop('checked', false);
                    $(this).closest('tr').find('.missing_qty').attr('required', 'required');
                    $(this).closest('tr').find('.missing_qty').attr('min', 1);
                }
            });

            $(document).on("submit", "#investigationUpdateForm", function(e) {
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                $(".ie-span").text("").hide();
                var url = $(this).attr('action');


                formPost(url, formData, function (res){
                    if(res.status == 200){
                        showSuccessAlert('Success',res.message)
                        window.location.href = "{{ route('procurement.product-material-purchase.index') }}"
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');
            });

        });
    </script>
@endsection


