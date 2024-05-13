@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        <div class="erp-employee-list-wrapper">
            <div class="new-production-wrapper bg-card attd-table">
                <form action="{{route('production.board-pre-production.update', $pre_production->id)}}" id="preProductionUpdateForm" method="POST">
                    @csrf
                    <div class="product-selection-info-box d-flex flex-wrap" style="padding-right: 0px">
                        <div class="row w-100">
                            <div class="col-md-4">
                                <div class="input-block erp-step-input-block mb-0">
                                    <label class="col-form-label">Code <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="code" value="{{$board->code}}" placeholder="Enter Code" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-block erp-step-input-block mb-0">
                                    <label class="col-form-label">Machine Selection <span class="text-danger">*</span></label>
                                    <select class="select select-step select2" name="machine_id">
                                        <option value="">Select Machine</option>
                                        @foreach ($machines as $machine)
                                            <option value="{{$machine->id}}" {{( $machine->id == $pre_production->machine_id) ? 'selected' : ''}}>{{$machine->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-block erp-step-input-block mb-0">
                                    <label class="col-form-label">Staff <span class="text-danger">*</span></label>
                                    <select class="select select-step select2" name="staff_id">
                                        <option value="">Select Staff</option>
                                        @foreach ($staffs as $staff)
                                            <option value="{{$staff->id}}" {{( $staff->id == $pre_production->staff_id) ? 'selected' : ''}}>{{$staff->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row w-100">
                            <div class="col-12">
                                <label class="col-form-label">Product Description</label>
                                <textarea rows="1"  name="product_description"  class="form-control">{{$board->description}}</textarea>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="production-process-wrapper process-wrapper">
                            <h4 class="process-child-title">Material</h4>
                            <div class="materialWraper pms-item-main-wrapper">
                                <div class=" pms-item-wrapper d-flex flex-wrap align-items-end">
                                    <div class="pms-item flex-32">
                                        <div class="input-block erp-step-input-block mb-0">
                                            <label class="col-form-label">Raw Boards <span class="text-danger">*</span> </label>
                                            <select class="select select-step" name="product_material_id[]" required>
                                                <option value="">Select Board</option>
                                                @foreach ($boards as $board)
                                                    <option value="{{ $board->id }}" {{( $raw_board_id->product_material_id == $board->id) ? 'selected' : ''}}>{{ $board->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <input type="hidden" name="quantity[]" value="1" class="form-control">
                                        <input type="hidden" name="type[]" value="0" class="form-control">
                                    </div>

                                    <div class="pms-item flex-32">
                                        <div class="input-block erp-step-input-block mb-0">
                                            <label class="col-form-label">Plate Up <span class="text-danger">*</span> </label>
                                            <select name="plate_up" class="select select-step material-product" required>
                                                <option value="">Select Plate Up</option>
                                                @foreach ($plates as $plate)
                                                    <option value="{{ $plate->id }}" {{( $board->embossed_up == $plate->id) ? 'selected' : ''}}>{{ $plate->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="pms-item flex-32">
                                        <div class="input-block erp-step-input-block mb-0">
                                            <label class="col-form-label">Plate Down <span class="text-danger">*</span> </label>
                                            <select name="plate_down" class="select select-step material-product" required>
                                                <option value="">Select Plate Down</option>
                                                @foreach ($plates as $plate)
                                                    <option value="{{ $plate->id }}" {{( $board->embossed_down == $plate->id) ? 'selected' : ''}}>{{ $plate->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="pms-item flex-100 mt-3">
                                        <div class="d-flex">
                                            <div class="flex-50">
                                                <div class="d-flex pe-3">
                                                    <input type="hidden" name="type[]" value="1" class="form-control">
                                                    <div class="pms-item flex-80">
                                                        <div class="input-block erp-step-input-block mb-0">
                                                            <label class="col-form-label">Paper Up <span class="text-danger">*</span> </label>
                                                            <select name="product_material_id[]" class="select select-step material-product" required>
                                                                <option value="">Select Paper Up</option>
                                                                @foreach ($papers as $paper)
                                                                    <option value="{{ $paper->id }}" {{( $paper_up_id->product_material_id == $paper->id) ? 'selected' : ''}}>{{ $paper->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="pms-item flex-20 ps-2">
                                                        <div class="input-block erp-step-input-block mb-0">
                                                            <label class="col-form-label">QTY <span class="text-danger">*</span> </label>
                                                            <input type="number" name="quantity[]" value="{{$paper_up_id->quantity}}" min="1" class="form-control" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-50">
                                                <div class="d-flex ps-3">
                                                    <input type="hidden" name="type[]" value="2" class="form-control">
                                                    <div class="pms-item flex-80">
                                                        <div class="input-block erp-step-input-block mb-0">
                                                            <label class="col-form-label">Paper Down <span class="text-danger">*</span> </label>
                                                            <select name="product_material_id[]" class="select select-step material-product" required>
                                                                <option value="">Select Paper Down</option>
                                                                @foreach ($papers as $paper)
                                                                    <option value="{{ $paper->id }}" {{( $paper_down_id->product_material_id == $paper->id) ? 'selected' : ''}}>{{ $paper->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="pms-item flex-20 ps-2">
                                                        <div class="input-block erp-step-input-block mb-0">
                                                            <label class="col-form-label">QTY <span class="text-danger">*</span> </label>
                                                            <input type="number" name="quantity[]" value="{{$paper_down_id->quantity}}" min="1" class="form-control" required>
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

                    <div class="row w-100 mt-3">
                        <div class="col-12">
                            <label class="col-form-label">Production Description</label>
                            <textarea rows="1"  name="production_description" class="form-control">{{$pre_production->note}}</textarea>
                        </div>
                    </div>
                    <div class="production-instrucion-output-selection-wrapper mt-3 p-2 text-center">
                        <button class=" erp-search-btn text-center">Save Pre Production</button>
                    </div>
                <form>
            </div>
        </div>
    </div>

@endsection

@section('modals')

@endsection

@section('css')
    <style>
        .prod-p-staff{
            width: 48%;
        }
    </style>
@endsection

@section('css_plugins')

@endsection

@section('js_plugins')
    <script src="{{asset('assets')}}/plugins/multipleselect/multiple-select.js"></script>
    <script src="{{asset('assets')}}/plugins/multipleselect/multi-select.js"></script>

    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            initSelect2();
            $("#preProductionUpdateForm").on('submit', function (e) {
                var self = this;
                e.preventDefault();
                var formData = new FormData($(self)[0]);
                $(".ie-span").text("").hide();
                var url = $(self).attr('action');

                formPost(url, formData, function (res) {
                    if(res.status == 200){
                        showSuccessAlert('Success',res.message)
                        setTimeout(function () {
                           window.location.href = "{{route('production.board-pre-production.index')}}";
                        }, 1000);
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');

            });
        });

        function initSelect2() {
            $('.select-step').select2({
                minimumResultsForSearch: -1,
                width: '100%',
            });
        }
    </script>
@endsection


