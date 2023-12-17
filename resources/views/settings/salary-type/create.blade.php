@extends('layouts.settings-layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">

        <div class="erp-employee-list-wrapper">
            <div class="erp-main-filter-wrapper d-flex justify-content-center ">
                <div class="erp-add-em-step-wrapper bg-card flex-100">
                    <div class="erp-step-content-wrapper">
                        <div id="reg-employee">
                            <form action="{{ route('settings.salary-type.store') }}" id="salaryTypeStoreForm" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-4">
                                            <div class="erp-filter-item flex-100">
                                                <h4 class="offcanvas-title-erp">Type</h4>
                                            </div>
                                            <div class="erp-filter-item flex-48">
                                                <div class="input-block mb-0 erp-step-input-block">
                                                    <label class="col-form-label">Title<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="title" placeholder="Title" required>
                                                    <span class="title_error ie-span"></span>
                                                </div>
                                            </div>
                                            <div class="erp-filter-item flex-48">
                                                <div class="input-block mb-0 erp-step-input-block">
                                                    <label class="col-form-label">Description </label>
                                                    <textarea class="form-control" name="description" rows="1"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="erp-filter-item flex-100 position-relative mb-1">
                                            <h4 class="offcanvas-title-erp">Type Details</h4>

                                        </div>
                                        <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between ">
                                            {{--<div class="erp-filter-item flex-100 position-relative">
                                                <a href="javascript:void(0)" class="add-tds">1</a>
                                            </div>--}}
                                            <div id="salaryTypeDetailWrapMain" class="d-flex flex-wrap flex-100">
                                                <div class="erp-deduction-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between flex-100">
                                                    <div class="erp-filter-item flex-30">
                                                        <div class="input-block erp-step-input-block mb-0 two">
                                                            <label class="col-form-label">Type <span class="text-danger">*</span> </label>
                                                            <select class="select select-step detail_type" name="detail_type[]" required>
                                                                <option value="">Select Type</option>
                                                                <option value="0">Earning/Allowance</option>
                                                                <option value="1">Deduction</option>
                                                            </select>
                                                            <span class="type_error ie-span"></span>
                                                        </div>
                                                    </div>

                                                    <div class="erp-filter-item flex-30">
                                                        <div class="input-block mb-0 erp-step-input-block ">
                                                            <label class="col-form-label">Title </label>
                                                            <input type="text" class="form-control detail_title" required name="detail_title[]"  placeholder="Title">
                                                            <span class="detail_title_error ie-span"></span>
                                                        </div>
                                                    </div>
                                                    <div class="erp-filter-item flex-30">
                                                        <div class="input-block mb-0 erp-step-input-block ">
                                                            <label class="col-form-label">Value </label>
                                                            <input type="number" step="any" name="detail_value[]" required  class="form-control detail_value" >
                                                            <span class="detail_value_error ie-span"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="erp-filter-item flex-100 position-relative text-center py-3">
                                            <a href="javascript:void(0)" onclick="addTypeDetail()" class="add-tds position-relative add-more-custom"> <i class="fa-solid fa-plus"></i> </a>
                                        </div>
                                    </div>
                                    <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-3 flex-100">

                                        <div class="erp-filter-item flex-100 mt-4">
                                            <div class="erp-search-btn-wrap text-center">
                                                <button class=" erp-search-btn text-center">Save</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <!--End::row-1 -->

    <div id="salaryTypeDetailWrap" style="display: none">
        <div class="erp-deduction-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between flex-100 mt-3">
            <div class="erp-filter-item flex-30">
                <div class="input-block erp-step-input-block mb-0 two">
                    <label class="col-form-label">Type <span class="text-danger">*</span> </label>
                    <select class="detail_type select2" name="detail_type[]" required>
                        <option value="">Select Type</option>
                        <option value="0">Earning/Allowance</option>
                        <option value="1">Deduction</option>
                    </select>
                    <span class="type_error ie-span"></span>
                </div>
            </div>

            <div class="erp-filter-item flex-30">
                <div class="input-block mb-0 erp-step-input-block ">
                    <label class="col-form-label">Title </label>
                    <input type="text" class="form-control detail_title" required name="detail_title[]" id="detail_title" placeholder="Title">
                    <span class="detail_title_error ie-span"></span>
                </div>
            </div>
            <div class="erp-filter-item flex-30">
                <div class="input-block mb-0 erp-step-input-block ">
                    <label class="col-form-label">Value </label>
                    <input type="number" step="any"  name="detail_value[]" required id="detail_value" class="form-control detail_value" >
                    <span class="detail_value_error ie-span"></span>
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
        $(document).ready(function() {
            $("#salaryTypeStoreForm").on('submit', function (e) {
                var self = this;
                e.preventDefault();
                var formData = new FormData($(self)[0]);
                $(".ie-span").text("").hide();
                var url = $(self).attr('action');

                formPost(url, formData, function (res) {
                    $(self)[0].reset();
                    showSuccessAlert('Success', res.message)
                     window.location.href = "{{ route('settings.salary-type.create') }}";
                }, 'show_input_error');
            });
        });

        function addTypeDetail() {
            var item = $('#salaryTypeDetailWrap').html();

            $('#salaryTypeDetailWrapMain').append(item);
            initializeSelect();

        }

        function initializeSelect() {
            $('#salaryTypeDetailWrapMain .detail_type.select2').select2({
                minimumResultsForSearch: -1,
                width: '100%'
            });
        }

    </script>

@endsection


