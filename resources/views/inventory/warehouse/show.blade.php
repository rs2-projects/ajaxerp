@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        <div class="col-md-12">
            <div class="new-warhouse-wrapper">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="warehouse-basic-info bg-card attd-table">
                            <div class="wbi-item">
                                <h2>Warehouse Basic Info</h2>
                            </div>
                            <div class="wbi-item">
                                <div class="wpi-child-item-wrapper d-flex flex-wrap gap-2">
                                    <div class="wpi-child-item flex-100">
                                        <h4 class="warehouse-details-title">{{ $warehouse->name??'N/A' }}</h4>

                                    </div>
                                    <div class="wpi-child-item flex-100">
                                        <p class="warehouse-details-p">
                                            {{$warehouse->description??''}}
                                        </p>
                                    </div>
                                </div>
                            </div>



                            <div class="wbi-item">
                                <div class="new-warehouse-main-wrapper">
                                    @if(count($warehouse->sections) > 0)
                                        @foreach($warehouse->sections as $key=>$section)
                                            <div class="new-warehouse-section-body d-flex flex-wrap gap-2 justify-content-between">
                                                <div class="new-wsb-item flex-40">
                                                    <div class="input-block mb-0 erp-step-input-block">
                                                        <label class="col-form-label">Section {{$key+1}} <span class="text-danger">*</span></label>
                                                        <h4 class="warehouse-details-section-name">{{$section->name??'N/A'}}</h4>
                                                    </div>
                                                </div>
                                                <div class="new-wsb-item flex-58">
                                                    <div class="new-wsb-sub-item-wrapper ">
                                                        <div class="new-wsb-sub-item flex-100">
                                                            <h2>Subsection (Inventory Storage Rack)</h2>
                                                        </div>
                                                        <div class="new-wsb-sub-item">
                                                            <div class="new-wsb-table-header d-flex flex-wrap align-items-center">
                                                                <div class="new-wsb-table-item">
                                                                    <h4>Sl</h4>
                                                                </div>
                                                                <div class="new-wsb-table-item">
                                                                    <h4>Subsection</h4>
                                                                </div>
                                                            </div>
                                                            <div class="new-wsb-table-body">
                                                                @if(count($section->racks) > 0)
                                                                    @foreach($section->racks as $keyR=>$rack)
                                                                        <div class="new-wsb-table-body-item-wrap d-flex flex-wrap align-items-center">
                                                                            <div class="new-wsb-table-body-item">
                                                                                <h5>{{$keyR+1}}</h5>
                                                                            </div>
                                                                            <div class="new-wsb-table-body-item">
                                                                                <div class="input-block mb-0 erp-step-input-block">
                                                                                    <h4 class="warehouse-subsection-name">{{ $rack->name??'N/A' }}</h4>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif

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



