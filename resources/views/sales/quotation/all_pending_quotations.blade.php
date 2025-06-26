@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        <div class="erp-employee-list-wrapper">
            <div class="erp-main-filter-wrapper bg-card attd-table">
                <div class="my-attendance-box-item flex-100 ">
                    <div class="my-attendance-report-wrapper">
                        <div class="my-attendance-report-wrapper">
                            <div class="big-table pt-4">
                                <div class="de-table-wrapper" id="ajax-data-load">
                                    <div class="">
                                        <table class="table mb-0 erp-table">
                                            <thead class="erp-thead">
                                            <tr class="erp-tr">
                                                <th class="erp-th">SL</th>
                                                <th class="erp-th">Quotation No. </th>
                                                <th class="erp-th text-center">Customer </th>
                                                <th class="erp-th text-center">Project Name </th>
                                                <th class="erp-th text-center">Ref No </th>
                                                <th class="erp-th text-center">Date </th>
                                                <th class="erp-th text-center">Amount </th>
                                            </tr>
                                            </thead>
                                            <tbody class="erp-tbody">
                                            @forelse($quotations as $quotation)
                                            <tr class="erp-tbody-tr">
                                                <td class="erp-tbody-td">
                                                    <h4 class="d-table-title">{{ $loop->iteration }}</h4>
                                                </td>
                                                <td class="erp-tbody-td text-start">
                                                    <h4 class="text-start d-table-title"><strong>Quotation No -</strong> <span>{{ $quotation->quotation_no }}</span></h4>
                                                    <small class="text-center d-table-title">{{ getFormattedDate($quotation->created_at) }}</small>
                                                </td>
                                                <td class="erp-tbody-td">
                                                    <div class="em-profile-wrap d-flex align-items-center flex-wrap w-100 justify-content-center">
                                                        <div class="em-pro-img-box">
                                                            <img src="{{ $quotation->customer->show_image }}" alt="">
                                                        </div>
                                                        <div class="em-pro-details-box">
                                                            <h5>{{ $quotation->customer->business_name }}</h5>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="erp-tbody-td text-center">
                                                    <p>{{ $quotation->project_name }}</p>
                                                </td>
                                                <td class="erp-tbody-td text-center">
                                                    <p>{{ $quotation->ref_no }}</p>
                                                </td>
                                                <td class="erp-tbody-td text-center">
                                                    <p>{{ $quotation->quotation_date }}</p>
                                                </td>
                                                <td class="erp-tbody-td text-center">
                                                    <h4 class="text-center d-table-title"><span class="in-t-amount-text">Total - </span>{{ getCurrencySymbol().formatNumber($quotation->payable_amount) }}</h4>
                                                </td>
                                            </tr>
                                            @empty
                                                <tr class="erp-tbody-tr">
                                                    <td class="erp-tbody-td text-center text-primary" colspan="7">
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
        // var filterData = {
        //     quotation_id: '',
        //     status_filter: '',
        //     start_date_filtered:'',
        //     end_date_filtered:'',
        // };
        // $(document).ready(function() {
        //     getData();
        //     initializeDatepicker()
        //     filterData.quotation_id = $("#quotation_id").val()
        //     $("#quotation_id").on('input', function () {
        //         filterData.quotation_id = $(this).val();
        //     });
        //     filterData.status_filter = $("#status_filter").val()
        //     $("#status_filter").on('input', function () {
        //         filterData.status_filter = $(this).val();
        //     });
        //     $('#start_date_filtered').on('dp.change', function(e){
        //         filterData.start_date_filtered = $(this).val();
        //     });
        //     $('#end_date_filtered').on('dp.change', function(e){
        //         filterData.end_date_filtered = $(this).val();
        //     });

        // });
        
        // //get filtered data
        // function getData(){
        //     getPaginatedListData("{{ route('sales.quotation.filtered') }}", "#ajax-data-load", filterData);
        // }
        // //get paginated data
        // function getPaginatedData(button) {
        //     getPaginatedListData($(button).attr('data-href'), "#ajax-data-load", filterData);
        // }
    </script>
@endsection
