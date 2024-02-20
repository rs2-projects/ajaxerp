@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        @if(hasPermission('manage-warehouse'))
            <div class="col-md-12 mb-3">
                <div class="erp-add-employee-wrapper  warehouse-add">
                    <div class="erp-add-employee">
                        <a href="{{ route('inventory.warehouse.create') }}" class="btn add-btn erp-add-employee" ><i class="fa-solid fa-plus"></i> New Warehouse</a>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-md-12">
            <div class="warehouse-list-main-wrapper" id="ajax-data-load">

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
        var filterData = {
            keyword_filtered: ''
        };
        $(document).ready(function() {
            getData();
        });

        function getData(){
            getPaginatedListData("{{ route('inventory.warehouse.filtered') }}", "#ajax-data-load", filterData);
        }

        function getPaginatedData(button) {
            getPaginatedListData($(button).attr('data-href'), "#ajax-data-load", filterData);
        }

    </script>
@endsection


