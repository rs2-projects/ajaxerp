@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        @if(hasPermission('manage-employees'))
            <div class="erp-add-employee-wrapper mb-3">
                <div class="erp-add-employee">
                    <a href="{{ route('hr.employee.create') }}" class="btn add-btn erp-add-employee ms-2" ><i class="fa-solid fa-plus"></i> Add Employee</a>
                    {{-- <a href="#" class="btn add-btn erp-add-employee ms-2" data-bs-toggle="modal" data-bs-target="#import_employee"><i class="fa-solid fa-plus"></i>Import</a>
                    <a href="#" class="btn add-btn erp-add-employee" ><i class="fa-solid fa-plus"></i> Export</a> --}}
                </div>
            </div>
        @endif
        <div class="erp-employee-list-wrapper">
            <div class="erp-main-filter-wrapper bg-card attd-table">
                <div class="my-attendance-box-item flex-100 ">
                    <div class="my-attendance-report-wrapper">
                        <div class="erp-header-main-wrap d-flex justify-content-between align-items-center">
                            <div class="erp-filter-box d-flex align-items-center justify-content-start flex-100">

                                <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-start flex-100">
                                    <div class="erp-filter-item flex-5">
                                        <h6 class="me-2">Search By: </h6>
                                    </div>

                                    <div class="erp-filter-item flex-30">
                                        <div class="search-box table-search position-relative">
                                            <input class="form-control" type="text" id="keyword_filtered" placeholder=" Name, ID, Phone, Email">
                                            <button class="btn position-absolute search-btn" onclick="getData()" type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
                                        </div>
                                    </div>
                                    <div class="erp-filter-item flex-63 text-end">
                                        <div class="erp-filter-by d-flex align-items-center justify-content-end">
                                            <a href="#" data-bs-toggle="offcanvas" data-bs-target="#filter-by" aria-controls="offcanvasRight"><span class="me-1"><i class="fa-solid fa-arrow-up-wide-short"></i></span>Filter</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-main-wrapper pt-4" id="ajax-data-load">

                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <!--End::row-1 -->

    <div class="offcanvas offcanvas-end bg-card employeeOffcanvas" tabindex="-1" id="filter-by" aria-labelledby="offcanvasRightLabel" data-bs-backdrop="static">
        <div class="offcanvas-header">
          <h5 id="offcanvasRightLabel" class="mb-0">Filter By</h5>
          <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="erp-offcanvas-wrapper">
                <div class="erp-tab-view-wrapper">
                    <div class="erp-off-canvas-search-wrapper">
                        <div class="erp-tab-pane-title-box">
                            <h4>Search By</h4>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry </p>
                        </div>
                        <div class="erp-tab-pane-content-box mt-2 erp-right-offcanvas ">
                            <div class="erp-filter-item flex-100">
                                <div class=" form-focus select-focus custom-form-focus">
                                    <label class="col-form-label">Select Department:</label>
                                    {{-- <select class="select floating select2-box" multiple> 
                                        <option>Web Development</option>
                                        <option>IT Management</option>
                                        <option>Marketing</option>
                                    </select> --}}
                                    <select class="select select-step select2 floating select2-box" name="department_id[]" multiple onchange="getDesignation(this)" id="department_id">
                                        <option value="">Select Department</option>
                                        @foreach($departments as $key=>$department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>                                
                                </div>
                            </div>
                            <div class="erp-filter-item flex-100">
                                <div class=" form-focus select-focus custom-form-focus">
                                    <label class="col-form-label">Select Designation:</label>
                                    {{-- <select class="select floating select2-box" multiple> 
                                        <option>Web Designer</option>
                                        <option>Web Developer</option>
                                        <option>Android Developer</option>
                                    </select> --}}
                                    <select onchange="designationFilter(this)" class="select select-step select2 floating select2-box" name="designation_id[]" id="designation_id" multiple>
                                        <option value=""></option>
                                    </select>
                                
                                </div>
                            </div>
                            <div class="erp-filter-item flex-100 mt-3">
                                <div class="erp-offcanvas-search-box">
                                    <button class="erp-off-search-btn" onclick="getFilteredData()"><span class="me-2"><i class="fa-solid fa-magnifying-glass"></i></span>Search</button>
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
    @include('hr.employee._change_role')
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
            keyword_filtered: '',
            department_id: [],
            designation_id: [],
        };
        $(document).ready(function() {
            getData();

            filterData.keyword_filtered = $("#keyword_filtered").val()
            $("#keyword_filtered").on('input', function () {
                filterData.keyword_filtered = $(this).val();
            });

            $("#designationStoreForm").on('submit', function (e) {
                var self = this;
                e.preventDefault();
                var formData = new FormData($(self)[0]);
                $(".ie-span").text("").hide();
                var url = $(self).attr('action');

                formPost(url, formData, function (res) {
                    if (res.status == 200) {
                        $("#add_designation_modal").modal('hide');
                        $(self)[0].reset();
                        showSuccessAlert('Success', res.message)
                        getData();
                    } else {
                        showErrorAlert('Error', res.message)
                    }
                }, 'show_input_error');
            });

            $(document).on("submit", "#changeRoleUpdateForm", function(e) {
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                $(".ie-span").text("").hide();
                var url = $(this).attr('action');

                formPost(url, formData, function (res){
                    if(res.status == 200){
                        $("#editRoleModal").modal('hide');
                        showSuccessAlert('Success',res.message)
                        getData();
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');
            });
        });

        function getDesignation(select) {
            var department_id = $(select).val();
            filterData.department_id = department_id;
            let url = "{{ route('ajax.get-designation-by-multiple-departments') }}";
            if(department_id.length > 0){
                ajaxGet(url, {department_id:department_id}, function (response) {
                    if (response.status == 200) {
                        $("#designation_id").html(response.view);
                    } else {
                        $("#designation_id").html('');
                        toastr.error(response.message);
                    }
                });
            }else{
                // $("#designation_id").html('<option value="">Select Department First</option>');
                $("#designation_id").html('');
                return;
            }
        }

        function designationFilter(select) {
            filterData.designation_id = $(select).val();
        }

        function getData(){
            getPaginatedListData("{{ route('hr.employee.filtered') }}", "#ajax-data-load", filterData);
        }

        function getFilteredData(){
            console.log(1)
            $('.offcanvas').offcanvas('hide');
            getData();
        }

        function getPaginatedData(button) {
            getPaginatedListData($(button).attr('data-href'), "#ajax-data-load", filterData);
        }

        function editRole(id){
            let url = "{{route('hr.employee.edit-role', ':id')}}";
            url = url.replace(':id', id);
            ajaxGet(url, {}, function (response) {
                if (response.status == 200) {
                    $("#edit_role_modal_body").html(response.view);
                    $("#editRoleModal").modal('show');
                    initializeSelect()
                } else {
                    toastr.error(response.message);
                }
            }, 'default');
        }

        function initializeSelect() {
            $('.select2').select2({
                minimumResultsForSearch: -1,
                width: '100%'
            });
        }

    </script>
@endsection


