@extends('production-staff.layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        <div class="erp-add-employee-wrapper mb-3">
            <div class="erp-add-employee">
                <a href="{{ route('production-staff.requisition.create') }}" class="btn add-btn erp-add-employee ms-2"><i class="fa-solid fa-plus"></i> Create Requisition</a>
            </div>
        </div>
        <div class="erp-employee-list-wrapper">
            <div class="erp-main-filter-wrapper bg-card attd-table">
                <div class="my-attendance-box-item flex-100 ">
                    <div class="my-attendance-report-wrapper">
                        <div class="my-attendance-report-wrapper" id="ajax-data-load">
                            
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
        var filterData = {
            keyword_filtered: '',
            status_filtered: '',
        };
        $(document).ready(function() {
            getData();
        });

        function getData(){
            getPaginatedListData("{{ route('production-staff.requisition.filtered') }}", "#ajax-data-load", filterData);
        }

        function getPaginatedData(button) {
            getPaginatedListData($(button).attr('data-href'), "#ajax-data-load", filterData);
        }
    </script>
@endsection


