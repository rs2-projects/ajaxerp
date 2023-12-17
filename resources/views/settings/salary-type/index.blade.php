@extends('layouts.settings-layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        <div class="erp-add-employee-wrapper mb-3">
            <div class="erp-add-employee">
                <a href="{{ route('settings.salary-type.create') }}" class="btn add-btn erp-add-employee">
                    <i class="fa-solid fa-plus"></i> Add Salary Type
                </a>
            </div>
        </div>
        <div class="erp-employee-list-wrapper">
            <div class="erp-main-filter-wrapper bg-card attd-table">
                <div class="my-attendance-box-item flex-100 ">
                    <div class="my-attendance-report-wrapper">
                        <div class="erp-header-main-wrap d-flex justify-content-between align-items-center">
                            <div class="erp-box-header">
                                <h4>Salary Type Setting </h4>
                            </div>

                        </div>

                        <div class="big-table pt-4">
                            <div class="de-table-wrapper" id="ajax-data-load">

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

    <script>
        $(document).ready(function(){
            getData();
        });

        function getData(){
            getPaginatedListData("{{ route('settings.salary-type.filtered') }}", "#ajax-data-load");
        }

        function getPaginatedData(button) {
            getPaginatedListData($(button).attr('data-href'), "#ajax-data-load");
        }

    </script>

@endsection


