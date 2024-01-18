@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        <div class="erp-employee-list-wrapper">
            <div class="erp-main-filter-wrapper bg-card attd-table">
                <div class="my-attendance-box-item flex-100 ">
                    <div class="my-attendance-report-wrapper">
                        <div class="table-main-wrapper pt-4" id="ajax-data-load">
                            <div class="table-header-wrapper d-flex flex-wrap">
                                <div class="table-header-item em-list">
                                    <h4>Date</h4>
                                </div>
                                <div class="table-header-item em-list text-start">
                                    <h4>Salary Set</h4>
                                </div>
                                <div class="table-header-item em-list text-center">
                                    <h4>Total Employee</h4>
                                </div>
                                <div class="table-header-item em-list text-center">
                                    <h4>Total Overtime</h4>
                                </div>
                                <div class="table-header-item em-list text-center">
                                    <h4>Total Amount</h4>
                                </div>
                                <div class="table-header-item em-list text-center">
                                    <h4>Generated At</h4>
                                </div>
                                <div class="table-header-item em-list text-center">
                                    <h4>Generated Status</h4>
                                </div>
                                <div class="table-header-item em-list text-center">
                                    <h4>Action</h4>
                                </div>
                            </div>
                            <div class="table-body-wrapper">
                                <div class="table-body-item-wrapper d-flex justify-content-center">
                                    <span class="text-danger text-center">
                                        No Data Available
                                    </span>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>


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

@endsection


