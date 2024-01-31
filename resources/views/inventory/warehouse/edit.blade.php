@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        <div class="col-md-12">
            <div class="new-warhouse-wrapper">
                <div class="row justify-content-center">
                    <form action="{{ route('inventory.warehouse.update',$warehouse) }}" id="warehouseUpdateForm" method="post">
                        @csrf
                        <div class="col-md-12">
                            <div class="warehouse-basic-info bg-card attd-table">
                                <div class="wbi-item">
                                    <h2>Warehouse Basic Info</h2>
                                </div>
                                <div class="wbi-item">
                                    <div class="wpi-child-item-wrapper d-flex gap-2">
                                        <div class="wpi-child-item flex-40">
                                            <div class="input-block mb-0 erp-step-input-block">
                                                <label class="col-form-label">Warehouse Name <span class="text-danger">*</span></label>
                                                <input type="text" name="name" value="{{$warehouse->name}}" required class="form-control ">
                                            </div>
                                        </div>
                                        <div class="wpi-child-item flex-60">
                                            <div class="input-block mb-0 erp-step-input-block">
                                                <label class="col-form-label">Description </label>
                                                <input type="text" value="{{$warehouse->description}}" name="description" class="form-control ">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="wbi-item">
                                    <div class="new-warehouse-main-wrapper">
                                        <div class="add-section-main-wrapper">
                                            @if(count($warehouse->sections) > 0)
                                                @foreach($warehouse->sections as $key=>$section)
                                                    <input type="hidden" name="hidden_section_ids[]" value="{{ $section->id }}">
                                                    <div class="new-warehouse-section-body d-flex flex-wrap gap-2 justify-content-between" data-index="{{$key}}">
                                                        <div class="new-wsb-item flex-40">
                                                            <div class="input-block mb-0 erp-step-input-block">
                                                                <label class="col-form-label">Section  <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control mb-2" value="{{ $section->name }}" name="section_name[{{$key}}]" required placeholder="Section Name here">

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
                                                                        <div class="add-sub-section-main-wrapper">
                                                                            @if(count($section->racks) > 0)
                                                                                @foreach($section->racks as $keyR=>$rack)
                                                                                    <input type="hidden" name="hidden_section_rack_ids[{{$key}}][]" value="{{ $rack->id }}">
                                                                                    <div class="new-wsb-table-body-item-wrap d-flex flex-wrap align-items-center position-relative">
                                                                                        <div class="new-wsb-table-body-item">
                                                                                            <h5>{{$keyR+1}}</h5>
                                                                                        </div>
                                                                                        <div class="new-wsb-table-body-item">
                                                                                            <div class="input-block mb-0 erp-step-input-block">
                                                                                                <input type="text" value="{{ $rack->name }}" name="subsection[{{$key}}][]" required class="form-control subsection_input" placeholder="subsection name here">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="new-wsb-sub-item flex-100">
                                                                    <div class="new-subsection-btn position-relative">
                                                                        <button type="button" onclick="addSubsection(this)" class="add-tds ad-more-row-btn"><i class="fa-solid fa-plus"></i></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="new-warehouse-section-body d-flex flex-wrap gap-2 justify-content-between" data-index="0">
                                                    <div class="new-wsb-item flex-40">
                                                        <div class="input-block mb-0 erp-step-input-block">
                                                            <label class="col-form-label">Section  <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control mb-2" name="section_name[0]" required placeholder="Section Name here">

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
                                                                    <div class="add-sub-section-main-wrapper">
                                                                        <div class="new-wsb-table-body-item-wrap d-flex flex-wrap align-items-center position-relative">
                                                                            <div class="new-wsb-table-body-item">
                                                                                <h5>1</h5>
                                                                            </div>
                                                                            <div class="new-wsb-table-body-item">
                                                                                <div class="input-block mb-0 erp-step-input-block">
                                                                                    <input type="text" name="subsection[0][]" required class="form-control subsection_input" placeholder="subsection name here">
                                                                                </div>
                                                                                {{--<a href="javascript:void(0)" class="remove-subsection-btn"> <i class="fa fa-times-circle"></i> </a>--}}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="new-wsb-sub-item flex-100">
                                                                <div class="new-subsection-btn position-relative">
                                                                    <button type="button" onclick="addSubsection(this)" class="add-tds ad-more-row-btn"><i class="fa-solid fa-plus"></i></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="new-warehouse-section-body-add-btn text-center">
                                            <button class="add-section-wh-btn text-center" type="button" onclick="addSection(this)">Add Section</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="nw-warehouse-add-btn text-center">
                                <button class="erp-search-btn text-center" type="submit">Save Warehouse</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
    <!--End::row-1 -->

    <div class="hidden-add-section-main-wrapper" style="display: none">
        <div class="new-warehouse-section-body d-flex flex-wrap gap-2 justify-content-between">
            <div class="new-wsb-item flex-40">
                <div class="input-block mb-0 erp-step-input-block">
                    <label class="col-form-label">Section  <span class="text-danger">*</span></label>
                    <input type="text" class="form-control mb-2 section_name" name="section_name[]" required placeholder="Section Name here">
                    <a href="javascript:void(0)" onclick="removeSection(this)" class="remove-section-btn">Remove This Section</a>
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
                            <div class="add-sub-section-main-wrapper">
                                <div class="new-wsb-table-body-item-wrap d-flex flex-wrap align-items-center position-relative">
                                    <div class="new-wsb-table-body-item">
                                        <h5>1</h5>
                                    </div>
                                    <div class="new-wsb-table-body-item">
                                        <div class="input-block mb-0 erp-step-input-block">
                                            <input type="text" name="subsection[][]" required class="form-control subsection_input" placeholder="subsection name here">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="new-wsb-sub-item flex-100">
                        <div class="new-subsection-btn position-relative">
                            <button type="button" onclick="addSubsection(this)" class="add-tds ad-more-row-btn"><i class="fa-solid fa-plus"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="hidden-add-sub-section-main-wrapper" style="display:none;">
        <div class="new-wsb-table-body-item-wrap d-flex flex-wrap align-items-center position-relative">
            <div class="new-wsb-table-body-item">
                <h5>1</h5>
            </div>
            <div class="new-wsb-table-body-item">
                <div class="input-block mb-0 erp-step-input-block">
                    <input type="text" name="subsection[][]" required class="form-control subsection_input" placeholder="subsection name here">
                </div>
                <a href="javascript:void(0)" onclick="removeSubSection(this)" class="remove-subsection-btn"> <i class="fa fa-times-circle"></i> </a>
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
        var section_index = {{ count($warehouse->sections) }};

        $(document).ready(function () {
            $("#warehouseUpdateForm").on('submit', function (e) {
                var self = this;
                e.preventDefault();
                var formData = new FormData($(self)[0]);
                $(".ie-span").text("").hide();
                var url = $(self).attr('action');

                formPost(url, formData, function (res) {
                    if(res.status == 200){
                        showSuccessAlert('Success',res.message);
                        setTimeout(function () {
                            window.location.href = "{{ route('inventory.warehouse.index') }}";
                        }, 500);
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');
            });
        });

        function addSection(){
            section_index++;
            // setHiddenSectionIndex(section_index);
            $(".hidden-add-section-main-wrapper .new-warehouse-section-body").attr('data-index', section_index);
            let html = $('.hidden-add-section-main-wrapper').html();
            html = html.replace('section_name[]', 'section_name['+section_index+']');
            html = html.replace('subsection[][]', 'subsection['+section_index+'][]');
            $('.add-section-main-wrapper').append(html);
            setSubSectionSerial(section_index);
        }

        function setHiddenSectionIndex(index) {
            $(".hidden-add-section-main-wrapper .new-warehouse-section-body").attr('data-index', index);
            $(".hidden-add-section-main-wrapper .section_name").attr('name', 'section_name['+index+']');

        }

        function addSubsection(button){
            let index = $(button).closest('.new-warehouse-section-body').attr('data-index');
            let wrapper_element = $(button).closest('.add-section-main-wrapper .new-warehouse-section-body[data-index='+index+']');

            let html = $('.hidden-add-sub-section-main-wrapper').html();
            html = html.replace('subsection[][]', 'subsection['+index+'][]');
            $(wrapper_element).find('.add-sub-section-main-wrapper').append(html);
            setSubSectionSerial(index);
        }

        function removeSubSection(button) {
            let index = $(button).closest('.new-warehouse-section-body').attr('data-index');
            $(button).parent().parent().remove();
            setSubSectionSerial(index);
        }
        function setSubSectionSerial(index) {
            $(".new-warehouse-section-body[data-index="+index+"] .new-wsb-table-body-item-wrap").each(function (i, obj) {
                $(obj).find('.new-wsb-table-body-item h5').text(i+1);
            });
        }

        function removeSection(element){
            let index = $(element).closest('.new-warehouse-section-body').attr('data-index');
           $(element).parent().parent().parent().remove();
        }

    </script>
@endsection



